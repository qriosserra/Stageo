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
    <?=breadcrumb(3, [
        "Information générale" => Action::ENTREPRISE_ADD_STEP_1_FORM->value,
        "Détails techniques" => Action::ENTREPRISE_ADD_STEP_2_FORM->value,
        "Adresse postale" => Action::ENTREPRISE_ADD_STEP_3_FORM->value,
        "Authentification" => Action::ENTREPRISE_ADD_STEP_4_FORM->value
    ])?>
    <form class="grid grid-cols-3 gap-8" action="<?=Action::ENTREPRISE_ADD_STEP_3->value?>" method="post">
        <?=field("numero_voie", "Numéro et voie du siège de l'entreprise", "text", "Entrez l'adresse de siège de l'entreprise", null, false, $entreprise->getNumeroVoie(), "col-span-3")?>
        <?=dropdown("id_commune", "Commune", "Sélectionnez une commune", "col-span-2", $entreprise->getIdCommune(), $communes ?? [])?>
        <?=dropdown("id_code_postal", "Code Postal", "Sélectionnez un code postal", null, $entreprise->getIdCodePostal(), $code_postaux ?? [])?>
        <?=submit("Suivant", "col-span-3")?>
        <?=token($token)?>
    </form>
</main>