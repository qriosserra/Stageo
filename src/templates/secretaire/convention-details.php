<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Convention;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";

/**
 * @var string $token
 * @var Convention $convention
 */
?>


<!-- Lister toutes les informations de la convention : -->
<main>
    <div class="flex flex-col justify-between items-center bg-white p-4 rounded-lg shadow-lg">
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Login:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getLogin()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Sujet:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getSujet()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Date de début:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getDateDebut()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Date de fin:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getDateFin()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Détails:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getDetails()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Commentaires:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getCommentaires()?></p>
        </div>
        <div class="inline-flex">
            <h3   class="text-sm text-gray-500">Gratification:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getGratification()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Unite de gratification:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getIdUniteGratification()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Distribution commune:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getIdDistributionCommune()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Heures total:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getHeuresTotal()?></p>
        </div>
        <div class="inline-flex">
            <h3 class="text-sm text-gray-500">Heures hebdomadaire:</h3>
            <p class="text-sm text-gray-500"><?=$convention->getHeuresHebdomadaire()?></p>
        </div>
        <div class="inline-flex">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <a href="<?=Action::SECRETAIRE_CONVENTION_VALIDATION->value?>&id_convention=<?=$convention->getIdConvention()?>">Valider</a>
            </button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <a href="<?=Action::SECRETAIRE_CONVENTION_REFUS->value?>&id_convention=<?=$convention->getIdConvention()?>">Refuser</a>
            </button>
    </div>
</main>