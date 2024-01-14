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

        a svg {
            margin-right: 4%;
            margin-bottom: 2%;
        }
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
                        <nav class="mt-5">
                            <a href="<?= Action::ADMIN_DASH->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg>
                                <span>Tableau de bord</span>
                                
                            </a>
                            <a href="<?= Action::ADMIN_GESTION_ETUDIANT->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
</svg>
                                <span>Gestion etudiants</span>
                            </a>
                            <a href="<?= Action::ADMIN_LISTEENTREPRISE->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building-check" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514"/>
  <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6.5a.5.5 0 0 1-1 0V1H3v14h3v-2.5a.5.5 0 0 1 .5-.5H8v4H3a1 1 0 0 1-1-1z"/>
  <path d="M4.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
</svg>
                                <span>Entreprises à valider</span>
                            </a>
                            <a href="<?= Action::ADMIN_LISTEOFFRES->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-plus" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>
  <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z"/>
</svg>
                                <span>Offres à valider</span>
                            </a>
                            <a href="<?= Action::ADMIN_SIGN_UP_FORM->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
</svg>
                                <span>Ajouter des Admin</span>
                            </a>
                            <a href="<?= Action::ADMIN_SUPRIMERADMIN_FROM->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
</svg>
                                <span>Supprimer des Admin</span>
                            </a>
                            <a href="<?= Action::ADMIN_ENTREPRISEARCHIVE->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
  <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
</svg>
                                <span>Entreprises archivées</span>
                            </a>
                            <a href="<?= Action::ADMIN_STATS->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-percent" viewBox="0 0 16 16">
  <path d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0M4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
</svg>
                                <span>Statistiques</span>
                            </a>
                            
                            <a href="<?= Action::ADMIN_OFFRESARCHIVE->value ?>" class="flex items-center text-gray-300 hover:bg-gray-700 px-4 py-2 mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-zip" viewBox="0 0 16 16">
  <path d="M5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.11 0l-.929-.62a1 1 0 0 1-.415-1.074L5 8.438zm2 0H6v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.929-.62-.4-1.598A1 1 0 0 1 7 8.438z"/>
  <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1h-2v1h-1v1h1v1h-1v1h1v1H6V5H5V4h1V3H5V2h1V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
</svg>
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