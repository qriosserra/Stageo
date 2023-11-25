<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Lib\HTTP\Session;
use Stageo\Model\Object\Offre;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
/**
 * @var string $token
 * @var array $unite_gratifications
 * @var float $gratification
 * @var Offre $offre
 */
?>
<main class="h-screen flex flex-col items-center justify-center">
    <form class="bg-white h-screen lg:h-auto w-screen lg:w-[64rem] overflow-scroll p-12 text-gray-600 rounded-lg shadow-lg grid gap-8" action="<?=Action::ENTREPRISE_CREATION_OFFRE->value?>" method="post">
        <h4 class="lg:col-span-2">Ajouter une offre</h4>
        <?=field("secteur", "Secteur de l'offre*", "text", "Entrez le secteur de l'offre", Pattern::NAME, true, $offre->getSecteur() ?? '', null)?>
        <?=field("thematique", "Thématique de l'offre*", "text", "Entrez la thématique de l'offre", Pattern::NAME,true, $offre->getThematique(), null)?>
        <?=textarea("description", "Description", "Entrez une description brève de l'offre", 4, false, $offre->getDescription(), "lg:col-span-2")?>
        <?=textarea("taches", "Fonctions et tâches", "Entrez les fonctions et tâches que sera amené à faire l'étudiant", 4,false, $offre->getTaches())?>
        <?=textarea("commentaires", "Commentaires sur l'offre", "Entrez des commentaires optionnels sur l'offre",4,false,$offre->getCommentaires())?>
        <?php if (!isset($gratification)){
            $gratification=null;
        }?>
        <?=field("gratification", "Gratification par heure", "float", null, null, true, $gratification, $offre->getGratification())?>
        <?=dropdown("id_unite_gratification", "Unité de gratification", null, null, 2, $unite_gratifications)?>
        <div class="flex items-center col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                <div>
                    <input id="alternance" type="radio" value="alternance" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        <?php if ($offre->getType() === 'alternance') echo 'checked'; ?>>
                    <label for="alternance" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Alternance</label>
                </div>

                <div>
                    <input id="stage" type="radio" value="stage" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        <?php if ($offre->getType() === 'stage') echo 'checked'; ?>>
                    <label for="stage" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stage</label>
                </div>

                <div>
                    <input id="Stage&Alternance" type="radio" value="Stage&Alternance" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        <?php if ($offre->getType() === 'Stage&Alternance') echo 'checked'; ?>>
                    <label for="Stage&Alternance" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stage&Alternance</label>
                </div>
            </div>
        </div>
        <?=submit("Publier")?>
        <?=token($token)?>
    </form>
</main>