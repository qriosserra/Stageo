<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Convention;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";

/**
 * @var Convention $convention
 * @var string $token
 * @var array $type_conventions
 * @var array $annees_universitaires
 * @var array $unite_gratifications
 * @var array $distributions_commune
 * @var array $nomsEntreprise
 * @var float $gratification
 */
?>


<main class="mt-24">
    <form action="<?=Action::ETUDIANT_CONVENTION_ADD_STEP_1->value?>" method="post" class="bg-white w-[60vw] p-12 mx-auto text-gray-600 rounded-lg shadow-lg grid grid-cols-2 gap-8">
        <h5 class="col-span-2">Déposer une convention</h5>
        <?=dropdown("type_convention", "Type de convention*", $convention->getTypeConvention(), null, 1 , $type_conventions)?>
        <?=field("origine_stage", "Origine du stage*", "text", "Entrez l'origine de la mission", PATTERN::NAME, true, $convention->getOrigineStage())?>
        <?=dropdown("annee_universitaire", "Année universitaire*", $convention->getAnneeUniversitaire(), null ,"2023-2024", $annees_universitaires)?>
        <?=field("thematique", "Thématique*", "text", "Entrez la thématique de la convention", Pattern::NAME, false, $convention->getThematique())?>
        <?=field("sujet", "Sujet*", "text", "Entrez le sujet", Pattern::NAME, true, $convention->getSujet())?>
        <?=textarea("taches", "Tâches*", "Entrez les tâches et fonctions que vous aurez en entreprise", 4, false, $convention->getTaches())?>
        <?=textarea("commentaires" , "Commentaires", "Entrez les commentaires", 4, false, $convention->getCommentaires())?>
        <?=textarea("details" , "Détails", "Entrez les détails", 4, false, $convention->getDetails())?>
        <?=field("date_debut", "Date de début*", "date", "Entrez la date de début", null, true, $convention->getDateDebut())?>
        <?=field("date_fin", "Date de fin*", "date", "Entrez la date de fin", null, true, $convention->getDateFin())?>
        <?=dropdown("interruption", "Interruption*", $convention->getInterruption(), null, false, [false => "Non", true => "Oui"])?>
        <?=field("date_debut_interruption", "Date de début de l'interruption", "date", "Entrez la date de début de l'interruption", null ,false, $convention->getDateInterruptionDebut())?>
        <?=field("date_fin_interruption", "Date de fin de l'interruption", "date", "Entrez la date de fin de l'interruption", null, false, $convention->getDateInterruptionFin())?>
        <?=field("heures_total", "Heures total*", "number", "Entrez les heures total", null, true, $convention->getHeuresTotal())?>
        <?=field("jours_hebdomadaire", "Jours de travail hebdomadaire*", "number", "Entrez les jours de travail hebdomadaire", null, true, $convention->getJoursHebdomadaire())?>
        <?=field("heures_hebdomadaire", "Heures de travail hebdomadaire*", "number", "Entrez les heures de travail hebdomadaire", null, true, $convention->getHeuresHebdomadaire())?>
        <?=field("commentaire_duree", "Commentaire durée", "text", "Entrez un commentaire sur la durée", null, false , $convention->getCommentairesDuree())?>
        <?=field("gratification", "Gratification*", "float", "Entrez la gratification", null, true, $gratification)?>
        <?=dropdown("id_unite_gratification", "Unité de gratification*", $convention->getIdUniteGratification(), null, 2, $unite_gratifications)?>
        <?=textarea("avantages_nature", "Avantages nature", "Entrez les avantages nature", 4, false, $convention->getAvantagesNature())?>
        <?=field("numero_voie", "Adresse de l'établissement où se déroule la mission", "text", null, Pattern::NAME, false, $convention->getNumeroVoie())?>
        <?=dropdown("id_distribution_commune", "Commune*", $convention->getIdDistributionCommune(), null, 1 , $distributions_commune)?>
        <?=dropdown("entreprise", "Entreprise*", $convention->getIdEntreprise(), null, 1, $nomsEntreprise )?>
        <?=submit("Déposer la convention", "col-span-2")?>
        <?=submit("Enregistrer en tant que brouillon", "col-span-2")?>
        <?=token($token)?>
    </form>
</main>