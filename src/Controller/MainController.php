<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Cookie;
use Stageo\Lib\UserConnection;
use Stageo\Model\Repository\CategorieRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MainController extends CoreController
{
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function home(): Response
    {
        return new Response(
            template: "home.php",
            params: [
                "title" => "Home",
                "categories" => (new CategorieRepository)->select()
            ]
        );
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function about(): Response
    {
        return new Response(
            template: "about.php"
        );
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function faq(): Response
    {
        return new Response(
            template: "faq.php"
        );
    }

    /**
     * @throws ControllerException
     */
    public function signOut(): Response
    {
        if (!UserConnection::isSignedIn())
            throw new ControllerException(
                message: "Aucun utilisateur n'est connecté"
            );
        UserConnection::signOut();
        FlashMessage::add(
            content: "Vous avez été déconnecté",
            type: FlashType::INFO
        );
        return new Response(
            action: Action::HOME
        );
    }

    public static function error(): Response
    {
        return new Response(
            template: "error.php",
            params: [
                "title" => "Error",
                "message" => Cookie::get("error")
            ]
        );
    }
}