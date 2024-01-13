<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;

function newEntreprise(string $nom,
                       string $adresse,
                       string $code_postal,
                       string $ville,
                       string $telephone,
                       string $email,
                       string $site ,
                       int $id_entreprise): string {
    $action = Action::AFFICHER_ENTREPRISE->value. "&id=$id_entreprise";
    return <<<HTML
    <div class="flex rounded-lg border">
  <div class="h-24 w-24 flex-none bg-gray-200" aria-hidden="true"><!-- Placeholder for image --></div>
  <div class="flex-grow p-4">
    <p class="mb-2 font-bold">$nom</p>
    <p class="rounded bg-blue-50 text-sm text-gray-600">$adresse</p>
    <p class="mb-2 mt-1 text-sm text-gray-600">$code_postal</p>
    <p class="mb-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800">$ville</p>
    <p class="text-xs">$telephone</p>
    <p class="mt-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800">$email</p>
    <p class="mt-2 rounded bg-blue-50 px-2 py-1 text-xs text-blue-800">$site</p>
    <a href="$action" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">En savoir plus</a>
  </div>
</div>
&nbsp;
HTML;


}
