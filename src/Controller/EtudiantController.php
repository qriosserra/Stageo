<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Repository\EtudiantRepository;

class EtudiantController
{
    public function signUpForm(string $login = null): Response
    {
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
            login: $login
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
        $etudiantRepository=new EtudiantRepository();
        $url = "https://webinfo.iutmontp.univ-montp2.fr/~riosq/LDAP/?login=$login&password=$password";
        $response = json_decode(file_get_contents($url), true);
        $etudiant= $etudiantRepository->getByLogin($login);
        if (is_null($etudiant)){
            $etudiant = new Etudiant($login,$response["nom"],$response["prenom"],$response["mail"],$response["annee"],$password);
            $etudiantRepository->insert($etudiant);
        }
        FlashMessage::add(
            content: "Connexion réalisée avec succès",
            type: FlashType::SUCCESS
        );
        UserConnection::signIn($etudiant);
        return new Response(
            action: Action::HOME
        );
    }
}