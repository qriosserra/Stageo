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
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\ConventionRepository;

class EtudiantController
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
        $etudiant =(new EtudiantRepository)->getByLogin($login);
        if (is_null($etudiant)){
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
            action: Action::HOME
        );
    }

    public function conventionAddForm(): Response
    {
        return new Response(
            template: "etudiant/conventionAdd.php",
            params: [
                "title" => "Déposer une convention",
                "nav" => true,
                "footer" => true,
                "token" => Token::generateToken(Action::ETUDIANT_CONVENTION_ADD)
            ]
        );
    }
    public function conventionAdd(): Response
    {
        $etudiant = UserConnection::getUser();
        if (!Token::verify(Action::ETUDIANT_CONVENTION_ADD, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ETUDIANT_CONVENTION_ADD)) {
            throw new TokenTimeoutException(
                action: Action::ETUDIANT_CONVENTION_ADD,
                params: ["login" => $etudiant->getLogin()]
            );
        }


        $convention = new Convention(
            login: $etudiant->getLogin(),
            type_convention: $_REQUEST["type_convention"],
            origine_stage: $_REQUEST["origine_stage"],
            annee_universitaire: $_REQUEST["annee_universitaire"],
            thematique: $_REQUEST["thematique"],
            sujet: $_REQUEST["sujet"],
            taches: $_REQUEST["taches"],
            date_debut: $_REQUEST["date_debut"],
            date_fin: $_REQUEST["date_fin"]
        );
        (new ConventionRepository)->insert($convention);
        FlashMessage::add(
            content: "Convention ajoutée avec succès",
            type: FlashType::SUCCESS
        );

        return new Response(
            action: Action::HOME
        );
    }


}