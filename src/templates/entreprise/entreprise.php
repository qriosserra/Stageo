<?php

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/entreprise.php";
/**
 * @var \Stageo\Model\Object\Entreprise $entreprise
 */
?>

<main class="h-screen flex flex-col items-center justify-center">
    <h5 class="font-bold py-6"><?=$entreprise->getRaisonSociale()?></h5>
        <div class="flex flex-row !space-x-9">
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Adresse</dt>
                    <dd class="text-lg text-black font-semibold"><?=$entreprise->getNumeroVoie()?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Ville</dt>
                    <dd class="text-lg text-black font-semibold"><?=$entreprise->getIdDistributionCommune()?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Téléphone</dt>
                    <dd class="text-lg text-black font-semibold"><?=$entreprise->getTelephone()?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Email</dt>
                    <dd class="text-lg text-black font-semibold"><?=$entreprise->getEmail()?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Site</dt>
                    <dd class="text-lg text-black font-semibold"><?=$entreprise->getSite()?></dd>
                </div>