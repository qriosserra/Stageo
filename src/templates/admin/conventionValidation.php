<?php
/**
 * @var \Stageo\Model\Object\Convention $convention
 * @var \Stageo\Model\Object\Entreprise $entreprise
 * @var \Stageo\Model\Object\Suivi $suivi
 * @var \Stageo\Model\Object\Etudiant $etudiant
 * @var string $unite_gratification
 * @var string $title
 */

if ($convention->getTypeConvention() == 1){
    $type = "Stage";
}else{
    $type = "Alternance";
}
?>
<div class="h-40 flex justify-center items-center mt-[4rem]"
     style="background: linear-gradient(120deg, rgba(21, 129, 230, 0.75) 0%, rgba(0, 45, 141, 0.75) 50%, rgba(1, 7, 68, 0.75) 100%)">
    <h1 class="text-center font-medium text-white text-3xl text-shadow">
        <?= $title?>
    </h1>
</div>
<main class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full mt-12 max-w-2xl p-4 bg-white rounded-lg shadow-lg">
        <div class="relative">
            <div class="h-20 rounded-t-xl bg-blue-500 flex items-center justify-center">
                <div class="mb-1 h-5 text-xl font-bold text-black"><?= $etudiant->getNom()?> <?= $etudiant->getPrenom()?></div>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-center space-x-4">
                <div class="flex-1 border-b border-gray-300 py-2"><?= $entreprise->getRaisonSociale()?></div>
                <div class="flex-1 border-b border-gray-300 py-2"><?= $convention->getThematique() ?></div>
            </div>

            <div class="py-4 text-gray-700">
                <p class="text-lg font-bold">Description</p>
                <div class="border border-gray-300 bg-gray-200 p-2">
                    <textarea readonly class="w-full h-40 resize-none bg-transparent"><?= $convention->getDetails()?></textarea>
                </div>
            </div>

            <div class="py-4 text-gray-700">
                <p class="text-lg font-bold">Fonctions &amp; tâches</p>
                <div class="border border-gray-300 bg-gray-200 p-2">
                    <textarea readonly class="w-full h-40 resize-none bg-transparent"><?= $convention->getTaches()  ?></textarea>
                </div>
            </div>

            <?php if ($convention->getCommentaires()!=null):?>
            <div class="py-4 text-gray-700">
                <p class="text-lg font-bold">Commentaire</p>
                <div class="border border-gray-300 bg-gray-200 p-2">
                    <textarea readonly class="w-full h-40 resize-none bg-transparent"><?= $convention->getCommentaires() ?></textarea>
                </div>
            </div>
            <?php endif?>
            <div class="flex items-center space-x-4">
                <div class="text-xl text-gray-500">
                    <p>Type</p>
                    <div class="border border-gray-300 bg-gray-200 p-2"><?= $type ?></div>
                </div>
                <div class="text-xl text-gray-500">
                    <p>Gratification</p>
                    <div class="border border-gray-300 bg-gray-200 p-2">
                        <p><?= $convention->getGratification() ?>€ / <?= $unite_gratification ?>/heure</p>
                    </div>
                </div>
                <div class="text-xl text-gray-500">
                    <p>Date</p>
                    <div class="flex items-center space-x-2">
                        <div class="border border-gray-300 bg-gray-200 p-2"><?= $convention->getDateDebut() ?></div>
                        <?php if ($convention->getDateFin()): ?>
                            <div class="h-1 w-1 rounded-full bg-blue-200"></div>
                            <div class="border border-gray-300 bg-gray-200 p-2"><?= $convention->getDateFin() ?></div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


