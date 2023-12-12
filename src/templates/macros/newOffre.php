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
<div class="flex rounded-lg border mb-4">
  <div class="h-24 w-24 flex-none bg-gray-200" aria-hidden="true"><!-- Placeholder for image --></div>
  <a class="flex-grow p-4" href="$action">
    <p class="mb-2 font-bold">$description</p>
    <p class="rounded bg-blue-50 text-sm text-gray-600">$type</p>
    <p class="mb-2 mt-1 text-sm text-gray-600">$nomEntreprise</p>
    <p class="mb-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800">$durée</p>
    <p class="text-xs">Débute le : $dateDeDebuts</p>
    <p class="mt-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800">$libelle  </p>
  </a>
</div>
HTML;
}




?>