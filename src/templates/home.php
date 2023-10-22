<?php

use Stageo\Model\Object\Categorie;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use \Stageo\Model\Object\Offre;

include "macros/button.php";
include "macros/input.php";
include "macros/offre.php";
/**
 * @var Categorie[] $categories
 * @var Etudiant $etudiant
 * @var Offre[] $offres
 */
?>
    <main class="w-[64rem]">
        <section class="bg-gray-100 py-8  flex justify-center items-center ">
            <h5 class="align-middle">Bienvenue sur Stageo</h5>
        </section>
        <section class="bg-gray-100 py-8">
            <div class="bg-gray-200 p-4">
                <div class="max-w-screen-xl mx-auto">
                    <div class="relative">
                        <img id="carouselImage" src="assets/img/DuréeB.jpg" alt="Image 1" class="w-full h-100 object-cover rounded-lg shadow-md">
                        <div class="absolute top-500 left-0 right-500 bottom-0 flex items-center justify-center">
                            <button id="prevButton" class="bg-blue-500 text-white px-4 py-2 rounded-l-lg button-ghost">Précédent</button>
                            <button id="nextButton" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg button-ghost">Suivant</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php if (UserConnection::isInstance($etudiant)): ?>
            <section>
                <h5 class="flex justify-center items-center text-[2.5em] tracking-tighter">
                    Liste des recherches récentes ou favorites
                </h5>
                <div class="flex flex-wrap  overflow-hidden overflow-x-auto whitespace-no-wrap bg-gray-100 py-8">
                <?php foreach ($categories as $categorie):?>
                    <?=button($categorie->getLibelle(), "",""," !p-8 bg-white")?>
                <?php endforeach ?>
                </div>
            </section>
            <section>
                <h5 class="flex justify-center items-center text-[2.5em] tracking-tighter">
                    Liste des categories récemment recherchées
                </h5>
                <div class="flex flex-wrap gap-4  overflow-hidden overflow-x-auto whitespace-no-wrap bg-gray-100">
                    <?php $max = (count($offres)<=5) ? count($offres)-1 : 5; ?>
                    <?php for ($i = 0; $i <= $max; $i++):?>
                        <?=\offre($offres[$i]->getDescription() , $offres[$i]->getIdOffre(),$offres[$i]->getIdEntreprise(),$offres[$i]->getIdOffre(),"assets/img/DuréeB.jpg" )?>
                    <?php endfor ?>
                </div>
            </section>
        <?php endif ?>
        <script>
            const images = [
                "assets/img/DuréeB.jpg",
                "assets/img/RémunérationB.jpg",
                "assets/img/FAQB.jpg"
            ]; // Liste des images
            let currentIndex = 0; // Index de l'image actuelle

            const carouselImage = document.getElementById("carouselImage");
            const prevButton = document.getElementById("prevButton");
            const nextButton = document.getElementById("nextButton");

            // Fonction pour afficher l'image suivante
            function showNextImage() {
                currentIndex = (currentIndex + 1) % images.length;
                carouselImage.src = images[currentIndex];
            }

            // Fonction pour afficher l'image précédente
            function showPrevImage() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                carouselImage.src = images[currentIndex];
            }

            // Gestion des boutons
            prevButton.addEventListener("click", showPrevImage);
            nextButton.addEventListener("click", showNextImage);
        </script>
    </main>