<?php

use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/token.php";
/**
 * @var string $token
 * @var string $login
 * @var array $pattern
 */
?>
<main class="h-screen flex items-center justify-center gap-8 relative">
    <?=button("Accueil", "fi-rr-angle-small-left", Action::HOME->value, "!absolute !pl-2 top-16 left-0")?>
    <h1 class="w-[36rem]">Nous rejoindre en tant qu'étudiant</h1>
    <form class="flex flex-col items-center gap-4" action="<?=Action::ETUDIANT_SIGN_UP->value?>" method="post">
        <?=input("login", "Login", "text", "fi-rr-user", "required", null, $login)?>
        <?=input("password", "Mot de passe", "password", "fi-rr-lock", "required", $pattern["password"])?>
        <?=input("confirm", "Confirmation", "password", "fi-rr-lock", "required", $pattern["password"])?>
        <?=token($token)?>
        <input class="button-primary" type="submit" value="S'inscrire">
        <p>Vous avez déjà un compte étudiant ? <a class="font-bold" href="<?=Action::ETUDIANT_SIGN_IN_FORM->value?>">Se connecter</a></p>
        <p>Vous êtes une entreprise ? <a class="font-bold" href="<?=Action::ENTREPRISE_ADD_FORM->value?>">Entreprise</a></p>
    </form>
</main>