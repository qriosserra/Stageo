<?php

use Stageo\Model\Object\Categorie;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use \Stageo\Model\Object\Offre;
use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/newOffre.php";
include __DIR__ . "/../macros/newEntreprise.php";

/**
    * @var Etudiant $etudiant
    * @var \Stageo\Model\Object\Entreprise[] $entreprises
    * @var array $listeEntreprises
    * @var int [] $idEntreprises
    * @var string $selA
    * @var string $selB
    * @var string $search
    * @var Categorie $Categories
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
        Voici la liste des entreprises
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
    <form class="flex flex-wrap justify-center gap-6 "  action="<?=Action::LISTE_ENTREPRISES->value?>"  method="post">

        <div class="w-full md:w-1/2 lg:w-2/6">
            <div class="mb-6">
                <label for="job-field" class="block text-sm font-medium text-gray-700">Nom de l'entreprise recherchée</label>
                <input id="job-field" name="search"
                       class="mt-1 block w-full rounded-full border-gray-700 border-[1px] shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-lg p-3"
                       type="search" placeholder="<?=$search = (strlen($search) == 0) ? "Exemples : Google, Amazon, Ubisoft... " : $search?>">
            </div>

        </div>

        <!-- Second column for domain and duration fields -->

        <div class="w-full flex justify-center">
            <button
                id="search-button"
                class="rounded-lg px-8 py-2 text-xl border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-blue-100 duration-300">
                Recherche
            </button>
        </div>
    </form>


    <!-- Internship offers -->

    <?php if (!is_null($idEntreprises)) :?>
        <p class="text-lg font-semibold mb-4"><?=$nbRechercheTrouver ?> Entreprises</p>
        <?php foreach ($listeEntreprises as $entreprise):?>
            <?php if (in_array($entreprise["id_entreprise"],$idEntreprises)):?>
            <?= newEntreprise(
                $entreprise["raison_sociale"],
                $entreprise["numero_voie"],
                $entreprise["code_postal"],
                $entreprise["commune"],
                $entreprise["telephone"],
                $entreprise["email"],
                $entreprise["site"],
                $entreprise["id_entreprise"]
            ) ?>
            <?php endif;?>
        <?php endforeach; ?>
    <?php else:?>

        <p class="text-lg font-semibold mb-4">Aucune offre disponible selon vos recherches !</p>
    <?php endif ?>





</div>

</body>