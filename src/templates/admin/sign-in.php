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
<body class="">
<nav class="flex justify-between items-center border-b bg-slate-50 shadow">
    <a href="<?=Action::HOME->value?>" class="inline-flex items-center">
            <div class="mt-3 ml-3">
                <img src="assets/img/logo.png" class="h-[1.8rem] w-[7rem] ">
                <p style="font-family: Montserrat;" class="text-blue-900">Pour les admins</p>
            </div>
        </a>

    </nav>
    <div class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Connectez-vous au Centre administrateurs</h2>
        <form class="space-y-4" action="<?=Action::ETUDIANT_SIGN_IN->value?>" method="post">
            <div>
            <?=field("login", "Login*", "text", "Entrez votre login", null, true, $email ?? null)?>

            </div>

            <div>
            <?=field("password", "Mot de passe", "password", "Entrez le mot de passe", Pattern::PASSWORD, true)?>
            <?=token($token)?>

            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Mot de passe oublié ?</a>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Connexion
                </button>
            </div>
        </form>

    </div>
</div>
    <footer class="bg-gray-200 ">


        <!-- Bottom text -->
        <div class=" border-t border-gray-300 pt-3">
            <p class="text-gray-600 text-center">Se connecter en tant que : Etudiant, Entreprise</p>
            <p class="text-gray-500 text-xs text-center mt-4">Copyright © 2023, Stageo « Stageo » et son logo
                sont des branches officiel de l'IUT Montpellier/Sète.
            </p>
        </div>
        </div>
    </footer>
</body>