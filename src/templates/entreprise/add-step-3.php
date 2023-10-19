<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
/**
 * @var Entreprise $entreprise
 * @var string $token
 */
?>

<main class="h-screen flex items-center justify-center gap-2 relative">
    <?=button("Précédent", "fi-rr-angle-small-left", Action::ENTREPRISE_ADD_STEP_2_FORM, "!absolute !pl-2 top-16 left-0")?>
    <h4 class="text-3xl font-bold">Ajouter mon entreprise</h4>
    <form class="grid grid-cols-3 gap-8" action="<?=Action::ENTREPRISE_ADD_STEP_3->value?>" method="post">
        <?=field("adresse_voie", "Adresse de l'entreprise", "text", "Entrez l'adresse de siège de l'entreprise", null, false, $adresse_voie ?? null, "col-span-3")?>
        <?=dropdown("id_commune", "Commune", "Sélectionnez une commune", "col-span-2", $id_commune ?? null, $communes ?? [])?>
        <?=dropdown("id_code_postal", "Code Postal", "Sélectionnez un code postal", null, $id_code_postal ?? null, $code_postaux ?? [])?>
        <?=submit("Suivant", "col-span-3")?>
        <?=token($token)?>
    </form>
</main>