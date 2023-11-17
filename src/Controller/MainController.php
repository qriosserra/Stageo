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
use Stageo\Model\Repository\DistributionCommuneRepository;
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
                "title" => "Accueil",
                "categories" => (new CategorieRepository)->select(),
                "offres" => (new OffreRepository())->select()
            ]
        );
    }

    public function listeOffre(): Response
    {
        if (UserConnection::isSignedIn()) {
        $search = $_REQUEST["search"] ?? "";
        $commune = $_REQUEST["Commune"] ?? "";
        $option = $_POST["OptionL"] ?? "description";
        $tabla = $option === "description"
            ? "description"
            : "secteur";
        $offres = [];
      /*  $offres = isset($search)
            ? (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%".$search."%"))
            : (new OffreRepository)->select();*/
        if (isset($_REQUEST['categoriesSelectionnees'])){
            $categoriesSelect = $_REQUEST['categoriesSelectionnees'];
        }
        if (isset($search)){
            if ($option == "Categories"){
               $categories =  (new CategorieRepository()) ->select(new QueryCondition("libelle",ComparisonOperator::LIKE,"%".$search."%"));
               $idOffres =  [];
               foreach ($categories as $category) {
                  $idOffres [] =  (new DeCategorieRepository())->getByIdCategorie($category->getIdCategorie());
               }
               foreach ($idOffres as $idOffre){
                  $offres [] =  (new OffreRepository)->getById($idOffre->getIdOffre());
                  //$offres [] =  (new OffreRepository)->select(new QueryCondition("id_offre",ComparisonOperator::EQUAL,"%".$idOffre->getIdOffre()."%"));
               }
            }else {
                if (isset($categoriesSelect)){
                    //$categories = [];
                    //$res = (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%" . $search . "%"));
                    $res = (new OffreRepository)->getByTextAndLocalisation($search,$commune);
                    $cate = [];
                    foreach ($categoriesSelect as $category) {
                        //$cate [] = (new CategorieRepository())->select(new QueryCondition("libelle", ComparisonOperator::LIKE, "%" . $category . "%"));
                        $cate [] = (new CategorieRepository())->getByLibelle($category);
                    }
                    /*foreach ($cate as  $category){
                        //$categories [] =  (new DeCategorieRepository()) ->select(new QueryCondition("id_categorie",ComparisonOperator::EQUAL,"%".$category."%"));
                        $categories [] = (new DeCategorieRepository())->getByIdCategorie($category);
                    }*/
                    $categories = (new DeCategorieRepository())->getByIdCategorieliste($cate);
                    foreach ($res as $resu) {
                        foreach ($categories as $category) {
                            if ($category !=null) {
                                if ($resu->getIdOffre() == $category && !in_array($resu,$offres)) {
                                    $offres [] = $resu;
                                }
                            }
                        }
                    }
                }else {
                    //$offres = (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%" . $search . "%"));
                    (new OffreRepository)->getByTextAndLocalisation($search,$commune);
                }
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
        $Categories = (new CategorieRepository()) ->select();
        return new Response(
            template: "entreprise/offre/liste-offre.php",
            params: [
                "title" => "Liste des offres",
                "offres" => $offres,
                "selA" => $selA,
                "selB" => $selB,
                "selC" => $selC,
                "Categories" => $Categories,
                "nbRechercheTrouver" => count($offres),
                "communeTaper" => $commune,
                "search" => $search
            ]
        );}
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    public function afficherOffre(string $id): Response
    {
        if (UserConnection::isSignedIn()) {
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
        );}
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
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