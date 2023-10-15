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
        <h5 class="align-middle">Recherche</h5>
    </section>
    <section>

        <div class="mb-3">
            <div class="relative mb-4 flex flex-row w-full flex-wrap items-stretch">
                <input
                        type="search"
                        class=" relative bg-white m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l-lg border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary "
                        id="searchInput"
                        placeholder="Search"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                <a id="searchButton" href="" class="bg-blue-500 rounded-none !rounded-l-none !rounded-r-lg flex justify-center items-center">
                    <span>rechercher</span>
                </a>
            </div>
        </div>
    </section>
    <br>
    <section  class="flex flex-wrap gap-4 space-y-10 overflow-hidden overflow-x-auto whitespace-no-wrap bg-gray-100">
        <?php foreach ($offres as $offre):?>
            <?=\offre($offre->getDescription() , $offre->getIdOffre(),$offre->getIdEntreprise(),"assets/img/FAQB.jpg","assets/img/DuréeB.jpg", "itemContainer")?>
        <?php endforeach ?>
    </section>

    <script>
        const searchInput = document.getElementById("searchInput");
        const searchButton = document.getElementById("searchButton");
        const itemContainer = document.getElementById("itemContainer");

        // Fonction pour filtrer les éléments par titre
        function filterItems() {
            const searchTerm = searchInput.value.toLowerCase();
            const items = itemContainer.querySelectorAll(".title");

            for (let i = 0; i < items.length; i++) {
                const title = items[i].textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    items[i].parentNode.style.display = "block";
                } else {
                    items[i].parentNode.style.display = "none";
                }
            }
        }

        // Gestion du clic sur le lien de recherche
        searchButton.addEventListener("click", function (event) {
            event.preventDefault(); // Empêche le lien de suivre
            filterItems();
        });
    </script>
</main>
