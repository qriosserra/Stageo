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
 */
?>
<div class="h-min mt-[8rem] p-12">
    <?php foreach ($listeoffres as $offre):?>
            <?= newOffre($offre["description"],$offre["type"],$offre["raison_sociale"], $offre["taches"],"08/05/2024",$offre["categories"],$offre["id_offre"])?>
            <div class="flex">
                <?=button("Valider","fi-ss-check-circle",Action::ADMIN_VALIDEOFFRE->value."&idOffre=".$offre["id_offre"],"!text-primary-400 text-xl w-min","!text-primary-400")?>
                <?=button("Supprimer","fi-sr-cross-circle",Action::ADMIN_SUPRIMEROFFRES->value."&idOffre=".$offre["id_offre"],"!text-red-400 text-xl w-min","!text-red-400")?>
            </div>
    <?php endforeach; ?>
</div>