<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Offre;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
include __DIR__ . "/../../macros/offre.php";
/**
 * @var Offre $offre
 * @var string $unite_gratification
 */
?>

<main class="w-[64rem]">
    <?=button("Retour", "fi-rr-angle-small-left", Action::LISTE_OFFRE, "!absolute !pl-2 top-16 left-0")?>
    <section class="bg-gray-100 py-8  flex justify-center items-center ">
        <h5 class="align-middle"><?=$offre->getThematique()?></h5>
    </section>
    <section class="flex flex-col">
        <div class="flex flex-row !space-x-9">
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Secteur</dt>
                    <dd class="text-lg text-black font-semibold"> <?=$offre->getSecteur()?></dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Fonctions & tâches</dt>
                    <dd class="text-lg text-black font-semibold"><?=$offre->getTaches()?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Gratification</dt>
                    <dd class="text-lg text-black font-semibold"><?=$offre->getGratification()?>€ <?=$unite_gratification?>/heure</dd>
                </div>
            </dl>
        </div>
        <div class="grid grid-rows-2 gap-4 ">
            <p class="flex pl-2 justify-center items-center">
                <?=$offre->getDescription()?>
            </p>
            <p class="flex pl-2 justify-center items-center">
                <?=$offre->getCommentaires()?>
            </p>
        </div>
    </section>
</main>