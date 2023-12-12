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
 * @var string $unite_gratification
 */
?>

<main class="h-full flex flex-col items-center justify-center w-full">
    <div class="block bg-white px-4 py-4 xl:w-1/2 w-full">
        <div class="mx-auto max-w-2xl">
            <div class="w-full">
                <div class="h-48 w-full rounded-t-xl bg-blue-500"></div>
                <div class="xl:absolute xl:-mt-20 xl:ml-5 invisible xl:visible">
                    <div class=" xl:flex-row xl:items-center flex-col flex">
                        <div class="mb-1 h-5 w-fit font-bold text-black"><h5><?= $offre->getThematique() ?></h5></div>
                    </div>
                </div>
            </div>
            <div class="bg-primary border-primary flex flex-col rounded-b-xl border p-5 pt-20 text-gray-500">
                <div class="mb-1 h-5 w-fit font-bold text-black visible xl:hidden pb-10"><h5><?= $offre->getThematique() ?></h5></div>
                <div class="flex flex-col gap-2 xl:flex-row xl:gap-8">
                    <div class="mb-1 h-5 w-fit border border-gray-300 bg-gray-200">Nom Entreprise</div>
                    <div class="0 mb-1 h-5 w-fit border border-gray-300 bg-gray-200"><?= $offre->getSecteur() ?></div>
                </div>

                <div class="bbcode break-all py-5 text-gray-500">
                    <p>Description</p>
                    <div class="h-min-20 mb-1 h-40 w-full border border-gray-300 bg-gray-200 p-1">
                        <textarea readonly class="h-full w-full resize-none justify-center bg-transparent"><?=$offre->getDescription()?></textarea>
                    </div>
                </div>
                <div class="bbcode break-all">
                    <p>Fonctions & tâches</p>
                    <div class="mb-1 h-40 xl:h-max-30 w-full border border-gray-300 bg-gray-200">
                        <textarea readonly class="h-full w-full resize-none justify-center bg-transparent"><?=$offre->getTaches()?></textarea>
                    </div>
                </div>
                <div class="bbcode break-all">
                    <p>Commentaire</p>
                    <div class="mb-1 h-40 xl:h-max-30 w-full border border-gray-300 bg-gray-200"><textarea readonly class="h-full w-full resize-none justify-center bg-transparent"><?=$offre->getCommentaires()?></textarea></div>
                </div>
                <div class="flex flex-col gap-1 xl:flex-row xl:gap-8">
                    <div class="mt-2 text-xl text-gray-500">
                        <p>Niveau</p>
                        <div class="ml-auto flex flex-row items-center space-x-2">
                            <div class="mb-1 h-5 w-fit border border-gray-300 bg-gray-200"><p><?=$offre->getNiveau()?></p></div>
                        </div>
                    </div>
                    <div class="mt-2 text-xl text-gray-500">
                        <p>Gratifification</p>
                        <div class="ml-auto flex flex-row items-center space-x-2">
                            <div class="mb-1 h-5 w-fit border border-gray-300 bg-gray-200"><p><?=$offre->getGratification()?>€ </p></div>
                            <div class="mb-1 h-5 w-fit border border-gray-300 bg-gray-200"><p><?=$unite_gratification?>/heure</p></div>
                        </div>
                    </div>
                    <div class="mt-2 text-xl text-gray-500">
                        <p>Date</p>
                        <div class="ml-auto flex flex-row items-center space-x-2">
                            <div class="mb-1 h-5 w-fit border border-gray-300 bg-gray-200"><p><?=$offre->getDateDebut()?></p></div>
                            <?php if($offre->getDateFin()):?>
                            <div class="h-1 w-1 rounded-full bg-blue-200"></div>
                            <div class="mb-1 h-5 w-fit border border-gray-300 bg-gray-200"><p><?=$offre->getDateFin()?></p></div>
                            <?php endif?>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-3 break-all py-5 xl:flex xl:flex-row">
                    <?php if(UserConnection::isSignedIn() and UserConnection::isInstance(new Entreprise) and UserConnection::getSignedInUser()->getIdEntreprise()==$offre->getIdEntreprise()):?>
                        <button onclick="window.location.href='<?=Action::ENTREPRISE_MODIFICATION_OFFRE_FORM->value?>&id=<?=$offre->getIdOffre()?>'" class="rounded-md border border-b-4 border-blue-950 bg-blue-500 p-1 text-black drop-shadow-xl transition-all duration-150 hover:text-white active:bg-blue-400">Modifier</button>
                        <button onclick="window.location.href='<?=Action::ENTREPRISE_DELETE_OFFRE->value?>&id=<?=$offre->getIdOffre()?>'" class="rounded-md border border-b-4 border-blue-950 bg-blue-500 p-1 text-black drop-shadow-xl transition-all duration-150 hover:text-white active:bg-blue-400">Supprimer</button>
                    <?php endif?>
                    <?php if(UserConnection::isSignedIn() and UserConnection::isInstance(new Etudiant) and !(new PostulerRepository())->a_Postuler(UserConnection::getSignedInUser()->getLogin(),$offre->getIdOffre()) and !$offre->getLogin()):?>
                        <button onclick="window.location.href='<?=Action::ETUDIANT_POSTULER_OFFRE_FORM->value?>&id=<?=$offre->getIdOffre()?>&login=<?=UserConnection::getSignedInUser()->getLogin()?>'" class="rounded-md border border-b-4 border-blue-950 bg-blue-500 p-1 text-black drop-shadow-xl transition-all duration-150 hover:text-white active:bg-blue-400">Postuler</button>
                    <?php endif?>
                    <?php if(UserConnection::isSignedIn() and UserConnection::isInstance(new Etudiant) and ($offre->getLogin() == (UserConnection::getSignedInUser())->getLogin()) and !$offre->getValiderParEtudiant()):?>
                        <button onclick="window.location.href='<?=Action::VALIDER_DEFINITIVEMENT_OFFRE->value?>&idOffre=<?=$offre->getIdOffre()?>&login=<?=UserConnection::getSignedInUser()->getLogin()?>'" class="rounded-md border border-b-4 border-blue-950 bg-blue-500 p-1 text-black drop-shadow-xl transition-all duration-150 hover:text-white active:bg-blue-400"> Valider Définitivement </button>
                        <button onclick="window.location.href='<?=Action::REFUSER_DEFINITIVEMENT_OFFRE->value?>&idOffre=<?=$offre->getIdOffre()?>&login=<?=UserConnection::getSignedInUser()->getLogin()?>'" class="rounded-md border border-b-4 border-blue-950 bg-blue-500 p-1 text-black drop-shadow-xl transition-all duration-150 hover:text-white active:bg-blue-400"> Refuser Définitivement</button>
                    <?php endif?>
                </div>
            </div>
        </div>
    </div>
</main>