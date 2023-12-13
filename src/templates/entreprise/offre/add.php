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

        <div date-rangepicker class="flex items-center col-span-2">
            <div class="relative flex items-center">
                <input name="start" type="text" value="<?=$offre->getDateDebut()?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date début">
            </div>
            <span class="mx-4 text-gray-500" id="dateFin">à</span>
            <div class="relative flex items-center" id="dateFinContainer">
                <input name="end" type="text" value="<?=$offre->getDateFin()?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date fin">
            </div>
        </div>

        <div>
            <input type="checkbox" id="but2" name="checkbox[]" value="BUT2" class="mr-1" <?php if ($offre->getNiveau()!=null && str_contains($offre->getNiveau(), 'BUT2')) echo 'checked'; ?>>
            <label for="but2" class="mr-5">BUT2</label>


            <input type="checkbox" id="but3" name="checkbox[]" value="BUT3" class="mr-1" <?php if ($offre->getNiveau()!=null && str_contains($offre->getNiveau(), 'BUT3')) echo 'checked'; ?>>
            <label for="but3" class="mr-5">BUT3</label>
        </div>

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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("[name='start']", {
                enableTime: false,
                dateFormat: "Y-m-d",
            });

            flatpickr("[name='end']", {
                enableTime: false,
                dateFormat: "Y-m-d",
            });
            const startInput = document.querySelector("[name='start']");
            const endInput = document.querySelector("[name='end']");
            const dateFinContainer = document.getElementById('dateFinContainer');
            const dateFin = document.getElementById('dateFin');
            const emploiRadios = document.querySelectorAll("[name='emploi']");
            const niveauCheckboxes = document.querySelectorAll("[name='checkbox[]']");

            function calculateEndDate(startDate, durationWeeks) {
                const startDateObj = new Date(startDate);
                const endDateObj = new Date(startDateObj.getTime() + durationWeeks * 7 * 24 * 60 * 60 * 1000);
                return endDateObj.toISOString().split('T')[0];
            }

            startInput.addEventListener('change', function () {
                const selectedEmploi = document.querySelector("[name='emploi']:checked");
                const durationWeeks = (selectedEmploi && selectedEmploi.value === 'alternance') ? null : 1;
                if(durationWeeks) {
                    const selectedNiveau = document.querySelectorAll("[name='checkbox[]']:checked");

                    const hasBUT2 = Array.from(selectedNiveau).some(checkbox => checkbox.value === 'BUT2');
                    const hasBUT3 = Array.from(selectedNiveau).some(checkbox => checkbox.value === 'BUT3');

                    const dw = (hasBUT3 || (hasBUT2 && hasBUT3)) ? 16 : 10;
                    // Calcul de la date de fin
                    endInput.value = calculateEndDate(this.value, dw);
                }
            });

            // Au chargement de la page, déclencher l'événement change si la date de début a une valeur initiale
            if (startInput.value) {
                startInput.dispatchEvent(new Event('change'));
            }

            niveauCheckboxes.forEach(function (niveau) {
                niveau.addEventListener('change', function () {
                    const selectedEmploi = document.querySelector("[name='emploi']:checked");

                    if (selectedEmploi && (selectedEmploi.value === 'alternance' || selectedEmploi.value === 'Stage&Alternance')) {
                        endInput.value = null;
                    } else {
                        const selectedNiveau = document.querySelectorAll("[name='checkbox[]']:checked");

                        const hasBUT2 = Array.from(selectedNiveau).some(checkbox => checkbox.value === 'BUT2');
                        const hasBUT3 = Array.from(selectedNiveau).some(checkbox => checkbox.value === 'BUT3');

                        const durationWeeks = (hasBUT3 || (hasBUT2 && hasBUT3)) ? 16 : 10;

                        endInput.value = calculateEndDate(startInput.value, durationWeeks)
                    }
                });
            });

            emploiRadios.forEach(function (radio) {
                radio.addEventListener('change', function () {
                    const selectedEmploi = document.querySelector("[name='emploi']:checked");

                    // Si Alternance est sélectionné, masquer la date de fin, sinon l'afficher
                    dateFinContainer.style.display = (selectedEmploi && (selectedEmploi.value === 'alternance' || selectedEmploi.value==='Stage&Alternance')) ? 'none' : 'block';
                    dateFin.style.display = (selectedEmploi && (selectedEmploi.value === 'alternance' || selectedEmploi.value==='Stage&Alternance')) ? 'none' : 'block';

                    if (selectedEmploi && (selectedEmploi.value === 'alternance' || selectedEmploi.value === 'Stage&Alternance')) {
                        endInput.value = null;
                    } else {
                        const selectedNiveau = document.querySelectorAll("[name='checkbox[]']:checked");

                        const hasBUT2 = Array.from(selectedNiveau).some(checkbox => checkbox.value === 'BUT2');
                        const hasBUT3 = Array.from(selectedNiveau).some(checkbox => checkbox.value === 'BUT3');

                        const durationWeeks = (hasBUT3 || (hasBUT2 && hasBUT3)) ? 16 : 10;

                        endInput.value = calculateEndDate(startInput.value, durationWeeks)
                    }
                });
            });

            // Au chargement de la page, vérifier l'état initial
            const emploiSelectionne = document.querySelector("[name='emploi']:checked");
            const selectedNiveau = document.querySelectorAll("[name='checkbox[]']:checked");
            dateFinContainer.style.display = (emploiSelectionne && emploiSelectionne.value === 'alternance') ? 'none' : 'block';
            dateFin.style.display = (emploiSelectionne && emploiSelectionne.value === 'alternance') ? 'none' : 'block';
        });
    </script>

</main>
