<?php

use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/token.php";
/**
 * @var string $token
 * @var string $email
 * @var string $nom
 * @var string $prenom
 * @var array $pattern
 */
?>
<main class="h-screen flex items-center justify-center gap-8 relative">
    <?=button("Accueil", "fi-rr-angle-small-left", Action::HOME, "!absolute !pl-2 top-16 left-0")?>
    <h1 class="w-[36rem]">Crée un administrateur</h1>
    <form class="flex flex-col items-center gap-4" action="<?=Action::ADMIN_SIGN_UP->value?>" method="post">
        <?=input("nom", "Nom", "text", "fi-rr-user", "required", null, $nom ?? null)?>
        <?=input("prenom", "Prenom", "text", "fi-rr-user", "required", null, $prenom ?? null)?>
        <?=input("email", "Email", "text", "fi-rr-at", "required", null, $email ?? null)?>
        <?=input("password", "Mot de passe", "password", "fi-rr-lock", "required", $pattern["password"])?>
        <?=input("confirm", "Confirmation", "password", "fi-rr-lock", "required", $pattern["password"])?>
        <?=token($token)?>
        <input class="button-primary" type="submit" value="S'inscrire">
    </form>
</main>