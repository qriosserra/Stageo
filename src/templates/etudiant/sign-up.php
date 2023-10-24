<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
/**
 * @var string $token
 * @var string $login
 * @var array $pattern
 */
?>
<main class="h-screen flex items-center justify-center gap-8 relative">
    <?=button("Accueil", "fi-rr-angle-small-left", Action::HOME, "!absolute !pl-2 top-16 left-0")?>
    <h1 class="w-[36rem]">Nous rejoindre en tant qu'étudiant</h1>
    <form class="flex flex-col items-center gap-4" action="<?=Action::ETUDIANT_SIGN_UP->value?>" method="post">
        <?=field("login", "Login", "text", "Entrez votre login", null, true, $login)?>
        <?=field("password", "Mot de passe", "password", "Entrez un mot de passe", Pattern::PASSWORD, true)?>
        <?=field("confirm", "Confirmation", "password", "Confirmez votre mot de passe", Pattern::PASSWORD, true)?>
        <?=submit("S'inscire")?>
        <?=token($token)?>
        <p>Vous avez déjà un compte étudiant ? <a class="font-bold" href="<?=Action::ETUDIANT_SIGN_IN_FORM->value?>">Se connecter</a></p>
        <p>Vous êtes une entreprise ? <a class="font-bold" href="<?=Action::ENTREPRISE_ADD_STEP_1_FORM->value?>">Entreprise</a></p>
    </form>
</main>