<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/breadcrumb.php";
/**
 * @var Entreprise $entreprise
 * @var string $token
 */
?>

<main class="h-screen flex flex-col items-center justify-center gap-2 relative">
    <?=breadcrumb(1, [
        "Information générale" => Action::ENTREPRISE_ADD_STEP_1_FORM->value,
        "Détails techniques" => Action::ENTREPRISE_ADD_STEP_2_FORM->value,
        "Adresse postale" => Action::ENTREPRISE_ADD_STEP_3_FORM->value,
        "Authentification" => Action::ENTREPRISE_ADD_STEP_4_FORM->value
    ])?>
    <form class="grid grid-cols-2 gap-8" action="<?=Action::ENTREPRISE_ADD_STEP_1->value?>" method="post">
        <?=field("raison_sociale", "Nom de l'entreprise*", "text", "Entrez le nom de l'entreprise", Pattern::NAME, true, $entreprise->getRaisonSociale() ?? null)?>
        <?=field("telephone", "Téléphone*", "text", "Entrez un téléphone de contact", null, false, $entreprise->getTelephone() ?? null)?>
        <?=field("site", "Site web", "text", "www.example.com", null, false, $entreprise->getSite() ?? null)?>
        <?=field("fax", "Fax", "text", "Entrez un numéro de fax", null, false, $entreprise->getFax() ?? null)?>
        <?=submit("Suivant", "col-span-2")?>
        <?=token($token)?>
    </form>
</main>