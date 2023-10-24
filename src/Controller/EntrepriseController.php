<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Session;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Offre;
use Stageo\Model\Repository\CodePostalRepository;
use Stageo\Model\Repository\CommuneRepository;
use Stageo\Model\Repository\DatabaseConnection;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\StatutJuridiqueRepository;
use Stageo\Model\Repository\TailleEntrepriseRepository;
use Stageo\Model\Repository\TypeStructureRepository;
use Stageo\Model\Repository\UniteGratificationRepository;

class EntrepriseController
{
    public function addStep1Form(): Response {
        return new Response(
            template: "entreprise/add-step-1.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "entreprise" => Session::get("entreprise"),
                "token" => Token::generateToken(Action::ENTREPRISE_ADD_STEP_1_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function addStep1():  Response
    {
        $raison_sociale = $_REQUEST["raison_sociale"];
        $telephone = $_REQUEST["telephone"];
        $site = $_REQUEST["site"];
        $fax = $_REQUEST["fax"];

        $entreprise = Session::get("entreprise") ?? new Entreprise();
        $entreprise->setRaisonSociale($raison_sociale);
        $entreprise->setTelephone($telephone);
        $entreprise->setSite($site);
        $entreprise->setFax($fax);
        Session::set("entreprise", $entreprise);

        if (!Token::verify(Action::ENTREPRISE_ADD_STEP_1_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_ADD_STEP_1_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isPhoneNumber($telephone)) {
            throw new ControllerException(
                message: "Le numéro de téléphone n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isPhoneNumber($fax)) {
            throw new ControllerException(
                message: "Le numéro de fax n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isName($raison_sociale)) {
            throw new ControllerException(
                message: "Le nom de l'entreprise n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_1_FORM
            );
        }
        if (!Validate::isUrl($site)) {
            throw new ControllerException(
                message: "L'url du site n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_1_FORM
            );
        }

        return new Response(
            action: Action::ENTREPRISE_ADD_STEP_2_FORM
        );
    }

    public function addStep2Form(): Response
    {
        return new Response(
            template: "entreprise/add-step-2.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "entreprise" => Session::get("entreprise"),
                "taille_entreprises" => array_column(array_map(fn($e) => $e->toArray(), (new TailleEntrepriseRepository)->select()), "libelle", "id_taille_entreprise"),
                "type_structures" => array_column(array_map(fn($e) => $e->toArray(), (new TypeStructureRepository())->select()), "libelle", "id_type_structure"),
                "statut_juridiques" => array_column(array_map(fn($e) => $e->toArray(), (new StatutJuridiqueRepository())->select()), "libelle", "id_statut_juridique"),
                "token" => Token::generateToken(Action::ENTREPRISE_ADD_STEP_2_FORM)
            ]
        );
    }

    public function addStep2(): Response
    {
        $siret = $_REQUEST["siret"];
        $code_naf = $_REQUEST["code_naf"];
        $id_taille_entreprise = $_REQUEST["id_taille_entreprise"];
        $id_type_structure = $_REQUEST["id_type_structure"];
        $id_statut_juridique = $_REQUEST["id_statut_juridique"];

        $entreprise = Session::get("entreprise") ?? new Entreprise();
        $entreprise->setSiret($siret);
        $entreprise->setCodeNaf($code_naf);
        $entreprise->setIdTailleEntreprise($id_taille_entreprise);
        $entreprise->setIdTypeStructure($id_type_structure);
        $entreprise->setIdStatutJuridique($id_statut_juridique);
        Session::set("entreprise", $entreprise);

        if (!Token::verify(Action::ENTREPRISE_ADD_STEP_2_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_ADD_STEP_2_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isSiret($siret)) {
            throw new ControllerException(
                message: "Le numéro de SIRET n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_2_FORM
            );
        }
        if (!Validate::isCodeNaf($code_naf)) {
            throw new ControllerException(
                message: "Le code NAF n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_2_FORM
            );
        }
        if (is_null((new TailleEntrepriseRepository)->getTailleEntrepriseById($id_taille_entreprise))) {
            throw new ControllerException(
                message: "La taille de l'entreprise n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_2_FORM
            );
        }
        if (is_null((new TypeStructureRepository)->getTypeStructureById($id_type_structure))) {
            throw new ControllerException(
                message: "Le type de structure n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_2_FORM
            );
        }
        if (is_null((new StatutJuridiqueRepository)->getStatutJuridiqueById($id_statut_juridique))) {
            throw new ControllerException(
                message: "Le statut juridique n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_2_FORM
            );
        }

        return new Response(
            action: Action::ENTREPRISE_ADD_STEP_3_FORM
        );
    }

    public function addStep3Form(): Response
    {
        return new Response(
            template: "entreprise/add-step-3.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "entreprise" => Session::get("entreprise"),
                "communes" => array_column(array_map(fn($e) => $e->toArray(), (new CommuneRepository())->select()), "commune", "id_commune"),
                "code_postaux" => array_column(array_map(fn($e) => $e->toArray(), (new CodePostalRepository())->select()), "id_code_postal", "id_code_postal"),
                "token" => Token::generateToken(Action::ENTREPRISE_ADD_STEP_3_FORM)
            ]
        );
    }

    public function addStep3(): Response
    {
        $numero_voie = $_REQUEST["numero_voie"];
        $id_commune = $_REQUEST["id_commune"];
        $id_code_postal = $_REQUEST["id_code_postal"];

        $entreprise = Session::get("entreprise") ?? new Entreprise();
        $entreprise->setNumeroVoie($numero_voie);
        $entreprise->setIdCommune($id_commune);
        $entreprise->setIdCodePostal($id_code_postal);
        Session::set("entreprise", $entreprise);

        if (!Token::verify(Action::ENTREPRISE_ADD_STEP_3_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_ADD_STEP_3_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_ADD_STEP_3_FORM
            );
        }
        if (!Validate::isName($numero_voie)) {
            throw new ControllerException(
                message: "Le numéro et la voie n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_3_FORM
            );
        }
        if (is_null((new CommuneRepository())->getById($id_commune))) {
            throw new ControllerException(
                message: "Choisissez une commune valide",
                action: Action::ENTREPRISE_ADD_STEP_3_FORM
            );
        }
        if (is_null((new CodePostalRepository())->getById($id_code_postal))) {
            throw new ControllerException(
                message: "Le code postal n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_3_FORM
            );
        }

        return new Response(
            action: Action::ENTREPRISE_ADD_STEP_4_FORM
        );
    }

    public function addStep4Form(): Response
    {
        return new Response(
            template: "entreprise/add-step-4.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "entreprise" => Session::get("entreprise"),
                "token" => Token::generateToken(Action::ENTREPRISE_ADD_STEP_4_FORM)
            ]
        );
    }

    public function addStep4(): Response
    {
        $email = $_REQUEST["email"];
        $password = $_REQUEST["password"];

        $entreprise = Session::get("entreprise") ?? new Entreprise();
        $entreprise->setUnverifiedEmail($email);
        Session::set("entreprise", $entreprise);

        if (!Token::verify(Action::ENTREPRISE_ADD_STEP_4_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_ADD_STEP_4_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_ADD_STEP_4_FORM
            );
        }
        if (!Validate::isEmail($email)) {
            throw new ControllerException(
                message: "L'email n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_4_FORM
            );
        }
        if (!Validate::isPassword($password)) {
            throw new ControllerException(
                message: "Le mot de passe n'est pas valide",
                action: Action::ENTREPRISE_ADD_STEP_4_FORM
            );
        }
        if ($password !== $_REQUEST["confirm"]) {
            throw new ControllerException(
                message: "Les mots de passe ne correspondent pas",
                action: Action::ENTREPRISE_ADD_STEP_4_FORM
            );
        }

        $entreprise->setHashedPassword((Password::hash($password)));
        (new EntrepriseRepository)->insert($entreprise);
        Session::delete("entreprise");
        FlashMessage::add("L'entreprise a été ajoutée avec succès", FlashType::SUCCESS);
        return new Response(
            action: Action::HOME
        );
    }

    public function offreAddForm(string $email = null): Response {
        return new Response(
            template: "entreprise/offre/add.php",
            params: [
                "email" => $email,
                "title" => "Création d'une offre",
                "nav" => false,
                "footer" => false,
                "offre" => Session::get("offre"),
                "unite_gratifications" => array_column(array_map(fn($e) => $e->toArray(), (new UniteGratificationRepository())->select()), "libelle", "id_unite_gratification"),
                "token" => Token::generateToken(Action::ENTREPRISE_CREATION_OFFRE_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function offreAdd(): Response{
        $description = $_REQUEST["description"];
        $secteur = $_REQUEST["secteur"];
        $thematique = $_REQUEST["thematique"];
        $taches = $_REQUEST["taches"];
        $commentaires = $_REQUEST["commentaires"];
        $gratification = $_REQUEST["gratification"];
        $id_unite_gratification = $_REQUEST["id_unite_gratification"];
        $type = $_REQUEST["emploi"];

        /*if(!UserConnection::isInstance(new Entreprise())){
            throw new ControllerException(
                message: "Vous n'avez pas les droits",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }*/
        /**
         * @var Entreprise $entreprise
         */
        //$entreprise = UserConnection::getSignedInUser();
        //$id_entreprise = $entreprise->getIdEntreprise();

        $offre = Session::set("offre", new Offre(
            id_entreprise: $id_entreprise ?? 1,
            description: $description,
            secteur: $secteur,
            thematique: $thematique,
            taches: $taches,
            commentaires: $commentaires,
            gratification: $gratification,
            id_unite_gratification: $id_unite_gratification,
        ));

        if (!Token::verify(Action::ENTREPRISE_CREATION_OFFRE_FORM, $_REQUEST["token"])) {
            throw new InvalidTokenException();
        }
        if (Token::isTimeout(Action::ENTREPRISE_CREATION_OFFRE_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isName($secteur)) {
            throw new ControllerException(
                message: "Le secteur n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isName($thematique)) {
            throw new ControllerException(
                message: "La thématique n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($description)) {
            throw new ControllerException(
                message: "La description n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($taches)) {
            throw new ControllerException(
                message: "Les fonctions et tâches ne sont pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isText($commentaires)) {
            throw new ControllerException(
                message: "Les commmentaires sur l'offre ne sont pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isFloat($gratification)) {
            throw new ControllerException(
                message: "La gratification n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (is_null(new UniteGratificationRepository($id_unite_gratification))) {
            throw new ControllerException(
                message: "L'unité de gratification n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }

        FlashMessage::add("L'offre a été ajoutée avec succès", FlashType::SUCCESS);
        $id_offre = (new OffreRepository())->insert($offre);

        //A MODIFIER PLUS TARD !!!!!!!!!!!!!
        $pdo = DatabaseConnection::getPdo();
        $sql = $pdo->prepare("INSERT INTO stg_offre_$type (id_offre) VALUES ($id_offre)");
        $sql->execute();
        return new Response(
            action: Action::HOME,
        );

    }
}