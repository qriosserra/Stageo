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
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Offre;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\OffreRepository;

class EntrepriseController
{
    public function addForm(string $email = null): Response {
        return new Response(
            template: "entreprise/add.php",
            params: [
                "title" => "Ajouter son entreprise",
                "nav" => false,
                "footer" => false,
                "email" => $email,
                "token" => Token::generateToken(Action::ENTREPRISE_ADD_FORM)
            ]
        );

    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function add():  Response
    {
        $raison_socale = $_REQUEST["raison_sociale"];
        $adresse_voie = $_REQUEST["adresse_voie"];
        $code_naf = $_REQUEST["code_naf"];
        $telephone = $_REQUEST["telephone"];
        $email = $_REQUEST["email"];
        $siret = $_REQUEST["siret"];
        $statut_juridique = $_REQUEST["statut_juridique"];
        $type_structure = $_REQUEST["type_structure"];
        $effectif = $_REQUEST["effectif"];
        $site = $_REQUEST["site"];
        $fax = $_REQUEST["fax"];
        $id_code_postal = $_REQUEST["id_code_postal"];

        if (!Token::verify(Action::ENTREPRISE_ADD_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ENTREPRISE_ADD_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!is_null((new EntrepriseRepository)->getByEmail($email))) {
            throw new ControllerException(
                message: "Une entreprise avec cet email existe déjà",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isEmail($email)) {
            throw new ControllerException(
                message: "L'email n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isSiret($siret)) {
            throw new ControllerException(
                message: "Le numéro de SIRET n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isPhone($telephone)) {
            throw new ControllerException(
                message: "Le numéro de téléphone n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isFax($fax)) {
            throw new ControllerException(
                message: "Le numéro de fax n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isRaisonSociale($raison_socale)) {
            throw new ControllerException(
                message: "La raison sociale n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        /*if (!Validate::isUrl($site)) {
            throw new ControllerException(
                message: "L'url du site n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }*/
        if (!Validate::isAdresse($adresse_voie)) {
            throw new ControllerException(
                message: "L'adresse n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isCodePostal($id_code_postal)) {
            throw new ControllerException(
                message: "Le code postal n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isCodeNaf($code_naf)) {
            throw new ControllerException(
                message: "Le code NAF n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isStatutJuridique($statut_juridique)) {
            throw new ControllerException(
                message: "Le statut juridique n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isEffectif($effectif)) {
            throw new ControllerException(
                message: "L'effectif n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeStructure($type_structure)) {
            throw new ControllerException(
                message: "Le type de structure n'est pas valide",
                action: Action::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }

        FlashMessage::add(
            content: "L'entreprise a été ajoutée avec succès",
            type: FlashType::SUCCESS
        );
        (new EntrepriseRepository)->insert(
            new Entreprise(
                email: $email,
                raison_sociale: $raison_socale,
                adresse_voie: $adresse_voie,
                code_naf: $code_naf,
                telephone: $telephone,
                siret: $siret,
                statut_juridique: $statut_juridique,
                type_structure: $type_structure,
                effectif: $effectif,
                site: $site,
                fax: $fax,
                id_code_postal: $id_code_postal
            )
        );
        return new Response(
            action: Action::HOME
        );
    }

    public function creation_offre_form(string $email = null): Response {
        return new Response(
            template: "entreprise/creationOffreForm.php",
            params: [
                "email" => $email,
                "token" => Token::generateToken(Action::ENTREPRISE_CREATION_OFFRE_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function creation_offre(): Response{
        $description = $_REQUEST["description"];
        $secteur = $_REQUEST["secteur"];
        $thematique = $_REQUEST["thematique"];
        $tache = $_REQUEST["tache"];
        $commentaire = $_REQUEST["commentaire"];
        $gratification = $_REQUEST["gratification"];
        $unite_gratification = $_REQUEST["unite_gratification"];
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


        if (!Token::verify(Action::ENTREPRISE_CREATION_OFFRE_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(Action::ENTREPRISE_CREATION_OFFRE_FORM)) {
            throw new TokenTimeoutException(
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isTypeDescription($description)) {
            throw new ControllerException(
                message: "La description n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isTypeSecteur($secteur)) {
            throw new ControllerException(
                message: "Le secteur n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isTypeThematique($thematique)) {
            throw new ControllerException(
                message: "L'effectif n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isTypeTache($tache)) {
            throw new ControllerException(
                message: "La tache n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isTypeCommentaire($commentaire)) {
            throw new ControllerException(
                message: "Le commmentaire n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isTypeGratification($gratification)) {
            throw new ControllerException(
                message: "La gratification n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        if (!Validate::isTypeUniteGratification($unite_gratification)) {
            throw new ControllerException(
                message: "L'unite de gratification n'est pas valide",
                action: Action::ENTREPRISE_CREATION_OFFRE_FORM,
            );
        }
        FlashMessage::add(
            content: "L'offre a été ajoutée avec succès",
            type: FlashType::SUCCESS
        );
        (new OffreRepository())->insert(
            new Offre(
                id_entreprise: $id_entreprise,
                description: $description,
                secteur: $secteur,
                thematique: $thematique,
                tache: $tache,
                commentaire: $commentaire,
                gratification: $gratification,
                unite_gratification: $unite_gratification,
            )
        );
        return new Response(
            action: Action::HOME,
        );

    }
}