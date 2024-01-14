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
use Stageo\Lib\Mailer\Email;
use Stageo\Lib\Mailer\Mailer;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Crypto;
use Stageo\Lib\Security\EmailVerification;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\Categorie;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\DeCategorie;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Offre;
use Stageo\Model\Object\Secretaire;
use Stageo\Model\Repository\CategorieRepository;
use Stageo\Model\Repository\ConventionRepository;
use Stageo\Model\Repository\DeCategorieRepository;
use Stageo\Model\Repository\DistributionCommuneRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\PostulerRepository;
use Stageo\Model\Repository\StatutJuridiqueRepository;
use Stageo\Model\Repository\SuiviRepository;
use Stageo\Model\Repository\TailleEntrepriseRepository;
use Stageo\Model\Repository\TypeStructureRepository;
use Stageo\Model\Repository\UniteGratificationRepository;
use function Sodium\add;

class EntrepriseController
{
    /**
     * Affiche le formulaire de la première étape d'inscription pour une entreprise.
     *
     * @return Response
     */
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
     * Traite la troisième étape du processus d'inscription pour une entreprise.
     * @return Response
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

    /**
     * Affiche le formulaire de la deuxième étape d'inscription pour une entreprise.
     *
     * @return Response
     */
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

    /**
     * Traite la deuxième étape du processus d'inscription pour une entreprise.
     *
     * @return Response
     */
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

    /**
     * Affiche le formulaire de la troisième étape d'inscription pour une entreprise.
     *
     * @return Response
     */
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

    /**
     * Traite la troisième étape du processus d'inscription pour une entreprise.
     *
     * @return Response
     */
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

    /**
     * Affiche le formulaire de la quatrième étape d'inscription pour une entreprise.
     *
     * @return Response
     */
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
     * @return Response
     *@throws ControllerException
     * @throws InvalidTokenException
     * @throws Exception
     * Traite le formulaire de la quatrième étape d'inscription pour une entreprise.
     *
     * @throws TokenTimeoutException
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

    /**
     * Vérifie l'email de l'entreprise après qu'elle a suivi le lien de vérification.
     *
     * @param string $data Données cryptées nécessaires pour la vérification.
     * @return Response
     */
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

    /**
     * Affiche le formulaire de connexion pour une entreprise.
     */
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

    /**
     * Gère le processus de connexion d'une entreprise.
     *
     * Cette fonction récupère les paramètres de la requête, tels que l'email et le mot de passe,
     * puis effectue plusieurs vérifications pour s'assurer de la validité des données fournies.
     * Elle utilise la classe Token pour vérifier la validité du jeton de sécurité associé au formulaire.
     * Si toutes les vérifications passent, elle tente de récupérer l'entreprise correspondant à l'email fourni
     * depuis la base de données et vérifie si le mot de passe correspond.
     * En cas de succès, elle connecte l'entreprise, ajoute un message flash de succès
     * et redirige vers la page d'affichage des offres de l'entreprise connectée.
     *
     * @return Response
     * @throws InvalidTokenException si le jeton de sécurité est invalide.
     * @throws TokenTimeoutException si le jeton de sécurité a expiré.
     * @throws ControllerException si l'email ou le mot de passe fourni est incorrect,
     *                             ou si une erreur survient lors de la connexion de l'entreprise.
     */
    public function signIn(): Response {
        // Récupérer les paramètres de la requête
        $email = $_REQUEST["email"];
        $password = $_REQUEST["password"];

        //Vérification des informations
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

    /**
     * Affiche le formulaire de création d'une nouvelle offre.
     *
     * Cette fonction vérifie d'abord si l'utilisateur est une instance de l'entreprise.
     * Si c'est le cas, elle renvoie une Response contenant le formulaire de création d'une nouvelle offre
     * avec les données précédemment saisies si elles existent en session.
     * Les catégories et les unités de gratification disponibles sont également récupérées pour le formulaire.
     *
     * @param string|null $email Adresse e-mail optionnelle à afficher dans le formulaire.
     * @return Response
     * @throws ControllerException si l'utilisateur n'a pas les droits d'accéder à la page d'accueil.
     */
    public function offreAddForm(string $email = null): Response
    {
        if (UserConnection::isInstance(new Entreprise())) {
            return new Response(
                template: "entreprise/offre/add.php",
                params: [
                    "email" => $email,
                    "title" => "Création d'une offre",
                    "nav" => false,
                    "footer" => false,
                    "offre" => Session::get("offre") ?? new Offre(),
                    "liste_tag_choisi" => Session::get("tags") ?? [],
                    "liste_tag" => array_column(array_map(fn($e) => $e->toArray(), (new CategorieRepository)->select()), "libelle"),
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
     * Ajoute une nouvelle offre à partir des paramètres de la requête.
     *
     * Cette fonction récupère les paramètres nécessaires à la création d'une offre depuis la requête.
     * Elle effectue des vérifications sur ces paramètres, notamment sur la validité des données, la présence du niveau d'étude,
     * la vérification des tokens, etc.
     * Si toutes les vérifications sont réussies, elle insère l'offre dans la base de données et associe les catégories sélectionnées.
     * Enfin, elle renvoie une Response redirigeant vers la page d'accueil avec un message de succès.
     *
     * @return Response
     * @throws ControllerException si des erreurs surviennent lors de la création de l'offre.
     * @throws TokenTimeoutException
     * @throws InvalidTokenException
     */
    public function offreAdd(): Response{
        // Récupérer les paramètres de la requête
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
        $selectedTags = $_REQUEST["selectedTags"];

        if(!$date_fin){
            $date_fin =null;
        }

        // Vérifier si le niveau d'étude est sélectionné
        if(!$_REQUEST["checkbox"]){
            throw new ControllerException(
                message: "Niveau d'étude pas selectionner",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }

        // Construire la chaîne du niveau d'étude en fonction du nombre de cases cochées
        if (count($_REQUEST["checkbox"]) == 1) {
            $niveau = $_REQUEST["checkbox"][0];
        }
        elseif (count($_REQUEST["checkbox"]) == 2) {
            $niveau = implode("&", $_REQUEST["checkbox"]);
        }
        else {
            $niveau = null;
        }

        // Vérifier si l'utilisateur est une instance de l'entreprise
        if(!UserConnection::isInstance(new Entreprise())){
            throw new ControllerException(
                message: "Vous n'avez pas les droits",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        /**
         * @var Entreprise $entreprise
         */
        //Enregistrer l'offre dans le session pour l'autocomplétion en cas d'erreur
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

        $selectedTags = Session::set("tags",$selectedTags);

        //Vérification des différentes informations
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
        if (!Validate::isGratification($gratification)) {
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
        if($type=='stage' or $type=='Stage'){
            if(!Validate::isDateStage($date_debut,$date_fin,$niveau)){
                throw new ControllerException(
                    message: "Les dates de stages ne sont pas conformes",
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

        foreach ($selectedTags as $tag){
            $categorie = (new CategorieRepository())->getByLibelle($tag);
            $id_categorie = $categorie->getIdCategorie();
            (new DeCategorieRepository())->insert(new DeCategorie($id_categorie,$id_offre));
        }

        FlashMessage::add("L'offre a été ajoutée avec succès", FlashType::SUCCESS);

        Session::delete("offre");
        Session::delete("tags");
        return new Response(
            action: Action::HOME,
        );
    }

    /**
     * Affiche le formulaire de mise à jour d'une offre.
     *
     * Cette fonction récupère l'utilisateur connecté, l'identifiant de l'offre à mettre à jour, et l'offre correspondante.
     * Elle effectue des vérifications sur la validité de l'utilisateur et de l'offre avant de construire la liste des tags déjà choisis.
     * Enfin, elle renvoie une Response contenant le template du formulaire de mise à jour avec les paramètres nécessaires.
     *
     * @return Response
     * @throws ControllerException si l'accès à la page est refusé ou si des erreurs se produisent.
     */
    public static function afficherFormulaireMiseAJourOffre(): Response
    {
        $user = UserConnection::getSignedInUser();
        $id = $_REQUEST["id"];
        $offre = (new OffreRepository)->getById($id);

        //Vérification
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
            // Construire la liste des tags déjà choisis pour l'offre
            $selectedTags = (new DeCategorieRepository)->select(new QueryCondition("id_offre",ComparisonOperator::EQUAL,$id));
            $idCategorie = [];

            foreach ($selectedTags as $tag){
                $idCategorie[] = $tag->getIdCategorie();
            }

            // Construire la liste des noms des tags choisis
            $nomTag = [];

            foreach ($idCategorie as $tag){
                $t = (new CategorieRepository())->select(new QueryCondition("id_categorie",ComparisonOperator::EQUAL,$tag));
                $nomTag[] = $t[0]->getLibelle();
            }

            return new Response(
                template: "entreprise/offre/add.php",
                params: [
                    "entreprise" => $user,
                    "offre" => $offre,
                    "nav" => false,
                    "footer" => false,
                    "liste_tag" => array_column(array_map(fn($e) => $e->toArray(), (new CategorieRepository)->select()), "libelle"),
                    "liste_tag_choisi" => $nomTag,
                    "token" => Token::generateToken(Action::ENTREPRISE_MODIFICATION_OFFRE_FORM),
                    "unite_gratifications" => array_column(array_map(fn($e) => $e->toArray(), (new UniteGratificationRepository())->select()), "libelle", "id_unite_gratification")
                ]
            );
        }
    }

    /**
     * Met à jour une offre dans la base de données.
     *
     * Cette fonction récupère les paramètres de la requête pour mettre à jour les informations d'une offre.
     * Elle effectue des vérifications sur les données et les permissions de l'utilisateur avant la mise à jour.
     * Si les conditions sont remplies, elle crée un nouvel objet Offre avec les nouvelles données,
     * gère les catégories associées à l'offre, puis met à jour l'offre dans la base de données.
     * Enfin, elle redirige l'utilisateur vers la page d'accueil.
     *
     * @return Response
     * @throws ControllerException si l'accès à la page est refusé ou si des erreurs de validation se produisent.
     */
    public static function mettreAJourOffre() : Response
    {
        // Récupérer les paramètres de la requête
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
        $selectedTags = $_REQUEST["selectedTags"];

        // Vérifier si le niveau d'étude a été sélectionné
        if(!$_REQUEST["checkbox"]){
            throw new ControllerException(
                message: "Niveau d'étude pas selectionner",
                action: Action::ENTREPRISE_MODIFICATION_OFFRE,
                params: ["id"=>$idOffre]
            );
        }

        // Déterminer le niveau d'étude en fonction de la sélection
        if (count($_REQUEST["checkbox"]) == 1) {
            $niveau = $_REQUEST["checkbox"][0];
        }
        elseif (count($_REQUEST["checkbox"]) == 2) {
            $niveau = implode("&", $_REQUEST["checkbox"]);
        }
        else {
            $niveau = null;
        }

        //Vérification des différentes informations
        $user = UserConnection::getSignedInUser();
        if (!Token::verify(Action::ENTREPRISE_MODIFICATION_OFFRE_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_MODIFICATION_OFFRE_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
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
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
            );
        }
        if (!Validate::isName($thematique)) {
            throw new ControllerException(
                message: "La thématique n'est pas valide",
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
            );
        }
        if (!Validate::isText($description)) {
            throw new ControllerException(
                message: "La description n'est pas valide",
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
            );
        }
        if (!Validate::isText($taches)) {
            throw new ControllerException(
                message: "Les fonctions et tâches ne sont pas valide",
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
            );
        }
        if (!Validate::isText($commentaires)) {
            throw new ControllerException(
                message: "Les commmentaires sur l'offre ne sont pas valide",
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
            );
        }
        if (!Validate::isFloat($gratification)) {
            throw new ControllerException(
                message: "La gratification n'est pas valide",
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
            );
        }
        if (is_null(new UniteGratificationRepository($id_unite_gratification))) {
            throw new ControllerException(
                message: "L'unité de gratification n'est pas valide",
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
            );
        }
        if(!Validate::isNiveau($niveau)){
            throw new ControllerException(
                message: "Le niveau scolaire n'existe pas",
                action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                params: ["id"=>$idOffre]
            );
        }
        if($type=='stage' or $type=='Stage'){
            if(!Validate::isDateStage($date_debut,$date_fin,$niveau)){
                throw new ControllerException(
                    message: "Les dates de stages ne sont pas conforment",
                    action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                    params: ["id"=>$idOffre]
                );
            }
        }
        else{
            if(!Validate::isDate($date_debut) && !Validate::isDate($date_fin)){
                throw new ControllerException(
                    message: "Les dates ne sont pas au bon format",
                    action: Action::ENTREPRISE_MODIFICATION_OFFRE_FORM,
                    params: ["id"=>$idOffre]
                );
            }
        }
        if ($type == "Stage&Alternance" || $type == "Alternance"){
            $date_fin = null;
        }

        // Créer un nouvel objet Offre avec les nouvelles données
        $o = new Offre($idOffre, $description, $thematique,$secteur , $taches, $commentaires, $gratification,$type , null,$id_unite_gratification, $user->getIdEntreprise(),$date_debut,$date_fin,$niveau,$offre->getValider());

        // Récupérer les catégories associées à l'offre avant la mise à jour
        $tags = (new DeCategorieRepository)->select(new QueryCondition("id_offre",ComparisonOperator::EQUAL,$idOffre));
        $idCategorie_avant = [];
        $idCategorie_apres = [];

        foreach ($tags as $tag){
            $idCategorie_avant[] = $tag->getIdCategorie();
        }

        foreach ($selectedTags as $tag){
            $categorie = (new CategorieRepository())->getByLibelle($tag);
            $idCategorie_apres[] = $categorie->getIdCategorie();
        }

        // Gérer les catégories associées avant et après la mise à jour
        foreach ($idCategorie_apres as $c){
            if(!in_array($c, $idCategorie_avant)){
                (new DeCategorieRepository())->insert(new DeCategorie($c,$idOffre));
            }
            else{
                $key = array_search($c, $idCategorie_avant);
                if ($key !== false) {
                    unset($idCategorie_avant[$key]);
                }
            }
            $key = array_search($c, $idCategorie_apres);
            if ($key !== false) {
                unset($idCategorie_apres[$key]);
            }
        }

        // Supprimer les catégories associées qui ne sont plus sélectionnées
        foreach($idCategorie_avant as $c){
            $condition = [new QueryCondition("id_offre",ComparisonOperator::EQUAL,$idOffre, LogicalOperator::AND),
                new QueryCondition("id_categorie",ComparisonOperator::EQUAL,$c)
            ];
            (new DeCategorieRepository())->delete($condition);
        }

        // Mettre à jour l'offre dans la base de données et redirection
        (new OffreRepository())->update($o);
        return new Response(
            action: Action::HOME,
        );
    }

    public function gestionEtudiant(): Response
    {
        /**
         * @var Etudiant $etu
         * @var Convention $convention[]
         */
        $user = UserConnection::getSignedInUser();
        if (($user instanceof Entreprise)){
            $offres = (new EntrepriseRepository())->getOffreEntreprise($user->getIdEntreprise())["offre"];
            /**
            * @var Offre $ofr
             * @var Etudiant[] $etudiants
             */
            $etudiants = [];
            foreach ($offres as $ofr){
                $offre = (new OffreRepository())->getById($ofr);
                /**
                 * @var Offre $offre
                */
                if ($offre->getLogin()!=null) {
                    $etudiants[] = (new EtudiantRepository())->getByLogin($offre->getLogin());
                }
            }
            $param["etudiants"] = $etudiants;
            if ($etudiants != null) {
                foreach ($etudiants as $etu) {
                    $nbcandidature[$etu->getlogin()] = (new EtudiantRepository())->getnbcandatures($etu->getlogin());
                    if ($nbcandidature[$etu->getlogin()] === null) {
                        $nbcandidature[$etu->getlogin()] = 0;
                    }
                    $conventions[$etu->getlogin()] = (new ConventionRepository())->getByLogin($etu->getlogin());
                    if ($conventions[$etu->getLogin()]) {
                        $suivies[$etu->getLogin()] = (new SuiviRepository())->getByIdConvention($conventions[$etu->getLogin()]->getIdConvention());
                    }
                    $condition = new QueryCondition("login", ComparisonOperator::EQUAL, $etu->getLogin());
                    $liste_accepter = (new OffreRepository())->select($condition);
                    $nbaccepter[$etu->getlogin()] = sizeof($liste_accepter);
                    if ($nbaccepter[$etu->getlogin()] === null) {
                        $nbaccepter[$etu->getlogin()] = 0;
                    }
                }
                $param["nbaccepter"] = $nbaccepter;
                $param["nbcandidature"] = $nbcandidature;
                $param["conventions"] = $conventions;
                $param["suivies"] = $suivies;
            }
            return new Response(
                template: "admin/gestionEtudiants.php",
                params: $param
            );
        }
        return new Response(
            template: "admin/sign-in.php",
            params: [
                "title" => "Se connecter",
                "nav" => false,
                "footer" => false,
                "token" => Token::generateToken(Action::ADMIN_SIGN_IN_FORM)
            ]
        );
    }

    public function validerconvention(){
        $user = UserConnection::getSignedInUser();
        $convention = (new ConventionRepository())->getById($_REQUEST["idConv"]);
        /**
         * @var Convention $convention
         */
        if (($user instanceof  Entreprise && $user->getIdEntreprise()== $convention->getIdEntreprise())) {
            if (!$convention->getVerificationEntreprise()) {
                $convention->setVerificationEntreprise(true);
                (new ConventionRepository())->update($convention);
                $etu = (new EtudiantRepository())->getByLogin($convention->getLogin());
                /**
                 * @var Etudiant $etu
                 */
                $email = $etu->getEmail();
                $email = new Email($email,"Validation de l'entreprise de votre convention","Bonjour, nous vous informons que votre convention a était validé par l'entreprise");
                (new Mailer())->send($email);
                FlashMessage::add(
                    content: "Convention envoyer au secretariat!",
                    type: FlashType::SUCCESS
                );
                return $this->gestionEtudiant();
            }
            FlashMessage::add(
                content: "déjà validé !",
                type: FlashType::ERROR
            );
            return $this->gestionEtudiant();
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette action",
            action: Action::HOME,
        );
    }

    /**
     * @throws ControllerException
     */
    public function invaliderconvention(){
        $user = UserConnection::getSignedInUser();
        $convention = (new ConventionRepository())->getById($_REQUEST["idConv"]);
        /**
         * @var Convention $convention
         */
        if (($user instanceof  Entreprise && $user->getIdEntreprise()== $convention->getIdEntreprise())) {
            /**
             * @var Convention $convention
             */
            (new ConventionRepository())->delete([new QueryCondition("id_convention", ComparisonOperator::EQUAL, $convention->getIdConvention())]);
            $etu = (new EtudiantRepository())->getByLogin($convention->getLogin());
            /**
             * @var Etudiant $etu
             */
            $email = $etu->getEmail();
            $raison = $_REQUEST["raisonRefus"];
            $email = new Email($email,"Refus de votre convention par l'entreprise","Bonjour, nous vous informons que votre convention a était refusé par l'entreprise pour les raisons suivantes : <br> <br>".$raison);
            (new Mailer())->send($email);
            FlashMessage::add(
                content: "Convention invalidé!",
                type: FlashType::SUCCESS
            );
            return $this->gestionEtudiant();
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette action",
            action: Action::HOME,
        );

    }

    /**
     * Supprime une offre.
     *
     * Cette fonction permet à un utilisateur autorisé de supprimer une offre spécifique.
     * Elle vérifie si l'utilisateur est connecté, s'il est une instance d'un administrateur ou d'une entreprise,
     * et s'il appartient à la même entreprise que l'offre (dans le cas d'une entreprise).
     * Si ces conditions sont remplies, elle supprime l'offre correspondante, puis redirige l'utilisateur vers la page d'accueil.
     *
     * @return Response
     * @throws ControllerException si l'accès à la page est refusé.
     */
    public static function deleteOffre() : Response{
        // Récupérer les paramètres de la requête
        $id = $_REQUEST["id"];
        $offre = (new OffreRepository())->getById($id);
        $user = UserConnection::getSignedInUser();

        /* Vérifier si l'utilisateur est connecté, est une instance d'Entreprise ou d'Admin
        et s'il appartient à la même entreprise que l'offre si c'est une Entreprise*/
        if($user and (UserConnection::isInstance(new Admin())) or (UserConnection::isInstance(new Entreprise) and $user->getIdEntreprise() == $offre->getIdEntreprise())){
            $condition = new QueryCondition("id_offre",ComparisonOperator::EQUAL,$id);
            (new OffreRepository())->delete($condition);
            return new Response(
                action: Action::HOME,
            );
        }
        else{
            // Si les conditions ne sont pas remplies, générer une exception de contrôleur avec un message d'erreur
            throw new ControllerException(
                message: "Vous n'avez pas les droits de supprimer cette offre",
                action: Action::HOME
            );
        }
    }

    /**
     * Accepte la candidature d'un étudiant pour une offre.
     *
     * Cette fonction permet à une entreprise de valider la candidature d'un étudiant pour une offre spécifique.
     * Elle vérifie si l'utilisateur est connecté, s'il est une instance d'une entreprise, et s'il appartient à la même entreprise
     * que l'offre en question. Si ces conditions sont remplies, elle met à jour l'offre avec le login de l'étudiant accepté,
     * supprime l'enregistrement correspondant dans la table Postuler, envoie un email d'acceptation à l'étudiant,
     * affiche un message de succès, puis redirige l'utilisateur vers la page d'accueil.
     *
     * @return Response
     * @throws ControllerException si l'accès à la page est refusé.
     */
    public static function accepterEtudiantOffre() : Response
    {
        /**
         * @var Etudiant $etudiant
         * @var Offre $offre
         */
        // Récupérer les paramètres de la requête
        $id = $_REQUEST["id"];
        $login = $_REQUEST["login"];

        $offre = (new OffreRepository())->getById($id);
        $user = UserConnection::getSignedInUser();
        /* Vérifier si l'utilisateur est connecté, est une instance de Entreprise et s'il appartient à la même entreprise que l'offre*/
        if($user and UserConnection::isInstance(new Entreprise) and $user->getIdEntreprise() == $offre->getIdEntreprise()){
            $offre->setLogin($login);
            (new OffreRepository())->update($offre);

            // Préparer des conditions pour supprimer l'enregistrement correspondant dans la table Postuler
            $condition = [
                new QueryCondition("login", ComparisonOperator::EQUAL,$login,LogicalOperator::AND),
                new QueryCondition("id_offre", ComparisonOperator::EQUAL,$id)
            ];
            (new PostulerRepository())->delete($condition);
            $etudiant = (new EtudiantRepository())->getByLogin($login);

            // Envoyer un email à l'étudiant pour informer de l'acceptation de sa candidature
            Mailer::send(new Email(
                $etudiant->getEmail(),
                "Votre candidature a été accepté",
                "Votre candidature a été accepté pour l'offre " . $offre->getThematique()
            ));
            FlashMessage::add("Etudiant accepter avec succès", FlashType::SUCCESS);

            // Rediriger l'utilisateur vers la page d'accueil
            return new Response(
                action: Action::HOME,
            );
        }
        // Si les conditions ne sont pas remplies, générer une exception de contrôleur avec un message d'erreur
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette page.",
            action: Action::HOME
        );
    }

    /**
     * Affiche la liste des offres de l'entreprise connectée.
     *
     * Cette fonction est destinée aux entreprises pour visualiser la liste de toutes les offres qu'elles ont publiées.
     * Elle récupère l'identifiant de l'entreprise connectée, sélectionne toutes les offres correspondantes à cet identifiant,
     * et prépare les données nécessaires pour l'affichage.
     *
     * @return Response
     * @throws ControllerException si l'accès à la page est refusé.
     */
    public static function mesOffres(): Response
    {
        if (UserConnection::isInstance(new Entreprise())) {
            $user = UserConnection::getSignedInUser();
            $idEntreprise = $user->getIdEntreprise();
            $condition = new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $idEntreprise);
            $listeoffres = (new OffreRepository())->getOffresDetailsAvecCategoriesByIdEntreprise("%%");
            $liste_offre = (new OffreRepository())->select($condition);
            $idOffres =  [];
            foreach ($liste_offre as $offre){
                $idOffres [] = $offre->getIdOffre();
            }
            $Categories = (new CategorieRepository())->select();
            return new Response(
                template: "entreprise/offre/liste-offre.php",
                params: [
                    "title" => "Liste des offres",
                    "listeoffres" => $listeoffres,
                    "idOffres" => $idOffres,
                    "Categories" => $Categories,
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

    /**
     * Affiche la liste des candidats ayant postulé à toutes les offres de l'entreprise.
     *
     * Cette fonction est destinée aux entreprises pour visualiser tous les candidats ayant postulé à leurs offres.
     * Elle récupère toutes les offres de l'entreprise connectée, puis pour chaque offre, elle sélectionne les candidats
     * ayant postulé à cette offre.
     *
     * @return Response
     * @throws ControllerException si l'accès à la page est refusé.
     */
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

    /**
     * Affiche la liste des étudiants ayant postulé à une offre spécifique, regroupée par offre.
     *
     * Cette fonction nécessite que l'utilisateur soit connecté en tant qu'entreprise et que les conditions
     * spécifiques soient remplies pour accéder à la liste des étudiants postulants à une offre.
     *
     * @return Response
     * @throws ControllerException si l'accès à la page est refusé.
     */
    public static function voirAPostuler():Response{
        if(UserConnection::isSignedIn()){
            // Récupérer l'ID de l'offre depuis la requête
            $id = $_REQUEST["id"];

            $offre = (new OffreRepository())->getById($id);
            $user = UserConnection::getSignedInUser();

            // Vérifier si les conditions pour accéder à la liste sont remplies
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

    /**
     * Supprime le compte de l'entreprise connectée.
     *
     * @return Response
     */
    public static function delete(){
        $user = UserConnection::getSignedInUser();
        $id =  $_REQUEST["idEntreprise"];
        if ($user instanceof Entreprise && $user->getIdEntreprise() == $id){
            (new EntrepriseRepository())->delete([new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $id)]);
            UserConnection::signOut();
            return new Response(
                action: Action::HOME
            );
        }
        throw new ControllerException(
            message: "Vous n'avez pas accès à cette action.",
            action: Action::HOME
        );
    }

    /**
     * Affiche la page du tutoriel destiné aux entreprises.
     *
     * @return Response
     */
    public static function tutorielEntreprise(): Response
    {
        return new Response(
            template: "entreprise/tutoriel.php",
            params: [
                "title" => "Tutoriel entreprise",
            ]
        );
    }

}