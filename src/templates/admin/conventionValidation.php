<?php

/**
 * @var \Stageo\Model\Object\Convention $convention
 * @var Entreprise $entreprise
 * @var \Stageo\Model\Object\Suivi $suivi
 * @var \Stageo\Model\Object\Etudiant $etudiant
 * @var string $unite_gratification
 * @var string $title
 */

use Stageo\Lib\enums\Action;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Secretaire;

if ($convention->getTypeConvention() == 1) {
    $type = "Stage";
} else {
    $type = "Alternance";
}
?>
<div class="h-40 flex justify-center items-center mt-[4rem]" style="background: linear-gradient(120deg, rgba(21, 129, 230, 0.75) 0%, rgba(0, 45, 141, 0.75) 50%, rgba(1, 7, 68, 0.75) 100%)">
    <h1 class="text-center font-medium text-white text-3xl text-shadow">
        <?= $type . ' : ' . $title ?>
    </h1>
</div>
<main class="flex w-full   my-20 justify-center items-center">
    <div class="w-[40rem] space-y-6 rounded-lg p-8 shadow-lg bg-white mr-10 ">
        <div style="background-color: #dedede;" class="rounded-md  p-2">
            <h1 class="text-center text-xl font-bold">Informations De la Convention</h1>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="first-name">Prénom</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="first-name"><?= $etudiant->getPrenom() ?></p>
            </div>
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="last-name">Nom</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="last-name"><?= $etudiant->getNom() ?></p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="first-name">Nom entreprise</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="first-name"><?= $entreprise->getRaisonSociale() ?>
                </p>
            </div>
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="last-name">Thématique</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="last-name"><?= $convention->getThematique() ?></p>
            </div>
        </div>
        <div>
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="description">Description</label>
            <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex min-h-[80px] w-full bg-gray-100 rounded-md border px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="description"><?= $convention->getDetails() ?></p>

        </div>
        <div>
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="function-task">Fonction &amp; Tâche</label>
            <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex min-h-[80px] w-full bg-gray-100 rounded-md border px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="function-task"><?= $convention->getTaches()  ?></p>

        </div>
        <div>
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="comment">Commentaire</label>
            <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex min-h-[80px] w-full bg-gray-100  rounded-md border px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="comment"><?= $convention->getCommentaires() ?></p>

        </div>
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="value1">Type</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full bg-gray-100 rounded-md border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="value1"> <?= $type ?></p>
            </div>
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="value2">Gratification</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full bg-gray-100 rounded-md border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="value2"> <?= $convention->getGratification() ?>€ / <?= $unite_gratification ?>/heure</p>
            </div>


        </div>
        <h6 class="text-center">Informations Tuteurs</h6>
        <div class="grid grid-cols-2 gap-4">
            
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="first-name">Prénom</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="first-name"><?= $convention->getTuteurPrenom() ?></p>
            </div>
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="last-name">Nom</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="last-name"><?= $convention->getTuteurNom() ?></p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" >Téléphone</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="first-name"><?= $convention->getTuteurTelephone() ?></p>
            </div>
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" >Email</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="last-name"><?= $convention->getTuteurEmail() ?></p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-1">
        <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" >Fonction</label>
                <p class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md bg-gray-100 border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="last-name"><?= $convention->getTuteurFonction() ?></p>
            </div>
        </div>
        <div class=" ">
            <label>Dates du contrat</label>
            <div class="flex items-center space-x-2 rounded-md">
                <div class="border border-gray-300 bg-gray-100 rounded-md p-2"><?= $convention->getDateDebut() ?></div>
                <?php if ($convention->getDateFin()) : ?>
                    <div class="h-1 w-1 rounded-full bg-blue-100"></div>
                    <div class="border border-gray-300 rounded-md bg-gray-100 p-2"><?= $convention->getDateFin() ?></div>
                <?php endif ?>
            </div>
        </div>
        <div class="flex flex-col justify-center items-center">
            <div class="m-3">
                <?php $user = UserConnection::getSignedInUser()?>
                <?php if ( ($user instanceof Enseignant && $user->getEstAdmin()) && $convention->getVerificationEntreprise() && !$convention->getVerificationSecretaire() && !$suivi->getModifiable()):?>
                    <button class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300">
                        <a href="<?= Action::ADMIN_VALIDERCONV->value."&idConv=".$convention->getIdConvention()?>">Valider et envoyer au secretaria</a>
                    </button>
                    <form method="post" action="<?= Action::ADMIN_INVALIDERCONV->value."&idConv=".$convention->getIdConvention() ?>">
                        <input name="raisonRefus" type="text" class="p-2 rounded-md bg-slate-100 m-1" placeholder="Raison du refus">
                        <button type="submit" class="rounded-lg px-4 py-2 bg-red-600 text-red-100 hover:bg-red-700 duration-300">Refuser</button>
                    </form>
                <?php elseif($user instanceof Secretaire && $convention->getVerificationEntreprise() && $convention->getVerificationAdmin() && !$suivi->getModifiable()):?>
                    <button class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300">
                        <a href="<?= Action::SECRETAIRE_VALIDERCONV->value."&idConv=".$convention->getIdConvention()?>">Valider définitivement la convention</a>
                    </button>
                    <form method="post" action="<?= Action::SECRETAIRE_INVALIDERCONV->value."&idConv=".$convention->getIdConvention() ?>">
                        <input name="raisonRefus" type="text" class="p-2 rounded-md bg-slate-100 m-1" placeholder="Raison du refus">
                        <button type="submit" class="rounded-lg px-4 py-2 bg-red-600 text-red-100 hover:bg-red-700 duration-300">Refuser</button>
                    </form>
                <?php elseif($user instanceof Entreprise && $user->getIdEntreprise()==$convention->getIdEntreprise() && !$convention->getVerificationAdmin() && !$convention->getVerificationSecretaire() && !$suivi->getModifiable()):?>
                    <button class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300">
                        <a href="<?= Action::ENTREPRISE_VALIDERCONV->value."&idConv=".$convention->getIdConvention()?>">Valider définitivement la convention</a>
                    </button>
                    <form method="post" action="<?= Action::ENTREPRISE_INVALIDERCONV->value."&idConv=".$convention->getIdConvention() ?>">
                        <input name="raisonRefus" type="text" class="p-2 rounded-md bg-slate-100 m-1" placeholder="Raison du refus">
                        <button type="submit" class="rounded-lg px-4 py-2 bg-red-600 text-red-100 hover:bg-red-700 duration-300">Refuser</button>
                    </form>
                <?php endif?>

            </div>

        </div>
    </div>


</main>