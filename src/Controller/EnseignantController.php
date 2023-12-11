<?php

namespace Stageo\Controller;

    use Stageo\Controller\Exception\ControllerException;
    use Stageo\Controller\Exception\InvalidTokenException;
    use Stageo\Controller\Exception\TokenTimeoutException;
    use Stageo\Lib\Database\ComparisonOperator;
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
    use Stageo\Model\Repository\DistributionCommuneRepository;
    use Stageo\Model\Repository\EntrepriseRepository;
    use Stageo\Model\Repository\EtudiantRepository;
    use Stageo\Model\Repository\ConventionRepository;
    use Stageo\Model\Repository\OffreRepository;
    use Stageo\Model\Repository\PostulerRepository;
    use Stageo\Model\Repository\UniteGratificationRepository;

class EnseignantController
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
        if (!Token::verify(Action::ETUDIANT_SIGN_IN_FORM, $_REQUEST["token"]))
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
        );
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

    public function conventionAddForm(String $login = null): Response
    {
        return new Response(
            template: "etudiant/conventionAdd.php",
            params: [
                "title" => "Déposer une convention",
                "nav" => true,
                "footer" => true,
                "login" => $login,
                "convention" => Session::get("convention") ?? new Convention(),
                "distributions_commune" => array_reduce((new DistributionCommuneRepository)->select(), fn($carry, $distribution) => $carry + [$distribution->getIdDistributionCommune() => "{$distribution->getCommune()} ({$distribution->getCodePostal()})"], []),
                "gratification" => 4.35,
                "unite_gratifications" => array_column(array_map(fn($e) => $e->toArray(), (new UniteGratificationRepository)->select()), "libelle", "id_unite_gratification"),
                "token" => Token::generateToken(Action::ETUDIANT_CONVENTION_ADD),
            ]
        );
    }
    public function conventionAdd(): Response
    {
        /**
         * @var Etudiant $etudiant
         */
        $etudiant = UserConnection::getSignedInUser();
        //TODO: Enlever la ligne du dessous une fois qu'il y aura une vérification pour que l'étudiant soit connecté
        $etudiant = new Etudiant("levys");
        $type_convention = $_REQUEST["type_convention"];
        $annee_universitaire = $_REQUEST["annee_universitaire"];
        $origine_stage = $_REQUEST["origine_stage"];
        $sujet = $_REQUEST["sujet"];
        $taches = $_REQUEST["taches"];
        $date_debut = $_REQUEST["date_debut"];
        $date_fin = $_REQUEST["date_fin"];
        $gratification = $_REQUEST["gratification"];
        $id_unite_gratification = $_REQUEST["id_unite_gratification"];
        $numero_voie = $_REQUEST["numero_voie"];
        $id_distribution_commune = $_REQUEST["id_distribution_commune"];
        $convention = new Convention(
            login: $etudiant->getLogin(),
            type_convention: $type_convention,
            origine_stage: $origine_stage,
            annee_universitaire: $annee_universitaire,
            sujet: $sujet,
            taches: $taches,
            date_debut: $date_debut,
            date_fin: $date_fin,
            gratification: $gratification,
            id_unite_gratification: $id_unite_gratification,
            numero_voie: $numero_voie,
            id_distribution_commune: $id_distribution_commune
        );

        if (!Token::verify(Action::ETUDIANT_CONVENTION_ADD, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ETUDIANT_CONVENTION_ADD)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_CONVENTION_ADD,
                params: ["convention" => $convention]
            );
        }
        (new ConventionRepository)->insert($convention);
        FlashMessage::add(
            content: "Convention ajoutée avec succès",
            type: FlashType::SUCCESS
        );
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
        $offre->setValiderParEtudiant(true);
        (new OffreRepository)->update($offre);
        $postuler = (new PostulerRepository())->select(new QueryCondition("login",ComparisonOperator::EQUAL,$etudiant->getLogin()));
        $offres =  (new OffreRepository())->select(new QueryCondition("login",ComparisonOperator::EQUAL,$etudiant->getLogin()));
        foreach($offres as $o){
            if ($o->getIdOffre != $idOffre){
                $o->setLogin(Null);
                (new OffreRepository())->update($o);
            }
        }
        foreach($postuler as $post){
            if ($post->getIdOffre() == $idOffre){
                $postu = $post;
            }
        }
        (new PostulerRepository())->delete(new QueryCondition("login",ComparisonOperator::EQUAL,$etudiant->getLogin()));
        (new PostulerRepository())->insert($postu);
        FlashMessage::add(
            content: "Profile mis à jours",
            type: FlashType::SUCCESS
        );
        return new Response(
            action: Action::PROFILE_ETUDIANT,
        );
    }
}