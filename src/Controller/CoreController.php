<?php

namespace Stageo\Controller;

use Exception;
use Stageo\Controller\Exception\ControllerException;
use Stageo\Lib\Container;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;
use Stageo\Model\Repository\CoreRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class CoreController
{
    protected static function renderTwigView(string     $path,
                                             StatusCode $statusCode = StatusCode::OK,
                                             array      $params = []): Response
    {
        /** @var Environment $twig */
        $twig = Container::getService("twig");
        return (new Response($twig->render($path, $params)))->setStatusCode($statusCode->value);
    }

    public static function redirect(RouteName  $route,
                                    StatusCode $statusCode = StatusCode::OK,
                                    array      $params = []): RedirectResponse
    {
//        if ($route === RouteName::RELOAD_PAGE);
//        elseif ($route === RouteName::PREVIOUS_PAGE);

        /* @var UrlGenerator $generator */
        $generator = Container::getService("urlGenerator");
        $url = $generator->generate(
            name: $route->value,
            parameters: $params
        );
        header("Location: $url");
        return (new RedirectResponse($url))->setStatusCode($statusCode->value);
//        exit();
    }

    /**
     * @throws Exception
     */
    public static function handleControllerResponse(ControllerResponse $controllerResponse): Response
    {
        if (!is_null($controllerResponse->getTemplate()))
            return self::renderTwigView(
                path: $controllerResponse->getTemplate(),
                params: $controllerResponse->getParams()
            )->setStatusCode($controllerResponse->getStatusCode()->value);
        elseif (!is_null($controllerResponse->getRedirection()))
            return self::redirect(
                route: $controllerResponse->getRedirection(),
                statusCode: $controllerResponse->getStatusCode(),
                params: $controllerResponse->getParams()
            );
        else throw new Exception(
            message: "Path and RouteName are null"
        );
    }

    public static function handleControllerException(ControllerException $exception): Response
    {
        FlashMessage::add(
            content: $exception->getMessage(),
            type: $exception->getFlashType()
        );
//        if ($exception->getRedirection() == RouteName::ERROR)
//            return self::error(
//                message: $exception->getMessage(),
//                statusCode: $exception->getStatusCode()
//            );
        return self::redirect(
            route: $exception->getRedirection(),
            statusCode: $exception->getStatusCode(),
            params: $exception->getParams()
        );
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public static function error(string            $message = "",
                                 StatusCode|string $statusCode = StatusCode::BAD_REQUEST): ControllerResponse
    {
        return new ControllerResponse(
            template: "error.html.twig",
            statusCode: is_string($statusCode) ? StatusCode::from($statusCode) : $statusCode,
            params: [
                "statusCode" => is_string($statusCode) ? $statusCode : $statusCode->value,
                "message" => $message
            ]
        );
    }
}