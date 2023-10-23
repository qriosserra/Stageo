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

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
/**
 * @var string $token
 * @var string $login
 */
?>

<main class="h-screen flex items-center justify-center gap-8 relative">
    <?=button("Accueil", "fi-rr-angle-small-left", Action::HOME, "!absolute !pl-2 top-16 left-0")?>
    <h1 class="w-[36rem]">Connection d'étudiant</h1>
    <div class="absolute -left-12 -z-10">
    </div>
    <form class="flex flex-col items-center gap-4" action="<?=Action::ETUDIANT_SIGN_IN->value?>" method="post">
        <?=input("login", "Login", "text", "fi-rr-user", "required", null, $login)?>
        <?=input("password", "Mot de passe", "password", "fi-rr-lock", "required")?>
        <?=token($token)?>
        <input type="submit" value="Se connecter" class="button-primary">
        <p>Vous n'avez pas de compte étudiant ? <a class="font-bold" href="<?=Action::ETUDIANT_SIGN_UP_FORM->value?>">S'inscrire</a></p>
    </form>

<!-- check box -->
    <!-- Checkbox pour étudiant -->
    <input type="checkbox" id="etudiant" disabled checked ">
    <label for="etudiant">Étudiant</label>

    <!-- Checkbox pour admin -->
    <input type="checkbox" id="admin" onchange="redirectToLink('admin', '<?= Action::ADMIN_SIGN_IN_FORM->value ?>')">
    <label for="admin">Admin</label>

    <!-- Checkbox pour entreprise -->
    <input type="checkbox" id="entreprise" onchange="">
    <label for="entreprise">Entreprise</label>
<!------------------------------------------->

</main>