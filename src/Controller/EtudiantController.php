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

    public function postuler(): Response
    {
        $login = $_REQUEST["login"];
        $id_offre = $_REQUEST["id"];
        $cv = $_FILES["cv"];
        $lm = $_FILES["lm"];
        $complement = $_REQUEST["complement"];

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
        FlashMessage::add(
            content: "Vous avez postuler avec succes",
            type: FlashType::SUCCESS
        );
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

        return new Response(
            template: "etudiant/convention-add-step-2.php",
            params: [
                "nav" => false,
                "footer" => false,
                "title" => "Déposer une convention",
                "convention" => Session::get("convention") ?? new Convention(),
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

        return new Response(
            template: "etudiant/convention-add-step-3.php",
            params: [
                "nav" => false,
                "footer" => false,
                "title" => "Déposer une convention",
                "convention" => Session::get("convention") ?? new Convention(),
                "distributions_commune" => array_reduce((new DistributionCommuneRepository)->select(), fn($carry, $distribution) => $carry + [$distribution->getIdDistributionCommune() => "{$distribution->getCommune()} ({$distribution->getCodePostal()})"], []),
                "token" => Token::generateToken(Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM),
                "nomsEntreprise" => array_reduce((new EntrepriseRepository)->select(), fn($carry, $entreprise) => $carry + [$entreprise->getIdEntreprise() => $entreprise->getRaisonSociale()], []),
            ]
        );
    }

    public function conventionAddStep3(): Response
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
                message: "veuillé inscrire la thématique du stage/alternance !",
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
                message: "veuillé inscrire le sujet du stage/alternance !",
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
                message: "veuillé inscrire l'origine du stage/alternance !",
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
                message: "veuillé inscrire les tâches de stage/alternance !",
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
                message: "veuillé inscrire les détails de stage/alternance !",
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
                message: "veuillé inscrire les date de stage/alternance !",
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
                message: "veuillé inscrire les avantages nature de stage/alternance et \"Aucun\" si vous n'en avait pas !",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isText($convention->getAvantagesNature())) {
            throw new ControllerException(
                message: "Les avantages nature doit faire moins de 3065 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
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
        if ($convention->getNumeroVoie()=="") {
            throw new ControllerException(
                message: "veuillé inscrire le numéro de voie du lieu de stage/alternance!",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isName($convention->getNumeroVoie())) {
            throw new ControllerException(
                message: "Le numéro de voie doit faire moins de 257 caractères",
                action: Action::ETUDIANT_CONVENTION_ADD_STEP_3_FORM
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

    public function sauvegarderEntreprise(): Response {

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
    }
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
            new QueryCondition("valider_par_etudiant", ComparisonOperator::EQUAL, true)
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
        Session::set("convention",$convention);
        return new Response(
            action: Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM ,
            params: []
        );
    }
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
                content: "vous n'êtes pas valider dans l'offre",
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
                content: "Tu as dejà un stage ou une alternance",
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
}