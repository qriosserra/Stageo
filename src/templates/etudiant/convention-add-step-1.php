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
        <h4 class="text-center">Informations générales</h4>
        <form action="<?=Action::ETUDIANT_CONVENTION_ADD_STEP_1->value?>" method="post" class="bg-white grid grid-cols-2 gap-4 p-6 rounded shadow-md border-t-4 border-blue-500">
            <?=field("thematique", "Thématique", "text", "Entrez la thématique de la convention", Pattern::NAME, false, $convention->getThematique(), "col-span-2")?>
            <?=field("sujet", "Sujet", "text", "Entrez le sujet", Pattern::NAME, false, $convention->getSujet(), "col-span-2")?>
            <?=field("origine_stage", "Origine du stage", "text", "Entrez l'origine de la mission", PATTERN::NAME, false, $convention->getOrigineStage())?>
            <?=dropdown("type_convention", "Type de convention", "Choisissez un type de convention", null, $convention->getTypeConvention(), $type_conventions)?>
            <?=textarea("taches", "Tâches", "Entrez les tâches et fonctions que vous aurez en entreprise", 4, false, $convention->getTaches(), "col-span-2")?>
            <?=textarea("commentaires" , "Commentaires", "Entrez les commentaires", 4, false, $convention->getCommentaires(), "col-span-2")?>
            <?=textarea("details" , "Détails", "Entrez les détails", 4, false, $convention->getDetails(), "col-span-2")?>
            <?=submit("Suivant", "col-span-2")?>
            <?=token($token)?>
        </form>
    </div>
</main>