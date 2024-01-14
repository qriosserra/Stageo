<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;

/**
 * @var ArrayObject|null $etudiants
 * @var int[] $nbcandidature
 * @var Etudiant $etu
 * @var int $nbentrepriseavalider
 * @var ArrayObject|null $entrepriseavalider
 * @var Entreprise $ent
 * @var int $nboffreavalider
 * @var ArrayObject|null $offreavalider
 * @var Entreprise $offre
 * @var int $entrepriseencreations
 * @var int $entrepriscree
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard </title>
    <style>
        @media (max-width: 1544px) {
            #container-card-valide {
                flex-direction: column;
            }

            #card-valide {
                width: 100%;
            }

            #container-main {
                width: 100%;
            }

            #container-deux-ligne {
                justify-content: center;
                align-items: center;
                width: 100%;
            }

            #tableau {
                width: 100%;
            }

            #container-deux-ligne-tab {
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
        }

        @media (max-width: 769px) {

            #container-deux-ligne {
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

           

        }

        @media (max-width : 600px) {
            #barre1, #barre2 {
                display: none;
            }
        }

        
    </style>
</head>

<body :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

    <div id="sidebarButton" class="justify-center bg-gray-800 pt-3 pb-3">
        <div class=" bg-white  rounded-2xl flex pt-2 pb-2 pl-2">
            <a class="text-xl cursor-pointer  mr-2" id="sidebarButton" onclick="openSidebaractiver()">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-[0.10rem]" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </a>
            <a href="<?= Action::HOME->value ?>" class="flex items-center">
                <img src="assets/img/logo.png" alt="logo" class="h-[1.8rem] w-[7rem] mr-3">
            </a>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
        <div class="sidebar flex flex-col h-screen overflow-hidden">
        <div class="h-[2.5rem] bg-gray-800 w-[120rem] absolute left-[16rem] z-10" id="barre1">
            
        </div>
        <div class="h-[4.5rem] bg-white w-[120rem] absolute left-[16rem] top-10 z-10" id="barre2">

        </div>
            <nav class=" h-full">
                <!-- Sidebar Start -->
                <div id="width-contrainte" class="flex flex-col w-64  bg-gray-800 md:flex h-full">
                    <div class="flex flex-col items-center mt-10 mb-10 bg-white pt-3 pb-3 border">
                        <div class=" bg-white flex p-2 ">
                            <a class=" text-xl cursor-pointer mr-4" id="sidebarButtonnav" onclick="openSidebaractiver()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                </svg>
                            </a>
                            <a href="<?= Action::HOME->value ?>" class="flex items-center">
                                <img src="assets/img/logo.png" alt="logo" class="h-[1.8rem] w-[7rem] mr-3">
                            </a>
                        </div>
                    </div>
                    <div id="nav-bouton" class="flex flex-grow">
                        <nav class="mt-10">
                            <a href="<?= Action::ADMIN_DASH->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                                <span>Tableau de bord</span>
                            </a>
                            <a href="<?= Action::ADMIN_GESTION_ETUDIANT->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                                <span>Gestion etudiants</span>
                            </a>
                            <a href="<?= Action::ADMIN_LISTEENTREPRISE->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                                <span>Entreprises à valider</span>
                            </a>
                            <a href="<?= Action::ADMIN_LISTEOFFRES->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                                <span>Offres à valider</span>
                            </a>
                            <a href="<?= Action::ADMIN_SIGN_UP_FORM->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                                <span>Ajouter des Admin</span>
                            </a>
                            <a href="<?= Action::ADMIN_SUPRIMERADMIN_FROM->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                                <span>Supprimer des Admin</span>
                            </a>
                            <a href="<?= Action::ADMIN_ENTREPRISEARCHIVE->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                                <span>Entreprises archivées</span>
                            </a>
                            <a href="<?= Action::ADMIN_OFFRESARCHIVE->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                                <span>Offres archivées</span>
                            </a>
                        </nav>
                    </div>
                </div>
            </nav>
        </div>


        <div id="contenue" class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden  mt-[7rem]">

            <div class="flex min-h-screen">



                <!-- Main Content - Right side test-->
                <div class="flex flex-col " id="container-main">

                    <!-- Entreprises à Valider Section -->
                    <div class="flex justify-between mb-6" id="container-card-valide">

                        <main id="card-valide" class="grid justify-center items-center p-4 w-1/2 mx-2">
                            <a href="<?= Action::ADMIN_LISTEENTREPRISE->value ?>">
                                <div id="drop-area" class="bg-black group inline-block p-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">
                                    <div class=" flex flex-row">
                                        <!-- Réduction de la hauteur du figure -->
                                        <figure class=" justify-center items-center h-72 aspect-square  ">
                                            <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto" src="./assets/img/check.png" />
                                            <div class="px-4 pt-2 pb-4 text-center">
                                                <h3 class="text-xl font-bold text-black">Entreprise(s) à valider</h3>
                                                <a class="text-blue-400 hover:text-red-400" href="<?= Action::ADMIN_LISTEENTREPRISE->value ?>">Acceder à la page de validation
                                                </a>
                                                <p id="upload-message"></p>
                                            </div>
                                        </figure>
                                        <!-- Suppression du padding en haut pour la div du texte -->
                                        <div class="hidden md:block">
                                            <h3 class="text-xl font-bold text-black mb-4 p-4"><?= $nbentrepriseavalider ?> entreprises à vérifier</h3>
                                            <ul class="ml-2">
                                                <?php $limit = 3;
                                                $count = 0;
                                                foreach ($entrepriseavalider as $ent) :
                                                    $count += 1;
                                                    if ($count > $limit) break;
                                                    if ($count != 1) : ?><p class="text-black border-b m-1"></p><?php endif; ?>
                                                    <li>
                                                        <p class="text-black"><?= $ent["raison_sociale"] ?> :
                                                            <?= $ent["numero_voie"] ?>, <?= $ent["commune"] ?> <?= $ent["code_postal"] ?> (<?= $ent["pays"] ?>)</p>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>


                                </div>
                            </a>

                        </main>

                        <main id="card-valide" class="grid justify-center items-center p-4 w-1/2 mx-2">
                            <div id="drop-area" class="bg-black group inline-block p-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">
                                <div class=" flex flex-row">
                                    <!-- Réduction de la hauteur du figure -->
                                    <figure class=" justify-center items-center h-72 aspect-square  ">
                                        <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto" src="./assets/img/offre.png" />
                                        <div class="px-4 pt-2 pb-4 text-center">
                                            <h3 class="text-xl font-bold text-black">Offre(s) à valider</h3>
                                            <a href="<?= Action::ADMIN_LISTEOFFRES->value ?>" class="text-blue-400 hover:text-red-400 ">Acceder à la page de validation
                                            </a>
                                            <p id="upload-message"></p>
                                        </div>
                                    </figure>
                                    <div class="hidden md:block">
                                        <h3 class="text-xl font-bold text-black mb-4 p-4"><?= $nboffreavalider ?> Offres à valider</h3>
                                        <ul class="ml-2">
                                            <?php $limit = 3;
                                            $count = 0;
                                            foreach ($offreavalider as $offre) :
                                                $count += 1;
                                                if ($count > $limit) break;
                                                if ($count != 1) : ?><p class="text-black border-b m-1"></p><?php endif; ?>
                                                <li>
                                                    <p class="text-black"><?= $offre["raison_sociale"] ?> :
                                                        <?= substr($offre["description"], 0, 70) . "..."; ?></p>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>


                            </div>

                        </main>

                    </div>
                    <div id="container-deux-ligne-tab" class=" flex flex-row   ">
                        <div id="container-deux-ligne" class=" ml-3 flex row  w-2/5">
                            <main class="grid justify-center items-center  p-4 ">
                                <div id="drop-area" class="bg-black group inline-block pb-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">

                                    <!-- Réduction de la hauteur du figure -->
                                    <figure class="mb-[-1.5rem] justify-center items-center h-56 aspect-square overflow-hidden ">
                                        <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto" src="./assets/img/csv.png" />
                                    </figure>
                                    <!-- Suppression du padding en haut pour la div du texte -->
                                    <div class="px-4 pt-2 pb-4 text-center">
                                        <h3 class="text-xl font-bold text-black">Suivi</h3>
                                        <p class="text-black">Importer ou exporter les suivis en csv</p>
                                        <p id="upload-message"></p>
                                    </div>
                                    <div class="flex gap-4">
                                        <a class="text-blue-400 hover:text-red-400" href="<?= Action::IMPORT_CSV_FORM->value ?>">Importer</a>
                                        <a class="text-blue-400 hover:text-red-400" href="<?= Action::EXPORT_CSV->value ?>">Exporter</a>
                                    </div>
                                </div>
                            </main>
                            <main class="grid justify-center items-center  p-4 ">
                                <div id="drop-area" class="bg-black group inline-block pb-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">

                                    <!-- Réduction de la hauteur du figure -->
                                    <figure class="mb-[-1.5rem] justify-center items-center h-56 aspect-square overflow-hidden ">
                                        <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto" src="./assets/img/stats.png" />
                                    </figure>
                                    <!-- Suppression du padding en haut pour la div du texte -->
                                    <div class="px-4 pt-2 pb-4 text-center">
                                        <h3 class="text-xl font-bold text-black">Quelques stats:</h3>
                                        <p class="text-black">Stats interaissantes</p>
                                        <p id="upload-message"></p>
                                    </div>
                                    <footer class="flex justify-between items-center w-full px-4 bg-transparent">
                                        <!-- Bouton pour l'importation à gauche -->
                                        <div class="flex  text-black text-center">
                                            <p class="fa-solid fa-upload"><strong><?= $entrepriseencreations ?></strong> Entreprise(s) qui n'ont pas encore validée(s) leur email</p>
                                        </div>
                                        <!-- Bouton pour l'exportation à droite -->
                                        <div class="flex  text-black text-center">
                                            <p class="fa-solid fa-upload"><strong><?= $entrepriscree ?></strong> Entreprise(s) inscrite(s) sur le site</p>
                                        </div>
                                    </footer>
                                </div>
                            </main>

                        </div>
                        <div id="tableau" class="w-3/5 bg-white mr-6 rounded-xl shadow-lg overflow-hidden">
                            <div class="p-5">
                                <h2 class="text-lg font-semibold text-gray-700 mb-3">Liste des élèves inscrit sur STAGEO</h2>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">

                                        <!-- Génération aléatoire d'élèves -->
                                        <?php if ($etudiants != null) : ?>
                                            <thead class="bg-gray-200 text-black">
                                                <tr>
                                                    <th class="w-1/4 px-4 py-2">Nom</th>
                                                    <th class="w-1/4 px-4 py-2">Prénom</th>
                                                    <th class="w-1/4 px-4 py-2">Adresse Mail</th>
                                                    <th class="w-1/8 px-4 py-2">Année</th>
                                                    <th class="w-1/8 px-4 py-2">nb candidature</th>
                                                </tr>
                                            </thead>
                                            <?php foreach ($etudiants as $etu) : ?>
                                                <tbody class="text-gray-700">
                                                    <tr>
                                                        <td class="border px-4 py-2"><?= $etu->getNom() ?></td>
                                                        <td class="border px-4 py-2"><?= $etu->getPrenom() ?></td>
                                                        <td class="border px-4 py-2"><?= $etu->getEmail() ?></td>
                                                        <td class="border px-4 py-2"><?= $etu->getAnnee() ?></td>
                                                        <td class="border px-4 py-2"><?= $nbcandidature[$etu->getLogin()] ?></td>
                                                    </tr>
                                                </tbody>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>Aucun Étudiant encore inscrit !</tr>
                                        <?php endif ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function openSidebaractiver() {
        var bout = document.querySelector(".sidebar");
        var button = document.getElementById('sidebarButton');
        var cont = document.getElementById("contenue");
        var widthcontrainte = document.getElementById("width-contrainte");
        var navbouton = document.getElementById("nav-bouton")
        if (!bout.classList.contains("hidden")) {
            button.style.display = 'flex';
            bout.classList.add("hidden");
            bout.classList.remove("w-full");
            widthcontrainte.classList.add("w-64");
            navbouton.classList.remove("items-center");
            if (cont.classList.contains("hidden")) {
                cont.classList.remove("hidden");
            }
        } else {
            button.style.display = 'none';
            bout.classList.remove("hidden");
            bout.classList.add("w-full");
            widthcontrainte.classList.remove("w-64");
            navbouton.classList.add("items-center");
            if (!cont.classList.contains("hidden")) {
                cont.classList.add("hidden");
            }
        }
    }

    function openSidebar() {
        var bout = document.querySelector(".sidebar");
        var button = document.getElementById('sidebarButton');
        var widthcontrainte = document.getElementById("width-contrainte");
        var cont = document.getElementById("contenue");
        if (!bout.classList.contains("hidden")) {
            button.style.display = 'flex';
            bout.classList.add("hidden");
            if (cont.classList.contains("hidden")) {
                cont.classList.remove("hidden");
            }
        } else {
            button.style.display = 'none';
            bout.classList.remove("hidden");
            if (cont.classList.contains("hidden")) {
                cont.classList.remove("hidden");
            }
            bout.classList.remove("w-full");
            widthcontrainte.classList.add("w-64");
        }
    }

    function updateButtonVisibility() {
        var button = document.getElementById('sidebarButton');
        var nav = document.getElementById('sidebarButtonnav');
        var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

        // Définissez la largeur à laquelle le bouton doit être visible
        var breakpointWidth = 600;
        if (screenWidth <= breakpointWidth) {
            if (!document.querySelector(".sidebar").classList.contains("hidden")) {
                openSidebar();
            }
            button.style.display = 'flex';
            nav.style.display = 'block';
        } else {
            if (document.querySelector(".sidebar").classList.contains("hidden")) {
                openSidebar();
            }
            button.style.display = 'none';
            nav.style.display = 'none';
        }
    }

    // Attachez l'événement de redimensionnement à la fonction
    window.addEventListener('resize', updateButtonVisibility);

    // Appelez la fonction une fois pour définir l'état initial
    updateButtonVisibility();
</script>

</html>