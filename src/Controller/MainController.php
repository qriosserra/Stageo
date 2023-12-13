<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Lib\Email;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Cookie;
use Stageo\Lib\Mailer;
use Stageo\Lib\Response;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Offre;
use Stageo\Model\Repository\CategorieRepository;
use Stageo\Model\Repository\ConventionRepository;
use Stageo\Model\Repository\DeCategorieRepository;
use Stageo\Model\Repository\DistributionCommuneRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\tableTemporaireRepository;
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
        FlashMessage::add(
            content: "Bienvenue sur Stageo",
            type: FlashType::SUCCESS
        );

        return new Response(
            template: "home.php",
            params: [
                "title" => "Accueil"
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
            $idOffres =  [];
            $Togle = [
                isset($_REQUEST['toggle']["Alternances"]) ? "oui" : "non",
                isset($_REQUEST['toggle']["Stages"]) ? "oui" : "non",
            ];

            if (isset($_REQUEST['categoriesSelectionnees'])){
                $categoriesSelect = $_REQUEST['categoriesSelectionnees'];
            }
            if (isset($search)){
                if ($option == "Categories"){
                    $categories =  (new CategorieRepository()) ->select(new QueryCondition("libelle",ComparisonOperator::LIKE,"%".$search."%"));
                    foreach ($categories as $category) {
                        $idOffres [] =  (new DeCategorieRepository())->getByIdCategorie($category->getIdCategorie());
                        var_dump($idOffres);
                    }
                    foreach ($idOffres as $idOffre){
                        $offres [] =  (new OffreRepository)->getById($idOffre->getIdOffre());
                        //$offres [] =  (new OffreRepository)->select(new QueryCondition("id_offre",ComparisonOperator::EQUAL,"%".$idOffre->getIdOffre()."%"));
                    }
                }else {
                    if (isset($categoriesSelect)){
                        //$categories = [];
                        //$res = (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%" . $search . "%"));
                        $res = (new OffreRepository)->getByTextAndLocalisation($search,$commune,$Togle);
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
                                        $idOffres [] = $resu->getIdOffre();
                                    }
                                }
                            }
                        }
                    }else {
                        //$offres = (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%" . $search . "%"));
                        $offres =  (new OffreRepository)->getByTextAndLocalisation($search,$commune,$Togle);
                        foreach ($offres as $o){
                            $idOffres [] = $o->getIdOffre();
                        }
                    }
                }
            }else{
                $offres = (new OffreRepository)->select(new QueryCondition("valider", ComparisonOperator::EQUAL, 1));
                $idOffres = (new OffreRepository())->getAllValideOffreId();
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
            $listeoffres = (new OffreRepository())->getOffresDetailsAvecCategories();
            $Categories = (new CategorieRepository()) ->select();
            return new Response(
                template: "entreprise/offre/liste-offre.php",
                params: [
                    "title" => "Liste des offres",
                    "offres" => $offres,
                    "listeoffres" => $listeoffres,
                    "idOffres" => $idOffres,
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
            $entreprise = (new EntrepriseRepository())->getById($offre->getIdEntreprise());
            if ($entreprise instanceof Entreprise){
                $nomentreprise = $entreprise->getRaisonSociale();
            }else{
                $nomentreprise = "EREUR lors de la recherche de l'entreprise !";
            }
            return new Response(
                template: "entreprise/offre/offre.php",
                params: [
                    "title" => "Offre $id",
                    "entreprise" => (new EntrepriseRepository)->getById($offre->getIdEntreprise()),
                    "offre" => $offre,
                    "nomentreprise" => $nomentreprise,
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

    public function importCsvForm() : Response
    {
        return new Response(
            template: "csvForm.php",
            params: [
                "title" => "Importation depuis CSV"
            ]
        );
    }

    public function importCsv() : Response
    {
        $cheminCSV = $_FILES['CHEMINCSV'];
        if ($cheminCSV["size"]!=0){
            $csvContent = file_get_contents($cheminCSV['tmp_name']);
            (new tableTemporaireRepository())->insertViaCSV($csvContent);
        }
        return new Response(
            template: "home.php",
            params: [
                "title" => "Accueil",
                "categories" => (new CategorieRepository)->select(),
                "offres" => (new OffreRepository())->select()
            ]
        );
    }

    public function exportCsv() : Response
    {
        foreach ((new ConventionRepository)->select() as $convention) {
            $entreprise = (new EntrepriseRepository)->getById($convention->getIdEntreprise());
            $etudiant = (new EtudiantRepository)->getById($convention->getIdEtudiant());
            $export[] = [
                "id_convention" => $convention->getIdConvention(),
                "id_etudiant" => $convention->getIdEtudiant(),
                "id_entreprise" => $convention->getIdEntreprise(),
                "id_offre" => $convention->getIdOffre(),
                "date_debut" => $convention->getDateDebut(),
                "date_fin" => $convention->getDateFin(),
                "date_signature" => $convention->getDateSignature(),
                "date_debut_stage" => $convention->getDateDebutStage(),
            ];
        }
        $offres = (new OffreRepository())->select();
        $csv = (new OffreRepository())->exportToCsv($offres);
        return new Response(
            template: "home.php",
            params: [
                "title" => "Accueil",
                "categories" => (new CategorieRepository)->select(),
                "offres" => (new OffreRepository())->select()
            ]
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