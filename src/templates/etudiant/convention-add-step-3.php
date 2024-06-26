<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Convention;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
/**
 * @var string $token
 * @var Convention $convention
 */
?>
<main class="bg-gray-100 w-full">
    <nav class="flex justify-between items-center border-b">
        <a href="<?=Action::HOME->value?>" class="inline-flex items-center">
            <div class="mt-3 ml-3">
                <img src="assets/img/logo.png" class="h-[1.8rem] w-[7rem]">
                <p style="font-family: Montserrat,serif;" class="text-blue-900">Pour les étudiants</p>
            </div>
        </a>
    </nav>
    <div class="flex items-center justify-center h-40 bg-gradient-to-r from-cyan-500 via-blue-800 to-blue-400 font-bold text-white">
        <span class="text-center" style="font-size: clamp(1rem, 5vw, 2rem)">Créer une convention</span>
    </div>
    <div class="max-w-lg mx-auto p-8 space-y-4">
        <h4 class="text-center">Informations sur le tuteur de stage</h4>
        <form action="<?=Action::ETUDIANT_CONVENTION_ADD_STEP_3->value?>" method="post" class="bg-white p-6 grid gap-4 rounded shadow-md border-t-4 border-blue-500">
            <?=field("prenom", "Prénom", "text", "Entrez le prénom de votre tuteur de stage", null, false, $convention->getTuteurPrenom())?>
            <?=field("nom", "Nom", "text", "Entrez le nom de votre tuteur de stage", null, false, $convention->getTuteurNom())?>
            <?=field("email", "Email", "text", "Entrez l'email de votre tuteur de stage", null, false, $convention->getTuteurEmail())?>
            <?=field("telephone", "Téléphone", "text", "Entrez le téléphone de votre tuteur de stage", null, false, $convention->getTuteurTelephone())?>
            <?=field("fonction", "Fonction", "text", "Entrez sa fonction dans l'entreprise", null, false, $convention->getTuteurFonction())?>
            <?=submit("Suivant")?>
            <?=token($token)?>
        </form>
    </div>
</main>