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
    <?=button("Accueil", "fi-rr-angle-small-left", Action::HOME, "!absolute !pl-2 top-16 left-0")?>
    <h4 class="text-3xl font-bold">Ajouter mon entreprise</h4>
    <form class="grid grid-cols-2 gap-8" action="<?=Action::ENTREPRISE_ADD_STEP_1->value?>" method="post">
        <?=field("raison_sociale", "Nom de l'entreprise*", "text", "Entrez le nom de l'entreprise", Pattern::NAME, true, $entreprise->getRaisonSociale() ?? null)?>
        <?=field("telephone", "Téléphone*", "text", "Entrez un téléphone de contact", null, false, $entreprise->getTelephone() ?? null)?>
        <?=field("site", "Site web", "text", "www.example.com", null, false, $entreprise->getSite() ?? null)?>
        <?=field("fax", "Fax", "text", "Entrez un numéro de fax", null, false, $entreprise->getFax() ?? null)?>
        <?=submit("Suivant", "col-span-2")?>
        <?=token($token)?>
    </form>
</main>