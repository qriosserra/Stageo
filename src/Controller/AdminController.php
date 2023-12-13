<?php

namespace Stageo\Controller;

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
use Stageo\Lib\Response;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Repository\AdminRepository;
use Stageo\Model\Repository\EnseignantRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\SecretaireRepository;

class AdminController
{
    public function dashboard(): Response
    {
        $user =UserConnection::getSignedInUser();
        if ($user instanceof Enseignant && $user->getEstAdmin()){
            return new Response(
                template: "admin/dashboard.php",
                params: ["title" => "dashboard","nav"=>false,"footer"=>false]
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
        if ($user instanceof  Enseignant && $user->getEstAdmin()) {
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
        if ($user instanceof  Enseignant && $user->getEstAdmin()) {
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
        if ($user instanceof  Enseignant && $user->getEstAdmin()) {
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
        $user = UserConnection::getSignedInUser();
        if ($user instanceof  Enseignant && $user->getEstAdmin()) {
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

    public function supprimerAdminForm(){
        $admis = (new AdminRepository())->select();
        $user = UserConnection::getSignedInUser();
        if ($user instanceof  Enseignant && $user->getEstAdmin()) {
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
        if ($user instanceof  Enseignant && $user->getEstAdmin()) {
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
}