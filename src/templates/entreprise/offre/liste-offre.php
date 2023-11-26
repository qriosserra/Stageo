<?php

use Stageo\Model\Object\Categorie;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use \Stageo\Model\Object\Offre;
use Stageo\Lib\enums\Action;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
include __DIR__ . "/../../macros/newOffre.php";
/**
 * @var Categorie[] $categories
 * @var Etudiant $etudiant
 * @var Offre[] $offres
 * @var array $listeoffres
 * @var int [] $idOffres
 * @var string $selA
 * @var string $selB
 * @var string $selC
 * @var string $search
 * @var Categorie $Categories
 * @var int $nbRechercheTrouver
 * @var string $communeTaper
 */
?>

<style>
    /* Toggle A */
    #toggleA:checked~.dot {
        transform: translateX(100%);
        background-color: #48bb78;
    }

    /* Toggle B */
    #toggleB:checked~.dot {
        transform: translateX(100%);
        background-color: #48bb78;
    }

    .text-shadow {
        text-shadow: -0.5px -0.5px 0 #000, 0.5px -0.5px 0 #000, -0.5px 0.5px 0 #000, 0.5px 0.5px 0 #000;
    }


</style>
</head>

<body class="bg-slate-50">
<div class="h-40 flex justify-center items-center mt-[4rem]"
     style="background: linear-gradient(120deg, rgba(21, 129, 230, 0.75) 0%, rgba(0, 45, 141, 0.75) 50%, rgba(1, 7, 68, 0.75) 100%)">
    <h1 class="text-center font-medium text-white text-3xl text-shadow">
        Des Offres allant du stage à l'Alternance validées par l'IUT !
    </h1>
</div>
<div class="container mx-auto px-4 mb-8 mt-12">
    <?php if(!isset($search)){
        $search="";
    }if(!isset($communeTaper)){
        $communeTaper="";
    }if (!isset($nbRechercheTrouver)){
        $nbRechercheTrouver=0;
    }?>

    <!-- Search area with two sets of inputs stacked -->
    <form class="flex flex-wrap justify-center gap-6 "  action="<?=Action::LISTE_OFFRE->value?>"  method="post">

        <div class="w-full md:w-1/2 lg:w-2/6">
            <div class="mb-6">
                <label for="job-field" class="block text-sm font-medium text-gray-700">Postes, mots clés, ...</label>
                <input id="job-field" name="search"
                       class="mt-1 block w-full rounded-full border-gray-700 border-[1px] shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-lg p-3"
                       type="search" placeholder="<?=$search = (strlen($search) == 0) ? "Exemples : Développeur web, Devops..." : $search?>">
            </div>

            <div>
                <label for="location-field" class="block text-sm font-medium text-gray-700">Localisation</label>
                <input id="location-field" name ="Commune"
                       class="mt-1 block w-full rounded-full border-gray-700 border-[1px] shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-lg p-3 transition duration-1000 ease-in-out"
                       type="text" placeholder="<?=$communeTaper = (strlen($communeTaper) == 0) ? "Exemples : Montpellier, Sète..." : $communeTaper?>">
            </div>
        </div>

        <!-- Second column for domain and duration fields -->
        <div class="w-full md:w-1/2 lg:w-2/6">
            <div class="mb-6">
                <label for="domain-field" class="block text-sm font-medium text-gray-700">Secteur</label>
                <select id="domain-field" name="categoriesSelectionnees[]"
                        class="mt-1 block w-full rounded-full border-gray-700 border-[1px] shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-lg p-3">
                    <option>Sélectionnez vos choix</option>
                    <?php foreach ($Categories as $category):?>
                        <option name="categoriesSelectionnees[<?= $category->getLibelle() ?>]" id="<?= $category->getIdCategorie() ?>  value="<?= $category->getIdCategorie() ?>"><?= $category->getLibelle() ?></option>
                    <?php endforeach;?>
                    <!-- Add other options here -->
                </select>
            </div>
            <h1 class="text-center text-xl font-medium underline-offset-1 ">Afficher les offres :</h1>

            <div class="flex flex-col lg:flex-row items-center justify-center space-x-4 w-full mb-12 ">

                <label for="toggleA" class="flex items-center cursor-pointer mt-4">
                    <!-- toggle -->
                    <div class="relative">
                        <!-- input -->
                        <input name="toggle[Alternances]=Alternances" id="toggleA" type="checkbox" class="sr-only" />
                        <!-- line -->
                        <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                        <!-- dot -->
                        <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
                    </div>
                    <!-- label -->
                    <div class="ml-0 lg:ml-3 text-gray-700 font-medium">
                        Alternances
                    </div>
                </label>
                <label for="toggleB" class="flex items-center cursor-pointer mt-4">
                    <!-- toggle -->
                    <div class="relative">
                        <!-- input -->
                        <input name="toggle[Stages]=Stages" id="toggleB" type="checkbox" class="sr-only" />
                        <!-- line -->
                        <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                        <!-- dot -->
                        <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
                    </div>
                    <!-- label -->
                    <div class="ml-0 lg:ml-3 text-gray-700 font-medium mr-4">
                        Stages
                    </div>
                </label>
            </div>
        </div>
        <div class="w-full flex justify-center">
            <button
                    id="search-button"
                    class="rounded-lg px-8 py-2 text-xl border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-blue-100 duration-300">
                Recherche
            </button>
        </div>
    </form>


    <!-- Internship offers -->

    <?php if (!is_null($idOffres)) :?>
    <p class="text-lg font-semibold mb-4"><?=$nbRechercheTrouver ?> offres de stage</p>
        <?php foreach ($listeoffres as $offre):?>
            <?php if (in_array($offre["id_offre"],$idOffres)):?>
            <?= newOffre($offre["description"],$offre["type"],$offre["raison_sociale"], $offre["taches"],"08/05/2024",$offre["categories"],$offre["id_offre"])?>
            <?php endif;?>
        <?php endforeach; ?>
    <?php else:?>

        <p class="text-lg font-semibold mb-4">Aucune offre disponible selon vos recherches !</p>
    <?php endif ?>





</div>

</body>