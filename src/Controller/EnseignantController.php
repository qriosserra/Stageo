<?php

namespace Stageo\Controller;

use Stageo\Controller\Exception\ControllerException;
use Stageo\Controller\Exception\InvalidTokenException;
use Stageo\Controller\Exception\TokenTimeoutException;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\LogicalOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\FlashMessage;
use Stageo\Lib\HTTP\Session;
use Stageo\Lib\Response;
use Stageo\Lib\Security\Password;
use Stageo\Lib\Security\Token;
use Stageo\Lib\Security\Validate;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\DistributionCommune;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Offre;
use Stageo\Model\Object\Postuler;
use Stageo\Model\Repository\DistributionCommuneRepository;
use Stageo\Model\Repository\EntrepriseRepository;
use Stageo\Model\Repository\EtudiantRepository;
use Stageo\Model\Repository\ConventionRepository;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\PostulerRepository;
use Stageo\Model\Repository\UniteGratificationRepository;

class EnseignantController
{
    public function tutorerEtudiantForm(): Response
    {
        if (!UserConnection::isInstance(new Enseignant()) and !UserConnection::isInstance(new Admin())) {
            throw new ControllerException("Vous n'êtes pas autorisé à accéder à cette page");
        }
        /**
         * @var Convention[] $conventions
         * @var Enseignant $enseignant
         * @var Etudiant[] $etudiants
         * @var Convention[] $conventionsSuivies
         * @var DistributionCommune[] $communes
         */
        $enseignant = UserConnection::getSignedInUser();
        $etudiants = [];
        $entreprises = [];
        $communes = [];
        $etudiantsSuivis = [];

        $conventions = (new ConventionRepository)->getWhereLoginEnseignantIsNull();
        $etudiants = (new EtudiantRepository())->getWhereLoginEnseignantIsNull();
        foreach ($conventions as $convention) {
            $entreprises[] = (new EntrepriseRepository)->select([
                new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $convention->getIdEntreprise())
            ])[0];
        }
        foreach ($conventions as $convention) {
            $communes[] = (new DistributionCommuneRepository)->select([
                new QueryCondition("id_distribution_commune", ComparisonOperator::EQUAL, $convention->getIdDistributionCommune())
            ])[0];
        }
        $conventionsSuivies = (new ConventionRepository)->select([
            new QueryCondition("login_enseignant", ComparisonOperator::EQUAL, $enseignant->getLogin())
        ]);
        foreach ($conventionsSuivies as $conventionSuivie) {
            $etudiantsSuivis[] = (new EtudiantRepository)->select([
                new QueryCondition("login", ComparisonOperator::EQUAL, $conventionSuivie->getLogin())
            ])[0];
        }

        return new Response(
            template: "enseignant/tutorer-etudiant.php",
            params: [
                "title" => "Liste des étudiants à tutorer",
                "nav" => false,
                "footer" => false,
                "conventions" => $conventions,
                "etudiants" => $etudiants,
                "entreprises" => $entreprises,
                "communes" => $communes,
                "etudiantsSuivis" => $etudiantsSuivis
            ]
        );
    }

    public function tutorerEtudiant(): Response
    {
        if (!UserConnection::isInstance(new Enseignant()) and !UserConnection::isInstance(new Admin())) {
            throw new ControllerException("Vous n'êtes pas autorisé à accéder à cette page");
        }
        $enseignant = UserConnection::getSignedInUser();

        $id_conventions = $_REQUEST["id_conventions"];
        foreach ($id_conventions as $id_convention) {
            $convention = new Convention();
            $convention->setIdConvention($id_convention);
            $convention->setLoginEnseignant($enseignant->getLogin());
            (new ConventionRepository)->update($convention);
        }

        return new Response(
            action: Action::ENSEIGNANT_TUTORER_ETUDIANT_FORM,
        );
    }
}