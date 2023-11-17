<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Convention;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";

/**
 * @var string $token
 * @var Convention $convention
 * @var array $conventions
 */
?>
<!--créer des onglets pour les deux types de conventions (stage et alternance) : -->
<main  class="mt-24">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Onglets Stages et Alternances</title>
        <style>
            .onglets {
                display: flex;
            }

            .onglet {
                flex: 1;
                text-align: center;
                padding: 10px;
                background-color: #ccc;
                cursor: pointer;
            }

            .contenu {
                display: none;
                padding: 20px;
            }
        </style>
    </head>
    <body>
    <div class="onglets">
        <div class="onglet" onclick="afficherContenu('stages')">Stages</div>
        <div class="onglet" onclick="afficherContenu('alternances')">Alternances</div>
    </div>

    <div class="contenu" id="stages">
        <?php foreach ($conventions as $convention):?>
        <?php if ($convention->getTypeConvention() == "1"):?>
            <a href="<?=Action::SECRETAIRE_CONVENTION_DETAILS->value . "&{$convention->getIdConvention()}"?>" class="flex flex-col justify-between items-center bg-white p-4 rounded-lg shadow-lg">
                <div class="inline-flex">
                    <h3 class="text-lg font-semibold"><?=$convention->getLogin()?></h3>
                    <p class="text-sm text-gray-500"><?=$convention->getSujet()?></p>
                </div>
                <div class="inline-flex">
                    <p class="text-sm text-gray-500"><?=$convention->getDateDebut()?></p>
                    <p class="text-sm text-gray-500"><?=$convention->getGratification()?></p>
                </div>
            </a>
        <?php endif?>
        <?php endforeach?>

    </div>

    <div class="contenu" id="alternances">
        <?php foreach ($conventions as $convention):?>
        <?php if ($convention->getTypeConvention() == "2"):?>
            <a href="<?=Action::SECRETAIRE_CONVENTION_DETAILS->value . "&{$convention->getIdConvention()}"?>" class="flex flex-col justify-between items-center bg-white p-4 rounded-lg shadow-lg">
                <div class="inline-flex">
                    <h3 class="text-lg font-semibold"><?=$convention->getLogin()?></h3>
                    <p class="text-sm text-gray-500"><?=$convention->getSujet()?></p>
                </div>
                <div class="inline-flex">
                    <p class="text-sm text-gray-500"><?=$convention->getDateDebut()?></p>
                    <p class="text-sm text-gray-500"><?=$convention->getGratification()?></p>
                </div>
            </a>
        <?php endif?>
        <?php endforeach?>

    </div>

    <script>
        function afficherContenu(ongletId) {
            // On commence par récupérer tous les onglets et tous les contenus
            let elements_onglets = document.getElementsByClassName('onglet');
            let elements_contenu = document.getElementsByClassName('contenu');

            // On parcourt les onglets pour les désactiver tous...
            for(let i = 0; i < elements_onglets.length; i++) {
                elements_onglets[i].classList.remove('actif');
            }

            // On parcourt les contenus pour les masquer tous...
            for(let i = 0; i < elements_contenu.length; i++) {
                elements_contenu[i].style.display = 'none';
            }

            // On affiche le contenu de l'onglet cliqué
            document.getElementById(ongletId).style.display = 'block';

            // On rend actif l'onglet cliqué
            event.currentTarget.classList.add('actif');
        }
    </script>
    </body>

</main>