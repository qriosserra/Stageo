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
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\Secretaire;
use Stageo\Model\Repository\AdminRepository;
use Stageo\Model\Repository\ConventionRepository;
use Stageo\Model\Repository\SecretaireRepository;
//

class SecretaireController
{
    public function dashboard(): Response
    {
        $user =UserConnection::getSignedInUser();
        if ($user instanceof Secretaire){
            return new Response(
                template: "secretaire/dashboard.php",
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
        if (!Token::verify(Action::SECRETAIRE_SIGN_UP_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::SECRETAIRE_SIGN_UP_FORM)) {
            throw new TokenTimeoutException(
                action: Action::SECRETAIRE_SIGN_UP_FORM,
                params: [
                    "email" => $email,
                ]
            );
        }
        if (!Validate::isPassword($password)) {
            throw new ControllerException(
                message: "Le mot de passe ne respecte pas les critères de sécurité",
                action: Action::SECRETAIRE_SIGN_UP_FORM,
                params: [
                    "email" => $email,
                ]
            );
        }
        if (!Validate::isEmail($email)) {
            throw new ControllerException(
                message: "$email ne correspond pas à une email valide",
                action: Action::SECRETAIRE_SIGN_UP_FORM,
                params: [
                    "email" => $email,
                ]
            );
        }
        if ($password !== $_REQUEST["confirm"]) {
            throw new ControllerException(
                message: "Les mots de passe ne correspondent pas",
                action: Action::SECRETAIRE_SIGN_UP_FORM,
                params: [
                    "email" => $email,
                ]
            );
        }

        FlashMessage::add(
            content: "Inscription réalisée avec succès",
            type: FlashType::SUCCESS
        );
        $secretaire = new Secretaire(
            email: $email,
            hashed_password: Password::hash($password),
        );
        UserConnection::signIn($secretaire);
        (new SecretaireRepository())->insert($secretaire);
        return new Response(
            action: Action::HOME
        );
    }
    public function signUpForm(): Response
    {
        return new Response(
            template: "secretaire/sign-up.php",
            params: [
                "title" => "Se connecter",
                "nav" => false,
                "footer" => false,
                "token" => Token::generateToken(Action::SECRETAIRE_SIGN_UP_FORM)
            ]
        );
    }
    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function signIn(Secretaire $secretaire, string $password): Response
    {
        if (!Password::verify($password, $secretaire->getHashedPassword())) {
            throw new ControllerException(
                message: "Le mot de passe est incorrect",
                action: Action::ADMIN_SIGN_IN_FORM,
                params: [
                    "email" => $secretaire->getEmail(),
                ]
            );
        }

        FlashMessage::add(
            content: "Connexion réalisée avec succès",
            type: FlashType::SUCCESS
        );
        UserConnection::signIn($secretaire);

        return new Response(
            action: Action::HOME
        );
    }
    public function listeConventions(): Response
    {
        if (!UserConnection::isInstance(new Secretaire)){
            throw new ControllerException(
                message: "Vous n'avez pas accès à cette page",
                action: Action::HOME,
            );
        }
        return new Response(
            template: "secretaire/listeConventions.php",
            params: [
                "title" => "listeConventions",
                "conventions" => (new ConventionRepository)->select(),
            ]
        );
    }

    public function conventionDetails(int $id_convention): Response {
        if (!UserConnection::isInstance(new Secretaire)) {
            throw new ControllerException(
                message: "Vous n'êtes pas authorisé à accéder à cette page",
                action: Action::HOME,
            );
        }
        return new Response(
            template: "secretaire/convention-details.php",
            params: [
                "title" => "Détails de la convention",
                "convention" => (new ConventionRepository)->select(new QueryCondition("id_convention", ComparisonOperator::EQUAL, $id_convention))
            ]
        );
    }
}