<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Offre;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
include __DIR__ . "/../../macros/offre.php";
/**
 * @var Offre $offre
 * @var string $unite_gratification
 */
?>

<main class="h-screen flex flex-col items-center justify-center">
    <?=button("Retour", "fi-rr-angle-small-left", Action::LISTE_OFFRE, "!absolute !pl-2 top-16 left-0")?>
    <h5 class="font-bold py-6"><?=$offre->getThematique()?></h5>
        <div class="flex flex-row !space-x-9 max-w-50">
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Secteur</dt>
                    <dd class="text-lg text-black font-semibold"> <?=$offre->getSecteur()?></dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Fonctions & tâches</dt>
                    <dd class="text-lg text-black font-semibold"><?=$offre->getTaches()?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Description</dt>
                    <dd class="block p-2.5 w-full text-sm text-gray-900 dark:text-white"><?=$offre->getDescription()?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Commentaire</dt>
                    <dd class="text-lg text-black font-semibold"><?=$offre->getCommentaires()?></dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 underline-offset-1">Gratification</dt>
                    <dd class="text-lg text-black font-semibold"><?=$offre->getGratification()?>€ <?=$unite_gratification?>/heure</dd>
                </div>
            </dl>
        </div>
    <?php if(\Stageo\Lib\UserConnection::isSignedIn() and \Stageo\Lib\UserConnection::isInstance(new \Stageo\Model\Object\Entreprise) and \Stageo\Lib\UserConnection::getSignedInUser()->getIdEntreprise()==$offre->getIdEntreprise()):?>
        <a href="<?=Action::ENTREPRISE_MODIFICATION_OFFRE_FORM->value?>&id=<?=$offre->getIdOffre()?>">
            Modifier
        </a>
        <a href="<?=Action::ENTREPRISE_DELETE_OFFRE->value?>&id=<?=$offre->getIdOffre()?>">
            Delete
        </a>
    <?php endif?>
</main>