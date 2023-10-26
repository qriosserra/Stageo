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
        <?=field("raison_sociale", "Nom de l'entreprise*", "text", "Entrez le nom de l'entreprise", Pattern::NAME, true, $entreprise->getRaisonSociale())?>
        <?=field("telephone", "Téléphone", "text", "0412345678", Pattern::PHONE_NUMBER, false, $entreprise->getTelephone())?>
        <?=field("site", "Site web", "text", "www.example.com", Pattern::URL, false, $entreprise->getSite())?>
        <?=field("fax", "Fax", "text", "Entrez un numéro de fax", Pattern::PHONE_NUMBER, false, $entreprise->getFax())?>
        <?=submit("Suivant", "col-span-2")?>
        <?=token($token)?>
    </form>
</main>