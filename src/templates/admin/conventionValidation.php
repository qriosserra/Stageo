<?php

/**
 * @var \Stageo\Model\Object\Convention $convention
 * @var \Stageo\Model\Object\Entreprise $entreprise
 * @var \Stageo\Model\Object\Suivi $suivi
 * @var \Stageo\Model\Object\Etudiant $etudiant
 * @var string $unite_gratification
 * @var string $title
 */

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
    <div class="w-[40rem] space-y-6 rounded-lg p-6 shadow-lg bg-white">
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
        <div class=" ">
            <label>Dates</label>
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
                <button class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300">Valider</button>

            </div>
                <button class="rounded-lg px-4 py-2 bg-red-600 text-red-100 hover:bg-red-700 duration-300">Refuser</button>
                <input type="text" class="p-2 rounded-md bg-slate-100 m-1" placeholder="Raison du refus">

        </div>
    </div>


</main>