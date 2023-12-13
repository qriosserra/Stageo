<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Offre;
use Stageo\Lib\UserConnection;
use \Stageo\Model\Object\Etudiant;
use \Stageo\Model\Repository\PostulerRepository;
use \Stageo\Model\Object\Entreprise;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
include __DIR__ . "/../../macros/offre.php";
/**
 * @var Offre $offre
 * @var string $nomentreprise
 * @var string $unite_gratification
 */
?>
<main class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full mt-12 max-w-2xl p-4 bg-white rounded-lg shadow-lg">
        <div class="relative">
            <div class="h-20 rounded-t-xl bg-blue-500 flex items-center justify-center">
                <div class="mb-1 h-5 text-xl font-bold text-black"><?= $offre->getThematique()?></div>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-center space-x-4">
                <div class="flex-1 border-b border-gray-300 py-2"><?= $nomentreprise?></div>
                <div class="flex-1 border-b border-gray-300 py-2"><?= $offre->getSecteur() ?></div>
            </div>

            <div class="py-4 text-gray-700">
                <p class="text-lg font-bold">Description</p>
                <div class="border border-gray-300 bg-gray-200 p-2">
                    <textarea readonly class="w-full h-40 resize-none bg-transparent"><?= $offre->getDescription() ?></textarea>
                </div>
            </div>

            <div class="py-4 text-gray-700">
                <p class="text-lg font-bold">Fonctions &amp; tâches</p>
                <div class="border border-gray-300 bg-gray-200 p-2">
                    <textarea readonly class="w-full h-40 resize-none bg-transparent"><?= $offre->getTaches() ?></textarea>
                </div>
            </div>

            <div class="py-4 text-gray-700">
                <p class="text-lg font-bold">Commentaire</p>
                <div class="border border-gray-300 bg-gray-200 p-2">
                    <textarea readonly class="w-full h-40 resize-none bg-transparent"><?= $offre->getCommentaires() ?></textarea>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-xl text-gray-500">
                    <p>Niveau</p>
                    <div class="border border-gray-300 bg-gray-200 p-2"><?= $offre->getNiveau() ?></div>
                </div>
                <div class="text-xl text-gray-500">
                    <p>Gratification</p>
                    <div class="border border-gray-300 bg-gray-200 p-2">
                        <p><?= $offre->getGratification() ?>€ / <?= $unite_gratification ?>/heure</p>
                    </div>
                </div>
                <div class="text-xl text-gray-500">
                    <p>Date</p>
                    <div class="flex items-center space-x-2">
                        <div class="border border-gray-300 bg-gray-200 p-2"><?= $offre->getDateDebut() ?></div>
                        <?php if ($offre->getDateFin()): ?>
                            <div class="h-1 w-1 rounded-full bg-blue-200"></div>
                            <div class="border border-gray-300 bg-gray-200 p-2"><?= $offre->getDateFin() ?></div>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-y-4">
                <?php if (UserConnection::isSignedIn() && UserConnection::isInstance(new Entreprise) && UserConnection::getSignedInUser()->getIdEntreprise() == $offre->getIdEntreprise()): ?>
                    <button onclick="window.location.href='<?= Action::ENTREPRISE_MODIFICATION_OFFRE_FORM->value ?><?= $offre->getIdOffre() ?>'" class="btn-blue">Modifier</button>
                    <button onclick="window.location.href='<?= Action::ENTREPRISE_DELETE_OFFRE->value ?><?= $offre->getIdOffre() ?>'" class="btn-blue">Supprimer</button>
                <?php endif ?>
                <?php if (UserConnection::isSignedIn() && UserConnection::isInstance(new Etudiant) && !(new PostulerRepository())->a_Postuler(UserConnection::getSignedInUser()->getLogin(), $offre->getIdOffre()) && !$offre->getLogin()): ?>
                    <button onclick="window.location.href='<?= Action::ETUDIANT_POSTULER_OFFRE_FORM->value ?>&id=<?= $offre->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="btn-blue">Postuler</button>
                <?php endif ?>
                <?php if (UserConnection::isSignedIn() && UserConnection::isInstance(new Etudiant) && ($offre->getLogin() == (UserConnection::getSignedInUser())->getLogin()) && !$offre->getValiderParEtudiant()): ?>
                    <button onclick="window.location.href='<?= Action::VALIDER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $offre->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="btn-blue">Valider Définitivement</button>
                    <button onclick="window.location.href='<?= Action::REFUSER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $offre->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="btn-blue">Refuser Définitivement</button>
                <?php endif ?>
            </div>
        </div>
    </div>
</main>
