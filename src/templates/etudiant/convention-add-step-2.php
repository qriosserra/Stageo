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
        <h4 class="text-center">Information générale</h4>
        <form action="<?=Action::ENTREPRISE_SIGN_UP_STEP_1->value?>" method="post" class="bg-white p-6 rounded shadow-md border-t-4 border-blue-500 space-y-4">
            <form class="bg-white p-12 text-gray-600 rounded-lg shadow-lg grid gap-8" action="<?=Action::ETUDIANT_CONVENTION_ADD_STEP_2->value?>" method="post">
                <?=field("date_debut", "Date de début*", "date", "Entrez la date de début", null, true, $convention->getDateDebut())?>
                <?=field("date_fin", "Date de fin*", "date", "Entrez la date de fin", null, true, $convention->getDateFin())?>
<!--                --><?php //=dropdown("interruption", "Interruption*", $convention->getInterruption(), null, false, [false => "Non", true => "Oui"])?>
<!--                --><?php //=field("date_debut_interruption", "Date de début de l'interruption", "date", "Entrez la date de début de l'interruption", null ,false, $convention->getDateInterruptionDebut())?>
<!--                --><?php //=field("date_fin_interruption", "Date de fin de l'interruption", "date", "Entrez la date de fin de l'interruption", null, false, $convention->getDateInterruptionFin())?>
                <?=field("heures_total", "Heures total*", "number", "Entrez les heures total", null, true, $convention->getHeuresTotal())?>
                <?=field("jours_hebdomadaire", "Jours de travail hebdomadaire*", "number", "Entrez les jours de travail hebdomadaire", null, true, $convention->getJoursHebdomadaire())?>
                <?=field("heures_hebdomadaire", "Heures de travail hebdomadaire*", "number", "Entrez les heures de travail hebdomadaire", null, true, $convention->getHeuresHebdomadaire())?>
                <?=field("commentaire_duree", "Commentaire durée", "text", "Entrez un commentaire sur la durée", null, false , $convention->getCommentairesDuree())?>
            </form>
        </form>
    </div>
</main>
<footer class="bg-gray-100 mt-10">
    <div class="mt-4 border-t border-gray-300 pt-3">
        <p class="text-gray-600 text-center">
            Se connecter en tant que : Etudiant, Entreprise
        </p>
        <p class="text-gray-500 text-xs text-center mt-4">
            Copyright © 2023, Stageo « Stageo » et son logo sont des branches officiel de l'IUT Montpellier-Sète.
        </p>
    </div>
    </div>
</footer>