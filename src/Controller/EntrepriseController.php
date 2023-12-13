<?php

namespace Stageo\Controller;

use Exception;
use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\LogicalOperator;
use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Session;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Crypto;
use Stageo\Lib\Security\EmailVerification;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Offre;
use Stageo\Model\Repository\DistributionCommuneRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\PostulerRepository;
use Stageo\Model\Repository\StatutJuridiqueRepository;
use Stageo\Model\Repository\TailleEntrepriseRepository;
use Stageo\Model\Repository\TypeStructureRepository;
use Stageo\Model\Repository\UniteGratificationRepository;
use function Sodium\add;

class EntrepriseController
{
    public function signUpStep1Form(): Response
    {
        if (UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous êtes déjà connecté",
                action: Action::HOME
            );
        }
        return new Response(
            template: "entreprise/sign-up-step-1.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "entreprise" => Session::get("entreprise"),
                "token" => Token::generateToken(Action::ENTREPRISE_SIGN_UP_STEP_1_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function signUpStep1():  Response
    {
        $raison_sociale = $_REQUEST["raison_sociale"];
        $telephone = $_REQUEST["telephone"];
        $site = $_REQUEST["site"];
        $fax = $_REQUEST["fax"];

        $entreprise = Session::get("entreprise") ?? new Entreprise();
        $entreprise->setRaisonSociale($raison_sociale);
        $entreprise->setTelephone($telephone);
        $entreprise->setSite($site);
        $entreprise->setFax($fax);
        Session::set("entreprise", $entreprise);

        if (UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous êtes déjà connecté",
                action: Action::HOME
            );
        }
        if (!Token::verify(Action::ENTREPRISE_SIGN_UP_STEP_1_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_SIGN_UP_STEP_1_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_SIGN_UP_STEP_1_FORM
            );
        }
        if (!Validate::isPhoneNumber($telephone)) {
            throw new ControllerException(
                message: "Le numéro de téléphone n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_1_FORM
            );
        }
        if (!Validate::isPhoneNumber($fax)) {
            throw new ControllerException(
                message: "Le numéro de fax n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_1_FORM
            );
        }
        if (!Validate::isName($raison_sociale)) {
            throw new ControllerException(
                message: "Le nom de l'entreprise n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_1_FORM
            );
        }
        if (!Validate::isUrl($site)) {
            throw new ControllerException(
                message: "L'url du site n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_1_FORM
            );
        }

        return new Response(
            action: Action::ENTREPRISE_SIGN_UP_STEP_2_FORM
        );
    }

    public function signUpStep2Form(): Response
    {
        if (UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous êtes déjà connecté",
                action: Action::HOME
            );
        }
        return new Response(
            template: "entreprise/sign-up-step-2.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "entreprise" => Session::get("entreprise"),
                "taille_entreprises" => array_column(array_map(fn($e) => $e->toArray(), (new TailleEntrepriseRepository)->select()), "libelle", "id_taille_entreprise"),
                "type_structures" => array_column(array_map(fn($e) => $e->toArray(), (new TypeStructureRepository())->select()), "libelle", "id_type_structure"),
                "statut_juridiques" => array_column(array_map(fn($e) => $e->toArray(), (new StatutJuridiqueRepository())->select()), "libelle", "id_statut_juridique"),
                "token" => Token::generateToken(Action::ENTREPRISE_SIGN_UP_STEP_2_FORM)
            ]
        );
    }

    public function signUpStep2(): Response
    {
        $siret = $_REQUEST["siret"];
        $code_naf = $_REQUEST["code_naf"];
        $id_taille_entreprise = $_REQUEST["id_taille_entreprise"];
        $id_type_structure = $_REQUEST["id_type_structure"];
        $id_statut_juridique = $_REQUEST["id_statut_juridique"];

        $entreprise = Session::get("entreprise") ?? new Entreprise();
        $entreprise->setSiret($siret);
        $entreprise->setCodeNaf($code_naf);
        $entreprise->setIdTailleEntreprise($id_taille_entreprise);
        $entreprise->setIdTypeStructure($id_type_structure);
        $entreprise->setIdStatutJuridique($id_statut_juridique);
        Session::set("entreprise", $entreprise);

        if (UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous êtes déjà connecté",
                action: Action::HOME
            );
        }
        if (!Token::verify(Action::ENTREPRISE_SIGN_UP_STEP_2_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_SIGN_UP_STEP_2_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_SIGN_UP_STEP_2_FORM
            );
        }
        if (!Validate::isSiret($siret)) {
            throw new ControllerException(
                message: "Le numéro de SIRET n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_2_FORM
            );
        }
        if (!Validate::isCodeNaf($code_naf)) {
            throw new ControllerException(
                message: "Le code NAF n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_2_FORM
            );
        }
        if (is_null((new TailleEntrepriseRepository)->getTailleEntrepriseById($id_taille_entreprise))) {
            throw new ControllerException(
                message: "La taille de l'entreprise n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_2_FORM
            );
        }
        if (is_null((new TypeStructureRepository)->getTypeStructureById($id_type_structure))) {
            throw new ControllerException(
                message: "Le type de structure n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_2_FORM
            );
        }
        if (is_null((new StatutJuridiqueRepository)->getStatutJuridiqueById($id_statut_juridique))) {
            throw new ControllerException(
                message: "Le statut juridique n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_2_FORM
            );
        }

        return new Response(
            action: Action::ENTREPRISE_SIGN_UP_STEP_3_FORM
        );
    }

    public function signUpStep3Form(): Response
    {
        if (UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous êtes déjà connecté",
                action: Action::HOME
            );
        }
        return new Response(
            template: "entreprise/sign-up-step-3.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "entreprise" => Session::get("entreprise"),
                "distributions_commune" => array_map(fn($distribution) => "{$distribution->getCommune()} ({$distribution->getCodePostal()})", (new DistributionCommuneRepository)->select()),
                "token" => Token::generateToken(Action::ENTREPRISE_SIGN_UP_STEP_3_FORM)
            ]
        );
    }

    public function signUpStep3(): Response
    {
        $numero_voie = $_REQUEST["numero_voie"];
        $id_distribution_commune = $_REQUEST["id_distribution_commune"];

        $entreprise = Session::get("entreprise") ?? new Entreprise();
        $entreprise->setNumeroVoie($numero_voie);
        $entreprise->setIdDistributioncommune($id_distribution_commune);
        Session::set("entreprise", $entreprise);

        if (UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous êtes déjà connecté",
                action: Action::HOME
            );
        }
        if (!Token::verify(Action::ENTREPRISE_SIGN_UP_STEP_3_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_SIGN_UP_STEP_3_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_SIGN_UP_STEP_3_FORM
            );
        }
        if (!Validate::isName($numero_voie)) {
            throw new ControllerException(
                message: "Le numéro et la voie n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_3_FORM
            );
        }
        if (is_null((new DistributionCommuneRepository)->getById($id_distribution_commune))) {
            throw new ControllerException(
                message: "Choisissez une distribution de commune valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_3_FORM
            );
        }

        return new Response(
            action: Action::ENTREPRISE_SIGN_UP_STEP_4_FORM
        );
    }

    public function signUpStep4Form(): Response
    {
        if (UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous êtes déjà connecté",
                action: Action::HOME
            );
        }
        return new Response(
            template: "entreprise/sign-up-step-4.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "entreprise" => Session::get("entreprise"),
                "token" => Token::generateToken(Action::ENTREPRISE_SIGN_UP_STEP_4_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     * @throws Exception
     */
    public function signUpStep4(): Response
    {
        $email = $_REQUEST["email"];
        $password = $_REQUEST["password"];
        $entreprise = Session::get("entreprise") ?? new Entreprise();
        $entreprise->setUnverifiedEmail($email);
        Session::set("entreprise", $entreprise);

        if (UserConnection::isSignedIn()) {
            throw new ControllerException(
                message: "Vous êtes déjà connecté",
                action: Action::HOME
            );
        }
        if (!Token::verify(Action::ENTREPRISE_SIGN_UP_STEP_4_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_SIGN_UP_STEP_4_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_SIGN_UP_STEP_4_FORM
            );
        }
        if (!Validate::isEmail($email)) {
            throw new ControllerException(
                message: "L'email n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_4_FORM
            );
        }
        if (!Validate::isPassword($password)) {
            throw new ControllerException(
                message: "Le mot de passe n'est pas valide",
                action: Action::ENTREPRISE_SIGN_UP_STEP_4_FORM
            );
        }
        if ($password !== $_REQUEST["confirm"]) {
            throw new ControllerException(
                message: "Les mots de passe ne correspondent pas",
                action: Action::ENTREPRISE_SIGN_UP_STEP_4_FORM
            );
        }

        if (is_null((new EntrepriseRepository)->getByEmail($email)))
            $entreprise->setNonce(EmailVerification::sendVerificationEmail($email));
        else EmailVerification::sendAlertEmail($email);

        $entreprise->setHashedPassword((Password::hash($password)));
        (new EntrepriseRepository)->insert($entreprise);
        UserConnection::signIn($entreprise);
        Session::delete("entreprise");
        FlashMessage::add("Veuillez vérifier votre email depuis votre boîte de réception", FlashType::INFO);
        return new Response(
            action: Action::HOME
        );
    }

    public function verifier(string $data): Response
    {
        $decodedData = Crypto::decrypt($data);
        $email = $decodedData["email"];
        $nonce = $decodedData["nonce"];
        $entreprise = (new EntrepriseRepository)->getByUnverifiedEmail($email);
        if (!EmailVerification::verify($entreprise, $nonce)) {
            throw new ControllerException(
                message: "Le lien de vérification n'est pas valide",
                action: Action::HOME
            );
        }
        UserConnection::signOut();

        $entreprise->setEmail($email);
        $entreprise->setUnverifiedEmail(new NullDataType);
        $entreprise->setNonce(new NullDataType);
        (new EntrepriseRepository)->update($entreprise);
        FlashMessage::add("Votre email a été vérifié avec succès", FlashType::SUCCESS);
        return new Response(
            action: Action::ENTREPRISE_SIGN_IN_FORM,
            params: [
                "email" => $email
            ]
        );
    }

    public function signInForm(string $email = null): Response
    {
        UserConnection::signOut();
        return new Response(
            template: "entreprise/sign-in.php",
            params: [
                "title" => "Connexion à un compte entreprise",
                "nav" => false,
                "footer" => false,
                "email" => $email,
                "token" => Token::generateToken(Action::ENTREPRISE_SIGN_IN_FORM)
            ]
        );
    }

    public function signIn(): Response {
        $email = $_REQUEST["email"];
        $password = $_REQUEST["password"];

        if (!Token::verify(Action::ENTREPRISE_SIGN_IN_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_SIGN_IN_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_SIGN_IN_FORM
            );
        }
        if (!Validate::isEmail($email)) {
            throw new ControllerException(
                message: "L'email n'est pas valide",
                action: Action::ENTREPRISE_SIGN_IN_FORM
            );
        }
        if (!Validate::isPassword($password)) {
            throw new ControllerException(
                message: "Le mot de passe n'est pas valide",
                action: Action::ENTREPRISE_SIGN_IN_FORM
            );
        }
        /**
         * @var Entreprise $entreprise
         */
        $entreprise = (new EntrepriseRepository)->getByEmail($email);
        if (is_null($entreprise) or !Password::verify($password, $entreprise->getHashedPassword())) {
            throw new ControllerException(
                message: "L'email ou le mot de passe est incorrect",
                action: Action::ENTREPRISE_SIGN_IN_FORM
            );
        }

        UserConnection::signIn($entreprise);
        FlashMessage::add("Vous êtes connecté", FlashType::SUCCESS);
        return new Response(
            action: Action::ENTREPRISE_AFFICHER_OFFRE
        );
    }

    public function offreAddForm(string $email = null): Response {
        if (UserConnection::isInstance(new Entreprise())) {
            return new Response(
                template: "entreprise/offre/add.php",
                params: [
                    "email" => $email,
                    "title" => "Création d'une offre",
                    "nav" => false,
                    "footer" => false,
                    "offre" => Session::get("offre") ?? new Offre(),
                    "unite_gratifications" => array_column(array_map(fn($e) => $e->toArray(), (new UniteGratificationRepository)->select()), "libelle", "id_unite_gratification"),
                    "token" => Token::generateToken(Action::ENTREPRISE_CREATION_OFFRE_FORM)
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function offreAdd(): Response{
        $description = $_REQUEST["description"];
        $secteur = $_REQUEST["secteur"];
        $thematique = $_REQUEST["thematique"];
        $taches = $_REQUEST["taches"];
        $commentaires = $_REQUEST["commentaires"];
        $gratification = $_REQUEST["gratification"];
        $id_unite_gratification = $_REQUEST["id_unite_gratification"];
        $type = $_REQUEST["emploi"];
        $date_debut = $_REQUEST["start"];
        $date_fin = $_REQUEST["end"];
        if(!$date_fin){
            $date_fin =null;
        }
        if(!$_REQUEST["checkbox"]){
            throw new ControllerException(
                message: "Niveau d'étude pas selectionner",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }

        if (count($_REQUEST["checkbox"]) == 1) {
            $niveau = $_REQUEST["checkbox"][0];
        }
        elseif (count($_REQUEST["checkbox"]) == 2) {
            $niveau = implode("&", $_REQUEST["checkbox"]);
        }
        else {
            $niveau = null;
        }

        if(!UserConnection::isInstance(new Entreprise())){
            throw new ControllerException(
                message: "Vous n'avez pas les droits",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        /**
         * @var Entreprise $entreprise
         */
        $entreprise = UserConnection::getSignedInUser();
        $offre = Session::set("offre", new Offre(
            description: $description,
            thematique: $thematique,
            secteur: $secteur,
            taches: $taches,
            commentaires: $commentaires,
            gratification: $gratification,
            type: $type,
            id_unite_gratification: $id_unite_gratification,
            id_entreprise: $entreprise->getIdEntreprise(),
            date_debut: $date_debut,
            date_fin: $date_fin,
            niveau: $niveau,
            valider: false,
        ));

        if (!Token::verify(Action::ENTREPRISE_CREATION_OFFRE_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_CREATION_OFFRE_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if(!UserConnection::isInstance(new Entreprise)){
            throw new ControllerException(
                message: "Vous n'êtes pas une entreprise",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isName($secteur)) {
            throw new ControllerException(
                message: "Le secteur n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isName($thematique)) {
            throw new ControllerException(
                message: "La thématique n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($description)) {
            throw new ControllerException(
                message: "La description n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($taches)) {
            throw new ControllerException(
                message: "Les fonctions et tâches ne sont pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($commentaires)) {
            throw new ControllerException(
                message: "Les commmentaires sur l'offre ne sont pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isFloat($gratification)) {
            throw new ControllerException(
                message: "La gratification n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (is_null(new UniteGratificationRepository($id_unite_gratification))) {
            throw new ControllerException(
                message: "L'unité de gratification n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if(!Validate::isNiveau($niveau)){
            throw new ControllerException(
                message: "Le niveau scolaire n'existe pas",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if($type!='alternance'){
            if(!Validate::isDateStage($date_debut,$date_fin,$niveau)){
                throw new ControllerException(
                    message: "Les dates de stages ne sont pas conforment",
                    action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
                );
            }
        }
        else{
            if(!Validate::isDate($date_debut) && !Validate::isDate($date_fin)){
                throw new ControllerException(
                    message: "Les dates ne sont pas au bon format",
                    action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
                );
            }
        }


        $id_offre = (new OffreRepository)->insert($offre);
        FlashMessage::add("L'offre a été ajoutée avec succès", FlashType::SUCCESS);

        Session::delete("offre");
        return new Response(
            action: Action::HOME,
        );
    }

    /**
     * @throws ControllerException
     */
    public static function afficherFormulaireMiseAJourOffre(string $id): Response
    {
        $user = UserConnection::getSignedInUser();
        $offre = (new OffreRepository)->getById($id);
        if (!$user) {
            throw new ControllerException(
                message: "Veillez vous connecter",
                action: Action::HOME
            );
        } else if (!UserConnection::isInstance(new Entreprise())) {
            throw new ControllerException(
                message: "Vous n'avez pas à acceder à cette page",
                action: Action::HOME
            );
        } else if (!($user->getIdEntreprise() == $offre->getIdEntreprise())) {
            throw new ControllerException(
                message: "Vous n'êtes pas la bonne entreprise pour modifier cette offre",
                action: Action::HOME
            );
        } else {
            return new Response(
                template: "entreprise/offre/add.php",
                params: [
                    "entreprise" => $user,
                    "offre" => $offre,
                    "token" => Token::generateToken(Action::ENTREPRISE_MODIFICATION_OFFRE_FORM),
                    "unite_gratifications" => array_column(array_map(fn($e) => $e->toArray(), (new UniteGratificationRepository())->select()), "libelle", "id_unite_gratification")
                ]
            );
        }
    }

    public static function mettreAJourOffre() : Response
    {
        $idOffre = $_REQUEST["id"];
        $offre = (new OffreRepository)->getById($idOffre);
        $description = $_REQUEST["description"];
        $secteur = $_REQUEST["secteur"];
        $thematique = $_REQUEST["thematique"];
        $taches = $_REQUEST["taches"];
        $commentaires = $_REQUEST["commentaires"];
        $gratification = $_REQUEST["gratification"];
        $id_unite_gratification = $_REQUEST["id_unite_gratification"];
        $type = $_REQUEST["emploi"];
        $date_debut = $_REQUEST["start"];
        $date_fin = $_REQUEST["end"];
        if(!$_REQUEST["checkbox"]){
            throw new ControllerException(
                message: "Niveau d'étude pas selectionner",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (count($_REQUEST["checkbox"]) == 1) {
            $niveau = $_REQUEST["checkbox"][0];
        }
        elseif (count($_REQUEST["checkbox"]) == 2) {
            $niveau = implode("&", $_REQUEST["checkbox"]);
        }
        else {
            $niveau = null;
        }
        $user = UserConnection::getSignedInUser();
        if (!Token::verify(Action::ENTREPRISE_MODIFICATION_OFFRE_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_MODIFICATION_OFFRE_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
            );
        }
        if(!$user){
            throw new ControllerException(
                message: "Veillez vous connecter",
                action: Action::HOME
            );
        }
        if(!UserConnection::isInstance(new Entreprise())){
            throw new ControllerException(
                message: "Vous n'avez pas à acceder à cette page",
                action: Action::HOME
            );
        }
        if (!($user->getIdEntreprise() == $offre->getIdEntreprise())) {
            throw new ControllerException(
                message: "Vous n'êtes pas la bonne entreprise pour modifier cette offre",
                action: Action::HOME
            );
        }
        if (!Validate::isName($secteur)) {
            throw new ControllerException(
                message: "Le secteur n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isName($thematique)) {
            throw new ControllerException(
                message: "La thématique n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($description)) {
            throw new ControllerException(
                message: "La description n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($taches)) {
            throw new ControllerException(
                message: "Les fonctions et tâches ne sont pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($commentaires)) {
            throw new ControllerException(
                message: "Les commmentaires sur l'offre ne sont pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isFloat($gratification)) {
            throw new ControllerException(
                message: "La gratification n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (is_null(new UniteGratificationRepository($id_unite_gratification))) {
            throw new ControllerException(
                message: "L'unité de gratification n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if(!Validate::isNiveau($niveau)){
            throw new ControllerException(
                message: "Le niveau scolaire n'existe pas",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if($type!='alternance'){
            if(!Validate::isDateStage($date_debut,$date_fin,$niveau)){
                throw new ControllerException(
                    message: "Les dates de stages ne sont pas conforment",
                    action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
                );
            }
        }
        else{
            if(!Validate::isDate($date_debut) && !Validate::isDate($date_fin)){
                throw new ControllerException(
                    message: "Les dates ne sont pas au bon format",
                    action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
                );
            }
        }

        $o = new Offre($idOffre, $description, $thematique,$secteur , $taches, $commentaires, $gratification,$type , null,$id_unite_gratification, $user->getIdEntreprise(),$date_debut,$date_fin,$niveau,$offre->getValider());
        (new OffreRepository())->update($o);
        return new Response(
            action: Action::HOME,
        );
    }

    public static function deleteOffre() : Response{
        $id = $_REQUEST["id"];
        $offre = (new OffreRepository())->getById($id);
        $user = UserConnection::getSignedInUser();
        if($user and (UserConnection::isInstance(new Admin())) or (UserConnection::isInstance(new Entreprise) and $user->getIdEntreprise() == $offre->getIdEntreprise())){
            $condition = new QueryCondition("id_offre",ComparisonOperator::EQUAL,$id);
            (new OffreRepository())->delete($condition);
            return new Response(
                action: Action::HOME,
            );
        }
        else{
            throw new ControllerException(
                message: "Vous n'avez pas les droits de supprimer cette offre",
                action: Action::HOME
            );
        }
    }

    public static function accepterEtudiantOffre():Response{
        $id = $_REQUEST["id"];
        $etudiant = $_REQUEST["login"];
        $offre = (new OffreRepository())->getById($id);
        $user = UserConnection::getSignedInUser();
        if($user and UserConnection::isInstance(new Entreprise) and $user->getIdEntreprise() == $offre->getIdEntreprise()){
            $offre->setLogin($etudiant);
            (new OffreRepository())->update($offre);
            $condition = [
                new QueryCondition("login", ComparisonOperator::EQUAL,$etudiant,LogicalOperator::AND),
                new QueryCondition("id_offre", ComparisonOperator::EQUAL,$id)
            ];
            (new PostulerRepository())->delete($condition);
            FlashMessage::add("Etudiant accepter avec success", FlashType::SUCCESS);
            return new Response(
                action: Action::HOME,
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    public static function afficherOffreEntreprise(): Response
    {
        if (UserConnection::isInstance(new Entreprise())) {
            $user = UserConnection::getSignedInUser();
            $idEntreprise = $user->getIdEntreprise();
            $condition = new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $idEntreprise);
            $listeoffres = (new OffreRepository())->getOffresDetailsAvecCategories();
            $liste_offre = (new OffreRepository())->select($condition);
            $idOffres =  [];
            foreach ($liste_offre as $offre){
                $idOffres [] = $offre->getIdOffre();
            }
            return new Response(
                template: "entreprise/offre/liste-offre.php",
                params: [
                    "title" => "Liste des offres",
                    "listeoffres" => $listeoffres,
                    "idOffres" => $idOffres,
                    "nbRechercheTrouver" => count($idOffres),
                    "selB" => null,
                    "search" => null
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    public static function afficherPostuleEtudiantAll():Response{
        if (UserConnection::isInstance(new Entreprise())) {
            $result = (new EntrepriseRepository())->getOffreEntreprise(UserConnection::getSignedInUser()->getIdEntreprise());
            $offre = $result['offre'];
            $personne = [];

            foreach ($offre as $id) {
                $condition = new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id);
                $liste_offrePostuler = (new PostulerRepository())->select($condition);
                $personne[] = $liste_offrePostuler;
            }

            return new Response(
                template: "entreprise/offre/etudiant_postulant_offre.php",
                params: [
                    "title" => "Voir les candidats ayant postulé à nos offre",
                    "postuler"=>$personne
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    public static function voirAPostuler():Response{
        if(UserConnection::isSignedIn()){
            $id = $_REQUEST["id"];
            $offre = (new OffreRepository())->getById($id);
            $user = UserConnection::getSignedInUser();
            if($user and $offre and UserConnection::isInstance(new Entreprise) and $user->getIdEntreprise() == $offre->getIdEntreprise()){
                $condition = new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id);
                $liste_offrePostuler = (new PostulerRepository())->select($condition);
                return new Response(
                    template: "entreprise/offre/etudiant_postulant_offre.php",
                    params: [
                        "title" => "Liste des etudiant ayant postuler",
                        "postuler" => $liste_offrePostuler,
                    ]
                );
            }
            return new Response(
                action: Action::HOME,
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

}