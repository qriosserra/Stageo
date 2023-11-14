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
        "Information générale" => Action::ENTREPRISE_SIGN_UP_STEP_1_FORM->value,
        "Détails techniques" => Action::ENTREPRISE_ADD_STEP_2_FORM->value,
        "Adresse postale" => Action::ENTREPRISE_ADD_STEP_3_FORM->value,
        "Authentification" => Action::ENTREPRISE_ADD_STEP_4_FORM->value
    ])?>
    <form class="bg-white p-12 text-gray-600 rounded-lg shadow-lg grid gap-8 w-[28rem]" action="<?=Action::ENTREPRISE_ADD_STEP_3->value?>" method="post">
        <h4>3. Adresse postale</h4>
        <?=field("numero_voie", "Numéro et voie du siège de l'entreprise", "text", "Entrez l'adresse de siège de l'entreprise", null, false, $entreprise->getNumeroVoie())?>
        <?=dropdown("id_distribution_commune", "Commune", "Sélectionnez une commune", null, $entreprise->getIdDistributioncommune(), $distributions_commune ?? [])?>
        <?=submit("Suivant")?>
        <?=token($token)?>
    </form>
</main>