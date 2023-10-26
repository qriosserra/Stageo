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
 * @var array $taille_entreprises
 * @var array $type_structures
 * @var array $statut_juridiques
 */
?>

<main class="h-screen flex items-center justify-center gap-2 relative">
    <?=breadcrumb(2, [
        "Information générale" => Action::ENTREPRISE_ADD_STEP_1_FORM->value,
        "Détails techniques" => Action::ENTREPRISE_ADD_STEP_2_FORM->value,
        "Adresse postale" => Action::ENTREPRISE_ADD_STEP_3_FORM->value,
        "Authentification" => Action::ENTREPRISE_ADD_STEP_4_FORM->value
    ])?>
    <form class="grid grid-cols-2 gap-8" action="<?=Action::ENTREPRISE_ADD_STEP_2->value?>" method="post">
        <?=field("siret", "Numéro de SIRET*", "text", "12345678901234", null, true, $entreprise->getSiret(), "col-span-2" )?>
        <?=field("code_naf", "Code NAF*", "text", "1234A", null, false, $entreprise->getCodeNaf())?>
        <?=dropdown("id_taille_entreprise", "Taille de l'entreprise*", "Sélectionner une taille d'entreprise", null, $entreprise->getIdTailleEntreprise(), $taille_entreprises)?>
        <?=dropdown("id_type_structure", "Type de s'établissement*", "Sélectionnez un type d'établissement", "col-span-2", $entreprise->getIdTypeStructure(), $type_structures)?>
        <?=dropdown("id_statut_juridique", "Statut juridique*", "Sélectionnez un statut juridique", "col-span-2", $entreprise->getIdStatutJuridique(), $statut_juridiques)?>
        <?=submit("Suivant", "col-span-2")?>
        <?=token($token)?>
    </form>
</main>