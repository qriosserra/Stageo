<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
/**
 * @var Entreprise $entreprise
 * @var string $token
 */
?>

<main class="h-screen flex items-center justify-center gap-2 relative">
    <?=button("Précédent", "fi-rr-angle-small-left", Action::ENTREPRISE_ADD_STEP_3_FORM, "!absolute !pl-2 top-16 left-0")?>
    <h4 class="text-3xl font-bold">Ajouter mon entreprise</h4>
    <form class="grid gap-8" action="<?=Action::ENTREPRISE_ADD_STEP_3->value?>" method="post">
        <?=field("email", "Email*", "email", "Entrez un email de contact", null, true, $entreprise->getUnverifiedEmail() ?? null)?>
        <?=field("password", "Mot de passe*", "password", "Entrez un mot de passe", null, true)?>
        <div>
            <p>Le mot de passe doit au moins contenir:</p>
            <ul>
                <li>- 8 caractères</li>
                <li>- Une lettre minuscule</li>
                <li>- Une lettre majuscule</li>
                <li>- Un chiffre</li>
            </ul>
        </div>
        <?=field("confirm", "Confirmer le mot de passe*", "password", "Confirmez le mot de passe", null, true)?>
        <?=submit("Terminer l'inscription")?>
        <?=token($token)?>
    </form>
</main>