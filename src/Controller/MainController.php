<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Lib\Mailer\Email;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Cookie;
use Stageo\Lib\HTTP\Session;
use Stageo\Lib\Mailer\Mailer;
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

    /**
     * Méthode de contrôleur représentant la gestion de la liste des offres dans l'application.
     * Si l'utilisateur est connecté, la méthode traite les paramètres de recherche, effectue des requêtes SQL
     * pour récupérer les offres correspondantes, et renvoie une réponse avec les données à afficher.
     *
     * @throws ControllerException Si l'utilisateur n'est pas connecté, une exception est levée redirigeant vers la page d'accueil.
     *
     * @return Response Réponse à renvoyer au client, généralement une page web affichant la liste des offres.
     *
     * @var string $search Représente le terme de recherche saisi par l'utilisateur.
     * @var string $commune Représente la commune spécifiée dans la recherche.
     * @var array $Togle Tableau indiquant les types d'offres à inclure dans la recherche (Alternances, Stages).
     * @var array $categoriesSelect Tableau des catégories sélectionnées dans la recherche.
     * @var array $offres Tableau contenant les offres résultant de la recherche.
     * @var array $idOffres Tableau contenant les identifiants des offres résultant de la recherche.
     * @var array $listeoffres Tableau contenant les détails des offres avec leurs catégories associées.
     * @var array $Categories Tableau contenant toutes les catégories disponibles.
     * @var int $nbRechercheTrouver Nombre d'offres trouvées suite à la recherche.
     * @var string $communeTaper Représente la commune spécifiée dans la recherche (à afficher dans l'interface).
     */
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

            if (isset($_REQUEST['categoriesSelectionnees'])) {
                $categoriesSelect = $_REQUEST['categoriesSelectionnees'];
            }
            if (isset($search)) {
                if ($option == "Categories") {
                    $categories =  (new CategorieRepository())->select(new QueryCondition("libelle", ComparisonOperator::LIKE, "%" . $search . "%"));
                    foreach ($categories as $category) {
                        $idOffres[] =  (new DeCategorieRepository())->getByIdCategorie($category->getIdCategorie());
                        var_dump($idOffres);
                    }
                    foreach ($idOffres as $idOffre) {
                        $offres[] =  (new OffreRepository)->getById($idOffre->getIdOffre());
                        //$offres [] =  (new OffreRepository)->select(new QueryCondition("id_offre",ComparisonOperator::EQUAL,"%".$idOffre->getIdOffre()."%"));
                    }
                } else {
                    if (isset($categoriesSelect)) {
                        //$categories = [];
                        //$res = (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%" . $search . "%"));
                        $res = (new OffreRepository)->getByTextAndLocalisation($search, $commune, $Togle);
                        $cate = [];
                        foreach ($categoriesSelect as $category) {
                            //$cate [] = (new CategorieRepository())->select(new QueryCondition("libelle", ComparisonOperator::LIKE, "%" . $category . "%"));
                            $cate[] = (new CategorieRepository())->getByLibelle($category);
                        }
                        /*foreach ($cate as  $category){
                            //$categories [] =  (new DeCategorieRepository()) ->select(new QueryCondition("id_categorie",ComparisonOperator::EQUAL,"%".$category."%"));
                            $categories [] = (new DeCategorieRepository())->getByIdCategorie($category);
                        }*/
                        $categories = (new DeCategorieRepository())->getByIdCategorieliste($cate);
                        foreach ($res as $resu) {
                            foreach ($categories as $category) {
                                if ($category != null) {
                                    if ($resu->getIdOffre() == $category && !in_array($resu, $offres)) {
                                        $offres[] = $resu;
                                        $idOffres[] = $resu->getIdOffre();
                                    }
                                }
                            }
                        }
                    } else {
                        //$offres = (new OffreRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%" . $search . "%"));
                        $offres =  (new OffreRepository)->getByTextAndLocalisation($search, $commune, $Togle);
                        foreach ($offres as $o) {
                            $idOffres[] = $o->getIdOffre();
                        }
                    }
                }
            } else {
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
            $Categories = (new CategorieRepository())->select();
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
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    /**
     * Méthode de contrôleur pour afficher la liste des entreprises dans l'application.
     * Si l'utilisateur est connecté, la méthode traite les paramètres de recherche, effectue des requêtes SQL
     * pour récupérer les entreprises correspondantes, et renvoie une réponse avec les données à afficher.
     *
     * @throws ControllerException Si l'utilisateur n'est pas connecté, une exception est levée redirigeant vers la page d'accueil.
     *
     * @return Response  une page web affichant la liste des entreprises.
     *
     * @var string $search Représente le terme de recherche saisi par l'utilisateur.
     * @var string $commune Représente la commune spécifiée dans la recherche.
     * @var string $option Représente l'option de recherche choisie par l'utilisateur (raison_sociale, communes).
     * @var array $entreprises Tableau d'objets Entreprise résultant de la recherche.
     * @var array $idEntreprises Tableau contenant les identifiants des entreprises résultant de la recherche.
     * @var string|null $selA Sélection pour l'option "raison_sociale" dans la liste déroulante.
     * @var string|null $selB Sélection pour l'option "communes" dans la liste déroulante.
     * @var array $listeEntreprises Tableau contenant les détails des entreprises.
     * @var array $Categories Tableau contenant toutes les catégories disponibles.
     * @var int $nbRechercheTrouver Nombre d'entreprises trouvées suite à la recherche.
     * @var string $communeTaper Représente la commune spécifiée dans la recherche (à afficher dans l'interface).
     */
    public function listeEntreprises(): Response
    {


        if (UserConnection::isSignedIn()) {
            $search = $_REQUEST["search"] ?? "";
            $commune = $_REQUEST["commune"] ?? "";
            $option = $_POST["OptionL"] ?? "raison_sociale";
            $tabla = $option === "raison_sociale"
                ? "raison_sociale"
                : "commune";
            $entreprises = [];
            $idEntreprises =  [];

            if (isset($search)) {
                if ($option == "commune") {
                    $entreprises = (new EntrepriseRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%" . $search . "%"));
                    foreach ($entreprises as $entreprise) {
                        $idEntreprises[] = $entreprise->getIdEntreprise();
                    }
                } else {
                    $entreprises = (new EntrepriseRepository)->select(new QueryCondition($tabla, ComparisonOperator::LIKE, "%" . $search . "%"));
                    foreach ($entreprises as $o) {
                        $idEntreprises[] = $o->getIdEntreprise();
                    }
                }
            } else {
                $entreprises = (new EntrepriseRepository)->select();
                $idEntreprises = (new EntrepriseRepository())->getAllEntrepriseId();
            }
            $selA = $option === "raison_sociale"
                ? "selected"
                : null;
            $selB = $option === "commune"
                ? "selected"
                : null;
            $listeEntreprises = (new EntrepriseRepository())->getEntrepriseDetails();
            $Categories = (new CategorieRepository())->select();
            return new Response(
                template: "entreprise/liste-entreprise.php",
                params: [
                    "title" => "Liste des entreprises",
                    "entreprises" => $entreprises,
                    "listeEntreprises" => $listeEntreprises,
                    "idEntreprises" => $idEntreprises,
                    "selA" => $selA,
                    "selB" => $selB,
                    "Categories" => $Categories,
                    "nbRechercheTrouver" => count($entreprises),
                    "communeTaper" => $commune,
                    "search" => $search
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    /**
     * Méthode de contrôleur pour afficher les détails d'une offre spécifiée par son identifiant.
     * Si l'utilisateur est connecté, la méthode récupère les informations de l'offre, de l'entreprise associée,
     * des catégories auxquelles l'offre est liée, et renvoie une réponse avec ces données pour affichage.
     *
     * @param string $id Identifiant de l'offre à afficher.
     *
     * @throws ControllerException Si l'utilisateur n'est pas connecté, une exception est levée redirigeant vers la page d'accueil.
     *
     * @return Response  une page web affichant les détails de l'offre.
     *
     * @var Offre $offre Représente l'objet Offre récupéré de la base de données.
     * @var Entreprise $entreprise Représente l'objet Entreprise associé à l'offre.
     * @var array $categorie Tableau d'objets DeCategorie représentant les liens entre l'offre et ses catégories.
     * @var array $nomCategory Tableau d'objets Categorie contenant les noms des catégories associées à l'offre.
     * @var string $nomentreprise Nom de l'entreprise associée à l'offre (ou un message d'erreur en cas d'échec de recherche).
     */
    public function afficherOffre(string $id): Response
    {

        if (UserConnection::isSignedIn()) {
            /**
             * @var Offre $offre
             */
            $offre = (new OffreRepository)->getById($id);
            $entreprise = (new EntrepriseRepository())->getById($offre->getIdEntreprise());
            $categorie = (new DeCategorieRepository())->getByIdOffreA($id);
            $nomCategory = [];
            foreach ($categorie as $category) {
                $idCategorie = $category->getIdCategorie();
                $nomCategory[] = (new CategorieRepository())->getById($idCategorie);
            }
            if ($entreprise instanceof Entreprise) {
                $nomentreprise = $entreprise->getRaisonSociale();
            } else {
                $nomentreprise = "EREUR lors de la recherche de l'entreprise !";
            }
            return new Response(
                template: "entreprise/offre/offre.php",
                params: [
                    "title" => "Offre $id",
                    "entreprise" => (new EntrepriseRepository)->getById($offre->getIdEntreprise()),
                    "offre" => $offre,
                    "nomentreprise" => $nomentreprise,
                    "unite_gratification" => (new UniteGratificationRepository)->getById($offre->getIdUniteGratification())->getLibelle(),
                    "nomCategory" => $nomCategory
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    /**
     * Méthode de contrôleur pour afficher les détails d'une entreprise spécifiée par son identifiant,
     * ainsi que la liste des offres associées à cette entreprise.
     * Si l'utilisateur est connecté, la méthode récupère les informations de l'entreprise et de ses offres,
     * puis renvoie une réponse avec ces données pour affichage.
     *
     * @param string $id Identifiant de l'entreprise à afficher.
     *
     * @throws ControllerException Si l'utilisateur n'est pas connecté, une exception est levée redirigeant vers la page d'accueil.
     *
     * @return Response une page web affichant ses offres et les détails de l'entreprise.
     *
     * @var Entreprise $entreprise Représente l'objet Entreprise récupéré de la base de données.
     * @var array $listeoffres Tableau d'objets Offre représentant les offres associées à l'entreprise.
     * @var int $nbRechercheTrouver Nombre d'offres trouvées associées à l'entreprise.
     */
    public function afficherEntreprise(string $id): Response
    {

        if (UserConnection::isSignedIn()) {
            /**
             * @var Entreprise $entreprise
             */
            $entreprise = (new EntrepriseRepository)->getEntrepriseDetailsById($id);
            $listeoffres = (new OffreRepository())->getOffresDetailsAvecCategoriesByIdEntreprise($id);
            return new Response(
                template: "entreprise/entreprise.php",
                params: [
                    "title" => "Entreprise $id",
                    "entreprise" => $entreprise[0],
                    "listeoffres" => $listeoffres,
                    "nbRechercheTrouver" => sizeof($listeoffres),
                ]
            );
        }
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
            template: "Propos.php",
            params: [
                "title" => "A propos"
            ]
        );
    }


    public function contact(): Response
    {
        $listeEmailadmin = (new EnseignantRepository())->getAllEmails();
        return new Response(
            template: "Contact.php",
            params: [
                "title" => "Contact",
                "listeEmailadmin" => $listeEmailadmin
            ]
        );
    }

    public function confidentialite(): Response
    {
        return new Response(
            template: "Confidentialite.php",
            params: [
                "title" => "Contact"
            ]
        );
    }


    public function importCsvForm(): Response
    {
        return new Response(
            template: "csvForm.php",
            params: [
                "title" => "Importation depuis CSV"
            ]
        );
    }

    /**
     * Méthode de contrôleur pour importer des données à partir d'un fichier CSV dans la table temporaire de la base de données,
     * puis d'appeller la procedure pour triée et ranger les valeurs.
     *
     * @return Response Réponse à renvoyer au client, généralement une redirection vers la page d'accueil.
     *
     * @var array $cheminCSV Informations sur le fichier CSV provenant des données de formulaire.
     * @var string $csvContent Contenu du fichier CSV récupéré à partir du chemin temporaire du fichier.
     */

    public function importCsv(): Response
    {

        $cheminCSV = $_FILES['CHEMINCSV'];
        if ($cheminCSV["size"] != 0) {
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

    /**
     * Méthode de contrôleur pour exporter les données des conventions vers un fichier CSV.
     * Les informations nécessaires sont extraites de la base de données, puis écrites dans un fichier CSV.
     * Un message flash de succès est ajouté et l'utilisateur est redirigé vers la page d'accueil.
     *
     * @return Response  une redirection vers la page d'accueil.
     *
     * @var array $data Tableau associatif contenant les données à exporter.
     * @var resource $file Ressource représentant le fichier CSV à créer.
     */
    public function exportCsv(): Response
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
            template: "FAQ.php",
            params: [
                "title" => "FAQ"
            ]
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


    public static function contact_form(): Response
    {
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        $name = $_POST["name"];
        $message = "Nom : " . $name . "\nEmail : " . $email . "\nMessage : " . $message . "\nSujet : " . $subject;
        $email_target = $_POST["email_target"];
        if (isset($email_target)) {


            $emailTargetPart = explode("@", $email_target)[0];
            $listeEmailadmin = (new EnseignantRepository())->getAllEmails();
            foreach ($listeEmailadmin as $emailadmin) {
                $emailClean = trim($emailadmin['email']); // Nettoie l'e-mail et utilise la clé correcte
                $emailAdminPart = explode("@", $emailClean)[0];

                if ($emailTargetPart == $emailAdminPart) {
                    $email_target = $emailClean;
                    var_dump($emailClean);
                    break;
                }
            }
        }
        if (empty($email_target)) {
            $email_target = "jintek781@gmail.com";
        }
        (new EnseignantRepository())->getAllEmails();
        $htmlContent = '<html> 
                    <head> 
                        <title>Mail automatique Stageo</title> 
                    </head> 
                    <body style="text-align: center; margin: 0 auto;"> 
                        <div>
                            <p style="padding: 1em; text-align: left; padding-left: 2%;">'.$message.'</p>
                            <div style="text-align: left; padding-left: 2%;">
                                <h3 style="margin: 0;">'.$name.'</h3>
                                <a href="'.$email.'" style="margin: 0; text-decoration: none; color: black;">'.$email.'</a>
                            </div>
                        </div>
                        <div style="display: flex; gap: 20px;  flex-wrap: wrap;  margin: 2%;">
                            <img src="https://media.discordapp.net/attachments/1130996891409207379/1196206354776477756/logo.png?ex=65b6c8fb&is=65a453fb&hm=6c88ace93cb3a47abbe5977ff8f635b7536a709a874fef49ff129786cc39bd5c&=&format=webp&quality=lossless" style="max-width: 200px; padding-right: 1%; border-right: 1px solid grey;">
                            <img src="https://media.discordapp.net/attachments/1130996891409207379/1196206354260570272/um.png?ex=65b6c8fb&is=65a453fb&hm=472c4236a255cb014683b1632e014506ad6d761eb24771b35349ee5ef99e7c04&=&format=webp&quality=lossless" style="max-width: 200px; padding-right: 1%; border-right: 1px solid grey;">
                            <img src="https://media.discordapp.net/attachments/1130996891409207379/1196206354537381888/iut_montpellier_sete.png?ex=65b6c8fb&is=65a453fb&hm=00670b0cb9e7cafd1902089232e43dcd1a50b441d0b13ca0dd6a67cfe9bc0d8e&=&format=webp&quality=lossless" style="max-width: 200px;">
                        </div>        
                    </body> 
                </html>';
        $email = new Email(
            $email_target,
            'Message contact stageo : '.$subject,
            $htmlContent,
        );
        $mailer = new Mailer();
        $mailer->send($email);
        FlashMessage::add(
            content: "Votre message a bien été envoyé",
            type: FlashType::SUCCESS
        );
        return new Response(
            action: Action::HOME
        );
    }
    public static function tutoriel(): Response
    {
        return new Response(
            template: "visiteur/tutoriel.php",
            params: [
                "title" => "Tutoriel"
            ]
        );
    }

    public static function mention() : Response
    {
        return new Response(
            template: "mention.php",
            params: [
                "title" => "Mentions légales"
            ]
        );
    }
}
