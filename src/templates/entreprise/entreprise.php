<?php

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/entreprise.php";
include __DIR__ . "/../macros/newOffre.php";
/**
 * @var \Stageo\Model\Object\Entreprise $entreprise
 * @var array $listeoffres
 * @var int $nbRechercheTrouver
 */
?>
    <div class="container mx-auto p-4 mt-[10rem]  border-2 rounded-2xl bg-slate-50 ">
        <div class=" rounded p-6 ">
            <div class="mb-4">
                <h1 class="text-2xl  text-center font-bold mb-2"><?= $entreprise["raison_sociale"] ?> </h1>
                <h6 class=" text-center"> <?= $entreprise["email"] ?></h6>
                <div class="flex mb-4">
                    Siret : <?= $entreprise["siret"] ?>
                </div>

            </div>

            <div class="mb-8">
                <p class="text-xl font-bold mb-2">Taille de l'entreprise :</p>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["taille_entreprise"] ?>
                </p>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-2">Type de structure : </h2>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["type_structure"] ?>
                </p>
            </div>
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-2">Statue Juridique : </h2>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["statut_juridique"] ?>
                </p>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-2">Naf : </h2>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["code_naf"] ?>
                </p>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-2">Localisation : </h2>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["numero_voie"] ?>
                </p>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["code_postal"] ?>
                </p>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-2">Telephone : </h2>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["telephone"] ?>
                </p>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-2">Site Web : </h2>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["site"] ?>
                </p>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-2">Fax : </h2>
                <p class="text-gray-700 text-base mb-4">
                    <?= $entreprise["fax"] ?>
                </p>
            </div>

        </div>
    </div>
<div class="mx-auto p-4">
    <?php if (!is_null($listeoffres)) :?>
        <p class="text-lg font-semibold mb-4 text-center"><?=$nbRechercheTrouver ?> offres de stage</p>
        <?php foreach ($listeoffres as $offre):?>
            <?= newOffre($offre["description"],$offre["type"],$offre["raison_sociale"], $offre["taches"],"08/05/2024",$offre["categories"],$offre["id_offre"])?>
        <?php endforeach; ?>
    <?php else:?>

        <p class="text-lg font-semibold mb-4">Aucune offre disponible selon vos recherches !</p>
    <?php endif ?>
</div>
