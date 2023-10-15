<?php

namespace Stageo\Controller;
use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\UserConnection;
use Stageo\Lib\Validate;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Offre;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\OffreRepository;

class EntrepriseController extends UserController
{
    /**
     * @throws ControllerException
     */
    public function addForm(string $email = null): ControllerResponse {
        return new ControllerResponse(
            template: "entreprise/add.html.twig",
            params: [
                "email" => $email,
                "token" => Token::generateToken(RouteName::ENTREPRISE_ADD_FORM)
            ]
        );

    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function add() :  ControllerResponse
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
        $password = $_REQUEST["password"];
        $id_code_postal = $_REQUEST["id_code_postal"];

        if (!Token::verify(RouteName::ENTREPRISE_ADD_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(RouteName::ENTREPRISE_ADD_FORM)) {
            throw new TokenTimeoutException(
                routeName: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!is_null((new EntrepriseRepository)->getByEmail($email))) {
            throw new ControllerException(
                message: "Une entreprise avec cet email existe déjà",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isEmail($email)) {
            throw new ControllerException(
                message: "L'email n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isSiret($siret)) {
            throw new ControllerException(
                message: "Le numéro de SIRET n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isPhone($telephone)) {
            throw new ControllerException(
                message: "Le numéro de téléphone n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isFax($fax)) {
            throw new ControllerException(
                message: "Le numéro de fax n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isRaisonSociale($raison_socale)) {
            throw new ControllerException(
                message: "La raison sociale n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        /*if (!Validate::isUrl($site)) {
            throw new ControllerException(
                message: "L'url du site n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }*/
        if (!Validate::isAdresse($adresse_voie)) {
            throw new ControllerException(
                message: "L'adresse n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        //En commentaire car changement dans base de donnée
        /*if (!Validate::isCodePostal($id_code_postal)) {
            throw new ControllerException(
                message: "Le code postal n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }*/
        if (!Validate::isCodeNaf($code_naf)) {
            throw new ControllerException(
                message: "Le code NAF n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isStatutJuridique($statut_juridique)) {
            throw new ControllerException(
                message: "Le statut juridique n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isEffectif($effectif)) {
            throw new ControllerException(
                message: "L'effectif n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeStructure($type_structure)) {
            throw new ControllerException(
                message: "Le type de structure n'est pas valide",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isPassword($password)) {
            throw new ControllerException(
                message: "Le mot de passe ne respecte pas les critères de sécurité",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if ($password !== $_REQUEST["confirm"]) {
            throw new ControllerException(
                message: "Les mots de passe ne correspondent pas",
                redirection: RouteName::ENTREPRISE_ADD_FORM,
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
                hashed_password: Password::hash($password),
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
                //id_code_postal: $id_code_postal
            )
        );
        return new ControllerResponse(
            redirection: RouteName::HOME,
            statusCode: StatusCode::ACCEPTED
        );
    }

    public function creation_offre_form(string $email = null): ControllerResponse {
        return new ControllerResponse(
            template: "entreprise/creaOffreForm.html.twig",
            params: [
                "email" => $email,
                "token" => Token::generateToken(RouteName::ENTREPRISE_CREATION_OFFRE_FORM)
            ]
        );
    }

    /**
     * @throws TokenTimeoutException
     * @throws ControllerException
     * @throws InvalidTokenException
     */
    public function creation_offre(): ControllerResponse{
        $description = $_REQUEST["description"];
        $secteur = $_REQUEST["secteur"];
        $thematique = $_REQUEST["thematique"];
        $tache = $_REQUEST["tache"];
        $commentaire = $_REQUEST["commentaire"];
        $gratification = $_REQUEST["gratification"];
        $unite_gratification = $_REQUEST["unite_gratification"];

        //Je sais pas quoi faire pour récup le mail
        $email = $_REQUEST["email"];

        if (!Token::verify(RouteName::ENTREPRISE_CREATION_OFFRE_FORM, $_REQUEST["token"]))
            throw new InvalidTokenException();
        if (Token::isTimeout(RouteName::ENTREPRISE_CREATION_OFFRE_FORM)) {
            throw new TokenTimeoutException(
                routeName: RouteName::ENTREPRISE_CREATION_OFFRE_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeDescription($description)) {
            throw new ControllerException(
                message: "La description n'est pas valide",
                redirection: RouteName::ENTREPRISE_CREATION_OFFRE_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeSecteur($secteur)) {
            throw new ControllerException(
                message: "Le secteur n'est pas valide",
                redirection: RouteName::ENTREPRISE_CREATION_OFFRE_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeThematique($thematique)) {
            throw new ControllerException(
                message: "La thematique n'est pas valide",
                redirection: RouteName::ENTREPRISE_CREATION_OFFRE_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeTache($tache)) {
            throw new ControllerException(
                message: "La tache n'est pas valide",
                redirection: RouteName::ENTREPRISE_CREATION_OFFRE_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeCommentaire($commentaire)) {
            throw new ControllerException(
                message: "Le commmentaire n'est pas valide",
                redirection: RouteName::ENTREPRISE_CREATION_OFFRE_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeGratification($gratification)) {
            throw new ControllerException(
                message: "La gratification n'est pas valide",
                redirection: RouteName::ENTREPRISE_CREATION_OFFRE_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        if (!Validate::isTypeUniteGratification($unite_gratification)) {
            throw new ControllerException(
                message: "L'unite de gratification n'est pas valide",
                redirection: RouteName::ENTREPRISE_CREATION_OFFRE_FORM,
                params: [
                    "email" => $email
                ]
            );
        }
        FlashMessage::add(
            content: "L'offre a été ajoutée avec succès",
            type: FlashType::SUCCESS
        );
        (new OffreRepository())->insert(
            new Offre(
                id_entreprise: 1,
                description: $description,
                secteur: $secteur,
                thematique: $thematique,
                tache: $tache,
                commentaire: $commentaire,
                gratification: $gratification,
                unite_gratification: $unite_gratification,
            )
        );
        return new ControllerResponse(
            redirection: RouteName::HOME,
            statusCode: StatusCode::ACCEPTED
        );

    }



}