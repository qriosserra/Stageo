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

            #container-main,
            #card-valide,
            #tableau {
                width: 100%;
            }

            #container-deux-ligne {
                justify-content: center;
                align-items: center;
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


        @media screen and (max-width: 1022px) {

            #navba-dash {
                position: absolute;
                z-index: 3;
            }
        }
    </style>
</head>

<body :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

<div class="w-full bg-slate-700 h-[85px] shadow-xl">

</div>

    <div class="flex h-screen overflow-hidden">
        <nav class="w-[300px]" id="navba-dash">
            <span class="absolute text-white text-4xl top-[-4rem] left-4 cursor-pointer" onclick="openSidebar()">
                <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
            </span>
            <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-slate-700">
                <div class="text-gray-100 text-xl ">
                    <a class="p-2.5 mt-1 flex items-center" href="<?= Action::HOME->value ?>">
                        <img src="assets/img/logo.png" class="w-3/4 ml-5">
                        <i class="bi bi-x cursor-pointer ml-28 lg:hidden" onclick="openSidebar()"></i>
                    </a>
                    <div class="my-2 bg-white h-[1px]"></div>
                </div>

                <a href="<?= Action::ADMIN_DASH->value ?>" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                    <i class="bi bi-house-door-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200 font-bold">Tableau de bord</span>
                </a>
                <a href="<?= Action::ADMIN_GESTION_ETUDIANT->value ?>" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backpack-fill" viewBox="0 0 16 16">
                        <path d="M5 13v-3h4v.5a.5.5 0 0 0 1 0V10h1v3z" />
                        <path d="M6 2v.341C3.67 3.165 2 5.388 2 8v5.5A2.5 2.5 0 0 0 4.5 16h7a2.5 2.5 0 0 0 2.5-2.5V8a6.002 6.002 0 0 0-4-5.659V2a2 2 0 1 0-4 0m2-1a1 1 0 0 1 1 1v.083a6.04 6.04 0 0 0-2 0V2a1 1 0 0 1 1-1m0 3a4 4 0 0 1 3.96 3.43.5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14A4 4 0 0 1 8 4M4.5 9h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5" />
                    </svg>
                    <span class="text-[15px] ml-4 text-gray-200 font-bold">Gestion des étudiants</span>
                </a>
                <div class="my-4 bg-white h-[1px]"></div>
                <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white" onclick="dropdown()">
                    <i class="bi bi-building"></i>
                    <div class="flex justify-between w-full items-center">
                        <span class="text-[15px] ml-4 text-gray-200 font-bold">Gestion des entreprises</span>
                        <span class="text-sm rotate-180" id="arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </div>
                </div>
                <div class="text-left  mt-2 w-4/5 mx-auto text-gray-200 font-medium" id="submenu">
                    <a href="<?= Action::ADMIN_LISTEENTREPRISE->value ?>">

                        <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                            <i class="bi bi-building-check"></i> Entreprise(s) à valider
                        </h1>
                    </a>
                    <a href="<?= Action::ADMIN_LISTEOFFRES->value ?>">
                        <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                            Offre(s) à valider
                        </h1>
                    </a>

                </div>
                <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span class="text-[15px] ml-4 text-gray-200 font-bold">Logout</span>
                </div>
            </div>
        </nav>


        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden ">

            <div class="flex min-h-screen">



                <!-- Main Content - Right side test-->
                <div class="flex flex-col " id="container-main">

                    <!-- Entreprises à Valider Section -->
                    <div class="flex justify-between mb-6" id="container-card-valide">

                        <main id="card-valide" class="grid justify-center items-center p-4 w-1/2 mx-2">
                            <a href="<?= Action::ADMIN_LISTEENTREPRISE->value ?>">
                                <div id="drop-area" class="bg-black group inline-block p-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">
                                    <div class=" flex flex-row">
                                        <figure class=" justify-center items-center h-72 aspect-square  ">
                                            <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto" src="./assets/img/check.png" />
                                            <div class="px-4 pt-2 pb-4 text-center">
                                                <h3 class="text-xl font-bold text-black">Entreprise(s) à valider</h3>
                                                <a class="text-blue-400 hover:text-red-400" href="<?= Action::ADMIN_LISTEENTREPRISE->value ?>">Acceder à la page de validation
                                                </a>
                                                <p id="upload-message"></p>
                                            </div>
                                        </figure>
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
                                    <form id="uploadForm" class="flex justify-between items-center w-full px-4 bg-transparent" action="<?= Action::IMPORT_CSV_FORM->value ?>" method="post" enctype="multipart/form-data">
                                        <!-- Bouton personnalisé pour l'importation à gauche -->
                                        <label class="text-blue-400 hover:text-red-400 cursor-pointer">
                                            <i class="fa-solid fa-upload"></i> Importer
                                            <input type="file" name="CHEMINCSV" id="CHEMINCSV" accept=".csv" class="hidden" onchange="submitForm()">
                                        </label>

                                        <!-- Bouton pour l'exportation à droite -->
                                        <button type="submit" class="text-blue-400 hover:text-red-400">
                                            <i class="fa-solid fa-download"></i> Exporter
                                        </button>
                                    </form>
                                </div>
                            </main>
                            <main class="grid justify-center items-center  p-4 ">
                                <div id="drop-area" class="bg-black group inline-block pb-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">
                                    <figure class="mb-[-1.5rem] justify-center items-center h-56 aspect-square overflow-hidden ">
                                        <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto" src="./assets/img/stats.png" />
                                    </figure>
                                    <div class="px-4 pt-2 pb-4 text-center">
                                        <h3 class="text-xl font-bold text-black">Quelques stats:</h3>
                                        <p class="text-black">Stats interaissantes</p>
                                        <p id="upload-message"></p>
                                    </div>
                                    <footer class="flex justify-between items-center w-full px-4 bg-transparent">
                                        <div class="flex  text-black text-center">
                                            <p class="fa-solid fa-upload"><strong><?= $entrepriseencreations ?></strong> Entreprise(s) qui n'ont pas encore validée(s) leur email</p>
                                        </div>
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
    var wasSidebarOpen = null;

    function dropdown() {
        var submenu = document.querySelector("#submenu");
        var arrow = document.querySelector("#arrow");
        submenu.style.visibility = submenu.style.visibility === 'hidden' ? 'visible' : 'hidden';
        arrow.classList.toggle("rotate-0");
    }
    dropdown();

    function openSidebar() {
        var sidebar = document.querySelector("#navba-dash .sidebar");
        if (sidebar.style.visibility === 'visible') {
            sidebar.style.visibility = 'hidden';
            wasSidebarOpen = false;
        } else {
            sidebar.style.visibility = 'visible';
            wasSidebarOpen = true;
        }
    }

    function closeSidebar() {
        var sidebar = document.querySelector("#navba-dash .sidebar");
        sidebar.style.visibility = 'hidden';
    }

    function adjustSidebar() {
        var isSmallScreen = window.innerWidth < 1022;
        if (isSmallScreen && wasSidebarOpen !== false) {
            closeSidebar();
            wasSidebarOpen = false;
        } else if (!isSmallScreen && wasSidebarOpen !== true) {
            openSidebar();
            wasSidebarOpen = true;
        }
    }

    window.addEventListener('resize', adjustSidebar);
    adjustSidebar();
</script>




</html>