<?php

namespace Stageo\Controller;

use Exception;
use LogicException;
use RuntimeException;
use Dotenv\Dotenv;
use Stageo\Controller\Exception\ControllerException;
use Stageo\Lib\Container;
use Stageo\Lib\enums\Pattern;
use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Cookie;
use Stageo\Lib\HTTP\Session;
use Stageo\Lib\UserConnection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Router
{

    /**
     * @return void
     *
     * @throws NoConfigurationException  If no routing configuration could be found
     * @throws ResourceNotFoundException If the resource could not be found
     * @throws MethodNotAllowedException If the resource was found but the request method is not allowed
     * @throws LogicException If a controller was found based on the request, but it is not callable
     * @throws RuntimeException When no value could be provided for a required argument
     */
    public static function processRequest(): void
    {
        try {
            $response = self::callUserFunction();
        } catch (MethodNotAllowedException $exception) {
            $response = CoreController::handleControllerException(
                exception: new ControllerException(
                    message: $exception->getMessage(),
                    statusCode: StatusCode::METHOD_NOT_ALLOWED
                )
            );
        } catch (ResourceNotFoundException $exception) {
            $response = CoreController::handleControllerException(
                exception: new ControllerException(
                    message: $exception->getMessage(),
                    statusCode: StatusCode::NOT_FOUND
                )
            );
        } catch (Exception $exception) {
            $response = CoreController::handleControllerException(
                exception: new ControllerException(
                    message: $exception->getMessage(),
                    statusCode: StatusCode::INTERNAL_SERVER_ERROR
                )
            );
        }
        $response->send();
    }

    /**
     * @throws Exception
     */
    public static function callUserFunction(): Response
    {
        $dir = __DIR__;
        $dotEnv = Dotenv::createImmutable("$dir/../..");
        $dotEnv->load();

        $idUser = UserConnection::getSignedInUser();
        $twigLoader = new FilesystemLoader("$dir/../templates/");
        $twig = new Environment($twigLoader, [
            "autoescape" => "html",
            "strict_variables" => true,
            "debug" => $_ENV["DEBUG"],
            "cache" => false
        ]);

        $request = Request::createFromGlobals();
        $requestContext = (new RequestContext())->fromRequest($request);
        $routes = self::getRoutesCollection();

        $urlHelper = new UrlHelper(new RequestStack(), $requestContext);
        Container::addService("urlHelper", $urlHelper);
        $twig->addFunction(new TwigFunction("asset", [$urlHelper, "getAbsoluteUrl"]));

        $urlGenerator = new UrlGenerator($routes, $requestContext);
        Container::addService("urlGenerator", $urlGenerator);
        $twig->addFunction(new TwigFunction("route", [$urlGenerator, "generate"]));

        //Passages de functions & variables globales aux templates Twig
        $twig->addFunction(new TwigFunction("cookie", [Cookie::class, "get"]));
        $twig->addFunction(new TwigFunction("session", [Session::class, "get"]));
        $twig->addFunction(new TwigFunction("isUserInstance", [UserConnection::class, "isInstance"]));
        $twig->addGlobal("idUser", $idUser);
        $twig->addGlobal("flashMessages", FlashMessage::read());
        $twig->addGlobal("pattern", Pattern::toArray());
        $twig->addGlobal("absoluteURL", $_ENV["ABSOLUTE_URL"]);
        $twig->addExtension(new DebugExtension);
        Container::addService("twig", $twig);

        $urlMatcher = new UrlMatcher($routes, $requestContext);
        $routesData = $urlMatcher->match($request->getPathInfo());

        $request->attributes->add($routesData);
        $controller = (new ControllerResolver())->getController($request);
        $arguments = (new ArgumentResolver())->getArguments($request, $controller);

        return CoreController::handleControllerResponse(
            controllerResponse: call_user_func_array($controller, $arguments)
        );
    }

    private static function getRoutesCollection(): RouteCollection
    {
        $routes = [
            [
                "name" => RouteName::HOME,
                "route" => new Route(
                    path: "/",
                    defaults: ["_controller" => [MainController::class, "home"]]
                )
            ],
            [
                "name" => RouteName::ABOUT,
                "route" => new Route(
                    path: "/about",
                    defaults: ["_controller" => [MainController::class, "about"]]
                )
            ],
            [
                "name" => RouteName::FAQ,
                "route" => new Route(
                    path: "/faq",
                    defaults: ["_controller" => [MainController::class, "faq"]]
                )
            ],
            [
                "name" => RouteName::CONTACT_FORM,
                "route" => new Route(
                    path: "/contact",
                    defaults: ["_controller" => [MainController::class, "contactForm"]],
                    methods: "GET"
                )
            ],
            [
                "name" => RouteName::CONTACT,
                "route" => new Route(
                    path: "/contact",
                    defaults: ["_controller" => [MainController::class, "contact"]],
                    methods: "POST"
                )
            ],
            [
                "name" => RouteName::ERROR,
                "route" => new Route(
                    path: "/error/{statusCode}",
                    defaults: ["_controller" => [CoreController::class, "error"]]
                )
            ],
            [
                "name" => RouteName::ETUDIANT_SIGN_UP_FORM,
                "route" => new Route(
                    path: "/etudiant/sign-up/{login?}",
                    defaults: ["_controller" => [EtudiantController::class, "signUpForm"]],
                    methods: "GET"
                )
            ],
            [
                "name" => RouteName::ETUDIANT_SIGN_UP,
                "route" => new Route(
                    path: "/etudiant/sign-up",
                    defaults: ["_controller" => [EtudiantController::class, "signUp"]],
                    methods: "POST"
                )
            ],
            [
                "name" => RouteName::SIGN_OUT,
                "route" => new Route(
                    path: "/sign-out",
                    defaults: ["_controller" => [EtudiantController::class, "signOut"]]
                )
            ],
            [
                "name" => RouteName::ETUDIANT_SIGN_IN_FORM,
                "route" => new Route(
                    path: "/etudiant/sign-in/{login?}",
                    defaults: ["_controller" => [EtudiantController::class, "signInForm"]],
                    methods: "GET"
                )
            ],
            [
                "name" => RouteName::ETUDIANT_SIGN_IN,
                "route" => new Route(
                    path: "/etudiant/sign-in",
                    defaults: ["_controller" => [EtudiantController::class, "signIn"]],
                    methods: "POST"
                )
            ],
            [
                "name" => RouteName::ADMIN_DASHBOARD,
                "route" => new Route(
                    path: "/admin/dashboard",
                    defaults: ["_controller" => [AdminController::class, "dashboard"]]
                )
            ],
            [
                "name" => RouteName::ENTREPRISE_ADD_FORM,
                "route" => new Route(
                    path: "/entreprise/add/{email?}",
                    defaults: ["_controller" => [EntrepriseController::class, "addForm"]],
                    methods: "GET"
                )
            ],
            [
                "name" => RouteName::ENTREPRISE_ADD,
                "route" => new Route(
                    path: "/entreprise/add",
                    defaults: ["_controller" => [EntrepriseController::class, "add"]],
                    methods: "POST"
                )
            ]
        ];
        $routeCollection = new RouteCollection();
        foreach ($routes as $route) {
            $routeCollection->add($route["name"]->value, $route["route"]);
        }
        return $routeCollection;
    }
}