<?php

use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/token.php";
/**
 * @var string $token
 */
?>

<main class="h-screen items-center justify-center gap-2 relative">
    <h4 class="text-3xl font-bold py-6">Ajouter une offre</h4>
    <form class="flex flex-col items-center gap-4" action="<?=Action::ENTREPRISE_CREATION_OFFRE->value?>" method="post">
    <div class="mb-6">
        <?=input("secteur", "secteur", "text", "", "required", null, null)?>
    </div>
    <div class="mb-6">
        <?=input("thematique", "thematique", "text", "", "required", null, null)?>
    </div>
    <div class="mb-6">
        <?=input("tache", "tache", "text", "", "required", null, null)?>
    </div>
    <div class="mb-6">
        <?=input("description", "description", "text", "", "required", null, null)?>
    </div>
    <div class="mb-6">
        <?=input("commentaire", "commentaire", "text", "", "required", null, null)?>
    </div>
    <div class="mb-6">
        <?=input("gratification", "gratification", "text", "", "required", null, null)?>
    </div>
    <div class="mb-6">
        <?=input("unite_gratification", "unite_gratification", "text", "", "required", null, null)?>
    </div>
    <div class="flex">
        <div class="flex items-center pr-4">
            <input id="alternance" type="radio" value="alternance" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Alternance</label>
        </div>
        <div class="flex items-center">
            <input checked id="stage" type="radio" value="stage" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stage</label>
        </div>
    </div>
    <button type="submit">Envoyer</button>
        <?=token($token)?>
    </form>
</main>