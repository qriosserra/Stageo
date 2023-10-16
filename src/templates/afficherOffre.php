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
        <div class="flex flex-row">
            <div class="flex flex-col">
                <h7>
                    <p class="mb-3 font-normal text-black dark:text-gray-400"> fujvihjk </p>
                </h7>
                <img class="object-cover md:h-auto md:w-auto md:rounded-none md:rounded-l-lg border-blue-500" src="assets/img/DuréeB.jpg" alt="">
            </div>
            <p>
                <?= $offre->getDescription() ?>
            </p>
        </div>
        <p><?= $offre->getSecteur() ?></p>
        <p><?= $offre->getTache() ?></p>
        <p><?= $offre->getThematique() ?></p>
        <p><?= $offre->getUniteGratification() ?></p>
    </section>
</main>
