<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;

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

    <form class="flex flex-col items-center gap-4" action="<?=Action::ETUDIANT_SIGN_IN->value?>" method="post">
        <?=field("login", "Login", "text", "Entrez votre login", null, true, $login)?>
        <?=field("password", "Mot de passe", "password", "Entrez un mot de passe", null, true)?>
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