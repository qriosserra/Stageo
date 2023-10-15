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
    <?=button("Accueil", "fi-rr-angle-small-left", Action::HOME->value, "!absolute !pl-2 top-16 left-0")?>
    <h4 class="text-3xl font-bold">Ajouter une entreprise</h4>
    <form class="flex flex-row gap-4" action="<?=Action::ENTREPRISE_ADD->value?>" method="post">
        <div class="left-0">
            <input type="submit" value="Ajouter" class="button-primary">
            <button type="button" hidden="hidden" id="prevButton" onclick="move(-1)">Précédent</button>
            <button type="button"  id="nextButton" onclick="move(1)">Suivant</button>
        </div>
        <div class="flex flex-col items-center gap-4 " id="group1" >
            <?=input("raison_sociale", "Nom de l'entreprise", "text", "required")?>
            <?=input("adresse_voie", "Adresse de l'entreprise", "text", "required")?>
            <?=input("code_naf", "Code Naf", "text", "required")?>
            <?=input("telephone", "Téléphone", "text", "required")?>
        </div>
        <div class="flex flex-col items-center gap-4 hidden" id="group2">
            <?=input("email", "Email", "email", "required")?>
            <?=input("siret", "Siret", "text", "required")?>
            <?=input("statut_juridique", "Statut Juridique", "text", "required")?>
            <?=input("type_structure", "Type de structure", "text", "required")?>
        </div>
        <div class="flex flex-col items-center gap-4 hidden" id="group3" >
            <?=input("effectif", "Effectif", "number", "required")?>
            <?=input("site", "Site web", "text", "required")?>
            <?=input("fax", "Fax", "text", "required")?>
            <?=input("id_code_postal", "Code Postal", "text", "required")?>
        </div>
        <script> let currentGroup = 1;
            const totalGroups = 3;
            function move(step) {
                document.getElementById('group' + currentGroup).style.display = 'none';
                currentGroup += step;
                document.getElementById('group' + currentGroup).style.display = 'flex';
                // Gérer les boutons
                if (currentGroup <= 1) {
                    document.getElementById('prevButton').style.display = 'none';
                } else {
                    document.getElementById('prevButton').style.display = 'flex';
                }
                if (currentGroup >= totalGroups) {
                    document.getElementById('nextButton').style.display = 'none';
                } else {
                    document.getElementById('nextButton').style.display = 'flex';
                }
            }
        </script>
        <?=token($token)?>
    </form>
</main>