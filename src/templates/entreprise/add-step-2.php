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
    <?=button("Précédent", "fi-rr-angle-small-left", Action::ENTREPRISE_ADD_STEP_1_FORM, "!absolute !pl-2 top-16 left-0")?>
    <h4 class="text-3xl font-bold">Ajouter mon entreprise</h4>
    <form class="grid grid-cols-2 gap-8" action="<?=Action::ENTREPRISE_ADD_STEP_2->value?>" method="post">
        <?=field("siret", "Numéro de SIRET*", "text", "Un numéro de SIRET est une suite de 14 chiffres", null, false, $entreprise->getSiret() ?? null, "col-span-2" )?>
        <?=field("code_naf", "Code NAF", "text", "Un code NAF est composé de 4 chiffres et une lettre", null, false, $entreprise->getCodeNaf() ?? null)?>
        <?=dropdown("effectif", "Effectif", "Sélectionner un effectif d'entreprise", null, $entreprise->getEffectif() ?? null, [
                "TPE" => "TPE - moins de 10 salariés",
                "PME" => "PME - 10 à 249 salariés",
                "ETI" => "ETI - 250 à 4999 salariés",
                "GE"  => "GE - au moins 5000 salariés"
            ])?>
        <?=dropdown("type_structure", "Type de s'établissement", "Sélectionnez un type d'établissement", "col-span-2", $entreprise->getTypeStructure() ?? null, [
                "1" => "Entreprise publique",
                "2" => "Entreprise privée"
            ])?>
        <?=dropdown("statut_juridique", "Statut juridique", "Sélectionnez un statut juridique", "col-span-2", $entreprise->getStatutJuridique() ?? null, [
                "EI"    => "EI - Entreprise individuelle",
                "EURL"  => "EURL - Entreprise unipersonnelle à responsabilité limitée",
                "SARL"  => "SARL - Société à responsabilité limitée",
                "SA"    => "SA - Société anonyme",
                "SAS"   => "SAS - Société par actions simplifiée",
                "SASU"  => "SASU - Société par actions simplifiée unipersonnelle",
                "SNC"   => "SNC - Société en nom collectif",
                "SCOP"  => "SCOP - Société coopérative ouvrière de production",
                "SCA"   => "SCA - Société en commandite par actions",
                "SCS"   => "SCS - Société en commandite simple",
            ])?>
        <?=submit("Suivant", "col-span-2")?>
        <?=token($token)?>
    </form>
</main>