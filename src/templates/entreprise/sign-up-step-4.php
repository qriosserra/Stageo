<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/breadcrumb.php";
/**
 * @var Entreprise $entreprise
 * @var string $token
 */
?>

<main class="h-screen flex items-center justify-center gap-2 relative">
    <?=breadcrumb(4, [
        "Information générale" => Action::ENTREPRISE_SIGN_UP_STEP_1_FORM->value,
        "Détails techniques" => Action::ENTREPRISE_SIGN_UP_STEP_2_FORM->value,
        "Adresse postale" => Action::ENTREPRISE_SIGN_UP_STEP_3_FORM->value,
        "Authentification" => Action::ENTREPRISE_SIGN_UP_STEP_4_FORM->value
    ])?>
    <form class="bg-white p-12 text-gray-600 rounded-lg shadow-lg grid gap-8" action="<?=Action::ENTREPRISE_SIGN_UP_STEP_4->value?>" method="post">
        <h4 class="sm:col-span-2">4. Authentification</h4>
        <?=field("email", "Email*", "email", "Entrez un email de contact", null, true, $entreprise->getUnverifiedEmail(), "sm:col-span-2")?> // FIXME : EMAIL enlever, et mis dans sign-up.php/entreprise
        <?=field("password", "Mot de passe*", "password", "Entrez un mot de passe", null, true)?> // FIXME : MPD enlever, et mis dans sign-up.php/entreprise
        <?=field("confirm", "Confirmer le mot de passe*", "password", "Confirmez le mot de passe", null, true)?> // FIXME : MPD enlever, et mis dans sign-up.php/entreprise
        <div class="sm:col-span-2">
            <p>Le mot de passe doit au moins contenir:</p>
            <ul>
                <li>- 8 caractères</li>
                <li>- Une lettre minuscule</li>
                <li>- Une lettre majuscule</li>
                <li>- Un chiffre</li>
            </ul>
        </div>
        <?=submit("Finaliser l'inscription", "sm:col-span-2")?>
        <?=token($token)?>
    </form>
</main>