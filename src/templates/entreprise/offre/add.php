<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Offre;
use Stageo\Model\Object\Entreprise;
use Stageo\Lib\enums\Pattern;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
include __DIR__ . "/../../macros/offre.php";

/**
 * @var Offre $offre
 * @var Entreprise $entreprise
 * @var array $unite_gratifications
 * @var string $token
 * @var float $gratification
 */
?>

<main class="h-screen flex flex-col items-center justify-center">
    <?=button("Accueil", "fi-rr-home", Action::HOME, "!absolute !pl-2 top-16 left-0")?>
    <h5 class="font-bold py-6"><?= $offre->getIdOffre() !== null ? 'Modifier' : 'Ajouter' ?> une offre</h5>

    <form class="w-[60vw] grid grid-cols-2 gap-8"
          action="<?= $offre->getIdOffre() !== null ? Action::ENTREPRISE_MODIFICATION_OFFRE->value . '&id=' . $offre->getIdOffre() : Action::ENTREPRISE_CREATION_OFFRE->value ?>"
          method="post">

        <?php if ($offre->getIdOffre() !== null) : ?>
            <input type="hidden" name="idOffre" value="<?= $offre->getIdOffre() ?>">
        <?php endif; ?>

        <?=field("secteur", "Secteur de l'offre", "text", "", Pattern::NAME, true, $offre->getSecteur() ?? '', null)?>
        <?=field("thematique", "Thématique de l'offre", "text", null, Pattern::NAME, true, $offre->getThematique(), null)?>
        <?=textarea("description", "Description", "", 4, false, $offre->getDescription(), "col-span-2")?>

        <div class="col-span-2 sm:col-span-1">
            <?=textarea("taches", "Fonctions et tâches", "", 4, false, $offre->getTaches())?>
        </div>

        <div class="col-span-2 sm:col-span-1">
            <?=textarea("commentaires", "Commentaires sur l'offre", "", 4, false, $offre->getCommentaires())?>
        </div>

        <?php if (!isset($gratification)){
            $gratification=null;
        }?>

        <?=field("gratification", "Gratification par heure", "float", "", null, true,$offre->getGratification())?>
        <?=dropdown("id_unite_gratification", "Unité de gratification", null, null, 2, $unite_gratifications)?>

        <div class="flex items-center col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                <div>
                    <input id="alternance" type="radio" value="alternance" name="emploi"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        <?php if ($offre->getType() === 'alternance') echo 'checked'; ?>>
                    <label for="alternance" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Alternance</label>
                </div>

                <div>
                    <input id="stage" type="radio" value="stage" name="emploi"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        <?php if ($offre->getType() === 'stage') echo 'checked'; ?>>
                    <label for="stage" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stage</label>
                </div>

                <div>
                    <input id="Stage&Alternance" type="radio" value="Stage&Alternance" name="emploi"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        <?php if ($offre->getType() === 'Stage&Alternance') echo 'checked'; ?>>
                    <label for="Stage&Alternance" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stage&Alternance</label>
                </div>
            </div>
        </div>

        <?=submit($offre->getIdOffre() !== null ? "Modifier" : "Publier")?>
        <?=token($token)?>
    </form>
</main>
