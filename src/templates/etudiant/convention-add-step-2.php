<?php

use Stageo\Lib\enums\Pattern;
use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
/**
 * @var string $token
 * @var Convention $convention
 * @var array $type_conventions
 * @var array $annees_universitaires
 * @var array $unite_gratifications
 * @var float $gratification
 */
?>
<main class="bg-gray-100 w-full">
    <nav class="flex justify-between items-center border-b">
        <a href="<?=Action::HOME->value?>" class="inline-flex items-center">
            <div class="mt-3 ml-3">
                <img src="assets/img/logo.png" class="h-[1.8rem] w-[7rem]">
                <p style="font-family: Montserrat,serif;" class="text-blue-900">Pour les étudiants</p>
            </div>
        </a>
    </nav>
    <div class="flex items-center justify-center h-40 bg-gradient-to-r from-cyan-500 via-blue-800 to-blue-400 font-bold text-white">
        <span class="text-center" style="font-size: clamp(1rem, 5vw, 2rem)">Créer une convention</span>
    </div>
    <div class="max-w-lg mx-auto p-8 space-y-4">
        <h4 class="text-center">Périodes et rémunération</h4>
        <form action="<?=Action::ETUDIANT_CONVENTION_ADD_STEP_2->value?>" method="post" class="bg-white p-6 grid grid-cols-2 gap-4 rounded shadow-md border-t-4 border-blue-500">
            <?=field("date_debut", "Date de début", "date", "Entrez la date de début", null, false, $convention->getDateDebut())?>
            <?=field("date_fin", "Date de fin", "date", "Entrez la date de fin", null, false, $convention->getDateFin())?>
            <!--               --><?php //=dropdown("interruption", "Interruption", $convention->getInterruption(), null, false, [false => "Non", true => "Oui"])?>
            <!--               --><?php //=field("date_debut_interruption", "Date de début de l'interruption", "date", "Entrez la date de début de l'interruption", null ,false, $convention->getDateInterruptionDebut())?>
            <!--               --><?php //=field("date_fin_interruption", "Date de fin de l'interruption", "date", "Entrez la date de fin de l'interruption", null, false, $convention->getDateInterruptionFin())?>
            <?=dropdown("annee_universitaire", "Année universitaire", $convention->getAnneeUniversitaire(), null ,"2023-2024", $annees_universitaires)?>
            <?=field("heures_total", "Heures total", "number", "Entrez les heures total", null, false, $convention->getHeuresTotal())?>
            <?=field("jours_hebdomadaire", "Jours hebdomadaire", "number", "Entrez les jours de travail hebdomadaire", null, false, $convention->getJoursHebdomadaire())?>
            <?=field("heures_hebdomadaire", "Heures hebdomadaire", "number", "Entrez les heures de travail hebdomadaire", null, false, $convention->getHeuresHebdomadaire())?>
            <?=textarea("commentaire_duree", "Commentaire durée", "Entrez un commentaire sur la durée", 4, false , $convention->getCommentairesDuree(), "col-span-2")?>
            <?=field("gratification", "Gratification*", "float", "Entrez la gratification", null, false, $gratification)?>
            <?=dropdown("id_unite_gratification", "Unité de gratification", $convention->getIdUniteGratification(), null, 2, $unite_gratifications)?>
            <?=textarea("avantages_nature", "Avantages nature", "Entrez les avantages nature", 4, false, $convention->getAvantagesNature(), "col-span-2")?>
            <?=submit("Suivant", "col-span-2")?>
            <?=token($token)?>
        </form>
    </div>
</main>