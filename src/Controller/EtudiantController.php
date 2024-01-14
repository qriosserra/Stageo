<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\LogicalOperator;
use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Session;
use Stageo\Lib\Mailer\Email;
use Stageo\Lib\Mailer\Mailer;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Offre;
use Stageo\Model\Object\Postuler;
use Stageo\Model\Object\Suivi;
use Stageo\Model\Repository\ConfigurationRepository;
use Stageo\Model\Repository\DistributionCommuneRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\ConventionRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\PostulerRepository;
use Stageo\Model\Repository\SuiviRepository;
use Stageo\Model\Repository\UniteGratificationRepository;

class EtudiantController
{
    public function signInForm(string $login = null): Response
    {
        return new Response(
            template: "etudiant/sign-in.php",
            params: [
                "title" => "Se connecter",
                "nav" => false,
                "footer" => false,
                "login" => $login,
                "token" => Token::generateToken(Action::ETUDIANT_SIGN_IN_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function signIn(): Response
    {
        $login = $_REQUEST["login"];
        $password = $_REQUEST["password"];
        if (!Token::verify(Action::ETUDIANT_SIGN_IN_FORM, $_REQUEST["token"]) && !Token::verify(Action::ADMIN_SIGN_IN_FORM, $_REQUEST["token"]) )
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ETUDIANT_SIGN_IN_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_SIGN_IN_FORM,
                params: ["login" => $login]
            );
        }

        $url = $_ENV["LDAP_API"] . "?" . http_build_query([
                "login" => $login,
                "password" => $password
            ]);
        $response = json_decode(file_get_contents($url), true);
        if (empty($response)) throw new ControllerException(
            message: "Le login ou le mot de passe est incorrect",
            action: Action::ETUDIANT_SIGN_IN_FORM,
            params: ["login" => $login]
        );
        if ($response["annee"]==null){
            return (new AdminController())->signIn($response);
        }else{
        $etudiant = (new EtudiantRepository)->getByLogin($login);
        if (is_null($etudiant)) {
            $etudiant = new Etudiant(
                login: $login,
                nom: $response["nom"],
                prenom: $response["prenom"],
                email_etudiant: $response["mail"],
                annee: $response["annee"]
            );
            (new EtudiantRepository)->insert($etudiant);
        }

        FlashMessage::add(
            content: "Connexion réalisée avec succès",
            type: FlashType::SUCCESS
        );
        UserConnection::signIn($etudiant);
        return new Response(
            action: Action::LISTE_OFFRE
        );}
    }

    public static function afficherFormulairePostuler(string $id): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }
        /**
         * @var Etudiant $user
         */
        $user = UserConnection::getSignedInUser();
        if ((new PostulerRepository)->a_Postuler($user->getLogin(), $id)){
            throw new ControllerException(
                message: "Vous n'avez pas à acceder à cette page",
                action: Action::HOME
            );
        }
        return new Response(
            template: "entreprise/offre/postuler.php",
            params: [
                "etudiant" => $user,
                "offre" => (new OffreRepository)->getById($id),
                "token" => Token::generateToken(Action::ETUDIANT_POSTULER_OFFRE_FORM)
            ]
        );
    }

    /**
     * Méthode de contrôleur permettant à un étudiant de postuler à une offre de stage ou d'alternance. Les informations nécessaires
     * sont récupérées depuis les paramètres de la requête. La fonction effectue plusieurs vérifications pour garantir que l'opération
     * se déroule correctement. En cas de problème, une exception est lancée avec un message approprié et l'utilisateur est redirigé
     * vers la page correspondante pour effectuer les corrections nécessaires. Si la postulation est réussie, un email de confirmation
     * est envoyé à l'entreprise et un message de succès est affiché.
     *
     * @return Response une redirection vers la page d'affichage de l'offre postulée.
     *
     * @throws ControllerException Si une vérification échoue, une exception est lancée avec un message explicatif et une action de redirection.
     *
     * @var string $login Login de l'étudiant postulant.
     * @var string $id_offre Identifiant de l'offre à laquelle l'étudiant postule.
     * @var array $cv Informations du fichier du CV envoyé par l'étudiant.
     * @var array $lm Informations du fichier de la lettre de motivation envoyée par l'étudiant.
     * @var string $complement Informations complémentaires fournies par l'étudiant.
     * @var Offre $offre Instance de l'offre à laquelle l'étudiant postule.
     * @var Entreprise $entreprise Instance de l'entreprise liée à l'offre.
     * @var string $cvName Nom du fichier du CV après l'enregistrement.
     * @var string|null $lmName Nom du fichier de la lettre de motivation après l'enregistrement (peut être null s'il n'y a pas de lettre).
     */
    public function postuler(): Response
    {
        $login = $_REQUEST["login"];
        $id_offre = $_REQUEST["id"];
        $cv = $_FILES["cv"];
        $lm = $_FILES["lm"];
        $complement = $_REQUEST["complement"];
        $offre = (new OffreRepository)->getById($id_offre);
        if (is_null($offre)) {
            throw new ControllerException(
                message: "L'offre n'existe pas",
                action: Action::HOME
            );
        }
        $entreprise = (new EntrepriseRepository())->getById($offre->getIdEntreprise());

        if (!Token::verify(Action::ETUDIANT_POSTULER_OFFRE_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ETUDIANT_POSTULER_OFFRE_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_POSTULER_OFFRE_FORM
            );
        }
        if (!UserConnection::isSignedIn() or !UserConnection::isInstance(new Etudiant) or !UserConnection::getSignedInUser()->getLogin() === $login) {
            throw new ControllerException(
                message: "Vous n'avez pas à acceder à cette page",
                action: Action::ETUDIANT_POSTULER_OFFRE_FORM,
                params: [
                    "login" => $login,
                    "id" => $id_offre
                ]
            );
        }
        if (!$cv["size"]==0 and $cv["error"] != UPLOAD_ERR_OK) {
            throw new ControllerException(
                message: "Erreur lors de l'upload du fichier cv",
                action: Action::ETUDIANT_POSTULER_OFFRE_FORM,
                params: [
                    "login" => $login,
                    "id" => $id_offre,
                    "lm" => $lm,
                    "complement" => $complement
                ]
            );
        }
        if (!$lm["size"]==0 and $lm["error"] != UPLOAD_ERR_OK) {
            throw new ControllerException(
                message: "Erreur lors de l'upload du fichier lm",
                action: Action::ETUDIANT_POSTULER_OFFRE_FORM,
                params: [
                    "login" => $login,
                    "id" => $id_offre,
                    "cv" => $cv,
                    "complement" => $complement
                ]
            );
        }

        if($cv["size"]!=0) {
            $cvName = "cv_" . pathinfo($cv["name"], PATHINFO_FILENAME) . "_" . uniqid() . "." . strtolower(pathinfo($cv["name"], PATHINFO_EXTENSION));
            move_uploaded_file($cv["tmp_name"], "assets/document/cv/$cvName");
            //$cvName = uniqid("", true) . pathinfo($cv["name"], PATHINFO_EXTENSION);
            //move_uploaded_file($cv["tmp_name"], "assets/document/cv/$cvName");
        }
        else{
            FlashMessage::add(
                content: "Il faut déposer un cv",
                type: FlashType::WARNING
            );
            return new Response(
                action: Action::ETUDIANT_POSTULER_OFFRE_FORM,
                params: [
                    "login" => $login,
                    "id" => $id_offre,
                    "lm" => $lm,
                    "complement" => $complement
                ]
            );
        }

        if($lm["size"]!=0) {
            $lmName = "lm_" . pathinfo($lm["name"], PATHINFO_FILENAME) . "_" . uniqid() . "." . strtolower(pathinfo($lm["name"], PATHINFO_EXTENSION));
            //$lmName = uniqid("", true) . pathinfo($lm["name"], PATHINFO_EXTENSION);
            move_uploaded_file($lm["tmp_name"], "assets/document/lm/$lmName");
        }
        else{
            $lmName = null;
        }

        (new PostulerRepository)->insert(new Postuler(
            cv: $cvName,
            login: $login,
            id_offre: $id_offre,
            lettre_motivation: $lmName,
            complement: $complement
        ));
        Mailer::send(new Email(
            $entreprise->getEmail(),
            "Votre convention a été validé pédaogiquement",
            "Votre convention a été validé pédaogiquement"
        ));
        FlashMessage::add(
            content: "Vous avez postuler avec succes",
            type: FlashType::SUCCESS
        );

        // envoyer un mail à l'entreprise
        
        return new Response(
            action: Action::AFFICHER_OFFRE,
            params: [
                "id" => $id_offre
            ]
        );
    }

    public function conventionAddStep1Form(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }
        /**
         * @var Etudiant $etudiant
         * @var Convention $convention
         * @var Suivi $suivi
         */
        if (Session::contains("convention")) {
            $convention = Session::get("convention");
        }
        else {
            $etudiant = UserConnection::getSignedInUser();
            $convention = (new ConventionRepository)->getByLogin($etudiant->getLogin());
            if (is_null($convention)){
                $convention = new Convention();
                if (Session::contains("convention")) {
                    Session::delete("convention");
                }
            }
            $suivi = (new SuiviRepository)->getByIdConvention($convention->getIdConvention());
            if ($suivi != null && !$suivi->getModifiable()) {
                throw new ControllerException(
                    "Vous ne pouvez plus modifier la convention",
                    Action::HOME
                );
            }
        }

        Session::set("convention", $convention);
        return new Response(
            template: "etudiant/convention-add-step-1.php",
            params: [
                "nav" => false,
                "footer" => false,
                "title" => "Déposer une convention",
                "convention" => $convention,
                "token" => Token::generateToken(Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM),
                "type_conventions" => ["1" => "Stage", "2" => "Alternance"],
            ]
        );
    }
    public function conventionAddStep1(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }
        if (!Token::verify(Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1
            );
        }

        /**
         * @var Convention $convention
         */
        $convention = Session::get("convention");
        if (is_null($convention)){
            $user = UserConnection::getSignedInUser();
            /**
             * @var Etudiant $user
             */
            $convention = (new ConventionRepository())->getByLogin($user->getLogin());
            if (is_null($convention)){
                throw new ControllerException(
                    message: "Vous avez prit trop de temps, veuillé recommencer !",
                    action: Action::HOME
                );
            }
        }
        $convention->setLogin((UserConnection::getSignedInUser())->getLogin());
        $convention->setTypeConvention($_REQUEST["type_convention"]);
        $convention->setOrigineStage($_REQUEST["origine_stage"]);
        $convention->setThematique($_REQUEST["thematique"]);
        $convention->setSujet($_REQUEST["sujet"]);
        $convention->setTaches($_REQUEST["taches"]);
        $convention->setCommentaires($_REQUEST["commentaires"]);
        $convention->setDetails($_REQUEST["details"]);

        if (!Validate::isName($convention->getThematique(), false)) {
            throw new ControllerException(
                message: "La thématique doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isName($convention->getSujet(), false)) {
            throw new ControllerException(
                message: "Le sujet doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isName($convention->getOrigineStage(), false)) {
            throw new ControllerException(
                message: "L'origine du stage doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isText($convention->getTaches())) {
            throw new ControllerException(
                message: "Les tâches doivent faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isText($convention->getCommentaires())) {
            throw new ControllerException(
                message: "Les commentaires doivent faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isText($convention->getDetails())) {
            throw new ControllerException(
                message: "Les détails doivent faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }

        return new Response(
            action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
        );
    }

    public function conventionAddStep2Form(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }
        $annees_universitaires = [
            "2020-2021" => "2020-2021",
            "2021-2022" => "2021-2022",
            "2022-2023" => "2022-2023",
            "2023-2024" => "2023-2024",
            "2024-2025" => "2024-2025"
        ];

        if (Session::contains("convention")) {
            $convention = Session::get("convention");
        }
        else {
            $etudiant = UserConnection::getSignedInUser();
            $convention = (new ConventionRepository)->getByLogin($etudiant->getLogin());
            if (is_null($convention)){
                $convention = new Convention();
                if (Session::contains("convention")) {
                    Session::delete("convention");
                }
            }
            $suivi = (new SuiviRepository)->getByIdConvention($convention->getIdConvention());
            if ($suivi != null && !$suivi->getModifiable()) {
                throw new ControllerException(
                    "Vous ne pouvez plus modifier la convention",
                    Action::HOME
                );
            }
        }

        return new Response(
            template: "etudiant/convention-add-step-2.php",
            params: [
                "nav" => false,
                "footer" => false,
                "title" => "Déposer une convention",
                "convention" => $convention ?? new Convention(),
                "gratification" => (new ConfigurationRepository)->getGratificationMinimale(),
                "unite_gratifications" => array_column(array_map(fn($e) => $e->toArray(), (new UniteGratificationRepository)->select()), "libelle", "id_unite_gratification"),
                "token" => Token::generateToken(Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM),
                "annees_universitaires" => $annees_universitaires,
            ]
        );
    }

    public function conventionAddStep2(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }
        if (!Token::verify(Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2
            );
        }

        /**
         * @var Convention $convention
         */
        $convention = Session::get("convention");
        if (is_null($convention)){
            $user = UserConnection::getSignedInUser();
            /**
             * @var Etudiant $user
             */
            $convention = (new ConventionRepository())->getByLogin($user->getLogin());
            if (is_null($convention)){
                throw new ControllerException(
                    message: "Vous avez prit trop de temps, veuillé recommencer !",
                    action: Action::HOME
                );
            }
        }
        $convention->setDateDebut($_REQUEST["date_debut"] === "" ? null : $_REQUEST["date_debut"]);
        $convention->setDateFin($_REQUEST["date_fin"] === "" ? null : $_REQUEST["date_fin"]);
//        $convention->setInterruption($_REQUEST["interruption"]);
//        $convention->setDateInterruptionDebut($_REQUEST["date_debut_interruption"] === "" ? null : $_REQUEST["date_debut_interruption"]);
//        $convention->setDateInterruptionFin($_REQUEST["date_fin_interruption"] === "" ? null : $_REQUEST["date_fin_interruption"]);
        $convention->setAnneeUniversitaire($_REQUEST["annee_universitaire"]);
        $convention->setHeuresTotal($_REQUEST["heures_total"] === "" ? null : $_REQUEST["heures_total"]);
        $convention->setJoursHebdomadaire($_REQUEST["jours_hebdomadaire"] === "" ? null : $_REQUEST["jours_hebdomadaire"]);
        $convention->setHeuresHebdomadaire($_REQUEST["heures_hebdomadaire"] === "" ? null : $_REQUEST["heures_hebdomadaire"]);
        $convention->setCommentairesDuree($_REQUEST["commentaire_duree"]);
        $convention->setGratification($_REQUEST["gratification"]);
        $convention->setIdUniteGratification($_REQUEST["id_unite_gratification"]);
        $convention->setAvantagesNature($_REQUEST["avantages_nature"]);
        Session::set("convention", $convention);

        if (!is_null($convention->getDateDebut()) and date("Y-m-d") > $convention->getDateDebut()) {
            throw new ControllerException(
                message: "La date de début doit être supérieur à la date du jour",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_null($convention->getDateDebut()) and $convention->getDateDebut() >= $convention->getDateFin()) {
            throw new ControllerException(
                message: "La date de début doit être inférieur à la date de fin",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_null($convention->getHeuresTotal()) and $convention->getHeuresTotal() < 0) {
            throw new ControllerException(
                message: "Le nombre d'heures total doit être supérieur à 0",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_null($convention->getJoursHebdomadaire()) and $convention->getJoursHebdomadaire() < 0 or $convention->getJoursHebdomadaire() > 7) {
            throw new ControllerException(
                message: "Le nombre de jours hebdomadaire doit être compris entre 0 et 7",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_null($convention->getHeuresHebdomadaire()) and $convention->getHeuresHebdomadaire() < 0 or $convention->getHeuresHebdomadaire() > 45) {
            throw new ControllerException(
                message: "Le nombre d'heures hebdomadaire doit être compris entre 0 et 45",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isText($convention->getCommentairesDuree())) {
            throw new ControllerException(
                message: "Le commentaire sur la durée doit faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_null($convention->getGratification()) and $convention->getGratification() < (new ConfigurationRepository)->getGratificationMinimale()) {
            throw new ControllerException(
                message: "La gratification doit être supérieur à " . (new ConfigurationRepository)->getGratificationMinimale(),
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isText($convention->getAvantagesNature())) {
            throw new ControllerException(
                message: "Le commentaire sur la durée doit faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }

        return new Response(
            action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
        );
    }
    public function conventionAddStep3Form(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }
        if (Session::contains("convention")) {
            $convention = Session::get("convention");
        }
        else {
            $etudiant = UserConnection::getSignedInUser();
            $convention = (new ConventionRepository)->getByLogin($etudiant->getLogin());
            if (is_null($convention)){
                $convention = new Convention();
                if (Session::contains("convention")) {
                    Session::delete("convention");
                }
            }
            $suivi = (new SuiviRepository)->getByIdConvention($convention->getIdConvention());
            if ($suivi != null && !$suivi->getModifiable()) {
                throw new ControllerException(
                    "Vous ne pouvez plus modifier la convention",
                    Action::HOME
                );
            }
        }
        return new Response(
            template: "etudiant/convention-add-step-3.php",
            params: [
                "nav" => false,
                "footer" => false,
                "title" => "Déposer une convention",
                "convention" => $convention ?? new Convention(),
                "token" => Token::generateToken(Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM)
            ]
        );
    }

    public function conventionAddStep3(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour accéder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas accéder à cette page",
                action: Action::HOME
            );
        }
        if (!Token::verify(Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3
            );
        }

        /**
         * @var Convention $convention
         */
        $convention = Session::get("convention");
        if (is_null($convention)){
            $user = UserConnection::getSignedInUser();
            /**
             * @var Etudiant $user
             */
            $convention = (new ConventionRepository())->getByLogin($user->getLogin());
            if (is_null($convention)){
                throw new ControllerException(
                    message: "Vous avez prit trop de temps, veuillez recommencer !",
                    action: Action::HOME
                );
            }
        }
        $convention->setTuteurPrenom($_REQUEST["prenom"]);
        $convention->setTuteurNom($_REQUEST["nom"]);
        $convention->setTuteurEmail($_REQUEST["email"]);
        $convention->setTuteurTelephone($_REQUEST["telephone"]);
        $convention->setTuteurFonction($_REQUEST["fonction"]);
        Session::set("convention", $convention);

        if (!is_null($convention->getTuteurPrenom()) and !Validate::isName($convention->getTuteurPrenom())) {
            throw new ControllerException(
                message: "Le prénom du tuteur doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!is_null($convention->getTuteurNom()) and !Validate::isName($convention->getTuteurNom())) {
            throw new ControllerException(
                message: "Le nom du tuteur doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!is_null($convention->getTuteurEmail()) and !Validate::isEmail($convention->getTuteurEmail())) {
            throw new ControllerException(
                message: "L'email n'est pas valide",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!is_null($convention->getTuteurTelephone()) and !Validate::isPhoneNumber($convention->getTuteurTelephone())) {
            throw new ControllerException(
                message: "Le téléphone n'est pas valide",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!is_null($convention->getTuteurFonction()) and !Validate::isName($convention->getTuteurFonction())) {
            throw new ControllerException(
                message: "La fonction du tuteur doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }

        return new Response(
            action: Action::ETUDIANT_CONVENTION_ADD_STEP_4_FORM
        );
    }

    public function conventionAddStep4Form(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }

        if (Session::contains("convention")) {
            $convention = Session::get("convention");
        }
        else {
            $etudiant = UserConnection::getSignedInUser();
            $convention = (new ConventionRepository)->getByLogin($etudiant->getLogin());
            if (is_null($convention)){
                $convention = new Convention();
                if (Session::contains("convention")) {
                    Session::delete("convention");
                }
            }
            $suivi = (new SuiviRepository)->getByIdConvention($convention->getIdConvention());
            if ($suivi != null && !$suivi->getModifiable()) {
                throw new ControllerException(
                    "Vous ne pouvez plus modifier la convention",
                    Action::HOME
                );
            }
        }

        return new Response(
            template: "etudiant/convention-add-step-4.php",
            params: [
                "nav" => false,
                "footer" => false,
                "title" => "Déposer une convention",
                "convention" => $convention ?? new Convention(),
                "distributions_commune" => array_reduce((new DistributionCommuneRepository)->select(), fn($carry, $distribution) => $carry + [$distribution->getIdDistributionCommune() => "{$distribution->getCommune()} ({$distribution->getCodePostal()})"], []),
                "token" => Token::generateToken(Action::ETUDIANT_CONVENTION_ADD_STEP_4_FORM),
                "nomsEntreprise" => array_reduce((new EntrepriseRepository)->select(), fn($carry, $entreprise) => $carry + [$entreprise->getIdEntreprise() => $entreprise->getRaisonSociale()], []),
            ]
        );
    }

    public function conventionAddStep4(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }
        if (!Token::verify(Action::ETUDIANT_CONVENTION_ADD_STEP_4_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ETUDIANT_CONVENTION_ADD_STEP_4_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3
            );
        }

        /**
         * @var Convention $convention
         */
        $convention = Session::get("convention");
        if (is_null($convention)){
            $user = UserConnection::getSignedInUser();
            /**
             * @var Etudiant $user
             */
            $convention = (new ConventionRepository())->getByLogin($user->getLogin());
            if (is_null($convention)){
                throw new ControllerException(
                    message: "Vous avez prit trop de temps, veuillé recommencer !",
                    action: Action::HOME
                );
            }
        }
        $convention->setIdEntreprise($_REQUEST["entreprise"]);
        $convention->setIdDistributionCommune($_REQUEST["id_distribution_commune"]);
        $convention->setNumeroVoie($_REQUEST["numero_voie"]);

        if (is_null((new EntrepriseRepository)->getById($convention->getIdEntreprise()))) {
            throw new ControllerException(
                message: "L'entreprise n'existe pas",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (is_null((new DistributionCommuneRepository)->getById($convention->getIdDistributionCommune()))) {
            throw new ControllerException(
                message: "La commune n'existe pas",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!Validate::isName($convention->getNumeroVoie())) {
            throw new ControllerException(
                message: "Le numéro de voie doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (is_null($convention->getIdConvention())) {
            $id_convention = (new ConventionRepository)->insert($convention);
            $convention->setIdConvention($id_convention);
            (new SuiviRepository)->insert(new Suivi(
                date_creation: date("Y-m-d H:i:s"),
                date_modification: date("Y-m-d H:i:s"),
                id_convention: $id_convention
            ));
        }
        else {
            $conventionBDD = (new ConventionRepository())->getById($convention->getIdConvention());
            (new ConventionRepository)->update($convention);
            /**
             * @var Suivi $suivi
             */
            $suivi = (new SuiviRepository)->getByIdConvention($convention->getIdConvention());
            $suivi->setDateModification(date("Y-m-d H:i:s"));
            (new SuiviRepository)->update($suivi);
        }
        Session::delete("convention");
        FlashMessage::add("Convention enregistrée comme brouillon. Veuillez la soumettre une fois complétée.", FlashType::INFO);

        return new Response(
            action: Action::HOME
        );
    }

    /**
     * Méthode de contrôleur permettant à l'étudiant de soumettre une convention. Cette fonction effectue une série de vérifications
     * pour s'assurer que la convention est correctement remplie. En cas de problème, elle lance une exception avec un message
     * approprié et redirige l'utilisateur vers la page correspondante pour corriger les informations nécessaires. Si toutes les
     * vérifications passent, la convention est marquée comme soumise, et un message de réussite est affiché.
     *
     * @return Response une redirection vers la page d'accueil.
     *
     * @throws ControllerException Si une vérification échoue, une exception est lancée avec un message explicatif et une action de redirection.
     *
     * @var Etudiant $etudiant Instance de l'étudiant actuellement connecté.
     * @var Convention $convention Instance de la convention associée à l'étudiant.
     * @var Suivi $suivi Instance du suivi associé à la convention.
     */

    public function soumettreConvention(): Response
    {
        if (!UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous devez être connecté pour acceder à cette page",
                action: Action::ETUDIANT_SIGN_IN_FORM
            );
        }
        if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous ne pouvez pas acceder à cette page",
                action: Action::HOME
            );
        }
        /**
         * @var Etudiant $etudiant
         */
        $etudiant = UserConnection::getSignedInUser();
        $convention = (new ConventionRepository)->getByLogin($etudiant->getLogin());

        if(!$convention){
            throw new ControllerException(
                message: "Vous n'avez pas créer de convention",
                action: Action::HOME
            );
        }

        if ($convention->getThematique()==""){
            throw new ControllerException(
                message: "Veuillez inscrire la thématique de la convention",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isName($convention->getThematique(), false)) {
            throw new ControllerException(
                message: "La thématique doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if ($convention->getSujet()==""){
            throw new ControllerException(
                message: "Veuillez inscrire le sujet de la convention",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isName($convention->getSujet(), false)) {
            throw new ControllerException(
                message: "Le sujet doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if ($convention->getOrigineStage()==""){
            throw new ControllerException(
                message: "Veuillez inscrire l'origine de la convention",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isName($convention->getOrigineStage(), false)) {
            throw new ControllerException(
                message: "L'origine du stage doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if ($convention->getTaches()==""){
            throw new ControllerException(
                message: "Veuillez inscrire les tâches de la convention",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isText($convention->getTaches())) {
            throw new ControllerException(
                message: "Les tâches doivent faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if (!is_null($convention->getCommentaires()) && !Validate::isText($convention->getCommentaires())) {
            throw new ControllerException(
                message: "Les commentaires doivent faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if ($convention->getDetails()==""){
            throw new ControllerException(
                message: "Veuillez inscrire les détails de la convention",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isText($convention->getDetails())) {
            throw new ControllerException(
                message: "Les détails doivent faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM
            );
        }
        if (is_null($convention->getDateDebut())|| is_null($convention->getDateFin())){
            throw new ControllerException(
                message: "Veuillez inscrire les dates de la convention",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isDate($convention->getDateDebut()) or date("Y-m-d") > $convention->getDateDebut()) {
            throw new ControllerException(
                message: "La date de début doit être supérieur à la date du jour",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isDate($convention->getDateFin()) or $convention->getDateDebut() >= $convention->getDateFin()) {
            throw new ControllerException(
                message: "La date de début doit être inférieur à la date de fin",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_int((int) $convention->getHeuresTotal()) or $convention->getHeuresTotal() < 0) {
            throw new ControllerException(
                message: "Le nombre d'heures total doit être supérieur à 0",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_int((int) $convention->getJoursHebdomadaire()) or $convention->getJoursHebdomadaire() < 0 or $convention->getJoursHebdomadaire() > 7) {
            throw new ControllerException(
                message: "Le nombre de jours hebdomadaire doit être compris entre 0 et 7",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_int((int) $convention->getHeuresHebdomadaire()) or $convention->getHeuresHebdomadaire() < 0 or $convention->getHeuresHebdomadaire() > 45) {
            throw new ControllerException(
                message: "Le nombre d'heures hebdomadaire doit être compris entre 0 et 45",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!is_null($convention->getCommentairesDuree()) && !Validate::isText($convention->getCommentairesDuree())) {
            throw new ControllerException(
                message: "Le commentaire sur la durée doit faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (is_null($convention->getGratification()) or $convention->getGratification() < (new ConfigurationRepository)->getGratificationMinimale()) {
            throw new ControllerException(
                message: "La gratification doit être supérieur à " . (new ConfigurationRepository)->getGratificationMinimale(),
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if ($convention->getAvantagesNature()=="") {
            throw new ControllerException(
                message: "Veuillez inscrire les avantages nature de la convention, \"aucun\" s'il n'y en a pas",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isText($convention->getAvantagesNature())) {
            throw new ControllerException(
                message: "Les avantages nature doit faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if ($convention->getTuteurPrenom()=="") {
            throw new ControllerException(
                message: "Veuillez inscrire le prénom du tuteur",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!Validate::isName($convention->getTuteurPrenom())) {
            throw new ControllerException(
                message: "Le prénom du tuteur doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if ($convention->getTuteurNom()=="") {
            throw new ControllerException(
                message: "Veuillez inscrire le nom du tuteur",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!Validate::isName($convention->getTuteurNom())) {
            throw new ControllerException(
                message: "Le nom du tuteur doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if ($convention->getTuteurEmail()=="") {
            throw new ControllerException(
                message: "Veuillez inscrire l'email du tuteur",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!Validate::isEmail($convention->getTuteurEmail())) {
            throw new ControllerException(
                message: "L'email du tuteur n'est pas valide",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if ($convention->getTuteurTelephone()=="") {
            throw new ControllerException(
                message: "Veuillez inscrire le téléphone du tuteur",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!Validate::isPhoneNumber($convention->getTuteurTelephone())) {
            throw new ControllerException(
                message: "Le téléphone du tuteur n'est pas valide",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if ($convention->getTuteurFonction()=="") {
            throw new ControllerException(
                message: "Veuillez inscrire la fonction du tuteur",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (!Validate::isName($convention->getTuteurFonction())) {
            throw new ControllerException(
                message: "La fonction du tuteur doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
            );
        }
        if (is_null((new EntrepriseRepository)->getById($convention->getIdEntreprise()))) {
            throw new ControllerException(
                message: "L'entreprise n'existe pas",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_4_FORM
            );
        }
        if (is_null((new DistributionCommuneRepository)->getById($convention->getIdDistributionCommune()))) {
            throw new ControllerException(
                message: "La commune n'existe pas",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_4_FORM
            );
        }
        if ($convention->getNumeroVoie()=="") {
            throw new ControllerException(
                message: "Veuillez inscrire l'adresse où se déroulera la convention",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_4_FORM
            );
        }
        if (!Validate::isName($convention->getNumeroVoie())) {
            throw new ControllerException(
                message: "Le numéro de voie doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_4_FORM
            );
        }

        /**
         * @var Suivi $suivi
         */
        $suivi = (new SuiviRepository)->getByIdConvention($convention->getIdConvention());
        $suivi->setDateModification(date("Y-m-d H:i:s"));
        $suivi->setModifiable(false);
        (new SuiviRepository)->update($suivi);

        FlashMessage::add("La convention a été soumise avec succès", FlashType::SUCCESS);
        return new Response(
            action: Action::HOME
        );
    }

  /*  public function sauvegarderEntreprise(): Response {

        if (!isset($_REQUEST['Entreprise']) || !isset($_REQUEST['Entreprise']['id']) || !isset($_REQUEST['Entreprise']['nom']) ){
            FlashMessage::add(
                content: "erreur identifiant de l'entreprise non trouvée",
                type: FlashType::ERROR
            );

            return new Response(
                action: Action::HOME
            );
        }else{
            $id = $_REQUEST['Entreprise']['id'];
            //$i[] = ['oo' => ['a','b']];
            $Favorie = Session::get('favorie') ?? [];
            $Favorie[$_REQUEST['Entreprise']['nom']] = $id;
            Session::set('favorie', $Favorie);

            FlashMessage::add(
                content: "Entreprise Sauvegarder",
                type: FlashType::SUCCESS
            );

            return new Response(
                action: Action::AFFICHER_OFFRE,
                params: ["id" => urlencode($id)]
            );
        }
    }*/
    public function afficherProfile() : Response{

        if (!UserConnection::isInstance(new Etudiant())){
            FlashMessage::add(
                content: "tu n'est pas connecter ou tu n'as pas les droits",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        $etudiant = UserConnection::getSignedInUser();
        $communes  = (new DistributionCommuneRepository)->select();
        if (!isset($etudiant)){
            FlashMessage::add(
                content: "vous n'etes pas enregistrer dans la base de données",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        $offrePostuler = (new PostulerRepository())->select(new QueryCondition("login", ComparisonOperator::EQUAL, $etudiant->getLogin()));
        $offres = [];
        foreach ($offrePostuler as $idOffre) {
            $offre = (new OffreRepository())->getById($idOffre->getIdOffre());

            if ($offre instanceof Offre) {
                $entreprise = (new EntrepriseRepository())->getById($offre->getIdEntreprise());

                if ($entreprise instanceof Entreprise) {
                    // Ajouter le couple (Offre, Entreprise) à la liste $offres
                    $offres[] = ['offre' => $offre, 'entreprise' => $entreprise];
                }
            }
        }
        return new Response(
            template: "etudiant/profile.php",
            params: [
                "login" =>$etudiant->getLogin(),
                "nom" => $etudiant->getNom(),
                "prenom" => $etudiant->getPrenom(),
                "email" =>$etudiant->getEmailEtudiant(),
                "annee" => $etudiant->getAnnee(),
                "tel" => $etudiant->getTelephone(),
                "fix" => $etudiant->getTelephoneFixe(),
                "civiliter" => $etudiant->getCivilite(),
                "commune" => $etudiant->getIdDistributionCommune(),
                "communes" => $communes,
                "voie" => $etudiant->getNumeroVoie(),
                "offres" => $offres,
            ]
        );
    }
    public function MettreAJourProfile() : Response{
        $tel = $_REQUEST['Tel'];
        $fix = $_REQUEST['Fixe'];
        $civiliter = $_REQUEST['Civiliter'];
        $commune = $_REQUEST['Commune'];
        $voie = $_REQUEST['Voie'];
        $etudiant = UserConnection::getSignedInUser();
        if (!isset($tel) || !isset($fix) || !isset($civiliter) || !isset($commune) || !isset($voie)){
            FlashMessage::add(
                content: "il manque des informations",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        if (!UserConnection::isInstance(new Etudiant())){
            FlashMessage::add(
                content: "tu n'est pas connecter ou tu n'as pas les droits",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        if (!isset($etudiant)){
            FlashMessage::add(
                content: "vous n'etes pas l'etudiant enregistrer dans la base de données",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        $etudiant->setTelephone($tel);
        $etudiant->setTelephoneFixe($fix);
        $etudiant->setCivilite($civiliter);
        $etudiant->setIdDistributionCommune($commune);
        $etudiant->setNumeroVoie($voie);
        (new EtudiantRepository())->update($etudiant);
        FlashMessage::add(
            content: "Profile mis à jours",
            type: FlashType::SUCCESS
        );
        return new Response(
            action: Action::PROFILE_ETUDIANT,
        );
    }


    /**
     * Méthode de contrôleur permettant à l'étudiant d'accepter une offre et d'être redirigé vers une page de création de convention
     * préremplie. Si l'étudiant a déjà accepté l'offre, la fonction redirige également vers la convention préremplie associée.
     * Dans le premier cas, la base de données est nettoyée en supprimant les autres étudiants ayant postulé à la même offre, ainsi
     * que leurs CV et lettres de motivation.
     *
     * @return Response une redirection vers la page de création de convention.
     *
     * @var string $login Login de l'étudiant.
     * @var string $idOffre Identifiant de l'offre acceptée.
     * @var Etudiant $etudiant Instance de l'étudiant actuellement connecté.
     * @var OffreRepository $offreRepository Instance du référentiel d'offres pour interagir avec la base de données des offres.
     * @var EntrepriseRepository $entrepriseRepository Instance du référentiel d'entreprises pour interagir avec la base de données des entreprises.
     * @var Convention $convention Instance d'une convention préremplie.
     * @var array $condition Condition de requête pour vérifier si l'étudiant a déjà un stage ou une alternance.
     * @var array $verif_etudiant Résultat de la requête de vérification de l'étudiant.
     * @var array $condition_deja_accepter Condition de requête pour vérifier si l'étudiant a déjà accepté cette offre.
     * @var array $already_accept Résultat de la requête pour vérifier si l'étudiant a déjà accepté cette offre.
     * @var array $offres Résultat de la requête pour récupérer toutes les offres auxquelles l'étudiant a postulé.
     * @var array $autrePostulant Résultat de la requête pour récupérer les autres étudiants ayant postulé à la même offre.
     */
    public function validerDefinitivement() : Response{
        $login = $_REQUEST['login'];
        $idOffre = $_REQUEST['idOffre'];

        if (!isset($idOffre) || !isset($login)){
            FlashMessage::add(
                content: "il manque des valeurs",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::PROFILE_ETUDIANT,
                params: []
            );
        }
        if (!UserConnection::isInstance(new Etudiant())){
            FlashMessage::add(
                content: "tu n'est pas connecter ou tu n'as pas les droits",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        $etudiant = UserConnection::getSignedInUser();
        if (!isset($etudiant) || $etudiant->getLogin() != $login){
            FlashMessage::add(
                content: "vous n'etes pas enregistrer dans la base de données",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        $offre = (new OffreRepository())->getById($idOffre);
        $entreprise = (new EntrepriseRepository())->getById($offre->getIdEntreprise());
        $convention = new Convention(
            login: $offre->getLogin(),
            type_convention: $offre->getType(),
            thematique: $offre->getThematique(),
            sujet: $offre->getSecteur(),
            taches: $offre->getTaches(),
            commentaires: $offre->getCommentaires(),
            date_debut: $offre->getDateDebut(),
            date_fin: $offre->getDateFin(),
            gratification: $offre->getGratification(),
            id_unite_gratification: $offre->getIdUniteGratification(),
            id_distribution_commune: $entreprise->getIdDistributionCommune(),
            numero_voie: $entreprise->getNumeroVoie(),
            id_entreprise: $offre->getIdEntreprise(),
        );

        if ($offre->getType() === "Stage&Alternance") {
            $convention->setTypeConvention(null);
        }

        if ($offre->getLogin() != $login){
            FlashMessage::add(
                content: "vous n'êtes pas valider dans l'offre",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM ,
                params: [
                    "convention"=>$convention
                ]
            );
        }
        $condition = [
            new QueryCondition("login", ComparisonOperator::EQUAL, $etudiant->getLogin(), LogicalOperator::AND),
            new QueryCondition("valider_par_etudiant", ComparisonOperator::EQUAL, true, LogicalOperator::AND),
            new QueryCondition("id_offre", ComparisonOperator::NOT_EQUAL, $idOffre)
        ];

        $verif_etudiant = (new OffreRepository())->select($condition);
        if($verif_etudiant){
            FlashMessage::add(
                content: "Tu as dejà un stage ou une alternance",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }

        $condition_deja_accepter = [
            new QueryCondition("login", ComparisonOperator::EQUAL, $etudiant->getLogin(), LogicalOperator::AND),
            new QueryCondition("valider_par_etudiant", ComparisonOperator::EQUAL, true, LogicalOperator::AND),
            new QueryCondition("id_offre", ComparisonOperator::EQUAL, $idOffre)
        ];

        $already_accept = (new OffreRepository())->select($condition_deja_accepter);

        if(!$already_accept) {
            $offre->setValiderParEtudiant(true);
            (new OffreRepository)->update($offre);
            //$postuler = (new PostulerRepository())->select(new QueryCondition("login",ComparisonOperator::EQUAL,$etudiant->getLogin()));
            $offres =  (new OffreRepository())->select(new QueryCondition("login",ComparisonOperator::EQUAL,$etudiant->getLogin()));
            $autrePostulant = (new PostulerRepository())->select(new QueryCondition("id_offre",ComparisonOperator::EQUAL,$idOffre));
            foreach($offres as $o){
                if ($o->getIdOffre() != $idOffre){
                    $o->setLogin(new NullDataType());
                    (new OffreRepository())->update($o);
                }
            }
            foreach($autrePostulant as $post){
                    if(file_exists("assets/document/cv/".$post->getCv())){
                        unlink("assets/document/cv/".$post->getCv());
                    }
                    if(file_exists("assets/document/lm/".$post->getLettreMotivation())){
                        unlink("assets/document/lm/".$post->getLettreMotivation());
                }
            }
            (new PostulerRepository())->delete(new QueryCondition("login",ComparisonOperator::EQUAL,$etudiant->getLogin()));




            FlashMessage::add(
                content: "Profile mis à jours",
                type: FlashType::SUCCESS
            );
        }
        Session::set("convention",$convention);
        return new Response(
            action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM ,
            params: []
        );
    }


    /**
     * Méthode de contrôleur permettant à un étudiant choisi par une entreprise pour un stage ou une alternance de refuser
     * définitivement le poste. La fonction supprime l'association entre l'étudiant et l'offre, et supprime également les
     * documents (CV, lettre de motivation) associés à cette candidature.
     *
     * @return Response  une redirection vers la page de profil de l'étudiant.
     *
     * @var string $login Login de l'étudiant.
     * @var string $idOffre Identifiant de l'offre à laquelle l'étudiant a été choisi.
     * @var Etudiant $etudiant Instance de l'étudiant actuellement connecté.
     * @var OffreRepository $offreRepository Instance du référentiel d'offres pour interagir avec la base de données des offres.
     * @var array $condition2 Condition de requête pour vérifier si l'étudiant a déjà un stage ou une alternance.
     * @var array $verif_etudiant Résultat de la requête de vérification de l'étudiant.
     * @var array $condition Condition de requête pour récupérer la candidature de l'étudiant à l'offre choisie.
     * @var array $offrePotuler Résultat de la requête pour récupérer la candidature de l'étudiant à l'offre.
     */
    public function refuserDefinitivement() : Response{
        $login = $_REQUEST['login'];
        $idOffre = $_REQUEST['idOffre'];

        if (!isset($idOffre) || !isset($login)){
            FlashMessage::add(
                content: "il manque des valeurs",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::PROFILE_ETUDIANT,
                params: []
            );
        }
        if (!UserConnection::isInstance(new Etudiant())){
            FlashMessage::add(
                content: "tu n'est pas connecter ou tu n'as pas les droits",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        $etudiant = UserConnection::getSignedInUser();
        if (!isset($etudiant) || $etudiant->getLogin() != $login){
            FlashMessage::add(
                content: "vous n'etes pas enregistrer dans la base de données",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        $offre = (new OffreRepository())->getById($idOffre);

        if ($offre->getLogin() != $login){
            FlashMessage::add(
                content: "Vous n'êtes pas valider dans l'offre",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::PROFILE_ETUDIANT,
                params: []
            );
        }
        $condition2 = [new QueryCondition("login",ComparisonOperator::EQUAL,$etudiant->getLogin(),LogicalOperator::AND),
            new QueryCondition("valider_par_etudiant",ComparisonOperator::EQUAL,true)
        ];
        $verif_etudiant = (new OffreRepository())->select($condition2);
        if($verif_etudiant){
            FlashMessage::add(
                content: "Vous avez dejà un stage ou une alternance",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::HOME,
                params: []
            );
        }
        $offre->setLogin(new NullDataType());
        $condition = [
            new QueryCondition("login",ComparisonOperator::EQUAL,$login,LogicalOperator::AND),
            new QueryCondition("id_offre",ComparisonOperator::EQUAL,$idOffre)
        ];
        $offrePotuler = (new PostulerRepository())->select($condition);
        if (!empty($offrePotuler) && isset($offrePotuler[0])) {
            if (file_exists("assets/document/cv/" . $offrePotuler[0]->getCv())) {
                unlink("assets/document/cv/" . $offrePotuler[0]->getCv());
            }
            if (file_exists("assets/document/lm/" . $offrePotuler[0]->getLettreMotivation())) {
                unlink("assets/document/lm/" . $offrePotuler[0]->getLettreMotivation());
            }
        }
        (new OffreRepository)->update($offre);
        $postuler = (new PostulerRepository())->select(new QueryCondition("login",ComparisonOperator::EQUAL,$etudiant->getLogin()));

        $cond = [
            new QueryCondition("login",ComparisonOperator::EQUAL,$login,LogicalOperator::AND),
            new QueryCondition("id_offre",ComparisonOperator::EQUAL,$idOffre)
        ];
        (new PostulerRepository())->delete($cond);
        FlashMessage::add(
            content: "Profile mis à jours",
            type: FlashType::SUCCESS
        );
        return new Response(
            action: Action::PROFILE_ETUDIANT,
        );
    }

    /**
     * Méthode de contrôleur permettant à un étudiant de visualiser les offres sur lesquelles il a postulé,
     * ainsi que celles pour lesquelles il a été accepté. La fonction renvoie également le nombre total d'offres auxquelles
     * l'étudiant a postulé.
     *
     * @return Response une page affichant les offres postulées.
     *
     * @var Etudiant $user Instance de l'étudiant actuellement connecté.
     * @var QueryCondition $condition Condition de requête pour filtrer les offres en fonction du login de l'étudiant.
     * @var array $liste_accepter Liste des offres acceptées par l'étudiant.
     * @var array $liste_postuler Liste des offres auxquelles l'étudiant a postulé.
     * @var array $postuler Liste complète des offres auxquelles l'étudiant a postulé.
     * @var int $nbpostuler Nombre total d'offres auxquelles l'étudiant a postulé.
     * @var Offre|null $id ID de l'offre acceptée par l'étudiant, null si aucune offre n'a été acceptée.
     */
    public function voirMesCandidature():Response{
        if (UserConnection::isInstance(new Etudiant())) {
            $user = UserConnection::getSignedInUser();
            $condition = new QueryCondition("login", ComparisonOperator::EQUAL, $user->getLogin());
            $liste_accepter = (new OffreRepository())->select($condition);
            $liste_postuler = (new PostulerRepository())->select($condition);
            $postuler = [];
            $id = null;

            foreach ($liste_postuler as $p) {
                $offrePostuler = (new OffreRepository())->getById($p->getIdOffre());
                $postuler[] = $offrePostuler;
            }
            foreach ($liste_accepter as $p){
                $offrePostuler = (new OffreRepository())->getById($p->getIdOffre());
                if($offrePostuler->getValiderParEtudiant()){
                    $id = $offrePostuler;
                }
            }
            $nbpostuler = count($postuler)+count($liste_accepter);
            return new Response(
                template: "etudiant/afficher-offre-postuler.php",
                params: [
                    "title" => "Voir les offres auxquelle j'ai postulé",
                    "postuler"=>$postuler,
                    "accepter"=>$liste_accepter,
                    "nombre"=>$nbpostuler,
                    "id"=>$id
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    public function tutorielEtudiant() : Response{
        return new Response(
            template: "etudiant/tutoriel.php",
            params: [
                "title" => "Tutoriel Etudiant",
            ]
        );
    }
}