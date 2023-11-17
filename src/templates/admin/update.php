<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Admin;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
/**
 * @var Admin $user
 * @var string $token
 */
?>
<main class="h-screen flex flex-col items-center justify-center">
    <?=button("Accueil", "fi-rr-home", Action::HOME, "!absolute !pl-2 top-16 left-0")?>
    <h5 class="font-bold py-6">Modifier Information</h5>
    <form class="w-[60vw] grid gap-8" action="<?=Action::ADMIN_MODIFICATION_INFO->value?>" method="post">
        <input type="hidden" name="id" value="<?= $user->getIdAdmin() ?>">
        <?=field("email", "email", "text", "", Pattern::NAME, true, $user->getEmail(), null)?>
        <?=field("nom", "nom", "text", null, Pattern::NAME,true, $user->getNom(), null)?>
        <?=field("prenom", "prenom", "text", "", null, true, $user->getPrenom())?>
        <?=field("password", "Ancien mot de passe", "password", "Entrez votre mot de passe actuel", Pattern::PASSWORD, true)?>
        <?=field("new_password1", "Nouveau mot de passe", "password", "Entrez votre mot nouveau mot de passe", Pattern::PASSWORD, false)?>
        <?=field("new_password2", "Confirmer nouveau mot de passe", "password", "Entrez de nouveau votre mot de passe", Pattern::PASSWORD, false)?>
        <?=token($token)?>
        <?=submit("Enregistrer")?>
    </form>
</main>
