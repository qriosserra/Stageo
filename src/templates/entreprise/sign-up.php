<?php

use Stageo\Lib\enums\Pattern;
use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/input.php";
/**
 * @var string $token
 * @var Entreprise $entreprise
 */
?>
<main class="bg-gray-100 w-full">
    <nav class="flex justify-between items-center border-b">
        <a href="<?=Action::HOME->value?>" class="inline-flex items-center">
            <div class="mt-3 ml-3">
                <img src="assets/img/logo.png" class="h-[1.8rem] w-[7rem]">
                <p style="font-family: Montserrat,serif;" class="text-blue-900">Pour les entreprises</p>
            </div>
        </a>
        <button class="hidden sm:block scale-100 hover:scale-110 transition border uppercase font-semibold tracking-wider mr-5 leading-none rounded">
            <a  href="<?=Action::ENTREPRISE_SIGN_IN_FORM->value?>" class="relative px-12 py-3 rounded bg-blue-500 text-white text-1xl font-bold">
                Se connecter
            </a>
        </button>
    </nav>
    <div class="flex items-center justify-center h-40 bg-gradient-to-r from-cyan-500 via-blue-800 to-blue-400 font-bold text-white">
        <span class="text-lg sm:text-xl lg:text-2xl xl:text-4xl">Créer votre compte entreprise</span>
    </div>
    <div class="max-w-lg mx-auto  p-8">
        <p class="text-lg text-center font-semibold mb-5">
            Attirez ici les futurs piliers de votre organisation.
            Présentez-vous là où ils cherchent et démontrez-leur les raisons pour lesquelles rejoindre votre équipe
            serait une opportunité incontournable pour eux.
        </p>
        <form action="<?=Action::ENTREPRISE_SIGN_UP_STEP_4->value?>" method="post" class="bg-white p-6 rounded shadow-md border-t-4 border-blue-500 space-y-4">
            <?=field("email", "Email professionelle*", "email", "Entrez un email de contact", null, true, $entreprise->getUnverifiedEmail(), "sm:col-span-2")?>
            <?=field("password", "Mot de passe*", "password", "Entrez un mot de passe", Pattern::PASSWORD, true)?>
            <?=field("confirm", "Confirmer le mot de passe*", "password", "Confirmez le mot de passe", Pattern::PASSWORD, true)?>
            <label class="block">
                <input type="checkbox" name="terms" class="mr-2 leading-tight">
                <span class="text-sm">
                    En cochant cette case, je certifie occuper un poste au sein des Ressources Humaines, de l'Équipe
                    de Recrutement, du Département Marketing ou des Relations Publiques, ou faire partie du corps
                    dirigeant de ma société. J'adhère ainsi aux termes et conditions et je valide la politique de
                    confidentialité de Stageo au nom de mon entreprise.
                </span>
            </label>
            <?=submit("S'inscrire", "w-full")?>
<!--            <a href="--><?php //=Action::ENTREPRISE_SIGN_IN_FORM->value?><!--" class="block w-full text-sm text-blue-600 text-center hover:underline">-->
<!--                Vous avez déjà un compte ? Se connecter-->
<!--            </a>-->
        </form>
    </div>
</main>
<footer class="bg-gray-100 mt-10">
    <div class="mt-4 border-t border-gray-300 pt-3">
        <p class="text-gray-600 text-center">
            Se connecter en tant que : Etudiant, Entreprise
        </p>
        <p class="text-gray-500 text-xs text-center mt-4">
            Copyright © 2023, Stageo « Stageo » et son logo sont des branches officiel de l'IUT Montpellier-Sète.
        </p>
    </div>
    </div>
</footer>