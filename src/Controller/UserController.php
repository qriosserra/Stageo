<?php

namespace Stageo\Controller;

use Exception;
use Stageo\Controller\CoreController;
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
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\User;
use Stageo\Model\Repository\EnseignantRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\EtudiantRepository;

abstract class UserController extends CoreController
{
    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function signIn(): ControllerResponse
    {
        $list = [
            "etudiant" => new EtudiantRepository(),
            "entreprise" => new EntrepriseRepository(),
            "enseignant" => new EnseignantRepository()
        ];

        $login = $_REQUEST["login"] ?? null;
        $password = $_REQUEST["password"];
        $token = $_REQUEST["token"] ?? null;

        foreach ($list as $type => $repositoryClass) {

            if (!Token::verify(RouteName::ETUDIANT_SIGN_IN_FORM, $token)) {
                throw new InvalidTokenException();
            }
            if (Token::isTimeout(RouteName::ETUDIANT_SIGN_IN_FORM)) {
                throw new TokenTimeoutException(
                    routeName: RouteName::ETUDIANT_SIGN_IN_FORM,
                    params: [
                        "login" => $login
                    ]
                );
            }

            if ($type == 'etudiant') {
                $user = $repositoryClass->getByLogin($login);
            } else {
                $user = $repositoryClass->getByEmail($login);
            }

            if ($user) {
                if (Password::verify($password, $user->getHashedPassword())) {
                    FlashMessage::add(
                        content: "Connexion réalisée avec succès",
                        type: FlashType::SUCCESS
                    );
                    UserConnection::signIn($user);

                    return new ControllerResponse(
                        redirection: RouteName::HOME,
                        statusCode: StatusCode::ACCEPTED,
                    );
                }
            }
        }

        throw new ControllerException(
            message: "L'utilisateur n'existe pas ou le mot de passe est incorrect",
            redirection: RouteName::ETUDIANT_SIGN_IN_FORM,
            params: [
                "login" => $login
            ]
        );
    }
}