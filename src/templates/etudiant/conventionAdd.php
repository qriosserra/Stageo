<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Convention;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";

/**
 * @var string $token
 * @var Convention $convention
 * @var array $pattern
 * @var array $distributions_commune
 * @var array $unite_gratifications
 * @var float $gratification
 * @var array $type_conventions
 * @var array $annees_universitaires
 * @var array $thematiques
 * @var array $entreprisesNom
 * @var array $interruption
 */
?>


<main class="mt-24">
    <form action="<?=Action::ETUDIANT_CONVENTION_ADD->value?>" method="post" class="bg-white w-[60vw] p-12 mx-auto text-gray-600 rounded-lg shadow-lg grid grid-cols-2 gap-8">
        <h5 class="col-span-2">Déposer une convention</h5>
        <?php if ($convention->getIdConvention() !== null): ?>
        <?php if ((new \Stageo\Model\Repository\SuiviRepository)->select([new \Stageo\Lib\Database\QueryCondition("id_convention", \Stageo\Lib\Database\ComparisonOperator::EQUAL, $convention->getIdConvention())])[0]->getModifiable() === true): ?>
        <?=dropdown("type_convention", "Type de convention*", $convention->getTypeConvention(), null, 1 , $type_conventions)?>
        <?=field("origine_stage", "Origine du stage*", "text", "Entrez l'origine de la mission", null, true, $convention->getOrigineStage())?>
        <?=dropdown("annee_universitaire", "Année universitaire*", $convention->getAnneeUniversitaire(), null ,"2023-2024", $annees_universitaires)?>
        <?=dropdown("thematique", "Thématique*", $convention->getThematique(), null, 1, $thematiques)?>
        <?=field("sujet", "Sujet*", "text", "Entrez le sujet", null, true, $convention->getSujet())?>
        <?=field("taches", "Tâches*", "text", "Entrez les tâches", null, true, $convention->getTaches())?>
        <?=field("commentaires" , "Commentaires", "text", "Entrez un commentaire", null, false, $convention->getCommentaires())?>
        <?=field("details" , "Détails", "text", "Entrez des détails", null, false, $convention->getDetails())?>
        <?=field("date_debut", "Date de début*", "date", "Entrez la date de début", null, true, $convention->getDateDebut())?>
        <?=field("date_fin", "Date de fin*", "date", "Entrez la date de fin", null, true, $convention->getDateFin())?>
        <?=dropdown("interruption", "Interruption*", $convention->getInterruption(), null, 0, $interruption)?>
        <?=field("date_debut_interruption", "Date de début de l'interruption", "date", "Entrez la date de début de l'interruption", null ,false, $convention->getDateInterruptionDebut())?>
        <?=field("date_fin_interruption", "Date de fin de l'interruption", "date", "Entrez la date de fin de l'interruption", null, false, $convention->getDateInterruptionFin())?>
        <?=field("heures_total", "Heures total*", "number", "Entrez les heures total", null, true, $convention->getHeuresTotal())?>
        <?=field("jours_hebdomadaire", "Jours hebdomadaire*", "number", "Entrez les jours hebdomadaire", null, true, $convention->getJoursHebdomadaire())?>
        <?=field("heures_hebdomadaire", "Heures hebdomadaire*", "number", "Entrez les heures hebdomadaire", null, true, $convention->getHeuresHebdomadaire())?>
        <?=field("commentaire_duree", "Commentaire durée", "text", "Entrez un commentaire sur la durée", null, false , $convention->getCommentairesDuree())?>
        <?=field("gratification", "Gratification*", "float", "Entrez la gratification", null, true, $gratification)?>
        <?=dropdown("id_unite_gratification", "Unité de gratification*", $convention->getIdUniteGratification(), null, 2, $unite_gratifications)?>
        <?=field("avantages_nature", "Avantages nature", "text", "Entrez les avantages nature", null, false, $convention->getAvantagesNature())?>
        <?=field("code_elp", "Code ELP", "text", "Entrez le code ELP", null, false, $convention->getCodeElp())?>
        <?=field("numero_voie", "Adresse de l'établissement où se déroule la mission", "text", null, Pattern::NAME, false, $convention->getNumeroVoie())?>
        <?=dropdown("id_distribution_commune", "Commune*", $convention->getIdDistributionCommune(), null, 1 , $distributions_commune)?>
        <?=dropdown("entreprise", "Entreprise*", $convention->getEntreprise(), null, 1, $entreprisesNom )?>
        <hidden name="id_convention" value="<?=$convention->getIdConvention()?>">
        <form action="<?=Action::ETUDIANT_CONVENTION_ADD_BROUILLON->value?>" method="post">
            <input type="hidden" name="token" value="<?=token($token)?>">
        <?=token($token)?>
            <?php endif; ?>
        <?php else: ?>
        <?=dropdown("type_convention", "Type de convention*", null, null, 1 , $type_conventions)?>
        <?=field("origine_stage", "Origine du stage*", "text", "Entrez l'origine de la mission", null, true)?>
        <?=dropdown("annee_universitaire", "Année universitaire*", null, null ,"2023-2024", $annees_universitaires)?>
        <?=dropdown("thematique", "Thématique*", null, null, 1, $thematiques)?>
        <?=field("sujet", "Sujet*", "text", "Entrez le sujet", null, true)?>
        <?=field("taches", "Tâches*", "text", "Entrez les tâches", null, true)?>
        <?=field("commentaires" , "Commentaires", "text", "Entrez un commentaire", null, false, $convention->getCommentaires())?>
        <?=field("details" , "Détails", "text", "Entrez des détails", null, false, $convention->getDetails())?>
        <?=field("date_debut", "Date de début*", "date", "Entrez la date de début", null, true)?>
        <?=field("date_fin", "Date de fin*", "date", "Entrez la date de fin", null, true)?>
        <?=dropdown("interruption", "Interruption*", null, null, 0, $interruption)?>
        <?=field("date_debut_interruption", "Date de début de l'interruption", "date", "Entrez la date de début de l'interruption", null ,false, $convention->getDateInterruptionDebut())?>
        <?=field("date_fin_interruption", "Date de fin de l'interruption", "date", "Entrez la date de fin de l'interruption", null, false, $convention->getDateInterruptionFin())?>
        <?=field("heures_total", "Heures total*", "number", "Entrez les heures total", null, true)?>
        <?=field("jours_hebdomadaire", "Jours hebdomadaire*", "number", "Entrez les jours hebdomadaire", null, true)?>
        <?=field("heures_hebdomadaire", "Heures hebdomadaire*", "number", "Entrez les heures hebdomadaire", null, true)?>
        <?=field("commentaire_duree", "Commentaire durée", "text", "Entrez un commentaire sur la durée", null, false , $convention->getCommentairesDuree())?>
        <?=field("gratification", "Gratification*", "float", "Entrez la gratification", null, true, $gratification)?>
        <?=dropdown("id_unite_gratification", "Unité de gratification*", null, null, 2, $unite_gratifications)?>
        <?=field("avantages_nature", "Avantages nature", "text", "Entrez les avantages nature", null, false, $convention->getAvantagesNature())?>
        <?=field("code_elp", "Code ELP", "text", "Entrez le code ELP", null, false, $convention->getCodeElp())?>
        <?=field("numero_voie", "Adresse de l'établissement où se déroule la mission", "text", null, Pattern::NAME, false, $convention->getNumeroVoie())?>
        <?=dropdown("id_distribution_commune", "Commune*", null, null, 1 , $distributions_commune)?>
        <?=dropdown("entreprise", "Entreprise*", null, null, 1, $entreprisesNom )?>
            <?php endif; ?>
        <?=submit("Déposer la convention", "col-span-2")?>
        <?=submit("Enregistrer en tant que brouillon", "col-span-2")?>
        <form action="<?=Action::ETUDIANT_CONVENTION_BROUILLON->value?>" method="post">
            <input type="hidden" name="token" value="<?=token($token)?>">
        <?=token($token)?>
    </form>
</main>