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
 * @var array $liste_tag
 * @var array $liste_tag_choisi
 */
?>
<style>
.formle {
    display: flex;
    flex-direction: column  ;
}
.tag_container{
    max-width: 60vw;
}
</style>
<main class="h-screen flex flex-col items-center justify-center">
    <?= button("Accueil", "fi-rr-home", Action::HOME, "!absolute !pl-2 top-8 left-8") ?>
    <h5 class="font-bold py-6"><?= $offre->getIdOffre() !== null ? 'Modifier' : 'Ajouter' ?> une offre</h5>

    <form class="w-[60vw] h-[80vh] grid grid-cols-2 gap-8 formle" action="<?= $offre->getIdOffre() !== null ? Action::ENTREPRISE_MODIFICATION_OFFRE->value . '&id=' . $offre->getIdOffre() : Action::ENTREPRISE_CREATION_OFFRE->value ?>" method="post">

        <?php if ($offre->getIdOffre() !== null) : ?>
            <input type="hidden" name="idOffre" value="<?= $offre->getIdOffre() ?>">
        <?php endif; ?>
        <?= field("secteur", "Secteur de l'offre", "text", "", Pattern::NAME, true, $offre->getSecteur() ?? '', null) ?>
        <?= field("thematique", "Thématique de l'offre", "text", null, Pattern::NAME, true, $offre->getThematique(), null) ?>

        <?= textarea("description", "Description", "", 4, false, $offre->getDescription(), "col-span-2") ?>

        <div class="col-span-2 sm:col-span-1">
            <?= textarea("taches", "Fonctions et tâches", "", 4, false, $offre->getTaches()) ?>
        </div>

        <div class="col-span-2 sm:col-span-1">
            <?= textarea("commentaires", "Commentaires sur l'offre", "", 4, false, $offre->getCommentaires()) ?>
        </div>

        <?php if (!isset($gratification)) {
            $gratification = null;
        } ?>

        <?= field("gratification", "Gratification par heure", "float", "", null, true, $offre->getGratification()) ?>
        <?= dropdown("id_unite_gratification", "Unité de gratification", null, null, 2, $unite_gratifications) ?>

        <div date-rangepicker class="flex flex-col sm:flex-row items-center col-span-2">
            <div class="relative flex items-center">
                <input name="start" type="text" value="<?= $offre->getDateDebut() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date début">
            </div>
            <p class="mx-4 text-gray-500" id="dateFin">à</p>
            <div class="relative flex items-center" id="dateFinContainer">
                <input name="end" type="text" value="<?= $offre->getDateFin() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date fin">
            </div>
        </div>

        <div>
            <input type="checkbox" id="but2" name="checkbox[]" value="BUT2" class="mr-1" <?php if ($offre->getNiveau() != null && str_contains($offre->getNiveau(), 'BUT2')) echo 'checked'; ?>>
            <label for="but2" class="mr-5">BUT2</label>


            <input type="checkbox" id="but3" name="checkbox[]" value="BUT3" class="mr-1" <?php if ($offre->getNiveau() != null && str_contains($offre->getNiveau(), 'BUT3')) echo 'checked'; ?>>
            <label for="but3" class="mr-5">BUT3</label>
        </div>

        <div class="flex items-center col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                <div>
                    <input id="Alternance" type="radio" value="Alternance" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php if ($offre->getType() === 'Alternance') echo 'checked'; ?>>
                    <label for="Alternance" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Alternance</label>
                </div>

                <div>
                    <input id="Stage" type="radio" value="Stage" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php if ($offre->getType() === 'Stage') echo 'checked'; ?>>
                    <label for="Stage" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stage</label>
                </div>

                <div>
                    <input id="Stage&Alternance" type="radio" value="Stage&Alternance" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php if ($offre->getType() === 'Stage&Alternance') echo 'checked'; ?>>
                    <label for="Stage&Alternance" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stage&Alternance</label>
                </div>
            </div>
        </div>

        <div class="max-w-md grid grid-cols-1 md:grid-cols-2">

            <!-- Dropdown + bouton "Add" pour les tags -->
            <div class="relative flex flex-col col-span-1 items-center mb-4 justify-self-start w-[13rem]">
                <?= dropdown("tag", "Tag", null, null, 2, $liste_tag) ?>
                <button type="button" id="addTagButton" class="mt-5 h-10 px-4 py-2 text-sm font-medium leading-5 text-center text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-800">
                    Add
                </button>
            </div>

            <!-- Les tags seront ajoutés ici à droite -->
            <div class="tag_container mt-4 col-span-1 w-[25rem]">
                <div id="tagContainer" class="flex flex-wrap">
                    <!-- Contenu des tags -->
                </div>
            </div>

        </div>

        <!-- Nouvelle div pour le bouton "Submit" -->
        <div class="col-span-2  flex justify-center " >
            <?= submit($offre->getIdOffre() !== null ? "Modifier" : "Publier", "mb-10") ?>
            
        </div>

        <?= token($token) ?>
    </form>
    <script>
        const tagListChoisi = <?php echo json_encode($liste_tag_choisi); ?>;
        document.addEventListener('DOMContentLoaded', function() {
            const tagList = <?php echo json_encode($liste_tag); ?>; //Merci GPT

            const addTagButton = document.getElementById('addTagButton');
            addTagButton.addEventListener('click', function() {
                addTag(null);
            });

            tagListChoisi.forEach(tag => {
                console.log(tag);
                addTag(tag);
            });

            function removeTag(tagToRemove) {
                const tagContainer = document.getElementById('tagContainer');
                const tags = tagContainer.querySelectorAll('.tag-element');

                tags.forEach(tag => {
                    if (tag.textContent.trim() === tagToRemove) {
                        tag.remove();
                    }
                });
            }

            function addTag(selectedTag) {
                const tagDropdown = document.querySelector('[name="tag"]');
                if (selectedTag === null) {
                    selectedTag = tagDropdown.options[tagDropdown.selectedIndex].text.trim();
                }

                if (selectedTag !== '' && tagList.includes(selectedTag)) {
                    const tagContainer = document.getElementById('tagContainer');

                    const existingTags = tagContainer.querySelectorAll('.tag-element');
                    const tagExists = Array.from(existingTags).some(tag => tag.textContent.trim() === selectedTag);

                    if (!tagExists) {
                        const tagElement = document.createElement('input');
                        tagElement.value = selectedTag;
                        tagElement.name = 'selectedTags[]';
                        tagElement.className = 'hidden';
                        tagElement.setAttribute('readonly', true);
                        const tagLabel = document.createElement('label');
                        tagLabel.textContent = selectedTag;
                        tagLabel.appendChild(tagElement);
                        tagLabel.className = 'bg-indigo-200 text-indigo-800 px-2 py-1 m-1 rounded-full tag-element';

                        // Ajouter le gestionnaire d'événements click pour la suppression du tag
                        tagLabel.addEventListener('click', function() {
                            removeTag(selectedTag);
                        });

                        tagContainer.appendChild(tagLabel);
                        tagDropdown.value = '';
                    } else {
                        tagDropdown.value = '';
                    }
                }
            }

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

            startInput.addEventListener('change', function() {
                const selectedEmploi = document.querySelector("[name='emploi']:checked");
                const durationWeeks = (selectedEmploi && selectedEmploi.value === 'Alternance') ? null : 1;
                if (durationWeeks) {
                    const selectedNiveau = document.querySelectorAll("[name='checkbox[]']:checked");

                    const hasBUT2 = Array.from(selectedNiveau).some(checkbox => checkbox.value === 'BUT2');
                    const hasBUT3 = Array.from(selectedNiveau).some(checkbox => checkbox.value === 'BUT3');

                    const dw = (hasBUT3 || (hasBUT2 && hasBUT3)) ? 16 : 10;
                    // Calcul de la date de fin
                    endInput.value = calculateEndDate(this.value, dw);
                }
            });
            niveauCheckboxes.forEach(function(niveau) {
                niveau.addEventListener('change', function() {
                    const selectedEmploi = document.querySelector("[name='emploi']:checked");

                    if (selectedEmploi && (selectedEmploi.value === 'Alternance' || selectedEmploi.value === 'Stage&Alternance')) {
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

            emploiRadios.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    const selectedEmploi = document.querySelector("[name='emploi']:checked");

                    // Si Alternance est sélectionné, masquer la date de fin, sinon l'afficher
                    dateFinContainer.style.display = (selectedEmploi && (selectedEmploi.value === 'Alternance' || selectedEmploi.value === 'Stage&Alternance')) ? 'none' : 'block';
                    dateFin.style.display = (selectedEmploi && (selectedEmploi.value === 'Alternance' || selectedEmploi.value === 'Stage&Alternance')) ? 'none' : 'block';

                    if (selectedEmploi && (selectedEmploi.value === 'Alternance' || selectedEmploi.value === 'Stage&Alternance')) {
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
            dateFinContainer.style.display = (emploiSelectionne && (emploiSelectionne.value === 'Alternance' || emploiSelectionne.value === 'Stage&Alternance')) ? 'none' : 'block';
            dateFin.style.display = (emploiSelectionne && (emploiSelectionne.value === 'Alternance' || emploiSelectionne.value === 'Stage&Alternance')) ? 'none' : 'block';
        });
    </script>

</main>