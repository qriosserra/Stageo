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
use Stageo\Model\Object\Postuler;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\PostulerRepository;

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
            action: Action::LISTE_OFFRE
        );
    }

    public static function afficherFormulairePostuler(string $id): Response
    {
        $user = UserConnection::getSignedInUser();
        $offre = (new OffreRepository())->getById($id);
        if(!$user){
            throw new ControllerException(
                message: "Veillez vous connecter",
                action: Action::HOME
            );
        }
        else if (!UserConnection::isInstance(new Etudiant)) {
            throw new ControllerException(
                message: "Vous n'avez pas à acceder à cette page",
                action: Action::HOME
            );
        }
        /*else if(!(new PostulerRepository())->a_Postuler($user->getLogin(),$id)){
            throw new ControllerException(
                message: "Vous n'avez pas à acceder à cette page",
                action: Action::HOME
            );
        }*/
        else {
            return new Response(
                template: "entreprise/offre/postuler.php",
                params: [
                    "etudiant" => $user,
                    "offre" => $offre,
                ]
            );
        }
    }

    public function postuler(): Response{
        $login = $_REQUEST["login"];
        $idOffre = $_REQUEST["id"];
        $cv = $_FILES["cv"];
        $lettre_motivation = $_FILES["lm"];
        $complement = $_REQUEST["complement"];
        if($cv["size"] == 0){
            return new Response(
                action:Action::ETUDIANT_POSTULER_OFFRE_FORM,
                params:[
                    "login" => $login,
                    "id" => $idOffre
                ]
            );
        }
        if(UserConnection::isSignedIn() and UserConnection::isInstance(new Etudiant) and UserConnection::getSignedInUser()->getLogin()==$login){
            $lm_chemin = null;
            if ($cv["error"] == UPLOAD_ERR_OK) {
                $cvFileName = "cv_" . uniqid() . "_" . basename($cv["name"]);
                move_uploaded_file($cv["tmp_name"], "assets/document/cv/" . $cvFileName);
                $cv_chemin = "asset/document/cv/".$cvFileName;
            }
            else{
                return new Response(
                    action:Action::ETUDIANT_POSTULER_OFFRE_FORM,
                    params:[
                       "login" => $login,
                       "id" => $idOffre
                    ]
                );
            }
            if ($lettre_motivation["error"] == UPLOAD_ERR_OK) {
                $lmFileName = "lm_" . uniqid() . "_" . basename($lettre_motivation["name"]);
                move_uploaded_file($lettre_motivation["tmp_name"], "assets/document/lm/" . $lmFileName);
                $lm_chemin = "asset/document/lm/".$lmFileName;
            }
            else{
                return new Response(
                    action:Action::ETUDIANT_POSTULER_OFFRE_FORM,
                    params:[
                        "login" => $login,
                        "id" => $idOffre
                    ]
                );
            }
            (new PostulerRepository())->insert(new Postuler(null,$cv_chemin,$login,$idOffre,$lm_chemin,$complement));
        }
        else{
            FlashMessage::add(
                content: "Information incorrecte pour postuler",
                type: FlashType::WARNING
            );
        }
        return new Response(
            action: Action::AFFICHER_OFFRE,
            params: [
                "id" => $idOffre
            ]
        );
    }
}