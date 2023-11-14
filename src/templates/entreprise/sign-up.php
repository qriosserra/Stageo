<?php
use Stageo\Lib\enums\Pattern;

use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
/**
 * @var string $token
 * @var string $email
 * @var array $pattern
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .btn3 {
            transform: scale(1);
            transition: transform .2s ease-in
        }

        .btn3:hover {
            transform: scale(1.1);
        }

        .btn3 span {
            transform: scale(1);
            transition: transform .3s ease-in
        }

        .btn3:hover span {
            transform: scale(1.1, 1.2);
        }

        @media screen and (max-width: 455px) {
            .btn3 {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="flex justify-between items-center border-b">
        <a href="www.google.fr" class="inline-flex items-center">
            <div class="mt-3 ml-3">
                <img src=" assets/img/logo.png" class="h-[1.8rem] w-[7rem] ">
                <p style="font-family: Montserrat;" class="text-blue-900">Pour les entreprises</p>
            </div>
        </a>
        <button class="btn3 border  uppercase font-semibold tracking-wider mr-5 leading-none  rounded"
            type="button">
            <span class="absolute inset-0 "></span>
            <a  href="<?=Action::ENTREPRISE_SIGN_IN_FORM->value?>" class="relative px-12 py-3 rounded bg-blue-500 text-white text-1xl font-bold">
                Se connecter
            </a>
        </button>
    </nav>


    <div class="flex items-center justify-center h-40 bg-gradient-to-r from-cyan-500 via-blue-800 to-blue-400 font-bold text-white">
        <span class="text-lg sm:text-xl lg:text-2xl xl:text-4xl">Créer votre compte entreprise</span>
    </div>

    <div class="max-w-lg mx-auto  p-8">
        <p class="text-lg text-center font-semibold mb-5">Attirez ici les futurs piliers de votre organisation.
            Présentez-vous là où ils cherchent et démontrez-leur les raisons pour lesquelles rejoindre votre équipe
            serait une opportunité incontournable pour eux.</p>

        <form class="bg-white p-6 rounded shadow-md border-t-4 border-blue-500" method="post">

            <div class="mb-4">
            <?=field("raison_sociale", "Nom de l'entreprise*", "text", "Entrez le nom de l'entreprise", Pattern::NAME, true, $entreprise->getRaisonSociale())?>
            </div>
            <div class="mb-4">
            <?=field("email", "Email*", "email", "Entrez un email de contact", null, true, $entreprise->getUnverifiedEmail(), "sm:col-span-2")?>

                    
            </div>
            <div class="mb-4">
            <?=field("password", "Mot de passe*", "password", "Entrez un mot de passe", null, true)?>
            </div>
            <div class="mb-4">
            <?=field("confirm", "Confirmer le mot de passe*", "password", "Confirmez le mot de passe", null, true)?>

            </div>
            <div class="mb-4">
                <label class="block">
                    <input type="checkbox" name="terms" class="mr-2 leading-tight">
                    <span class="text-sm">
                        En cochant cette case, je certifie occuper un poste au sein des Ressources Humaines, de l'Équipe
                        de Recrutement, du Département Marketing ou des Relations Publiques, ou faire partie du corps
                        dirigeant de ma société. J'adhère ainsi aux termes et conditions et je valide la politique de
                        confidentialité de Stageo au nom de mon entreprise.
                    </span>
                </label>
            </div>

            <div class="mb-4">
                <button type="submit"
                    class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-700 transition-colors">S'inscrire</button>
            </div>
            <div class="text-center">

            <a href="<?=Action::ENTREPRISE_SIGN_IN_FORM->value?>" class="text-sm text-blue-600 hover:underline">Vous avez déjà un compte ? Se connecter</a>
            </div>
        </form>
    </div>

    <footer class="bg-gray-100 mt-10">
        <div class="mt-4 border-t border-gray-300 pt-3">
            <p class="text-gray-600 text-center">Se connecter en tant que : Etudiant, Entreprise</p>
            <p class="text-gray-500 text-xs text-center mt-4">Copyright © 2023, Stageo « Stageo » et son logo
                sont des branches officiel de l'IUT Montpellier/Sète.
            </p>
        </div>
        </div>
    </footer>
</body>

</html>