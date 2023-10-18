<?php

use Stageo\Lib\enums\Action;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/token.php";
/**
 * @var string $token
 */
?>

<main class="h-screen items-center justify-center gap-2 relative"">
    <h4 class="text-3xl font-bold py-6">Ajouter une offre</h4>
    <form class="border border-gray-300 p-4 rounded-lg" action="<?= Action::ENTREPRISE_CREATION_OFFRE->value ?>" method="post">
        <div class="flex gap-10">
            <div class="w-full relative border-2 border-gray-300 border-dashed rounded-lg p-4" id="dropzone">
                <div id="all">
                    <input type="file" class="absolute inset-0 w-full h-full opacity-0 z-50" id="file-upload" name="file-upload" accept="image/*" />
                    <div class="text-center">
                        <img class="mx-auto h-8 w-8" src="https://www.svgrepo.com/show/357902/image-upload.svg" alt="" id="upload-icon">
                        <p class="mt-1 text-xs text-gray-500" id="text-info">
                            PNG, JPG, GIF up to 10MB
                        </p>
                    </div>
                        <button id="select-file" class="mt-2">Sélectionner un fichier</button>
                </div>
                    <img src="" class="mt-4 mx-auto max-h-40 hidden" id="preview">
            </div>
            <div class="ml-4">
                <div class="mb-6">
                    <?=input("secteur", "secteur", "text", "", "required", null, null)?>
                </div>
                <div class="mb-6">
                    <?=input("thematique", "thematique", "text", "", "required", null, null)?>
                </div>
                <div class="mb-6">
                    <?=input("tache", "tache", "text", "", "required", null, null)?>
                </div>
                <!-- Ajoutez d'autres éléments "mb-6" au besoin -->
            </div>
        </div>
        <div class="mb-6 mt-4 w-full">
            <label>Description</label>
            <textarea id="description" name="description" class="w-full resize-y px-3 py-2 border rounded-md" rows="4" placeholder="max(500 caractères)" required></textarea>
        </div>
        <div class="mb-6 mt-4 w-full">
            <label>Commentaire:</label>
            <textarea id="commentaire" name="commentaire" class="w-full resize-y px-3 py-2 border rounded-md" rows="4" placeholder="max(100 caractères)" required></textarea>
            <!--<?=input("commentaire", "commentaire", "text", "", "required", null, null)?>-->
        </div>
        <div class="flex gap-4">
            <div class="mb-6">
                <?=input("gratification", "gratification", "text", "", "required", null, null)?>
            </div>
            <div class="mb-6">
                <?=input("unite_gratification", "unite_gratification", "text", "", "required", null, null)?>
            </div>
        </div>
    <div class="flex">
        <div class="flex items-center pr-4">
            <input id="alternance" type="radio" value="alternance" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Alternance</label>
        </div>
        <div class="flex items-center">
            <input checked id="stage" type="radio" value="stage" name="emploi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stage</label>
        </div>
    </div>
    <button type="submit" class="mt-6">Envoyer</button>
        <?=token($token)?>
    </form>
    <script>
        var dropzone = document.getElementById('dropzone');
        var all = document.getElementById('all');
        var selectFileButton = document.getElementById('select-file');
        var input = document.getElementById('file-upload');

        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-600');
            var file = e.dataTransfer.files[0];
            all.style.display = 'none';
            displayPreview(file);
        });

        input.addEventListener('change', e => {
            var file = e.target.files[0];
            displayPreview(file);
        });

        selectFileButton.addEventListener('click', function() {
            input.click();
        });

        input.addEventListener('change', function () {
            if (input.files.length > 0) {
                all.style.display = 'none';
            }
        });

        function displayPreview(file) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                var preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.classList.remove('hidden');
            };
        }
    </script>
</main>