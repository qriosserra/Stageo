<?php

namespace Stageo\Controller;

use http\Params;
use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Repository\AdminRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\SecretaireRepository;

class AdminController
{
    public function dashboard(): Response
    {
        $user =UserConnection::getSignedInUser();
        if ($user instanceof Admin){
            return new Response(
                template: "admin/dashboard.php",
                params: ["title" => "dashboard"]
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function signUp(): Response
    {
        $password = $_REQUEST["password"];
        $email= $_REQUEST["email"];
        $nom =$_REQUEST["nom"];
        $prenom=$_REQUEST["prenom"];
        if (!Token::verify(Action::ADMIN_SIGN_UP_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ADMIN_SIGN_UP_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ADMIN_SIGN_UP_FORM,
                params: [
                    "email" => $email,
                    "nom" => $nom,
                    "prenom" => $prenom
                ]
            );
        }
        if (!Validate::isPassword($password)) {
            throw new ControllerException(
                message: "Le mot de passe ne respecte pas les critères de sécurité",
                action: Action::ADMIN_SIGN_UP_FORM,
                params: [
                    "email" => $email,
                    "nom" => $nom,
                    "prenom" => $prenom
                ]
            );
        }
        if (!Validate::isEmail($email)) {
            throw new ControllerException(
                message: "$email ne correspond pas à une email valide",
                action: Action::ADMIN_SIGN_UP_FORM,
                params: [
                    "email" => $email,
                    "nom" => $nom,
                    "prenom" => $prenom
                ]
            );
        }
        if ($password !== $_REQUEST["confirm"]) {
            throw new ControllerException(
                message: "Les mots de passe ne correspondent pas",
                action: Action::ADMIN_SIGN_UP_FORM,
                params: [
                    "email" => $email,
                    "nom" => $nom,
                    "prenom" => $prenom
                ]
            );
        }

        FlashMessage::add(
            content: "Inscription réalisée avec succès",
            type: FlashType::SUCCESS
        );
        $admin = new Admin(
            email: $email,
            nom: $nom,
            prenom: $prenom,
            hashed_password: Password::hash($password),
        );
        (new AdminRepository())->insert($admin);
        $admin = (new AdminRepository())->getByEmail($email);
        UserConnection::signIn($admin);
        return new Response(
            action: Action::HOME
        );
    }
    public function signUpForm(): Response
    {
        if (UserConnection::isInstance(new Admin())) {
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
     */
    public function signIn(): Response
    {
        $email = $_REQUEST["email"];
        $password = $_REQUEST["password"];
        if (!Token::verify(Action::ADMIN_SIGN_IN_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ADMIN_SIGN_IN_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ADMIN_SIGN_IN_FORM,
                params: ["email" => $email]
            );
        }
        /**
         * @var Etudiant|null $etudiant
         */
        $admin = (new AdminRepository())->getByEmail($email);
        if (is_null($admin)) {
            $secretaire = (new SecretaireRepository())->getByEmail($email);
            if (is_null($secretaire)) {
                throw new ControllerException(
                    message: "Aucun compte n'existe avec ce login",
                    action: Action::ADMIN_SIGN_IN_FORM,
                    params: [
                        "email" => $email
                    ]
                );
            }
            (new SecretaireController())->signIn($secretaire,$password);
        }
        if (!Password::verify($password, $admin->getHashedPassword())) {
            throw new ControllerException(
                message: "Le mot de passe est incorrect",
                action: Action::ADMIN_SIGN_IN_FORM,
                params: [
                    "email" => $email
                ]
            );
        }

        FlashMessage::add(
            content: "Connexion réalisée avec succès",
            type: FlashType::SUCCESS
        );
        UserConnection::signIn($admin);
        // a modifier

        return new Response(
            action: Action::HOME
        );
    }

    public function listeEntreprises(){
        if (UserConnection::isInstance(new Admin())) {
            $listeEntreprises = (new EntrepriseRepository())->getEntreprisesNonValidees();
            return new Response(
                template: "admin/listeEntreprises.php",
                params: [
                    "title" => "Liste entreprises à valider",
                    "listeEntreprise" => $listeEntreprises
                ]
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }
    public function validerEntreprise(){
        if (UserConnection::isInstance(new Admin())) {
            $entreprise = (new EntrepriseRepository())->getById($_REQUEST["idEntreprise"]);
            /** @var Entreprise $entreprise **/
            $entreprise->setValide(true);
            (new EntrepriseRepository())->update($entreprise);
            $listeEntreprises = (new EntrepriseRepository())->getEntreprisesNonValidees();
            return new Response(
                action: Action::ADMIN_LISTEENTREPRISE
            );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function suprimerEntreprise(){
        if (UserConnection::isInstance(new Admin())) {
        (new EntrepriseRepository())->delete([new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $_REQUEST["idEntreprise"])]);
        $listeEntreprises = (new EntrepriseRepository())->getEntreprisesNonValidees();
        return new Response(
            action: Action::ADMIN_LISTEENTREPRISE
        );
        }
        throw new ControllerException(
            message: "Vous n'êtes pas authorisé à accéder à cette page",
            action: Action::HOME,
        );
    }

    public function afficherFormulaireMiseAJour(): Response{
        $user = UserConnection::getSignedInUser();
        if (!$user) {
            throw new ControllerException(
                message: "Veillez vous connecter",
                action: Action::HOME
            );
        }
        else if (!UserConnection::isInstance(new Admin())) {
            throw new ControllerException(
                message: "Vous n'avez pas à acceder à cette page",
                action: Action::HOME
            );
        }
        else{
            return new Response(
                template: "admin/update.php",
                params: [
                    "user" => UserConnection::getSignedInUser(),
                    "token" => Token::generateToken(Action::ADMIN_MODIFICATION_INFO_FORM)
                ]
            );
        }
    }

    public static function mettreAJourAdmin():Response
    {
        $user = UserConnection::getSignedInUser();
        $id = (int)$_REQUEST["id"];
        $email = $_REQUEST["email"];
        $nom = $_REQUEST["nom"];
        $prenom = $_REQUEST["prenom"];
        $password = $_REQUEST["password"];
        $new_password1 = $_REQUEST["new_password1"];
        $new_password2 = $_REQUEST["new_password2"];
        if (!Token::verify(Action::ADMIN_MODIFICATION_INFO_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ADMIN_MODIFICATION_INFO_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ADMIN_MODIFICATION_INFO_FORM
            );
        }
        if(!$user){
            throw new ControllerException(
                message: "Veillez vous connecter",
                action: Action::ADMIN_MODIFICATION_INFO_FORM
            );
        }
        else if(!UserConnection::isInstance(new Admin())){
            throw new ControllerException(
                message: "Vous n'avez pas à acceder à cette page",
                action: Action::ADMIN_MODIFICATION_INFO_FORM
            );
        }
        else if($id!=$user->getIdAdmin()){
            throw new ControllerException(
                message: "Vous ne pouvez pas modifier les autres admin",
                action: Action::ADMIN_MODIFICATION_INFO_FORM
            );
        }
        else if (!Password::verify($password, $user->getHashedPassword())) {
            throw new ControllerException(
                message: "Mot de Passe incorect",
                action: Action::ADMIN_MODIFICATION_INFO_FORM
            );
        }
        else if ($new_password1!=$new_password2) {
            throw new ControllerException(
                message: "Les nouveau mod de passe ne correspondent pas",
                action: Action::ADMIN_MODIFICATION_INFO_FORM
            );
        }
        if(!$new_password1 || !$new_password2){
            $new_password1 = $password;
        }
        /**
         * @var Admin $a
         */
        $a = UserConnection::getSignedInUser();
        $a->setEmail($email);
        $a->setNom($nom);
        $a->setPrenom($prenom);
        $a->setHashedPassword(Password::hash($new_password1));
        (new AdminRepository())->update($a);
        return new Response(
            action: Action::HOME,
        );
    }
}