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
use Stageo\Model\Repository\DeCategorieRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\UniteGratificationRepository;
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
        $search = $_REQUEST["search"] ?? "";
        $option = $_POST["OptionL"] ?? "description";
        $tabla = $option === "description"
            ? "description"
            : "secteur";
      /*  $offres = isset($search)
            ? (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%".$search."%"))
            : (new OffreRepository)->select();*/

        if (isset($search)){
            if ($option == "Categories"){
               $categories =  (new CategorieRepository()) ->select(new QueryCondition("libelle",ComparisonOperator::LIKE,"%".$search."%"));
               $idOffres =  [];
               foreach ($categories as $category) {
                  $idOffres [] =  (new DeCategorieRepository())->getByIdCategorie($category->getIdCategorie());
               }
               foreach ($idOffres as $idOffre){
                  $offres [] =  (new OffreRepository)->getById($idOffre->getIdOffre());
               }
            }else {
                $offres = (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%".$search."%"));
            }
        }else{
            $offres = (new OffreRepository)->select();
        }
        $selA = $option === "description"
            ? "selected"
            : null;
        $selB = $option === "secteur"
            ? "selected"
            : null;
        $selC = $option === "Categories"
            ? "selected"
            : null;
        return new Response(
            template: "entreprise/offre/liste-offre.php",
            params: [
                "title" => "Liste des offres",
                "offres" => $offres,
                "selA" => $selA,
                "selB" => $selB,
                "selC" => $selC,
                "search" => $search
            ]
        );
    }

    public function afficherOffre(string $id): Response
    {
        /**
         * @var Offre $offre
         */
        $offre = (new OffreRepository)->getById($id);
        return new Response(
            template: "entreprise/offre/offre.php",
            params: [
                "title" => "Offre $id",
                "entreprise" => (new EntrepriseRepository)->getById($offre->getIdEntreprise()),
                "offre" => $offre,
                "unite_gratification" => (new UniteGratificationRepository)->getById($offre->getIdUniteGratification())->getLibelle()
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