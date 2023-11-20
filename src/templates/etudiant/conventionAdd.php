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
        <?=dropdown("type_convention", "Type de convention*", "Sélectionnez un type de convention", null, $convention->getTypeConvention(), $type_conventions)?>
        <?=field("origine_stage", "Origine du stage*", "text", "Entrez l'origine de la mission", null, true)?>
        <?=dropdown("annee_universitaire", "Année universitaire*", "Sélectionnez une année universitaire", null ,$convention->getAnneeUniversitaire(), $annees_universitaires)?>
        <?=dropdown("thematique", "Thématique*", "Sélectionnez une thématique", null, $convention->getThematique(), $thematiques)?>
        <?=field("sujet", "Sujet*", "text", "Entrez le sujet", null, true)?>
        <?=field("taches", "Tâches*", "text", "Entrez les tâches", null, true)?>
        <?=field("commentaires" , "Commentaires", "text", "Entrez un commentaire", null, false, $convention->getCommentaires())?>
        <?=field("details" , "Détails", "text", "Entrez des détails", null, false, $convention->getDetails())?>
        <?=field("date_debut", "Date de début*", "date", "Entrez la date de début", null, true)?>
        <?=field("date_fin", "Date de fin*", "date", "Entrez la date de fin", null, true)?>
        <?=dropdown("interruption", "Interruption", "Selectionnez l'état d'interruption", null, $convention->getInterruption(), $interruption)?>
        <?=field("date_debut_interruption", "Date de début de l'interruption", "date", "Entrez la date de début de l'interruption", null ,false, $convention->getDateInterruptionDebut())?>
        <?=field("date_fin_interruption", "Date de fin de l'interruption", "date", "Entrez la date de fin de l'interruption", null, false, $convention->getDateInterruptionFin())?>
        <?=field("heures_total", "Heures total*", "number", "Entrez les heures total", null, true)?>
        <?=field("jours_hebdomadaire", "Jours hebdomadaire*", "number", "Entrez les jours hebdomadaire", null, true)?>
        <?=field("heures_hebdomadaire", "Heures hebdomadaire*", "number", "Entrez les heures hebdomadaire", null, true)?>
        <?=field("commentaire_duree", "Commentaire durée", "text", "Entrez un commentaire sur la durée", null, false , $convention->getCommentairesDuree())?>
        <?=field("gratification", "Gratification*", "float", "Entrez la gratification", null, true, $gratification)?>
        <?=dropdown("id_unite_gratification", "Unité de gratification", null, null, 2, $unite_gratifications)?>
        <?=field("avantages_nature", "Avantages nature", "text", "Entrez les avantages nature", null, false, $convention->getAvantagesNature())?>
        <?=field("code_elp", "Code ELP", "text", "Entrez le code ELP", null, false, $convention->getCodeElp())?>
        <?=field("numero_voie", "Adresse de l'établissement où se déroule la mission", "text", null, Pattern::NAME, false, $convention->getNumeroVoie())?>
        <?=dropdown("id_distribution_commune", "Commune", "Sélectionnez une commune*", null, $convention->getIdDistributioncommune(), $distributions_commune)?>
        <?=dropdown("entreprise", "Entreprise", "Sélectionnez une entreprise*", null, $convention->getIdEntreprise(), $entreprisesNom )?>
        <?=submit("Déposer la convention", "col-span-2")?>
        <?=token($token)?>
    </form>
</main>