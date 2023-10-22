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
 * @var string $search
 */
?>

<main class="w-[64rem] flex flex-col gap-8 mt-8">
    <div>
        <form class="mb-3" action="<?=Action::LISTE_OFFRE->value?>" method="post">
            <div class="relative flex flex-row flex-wrap items-stretch">
                <div class="w-64 ">
                    <select id="Option" name="OptionL" class="rounded-l-lg  w-full bg-white border border-blue-500 text-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="description" <?=$selA?>>Description</option>
                        <option value="secteur" <?=$selB?>>Secteur</option>
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