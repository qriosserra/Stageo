<?php

use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/token.php";
/**
 * @var string $token
 */
?>

<main class="h-screen flex items-center justify-center gap-2 relative">
    <h4 class="text-3xl font-bold">Ajouter une offre</h4>
    <form class="flex flex-col items-center gap-4" action="<?=Action::ENTREPRISE_CREATION_OFFRE->value?>" method="post">
    <div class="mb-6">
        <?=input("secteur", "secteur", "text", "", "required", null, null)?>
    </div>
    <div class="mb-6">
        <?=input("thematique", "thematique", "text", "", "required", null, null)?>
    </div class="mb-6">
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
    <button type="submit">Envoyer</button>
        <?=token($token)?>
    </form>
</main>