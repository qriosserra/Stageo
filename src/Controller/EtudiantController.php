<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Session;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\UserConnection;
use Stageo\Lib\Validate;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\CategorieRepository;
use Stageo\Controller\UserController;


class EtudiantController extends UserController
{
    /**
     * @throws ControllerException
     */
    public function signUpForm(string $login = null): ControllerResponse
    {
//        if (UserConnection::isSignedIn())
//            self::signOut();

        return new ControllerResponse(
            template: "etudiant/sign-up.html.twig",
            params: [
                "login" => $login,
                "token" => Token::generateToken(RouteName::ETUDIANT_SIGN_UP_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function signUp(): ControllerResponse
    {
        $login = $_REQUEST["login"];
        $password = $_REQUEST["password"];
        if (!Token::verify(RouteName::ETUDIANT_SIGN_UP_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(RouteName::ETUDIANT_SIGN_UP_FORM)) {
            throw new TokenTimeoutException(
                routeName: RouteName::ETUDIANT_SIGN_UP_FORM,
                params: [
                    "login" => $login
                ]
            );
        }
        if (!is_null((new EtudiantRepository())->getByLogin($login))) {
            throw new ControllerException(
                message: "Un compte avec ce login existe déjà",
                redirection: RouteName::ETUDIANT_SIGN_UP_FORM,
                params: [
                    "login" => $login
                ]
            );
        }
        if (!Validate::isPassword($password)) {
            throw new ControllerException(
                message: "Le mot de passe ne respecte pas les critères de sécurité",
                redirection: RouteName::ETUDIANT_SIGN_UP_FORM,
                params: [
                    "login" => $login
                ]
            );
        }
        if ($password !== $_REQUEST["confirm"]) {
            throw new ControllerException(
                message: "Les mots de passe ne correspondent pas",
                redirection: RouteName::ETUDIANT_SIGN_UP_FORM,
                params: [
                    "login" => $login
                ]
            );
        }

        FlashMessage::add(
            content: "Inscription réalisée avec succès",
            type: FlashType::SUCCESS
        );
        (new EtudiantRepository)->insert(new Etudiant(
            login: $login,
            hashed_password: Password::hash($password),
        ));
        return new ControllerResponse(
            redirection: RouteName::HOME,
            statusCode: StatusCode::ACCEPTED
        );
    }

    public function signInForm(string $login = null): ControllerResponse
    {
        return new ControllerResponse(
            template: "etudiant/sign-in.html.twig",
            params: [
                "login" => $login,
                "token" => Token::generateToken(RouteName::ETUDIANT_SIGN_IN_FORM)
            ]
        );
    }

    /**
     * @throws ControllerException
     */
    public function signOut(): ControllerResponse
    {
        if (!UserConnection::isSignedIn())
            throw new ControllerException(
                message: "User is not signed in",
                statusCode: StatusCode::UNAUTHORIZED
            );

        UserConnection::signOut();
        FlashMessage::add(
            content: "Vous avez été déconnecté",
            type: FlashType::INFO
        );

        return new ControllerResponse(
            redirection: RouteName::RELOAD_PAGE,
            statusCode: StatusCode::CREATED
        );
    }
}