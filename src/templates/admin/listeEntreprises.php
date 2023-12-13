<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;
include __DIR__."/../macros/button.php";
/** @var ArrayObject $listeEntreprise */
?>
    <div class="h-min mt-[8rem] p-12">
<?php foreach ($listeEntreprise as $entreprise) :?>
    <div class="flex border rounded-lg">
        <div class="flex-none w-24 h-24 bg-gray-200" aria-hidden="true"> <!-- Placeholder for image --> </div>
        <div class="p-4 flex-grow">
            <div class="mb-2 font-bold"><?=$entreprise["raison_sociale"]?></div>
            <div class="mb-2 text-sm text-gray-600">Siret : <?=$entreprise["siret"]?></div>
            <div class="mb-2 text-sm text-gray-600">Site : <?=$entreprise["site"]?></div>
            <div class="mb-2 text-sm text-gray-600">Adresse : <?=$entreprise["numero_voie"]?>, <?=$entreprise["commune"]?> <?=$entreprise["code_postal"]?> (<?=$entreprise["pays"]?>)</div>
            <div class="mb-2 text-xs bg-blue-100 text-blue-800 py-1 px-2 rounded"><ul><li>Numéro de téléphone : <?=$entreprise["telephone"] ?></li><li>Email : <?=$entreprise["email"] ?></li></ul></div>
            <div class="mb-2 text-sm text-gray-600">Code NAF : <?=$entreprise["code_naf"]?></div>
            <div class="mb-2 text-sm text-gray-600">Taille entreprise : <?=$entreprise["taille_entreprise"]?></div>
            <div class="mb-2 text-sm text-gray-600">Type structure : <?=$entreprise["type_structure"]?></div>
            <div class="mb-2 text-sm text-gray-600">Statut juridique : <?=$entreprise["statut_juridique"]?></div>
            <div class="flex">
                <?=button("Valider","fi-ss-check-circle",Action::ADMIN_VALIDEENTREPRISE->value."&idEntreprise=".$entreprise["id_entreprise"],"!text-primary-400 text-xl w-min","!text-primary-400")?>
                <?=button("Supprimer","fi-sr-cross-circle",Action::ADMIN_SUPRIMERENTREPRISE->value."&idEntreprise=".$entreprise["id_entreprise"],"!text-red-400 text-xl w-min","!text-red-400")?>
            </div>
        </div>
    </div>
<?php endforeach; ?></div>