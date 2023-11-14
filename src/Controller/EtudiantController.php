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

        // Récupérer les données du formulaire
        $type_convention = $_REQUEST["type_convention"];
        $origine_stage = $_REQUEST["origine_stage"];
        $annee_universitaire = $_REQUEST["annee_universitaire"];
        $thematique = $_REQUEST["thematique"];
        $sujet = $_REQUEST["sujet"];
        $taches = $_REQUEST["taches"];
        $commentaires = $_REQUEST["commentaires"];
        $details = $_REQUEST["details"];
        $date_debut = $_REQUEST["date_debut"];
        $date_fin = $_REQUEST["date_fin"];
        $interruption = $_REQUEST["interruption"];
        $date_interruption_debut = $_REQUEST["date_interruption_debut"];
        $date_interruption_fin = $_REQUEST["date_interruption_fin"];
        $heures_total = $_REQUEST["heures_total"];
        $jours_hebdomadaire = $_REQUEST["jours_hebdomadaire"];
        $heures_hebdomadaires = $_REQUEST["heures_hebdomadaires"];
        $commentaires_duree = $_REQUEST["commentaires_duree"];
        $gratification = $_REQUEST["gratification"];
        $avantages_nature = $_REQUEST["avantages_nature"];
        $code_elp = $_REQUEST["code_elp"];
        $numero_voie = $_REQUEST["numero_voie"];
        $id_unite_gratification = $_REQUEST["id_unite_gratification"];
        $id_entreprise = $_REQUEST["id_entreprise"];
        $id_tuteur = $_REQUEST["id_tuteur"];
        $id_enseignant = $_REQUEST["id_enseignant"];


        // Créer une nouvelle convention et définir ses propriétés
        $convention = new Convention(
            //mettre dans l'ordre :
           /* login: $etudiant->getLogin(),
            type_convention: $type_convention,
            origine_stage: $origine_stage,
            annee_universitaire: $annee_universitaire,
            thematique: $thematique,
            sujet: $sujet,
            taches: $taches,
            commentaires: $commentaires,
            details: $details,
            date_debut: $date_debut,
            date_fin: $date_fin,
            interruption: $interruption,
            date_interruption_debut: $date_interruption_debut,
            date_interruption_fin: $date_interruption_fin,
            heures_total: $heures_total,
            jours_hebdomadaire: $jours_hebdomadaire,
            heures_hebdomadaire: $heures_hebdomadaires,
            commentaires_duree: $commentaires_duree,
            gratification: $gratification,
            avantages_nature: $avantages_nature,
            code_elp: $code_elp,
            numero_voie: $numero_voie,
            id_unite_gratification: $id_unite_gratification,
            id_entreprise: $id_entreprise,
            id_tuteur: $id_tuteur,
            id_enseignant: $id_enseignant*/
        // dans l'ordre :
        login: $etudiant->getLogin(),
        type_convention: $type_convention,
        origine_stage: $origine_stage,
        annee_universitaire: $annee_universitaire,
        thematique: $thematique,
        sujet: $sujet,
        taches: $taches,
        commentaires: $commentaires,
        details: $details,
        date_debut: $date_debut,
        date_fin: $date_fin,
        interruption: $interruption,
        date_interruption_debut: $date_interruption_debut,
        date_interruption_fin: $date_interruption_fin,
        heures_total: $heures_total,
        jours_hebdomadaire: $jours_hebdomadaire,
        heures_hebdomadaire: $heures_hebdomadaires,
        commentaires_duree: $commentaires_duree,
        gratification: $gratification,
avantages_nature: $avantages_nature,
code_elp: $code_elp,
numero_voie: $numero_voie,

        );

        // Insérer la convention dans la base de données
        $conventionRepository = new ConventionRepository();
        $conventionRepository->insert($convention);

        // Ajouter un message Flash de succès
        FlashMessage::add(
            content: "Votre convention a bien été déposée",
            type: FlashType::SUCCESS
        );

        // Rediriger l'utilisateur vers la page d'accueil
        return new Response(
            action: Action::HOME
        );
    }


}