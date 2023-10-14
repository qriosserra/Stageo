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
    public function signIn2(string $cle, string $type): ControllerResponse
    {
        $login = $_REQUEST["$cle"];
        $type_chemin = strtoupper($type);
        $password = $_REQUEST["password"];
        if (!Token::verify(RouteName::${$type_chemin . '_SIGN_IN_FORM'}, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(RouteName::${$type_chemin . '_SIGN_IN_FORM'})) {
            throw new TokenTimeoutException(
                routeName: RouteName::${$type_chemin . '_SIGN_IN_FORM'},
                params: [
                    "login" => $login
                ]
            );
        }
        /**
         * @var User|null $user
         */
        $method = 'getBy' . $cle;
        $repositoryClass = ucfirst($type) . 'Repository';
        $user = (new $repositoryClass)->$method($login);
        if (is_null($user)) {
            throw new ControllerException(
                message: "Aucun compte n'existe avec ce login",
                redirection: RouteName::${$type_chemin . '_SIGN_IN_FORM'},
                params: [
                    "$cle" => $login
                ]
            );
        }
        if (!Password::verify($password, $user->getHashedPassword())) {
            throw new ControllerException(
                message: "Le mot de passe est incorrect",
                redirection: RouteName::${$type_chemin . '_SIGN_IN_FORM'},
                params: [
                    "$cle" => $login
                ]
            );
        }
        FlashMessage::add(
            content: "Connexion réalisée avec succès",
            type: FlashType::SUCCESS
        );
        UserConnection::signIn($user);
        // a modifier

        return new ControllerResponse(
            redirection: RouteName::HOME,
            statusCode: StatusCode::ACCEPTED,
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function signIn(): ControllerResponse
    {
        $repositoryList = [
            'etudiant' => new EtudiantRepository(),
            'entreprise' => new EntrepriseRepository(),
            'enseignant' => new EnseignantRepository(),
        ];

        $list = [
            "etudiant" => [
                "login" => $_REQUEST['login'],
                "password" => $_REQUEST['password'],
                "token" => $_REQUEST['token']
            ],
            "entreprise" => [
                "email" => $_REQUEST['login'],
                "password" => $_REQUEST['password'],
                "token" => $_REQUEST['token']
            ],
            "enseignant" => [
                "email" => $_REQUEST['login'],
                "password" => $_REQUEST['password'],
                "token" => $_REQUEST['token']
            ]
        ];

        foreach ($list as $type => $data) {
            try {
                $login = $data["login"] ?? null;
                $password = $data["password"];
                $email = $data["email"] ?? null;
                $token = $data["token"] ?? null;

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

                //$repositoryClass = ucfirst($type) . 'Repository';
                $repositoryClass = $repositoryList[$type];
                if($login) {
                    $user = (new $repositoryClass)->getByLogin($login);
                }
                else{
                    $login = $email;
                    $user = (new $repositoryClass)->getByEmail($login);
                }

                if (is_null($user)) {
                    throw new ControllerException(
                        message: "Aucun compte n'existe avec ce login",
                        redirection: RouteName::ETUDIANT_SIGN_IN_FORM,
                        params: [
                            "login" => $login
                        ]
                    );
                }
                if (!Password::verify($password, $user->getHashedPassword())) {
                    throw new ControllerException(
                        message: "Le mot de passe est incorrect",
                        redirection: RouteName::ETUDIANT_SIGN_IN_FORM,
                        params: [
                            "login" => $login
                        ]
                    );
                }

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
            catch (Exception $e) {
                return new ControllerResponse(
                    redirection: RouteName::ETUDIANT_SIGN_IN_FORM,
                    statusCode: StatusCode::ACCEPTED,
                );
            }

        }
    }
}