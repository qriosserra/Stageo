<?php

namespace Stageo\Controller;

use ArrayObject;
use Exception;
use http\Params;
use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\Mailer\Email;
use Stageo\Lib\Mailer\Mailer;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Offre;
use Stageo\Model\Object\Secretaire;
use Stageo\Model\Object\Suivi;
use Stageo\Model\Object\UniteGratification;
use Stageo\Model\Repository\AdminRepository;
use Stageo\Model\Repository\ConventionRepository;
use Stageo\Model\Repository\EnseignantRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\SecretaireRepository;
use Stageo\Model\Repository\SuiviRepository;
use Stageo\Model\Repository\UniteGratificationRepository;

class AdminController
{
    /**
     * @return Response
     * @throws ControllerException
     */
    public function dashboard(): Response
    {
        $user =UserConnection::getSignedInUser();
        if (($user instanceof Enseignant && $user->getEstAdmin())  || $user instanceof Secretaire){
            $etudiants = (new EtudiantRepository())->select();
            /**
             * @var Etudiant $etu
             */
            $param["title"] = "dashboard";
            $param["nav"] = false;
            $param["footer"] = false;
            $param["etudiants"]=$etudiants;
            $param["entrepriseavalider"] = (new EntrepriseRepository())->getEntreprisesNonValidees();
            if (is_array($param["entrepriseavalider"])) {
                $param["nbentrepriseavalider"] = sizeof($param["entrepriseavalider"]);
            }else{
                $param["nbentrepriseavalider"] = 0;
            }
            $param["offreavalider"] = (new OffreRepository())->getAllInvalidOffre();
            if (is_array($param["offreavalider"])) {
                $param["nboffreavalider"] = sizeof($param["offreavalider"]);
            }else{
                $param["nboffreavalider"] = 0;
            }
            // SOOOOME STAAAT
            $entrepriseencreations = (new EntrepriseRepository())->select(new QueryCondition("email",ComparisonOperator::EQUAL,""));
            if (is_array($entrepriseencreations)) {
                $param["entrepriseencreations"] = sizeof($entrepriseencreations);
            }else{
                $param["entrepriseencreations"] = 0;
            }
            $entrepriscree = (new EntrepriseRepository())->select(new QueryCondition("email",ComparisonOperator::NOT_EQUAL,""));
            if (is_array($entrepriscree)) {
                $param["entrepriscree"] = sizeof($entrepriscree);
            }else{
                $param["entrepriscree"] = 0;
            }
            if ($etudiants != null) {
                foreach ($etudiants as $etu) {
                    $nbcandidature[$etu->getlogin()] = (new EtudiantRepository())->getnbcandatures($etu->getlogin());
                    if ($nbcandidature[$etu->getlogin()] === null) {
                        $nbcandidature[$etu->getlogin()] = 0;
                    }
                }
                $param["nbcandidature"] = $nbcandidature;
                return new Response(
                    template: "admin/dashboard.php",
                    params: $param
                );
            }
            return new Response(
                template: "admin/dashboard.php",
                params: $param
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function signUp(): Response
    {
        if((new AdminRepository())->getByLogin($_REQUEST["login"]) == null) {
            (new AdminRepository())->insert(new Admin($_REQUEST["login"]));
            FlashMessage::add(
                content: "Ajout de ce login dans la base d'admins",
                type: FlashType::SUCCESS
            );
            return new Response(
                action: Action::ADMIN_DASH
            );
        }else{
            FlashMessage::add(
                content: "Ce login est déjà Admin !",
                type: FlashType::ERROR
            );
            return new Response(
                action: Action::ADMIN_DASH
            );
        }
    }
    public function signUpForm(): Response
    {
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            return new Response(
                template: "admin/sign-up.php",
                params: [
                    "title" => "Se connecter",
                    "nav" => false,
                    "footer" => false,
                    "token" => Token::generateToken(Action::ADMIN_SIGN_UP_FORM)
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function signInForm(string $login = null): Response
    {
        return new Response(
            template: "admin/sign-in.php",
            params: [
                "title" => "Se connecter",
                "nav" => false,
                "footer" => false,
                "login" => $login,
                "token" => Token::generateToken(Action::ADMIN_SIGN_IN_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     * @throws Exception
     */
    public function signIn($reponse): Response
    {
        if($reponse["login"] == "secretariat"){
            return (new SecretaireController())->signIn($reponse);
        }
        $nom = $reponse["nom"];
        $prenom = $reponse["prenom"];
        $login = $reponse["login"];
        $email = $reponse["mail"];
        $prof = (new EnseignantRepository())->getByLogin($login);
        if ($prof == null){
            (new EnseignantRepository())->insert(new Enseignant($login,$email,$nom,$prenom,false));
        }
        $prof = (new EnseignantRepository())->getByLogin($login);

        FlashMessage::add(
            content: "Connexion réalisée avec succès",
            type: FlashType::SUCCESS
        );
        UserConnection::signIn($prof);
        if ($prof instanceof Enseignant && $prof ->getEstAdmin()) {
            return new Response(
                action: Action::ADMIN_DASH
            );
        }else{
            return new Response(
                action: Action::HOME
            );

        }
    }

    public function listeEntreprises(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            $listeEntreprises = (new EntrepriseRepository())->getEntreprisesNonValidees();
            if ($listeEntreprises){
                return new Response(
                    template: "admin/listeEntreprises.php",
                    params: [
                        "title" => "Liste entreprises à valider",
                        "listeEntreprise" => $listeEntreprises
                    ]
                );
            }
            FlashMessage::add(
                content: "Aucune entreprise à valider",
                type: FlashType::INFO
            );
            return new Response(
                action: Action::ADMIN_DASH
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }
    public function validerEntreprise(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            $entreprise = (new EntrepriseRepository())->getById($_REQUEST["idEntreprise"]);
            /** @var Entreprise $entreprise **/
            $entreprise->setValide(true);
            (new EntrepriseRepository())->update($entreprise);
            return $this->listeOffreEntreprise($entreprise);
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }
    public function listeOffreEntreprise($entreprise){
        /**
         * @var Entreprise $entreprise
         */
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            $listeOffres = (new OffreRepository())->getAllInvalidOffreEntreprise($entreprise->getIdEntreprise());
            if ($listeOffres){
                return new Response(
                    template: "admin/listeOffre.php",
                    params: [
                        "title" => "Liste offres à valider de l'entreprise ".$entreprise->getRaisonSociale(),
                        "listeoffres" => $listeOffres
                    ]
                );
            }
            FlashMessage::add(
                content: "Aucune offre à valider",
                type: FlashType::INFO
            );
            return new Response(
                action: Action::ADMIN_LISTEENTREPRISE
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    /**
     * @throws ControllerException
     */
    public function suprimerEntreprise(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            $ent = (new EntrepriseRepository())->select(new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $_REQUEST["idEntreprise"]));
            /**
             * @var Entreprise $ent
             */
                $email = $_REQUEST["email"];
                $raison = $_REQUEST["raisonRefus"];
                $email = new Email($email,"Refus d'une Offre","Bonjour, nous vous informons que votre inscription a était refusé pour les raisons suivantes : <br> <br>".$raison);
                (new Mailer())->send($email);
            (new EntrepriseRepository())->delete([new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $_REQUEST["idEntreprise"])]);
            return new Response(
                action: Action::ADMIN_LISTEENTREPRISE
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function supprimerAdminForm(){
        $admis = (new AdminRepository())->select();
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            return new Response(
                template: "admin/supprimerAdmin.php",
                params: [
                    "title" => "Delete Admin",
                    "admins" => $admis
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function supprimerAdmin(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            if ((new AdminRepository())->getByLogin($_REQUEST["login"])){
                (new AdminRepository())->delete([new QueryCondition("login", ComparisonOperator::EQUAL, $_REQUEST["login"])]);
                $user = (new EnseignantRepository())->getByLogin($user->getLogin());
                UserConnection::signOut();
                UserConnection::signIn($user);
                FlashMessage::add(
                    content: "Admin supprimer !",
                    type: FlashType::SUCCESS
                );
                return new Response(
                    action: Action::ADMIN_DASH
                );
            }else {
                FlashMessage::add(
                    content: "Aucun Admin connue avec ce Login!",
                    type: FlashType::ERROR
                );
                return new Response(
                    action: Action::ADMIN_DASH
                );
            }
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function listeOffre(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            $listeOffres = (new OffreRepository())->getAllInvalidOffre();
            if ($listeOffres){
                return new Response(
                    template: "admin/listeOffre.php",
                    params: [
                        "title" => "Liste offres à valider",
                        "listeoffres" => $listeOffres
                    ]
                );
            }
            FlashMessage::add(
                content: "Aucune offre à valider",
                type: FlashType::INFO
            );
            return new Response(
                action: Action::ADMIN_DASH
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }
    public function validerOffre(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            $offre = (new OffreRepository())->getById($_REQUEST["idOffre"]);
            /** @var Offre $offre **/
            $offre->setValider(true);
            (new OffreRepository())->update($offre);
            return new Response(
                action: Action::ADMIN_LISTEOFFRES
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    /**
     * @throws ControllerException
     */
    public function suprimerOffre(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            $offre = (new OffreRepository())->select(new QueryCondition("id_offre", ComparisonOperator::EQUAL, $_REQUEST["idOffre"]));
            /**
             * @var Offre $offre
             */
                $email = $_REQUEST["email"];
                $raison = $_REQUEST["raisonRefus"];
                $email = new Email($email, "Refus d'une Offre", "Bonjour, nous vous informons que l'offre suivante a était refusé : " . $offre[0]->getDescription() . " pour les raison suivante :  <br> <br>" . $raison);
                (new Mailer())->send($email);
            (new OffreRepository())->delete([new QueryCondition("id_offre", ComparisonOperator::EQUAL, $_REQUEST["idOffre"])]);
            return new Response(
                action: Action::ADMIN_LISTEOFFRES
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
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
        if (($user instanceof Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire){
        $etudiants = (new EtudiantRepository())->select();
        $param["etudiants"] = $etudiants;
        if ($etudiants != null) {
            foreach ($etudiants as $etu) {
                $nbcandidature[$etu->getlogin()] = (new EtudiantRepository())->getnbcandatures($etu->getlogin());
                if ($nbcandidature[$etu->getlogin()] === null) {
                    $nbcandidature[$etu->getlogin()] = 0;
                }
            }
            foreach ($etudiants as $etu) {
                $conventions[$etu->getlogin()] = (new ConventionRepository())->getByLogin($etu->getlogin());
                if ($conventions[$etu->getLogin()]) {
                    $suivies[$etu->getLogin()] = (new SuiviRepository())->getByIdConvention($conventions[$etu->getLogin()]->getIdConvention());
                }
            }
            foreach ($etudiants as $etu) {
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
            $param["suivie"] = $suivies;
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

    public function validerConventionForm(): Response
    {
        $user = UserConnection::getSignedInUser();
        if (UserConnection::isSignedIn()) {
            if (($user instanceof Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire) {
                $etudiantlogin = $_REQUEST["etulogin"];
                $param["title"] = "Convention de l'étudiant " . $etudiantlogin;
                $etudiant = (new EtudiantRepository())->getByLogin($etudiantlogin);
                $param["etudiant"] = $etudiant;
                $param["convention"] = (new ConventionRepository())->getByLogin($etudiantlogin);
                $param["suivi"] = (new SuiviRepository())->getByIdConvention($param["convention"]->getIdConvention());
                $param["entreprise"] = (new EntrepriseRepository())->getById($param["convention"]->getIdEntreprise());
                $unite = (new UniteGratificationRepository())->getById($param["convention"]->getIdUniteGratification());
                /**
                 * @var UniteGratification $unite
                 */
                $param["unite_gratification"] = $unite->getLibelle();
                if (is_null($param["etudiant"]) || is_null($param["convention"]) || is_null($param["suivi"])) {
                    throw new ControllerException(
                        message: "il n'y a pas de convention liée a un tel étudiant !",
                        action: Action::HOME,
                    );
                }
                return new Response(
                    template: "admin/conventionValidation.php",
                    params: $param
                );
            }
            throw new ControllerException(
                message: "Vous n'avez pas acces a cette page!",
                action: Action::HOME,
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
    public function suiviStagiaire(): Response {
        return new Response(
            template: "admin/suiviStagiaire.php",
            params: [
                "title" => "Suvi du stagiaire",
                "nav" => false,
                "footer" => false
                
            ]
        );
    }

    // archive
    public function entreprisesArchive(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            $listeEntreprises = (new EntrepriseRepository())->getEntreprisesAchive();
            if ($listeEntreprises){
                return new Response(
                    template: "admin/entrepriseArchive.php",
                    params: [
                        "title" => "Liste entreprises archivé",
                        "listeEntreprise" => $listeEntreprises
                    ]
                );
            }
            FlashMessage::add(
                content: "Aucune entreprise archivé",
                type: FlashType::INFO
            );
            return new Response(
                action: Action::ADMIN_DASH
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function suprimerEntrepriseArchive(){
        $user = UserConnection::getSignedInUser();
        if (($user instanceof  Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire ) {
            (new EntrepriseRepository())->deleteEnterpriseFromArchive($_REQUEST["idEntreprise"]);
            return new Response(
                action: Action::ADMIN_ENTREPRISEARCHIVE
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }
}


