<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Repository\EtudiantRepository;

class EtudiantController
{
    public function signUpForm(string $login = null): Response
    {
//        if (UserConnection::isSignedIn())
//            self::signOut();

        return new Response(
            template: "etudiant/sign-up.php",
            params: [
                "title" => "S'inscrire",
                "nav" => false,
                "footer" => false,
                "login" => $login,
                "token" => Token::generateToken(Action::ETUDIANT_SIGN_UP_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */

    function connectToLdap(): bool|\LDAP\Connection
    {
        $ldap_host = "10.10.1.30";
        $ldap_port = "389";
        $ldap_conn = ldap_connect($ldap_host, $ldap_port);
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        return $ldap_conn;
    }
    public function signUp(): Response
    {
        $login = $_REQUEST["login"];
        $password = $_REQUEST["password"];
        if (!Token::verify(Action::ETUDIANT_SIGN_UP_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ETUDIANT_SIGN_UP_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_SIGN_UP_FORM,
                params: ["login" => $login]
            );
        }
        if (!is_null((new EtudiantRepository())->getByLogin($login))) {
            throw new ControllerException(
                message: "Un compte avec ce login existe déjà",
                action: Action::ETUDIANT_SIGN_UP_FORM,
                params: [
                    "login" => $login
                ]
            );
        }
        if (!Validate::isPassword($password)) {
            throw new ControllerException(
                message: "Le mot de passe ne respecte pas les critères de sécurité",
                action: Action::ETUDIANT_SIGN_UP_FORM,
                params: [
                    "login" => $login
                ]
            );
        }
        if ($password !== $_REQUEST["confirm"]) {
            throw new ControllerException(
                message: "Les mots de passe ne correspondent pas",
                action: Action::ETUDIANT_SIGN_UP_FORM,
                params: [
                    "login" => $login
                ]
            );
        }

        FlashMessage::add(
            content: "Inscription réalisée avec succès",
            type: FlashType::SUCCESS
        );
        $etudiant = new Etudiant(
            login: $login,
            hashed_password: Password::hash($password),
        );
        UserConnection::signIn($etudiant);
        (new EtudiantRepository)->insert($etudiant);
        return new Response(
            action: Action::HOME
        );
    }

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
        /**
         * @var Etudiant|null $etudiant
         */
        $etudiant = (new EtudiantRepository())->getByLogin($login);
        if (is_null($etudiant)) {
            throw new ControllerException(
                message: "Aucun compte n'existe avec ce login",
                action: Action::ETUDIANT_SIGN_IN_FORM,
                params: [
                    "login" => $login
                ]
            );
        }
        if (!Password::verify($password, $etudiant->getHashedPassword())) {
            throw new ControllerException(
                message: "Le mot de passe est incorrect",
                action: Action::ETUDIANT_SIGN_IN_FORM,
                params: [
                    "login" => $login
                ]
            );
        }

        FlashMessage::add(
            content: "Connexion réalisée avec succès",
            type: FlashType::SUCCESS
        );
        UserConnection::signIn($etudiant);
        // a modifier

        return new Response(
            action: Action::HOME
        );
    }
}