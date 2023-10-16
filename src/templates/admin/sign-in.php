<!-- check box -->
<script>
    function redirectToLink(checkboxId, actionValue) {
        var checkbox = document.getElementById(checkboxId);
        if (checkbox.checked) {
            window.location.href = actionValue;
        }
    }
</script>
<!------------------------------------------->
<?php

use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/token.php";
/**
 * @var string $token
 * @var string $email
 * @var array $pattern
 */
?>
<main class="h-screen flex items-center justify-center gap-8 relative">
    <?=button("Accueil", "fi-rr-angle-small-left", "/Stageo", "!absolute !pl-2 top-16 left-0")?>
    <h1 class="w-[36rem]">Connection d'Admin</h1>
    <form class="flex flex-col items-center gap-4" action="<?=Action::ADMIN_SIGN_IN->value?>" method="post">
        <?=input("email", "Email", "text", "fi-rr-at", "required", null, $email ?? null)?>
        <?=input("password", "Mot de passe", "password", "fi-rr-lock", "required")?>
        <?=token($token)?>
        <input class="button-primary" type="submit" value="Se connecter">
    </form>

<!-- check box -->
    <!-- Checkbox pour étudiant -->
    <input type="checkbox" id="etudiant" onchange="redirectToLink('admin', '<?= Action::ETUDIANT_SIGN_IN_FORM->value ?>')" ">
    <label for="etudiant">Étudiant</label>

    <!-- Checkbox pour admin -->
    <input type="checkbox" id="admin" disabled checked>
    <label for="admin">Admin</label>

    <!-- Checkbox pour entreprise -->
    <input type="checkbox" id="entreprise" onchange="">
    <label for="entreprise">Entreprise</label>
<!------------------------------------------->
</main>