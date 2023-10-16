<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Cookie;
use Stageo\Lib\Response;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Offre;
use Stageo\Model\Repository\CategorieRepository;
use Stageo\Model\Repository\OffreRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MainController
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
                "categories" => (new CategorieRepository)->select(),
                "offres" => (new OffreRepository())->select()
            ]
        );
    }

    public function listeOffre(): Response
    {
        $cherche = $_POST['searchInput'];
        $opt = (strlen($_POST['OptionL']) == 0) ? "description" : $_POST['OptionL'] ;
        $tabla = ($opt == "description") ? "description" : "secteur";
        $offres  = (strlen($cherche) == 0) ? (new OffreRepository())->select() : (new OffreRepository())->select( new QueryCondition(
            column: $tabla,
            comparisonOperator: ComparisonOperator::LIKE,
            value: "%".$cherche."%"
        ));
        $selA = ($_POST['OptionL'] == "description") ? "selected" : "";
        $selB = ($_POST['OptionL'] == "secteur") ? "selected" : "";
        return new Response(
            template: "listeOffre.php",
            params: [
                "title" => "Home",
                "offres" =>$offres,
                "selA" => $selA,
                "selB" => $selB,
                "cherche" =>$cherche
            ]
        );
    }

    public function afficherOffre(): Response
    {
        $offre  = (new OffreRepository())->select( new QueryCondition(
            column: "id_offre",
            comparisonOperator: ComparisonOperator::EQUAL,
            value: $_REQUEST['offre']
        ));
        return new Response(
            template: "afficherOffre.php",
            params: [
                "title" => "afficherOffre",
                "offre" =>$offre[0],
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