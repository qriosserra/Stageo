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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <img src="assets/img/logo.png" class="h-[1.8rem] w-[7rem] ">
                <p style="font-family: Montserrat;" class="text-blue-900">Pour les entreprises</p>
            </div>


        </a>
        <button class="btn3 border border-black uppercase font-semibold tracking-wider mr-5 leading-none  rounded"
            type="button">
            <span class="absolute inset-0 "></span>
            <div style="background-color: rgba(21, 129, 230, 0.75);" class="relative px-12 py-3  text-white text-1xl font-bold">
                Se connecter
            </div>
        </button>
    </nav>


    <div class="flex items-center justify-center h-40 bg-cover font-bold text-white"
        style="background: linear-gradient(120deg, rgba(21, 129, 230, 0.75) 0%, rgba(0, 45, 141, 0.75) 50%, rgba(1, 7, 68, 0.75) 100%), url('/path-to-your-image.jpg');">
        <span class="text-lg sm:text-xl lg:text-2xl xl:text-4xl">Créer votre compte entreprise</span>
    </div>

    <div class="max-w-lg mx-auto  p-8">
        <p class="text-lg text-center font-semibold mb-5">Attirez ici les futurs piliers de votre organisation.
            Présentez-vous là où ils cherchent et démontrez-leur les raisons pour lesquelles rejoindre votre équipe
            serait une opportunité incontournable pour eux.</p>

        <form class="bg-white p-6 rounded shadow-md border-t-4 border-blue-500">

            <div class="mb-4">
                <input type="text" name="company" placeholder="Nom de l'Entreprise" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <input type="email" name="email" placeholder="Adresse e-mail professionnelle"
                    class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Mot de passe" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Confirmer votre Mot de passe"
                    class="w-full p-2 border rounded">
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
                <a href="#" class="text-sm text-blue-600 hover:underline">Vous avez déjà un compte ? Se connecter</a>
            </div>
        </form>
    </div>

    <footer class="bg-gray-100 mt-10">


        <!-- Bottom text -->
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