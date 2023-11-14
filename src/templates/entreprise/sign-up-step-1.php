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
    <?=button("Accueil", "fi-rr-home", Action::HOME, "!absolute !pl-2 bottom-16 left-0")?>
    <?=breadcrumb(1, [
        "Information générale" => Action::ENTREPRISE_SIGN_UP_STEP_1_FORM->value,
        "Détails techniques" => Action::ENTREPRISE_ADD_STEP_2_FORM->value,
        "Adresse postale" => Action::ENTREPRISE_ADD_STEP_3_FORM->value,
        "Authentification" => Action::ENTREPRISE_ADD_STEP_4_FORM->value
    ])?>
    <form class="bg-white p-12 text-gray-600 rounded-lg shadow-lg grid gap-8" action="<?=Action::ENTREPRISE_ADD_STEP_1->value?>" method="post">
        <h4 class="sm:col-span-2">1. Information générale</h4>
        <?=field("raison_sociale", "Nom de l'entreprise*", "text", "Entrez le nom de l'entreprise", Pattern::NAME, true, $entreprise->getRaisonSociale())?> // FIXME : Nom entreprise enlever, et mis dans sign-up.php/entreprise
        <?=field("telephone", "Téléphone", "text", "0412345678", Pattern::PHONE_NUMBER, false, $entreprise->getTelephone())?>
        <?=field("site", "Site web", "text", "www.example.com", Pattern::URL, false, $entreprise->getSite())?>
        <?=field("fax", "Fax", "text", "Entrez un numéro de fax", Pattern::PHONE_NUMBER, false, $entreprise->getFax())?>
        <?=submit("Suivant", "sm:col-span-2")?>
        <?=token($token)?>
    </form>
</main>