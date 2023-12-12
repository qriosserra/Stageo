<?php

use Stageo\Lib\enums\Action;

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
    </style>
</head>

<body
    :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

<div class="flex h-screen overflow-hidden">

    <div>
        <!-- Sidebar Start -->
        <div class="flex flex-col w-64 h-full bg-gray-800 hidden md:flex">
            <div class="md:hidden flex items-center">
                <button class="mobile-menu-button">
                    <svg
                        class="w-6 h-6 text-gray-500"
                        x-show="!showMenu"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
            <div class="flex flex-col items-center mt-10 mb-10 bg-white pt-3 pb-3">
                <a href="<?=Action::HOME->value?>" class="flex items-center">
                    <img src="assets/img/logo.png" alt="logo" class="h-[1.8rem] w-[7rem] mr-3">
                </a>
            </div>
            <div class="flex-grow">
                <nav class="mt-10">
                    <a href="<?= Action::ADMIN_DASH->value?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                        <span>Tableau de bord</span>
                    </a>
                    <a href="" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                        <span>Etudiants</span>
                    </a>
                    <a href="<?=Action::ADMIN_LISTEENTREPRISE->value?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                        <span>Entreprises à valider</span>
                    </a>
                    <a href="/validate-offers" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                        <span>Offres à valider</span>
                    </a>
                    <a href="/tutors" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                        <span>Tuteurs</span>
                    </a>
                    <a href="<?=Action::ADMIN_SIGN_UP_FORM->value?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                        <span>Ajouter des Admin</span>
                    </a>
                    <a href="<?=Action::ADMIN_SUPRIMERADMIN_FROM->value?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                        <span>Supprimer des Admin</span>
                    </a>
                </nav>
            </div>
        </div>

    </div>



    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

        <div class="flex min-h-screen">



            <!-- Main Content - Right side -->
            <div class="flex flex-col " id="container-main">

                <!-- Entreprises à Valider Section -->
                <div class="flex justify-between mb-6" id="container-card-valide">

                    <main id="card-valide" class="grid justify-center items-center p-4 w-1/2 mx-2">
                        <div id="drop-area"
                             class="bg-black group inline-block p-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">
                            <div class=" flex flex-row">
                                <!-- Réduction de la hauteur du figure -->
                                <figure class=" justify-center items-center h-72 aspect-square  ">
                                    <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto"
                                         src="assets/img/check.png" />
                                    <div class="px-4 pt-2 pb-4 text-center">
                                        <h3 class="text-xl font-bold text-black">Entreprise(s) à valider</h3>
                                        <a class="text-blue-400 hover:text-red-400 ">Acceder à la page de validation
                                        </a>
                                        <p id="upload-message"></p>
                                    </div>
                                </figure>
                                <!-- Suppression du padding en haut pour la div du texte -->
                                <div class="hidden md:block">
                                    <h3 class="text-xl font-bold text-black mb-4 p-4">Entreprises à vérifier</h3>
                                    <ul class="ml-2">
                                        <li><a href="#entreprise1"
                                               class="text-blue-600 text-blue-400 hover:text-red-400">Google :
                                                bazfizbezjipgzze jpgzeza ad azdaz d a e gjzpegjzpigjem
                                                peijgejgzjebg</a></li>
                                        <li><a href="#entreprise2"
                                               class="text-blue-600 text-blue-400 hover:text-red-400">Microsoft :
                                                oeiaohgjoizeg zhegizhegizei ogiozh egoizhz nzjogzrioh</a></li>
                                        <li><a href="#entreprise3"
                                               class="text-blue-600 text-blue-400 hover:text-red-400">Apple :
                                                jkeraopjegpozejgipozjgeo jzpoejgpozejgop zjpoegozjnboern</a></li>
                                        <!-- Ajoutez d'autres entreprises ici... -->
                                    </ul>
                                </div>
                            </div>


                        </div>

                    </main>

                    <main id="card-valide" class="grid justify-center items-center p-4 w-1/2 mx-2">
                        <div id="drop-area"
                             class="bg-black group inline-block p-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">
                            <div class=" flex flex-row">
                                <!-- Réduction de la hauteur du figure -->
                                <figure class=" justify-center items-center h-72 aspect-square  ">
                                    <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto"
                                         src="assets/img/offre.png" />
                                    <div class="px-4 pt-2 pb-4 text-center">
                                        <h3 class="text-xl font-bold text-black">Offre(s) à valider</h3>
                                        <a class="text-blue-400 hover:text-red-400 ">Acceder à la page de validation
                                        </a>
                                        <p id="upload-message"></p>
                                    </div>
                                </figure>
                                <div class="hidden md:block">
                                    <h3 class="text-xl font-bold text-black mb-4 p-4">Offres à valider</h3>
                                    <ul class="ml-2">
                                        <li><a href="#entreprise1"
                                               class="text-blue-600 text-blue-400 hover:text-red-400">Googlekpnzkegne
                                                : Stages .........</a></li>
                                        <li><a href="#entreprise2"
                                               class="text-blue-600 text-blue-400 hover:text-red-400">Microsoft :
                                                Alternance ...</a></li>
                                        <li><a href="#entreprise3"
                                               class="text-blue-600 text-blue-400 hover:text-red-400">Apple :
                                                Stages &
                                                Alternance apknkaepngm.zenojvazfaz zefzef ze fze
                                                ffazfazfazfazfazfazfazf..</a></li>
                                    </ul>
                                </div>
                            </div>


                        </div>

                    </main>

                </div>
                <div id="container-deux-ligne-tab" class=" flex flex-row   ">
                    <div id="container-deux-ligne" class=" ml-3 flex row  w-2/5">
                        <main class="grid justify-center items-center  p-4 ">
                            <div id="drop-area"
                                 class="bg-black group inline-block pb-4 bg-gray-100 border-2 text-white overflow-hidden rounded-2xl shadow hover:shadow-md transition flex flex-col justify-center items-center pt-4">

                                <!-- Réduction de la hauteur du figure -->
                                <figure
                                    class="mb-[-1.5rem] justify-center items-center h-56 aspect-square overflow-hidden ">
                                    <img class="w-3/4 h-3/4 object-cover transition group-hover:scale-110 mx-auto my-auto"
                                         src="assets/img/csv.png" />
                                </figure>
                                <!-- Suppression du padding en haut pour la div du texte -->
                                <div class="px-4 pt-2 pb-4 text-center">
                                    <h3 class="text-xl font-bold text-black">Suivi</h3>
                                    <p class="text-black">Importer ou exporter les suivis en csv</p>
                                    <p id="upload-message"></p>
                                </div>
                                <footer class="flex justify-between items-center w-full px-4 bg-transparent">
                                    <!-- Bouton pour l'importation à gauche -->
                                    <button class="text-blue-400 hover:text-red-400">
                                        <i class="fa-solid fa-upload"></i> Importer
                                    </button>
                                    <!-- Bouton pour l'exportation à droite -->
                                    <button class="text-blue-400 hover:text-red-400">
                                        <i class="fa-solid fa-download"></i> Exporter
                                    </button>
                                </footer>
                            </div>
                        </main>
                        

                    </div>
                    <div id="tableau" class="w-3/5 bg-white mr-6 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-5">
                            <h2 class="text-lg font-semibold text-gray-700 mb-3">Liste des élèves</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-800 text-black">
                                    <tr>
                                        <th class="w-1/4 px-4 py-2">Nom</th>
                                        <th class="w-1/4 px-4 py-2">Prénom</th>
                                        <th class="w-1/4 px-4 py-2">Adresse Mail</th>
                                        <th class="w-1/8 px-4 py-2">Année</th>
                                        <th class="w-1/8 px-4 py-2">Groupe</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                    <!-- Génération aléatoire d'élèves -->
                                    <tr>
                                        <td class="border px-4 py-2">Doe</td>
                                        <td class="border px-4 py-2">John</td>
                                        <td class="border px-4 py-2">john.doe@email.com</td>
                                        <td class="border px-4 py-2">3ème</td>
                                        <td class="border px-4 py-2">A1</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border px-4 py-2">Smith</td>
                                        <td class="border px-4 py-2">Anna</td>
                                        <td class="border px-4 py-2">anna.smith@email.com</td>
                                        <td class="border px-4 py-2">2ème</td>
                                        <td class="border px-4 py-2">B3</td>
                                    </tr>


                                    <!-- Ajoutez plus de lignes ici selon le même modèle -->
                                    </tbody>
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
    const btn = document.querySelector("button.mobile-menu-button");
    const sidebar = document.querySelector(".sidebar");

    btn.addEventListener("click", () => {
        sidebar.classList.toggle("-translate-x-full");
    });
</script>
</html>