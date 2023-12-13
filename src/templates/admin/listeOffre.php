<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;
include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/newOffre.php";
/** @var ArrayObject $listeEntreprise
 * @var Offre[] $offres
 * @var array $listeoffres
 * @var int [] $idOffres
 * @var string $title
 */
?>
<div class="h-40 flex justify-center items-center mt-[4rem]"
       style="background: linear-gradient(120deg, rgba(21, 129, 230, 0.75) 0%, rgba(0, 45, 141, 0.75) 50%, rgba(1, 7, 68, 0.75) 100%)">
    <h1 class="text-center font-medium text-white text-3xl text-shadow">
        <?= $title?>
    </h1>
</div>
<div class="h-min mt-1 p-12">
    <?php foreach ($listeoffres as $offre):
        $libelle = "";
        $Categories = $offre["categories"];
        foreach ($Categories as list("libelle" => $lo)){
            $libelle  .= " ". $lo;
        }?>
                <div class="flex rounded-lg border mb-4 flex-col">
                    <div class="flex">
                        <div class="h-24 w-24 flex-none bg-gray-200" aria-hidden="true"><!-- Placeholder for image --></div>
                        <a class="flex-grow p-4" href="<?=Action::AFFICHER_OFFRE->value . "&id=".$offre["id_offre"]?>">
                            <p class="mb-2 font-bold"><?= $offre["description"]?></p>
                            <p class="rounded bg-blue-50 text-sm text-gray-600"><?= $offre["type"]?></p>
                            <p class="mb-2 mt-1 text-sm text-gray-600"><?= $offre["raison_sociale"]?></p>
                            <p class="mb-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800"><?= $offre["taches"]?></p>
                            <p class="text-xs">Débute le : <?= "08/05/2024"?></p>
                            <p class="mt-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800"><?= $libelle ?></p>
                        </a>
                    </div>
                    <div class="flex">
                    <?=button("Valider","fi-ss-check-circle",Action::ADMIN_VALIDEOFFRE->value."&idOffre=".$offre["id_offre"],"!text-primary-400 text-xl w-min h-min mt-2","!text-primary-400")?>
                    <form method="post" action="<?= Action::ADMIN_SUPRIMEROFFRES->value . "&idOffre=" . $offre["id_offre"] ."&email=".$offre["email"] ?>">
                        <input type="text" name="raisonRefus" placeholder="Raisons du refus" required>
                        <button type="submit" class="button-ghost !text-red-400 text-xl w-min">
                            <i class="fi fi-sr-cross-circle !text-red-400"></i>
                            <span>Supprimer</span>
                        </button>
                    </form>
                </div>
            </div>
    <?php endforeach; ?>
</div>