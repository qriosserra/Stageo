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


<div class="container mx-auto p-4 mt-[10rem]  border-2 rounded-2xl ">
    <div class=" rounded p-6">
        <div class="mb-4">
            <h1 class="text-2xl  text-center font-bold mb-2"><?= $offre->getThematique() ?> </h1>
            <h6 class=" text-center"> <?= $nomentreprise ?></h2>
                <div class="flex mb-4">
                    Secteur : <?= $offre->getSecteur() ?>
                </div>

        </div>

        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2">Description de l’employeur :</h2>
            <p class="text-gray-700 text-base mb-4">
                <?= $offre->getDescription() ?>
            </p>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2">Tâches : </h2>
            <p class="text-gray-700 text-base mb-4">
                <?= $offre->getTaches() ?>
            </p>
        </div>
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2">Commentaires : </h2>
            <p class="text-gray-700 text-base mb-4">
                <?= $offre->getCommentaires() ?>
            </p>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2">Niveau demandé : </h2>
            <p class="text-gray-700 text-base mb-4">
                <?= $offre->getNiveau() ?>
            </p>
        </div>

        <div class="mb-8 flex flex-row">
            <p class="font-bold">Gratification : </p>
            <p><?= $offre->getGratification() ?>€ / <?= $unite_gratification ?>/heure</p>


        </div>

        <div class="mb-8">
        
                    <div class="flex items-center space-x-2">
                    <p class="mr-3">Date :</p>
                        <div class=" p-2"><?= $offre->getDateDebut() ?></div>
                        <?php if ($offre->getDateFin()): ?>
                            <div class="h-1 w-1 rounded-full"></div>
                            <div class=" p-2"><?= $offre->getDateFin() ?></div>
                        <?php endif ?>
                    </div>
        </div>

    </div>
</div>

<div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-x-4 mt-4">
        <?php if (UserConnection::isSignedIn() && UserConnection::isInstance(new Entreprise) && UserConnection::getSignedInUser()->getIdEntreprise() == $offre->getIdEntreprise()) : ?>
        <button onclick="window.location.href='<?= Action::ENTREPRISE_MODIFICATION_OFFRE_FORM->value ?><?= $offre->getIdOffre() ?>'" class="px-4 py-2 bg-blue-500 text-white text-sm font-bold uppercase rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150 ease-in-out">Modifier</button>
        <button onclick="window.location.href='<?= Action::ENTREPRISE_DELETE_OFFRE->value ?><?= $offre->getIdOffre() ?>'" class="px-4 py-2 bg-red-500 text-white text-sm font-bold uppercase rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-150 ease-in-out">Supprimer</button>
    <?php endif ?>
    <?php if (UserConnection::isSignedIn() && UserConnection::isInstance(new Etudiant) && !(new PostulerRepository())->a_Postuler(UserConnection::getSignedInUser()->getLogin(), $offre->getIdOffre()) && !$offre->getLogin()) : ?>
        <button onclick="window.location.href='<?= Action::ETUDIANT_POSTULER_OFFRE_FORM->value ?>&id=<?= $offre->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="px-4 py-2 bg-green-500 text-black text-sm font-bold uppercase rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-150 ease-in-out">Postuler</button>
    <?php endif ?>
    <?php if (UserConnection::isSignedIn() && UserConnection::isInstance(new Etudiant) && ($offre->getLogin() == (UserConnection::getSignedInUser())->getLogin()) && !$offre->getValiderParEtudiant()) : ?>
        <button onclick="window.location.href='<?= Action::VALIDER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $offre->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="px-4 py-2 bg-yellow-500 text-black text-sm font-bold uppercase rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300 transition duration-150 ease-in-out">Valider Définitivement</button>
        <button onclick="window.location.href='<?= Action::REFUSER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $offre->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="px-4 py-2 bg-gray-500 text-black text-sm font-bold uppercase rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-150 ease-in-out">Refuser Définitivement</button>
    <?php endif ?>
</div>