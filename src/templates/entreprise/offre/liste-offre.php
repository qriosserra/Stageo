<?php

use Stageo\Model\Object\Categorie;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use \Stageo\Model\Object\Offre;
use Stageo\Lib\enums\Action;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
include __DIR__ . "/../../macros/offre.php";
/**
 * @var Categorie[] $categories
 * @var Etudiant $etudiant
 * @var Offre[] $offres
 * @var string $selA
 * @var string $selB
 * @var string $selC
 * @var string $search
 * @var Categorie $Categories
 */
?>

<main class="w-[64rem] flex flex-col gap-8 mt-8">









    <div>
        <form class="mb-3" action="<?=Action::LISTE_OFFRE->value?>" method="post">
            <div>
                <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown checkbox <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownDefaultCheckbox" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">

                    <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
                        <?php foreach ($Categories as $category):?>
                            <li>
                                <div class="flex items-center">
                                    <input name="categoriesSelectionnees[<?= $category->getLibelle() ?>]" id="<?= $category->getIdCategorie() ?>" type="checkbox" value="<?= $category->getIdCategorie() ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="<?= $category->getLibelle() ?>" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300" ><?= $category->getLibelle() ?></label>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
            <div class="relative flex flex-row flex-wrap items-stretch">
                <div class="w-64 ">
                    <select id="Option" name="OptionL" class="rounded-l-lg  w-full bg-white border border-blue-500 text-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="description" <?=$selA?>>Description</option>
                        <option value="secteur" <?=$selB?>>Secteur</option>
                        <option value="Categories" <?=$selC?>> Categories </option>
                    </select>
                </div>
                <input type="search"
                       class="relative bg-white m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto border border-solid border-blue-500 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                       name="search"
                       placeholder="<?=$search = (strlen($search) == 0) ? "Search" : $search?>"
                       aria-label="Search"
                       aria-describedby="button-addon1"  />
                <input type="submit" value="Rechercher" class="bg-blue-500 rounded-none !rounded-l-none !rounded-r-lg flex justify-center items-center">
            </div>
        </form>
    </div>



    <div class="grid grid-cols-2 gap-4 overflow-hidden overflow-x-auto whitespace-no-wrap bg-gray-100">
        <?php foreach ($offres as $offre):?>
            <?=offre(
                thematique: $offre->getThematique(),
                description: $offre->getDescription(),
                id_offre: $offre->getIdOffre(),
                nom_entreprise: $offre->getIdEntreprise(),
                entreprise_picture_path: "assets/img/DuréeB.jpg")
            ?>
        <?php endforeach ?>
    </div>
</main>