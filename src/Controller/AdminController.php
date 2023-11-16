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
        UserConnection::signIn($admin);
        (new AdminRepository())->insert($admin);
        return new Response(
            action: Action::HOME
        );
    }
    public function signUpForm(): Response
    {
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
        $admin = (new AdminRepository())->getByEmail($email);
        if (is_null($admin)) {
            $secretaire = (new SecretaireRepository())->getByEmail($email);
            (new SecretaireController())->signIn($secretaire,$password);
            if (is_null($secretaire)) {
                throw new ControllerException(
                    message: "Aucun compte n'existe avec ce login",
                    action: Action::ADMIN_SIGN_IN_FORM,
                    params: [
                        "email" => $email
                    ]
                );
            }
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
        $listeEntreprises = (new EntrepriseRepository())->getEntreprisesNonValidees();
        return new Response(
            template: "admin/listeEntreprises.php",
            params: [
                "title" => "Liste entreprises à valider",
                "listeEntreprise" => $listeEntreprises
            ]
        );
    }
    public function validerEntreprise(){
        $entreprise = (new EntrepriseRepository())->getById($_REQUEST["idEntreprise"]);
        /** @var Entreprise $entreprise **/
        $entreprise->setConfirmer(1);
        (new EntrepriseRepository())->update($entreprise);
        $listeEntreprises = (new EntrepriseRepository())->getEntreprisesNonValidees();
        return new Response(
            action: Action::ADMIN_LISTEENTREPRISE
        );
    }

    public function suprimerEntreprise(){
        (new EntrepriseRepository())->delete([new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $_REQUEST["idEntreprise"])]);
        $listeEntreprises = (new EntrepriseRepository())->getEntreprisesNonValidees();
        return new Response(
            action: Action::ADMIN_LISTEENTREPRISE
        );
    }

    public function bla(){
        $pass= "Stageo1234";
        echo Password::hash($pass);
    }
}