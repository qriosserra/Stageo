<?php

use Stageo\Lib\enums\Pattern;
use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
/**
 * @var string $token
 * @var Entreprise $entreprise
 * @var array $taille_entreprises
 * @var array $type_structures
 * @var array $statut_juridiques
 */
?>
<main class="bg-gray-100 w-full">
    <nav class="flex justify-between items-center border-b">
        <a href="<?=Action::HOME->value?>" class="inline-flex items-center">
            <div class="mt-3 ml-3">
                <img src="assets/img/logo.png" class="h-[1.8rem] w-[7rem]">
                <p style="font-family: Montserrat,serif;" class="text-blue-900">Pour les entreprises</p>
            </div>
        </a>
        <button class="hidden sm:block scale-100 hover:scale-110 transition border uppercase font-semibold tracking-wider mr-5 leading-none rounded">
            <a  href="<?=Action::ENTREPRISE_SIGN_IN_FORM->value?>" class="relative px-12 py-3 rounded bg-blue-500 text-white text-1xl font-bold">
                Se connecter
            </a>
        </button>
    </nav>
    <div class="flex items-center justify-center h-40 bg-gradient-to-r from-cyan-500 via-blue-800 to-blue-400 font-bold text-white">
        <span class="text-center" style="font-size: clamp(1rem, 5vw, 2rem)">Créer votre compte entreprise</span>
    </div>
    <div class="max-w-lg mx-auto p-8 space-y-4">
        <h4 class="text-center">Détails techniques</h4>
        <form class="bg-white p-6 rounded shadow-md border-t-4 border-blue-500 space-y-4 text-gray-600 grid gap-8" action="<?=Action::ENTREPRISE_SIGN_UP_STEP_2->value?>" method="post">
            <?=field("siret", "Numéro de SIRET*", "text", "12345678901234", Pattern::SIRET, true, $entreprise->getSiret(), "sm:col-span-2" )?>
            <?=field("code_naf", "Code NAF", "text", "1234A", Pattern::NAF, false, $entreprise->getCodeNaf())?>
            <?=dropdown("id_taille_entreprise", "Taille de l'entreprise*", "Sélectionner une taille d'entreprise", null, $entreprise->getIdTailleEntreprise(), $taille_entreprises)?>
            <?=dropdown("id_type_structure", "Type de s'établissement*", "Sélectionnez un type d'établissement", "sm:col-span-2", $entreprise->getIdTypeStructure(), $type_structures)?>
            <?=dropdown("id_statut_juridique", "Statut juridique*", "Sélectionnez un statut juridique", "sm:col-span-2", $entreprise->getIdStatutJuridique(), $statut_juridiques)?>
            <?=submit("Suivant", "sm:col-span-2")?>
            <?=token($token)?>
        </form>
    </div>
</main>
<footer class="bg-gray-100 mt-10">
    <div class="mt-4 border-t border-gray-300 pt-3">
        <p class="text-gray-600 text-center">
            Se connecter en tant que : Etudiant, Entreprise
        </p>
        <p class="text-gray-500 text-xs text-center mt-4">
            Copyright © 2023, Stageo « Stageo » et son logo sont des branches officiel de l'IUT Montpellier-Sète.
        </p>
    </div>
    </div>
</footer>