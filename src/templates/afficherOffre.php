<?php
use \Stageo\Model\Object\Offre;
use Stageo\Lib\enums\Action;

include "macros/button.php";
include "macros/input.php";
include "macros/offre.php";
/**
 * @var Offre $offre
 */
?>
<main class="w-[64rem]">
    <section class="bg-gray-100 py-8  flex justify-center items-center ">
        <h5 class="align-middle">Détails</h5>
    </section>
    <section class="flex flex-col">
        <div class="flex flex-row !space-x-9">
            <div class="flex flex-col w-1/2">
                <h7 class=" flex items-center justify-center">
                    <p class="mb-3 font-normal text-black dark:text-gray-400"> offre Stage </p>
                </h7>
                <img class=" !p-[10px] object-cover !rounded-l-lg !rounded-r-lg md:h-auto md:w-auto md:rounded-none md:rounded-l-lg  border-blue-500" src="assets/img/iut.jpg" alt="">
            </div>
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Secteur</dt>
                    <dd class="text-lg text-black font-semibold"> <?= $offre->getSecteur() ?></dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Tache</dt>
                    <dd class="text-lg text-black font-semibold"><?= $offre->getTache() ?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Thematique</dt>
                    <dd class="text-lg text-black font-semibold"><?= $offre->getThematique() ?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Gratification</dt>
                    <dd class="text-lg text-black font-semibold"><?= $offre->getGratification() ?> <?= $offre->getUniteGratification() ?></dd>
                </div>
            </dl>
        </div>
        <div class="grid grid-rows-2 gap-4 ">
            <p class="flex pl-2 justify-center items-center">
                <?= $offre->getDescription() ?>
            </p>
            <p class="flex pl-2 justify-center items-center">
                <?= $offre->getCommentaire() ?>
            </p>
        </div>
    </section>
</main>
