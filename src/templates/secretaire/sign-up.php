<?php

use Stageo\Lib\enums\Action;
use \Stageo\Lib\enums\Pattern;
//

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
/**
 * @var string $token
 * @var string $email
 * @var array $pattern
 */
?>
<main class="h-screen flex items-center justify-center gap-8 relative">
    <?=button("Accueil", "fi-rr-angle-small-left", Action::HOME, "!absolute !pl-2 top-16 left-0")?>
    <h1 class="w-[36rem]">Crée un(e) secrétaire</h1>
    <form class="flex flex-col items-center gap-4" action="<?=Action::SECRETAIRE_SIGN_UP->value?>" method="post">
        <?=field("email", "Email", "text", "fi-rr-at", null, "required", $email ?? null)?>
        <?=field("password", "Mot de passe", "password", "fi-rr-lock", Pattern::PASSWORD, "required")?>
        <?=field("confirm", "Confirmation", "password", "fi-rr-lock",    Pattern::PASSWORD, "required")?>
        <?=token($token)?>
        <input class="button-primary" type="submit" value="S'inscrire">
    </form>
</main>