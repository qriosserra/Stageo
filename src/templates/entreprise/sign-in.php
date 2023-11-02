<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/breadcrumb.php";
/**
 * @var Entreprise $entreprise
 * @var string $token
 */
?>

<main class="h-screen flex flex-col items-center justify-center gap-2 relative">
    <?=button("Accueil", "fi-rr-home", Action::HOME, "!absolute !pl-2 bottom-16 left-0")?>
    <form class="bg-white p-12 w-screen sm:w-auto text-gray-600 rounded-lg shadow-lg grid gap-8" action="<?=Action::ENTREPRISE_SIGN_IN->value?>" method="post">
        <h4>Connexion à un compte entreprise</h4>
        <?=field("email", "Email*", "email", "Entrez l'email utilisé par l'entreprise", null, true, $email ?? null)?>
        <?=field("password", "Mot de passe", "password", "Entrez le mot de passe d'entreprise", Pattern::PASSWORD, true)?>
        <div class="flex flex-col sm:flex-row justify-between gap-2">
            <?=checkbox("stay_connected", "Rester connecté ?")?>
            <a class="text-blue-600 sm:float-right">Mot de passe oublié ?</a>
        </div>
        <?=submit("Connexion")?>
        <a href="<?=Action::ENTREPRISE_ADD_STEP_1_FORM->value?>">Inscrire son entreprise</a>
        <?=token($token)?>
    </form>
</main>