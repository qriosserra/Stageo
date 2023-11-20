<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;

/**
 * @var Entreprise $entreprise
 */

/**
 * @param string|null $description
 * @param string|null $entreprise_picture_path
 * @return string
 */
function newOffre(string $description = null,
                  string $type = null,
                  string $nomEntreprise,
                  string $durée,
                  string $dateDeDebuts, array $Categories, int $id_offre


): string


{
    $action = Action::AFFICHER_OFFRE->value . "&id=$id_offre";
    $libelle = "";
    foreach ($Categories as list("libelle" => $lo)){
        $libelle  .= " ". $lo;
    }
    //$libelle = $Categories[0]['libelle'];
    return <<<HTML
<div class="flex rounded-lg border">
  <div class="h-24 w-24 flex-none bg-gray-200" aria-hidden="true"><!-- Placeholder for image --></div>
  <div class="flex-grow p-4">
    <div class="mb-2 font-bold">$description</div>
    <div class="rounded bg-blue-50 text-sm text-gray-600">$type</div>
    <div class="mb-2 mt-1 text-sm text-gray-600">$nomEntreprise</div>
    <div class="mb-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800">$durée</div>
    <div class="text-xs">Débute le : $dateDeDebuts</div>
    <div class="mt-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800">$libelle  </div>
    <a href="$action" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">En savoir plus</a>
  </div>
</div>
HTML;
}




?>