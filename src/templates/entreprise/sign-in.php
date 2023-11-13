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
<body class="h-screen" >
    <nav class="flex justify-between items-center border-b bg-slate-50 shadow">
        <a href="<?=Action::HOME->value?>" class="inline-flex items-center">
            <div class="mt-3 ml-3">
                <img src="assets/img/logo.png" class="h-[1.8rem] w-[7rem] ">
                <p style="font-family: Montserrat;" class="text-blue-900">Pour les entreprises</p>
            </div>
        </a>

    </nav>
    <section class=" section-1 flex flex-row-reverse ">
        <aside class=" aside-1 flex justify-center bg-black w-full xl:w-1/2 min-h-[915px]
        " > 
            <img src="assets/img/business.svg"  class="le-svg"  alt="">  
        </aside>
        <aside class=" aside-2 flex justify-center items-center w-1/2  min-h-[915px] h-screen" >
            <form class="forme bg-white p-6 rounded shadow-md border-t-4 min-w-[60%] min-h-[40%] border-blue-500 mx-auto max-w-sm " action="<?=Action::ENTREPRISE_SIGN_IN->value?>" method="post">

                <h1 class="text-center mb-4 text-2xl font-bold mt-8">Centre Entreprise</h1>
                <div class="mb-4">
                <?=field("email", "Email*", "email", "Entrez l'email utilisé par l'entreprise", null, true, $email ?? null)?>
                </div>
                <div class="mb-4">
                <?=field("password", "Mot de passe", "password", "Entrez le mot de passe d'entreprise", Pattern::PASSWORD, true)?>
                </div>

                <div class="mb-4">
                    <label class="block">
                        <input type="checkbox" name="terms" class="mr-2 leading-tight">
                        <span class="text-sm">
                            Restez connecté ?
                        </span>
                        <a class="text-blue-600 sm:float-right">Mot de passe oublié ?</a>

                    </label>
                </div>
    
                <div class="mb-4">
                <?=submit("Connexion")?>
                </div>
                <div class="text-center">
                <a href="<?=Action::ENTREPRISE_SIGN_UP_FORM->value?>">Inscrire son entreprise</a>
                <?=token($token)?>

                </div>
            </form>
        </aside>
    </section>
    <style>
        body {
            overflow: hidden;
        }
        .aside-1 {
            /* fait un degradé de couleur avec un cerlce blanc au millieu */
            background-color: rgb(59,130,246);
        }
@media screen and (max-width: 976px) {

body {
    overflow: visible;
}
    .section-1 {
        flex-direction: column;
    }

    .aside-1 {
        min-height: 50vh;
    }
    .aside-2 {
        width: 100%;
        height: auto; /* Ajouté pour remplacer la hauteur d'écran fixe */
        align-items: flex-start;

        min-height: 50vh;
    }

    .forme {
        margin-top: 10%;
        width: auto; 
        height: auto; 
    }
    .le-svg {
        max-height: 50vh;
    }
}
    </style>
</body>