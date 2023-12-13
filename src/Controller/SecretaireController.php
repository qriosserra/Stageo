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
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Secretaire;
use Stageo\Model\Repository\AdminRepository;
use Stageo\Model\Repository\ConventionRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\SecretaireRepository;
use Stageo\Model\Repository\SuiviRepository;

//

class SecretaireController
{
    /**
     * @throws ControllerException
     * @throws \Exception
     */
    public function dashboard(): Response
    {
        $user =UserConnection::getSignedInUser();
        if ($user instanceof Secretaire){
            $etudiants = (new EtudiantRepository())->select();
            /**
             * @var Etudiant $etu
             */
            $param["title"] = "dashboard";
            $param["nav"] = false;
            $param["footer"] = false;
            $param["etudiants"]=$etudiants;
            $param["entrepriseavalider"] = (new EntrepriseRepository())->getEntreprisesNonValidees();
            if (is_array($param["entrepriseavalider"])) {
                $param["nbentrepriseavalider"] = sizeof($param["entrepriseavalider"]);
            }else{
                $param["nbentrepriseavalider"] = 0;
            }
            $param["offreavalider"] = (new OffreRepository())->getAllInvalidOffre();
            if (is_array($param["offreavalider"])) {
                $param["nboffreavalider"] = sizeof($param["offreavalider"]);
            }else{
                $param["nboffreavalider"] = 0;
            }
            // SOOOOME STAAAT
            $entrepriseencreations = (new EntrepriseRepository())->select(new QueryCondition("email",ComparisonOperator::EQUAL,""));
            if (is_array($entrepriseencreations)) {
                $param["entrepriseencreations"] = sizeof($entrepriseencreations);
            }else{
                $param["entrepriseencreations"] = 0;
            }
            $entrepriscree = (new EntrepriseRepository())->select(new QueryCondition("email",ComparisonOperator::NOT_EQUAL,""));
            if (is_array($entrepriscree)) {
                $param["entrepriscree"] = sizeof($entrepriscree);
            }else{
                $param["entrepriscree"] = 0;
            }

            if ($etudiants != null) {
                foreach ($etudiants as $etu) {
                    $nbcandidature[$etu->getlogin()] = (new EtudiantRepository())->getnbcandatures($etu->getlogin());
                    if ($nbcandidature[$etu->getlogin()] === null) {
                        $nbcandidature[$etu->getlogin()] = 0;
                    }
                }
                $param["nbcandidature"] = $nbcandidature;
                return new Response(
                    template: "admin/dashboard.php",
                    params: $param
                );
            }}
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
        return new Response(
            action: Action::HOME
        );
    }
    public function signUpForm(): Response
    {
        $user = UserConnection::getSignedInUser();
        if ($user instanceof  Enseignant && $user->getEstAdmin() || UserConnection::isInstance(new Secretaire())){
            return new Response(
                template: "secretaire/sign-up.php",
                params: [
                    "title" => "Se connecter",
                    "nav" => false,
                    "footer" => false,
                    "token" => Token::generateToken(Action::SECRETAIRE_SIGN_UP_FORM)
                ]
            );
        }else{
            throw new ControllerException(
                message: "Vous n'êtes pas authorisé à accéder à cette page",
                action: Action::HOME,
            );
        }
    }
    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function signIn($reponse): Response
    {

        FlashMessage::add(
            content: "Connexion réalisée avec succès",
            type: FlashType::SUCCESS
        );
        UserConnection::signIn(new Secretaire());

        return new Response(
            action: Action::HOME
        );
    }
    public function listeConventions(): Response
    {
        if (!UserConnection::isInstance(new Secretaire) && !UserConnection::isInstance(new Admin)){
            throw new ControllerException(
                message: "Vous n'avez pas accès à cette page",
                action: Action::HOME,
            );
        }
        return new Response(
            template: "secretaire/liste-conventions.php",
            params: [
                "title" => "Conventions",
                "conventions" => (new ConventionRepository)->select(),
            ]
        );
    }

    public function conventionDetails(int $id_convention): Response {
        $convention = (new ConventionRepository())->select([new QueryCondition("id_convention", ComparisonOperator::EQUAL, $id_convention)])[0] ?? null;
        if (!UserConnection::isInstance(new Secretaire) && !UserConnection::isInstance(new Admin)) {
            throw new ControllerException(
                message: "Vous n'êtes pas authorisé à accéder à cette page",
                action: Action::HOME,
            );
        }
        return new Response(
            template: "secretaire/convention-details.php",
            params: [
                "title" => "Détails de la convention",
                "convention" => $convention,
            ]
        );
    }

    public function conventionValidation(int $id_convention): Response {
        $conventions = (new ConventionRepository())->select();
        $convention = (new ConventionRepository())->select([new QueryCondition("id_convention", ComparisonOperator::EQUAL, $id_convention)])[0] ?? null;
        if (!UserConnection::isInstance(new Secretaire) && !UserConnection::isInstance(new Admin)) {
            throw new ControllerException(
                message: "Vous n'êtes pas authorisé à accéder à cette page",
                action: Action::HOME,
            );
        }
        $suivi = (new SuiviRepository())->select([new QueryCondition("id_convention", ComparisonOperator::EQUAL, $id_convention)])[0] ?? null;
        // changer le statut de la convention en "validée"
        $suivi->setModifiable(false);
        if (UserConnection::isInstance(new Admin)) {
            $suivi->setValidePedagogiquement(true);
        }
        else {
            $suivi->setValide(true);
        }
        (new SuiviRepository())->update($suivi);
        return new Response(
            template: "secretaire/liste-conventions.php",
            params: [
                "title" => "Validation de la convention",
                "suivi" => $suivi,
                "convention" => $convention,
                "conventions" => $conventions,
            ]
        );
    }

    public function conventionRefus(int $id_convention): Response {
        $conventions = (new ConventionRepository())->select();
        $convention = (new ConventionRepository())->select([new QueryCondition("id_convention", ComparisonOperator::EQUAL, $id_convention)])[0] ?? null;
        if (!UserConnection::isInstance(new Secretaire) && !UserConnection::isInstance(new Admin)) {
            throw new ControllerException(
                message: "Vous n'êtes pas authorisé à accéder à cette page",
                action: Action::HOME,
            );
        }
        $suivi = (new SuiviRepository())->select([new QueryCondition("id_convention", ComparisonOperator::EQUAL, $id_convention)])[0] ?? null;
        // changer le statut de la convention en "refusée"
        $suivi->setModifiable(true);
        $suivi->setValide(false);
        $suivi->setValidePedagogiquement(false);
        $suivi->setRaisonRefus($_REQUEST["raison_refus"]);
        (new SuiviRepository())->update($suivi);
        return new Response(
            template: "secretaire/liste-conventions.php",
            params: [
                "title" => "Refus de la convention",
                "suivi" => $suivi,
                "convention" => $convention,
                "conventions" => $conventions,
            ]
        );
    }
}