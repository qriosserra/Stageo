<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;

/**
 * @var Entreprise $entreprise
 */

/**
 * @param string|null $description
 * @param string $thematique
 * @param string|null $id_offre
 * @param string|null $entreprise_picture_path
 * @param string|null $class
 * @return string
 */
function offre(string $thematique,
               string $description = null,
               string $id_offre = null,
               string $nom_entreprise = null,
               string $entreprise_picture_path = null,
               string $class = null): string

{
    $action = Action::AFFICHER_OFFRE->value . "&id=$id_offre";
    $entreprise_picture_path = (is_null($entreprise_picture_path))
        ? "assets/img/FAQB.jpg"
        : $entreprise_picture_path;
    return <<<HTML
    <div class="items-center bg-white border border-blue-500 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 $class">
        <a href="$action" class="h-full flex flex-row">
            <div class="flex flex-col justify-between p-4 leading-normal">
                <img class="object-cover w-1/2 rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg border-blue-500" src="$entreprise_picture_path" alt="">
                <h7>
                    <p class="mb-3 font-normal text-black dark:text-gray-400">$nom_entreprise</p>
                </h7>
            </div>
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-black dark:text-white">$thematique</h5>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$description</p>
            </div>
        </a>
    </div>
HTML;
}




?>