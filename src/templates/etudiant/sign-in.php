<?php

use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/token.php";
/**
 * @var string $token
 * @var string $login
 */
?>

<main class="h-screen flex items-center justify-center gap-8 relative">
    <?=button("Accueil", "fi-rr-angle-small-left", "/Stageo", "!absolute !pl-2 top-16 left-0")?>
    <h1 class="w-[36rem]">Se connecter</h1>
    <div class="absolute -left-12 -z-10">
    </div>
    <form class="flex flex-col items-center gap-4" action="<?=Action::ETUDIANT_SIGN_IN->value?>" method="post">
        <?=input("login", "Login", "text", "fi-rr-user", "required", null, $login)?>
        <?=input("password", "Mot de passe", "password", "fi-rr-lock", "required")?>
        <?=token($token)?>
        <input type="submit" value="Se connecter" class="button-primary">
        <p>Vous n'avez pas de compte étudiant ? <a class="font-bold" href="<?=Action::ETUDIANT_SIGN_UP_FORM->value?>">S'inscrire</a></p>
    </form>
</main>