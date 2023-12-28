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
use Stageo\Lib\HTTP\Session;
use Stageo\Lib\Mailer;
use Stageo\Lib\Response;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\DistributionCommune;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Offre;
use Stageo\Model\Object\StatutJuridique;
use Stageo\Model\Object\Suivi;
use Stageo\Model\Object\TailleEntreprise;
use Stageo\Model\Object\TypeStructure;
use Stageo\Model\Repository\CategorieRepository;
use Stageo\Model\Repository\ConventionRepository;
use Stageo\Model\Repository\DeCategorieRepository;
use Stageo\Model\Repository\DistributionCommuneRepository;
use Stageo\Model\Repository\EnseignantRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\StatutJuridiqueRepository;
use Stageo\Model\Repository\SuiviRepository;
use Stageo\Model\Repository\tableTemporaireRepository;
use Stageo\Model\Repository\TailleEntrepriseRepository;
use Stageo\Model\Repository\TypeStructureRepository;
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

    public function a_propos(): Response
    {
        return new Response(
            template: "Propos.php"
        );
    }


    public function contact(): Response
    {
        return new Response(
            template: "Contact.php"
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
        FlashMessage::add("Importation réussie", FlashType::SUCCESS);
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
        /**
         * @var Convention $convention
         * @var Entreprise $entreprise
         * @var Etudiant $etudiant
         * @var Suivi $suivi
         * @var Enseignant $enseignant
         * @var DistributionCommune $commune_etudiant
         * @var DistributionCommune $commune_entreprise
         * @var StatutJuridique $statut_juridique
         * @var TypeStructure $type_structure
         * @var TailleEntreprise $taille_entreprise
         */
        foreach ((new ConventionRepository)->select() as $convention) {
            $suivi = (new SuiviRepository)->getByIdConvention($convention->getIdConvention());
            $etudiant = (new EtudiantRepository)->getByLogin($convention->getLogin());
            $commune_etudiant = (new DistributionCommuneRepository)->getById($etudiant->getIdDistributionCommune());
            $entreprise = (new EntrepriseRepository)->getById($convention->getIdEntreprise());
            $commune_entreprise = (new DistributionCommuneRepository)->getById($entreprise->getIdDistributionCommune());
            $statut_juridique = (new StatutJuridiqueRepository)->getStatutJuridiqueById($entreprise->getIdStatutJuridique());
            $type_structure = (new TypeStructureRepository)->getTypeStructureById($entreprise->getIdTypeStructure());
            $taille_entreprise = (new TailleEntrepriseRepository)->getTailleEntrepriseById($entreprise->getIdTailleEntreprise());
            $enseignant = (new EnseignantRepository)->getByLogin($convention->getLoginEnseignant());
            $data[] = [
                "Numéro de Convention" => $convention->getIdConvention(),
                "Numéro étudiant" => null,
                "Nom étudiant" => $etudiant->getNom(),
                "Prénom étudiant" => $etudiant->getPrenom(),
                "Télephone Perso étudiant" => $etudiant->getTelephoneFixe(),
                "Télephone Portable étudiant" => $etudiant->getTelephone(),
                "Mail Perso étudiant" => $etudiant->getEmail(),
                "Mail Universitaire étudiant" => $etudiant->getEmailEtudiant(),
                "Code UFR" => null,
                "Libellé UFR" => null,
                "Code département" => null,
                "Code étape" => null,
                "Libellé Etape" => null,
                "Date Début Stage" => $convention->getDateDebut(),
                "Date Fin Stage" => $convention->getDateFin(),
                "Interruption" => null,
                "Date Début Interruption" => null,
                "Date Fin Interruption" => null,
                "Thématique" => $convention->getThematique(),
                "Sujet" => $convention->getSujet(),
                "Fonctions et Tâches" => $convention->getTaches(),
                "Détail du Projet" => $convention->getDetails(),
                "Durée du Stage" => $convention->getHeuresTotal(),
                "Nb de jours de travail" => $convention->getJoursHebdomadaire(),
                "Nombre d'heures hebdomadaire" => $convention->getHeuresHebdomadaire(),
                "Gratification" => $convention->getGratification(),
                "Unité Gratification" => null,
                "Unité Durée Gratification" => "heure",
                "Convention Validée" => $suivi->getValide(),
                "Nom Enseignant Référent" => $enseignant?->getNom(),
                "Prénom Enseignant Référent" => $enseignant?->getPrenom(),
                "Mail Enseignant Référent" => $enseignant?->getEmail(),
                "Nom Signataire" => null,
                "Prénom Signataire" => null,
                "Mail Signataire" => null,
                "Fonction Signataire" => null,
                "Année Universitaire" => $convention->getAnneeUniversitaire(),
                "Type de Convention" => $convention->getTypeConvention(),
                "Commentaire Stage" => $convention->getCommentaires(),
                "Commentaire Durée Travail" => $convention->getCommentairesDuree(),
                "Code ELP" => null,
                "Elément pédagogique" => null,
                "Code sexe étudiant" => $etudiant->getCivilite(),
                "Avantages nature" => $convention->getAvantagesNature(),
                "Adresse étudiant" => $etudiant->getNumeroVoie(),
                "Code postal étudiant" => $commune_etudiant->getCodePostal(),
                "Pays étudiant" => "France",
                "Ville étudiant" => $commune_etudiant->getCommune(),
                "Convention Validée Pédagogiquement" => $suivi->getValidePedagogiquement(),
                "Avenant(s) à la convention" => null,
                "Détails Avenant(s)" => null,
                "Date de création la convention" => $suivi->getDateCreation(),
                "Date de modification de la convention" => $suivi->getDateModification(),
                "Origine stage" => $convention->getOrigineStage(),
                "Nom Etablissement d'accueil" => $entreprise->getRaisonSociale(),
                "Siret" => $entreprise->getSiret(),
                "Adresse Résidence" => null,
                "Adresse Voie" => $entreprise->getNumeroVoie(),
                "Adresse lib cedex" => null,
                "Code Postal" => $commune_entreprise->getCodePostal(),
                "Etablissement d'accueil" => null,
                "Pays" => null,
                "Statut Juridique" => $statut_juridique->getLibelle(),
                "Type structure" => $type_structure->getLibelle(),
                "Effectif" => $taille_entreprise->getLibelle(),
                "Code NAF" => $entreprise->getCodeNaf(),
                "Téléphone" => $entreprise->getTelephone(),
                "Fax" => $entreprise->getFax(),
                "Mail" => $entreprise->getEmail(),
                "SiteWeb" => $entreprise->getSite(),
                "Service d'accueil - Nom" => null,
                "Service d'accueil - Résidence" => null,
                "Service d'accueil - Voie" => null,
                "Service d'accueil - Cedex" => null,
                "Service d'accueil - Code Postal" => null,
                "Service d'accueil - Commune" => null,
                "Service d'accueil - Pays" => null,
                "Nom Tuteur Professionnel" => null,
                "Prénom Tuteur Professionnel" => null,
                "Mail Tuteur Professionnel" => null,
                "Téléphone Tuteur Professionnel" => null,
                "Fonction Tuteur Professionnel" => null
            ];
        }
        $file = fopen("export.csv", "a");
        ftruncate($file, 0);
        fputcsv($file, array_keys($data[0]));
        foreach ($data as $row) fputcsv($file, $row);
        fclose($file);

        FlashMessage::add("Exportation des conventions effectuée", FlashType::SUCCESS);
        return new Response(
            action: Action::HOME,
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