<?php

namespace Stageo\Lib;

use JetBrains\PhpStorm\NoReturn;
use ReflectionMethod;
use Stageo\Lib\enums\Action;
use Stageo\Controller\Exception\ControllerException;
use Stageo\Lib\enums\Pattern;
use Stageo\Lib\HTTP\Cookie;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;

class Request
{
    public function process(string $controller, string $action, array $params): void
    {
        $class = "Stageo\\Controller\\" . ucfirst(strtolower($controller)) . "Controller";
        try {
            EnvLoader::load(__DIR__ . "/../..");
            if (!class_exists($class))
                throw new ControllerException("La classe {$class} n'existe pas");
            $instance = new $class();
            if (!method_exists($instance, $action))
                throw new ControllerException("L'action {$action} n'existe pas dans {$class}");
            $reflection = new ReflectionMethod($instance, $action);
            foreach ($reflection->getParameters() as $parameter)
                if (isset($params[$parameter->getName()]))
                    $actionParams[] = $params[$parameter->getName()];
                elseif (!$parameter->isOptional())
                    throw new ControllerException("Le paramètre {$parameter->getName()} est manquant dans $class->$action");
            self::handleResponse($reflection->invokeArgs($instance, $actionParams ?? []));
        }
        catch (ControllerException $exception) {
            self::handleControllerException($exception);
        }
    }

    private static function render(string $template, array $params): void
    {
        $params = array_merge($params, [
            "template" => $template,
            "nav" => $params["nav"] ?? true,
            "footer" => $params["footer"] ?? true,
            "flashMessages" => FlashMessage::read(),
            "absolute_url" => $_ENV["ABSOLUTE_URL"],
            "user" => UserConnection::getSignedInUser(),
            "etudiant" => new Etudiant(),
            "entreprise" => new Entreprise(),
            "pattern" => Pattern::toArray()
        ]);
        extract($params);
        require __DIR__ . "/../templates/layout.php";
    }

    #[NoReturn] private static function redirect(Action $action, array $params): void
    {
        $url = $_ENV["ABSOLUTE_URL"] . $action->value;
        if (!empty($params)) $url .= "&" . http_build_query($params);
        header("Location: $url");
        exit();
    }

    /**
     * @throws ControllerException
     */
    public function handleResponse(Response $response): void
    {
        if (!is_null($response->getTemplate()))
            self::render(
                template: $response->getTemplate(),
                params: $response->getParams()
            );
        elseif (!is_null($response->getAction()))
            self::redirect(
                action: $response->getAction(),
                params: $response->getParams()
            );
        else
            throw new ControllerException(
                message: "controllerResponse ne contient ni template ni action",
                action: Action::ERROR
            );
    }

    #[NoReturn] public static function handleControllerException(ControllerException $exception): void
    {
        if ($exception->getAction() === Action::ERROR)
            Cookie::set(
                key: "error",
                value: $exception->getMessage()
            );
        else
            FlashMessage::add(
                content: $exception->getMessage(),
                type: $exception->getFlashType()
            );
        self::redirect(
            action: $exception->getAction(),
            params: $exception->getParams()
        );
    }
}