<?php

/**
 * @var string $title
 * @var bool $nav
 * @var ?Stageo\Model\Object\User $user
 * @var string $template
 * @var bool $footer
 */

use Stageo\Lib\enums\Action;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Secretaire;

?>

<!DOCTYPE html>
<html lang="en">
<!----------------------------parameter, JS, css----------------------------------------->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?? "Sans titre" ?> | Stageo</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-straight/css/uicons-solid-straight.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css">
    <link rel='stylesheet' href="https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-straight/css/uicons-regular-straight.css">
    <link rel='stylesheet' href="https://cdn-uicons.flaticon.com/2.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.jsdelivr.net/npm/flowbite/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="icon" href="assets/img/faviconn.ico" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="assets/js/script.js"></script>
    <style>
        #dropdownContentEntreprise,
        #dropdownContentOffres,
        #dropdownContentMission,
        #dropdownContentListEntreprise,
        #dropdownContentContact{
            display: block;
            opacity: 0;
            visibility: hidden;
            transition: visibility 0.2s linear, opacity 0.2s ease-in-out;
            position: absolute;
            background-color: #ffffff;
        }

        #dropdownContentEntreprise.active,
        #dropdownContentOffres.active,
        #dropdownContentMission.active,
        #dropdownContentListEntreprise.active,
        #dropdownContentContact.active{
            opacity: 1;
            visibility: visible;
        }

        #dropdownContentEntreprise {
            width: 520px;
            height: 450px;
            position: absolute;
            right: 0;
        }

        #dropdownContentOffres {
            width: 500px;
            height: 210px;
            background-color: white;
        }

        #dropdownContentMission {
            width: 500px;
            height: 220px;
            background-color: white;
        }

        #dropdownContentContact {
            width: 500px;
            height: 220px;
            background-color: white;
        }

        #dropdownContentListEntreprise {
            width: 500px;
            height: 220px;
            background-color: white;
        }


        .card-entreprise {
            padding: 1%;
        }

        .card-entreprise:hover {
            background-color: rgb(245, 244, 244);
            transition: 0.3s;
            cursor: pointer;
        }
    </style>
</head>

<body class="overflow-x-hidden">
    <!----------------------------bar du haut----------------------------------------->
    <header class="fixed w-full z-20 top-0 left-0">
        <!----------------------------Bar nav----------------------------------------->
        <?php if ($nav) : ?>
            <nav class="bg-white w-full z-20 border-b border-gray-200 dark:border-gray-200">
                <div class="max-w-screen-xl flex flex-wrap md:pl-4 md:pr-4 items-center justify-between mx-auto md:p-0 p-4">
                    <a href="<?= Action::HOME->value ?>" class="flex items-center">
                        <img src="assets/img/logo.png" alt="logo" class="h-[1.8rem] w-[7rem] mr-3">
                    </a>

                    <!----------------------------Bouton à droite----------------------------------------->
                    <div class="flex md:order-2">
                        <!----------------------------Drop down User !!! ----------------------------------------->
                        <?php if (is_null($user)) : ?>
                            <a href="<?= Action::ETUDIANT_SIGN_IN_FORM->value ?>" class="space-x-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <i class="fi fi-rr-sign-in-alt flex align-middle text-lg float-left"></i>
                                <span>Se connecter</span>
                            </a>
                        <?php else : ?>
                            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                                <button type="button" class="flex text-sm rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="w-8 h-8 rounded-full" src="assets/img/utilisateur.png" alt="user photo">
                                    <!-- //TODO : Photo -->
                                </button>
                                <!-- Dropdown menu -->
                                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                                    <div class="px-4 py-3">
                                        <span class="block text-sm text-gray-900 dark:text-white">
                                            <?php if ($user instanceof Enseignant || UserConnection::isInstance(new Etudiant())) : ?><?=
                                                                                                                                    /** @var Admin|Etudiant $user */
                                                                                                                                    $user->getNom() . " " . $user->getPrenom() ?>
                                            <?php elseif (UserConnection::isInstance(new Entreprise())) : ?><?=
                                                                                                            /** @var Entreprise $user */
                                                                                                            $user->getRaisonSociale() ?>
                                            <?php else : ?>secrétariat
                                        <?php endif ?>
                                        </span>
                                        <span class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?= $user->getEmail() ?></span>
                                        <!-- //TODO : email du mec et tout -->
                                    </div>
                                    <!-- Menu étudiant -->
                                    <?php if (UserConnection::isInstance(new Etudiant())) : ?>
                                        <ul class="py-2" aria-labelledby="user-menu-button">
                                            <li>
                                                <a href="<?= Action::PROFILE_ETUDIANT->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profil</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::ETUDIANT_MES_CANDIDATURE->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mes Candidatures</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déposer ou modifier une convention</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::ETUDIANT_SOUMETTRE_CONVENTION->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Soumettre ma convention</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::SIGN_OUT->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                            </li>
                                        </ul>
                                    <?php endif ?>
                                    <!-- Menue entreprise -->
                                    <?php if (UserConnection::isInstance(new Entreprise())) : ?>
                                        <ul class="py-2" aria-labelledby="user-menu-button">
                                            <li>
                                                <a href="<?= Action::AFFICHER_ENTREPRISE->value ."&id=".$user->getIdEntreprise() ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profil</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::ENTREPRISE_POSTULE_OFFRE_ETUDIANT->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Candidats Offres</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::SIGN_OUT->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                            </li>
                                        </ul>
                                    <?php endif ?>
                                    <!-- Menu Admin -->
                                    <?php if (($user instanceof Enseignant && $user->getEstAdmin())) : ?>
                                        <ul class="py-2" aria-labelledby="user-menu-button">
                                            <li>
                                                <a href="<?= Action::ADMIN_DASH->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tableau de bord</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::SIGN_OUT->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                            </li>
                                        </ul>
                                    <?php endif ?>
                                    <!-- Menu Prof -->
                                    <?php if (($user instanceof Enseignant && !$user->getEstAdmin())) : ?>
                                        <ul class="py-2" aria-labelledby="user-menu-button">
                                            <li>
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tableau de bord</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::SIGN_OUT->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                            </li>
                                        </ul>
                                    <?php endif ?>
                                    <!-- Menu Secretaries -->
                                    <?php if (UserConnection::isInstance(new Secretaire())) : ?>
                                        <ul class="py-2" aria-labelledby="user-menu-button">
                                            <li>
                                                <a href="<?= Action::SECRETAIRE_DASH->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tableau de bord</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                            </li>
                                            <li>
                                                <a href="<?= Action::SIGN_OUT->value ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                            </li>
                                        </ul>
                                        </ul>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endif ?>
                        <!----------------------------Menu Burger !!! ----------------------------------------->
                        <button data-collapse-toggle="navbar-user" type="button" class=" ml-4 inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                            </svg>
                        </button>
                    </div>
                    <!----------------------------Bouton central----------------------------------------->
                    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 lg:mr-32" id="navbar-user">
                        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white  dark:border-gray-700">
                            <li class="relative">
                                <button class="block py-2 pl-3 pr-4 h-[4rem] text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700  md:dark:hover:text-blue-500 focus:outline-none" id="dropdownOffres">

                                    <?php if (UserConnection::isSignedIn()) : ?><a href="<?= Action::LISTE_OFFRE->value ?>">Offres</a>
                                    <?php else : ?><a href="<?= Action::ETUDIANT_SIGN_IN_FORM->value ?>">Offres</a><?php endif ?>
                                </button>
                                <div id="dropdownContentOffres" class="block opacity-0 absolute bg-white invisible active:opacity-100 active:visible text-gray-700 pt-1 border border-slate-300 w-[500px] h-[210px]">
                                    <div class="rounded  ease-in-out ml-3 mt-3 flex flex-row ">
                                        <div class="w-1/2">
                                            <span class="font-bold">Trouver le stage/alternance idéal</span>
                                            <p class="mt-2">
                                                Découvrez une multitude d'offres de stages et d'alternances taillées sur mesure.
                                                Trouvez l'expérience professionnelle idéale pour votre parcours.
                                            </p>
                                        </div>
                                        <div class="w-1/2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="250" height="170" viewBox="0 0 552.81023 515.45882" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <path d="M372.63287,365.4151H174.32491c-16.66894,0-30.22987-13.56093-30.22987-30.22987V136.87726c0-16.66894,13.56093-30.22987,30.22987-30.22987h198.30797c16.66894,0,30.22987,13.56093,30.22987,30.22987v198.30797c0,16.66894-13.56093,30.22987-30.22987,30.22987ZM174.32491,111.48416c-14.02422,0-25.39309,11.36888-25.39309,25.39309v198.30797c0,14.02422,11.36888,25.39309,25.39309,25.39309h138.90984c46.8289,0,84.79122-37.96232,84.79122-84.79122V136.87726c0-14.02422-11.36888-25.39309-25.39309-25.39309H174.32491Z" fill="#f2f2f2" />
                                                <path d="M195.70439,132.1061c-9.38575,0-17.02112,7.63537-17.02112,17.02112v26.64175c0,9.38575,7.63537,17.02112,17.02112,17.02112h26.64175c9.38575,0,17.02112-7.63537,17.02112-17.02112v-26.64175c0-9.38575-7.63537-17.02112-17.02112-17.02112h-26.64175Z" fill="#f2f2f2" />
                                                <path d="M195.70439,207.1061c-9.38575,0-17.02112,7.63537-17.02112,17.02112v26.64175c0,9.38575,7.63537,17.02112,17.02112,17.02112h26.64175c9.38575,0,17.02112-7.63537,17.02112-17.02112v-26.64175c0-9.38575-7.63537-17.02112-17.02112-17.02112h-26.64175Z" fill="#f2f2f2" />
                                                <path d="M195.70439,282.1061c-9.38575,0-17.02112,7.63537-17.02112,17.02112v26.64175c0,9.38575,7.63537,17.02112,17.02112,17.02112h26.64175c9.38575,0,17.02112-7.63537,17.02112-17.02112v-26.64175c0-9.38575-7.63537-17.02112-17.02112-17.02112h-26.64175Z" fill="#f2f2f2" />
                                                <g>
                                                    <path d="M213.3715,67.1061c-11.82633,0-21.44711,9.62079-21.44711,21.44711v33.56939c0,11.82633,9.62079,21.44711,21.44711,21.44711h33.56939c11.82633,0,21.44711-9.62079,21.44711-21.44711v-33.56939c0-11.82633-9.62079-21.44711-21.44711-21.44711h-33.56939Z" fill="#63b4ff" />
                                                    <path d="M323.89034,160.9186c-11.82633,0-21.44711,9.62079-21.44711,21.44711v33.56939c0,11.82633,9.62079,21.44711,21.44711,21.44711h33.56939c11.82633,0,21.44711-9.62079,21.44711-21.44711v-33.56939c0-11.82633-9.62079-21.44711-21.44711-21.44711h-33.56939Z" fill="#63b4ff" />
                                                    <g>
                                                        <polygon points="275.84229 498.80796 269.02267 498.75047 266.00379 471.83263 276.06892 471.91748 275.84229 498.80796" fill="#a0616a" />
                                                        <path d="M253.99807,509.65233c-.01481,1.6785,1.33828,3.06028,3.0229,3.07572l13.55914,.11314,2.37372-4.81149,.8718,4.83603,5.11615,.0464-1.2919-17.24842-1.77998-.11842-7.26029-.50048-2.34232-.15686-.0411,4.88024-10.89209,7.38777c-.82869,.56298-1.32776,1.49545-1.33604,2.49637Z" fill="#2f2e41" />
                                                    </g>
                                                    <g>
                                                        <polygon points="310.54007 498.80796 303.72044 498.75047 300.70157 471.83263 310.76669 471.91748 310.54007 498.80796" fill="#a0616a" />
                                                        <path d="M288.69584,509.65233c-.01481,1.6785,1.33828,3.06028,3.0229,3.07572l13.55914,.11314,2.37372-4.81149,.8718,4.83603,5.11615,.0464-1.2919-17.24842-1.77998-.11842-7.26029-.50048-2.34232-.15686-.0411,4.88024-10.89209,7.38777c-.82869,.56298-1.32776,1.49545-1.33604,2.49637Z" fill="#2f2e41" />
                                                    </g>
                                                    <path d="M249.08109,281.17831l27.64346,.87295,26.18854,5.81968s-2.61885,3.20082,6.11066,11.93033c0,0,11.63935,20.36886,3.49181,40.15576l-3.49181,79.14758s10.18085,55.79388,2.40219,73.5511l-10.28082,.64255-17.39634-73.54982-8.47914-79.20944-4.07377,77.98365s15.58482,53.52659,5.74359,74.77562l-11.13465-.64255-19.05157-74.13307s-8.14755-85.54922-6.98361-101.84432c1.16394-16.29509,9.31148-35.50002,9.31148-35.50002Z" fill="#2f2e41" />
                                                    <g>
                                                        <path d="M341.91407,156.11273c-3.77892,.97845-6.04918,4.83514-5.07069,8.61407,.44834,1.73156,1.50489,3.14028,2.87746,4.07089l-.00041,.00966-.53609,12.98479,9.93665,4.59846,.7932-19.98146-.06921,.00211c.86159-1.53494,1.15931-3.38933,.68324-5.22793-.97848-3.77893-4.83517-6.04911-8.61416-5.0706Z" fill="#a0616a" />
                                                        <path d="M286.37793,202.45483c-2.08746-2.06912-3.29844-4.87434-3.34374-7.92486-.06088-4.09228,1.98991-7.80651,5.48559-9.93539,4.02563-2.45174,9.05967-2.20364,12.82498,.63119l31.20286,23.4935,5.55989-33.84423,11.93675,3.84257-2.84806,44.07c-.19948,3.08263-1.94154,5.7983-4.6607,7.26426-2.71916,1.46596-5.94507,1.42927-8.63009-.09817l-45.0929-25.65511c-.90583-.51546-1.7216-1.13691-2.43458-1.84377Z" fill="#3f3d56" />
                                                    </g>
                                                    <g>
                                                        <path d="M238.79919,137.1819c1.9947,3.35541,.89159,7.69261-2.46385,9.68729-1.5375,.914-3.27962,1.17053-4.90955,.86503l-.00651,.00715-8.76131,9.59852-10.29404-3.73037,13.50476-14.7482,.04766,.05023c.46883-1.69663,1.563-3.22314,3.19555-4.19363,3.35544-1.99468,7.69258-.89152,9.68729,2.46398Z" fill="#a0616a" />
                                                        <path d="M242.58351,208.7873l-50.08512-13.52903c-2.98215-.8057-5.29885-3.05086-6.19773-6.00635-.89888-2.95549-.22401-6.11051,1.80467-8.44008l29.00517-33.30129,11.18221,5.67535-19.87987,27.94879,38.69929,5.28473c4.66979,.63785,8.41937,4.00591,9.55199,8.58126,.98359,3.97296-.17507,8.05448-3.09949,10.91773-2.17991,2.13441-5.01491,3.27394-7.95408,3.27362-1.00399,0-2.02084-.13303-3.02702-.40473Z" fill="#3f3d56" />
                                                    </g>
                                                    <path d="M313.98891,292.82223l-70.0381,3.21276c-1.92358-2.92109-1.40264-7.31347,1.29122-12.81367,10.17125-20.76721,2.44654-60.05462-2.74985-80.51179-1.45798-5.73976,2.4559-11.44589,8.34855-12.03515l6.60367-.66037,6.10424-18.63399h21.37875l8.86923,10.13266,15.05189,9.14389c-2.73972,28.22064-14.41356,68.0706,2.2172,88.05507,3.63737,4.37087,4.66873,9.09743,2.92321,14.1106Z" fill="#3f3d56" />
                                                    <circle cx="271.51868" cy="150.9868" r="20.82357" fill="#a0616a" />
                                                    <path d="M295.08231,137.65762c2.8972-10.56287-28.67928-19.62073-34.81549-11.11444-.85326-1.20934-4.00655-1.9439-5.45336-1.57293-1.44681,.37097-2.66357,1.29841-3.85072,2.19619-1.6323,1.2539-3.32392,2.55231-4.32553,4.35524-1.00909,1.79551-1.16487,4.24398,.19287,5.80205,1.07584,1.23904,2.9663,7.82332,4.58375,8.14978,1.12773,.23,2.07745,.41549,2.89358,.54904,.72714-1.06098,2.58132-2.39375,2.44778-3.67731,1.09807,.7271,.69691,2.00635,.47552,3.31376-.73718,4.35363-17.34626,38.05525-7.83345,28.12415,.9423,.55647,2.10715,1.07583,3.45008,1.55065,2.27775-3.43523,4.14747-7.48625,5.37914-11.7228l.00872,.07826c.42405,3.68168,3.11456,6.70263,6.67421,7.73388,14.27942,4.13681,25.82989-1.93337,29.80326-12.87997-1.45451-2.95297-2.08826-2.63223-1.95797-2.72004,1.81577-1.2238,4.31135-.42345,5.09179,1.62242,.2301,.60321,.43924,1.1182,.62043,1.50569,2.07002-7.40469,4.53201-6.33593-3.38458-21.29362Z" fill="#2f2e41" />
                                                    <path d="M285.23139,129.99395l-1.4586-7.45697c-.12261-.62684-.23896-1.30695,.04369-1.87973,.36317-.73595,1.29668-1.04096,2.10893-.92366,.81225,.11729,1.41978,.85923,2.22791,1.0021,2.80975,.49673,6.52379-2.27858,7.53053,4.7424,.41975,2.92732,5.09082,3.23652,6.65079,5.74883,1.55997,2.51232,1.75148,6.13862-.37749,8.19111-1.70031,1.63923-4.43095,1.82843-6.63933,.99107-2.20838-.83736-3.98071-2.52874-5.52887-4.31237s-2.9501-3.71374-4.73583-5.25948" fill="#2f2e41" />
                                                    <path d="M296.19459,141.33592c-5.69794-.79597-9.5818-2.86826-11.54365-6.15883-2.5677-4.30742-.84774-9.05031-.77338-9.25017l1.20447,.44772c-.016,.04361-1.57626,4.38523,.67957,8.15551,1.75478,2.9329,5.32489,4.79466,10.61057,5.53322l-.17758,1.27255Z" fill="#63b4ff" />
                                                </g>
                                                <path d="M322.93382,60.76232c-16.75117,0-30.38116-13.62998-30.38116-30.38116S306.18264,0,322.93382,0s30.38116,13.62998,30.38116,30.38116-13.62998,30.38116-30.38116,30.38116Zm0-48.60985c-10.05189,0-18.22869,8.1768-18.22869,18.22869s8.1768,18.22869,18.22869,18.22869,18.22869-8.1768,18.22869-18.22869-8.1768-18.22869-18.22869-18.22869Z" fill="#63b4ff" />
                                                <path d="M369.67748,81.40904c-1.48939,0-2.98174-.54294-4.15367-1.64367l-28.51497-26.72296c-2.45067-2.29342-2.57528-6.13854-.27889-8.58624,2.29045-2.4566,6.13557-2.57824,8.58624-.27889l28.51497,26.72296c2.45067,2.29342,2.57528,6.13854,.27889,8.58624-1.19566,1.27874-2.81263,1.92256-4.43256,1.92256Z" fill="#63b4ff" />
                                                <g>
                                                    <path d="M498.55135,498.12587c2.06592,.12937,3.20768-2.43737,1.64468-3.93333l-.1555-.61819c.02047-.04951,.04105-.09897,.06178-.14839,2.08924-4.9818,9.16992-4.94742,11.24139,.04177,1.83859,4.42817,4.17942,8.86389,4.75579,13.54594,.25838,2.0668,.14213,4.17236-.31648,6.20047,4.30807-9.41059,6.57515-19.68661,6.57515-30.02077,0-2.59652-.14213-5.19301-.43275-7.78295-.239-2.11854-.56839-4.2241-.99471-6.31034-2.30575-11.2772-7.29852-22.01825-14.50012-30.98962-3.46197-1.89248-6.34906-4.85065-8.09295-8.39652-.62649-1.27891-1.11739-2.65462-1.34991-4.05618,.39398,.05168,1.48556-5.94866,1.18841-6.3168,.54906-.83317,1.53178-1.24733,2.13144-2.06034,2.98232-4.04341,7.0912-3.33741,9.23621,2.15727,4.58224,2.31266,4.62659,6.14806,1.81495,9.83683-1.78878,2.34682-2.03456,5.52233-3.60408,8.03478,.16151,.20671,.32944,.40695,.4909,.61366,2.96106,3.79788,5.52208,7.88002,7.68104,12.16859-.61017-4.76621,.29067-10.50822,1.82641-14.20959,1.74819-4.21732,5.02491-7.76915,7.91045-11.41501,3.46601-4.37924,10.57337-2.46806,11.18401,3.08332,.00591,.05375,.01166,.10745,.01731,.1612-.4286,.24178-.84849,.49867-1.25864,.76992-2.33949,1.54723-1.53096,5.17386,1.24107,5.60174l.06277,.00967c-.15503,1.54366-.41984,3.07444-.80734,4.57937,3.70179,14.31579-4.29011,19.5299-15.70147,19.76412-.25191,.12916-.49738,.25832-.74929,.38109,1.15617,3.25525,2.07982,6.59447,2.76441,9.97891,.61359,2.99043,1.03991,6.01317,1.27885,9.04888,.29715,3.83006,.27129,7.67959-.05168,11.50323l.01939-.13562c.82024-4.21115,3.10671-8.14462,6.4266-10.87028,4.94561-4.06264,11.93282-5.55869,17.26826-8.82425,2.56833-1.57196,5.85945,.45945,5.41121,3.43708l-.02182,.14261c-.79443,.32289-1.56947,.69755-2.31871,1.11733-.4286,.24184-.84848,.49867-1.25864,.76992-2.33949,1.54729-1.53096,5.17392,1.24107,5.6018l.06282,.00965c.0452,.00646,.08397,.01295,.12911,.01944-1.36282,3.23581-3.26168,6.23922-5.63854,8.82922-2.31463,12.49713-12.25603,13.68282-22.89022,10.04354h-.00648c-1.16259,5.06378-2.86128,10.01127-5.0444,14.72621h-18.02019c-.06463-.20022-.12274-.40692-.18089-.60717,1.6664,.10341,3.34571,.00649,4.98629-.29702-1.33701-1.64059-2.67396-3.29409-4.01097-4.93462-.03229-.0323-.05816-.0646-.08397-.09689-.67817-.8396-1.36282-1.67283-2.04099-2.51246l-.00036-.00102c-.04245-2.57755,.26652-5.14662,.87876-7.63984l.00057-.00035Z" fill="#f2f2f2" />
                                                    <path d="M0,514.26882c0,.66003,.53003,1.19,1.19006,1.19H551.48004c.65997,0,1.19-.52997,1.19-1.19,0-.65997-.53003-1.19-1.19-1.19H1.19006c-.66003,0-1.19006,.53003-1.19006,1.19Z" fill="#ccc" />
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php if (!UserConnection::isSignedIn() || UserConnection::isInstance(new Entreprise())) : ?>
                                <li class="relative ">
                                    <button class="block py-2 pl-3 pr-4 h-[4rem]  text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent focus:outline-none md:hover:text-blue-700 md:dark:hover:text-blue-500" id="dropdownButtonEntreprise">

                                        <?php if (!UserConnection::isSignedIn()) : ?><a href="<?= Action::ENTREPRISE_SIGN_IN_FORM->value ?>">Espace Entreprise</a>
                                        <?php elseif (UserConnection::isInstance(new Entreprise())) : ?><a href="<?= Action::ENTREPRISE_AFFICHER_OFFRE->value ?>">Espace Offre</a>
                                        <?php endif ?>

                                    </button>
                                    <div class="relative hidden text-gray-700 border border-slate-300" id="dropdownContentEntreprise">
                                        <div class="flex flex-wrap -mx-2">
                                            <?php if (!UserConnection::isInstance(new Entreprise())) : ?>
                                                <a href="<?= Action::ENTREPRISE_SIGN_IN_FORM->value ?>" class="w-1/2 p-4" target="" rel="noopener noreferrer">
                                                    <div class="card-entreprise p-5 mr-3">
                                                        <span class="font-bold">Connectez-vous à l'Espace Entreprise</span>
                                                        <p>Administrez les opportunités de stage et d'alternance de votre entreprise,
                                                            consultez et réagissez aux retours des candidats.</p>
                                                    </div>
                                                </a>
                                            <?php endif ?>
                                            <a href="<?php if (UserConnection::isInstance(new Entreprise())) : ?><?= Action::ENTREPRISE_CREATION_OFFRE_FORM->value ?><?php else : ?><?= Action::ENTREPRISE_SIGN_IN_FORM->value ?><?php endif ?>" class="w-1/2 p-4" target="" rel="noopener noreferrer">
                                                <div class="card-entreprise  p-4  h-full">
                                                    <span class="font-bold">Vous voulez proposer des offres ?</span>
                                                    <p class="mt-2">
                                                        Rejoignez notre plateforme dynamique et rencontrez des candidats talentueux
                                                        prêts à s'engager dans des stages et alternances enrichissants.</p>
                                                </div>
                                            </a>
                                            <a href="<?php if (UserConnection::isInstance(new Entreprise())) : ?><?= Action::HOME->value ?><?php else : ?><?= Action::ENTREPRISE_SIGN_IN_FORM->value ?><?php endif ?>" class="w-1/2 p-4" target="" rel="noopener noreferrer">
                                                <div class="card-entreprise p-4">
                                                    <span class="font-bold">Besoin d'Information? Contactez l'IUT et le
                                                        Secrétariat!</span>
                                                    <p class="mt-2">Contactez notre secrétariat ou les administrateurs pour aide et
                                                        infos sur les
                                                        formations et candidatures.</p>
                                                </div>
                                            </a>
                                            <div class="w-1/2 p-4">
                                                <div class=" p-4">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="250" height="170" viewBox="0 0 537.64 563.26" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                        <path id="uuid-fb6bba6d-324d-4625-a98c-3d990729dcd8-212" d="m294.36,308.7c1.69,8.48,7.72,13.98,13.47,12.28,5.75-1.7,9.04-9.96,7.35-18.44-.63-3.4-2.11-6.52-4.32-9.07l-7.63-35.8-17.84,5.88,9.42,34.67c-1.01,3.51-1.16,7.11-.43,10.48,0,0,0,0,0,0Z" fill="#f8a8ab" />
                                                        <rect x="254.14" y="514.38" width="20.94" height="29.71" transform="translate(529.23 1058.47) rotate(-180)" fill="#f8a8ab" />
                                                        <path d="m272.77,561.11c-3.58.32-21.5,1.74-22.4-2.37-.82-3.77.39-7.71.56-8.25,1.72-17.14,2.36-17.33,2.75-17.44.61-.18,2.39.67,5.28,2.53l.18.12.04.21c.05.27,1.33,6.56,7.4,5.59,4.16-.66,5.51-1.58,5.94-2.03-.35-.16-.79-.44-1.1-.92-.45-.7-.53-1.6-.23-2.68.78-2.85,3.12-7.06,3.22-7.23l.27-.48,23.8,16.06,14.7,4.2c1.11.32,2,1.11,2.45,2.17h0c.62,1.48.24,3.2-.96,4.28-2.67,2.4-7.97,6.51-13.54,7.02-1.48.14-3.44.19-5.64.19-9.19,0-22.61-.95-22.71-.97Z" fill="#2f2e43" />
                                                        <rect x="196.13" y="514.38" width="20.94" height="29.71" transform="translate(413.21 1058.47) rotate(-180)" fill="#f8a8ab" />
                                                        <path d="m214.76,561.11c-3.58.32-21.5,1.74-22.4-2.37-.82-3.77.39-7.71.56-8.25,1.72-17.14,2.36-17.33,2.75-17.44.61-.18,2.39.67,5.28,2.53l.18.12.04.21c.05.27,1.33,6.56,7.4,5.59,4.16-.66,5.51-1.58,5.94-2.03-.35-.16-.79-.44-1.1-.92-.45-.7-.53-1.6-.23-2.68.78-2.85,3.12-7.06,3.22-7.23l.27-.48,23.8,16.06,14.7,4.2c1.11.32,2,1.11,2.45,2.17h0c.62,1.48.24,3.2-.96,4.28-2.67,2.4-7.97,6.51-13.54,7.02-1.48.14-3.44.19-5.64.19-9.19,0-22.61-.95-22.71-.97Z" fill="#2f2e43" />
                                                        <polygon points="213.11 100.28 245.58 110.95 245.58 64.21 216.12 64.21 213.11 100.28" fill="#f8a8ab" />
                                                        <circle cx="241.56" cy="44.8" r="32.35" fill="#f8a8ab" />
                                                        <path d="m233.32,47.33l4.46,5.41,8.07-14.12s10.3.53,10.3-7.11c0-7.64,9.45-7.86,9.45-7.86,0,0,13.37-23.35-14.33-17.2,0,0-19.21-13.16-28.77-1.91,0,0-29.3,14.75-20.91,40.44l13.93,26.48,3.16-5.99s-1.91-25.16,14.65-18.15Z" fill="#2f2e43" />
                                                        <path d="m0,562.07c0,.66.53,1.19,1.19,1.19h535.26c.66,0,1.19-.53,1.19-1.19s-.53-1.19-1.19-1.19H1.19c-.66,0-1.19.53-1.19,1.19Z" fill="#484565" />
                                                        <path d="m328.8,349.01l-61.13-19.65c-7.54-2.42-15.64,1.63-18.21,9.13l-27.62,80.54c-2.82,8.22,2.16,17.06,10.65,18.92l70.26,15.37c7.72,1.69,15.38-3.1,17.24-10.78l18.49-76.26c1.79-7.4-2.43-14.94-9.68-17.27Z" fill="#e2e3e4" />
                                                        <path d="m322.6,366l-3.94-.7c2.52-14.32,6-52.5-8.05-57.18-6.81-2.27-13.67,1.7-20.38,11.81-5.27,7.95-8.35,16.75-8.38,16.84l-3.78-1.31c.54-1.55,13.39-37.94,33.8-31.14,20.17,6.72,11.12,59.43,10.72,61.67Z" fill="#2f2e43" />
                                                        <polygon points="276.25 254.19 166.98 254.19 193.72 529.88 224.72 527.88 226.25 329.34 245.76 416.47 251.47 526.38 279.72 527.88 283 402.85 276.25 254.19" fill="#2f2e43" />
                                                        <polygon points="211.34 83.19 248.34 92.19 279.97 228.88 276.25 254.19 183.6 269.87 166.98 254.19 211.34 83.19" fill="#3e75cb" />
                                                        <polygon points="211.28 76.35 198.63 90.54 172.97 96.7 129.22 291.22 213.52 305.5 237 107.39 211.28 76.35" fill="#2f2e43" />
                                                        <polygon points="248.32 83.44 241.72 106.96 272.27 317.88 288.03 317.88 280.76 111.48 259.36 94.48 248.32 83.44" fill="#2f2e43" />
                                                        <path d="m268.07,108.87l12.69,2.61s5.56,2.04,7.58,17.84c2.01,15.8,2.37,68.86,2.37,68.86l21.58,85.6-24.51,8.08-11.54-46.06-8.18-136.94Z" fill="#2f2e43" />
                                                        <polygon points="246.9 97.89 240.76 109.15 253.04 241.23 238.71 254.54 225.4 242.26 235.13 109.66 220.95 97.89 225.91 94.3 231.03 100.44 241.27 98.4 245.36 92.25 246.9 97.89" fill="#2f2e43" />
                                                        <path id="uuid-4155b336-10d9-4b14-826d-07551e167be9-213" d="m186.59,275.51c5.15,6.95,12.95,9.34,17.42,5.35,4.47-3.99,3.92-12.86-1.23-19.82-2.02-2.81-4.69-4.99-7.79-6.35l-22.2-29.11-13.62,12.94,23.33,27.32c.59,3.61,1.99,6.92,4.09,9.66,0,0,0,0,0,0Z" fill="#f8a8ab" />
                                                        <path d="m183.11,99.89l-10.14-3.19s-13.74,3.41-18.29,20.57l-22.21,83.6,37.67,66.12,20.13-24.44-18.96-60.7,11.81-81.96Z" fill="#2f2e43" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif ?>
                            <?php if (UserConnection::isSignedIn()) : ?>
                                <li>
                                    <button id="dropdownButtonListEntreprise" class="block py-2 pl-3 pr-4 h-[4rem] text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700  md:dark:hover:text-blue-500 focus:outline-none" id="dropdownOffres">
                                        <a href="<?=Action::LISTE_ENTREPRISES->value?>">Entreprises</a>
                                    </button>

                                    <div class="absolute hidden text-gray-700 pt-1 border border-slate-300 " id="dropdownContentListEntreprise">
                                        <div class="rounded  ease-in-out ml-3 mt-3 flex flex-row justify-end ">
                                            <div class="w-1/2">
                                                <span class="font-bold">La liste des entreprises partenaire!</span>
                                                <p class="mt-2">Trouver ici toutes les entreprises présente sur le site.</p>
                                            </div>
                                            <div class="w-1/2">
                                                <svg width="300" height="250" viewBox="0 0 596.37688 544.04108" xmlns:xlink="http://www.w3.org/1999/xlink">
<style type="text/css">
    .st0{fill:#E5F3F9;}
    .st1{fill:#BEE1F4;}
    .st2{fill-rule:evenodd;clip-rule:evenodd;fill:#112B46;}
    .st3{fill-rule:evenodd;clip-rule:evenodd;fill:#21496D;}
    .st4{fill-rule:evenodd;clip-rule:evenodd;fill:#495DEA;}
    .st5{fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;}
    .st6{fill-rule:evenodd;clip-rule:evenodd;fill:#606BF1;}
    .st7{fill-rule:evenodd;clip-rule:evenodd;fill:#20318D;}
    .st8{fill-rule:evenodd;clip-rule:evenodd;fill:#FFC8AF;}
    .st9{fill-rule:evenodd;clip-rule:evenodd;fill:#7181F4;}
    .st10{fill-rule:evenodd;clip-rule:evenodd;fill:#F4AE92;}
    .st11{fill-rule:evenodd;clip-rule:evenodd;fill:#EC827D;}
    .st12{fill-rule:evenodd;clip-rule:evenodd;fill:#FBD15B;}
    .st13{fill:#83C9FF;}
    .st14{fill-rule:evenodd;clip-rule:evenodd;fill:#56548C;}
    .st15{fill:#56548C;}
    .st16{enable-background:new    ;}
    .st17{fill:#A3D8EF;}
    .st18{fill:#CEE9F4;}
    .st19{fill:#6CC6E5;}
    .st20{fill:#D86868;}
    .st21{fill:#D34C4C;}
    .st22{fill:#F49898;}
    .st23{fill:#EC827D;}
    .st24{fill:#7181F4;}
    .st25{fill:#495DEA;}
    .st26{fill:#606BF1;}
    .st27{fill:#EFBC3F;}
    .st28{fill:#FFDC85;}
    .st29{fill-rule:evenodd;clip-rule:evenodd;fill:#F2AD91;}
    .st30{fill:#FBD15B;}
    .st31{fill:#A5B7C6;}
    .st32{fill:#B6C7D3;}
    .st33{fill:none;}
    .st34{fill:#878CF0;}
    .st35{fill:#112B46;}
    .st36{fill:#CCD9E2;}
    .st37{fill:#EEEEEE;}
    .st38{fill:#879FAF;}
    .st39{fill:#FFFFFF;}
    .st40{fill:#00C3B6;}
    .st41{fill:#CECCFF;}
    .st42{fill:#EAEEEF;}
    .st43{fill:#FFC8AF;}
    .st44{font-family:'OpenSans-Semibold';}
    .st45{font-size:8.1433px;}
    .st46{font-size:9.6829px;}
    .st47{fill-rule:evenodd;clip-rule:evenodd;fill:#303072;}
    .st48{fill-rule:evenodd;clip-rule:evenodd;fill:#46467F;}
</style>
                                                    <g>
                                                        <g>
                                                            <path class="st0" d="M276.9,153.1c2.8,2.7,6.8,4.1,10.7,4c4.5-0.1,8.9-2.1,12.3-5.1c0.1-0.1,0.2-0.2,0.3-0.3    c-0.8,0-1.7-0.1-2.5-0.2c-3.8-0.3-7.8-0.8-11.1-2.5c5.9,0.9,11.9,0.4,17.6-1.5c2.1-2.6,3.7-5.6,4.8-8.7c-0.7,0.4-1.4,0.8-2.2,1.2    c-5,2.3-10.7,2.4-16.3,1.5c7-1.7,13.7-4.4,19.9-8.1c0.5-2.6,0.6-5.2,0.4-7.8c-0.7,0.7-1.3,1.4-1.9,2.2c-1.1,1.5-2,3.3-3.5,4.5    c-2,1.6-4.8,1.8-7.4,1.9c-1.3,0-2.6,0-4,0c1.6-0.6,3.1-1.2,4.7-1.8c1.4-0.6,2.7-1.1,4-1.9c3.2-1.9,5.6-4.8,7.7-7.9    c-0.3-1.6-0.7-3.2-1.3-4.8c-3.4,3.2-7.4,5.8-11.7,7.6c3.9-2.9,7.5-6.3,10.6-10.1c-0.6-1.4-1.4-2.6-2.2-3.9    c-2.9,3.5-6.7,6.4-10.9,8.1c3.6-3,6.6-6.7,8.8-10.8c-0.7-0.9-1.5-1.7-2.4-2.5c-0.7,0.8-1.5,1.6-2.3,2.3c-0.7,0.6-1.5,1.1-2.3,1.6    c1.2-1.7,2.3-3.5,3.1-5.4c-1.1-1-2.3-1.9-3.4-2.7L276.9,153.1z"/>
                                                            <path class="st0" d="M276.9,153.1c-2,0.6-5.6,0-7.5-0.8c-2.1-1-4.1-2.3-5.6-4.1c-3-3.4-4.3-8-4.7-12.6c1.6,1.5,3.4,2.8,5.4,3.8    c2,1,4.2,1.8,6.4,2.5c-2.2-2.2-4.1-4.6-6.5-6.5c-0.8-0.7-1.7-1.3-2.6-2c-1.1-1-2-2.1-2.8-3.4c0.2-3.6,1-7.2,2.5-10.4    c0.5,1.6,1.3,3.2,2,4.7c0.9,1.7,1.8,3.4,3.2,4.8c1,1,2.3,1.8,3.6,2.4c-0.8-0.8-1.4-1.6-2.1-2.6c-2.7-4-3.5-9-4.1-13.9    c1.1-1.4,2.3-2.8,3.7-4c0.3,3.1,1.2,6.2,2.6,9c1.3,2.6,3,4.9,5.1,6.9c-0.4-0.8-0.7-1.5-1.1-2.3c-1.1-2.5-2.2-4.9-2.9-7.5    c-0.4-1.6-0.7-3.2-0.9-4.9c-0.1-0.8-0.2-1.6-0.2-2.4c0-0.3,0-0.6,0.1-0.9c1.5-1,3-2,4.7-2.7c-0.3,2.1-0.4,4.3,0,6.4    c0.3,1.3,0.7,2.5,1.3,3.8c1.1,2.5,2.4,4.9,4,7c-2.8-5.8-3.5-12.7-1.6-18.8c1.2-0.4,2.5-0.8,3.7-1c-0.5,2.5-0.4,5.1,0.1,7.6    c0.2-2.8,1-5.6,2.3-8c1.4-0.2,2.8-0.3,4.3-0.4c-0.3,1.6-0.3,3.2-0.1,4.8c0.3-1.7,0.9-3.4,1.8-4.9c1.8-0.1,3.6-0.2,5.5-0.4    L276.9,153.1z"/>
                                                            <path class="st1" d="M283.1,145.3c1,0.1,2,0.2,3,0.2c2,0.1,4,0.1,6.1,0.1c2,0,4-0.2,6-0.4c2-0.2,4-0.5,6-1c-2,0.4-4,0.7-6,0.8    c-2,0.2-4,0.2-6,0.2c-2,0-4-0.1-6-0.3c-1-0.1-2-0.2-3-0.3l-2.3-0.3l2.2-6c1.3,0.1,2.7,0.2,4,0.1c1.5-0.1,3-0.2,4.4-0.4    c2.9-0.4,5.8-1,8.7-1.9c-2.9,0.8-5.8,1.3-8.7,1.5c-1.5,0.1-2.9,0.2-4.4,0.2c-1.3,0-2.5-0.1-3.8-0.2l2.1-5.7c1.8,0,3.6-0.2,5.3-0.6    c1.9-0.4,3.7-0.9,5.5-1.6c1.8-0.7,3.5-1.5,5.1-2.5c1.6-0.9,3.2-2,4.7-3.1c-1.5,1.1-3.1,2.1-4.8,3c-1.7,0.9-3.4,1.7-5.2,2.3    c-1.8,0.7-3.6,1.2-5.4,1.5c-1.7,0.3-3.4,0.4-5.1,0.5l2.2-6c1.5-0.3,3-0.7,4.4-1.3c1.5-0.6,3-1.2,4.4-2c1.4-0.8,2.7-1.7,4-2.6    c1.3-1,2.5-2,3.6-3.1c-1.2,1.1-2.4,2.1-3.7,3c-1.3,0.9-2.7,1.8-4.1,2.5c-1.4,0.8-2.9,1.4-4.4,1.9c-1.3,0.5-2.7,0.8-4.1,1.1    l2.3-6.2c1.8-1,3.6-2.1,5.2-3.4c1.6-1.3,3.2-2.8,4.5-4.4c-1.4,1.6-3,3-4.6,4.3c-1.5,1.2-3.2,2.2-4.9,3.1l4-10.9l-5.8,14.3    c-0.5-1-1.1-2.1-1.4-3.2c-0.2-0.6-0.4-1.3-0.6-1.9c-0.1-0.7-0.3-1.3-0.4-2c-0.2-1.3-0.3-2.7-0.3-4c0-1.3,0.1-2.7,0.3-4    c-0.3,1.3-0.4,2.7-0.4,4c0,1.3,0.1,2.7,0.2,4c0.1,0.7,0.2,1.3,0.4,2c0.2,0.7,0.3,1.3,0.5,2c0.4,1.2,0.9,2.4,1.5,3.5l-2.3,5.7    c-1-1.4-2-2.8-2.7-4.3c-0.9-1.7-1.6-3.5-2.1-5.3c-0.5-1.8-0.9-3.7-1-5.6c-0.2-1.9-0.2-3.8,0.1-5.7c-0.3,1.9-0.4,3.8-0.2,5.7    c0.1,1.9,0.4,3.8,0.9,5.7c0.5,1.8,1.1,3.7,2,5.4c0.8,1.7,1.8,3.2,2.9,4.7l-2.1,5.2l-0.7-0.7l-0.6-0.6l-0.5-0.6l-1-1.2l-1-1.3    c-1.2-1.7-2.4-3.6-3.3-5.5c-0.9-1.9-1.8-3.9-2.4-6c-0.7-2-1.2-4.1-1.5-6.3c0.3,2.1,0.8,4.2,1.4,6.3c0.6,2.1,1.4,4.1,2.3,6    c0.9,2,2,3.9,3.2,5.6l0.9,1.3l1,1.3l0.5,0.6l0.6,0.6l0.9,0.9l-1.3,3.1c-1.5-0.9-2.9-1.9-4.2-3.1c-1.5-1.3-2.9-2.6-4.1-4.1    c-1.3-1.5-2.5-3-3.5-4.7c-1.1-1.6-2.1-3.3-2.9-5.1c0.8,1.8,1.7,3.5,2.8,5.2c1,1.7,2.2,3.3,3.4,4.8c1.2,1.5,2.6,3,4,4.3    c1.3,1.2,2.8,2.3,4.3,3.3l-1.4,3.6c-0.7-0.3-1.4-0.6-2-0.9c-0.8-0.4-1.7-0.8-2.5-1.3c-1.7-0.9-3.3-1.9-4.9-2.9    c-1.6-1-3.1-2.2-4.6-3.4c-1.5-1.2-2.9-2.5-4.1-3.9c1.2,1.5,2.6,2.8,4,4c1.4,1.2,2.9,2.4,4.5,3.5c1.6,1.1,3.2,2.1,4.8,3.1    c0.8,0.5,1.7,0.9,2.5,1.4c0.7,0.3,1.4,0.7,2,1l-3,7.4c-1.4-0.2-2.8-0.5-4.2-1c-1.5-0.6-3-1.4-4.4-2.3c-1.4-0.9-2.7-2-4-3.1    c-1.2-1.1-2.4-2.4-3.5-3.7c1,1.4,2.2,2.6,3.4,3.8c1.2,1.2,2.5,2.3,3.9,3.3c1.4,1,2.9,1.8,4.4,2.5c1.3,0.5,2.7,0.9,4.1,1.1    l-5.2,12.9l1.8,0.7l4.8-13.1c1,0.5,2,1,3.1,1.3c1.3,0.5,2.7,0.8,4,1.1c1.4,0.3,2.7,0.4,4.1,0.5c1.4,0.1,2.8,0,4.1-0.1    c-1.4,0.1-2.8,0.1-4.1,0c-1.4-0.1-2.7-0.3-4.1-0.6c-1.3-0.3-2.7-0.7-3.9-1.2c-1.1-0.4-2.1-0.9-3.1-1.5l1.9-5.1L283.1,145.3z"/>
                                                        </g>
                                                        <g>
                                                            <path class="st0" d="M51.1,226.4c2.7-2.8,4-6.8,3.8-10.7c-0.2-4.5-2.3-8.8-5.3-12.2c-0.1-0.1-0.2-0.2-0.3-0.3    c0,0.8-0.1,1.7-0.1,2.5c-0.2,3.8-0.6,7.8-2.3,11.2c0.8-5.9,0.2-11.9-1.8-17.5c-2.7-2-5.6-3.6-8.7-4.7c0.4,0.7,0.8,1.4,1.2,2.2    c2.4,5,2.5,10.7,1.8,16.3c-1.8-7-4.7-13.7-8.4-19.8c-2.6-0.4-5.2-0.5-7.8-0.3c0.7,0.7,1.5,1.3,2.3,1.9c1.6,1.1,3.4,1.9,4.6,3.4    c1.7,2,1.9,4.8,2,7.3c0.1,1.3,0.1,2.6,0.1,4c-0.6-1.6-1.2-3.1-1.9-4.6c-0.6-1.4-1.2-2.7-2-4c-2-3.1-4.9-5.5-8-7.6    c-1.6,0.3-3.2,0.8-4.7,1.4c3.3,3.3,5.9,7.3,7.8,11.6c-3-3.9-6.4-7.4-10.3-10.5c-1.3,0.7-2.6,1.4-3.8,2.3c3.6,2.8,6.5,6.6,8.3,10.7    c-3.1-3.5-6.8-6.5-10.9-8.6c-0.9,0.8-1.7,1.6-2.5,2.4c0.9,0.7,1.7,1.4,2.4,2.3c0.6,0.7,1.1,1.5,1.6,2.3c-1.7-1.2-3.5-2.2-5.4-3    c-0.9,1.1-1.8,2.3-2.6,3.5L51.1,226.4z"/>
                                                            <path class="st0" d="M51.1,226.4c0.6,2,0.1,5.6-0.7,7.5c-0.9,2.1-2.3,4.1-4,5.7c-3.4,3.1-8,4.4-12.5,4.9c1.5-1.6,2.7-3.5,3.7-5.5    c1-2.1,1.7-4.2,2.4-6.4c-2.1,2.2-4.5,4.2-6.4,6.6c-0.7,0.9-1.2,1.8-1.9,2.6c-0.9,1.1-2.1,2.1-3.3,2.8c-3.6-0.2-7.2-0.9-10.5-2.3    c1.6-0.6,3.2-1.3,4.7-2.1c1.7-0.9,3.4-1.8,4.7-3.2c1-1.1,1.7-2.3,2.4-3.6c-0.8,0.8-1.6,1.5-2.5,2.1c-4,2.8-9,3.6-13.8,4.3    c-1.5-1.1-2.8-2.3-4-3.6c3.1-0.4,6.2-1.3,9-2.8c2.6-1.3,4.9-3.1,6.9-5.2c-0.7,0.4-1.5,0.8-2.3,1.1c-2.4,1.1-4.9,2.3-7.5,3    c-1.6,0.5-3.2,0.7-4.8,1c-0.8,0.1-1.6,0.2-2.4,0.2c-0.3,0-0.6,0-0.9,0c-1.1-1.4-2-3-2.8-4.6c2.1,0.3,4.3,0.3,6.4-0.1    c1.3-0.3,2.5-0.8,3.7-1.3c2.5-1.1,4.8-2.5,6.9-4.2c-5.8,2.9-12.6,3.7-18.7,1.9c-0.5-1.2-0.8-2.5-1.1-3.7c2.5,0.4,5.1,0.4,7.6-0.2    c-2.8-0.1-5.6-0.9-8.1-2.2c-0.2-1.4-0.4-2.8-0.5-4.3c1.6,0.3,3.2,0.3,4.8,0.1c-1.7-0.3-3.4-0.9-5-1.7c-0.1-1.8-0.3-3.6-0.5-5.5    L51.1,226.4z"/>
                                                            <path class="st1" d="M43.1,220.3c0-1,0.1-2,0.2-3c0.1-2,0.1-4,0-6.1c-0.1-2-0.2-4-0.5-6c-0.3-2-0.6-4-1.1-6c0.5,2,0.7,4,0.9,6    c0.2,2,0.3,4,0.3,6c0,2,0,4-0.2,6c0,1-0.2,2-0.2,3l-0.2,2.3l-6-2.1c0.1-1.3,0.1-2.7,0-4c-0.1-1.5-0.2-3-0.4-4.4    c-0.4-2.9-1.1-5.8-2-8.6c0.8,2.8,1.4,5.7,1.7,8.7c0.2,1.5,0.2,2.9,0.3,4.4c0,1.3-0.1,2.5-0.2,3.8l-5.7-2c-0.1-1.8-0.2-3.6-0.7-5.3    c-0.4-1.9-1-3.7-1.7-5.4c-0.7-1.8-1.6-3.5-2.5-5.1c-1-1.6-2-3.2-3.2-4.7c1.2,1.5,2.2,3.1,3.1,4.7c0.9,1.7,1.7,3.4,2.4,5.1    c0.7,1.8,1.2,3.6,1.6,5.4c0.4,1.7,0.5,3.4,0.5,5.1l-6-2.1c-0.3-1.5-0.7-3-1.3-4.4c-0.6-1.5-1.3-2.9-2.1-4.3    c-0.8-1.4-1.7-2.7-2.7-4c-1-1.3-2-2.5-3.2-3.6c1.1,1.1,2.1,2.4,3.1,3.7c0.9,1.3,1.8,2.6,2.6,4c0.8,1.4,1.4,2.8,2,4.3    c0.5,1.3,0.9,2.7,1.1,4.1l-6.3-2.2c-1-1.8-2.2-3.5-3.5-5.1c-1.3-1.6-2.8-3.1-4.5-4.5c1.6,1.4,3,2.9,4.3,4.6    c1.2,1.5,2.3,3.2,3.2,4.9l-11-3.8l14.4,5.5c-1,0.6-2.1,1.1-3.2,1.5c-0.6,0.3-1.3,0.4-1.9,0.6c-0.7,0.1-1.3,0.3-2,0.4    c-1.3,0.2-2.7,0.4-4,0.4c-1.3,0-2.7,0-4-0.3c1.3,0.2,2.7,0.3,4,0.4c1.3,0,2.7-0.1,4-0.3c0.7-0.1,1.3-0.3,2-0.4    c0.6-0.2,1.3-0.3,1.9-0.6c1.2-0.4,2.4-1,3.5-1.6l5.7,2.2c-1.3,1-2.7,2-4.3,2.8c-1.7,0.9-3.4,1.6-5.2,2.2c-1.8,0.6-3.7,0.9-5.6,1.1    c-1.9,0.2-3.8,0.2-5.7,0c1.9,0.3,3.8,0.3,5.7,0.1c1.9-0.2,3.8-0.5,5.6-1c1.8-0.5,3.6-1.2,5.3-2.1c1.6-0.8,3.1-1.8,4.6-2.9l5.2,2    l-0.7,0.7l-0.6,0.6l-0.6,0.5l-1.2,1.1l-1.3,1c-1.7,1.3-3.5,2.4-5.4,3.4c-1.9,1-3.9,1.8-5.9,2.5c-2,0.7-4.1,1.3-6.2,1.6    c2.1-0.3,4.2-0.8,6.3-1.5c2.1-0.7,4.1-1.5,6-2.4c2-0.9,3.8-2,5.6-3.3l1.3-1l1.2-1l0.6-0.5l0.6-0.6l0.9-0.9l3.2,1.2    c-0.9,1.5-1.9,2.9-3,4.3c-1.2,1.5-2.6,2.9-4.1,4.2c-1.5,1.3-3,2.5-4.6,3.6c-1.6,1.1-3.3,2.1-5,3c1.8-0.8,3.5-1.8,5.1-2.9    c1.6-1.1,3.2-2.2,4.7-3.5c1.5-1.3,2.9-2.6,4.2-4.1c1.2-1.3,2.3-2.8,3.2-4.4l3.6,1.4c-0.3,0.7-0.6,1.4-0.9,2    c-0.4,0.8-0.8,1.7-1.2,2.5c-0.8,1.7-1.8,3.3-2.8,4.9c-1,1.6-2.1,3.1-3.3,4.6c-1.2,1.5-2.4,2.9-3.8,4.2c1.4-1.2,2.7-2.6,4-4.1    c1.2-1.4,2.4-3,3.4-4.5c1.1-1.6,2.1-3.2,3-4.9c0.5-0.8,0.9-1.7,1.3-2.5c0.3-0.7,0.6-1.4,1-2.1l7.4,2.8c-0.1,1.4-0.4,2.8-0.9,4.2    c-0.6,1.6-1.4,3.1-2.3,4.5c-0.9,1.4-1.9,2.7-3.1,4c-1.1,1.3-2.3,2.5-3.6,3.5c1.3-1,2.6-2.2,3.7-3.4c1.2-1.2,2.2-2.5,3.2-3.9    c1-1.4,1.8-2.9,2.4-4.5c0.5-1.3,0.9-2.7,1.1-4.1l13,5l0.7-1.8l-13.2-4.6c0.5-1,0.9-2.1,1.3-3.1c0.4-1.3,0.8-2.7,1-4    c0.2-1.4,0.4-2.7,0.4-4.1c0-1.4,0-2.8-0.2-4.1c0.1,1.4,0.1,2.8,0,4.1c-0.1,1.4-0.3,2.7-0.6,4.1c-0.3,1.3-0.7,2.7-1.1,3.9    c-0.4,1.1-0.9,2.1-1.4,3.1l-5.1-1.8L43.1,220.3z"/>
                                                        </g>

                                                        <ellipse id="XMLID_888_" transform="matrix(5.422115e-03 -1 1 5.422115e-03 -113.5066 396.8224)" class="st0" cx="142.7" cy="255.5" rx="61.1" ry="105.8"/>

                                                        <ellipse id="XMLID_723_" transform="matrix(5.422619e-03 -1 1 5.422619e-03 35.6668 461.9192)" class="st0" cx="250" cy="213" rx="61.1" ry="105.8"/>
                                                        <g>
                                                            <path class="st0" d="M151.6,64.5L151.6,64.5C151.6,64.5,151.6,64.5,151.6,64.5c-1.2-0.6-2.4-1.1-3.7-1.5c-0.1,0-0.1,0-0.2-0.1    c-0.3-0.1-0.7-0.2-1-0.3c-0.1,0-0.2-0.1-0.3-0.1c-0.3-0.1-0.6-0.1-0.9-0.2c-0.1,0-0.3-0.1-0.4-0.1c-0.3,0-0.6-0.1-0.9-0.1    c-0.1,0-0.3,0-0.4-0.1c-0.3,0-0.6-0.1-0.9-0.1c-0.1,0-0.3,0-0.4,0c-0.4,0-0.9,0-1.3,0l0,0l0,0c-5,0-9.6,1.5-13.4,4.1    c-1,0.6-1.9,1.4-2.7,2.1c-0.9,0.8-1.6,1.6-2.4,2.5c-0.2,0.3-0.5,0.6-0.7,0.9c-0.5,0.6-0.9,1.3-1.3,1.9c-0.2,0.3-0.4,0.7-0.6,1    c-0.2,0.4-0.5,0.9-0.7,1.4c-0.2,0.5-0.4,1-0.6,1.5c-0.3,0.8-0.6,1.7-0.8,2.6c-0.5,1.9-0.8,3.9-0.8,6c0,0.4,0,0.8,0,1.1    c0,0.1,0,0.2,0,0.4c0,0.3,0,0.5,0.1,0.8c0,0.1,0,0.3,0,0.4c0,0.2,0.1,0.5,0.1,0.7c0,0.1,0,0.3,0.1,0.4c0,0.3,0.1,0.6,0.2,0.9    c0,0.1,0,0.2,0.1,0.3c0.1,0.3,0.1,0.6,0.2,0.9c0,0.1,0.1,0.3,0.1,0.4c0.1,0.2,0.1,0.4,0.2,0.6c0,0.2,0.1,0.3,0.2,0.5    c0.1,0.2,0.1,0.4,0.2,0.5c0.1,0.2,0.1,0.3,0.2,0.5c0.1,0.2,0.1,0.3,0.2,0.5c0.1,0.3,0.3,0.6,0.4,0.9c0.1,0.1,0.1,0.3,0.2,0.4    c0.1,0.2,0.2,0.4,0.3,0.6c0.1,0.1,0.1,0.2,0.2,0.4c0.1,0.2,0.2,0.4,0.3,0.6c0.1,0.1,0.1,0.2,0.2,0.3c0.1,0.2,0.2,0.4,0.3,0.6    c0,0.1,0.1,0.2,0.1,0.2c0.3,0.5,0.6,0.9,0.9,1.3c0,0,0,0,0,0l0,0c4.4,5.9,11.4,9.8,19.3,9.8c13.2,0,24-10.7,24-24    C164.9,76.6,159.5,68.4,151.6,64.5z"/>
                                                            <path class="st0" d="M80.8,56.7L80.8,56.7C80.8,56.7,80.8,56.7,80.8,56.7c-1.6-0.8-3.3-1.5-5-2c-0.1,0-0.2-0.1-0.3-0.1    c-0.5-0.1-0.9-0.3-1.4-0.4c-0.2,0-0.3-0.1-0.5-0.1c-0.4-0.1-0.8-0.2-1.2-0.3c-0.2,0-0.4-0.1-0.6-0.1c-0.4-0.1-0.8-0.1-1.2-0.2    c-0.2,0-0.4-0.1-0.6-0.1c-0.4,0-0.8-0.1-1.3-0.1c-0.2,0-0.4,0-0.5,0c-0.6,0-1.2-0.1-1.8-0.1c-18,0-32.6,14.6-32.6,32.6    c0,0.5,0,1,0,1.5c0,0.2,0,0.3,0,0.5c0,0.3,0,0.7,0.1,1c0,0.2,0,0.4,0.1,0.6c0,0.3,0.1,0.7,0.1,1c0,0.2,0,0.4,0.1,0.5    c0.1,0.4,0.1,0.8,0.2,1.2c0,0.1,0.1,0.3,0.1,0.4c0.1,0.4,0.2,0.8,0.3,1.3c0.1,0.2,0.1,0.4,0.2,0.6c0.1,0.3,0.1,0.5,0.2,0.8    c0.1,0.2,0.1,0.4,0.2,0.7c0.1,0.2,0.2,0.5,0.2,0.7c0.1,0.2,0.2,0.5,0.2,0.7c0.1,0.2,0.2,0.5,0.3,0.7c0.2,0.4,0.4,0.9,0.6,1.3    c0.1,0.2,0.2,0.4,0.2,0.5c0.1,0.3,0.3,0.5,0.4,0.8c0.1,0.2,0.2,0.3,0.3,0.5c0.1,0.3,0.3,0.5,0.4,0.8c0.1,0.1,0.2,0.3,0.3,0.4    c0.2,0.3,0.3,0.5,0.5,0.8c0.1,0.1,0.1,0.2,0.2,0.3c5.8,9.1,16,15.1,27.5,15.1c18,0,32.6-14.6,32.6-32.6    C98.9,73.1,91.5,62,80.8,56.7z"/>
                                                            <path class="st0" d="M120,1.8c-0.1,0-0.2-0.1-0.4-0.1c-0.6-0.2-1.2-0.3-1.8-0.5c-0.2,0-0.4-0.1-0.6-0.1c-0.5-0.1-1.1-0.2-1.6-0.3    c-0.2,0-0.5-0.1-0.7-0.1c-0.5-0.1-1-0.2-1.5-0.2c-0.3,0-0.5-0.1-0.8-0.1c-0.5-0.1-1.1-0.1-1.6-0.1c-0.2,0-0.5,0-0.7-0.1    C109.5,0,108.8,0,108,0l0,0l0,0c-7.9,0-15.3,2.2-21.6,6c-0.6,0.3-1.1,0.7-1.7,1.1c-3.3,2.2-6.3,5-8.9,8    c-5.9,7.2-9.5,16.4-9.5,26.5c0,0.7,0,1.3,0,2c0,0.2,0,0.4,0,0.6c0,0.4,0.1,0.9,0.1,1.3c0,0.2,0,0.5,0.1,0.7c0,0.4,0.1,0.8,0.2,1.3    c0,0.2,0.1,0.4,0.1,0.7c0.1,0.5,0.2,1,0.3,1.5c0,0.2,0.1,0.3,0.1,0.5c0.1,0.5,0.2,1.1,0.4,1.6c0.1,0.3,0.1,0.5,0.2,0.8    c0.1,0.3,0.2,0.7,0.3,1c0.1,0.3,0.2,0.6,0.3,0.8c0.1,0.3,0.2,0.6,0.3,0.9c0.1,0.3,0.2,0.6,0.3,0.9c0.1,0.3,0.2,0.6,0.3,0.9    c0.2,0.6,0.5,1.1,0.7,1.7c0.1,0.2,0.2,0.5,0.3,0.7c0.2,0.3,0.3,0.7,0.5,1c0.1,0.2,0.2,0.4,0.3,0.6c0.2,0.3,0.4,0.7,0.5,1    c0.1,0.2,0.2,0.4,0.3,0.6c0.2,0.3,0.4,0.7,0.6,1c0.1,0.1,0.2,0.3,0.3,0.4c7.4,11.6,20.4,19.3,35.2,19.3c23,0,41.7-18.7,41.7-41.7    C149.6,22.8,137.1,6.9,120,1.8z"/>
                                                            <polygon class="st1" points="141,88.3 109.8,105.2 108,53.7 105.8,115.4 68,86 105.6,120.8 104.1,166.2 111.9,166.2 109.9,110       "/>
                                                        </g>

                                                        <ellipse id="XMLID_1357_" transform="matrix(5.422608e-03 -1 1 5.422608e-03 135.9534 329.7694)" class="st0" cx="233.8" cy="96.5" rx="61.1" ry="105.8"/>

                                                        <ellipse id="XMLID_1358_" transform="matrix(5.422274e-03 -1 1 5.422274e-03 8.6182 605.2566)" class="st0" cx="308.6" cy="298.3" rx="34.9" ry="60.4"/>
                                                        <g>
                                                            <path class="st0" d="M358.7,259.9c-1,1.7-2.1,3.4-3.2,5.1c-0.3,0.4-0.8,0.8-0.7,1.3c0,0.6,1,1.5,1.4,2c0.5,0.6,1.3,2.1,2,2.5    c-0.9-0.5-2.7-1.8-4-1.7c0.1,0.8,0.6,1.7,0.9,2.5c-0.8-0.6-1.4-0.9-2.3-1.1c0.2,0.8-0.3,1.8-0.5,2.6c-0.8,3.9-1.4,8.6,0.4,12.3    c1.9,4,7.3,3.4,10.9,2.5c1.8-0.4,3.7-1.2,5.2-2.3c0.6-0.4,2.4-2.4,3.2-1.8c-0.2-0.8-0.5-1.6-0.6-2.3c0.5,0.4,1.3,0.3,1.7,0.7    c0.9-0.6,1.4-1.7,2.4-2.2c-0.8-0.8-1-2.3-1.7-3.2c1,0.1,2.1,0.4,3,0.8c0.3-0.6,0.7-1.2,1.1-1.8c1.7-2.3,3.2-5,4.5-7.6    c0.8-1.6,1.7-3.1,2.7-4.6c-0.8-0.6-1.4-1.7-2.1-2.5c-0.9-1-1.9-1.9-2.8-2.9c0.5,0,1,0.3,1.5,0.4c1.7,0.5,3.4,0.9,5.1,1.3    c0.1-0.7,3.3-6.7,2.9-6.9c-1-0.6-2.3-1.3-3.2-2c1.1,0.3,2.2,0,3.3,0c-0.5-1.2-2.9-2.3-3.8-3.3c0.8-0.2,1.8,0.2,2.6,0.2    c0.6,0,1.2-0.1,1.7,0.2c0.3-1.8,0.3-3.6,0.3-5.4c0-1.2,0.5-3.2,0-4.2c-0.3-0.7-1.6-1.2-1.9-1.8c0.5-0.2,1-0.2,1.5-0.1    c0-0.4-0.3-6.3-0.7-6.3c-3.6,0.5-7,1.1-10.2,2.9c-0.6,0.3-1.3,0.6-1.5,1.2c-0.3,1.2,0.6,2.9,0.7,4.1c-1-1.1-2.5-1.9-3.7-2.9    c-1.3,1.2-2.5,2.2-3.5,3.7c-0.9,1.3-2,2.5-2.7,3.8c-0.3,0.5-1,1.3-1.1,1.8c-0.3,1.4,2.5,4.3,3.4,5.3c-1.5-0.1-2.9-1.5-4.5-1.7    c-1.7-0.2-1.7,1.5-2.7,2.1c0.6,0.1,1.4,1.2,1.8,1.7c-0.7,0-1.5-0.5-2.2-0.3c0.6,1.4,1.3,2.7,2.3,3.9c-0.9,0-1.8-0.7-2.7-0.9    c-0.4-0.1-0.9-0.1-1.3-0.2c-0.7,1.7-1.9,3.2-2.9,4.8C358.8,259.8,358.7,259.9,358.7,259.9z"/>
                                                            <g>
                                                                <path class="st1" d="M387,234.6c-2,1.9-3.1,5.4-4.3,7.9c-1.2,2.7-2.4,5.4-3.7,8.1c-2.3,5-4.8,9.9-8,14.5     c-6.4,9.3-12.3,19.3-20.1,27.5c-0.5,0.6-1.6-0.3-1.1-0.9c7.3-9,14.3-18.1,20.9-27.7c3.4-4.9,5.9-10.2,8.4-15.6     c2.2-4.8,4.3-9.9,7.1-14.3C386.8,233.7,387.4,234.2,387,234.6L387,234.6z"/>
                                                            </g>
                                                        </g>
                                                        <path id="XMLID_1359_" class="st0" d="M191.5,360.2c-23.5,13.6-61.8,13.5-85.4-0.2c-23.7-13.7-23.8-35.7-0.3-49.3   c23.5-13.6,61.8-13.5,85.4,0.2C214.9,324.6,215,346.6,191.5,360.2z"/>
                                                        <path id="XMLID_1303_" class="st0" d="M314.6,352.2c-5.2,3-13.6,3-18.9,0c-5.2-3-5.3-7.9-0.1-10.9c5.2-3,13.6-3,18.9,0   C319.7,344.3,319.8,349.2,314.6,352.2z"/>
                                                        <path id="XMLID_1362_" class="st0" d="M30.5,267.3c-3.7,2.1-9.6,2.1-13.3,0c-3.7-2.1-3.7-5.6,0-7.7c3.7-2.1,9.6-2.1,13.3,0   C34.2,261.7,34.2,265.2,30.5,267.3z"/>
                                                        <path id="XMLID_1363_" class="st0" d="M365.9,241.5c-2.3,1.3-6,1.3-8.3,0c-2.3-1.3-2.3-3.5,0-4.8c2.3-1.3,6-1.3,8.3,0   C368.1,238,368.1,240.2,365.9,241.5z"/>
                                                        <g id="XMLID_878_">
                                                            <g id="XMLID_1594_">
                                                                <g id="XMLID_1599_">
                                                                    <g id="XMLID_1602_">
                                                                        <path id="XMLID_1625_" class="st2" d="M65.5,237.4c0,0,8.4,9.8,10.7,10.5c2.2,0.7,0.2,3-1.5,3.1c-1.7,0.2-7.2-0.1-8.8-1.6       c-1.6-1.6-6.1-3.2-6.1-3.2c0-5.1,1.2-8.3,1.2-8.3L65.5,237.4z"/>
                                                                        <path id="XMLID_1624_" class="st2" d="M68.5,168c0,0,1.1,21.7,0.7,28.9c-0.4,7.1-2.1,42.5-2.1,42.5c-4.6,1-7.5,0-7.5,0       c-1.5-27.1-1.5-34.9-1.9-39c-0.4-4-1-15.7-1-15.7c-3.2-6.7,0.1-15.5,1.8-17.6C60,165,68.5,168,68.5,168z"/>
                                                                        <path id="XMLID_1623_" class="st2" d="M51.8,246.8c0.3,4,1.7,8.7,2.1,11c0.4,2.4-0.5,3.7-1,4.5c-0.5,0.8-7.3-1.5-8.2-4       c-0.9-2.6,1-4.9,1.1-9.7C47.9,244.7,51.8,246.8,51.8,246.8z"/>
                                                                        <path id="XMLID_1622_" class="st3" d="M61.5,169.7c0,0-1.2,19.8-3,26.4c-1.8,6.6-3.5,25.9-4.2,29.3c-0.8,3.4-1.7,24.2-1.7,24.2       c-4.2,1.1-7.5,0-7.5,0c0.1-19.5-0.4-35.4,0-40.7c0.4-5.4-0.2-21.2-0.2-21.2c-1.7-7.4-1.8-8.3,0-13.2       C46.7,169.5,54.6,165.7,61.5,169.7z"/>
                                                                        <path id="XMLID_1621_" class="st4" d="M65.3,122.7c6.8,1.9,10.5,19.1,12.4,22.9c1.9,3.9,17.9,4.8,17.9,4.8       c1,3.3-1.8,6.9-1.8,6.9c-15.4-0.6-20.8-1.9-23.6-8C67.3,143.3,57.3,124.8,65.3,122.7z"/>
                                                                        <path id="XMLID_1620_" class="st5" d="M65.3,122.7c-6.1-0.3-20.1,2.9-24.8,8.8c-4.6,5.9,2.1,16.3,3.7,22.6       c1.6,6.3-0.7,22.1-0.7,23.6c7.2,4.8,24.5,5.4,26.4-1.7c0.8-7.7-1-16.9-1.1-21.4C69.1,144.9,73.3,125.6,65.3,122.7z"/>
                                                                        <path id="XMLID_1619_" class="st6" d="M60.1,124.2c3.9,13.7,4.8,29.1,4.4,34.9c-0.4,5.8-0.5,24.6-0.5,24.6       c4.5-2.4,6.5-6.8,6.5-8.8c0-2-1.7-19-1.7-20.4c0.1-1.4,2.3-17,1.7-24c-0.6-7-5.2-7.8-5.2-7.8h-5.8L60.1,124.2z"/>
                                                                        <path id="XMLID_1618_" class="st7" d="M63.8,107.6c2.7,0.8,0,6.9,0,6.9V107.6z"/>
                                                                        <path id="XMLID_1617_" class="st8" d="M64,108.4c0,0,1,3.6,0.6,6.3c-0.4,2.8-0.6,8.3-3.1,10c-2.4,1.8-6-0.3-8.3-2.3       c-2.3-2-4.8-5.6-4.8-10c-0.1-4.4,1.7-9.8,8-9.5C62.8,103.2,64,108.4,64,108.4z"/>
                                                                        <path id="XMLID_1616_" class="st8" d="M51.6,118.6c0,0,0.5,5.7-1,7.8c-0.1,1.4,3.9,7.3,7.9,6.3c2.3-0.6,2-3.3,2-3.3       c-0.2-2.1,0-7,0-7L51.6,118.6z"/>
                                                                        <path id="XMLID_1615_" class="st2" d="M65.5,103.7c0.9,3.3-0.1,4.4-2.9,5.4c-2.8,0.9-10.1-1.2-10.1-1.2       c0.5,3.5-0.6,5.3-0.6,5.3c-1.2-3.4-2.3-1.7-2.4,1.1c-0.1,2.7,1.4,2.7,1.4,2.7c-0.1,2.3-0.9,3.1-0.9,3.1c-2.9-2-7-15.6-1.6-16       C48.6,99.3,63.6,96.7,65.5,103.7z"/>
                                                                        <path id="XMLID_1613_" class="st6" d="M50.4,125.5c4.7,10,7.2,19,7,27.3c-0.2,8.2-1.9,32.1-1.9,32.1c-8.2-2-13.8-4.3-15.4-7.1       c3.5-9.3,4.8-15.5,4.1-18.1c-0.7-2.6-6.9-22.7-3.7-28.7C43.6,127.7,50.4,125.5,50.4,125.5z"/>
                                                                        <path id="XMLID_1605_" class="st9" d="M43.3,130.8c5.6,2.8,10.1,18.4,14.4,22.6c2.4,2.4,14.5,5.5,17.8,5.5c1.3,3-1,6.2-1,6.2       c-20.6-1.9-21.5-3.1-27.8-11.1C38.8,144,35.7,128.9,43.3,130.8z"/>
                                                                        <path class="st10" d="M60.5,125.3c-1.7,0.7-4.2-0.4-7.5-3c0,0,1,3.8,7.5,5.2V125.3z"/>
                                                                    </g>
                                                                    <path id="XMLID_1601_" class="st5" d="M51.5,124.1c0,0.2-1.1,1.3-1.1,1.3s2,4.5,2.8,6.5c0.7,2,2.7,3.6,2.7,3.6l2.7-2.9      C54.9,130.7,51.5,124.1,51.5,124.1z"/>
                                                                </g>
                                                                <path id="XMLID_1598_" class="st5" d="M60.2,125.6c-0.2-0.3-0.8,5.6-1.7,7.1c1.7,1.6,2.7,2,2.7,2S62.3,128.1,60.2,125.6z"/>
                                                            </g>
                                                            <g id="XMLID_1614_">
                                                                <g id="XMLID_1592_">
                                                                    <g id="XMLID_1588_">
                                                                        <g id="XMLID_1603_">
                                                                            <path id="XMLID_1612_" class="st2" d="M240.8,186.7c-0.2,2.9-0.5,5.9-0.5,5.9h-0.7c0,0,0-4.5-0.7-3.5        C239.1,186.6,240.8,186.7,240.8,186.7z"/>
                                                                            <path id="XMLID_1611_" class="st8" d="M231.7,191.7c-0.3,0-0.7-0.3-1.1-0.9c0.7-0.8,1.3-1.6,1.8-2.2c1.4-2,3.7-6.3,3.8-8.3        c0.1-2-1.1-22.4-1.4-25c-0.3-2.5-1.3-12-1.2-12.5c0.1-0.5,8.8,3.4,8.8,3.4c-0.1,0.8-1.3,5.7-0.8,8.8c0.5,3.2,1.2,5.2,0.8,10.4        c-0.4,5.2-2.9,13.4-2.1,17.4c0,0.1,0,0.1,0,0.2C237.8,186.6,236.9,193.4,231.7,191.7z"/>
                                                                            <path id="XMLID_1607_" class="st2" d="M230.6,190.8c0.4,0.5,0.8,0.9,1.1,0.9c5.2,1.7,6.1-5.1,8.7-8.6c0.8,3.7,0.5,4.2-0.2,4.7        c-0.7,0.5-3.1,3.5-3.5,5.6c-0.4,2.1-7,1.9-8.2,1.4C227.6,194.5,229.1,192.6,230.6,190.8z"/>
                                                                            <path id="XMLID_1606_" class="st8" d="M249.7,163.9c0.3,2.3,1.6,19.9,1.4,22.9c-0.1,1.8-1,4.6-1.5,6.9        c-0.3,1.4-0.5,2.7-0.3,3.2c0.5,1.5,0.5,6,3,5c2.4-1,4.1-4.1,3.6-7.6c-0.5-3.5,0.1-5.1,0-7.2c-0.1-2.1,1.2-14.9,1.5-19.5        c0.2-4.6-1.3-6.8-1.4-9.8c-0.1-3.1,0.8-9.4,0.8-9.4s-10.5-5.5-9.6,1.1C247.8,156.2,249.5,161.6,249.7,163.9z"/>
                                                                            <path id="XMLID_1604_" class="st2" d="M248.8,197.1c0.2,3.1,1,5.8,3.4,4.8c2.4-1,4.1-4.1,3.6-7.6c-1.3,3.8-6.3,3.7-6.2-0.6        C249.3,195.1,248.8,196.5,248.8,197.1z"/>
                                                                        </g>
                                                                    </g>
                                                                    <path id="XMLID_1590_" class="st11" d="M232.9,121c0,0,0,21.3,0,28.3c0,7,1.8,30.5,1.8,30.5c3.5,1.4,7-0.3,7-0.3      c0.5-6.1,2.3-16.1,2.6-21.3c0.3-5.3-2.1-6.1-1.1-10c1-3.8,3.7-24.4,3.7-24.4L232.9,121z"/>
                                                                    <path id="XMLID_1589_" class="st11" d="M244.3,125.5c0,0,1.8,22.9,2.6,25.8c0.8,2.9,1.3,14.1,1.9,17.9      c0.6,3.8,0.6,14.9,0.6,14.9c1.4,4.5,7.1,0.7,7.1,0.7c2.4-14.2,0.7-21.2,0.7-25.4c-0.1-4.1,2-15,1.5-19.5      c-0.4-4.5-0.9-13.9,0-15.6c0.9-1.7,1.9-4.6,2.2-9.8c-6.8-2.6-17.4,0.3-17.4,0.3L244.3,125.5z"/>
                                                                </g>
                                                                <path id="XMLID_1610_" class="st5" d="M233.9,75.7c6-0.3,16.2,6.8,20.8,12.6s1.8,12.1,0.2,18.3c-1.6,6.2,0.9,21.8,0.9,23.3     c-7.1,4.7-20.3,5.3-22.2-1.7c-0.8-7.6,0.9-15.6,0.9-20.1C234.1,98.6,226,78.6,233.9,75.7z"/>
                                                                <path id="XMLID_1609_" class="st12" d="M239.1,77.1c-3.1,13.5-2.1,28.2-1.4,33.9c0.7,5.7,0.8,24.8,0.8,24.8     c-4.6-2.3-6.8-6.6-6.9-8.6c-0.1-2,1.7-18.5,1.6-19.9c-0.1-1.3-2.5-14.1-2.2-21.1c0.2-6.9,2.9-8,2.9-8l5.9-2.6L239.1,77.1z"/>
                                                                <path id="XMLID_1608_" class="st12" d="M247.8,78.5c-4.6,9.9-2.4,18.9-2.2,27c0.2,8.1,4.4,30.9,4.4,30.9c8.1-2,9-7.4,10.6-10.2     c3.7-19-1-34.4-4.5-40C253.4,81.7,247.8,78.5,247.8,78.5z"/>
                                                                <g id="XMLID_1570_">
                                                                    <g id="XMLID_1593_">
                                                                        <path id="XMLID_1596_" class="st13" d="M215.3,109.2c1.1,0.6,2.9,0.6,4.1,0c1.1-0.7,1.1-1.7,0-2.3c-1.1-0.6-2.9-0.6-4.1,0       C214.2,107.5,214.2,108.6,215.3,109.2z"/>
                                                                    </g>
                                                                </g>
                                                                <g id="XMLID_1476_">
                                                                    <path id="XMLID_1477_" class="st12" d="M252.9,86.3c-5.6,2.7-6.1,19.2-10.4,23.3c-2.4,2.3-12.1,0.5-15.4,0.5      c-1.3,2.9,0.5,6.4,0.5,6.4c18.5,0.9,20.7,1.5,25.4-7.5C256.6,102.1,260.4,84.4,252.9,86.3z"/>
                                                                </g>
                                                                <g id="XMLID_1471_">
                                                                    <path id="XMLID_1475_" class="st12" d="M233.8,78.4c-3.6,1.9-5.3,16.8-9.5,20.6c-2.4,2.1-3.5,4.1-8.4,6.5      c-1.3,2.7,2.2,4.3,2.2,4.3c9.8-3.7,12.1-6.9,15.4-11.9C237.5,91.7,241.2,76.6,233.8,78.4z"/>
                                                                    <path id="XMLID_1474_" class="st8" d="M217.8,109.2c-0.1,0.3-1.1,1.4-1.9,2.3c-0.9,1-2.2,2.6-2.6,2.2c-0.4-0.4,0.4-2.1,0.4-2.1      s-2.5,2.4-3,3.2c-0.5,0.8-0.2-1.5,0.5-2.6c-1.6,2.5-2,3-2.1,2.4c-0.1-0.6,1.2-3.9,1-3.6c-1.9,2.8-2.6,3.2-2.4,1.9      c0.2-1.3,2-3.5,3.1-4.1c-3.2,2.1-3.5,1.9-2.7,0.9c0.8-0.9,3.8-3.2,7.8-3.8C218.4,108.5,217.8,109.2,217.8,109.2z"/>
                                                                </g>
                                                                <path id="XMLID_1439_" class="st8" d="M215.7,114.4c1-1.6,2.6-3.5,4.5-4c1.3-0.4,2.8-0.1,4.1,0.3c1.1,0.3,2.6,0.5,3.6,1     c0.5,1.2,0.8,2.3,0.7,3.4c-0.2,0.1-0.4,0.1-0.7,0.2c-1.1,0.1-2.3,0.5-3.4,0.5c-0.8,0-2,0.2-2.6,0c0.3,0.1,0.6,0.2,0.7,0.5     c0,0.2-0.2,0.5-0.4,0.5c-1.6,0.4-3.1-1.6-4.1-2.5C218.1,114.4,214.3,116.5,215.7,114.4z"/>
                                                                <path id="XMLID_902_" class="st14" d="M233,61.9c-0.1,0.2-0.2,0.3-0.2,0.5c-0.3,0.9-0.1,2-0.3,2.9c-0.3,1.5-1.4,2.6-1.9,4.1     c-1.8,5.2,3.4,8.2,7.9,7.8c0.8-0.1,1.6-0.2,2.3-0.7c2.2-1.7-0.3-4.3-1.3-5.9c-0.7-1.1-1.7-2.5-1.8-3.9c-0.1-1.3,0.6-2.3,0.3-3.7     C237.5,60.3,234.2,59.8,233,61.9z"/>
                                                                <path id="XMLID_899_" class="st8" d="M246.5,72.5c0,0-1.5,5.1,1.9,7.3c0.1,1.2-3.5,6.6-7,5.7c-2.1-0.5-3.1-3.5-3.1-3.5     c0.2-1.9,1.3-5.8,1.3-5.8L246.5,72.5z"/>
                                                                <g id="XMLID_897_">
                                                                    <path id="XMLID_898_" class="st8" d="M234.4,62.1c0,0-0.9,3.3-0.6,5.8c0.3,2.5,0.6,7.6,2.8,9.2c2.2,1.6,5.5-0.3,7.6-2.1      c2.1-1.8,4.4-5.1,4.4-9.2c0.1-4-1.5-9-7.3-8.7C235.5,57.3,234.4,62.1,234.4,62.1z"/>
                                                                </g>
                                                                <path id="XMLID_896_" class="st14" d="M238.5,59.6c-1.5,1.8-0.8,4.1,1.1,5.5c1.3,0.9,2.4,1.5,3.3,3c0.8,1.3,1.2,2.9,1.3,4.4     c0.1,1.3,0.1,2.6,0.1,3.8c0,0.6,0.1,1.4,0.7,1.6c0.7,0.2,2.2-0.4,2.9-0.7c1.1-0.6,2-1.5,2.8-2.4c1.6-1.9,2.5-4.2,2.6-6.6     c0.2-4.5-2.4-7.4-5.7-10C244.3,55.4,241.2,56.3,238.5,59.6z"/>
                                                                <path id="XMLID_895_" class="st14" d="M236.5,57.3C236.5,57.3,236.5,57.3,236.5,57.3c1.2-0.8,5.8-2.2,5.8,0.1     c0,2.4-3.4,4.7-5.3,5.8c-0.8,0.5-1.6,0.8-2.4,1.4c-1,0.7-1,2.2-1.9,2.8c-1.3-1.2-1-4.3-0.4-5.8C233,59.6,234.8,58.5,236.5,57.3z"/>
                                                                <path class="st10" d="M239.1,77.6c2.4-0.2,5-2.5,5-2.5s-0.5,2.8-5.3,3.8L239.1,77.6z"/>
                                                            </g>
                                                            <path id="XMLID_900_" class="st15" d="M306.8,216.6c-2.3,3.6-1.8,6.1-1.1,6.4c13.6,6.1,22.1,4.2,24.2,3.5    c-2.3-3.1-4.4-6.2-6.9-9.6C316.3,218.1,306.8,216.6,306.8,216.6z"/>
                                                            <g id="XMLID_662_">
                                                                <g class="st16">
                                                                    <g id="XMLID_664_">
                                                                        <polygon id="XMLID_665_" class="st17" points="267.2,119.5 267.2,134.6 239.9,150.4 239.9,135.4      "/>
                                                                    </g>
                                                                    <g id="XMLID_666_">
                                                                        <polygon id="XMLID_667_" class="st18" points="144.4,135.4 144.4,150.4 116.9,134.6 116.9,119.5      "/>
                                                                    </g>
                                                                    <g id="XMLID_668_">
                                                                        <path id="XMLID_669_" class="st19" d="M215.3,156.3l0-15c0-2.1,1.4-4.2,4.2-5.9c5.6-3.3,14.7-3.3,20.4,0l0,15       c-5.6-3.3-14.8-3.3-20.4,0C216.7,152.1,215.3,154.2,215.3,156.3z"/>
                                                                    </g>
                                                                    <g id="XMLID_670_">
                                                                        <path id="XMLID_671_" class="st17" d="M169.1,141.4l0,15c0-2.2-1.4-4.3-4.3-5.9c-5.6-3.3-14.8-3.3-20.4,0l0-15       c5.6-3.3,14.7-3.3,20.4,0C167.6,137,169.1,139.2,169.1,141.4z"/>
                                                                    </g>
                                                                    <g id="XMLID_672_">
                                                                        <polygon id="XMLID_673_" class="st18" points="192.3,163.1 192.3,178.1 164.8,162.2 164.9,147.2      "/>
                                                                    </g>
                                                                    <g id="XMLID_674_">
                                                                        <polygon id="XMLID_675_" class="st17" points="219.6,147.2 219.6,162.2 192.3,178.1 192.3,163.1      "/>
                                                                    </g>
                                                                    <g id="XMLID_676_">
                                                                        <path id="XMLID_677_" class="st1" d="M267.2,119.5l-27.3,15.9c-5.6-3.3-14.8-3.3-20.4,0c-5.6,3.3-5.6,8.5,0.1,11.8l-27.3,15.9       l-27.5-15.9c5.6-3.3,5.6-8.5-0.1-11.8c-5.6-3.3-14.8-3.3-20.4,0l-27.5-15.9L191.8,76L267.2,119.5z"/>
                                                                    </g>
                                                                </g>
                                                                <g class="st16">
                                                                    <g id="XMLID_678_">
                                                                        <path id="XMLID_679_" class="st20" d="M146.3,154.6l0,15c0,2.1-1.4,4.2-4.2,5.9l0-15C144.9,158.8,146.3,156.7,146.3,154.6z"/>
                                                                    </g>
                                                                    <g id="XMLID_680_">
                                                                        <polygon id="XMLID_681_" class="st20" points="169.6,176.3 169.6,191.3 142.3,207.2 142.3,192.1      "/>
                                                                    </g>
                                                                    <g id="XMLID_682_">
                                                                        <path id="XMLID_683_" class="st21" d="M117.7,213l0-15c0-2.1,1.4-4.2,4.2-5.9c5.6-3.3,14.7-3.3,20.4,0l0,15       c-5.6-3.3-14.8-3.3-20.4,0C119.1,208.8,117.7,210.9,117.7,213z"/>
                                                                    </g>
                                                                    <g id="XMLID_684_">
                                                                        <polygon id="XMLID_685_" class="st20" points="122,203.9 122,219 94.7,234.8 94.7,219.8      "/>
                                                                    </g>
                                                                    <g id="XMLID_686_">
                                                                        <polygon id="XMLID_687_" class="st22" points="94.7,219.8 94.7,234.8 19.3,191.3 19.3,176.3      "/>
                                                                    </g>
                                                                    <g id="XMLID_688_">
                                                                        <path id="XMLID_689_" class="st23" d="M142.1,148.6c5.6,3.3,5.7,8.5,0.1,11.8l27.5,15.9l-27.3,15.9c-5.6-3.3-14.8-3.3-20.4,0       c-5.6,3.3-5.6,8.5,0.1,11.8l-27.3,15.9l-75.4-43.5l74.9-43.5l27.5,15.9C127.3,145.4,136.4,145.4,142.1,148.6z"/>
                                                                    </g>
                                                                </g>
                                                                <g class="st16">
                                                                    <g id="XMLID_690_">
                                                                        <path id="XMLID_691_" class="st24" d="M238.2,169.5l0-15c0,2.1,1.4,4.3,4.2,5.9l0,15C239.6,173.8,238.2,171.7,238.2,169.5z"/>
                                                                    </g>
                                                                    <g id="XMLID_692_">
                                                                        <polygon id="XMLID_693_" class="st24" points="242.7,192.1 242.6,207.2 215.2,191.3 215.2,176.3      "/>
                                                                    </g>
                                                                    <g id="XMLID_694_">
                                                                        <path id="XMLID_695_" class="st25" d="M267.3,198.1l0,15c0-2.1-1.4-4.3-4.2-5.9c-5.6-3.3-14.8-3.3-20.4,0l0-15       c5.6-3.3,14.7-3.3,20.4,0C265.9,193.8,267.3,195.9,267.3,198.1z"/>
                                                                    </g>
                                                                    <g id="XMLID_696_">
                                                                        <polygon id="XMLID_697_" class="st24" points="290.6,219.8 290.5,234.8 263.1,219 263.1,203.9      "/>
                                                                    </g>
                                                                    <g id="XMLID_698_">
                                                                        <polygon id="XMLID_699_" class="st25" points="365.5,176.3 365.4,191.3 290.5,234.8 290.6,219.8      "/>
                                                                    </g>
                                                                    <g id="XMLID_700_">
                                                                        <path id="XMLID_701_" class="st26" d="M365.5,176.3l-74.9,43.5l-27.5-15.9c5.6-3.3,5.6-8.5-0.1-11.8c-5.6-3.3-14.8-3.3-20.4,0       l-27.5-15.9l27.3-15.9c-5.6-3.3-5.7-8.5-0.1-11.8c5.6-3.3,14.7-3.3,20.4,0l27.3-15.9L365.5,176.3z"/>
                                                                    </g>
                                                                </g>
                                                                <g class="st16">
                                                                    <g id="XMLID_702_">
                                                                        <path id="XMLID_703_" class="st27" d="M244.6,211.3l0,15c0,2.1-1.4,4.2-4.2,5.9l0-15C243.2,215.5,244.6,213.4,244.6,211.3z"/>
                                                                    </g>
                                                                    <g id="XMLID_704_">
                                                                        <path id="XMLID_705_" class="st28" d="M140.6,226.2l0-15c0,2.1,1.4,4.3,4.3,5.9l0,15C142,230.5,140.6,228.4,140.6,226.2z"/>
                                                                    </g>
                                                                    <g id="XMLID_706_">
                                                                        <path id="XMLID_1553_" class="st29" d="M166.1,281.8c0,0,0.7,0.3,2.5,1c1.7,0.7,5.5,1,7.8,0.6c2.3-0.4,5.5-0.9,4.9-1.7       c-0.6-0.9-12.3-3.8-12.8-3.6C167.9,278.3,166.1,281.8,166.1,281.8z"/>
                                                                        <polygon id="XMLID_707_" class="st28" points="193,276.5 192.9,291.6 117.5,248 117.6,233      "/>
                                                                    </g>
                                                                    <g id="XMLID_708_">
                                                                        <polygon id="XMLID_709_" class="st27" points="267.9,233 267.8,248 192.9,291.6 193,276.5      "/>
                                                                    </g>
                                                                    <g id="XMLID_710_">
                                                                        <path id="XMLID_711_" class="st30" d="M240.3,205.3c5.6,3.3,5.7,8.5,0.1,11.8l27.5,15.9L193,276.5L117.6,233l27.3-15.9       c-5.6-3.3-5.7-8.5-0.1-11.8c5.6-3.3,14.7-3.3,20.4,0l27.3-15.9l27.5,15.9C225.6,202.1,234.7,202.1,240.3,205.3z"/>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="XMLID_587_">
                                                                <g id="XMLID_625_">
                                                                    <g id="XMLID_713_">
                                                                        <g class="st16">
                                                                            <g id="XMLID_715_">
                                                                                <path id="XMLID_716_" class="st31" d="M193.1,229.8l0,1.6c0,1.2-0.8,2.5-2.4,3.4c-3.3,1.9-8.6,1.9-11.9,0         c-1.7-1-2.5-2.2-2.5-3.5l0-1.6c0,1.3,0.8,2.5,2.5,3.5c3.3,1.9,8.6,1.9,11.9,0C192.3,232.3,193.1,231,193.1,229.8z"/>
                                                                            </g>
                                                                            <g id="XMLID_717_">
                                                                                <path id="XMLID_718_" class="st32" d="M190.7,226.3c3.3,1.9,3.3,5,0,6.9c-3.3,1.9-8.6,1.9-11.9,0c-3.3-1.9-3.3-5,0-6.9         C182.1,224.4,187.4,224.4,190.7,226.3z"/>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <path id="XMLID_1856_" class="st32" d="M204.5,178.9c-0.5-0.3-1.2-0.2-1.9,0.2l-41.8,24.1c-1.5,0.9-2.7,3-2.7,4.7l0.1,31.3      c0,0.9,0.3,1.5,0.8,1.7l2.7,1.6c-0.5-0.3-0.8-0.9-0.8-1.7l-0.1-31.3c0-1.7,1.2-3.8,2.7-4.7l41.8-24.1c0.8-0.4,1.4-0.5,1.9-0.2      L204.5,178.9z"/>
                                                                    <path id="XMLID_714_" class="st31" d="M205.3,180.7c1.5-0.9,2.7-0.2,2.7,1.6l0.1,31.3c0,1.7-1.2,3.8-2.7,4.7l-41.8,24.1      c-1.5,0.9-2.7,0.2-2.7-1.6l-0.1-31.3c0-1.7,1.2-3.8,2.7-4.7L205.3,180.7z"/>
                                                                    <line id="XMLID_719_" class="st33" x1="162.7" y1="209.6" x2="162.7" y2="209.5"/>
                                                                    <polygon id="XMLID_720_" class="st34" points="206.1,188.5 206.1,182.5 204.9,183.1 202.4,184.6 168.7,204 162.7,207.5       162.7,209.5 162.7,209.6 162.7,224.4 162.7,236.8 189.4,221.4 193.5,219 206.2,211.7     "/>
                                                                    <polygon id="XMLID_721_" class="st26" points="168.7,204 162.7,207.5 162.7,209.4 206.1,184.4 206.1,182.5     "/>
                                                                    <path id="XMLID_1855_" class="st26" d="M167.8,211.8c0,0.9-0.6,1.9-1.4,2.4c-0.8,0.4-1.4,0.1-1.4-0.8c0-0.9,0.6-1.9,1.4-2.4      C167.2,210.6,167.8,210.9,167.8,211.8z"/>
                                                                    <path id="XMLID_1854_" class="st23" d="M167.8,216.6c0,0.9-0.6,1.9-1.4,2.4c-0.8,0.4-1.4,0.1-1.4-0.8c0-0.9,0.6-1.9,1.4-2.4      C167.2,215.4,167.8,215.7,167.8,216.6z"/>
                                                                    <path id="XMLID_1853_" class="st30" d="M167.8,221.4c0,0.9-0.6,1.9-1.4,2.4c-0.8,0.4-1.4,0.1-1.4-0.8c0-0.9,0.6-1.9,1.4-2.4      C167.2,220.2,167.8,220.5,167.8,221.4z"/>
                                                                    <path id="XMLID_1852_" class="st23" d="M167.6,237.3c0,0.6-0.4,1.4-1,1.7c-0.5,0.3-1,0.1-1-0.6c0-0.6,0.4-1.4,1-1.7      C167.2,236.4,167.6,236.7,167.6,237.3z"/>
                                                                </g>
                                                                <g id="XMLID_722_">
                                                                    <g id="XMLID_727_">
                                                                        <polygon id="XMLID_1851_" class="st15" points="223.2,238.5 209.8,230.8 227.6,220.5 241,228.2      "/>
                                                                    </g>
                                                                    <polygon id="XMLID_1850_" class="st35" points="223.2,239.1 223.2,238.5 241,228.2 241,228.8     "/>
                                                                    <polygon id="XMLID_1849_" class="st35" points="223.2,238.5 223.2,239.1 209.8,231.4 209.8,230.8     "/>
                                                                </g>
                                                                <g id="XMLID_728_">
                                                                    <polygon id="XMLID_1848_" class="st36" points="175.4,247.9 175.4,249 188.5,256.6 188.5,255.5     "/>
                                                                    <polygon id="XMLID_1847_" class="st31" points="188.5,255.5 188.5,256.6 217.5,239.9 217.5,238.8     "/>
                                                                    <polygon id="XMLID_1846_" class="st32" points="175.4,247.9 188.5,255.5 217.5,238.8 204.4,231.2     "/>
                                                                    <g id="XMLID_729_">
                                                                        <g class="st16">
                                                                            <g id="XMLID_731_">
                                                                                <polygon id="XMLID_1845_" class="st36" points="202.6,233.1 202.6,233.6 204.4,234.7 204.4,234.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_732_">
                                                                                <polygon id="XMLID_1844_" class="st31" points="204.4,234.1 204.4,234.7 206.2,233.7 206.2,233.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_733_">
                                                                                <polygon id="XMLID_1843_" class="st32" points="202.6,233.1 204.4,234.1 206.2,233.1 204.4,232        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_734_">
                                                                                <polygon id="XMLID_1842_" class="st36" points="200.3,234.4 200.3,235 202.1,236 202.1,235.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_735_">
                                                                                <polygon id="XMLID_1841_" class="st31" points="202.1,235.4 202.1,236 203.9,235 203.9,234.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_736_">
                                                                                <polygon id="XMLID_1726_" class="st32" points="200.3,234.4 202.1,235.4 203.9,234.4 202.1,233.4        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_737_">
                                                                                <polygon id="XMLID_1840_" class="st36" points="198,235.7 198,236.3 199.8,237.3 199.8,236.8        "/>
                                                                            </g>
                                                                            <g id="XMLID_738_">
                                                                                <polygon id="XMLID_1839_" class="st31" points="199.8,236.8 199.8,237.3 201.6,236.3 201.6,235.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_739_">
                                                                                <polygon id="XMLID_1727_" class="st32" points="198,235.7 199.8,236.8 201.6,235.7 199.8,234.7        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_740_">
                                                                                <polygon id="XMLID_1838_" class="st36" points="195.8,237 195.8,237.6 197.6,238.7 197.6,238.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_741_">
                                                                                <polygon id="XMLID_1837_" class="st31" points="197.6,238.1 197.6,238.7 199.3,237.6 199.3,237.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_742_">
                                                                                <polygon id="XMLID_1729_" class="st32" points="195.8,237 197.6,238.1 199.3,237.1 197.5,236        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_743_">
                                                                                <polygon id="XMLID_1836_" class="st36" points="193.5,238.4 193.5,238.9 195.3,240 195.3,239.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_744_">
                                                                                <polygon id="XMLID_1835_" class="st31" points="195.3,239.4 195.3,240 197.1,239 197.1,238.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_745_">
                                                                                <polygon id="XMLID_1728_" class="st32" points="193.5,238.4 195.3,239.4 197.1,238.4 195.2,237.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_746_">
                                                                                <polygon id="XMLID_1834_" class="st36" points="191.2,239.7 191.2,240.3 193,241.3 193,240.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_747_">
                                                                                <polygon id="XMLID_1833_" class="st31" points="193,240.7 193,241.3 194.8,240.3 194.8,239.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_748_">
                                                                                <polygon id="XMLID_1730_" class="st32" points="191.2,239.7 193,240.7 194.8,239.7 193,238.6        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_749_">
                                                                                <polygon id="XMLID_1832_" class="st36" points="188.9,241 188.9,241.6 190.7,242.6 190.7,242        "/>
                                                                            </g>
                                                                            <g id="XMLID_750_">
                                                                                <polygon id="XMLID_1831_" class="st31" points="190.7,242 190.7,242.6 192.5,241.6 192.5,241        "/>
                                                                            </g>
                                                                            <g id="XMLID_751_">
                                                                                <polygon id="XMLID_1733_" class="st32" points="188.9,241 190.7,242 192.5,241 190.7,240        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_752_">
                                                                                <polygon id="XMLID_1830_" class="st36" points="186.6,242.3 186.6,242.9 188.4,243.9 188.4,243.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_753_">
                                                                                <polygon id="XMLID_1829_" class="st31" points="188.4,243.4 188.4,243.9 190.2,242.9 190.2,242.3        "/>
                                                                            </g>
                                                                            <g id="XMLID_754_">
                                                                                <polygon id="XMLID_1731_" class="st32" points="186.6,242.3 188.4,243.4 190.2,242.3 188.4,241.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_755_">
                                                                                <polygon id="XMLID_1828_" class="st36" points="184.3,243.6 184.3,244.2 186.1,245.3 186.1,244.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_756_">
                                                                                <polygon id="XMLID_1827_" class="st31" points="186.1,244.7 186.1,245.3 187.9,244.2 187.9,243.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_757_">
                                                                                <polygon id="XMLID_1732_" class="st32" points="184.3,243.6 186.1,244.7 187.9,243.7 186.1,242.6        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_758_">
                                                                                <polygon id="XMLID_1826_" class="st36" points="182,245 182,245.5 183.8,246.6 183.8,246        "/>
                                                                            </g>
                                                                            <g id="XMLID_759_">
                                                                                <polygon id="XMLID_1825_" class="st31" points="183.8,246 183.8,246.6 185.6,245.6 185.6,245        "/>
                                                                            </g>
                                                                            <g id="XMLID_760_">
                                                                                <polygon id="XMLID_1716_" class="st32" points="182,245 183.8,246 185.6,245 183.8,243.9        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_761_">
                                                                                <polygon id="XMLID_1824_" class="st36" points="177.5,247.6 177.5,248.2 179.3,249.2 179.3,248.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_762_">
                                                                                <polygon id="XMLID_1823_" class="st31" points="179.3,248.7 179.3,249.2 183.3,246.9 183.3,246.3        "/>
                                                                            </g>
                                                                            <g id="XMLID_763_">
                                                                                <polygon id="XMLID_1715_" class="st32" points="177.5,247.6 179.3,248.7 183.3,246.3 181.5,245.2        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_764_">
                                                                                <polygon id="XMLID_1822_" class="st36" points="202.6,235.7 202.6,236.3 204.4,237.4 204.4,236.8        "/>
                                                                            </g>
                                                                            <g id="XMLID_765_">
                                                                                <polygon id="XMLID_1821_" class="st31" points="204.4,236.8 204.4,237.4 208.5,235 208.5,234.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_766_">
                                                                                <polygon id="XMLID_1267_" class="st32" points="202.6,235.7 204.4,236.8 208.5,234.4 206.7,233.4        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_767_">
                                                                                <polygon id="XMLID_1820_" class="st36" points="200.3,237.1 200.3,237.6 202.2,238.7 202.2,238.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_768_">
                                                                                <polygon id="XMLID_1819_" class="st31" points="202.2,238.1 202.2,238.7 203.9,237.7 203.9,237.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_769_">
                                                                                <polygon id="XMLID_1725_" class="st32" points="200.3,237.1 202.2,238.1 203.9,237.1 202.1,236        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_770_">
                                                                                <polygon id="XMLID_1818_" class="st36" points="198.1,238.4 198.1,239 199.9,240 199.9,239.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_771_">
                                                                                <polygon id="XMLID_1817_" class="st31" points="199.9,239.4 199.9,240 201.7,239 201.7,238.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_772_">
                                                                                <polygon id="XMLID_1724_" class="st32" points="198.1,238.4 199.9,239.4 201.7,238.4 199.8,237.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_773_">
                                                                                <polygon id="XMLID_1816_" class="st36" points="195.8,239.7 195.8,240.3 197.6,241.3 197.6,240.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_774_">
                                                                                <polygon id="XMLID_1815_" class="st31" points="197.6,240.7 197.6,241.3 199.4,240.3 199.4,239.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_775_">
                                                                                <polygon id="XMLID_1723_" class="st32" points="195.8,239.7 197.6,240.7 199.4,239.7 197.6,238.7        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_776_">
                                                                                <polygon id="XMLID_1814_" class="st36" points="193.5,241 193.5,241.6 195.3,242.6 195.3,242.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_777_">
                                                                                <polygon id="XMLID_1813_" class="st31" points="195.3,242.1 195.3,242.6 197.1,241.6 197.1,241        "/>
                                                                            </g>
                                                                            <g id="XMLID_778_">
                                                                                <polygon id="XMLID_1722_" class="st32" points="193.5,241 195.3,242.1 197.1,241 195.3,240        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_779_">
                                                                                <polygon id="XMLID_1812_" class="st36" points="191.2,242.3 191.2,242.9 193,244 193,243.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_780_">
                                                                                <polygon id="XMLID_1811_" class="st31" points="193,243.4 193,244 194.8,242.9 194.8,242.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_781_">
                                                                                <polygon id="XMLID_1721_" class="st32" points="191.2,242.3 193,243.4 194.8,242.4 193,241.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_782_">
                                                                                <polygon id="XMLID_1810_" class="st36" points="188.9,243.7 188.9,244.2 190.7,245.3 190.7,244.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_783_">
                                                                                <polygon id="XMLID_1809_" class="st31" points="190.7,244.7 190.7,245.3 192.5,244.3 192.5,243.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_784_">
                                                                                <polygon id="XMLID_1720_" class="st32" points="188.9,243.7 190.7,244.7 192.5,243.7 190.7,242.6        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_785_">
                                                                                <polygon id="XMLID_1808_" class="st36" points="186.6,245 186.6,245.6 188.4,246.6 188.4,246        "/>
                                                                            </g>
                                                                            <g id="XMLID_786_">
                                                                                <polygon id="XMLID_1807_" class="st31" points="188.4,246 188.4,246.6 190.2,245.6 190.2,245        "/>
                                                                            </g>
                                                                            <g id="XMLID_787_">
                                                                                <polygon id="XMLID_1719_" class="st32" points="186.6,245 188.4,246 190.2,245 188.4,243.9        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_788_">
                                                                                <polygon id="XMLID_1806_" class="st36" points="184.3,246.3 184.3,246.9 186.1,247.9 186.1,247.3        "/>
                                                                            </g>
                                                                            <g id="XMLID_789_">
                                                                                <polygon id="XMLID_1805_" class="st31" points="186.1,247.3 186.1,247.9 187.9,246.9 187.9,246.3        "/>
                                                                            </g>
                                                                            <g id="XMLID_790_">
                                                                                <polygon id="XMLID_1718_" class="st32" points="184.3,246.3 186.1,247.3 187.9,246.3 186.1,245.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_791_">
                                                                                <polygon id="XMLID_1804_" class="st36" points="182,247.6 182,248.2 183.9,249.2 183.9,248.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_792_">
                                                                                <polygon id="XMLID_1803_" class="st31" points="183.9,248.7 183.9,249.2 185.6,248.2 185.6,247.6        "/>
                                                                            </g>
                                                                            <g id="XMLID_793_">
                                                                                <polygon id="XMLID_1717_" class="st32" points="182,247.6 183.9,248.7 185.6,247.6 183.8,246.6        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_794_">
                                                                                <polygon id="XMLID_1802_" class="st36" points="179.8,248.9 179.8,249.5 181.6,250.6 181.6,250        "/>
                                                                            </g>
                                                                            <g id="XMLID_795_">
                                                                                <polygon id="XMLID_1801_" class="st31" points="181.6,250 181.6,250.6 183.4,249.5 183.4,249        "/>
                                                                            </g>
                                                                            <g id="XMLID_796_">
                                                                                <polygon id="XMLID_1714_" class="st32" points="179.8,248.9 181.6,250 183.4,249 181.5,247.9        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_797_">
                                                                                <polygon id="XMLID_1800_" class="st36" points="204.9,237.1 204.9,237.7 206.7,238.7 206.7,238.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_798_">
                                                                                <polygon id="XMLID_1799_" class="st31" points="206.7,238.1 206.7,238.7 210.8,236.4 210.8,235.8        "/>
                                                                            </g>
                                                                            <g id="XMLID_799_">
                                                                                <polygon id="XMLID_1280_" class="st32" points="204.9,237.1 206.7,238.1 210.8,235.8 209,234.7        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_800_">
                                                                                <polygon id="XMLID_1798_" class="st36" points="202.7,238.4 202.7,239 204.5,240 204.5,239.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_801_">
                                                                                <polygon id="XMLID_1797_" class="st31" points="204.5,239.4 204.5,240 206.2,239 206.2,238.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_802_">
                                                                                <polygon id="XMLID_1741_" class="st32" points="202.7,238.4 204.5,239.4 206.2,238.4 204.4,237.4        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_803_">
                                                                                <polygon id="XMLID_1796_" class="st36" points="200.4,239.7 200.4,240.3 202.2,241.3 202.2,240.8        "/>
                                                                            </g>
                                                                            <g id="XMLID_804_">
                                                                                <polygon id="XMLID_1795_" class="st31" points="202.2,240.8 202.2,241.3 204,240.3 204,239.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_805_">
                                                                                <polygon id="XMLID_1740_" class="st32" points="200.4,239.7 202.2,240.8 204,239.7 202.2,238.7        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_806_">
                                                                                <polygon id="XMLID_1794_" class="st36" points="198.1,241 198.1,241.6 199.9,242.7 199.9,242.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_807_">
                                                                                <polygon id="XMLID_1793_" class="st31" points="199.9,242.1 199.9,242.7 201.7,241.6 201.7,241.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_808_">
                                                                                <polygon id="XMLID_1739_" class="st32" points="198.1,241 199.9,242.1 201.7,241.1 199.9,240        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_809_">
                                                                                <polygon id="XMLID_1792_" class="st36" points="195.8,242.4 195.8,242.9 197.6,244 197.6,243.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_810_">
                                                                                <polygon id="XMLID_1791_" class="st31" points="197.6,243.4 197.6,244 199.4,243 199.4,242.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_811_">
                                                                                <polygon id="XMLID_1738_" class="st32" points="195.8,242.4 197.6,243.4 199.4,242.4 197.6,241.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_812_">
                                                                                <polygon id="XMLID_1790_" class="st36" points="193.5,243.7 193.5,244.3 195.3,245.3 195.3,244.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_813_">
                                                                                <polygon id="XMLID_1789_" class="st31" points="195.3,244.7 195.3,245.3 197.1,244.3 197.1,243.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_814_">
                                                                                <polygon id="XMLID_1737_" class="st32" points="193.5,243.7 195.3,244.7 197.1,243.7 195.3,242.6        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_815_">
                                                                                <polygon id="XMLID_1788_" class="st36" points="191.2,245 191.2,245.6 193,246.6 193,246.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_816_">
                                                                                <polygon id="XMLID_1787_" class="st31" points="193,246.1 193,246.6 194.8,245.6 194.8,245        "/>
                                                                            </g>
                                                                            <g id="XMLID_817_">
                                                                                <polygon id="XMLID_1736_" class="st32" points="191.2,245 193,246.1 194.8,245 193,244        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_818_">
                                                                                <polygon id="XMLID_1786_" class="st36" points="188.9,246.3 188.9,246.9 190.7,247.9 190.7,247.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_819_">
                                                                                <polygon id="XMLID_1785_" class="st31" points="190.7,247.4 190.7,247.9 192.5,246.9 192.5,246.3        "/>
                                                                            </g>
                                                                            <g id="XMLID_820_">
                                                                                <polygon id="XMLID_1735_" class="st32" points="188.9,246.3 190.7,247.4 192.5,246.3 190.7,245.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_821_">
                                                                                <polygon id="XMLID_1784_" class="st36" points="186.6,247.6 186.6,248.2 188.5,249.3 188.5,248.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_822_">
                                                                                <polygon id="XMLID_1783_" class="st31" points="188.5,248.7 188.5,249.3 190.2,248.2 190.2,247.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_823_">
                                                                                <polygon id="XMLID_1734_" class="st32" points="186.6,247.6 188.5,248.7 190.2,247.7 188.4,246.6        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_824_">
                                                                                <polygon id="XMLID_1782_" class="st36" points="182.1,250.3 182.1,250.9 183.9,251.9 183.9,251.3        "/>
                                                                            </g>
                                                                            <g id="XMLID_825_">
                                                                                <polygon id="XMLID_1781_" class="st31" points="183.9,251.3 183.9,251.9 188,249.6 188,249        "/>
                                                                            </g>
                                                                            <g id="XMLID_826_">
                                                                                <polygon id="XMLID_1713_" class="st32" points="182.1,250.3 183.9,251.3 188,249 186.1,247.9        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_827_">
                                                                                <polygon id="XMLID_1780_" class="st36" points="205,239.7 205,240.3 206.8,241.4 206.8,240.8        "/>
                                                                            </g>
                                                                            <g id="XMLID_828_">
                                                                                <polygon id="XMLID_1779_" class="st31" points="206.8,240.8 206.8,241.4 213.1,237.7 213.1,237.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_829_">
                                                                                <polygon id="XMLID_1699_" class="st32" points="205,239.7 206.8,240.8 213.1,237.1 211.3,236.1        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_830_">
                                                                                <polygon id="XMLID_1778_" class="st36" points="202.7,241.1 202.7,241.6 204.5,242.7 204.5,242.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_831_">
                                                                                <polygon id="XMLID_1777_" class="st31" points="204.5,242.1 204.5,242.7 206.3,241.7 206.3,241.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_832_">
                                                                                <polygon id="XMLID_1743_" class="st32" points="202.7,241.1 204.5,242.1 206.3,241.1 204.5,240        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_833_">
                                                                                <polygon id="XMLID_1776_" class="st36" points="200.4,242.4 200.4,243 202.2,244 202.2,243.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_834_">
                                                                                <polygon id="XMLID_1775_" class="st31" points="202.2,243.4 202.2,244 204,243 204,242.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_835_">
                                                                                <polygon id="XMLID_1742_" class="st32" points="200.4,242.4 202.2,243.4 204,242.4 202.2,241.4        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_836_">
                                                                                <polygon id="XMLID_1774_" class="st36" points="198.1,243.7 198.1,244.3 199.9,245.3 199.9,244.8        "/>
                                                                            </g>
                                                                            <g id="XMLID_837_">
                                                                                <polygon id="XMLID_1773_" class="st31" points="199.9,244.8 199.9,245.3 201.7,244.3 201.7,243.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_838_">
                                                                                <polygon id="XMLID_1744_" class="st32" points="198.1,243.7 199.9,244.8 201.7,243.7 199.9,242.7        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_839_">
                                                                                <polygon id="XMLID_1772_" class="st36" points="195.8,245 195.8,245.6 197.6,246.6 197.6,246.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_840_">
                                                                                <polygon id="XMLID_1771_" class="st31" points="197.6,246.1 197.6,246.6 199.4,245.6 199.4,245        "/>
                                                                            </g>
                                                                            <g id="XMLID_841_">
                                                                                <polygon id="XMLID_1745_" class="st32" points="195.8,245 197.6,246.1 199.4,245 197.6,244        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_842_">
                                                                                <polygon id="XMLID_1770_" class="st36" points="193.5,246.3 193.5,246.9 195.3,248 195.3,247.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_843_">
                                                                                <polygon id="XMLID_1769_" class="st31" points="195.3,247.4 195.3,248 197.1,246.9 197.1,246.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_844_">
                                                                                <polygon id="XMLID_1746_" class="st32" points="193.5,246.3 195.3,247.4 197.1,246.4 195.3,245.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_845_">
                                                                                <polygon id="XMLID_1768_" class="st36" points="191.2,247.7 191.2,248.2 193,249.3 193,248.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_846_">
                                                                                <polygon id="XMLID_1767_" class="st31" points="193,248.7 193,249.3 194.8,248.3 194.8,247.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_847_">
                                                                                <polygon id="XMLID_1747_" class="st32" points="191.2,247.7 193,248.7 194.8,247.7 193,246.6        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_848_">
                                                                                <polygon id="XMLID_1766_" class="st36" points="189,249 189,249.6 190.8,250.6 190.8,250        "/>
                                                                            </g>
                                                                            <g id="XMLID_849_">
                                                                                <polygon id="XMLID_1765_" class="st31" points="190.8,250 190.8,250.6 192.5,249.6 192.5,249        "/>
                                                                            </g>
                                                                            <g id="XMLID_850_">
                                                                                <polygon id="XMLID_1712_" class="st32" points="189,249 190.8,250 192.5,249 190.7,248        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_851_">
                                                                                <polygon id="XMLID_1764_" class="st36" points="184.4,251.6 184.4,252.2 186.2,253.3 186.2,252.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_852_">
                                                                                <polygon id="XMLID_1763_" class="st31" points="186.2,252.7 186.2,253.3 190.3,250.9 190.3,250.3        "/>
                                                                            </g>
                                                                            <g id="XMLID_853_">
                                                                                <polygon id="XMLID_1711_" class="st32" points="184.4,251.6 186.2,252.7 190.3,250.3 188.5,249.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_854_">
                                                                                <polygon id="XMLID_1762_" class="st36" points="211.8,238.4 211.8,239 213.7,240.1 213.7,239.5        "/>
                                                                            </g>
                                                                            <g id="XMLID_855_">
                                                                                <polygon id="XMLID_1761_" class="st31" points="213.7,239.5 213.7,240.1 215.4,239 215.4,238.5        "/>
                                                                            </g>
                                                                            <g id="XMLID_856_">
                                                                                <polygon id="XMLID_1700_" class="st32" points="211.8,238.4 213.7,239.5 215.4,238.5 213.6,237.4        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_857_">
                                                                                <polygon id="XMLID_1760_" class="st36" points="209.6,239.8 209.6,240.3 211.4,241.4 211.4,240.8        "/>
                                                                            </g>
                                                                            <g id="XMLID_858_">
                                                                                <polygon id="XMLID_1759_" class="st31" points="211.4,240.8 211.4,241.4 213.2,240.4 213.1,239.8        "/>
                                                                            </g>
                                                                            <g id="XMLID_859_">
                                                                                <polygon id="XMLID_1701_" class="st32" points="209.6,239.8 211.4,240.8 213.1,239.8 211.3,238.7        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_860_">
                                                                                <polygon id="XMLID_1758_" class="st36" points="207.3,241.1 207.3,241.7 209.1,242.7 209.1,242.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_861_">
                                                                                <polygon id="XMLID_1757_" class="st31" points="209.1,242.1 209.1,242.7 210.9,241.7 210.9,241.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_862_">
                                                                                <polygon id="XMLID_1702_" class="st32" points="207.3,241.1 209.1,242.1 210.9,241.1 209.1,240        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_863_">
                                                                                <polygon id="XMLID_1756_" class="st36" points="195.8,247.7 195.8,248.3 197.6,249.3 197.6,248.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_864_">
                                                                                <polygon id="XMLID_1755_" class="st31" points="197.6,248.7 197.6,249.3 208.6,243 208.6,242.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_865_">
                                                                                <polygon id="XMLID_1703_" class="st32" points="195.8,247.7 197.6,248.7 208.6,242.4 206.8,241.4        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_866_">
                                                                                <polygon id="XMLID_1754_" class="st36" points="193.5,249 193.5,249.6 195.4,250.6 195.4,250.1        "/>
                                                                            </g>
                                                                            <g id="XMLID_867_">
                                                                                <polygon id="XMLID_1753_" class="st31" points="195.4,250.1 195.4,250.6 197.1,249.6 197.1,249        "/>
                                                                            </g>
                                                                            <g id="XMLID_868_">
                                                                                <polygon id="XMLID_1704_" class="st32" points="193.5,249 195.4,250.1 197.1,249 195.3,248        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_869_">
                                                                                <polygon id="XMLID_1752_" class="st36" points="191.3,250.3 191.3,250.9 193.1,251.9 193.1,251.4        "/>
                                                                            </g>
                                                                            <g id="XMLID_870_">
                                                                                <polygon id="XMLID_1751_" class="st31" points="193.1,251.4 193.1,251.9 194.9,250.9 194.9,250.3        "/>
                                                                            </g>
                                                                            <g id="XMLID_871_">
                                                                                <polygon id="XMLID_1707_" class="st32" points="191.3,250.3 193.1,251.4 194.9,250.3 193,249.3        "/>
                                                                            </g>
                                                                        </g>
                                                                        <g class="st16">
                                                                            <g id="XMLID_872_">
                                                                                <polygon id="XMLID_1750_" class="st36" points="186.7,253 186.7,253.5 188.5,254.6 188.5,254        "/>
                                                                            </g>
                                                                            <g id="XMLID_873_">
                                                                                <polygon id="XMLID_1749_" class="st31" points="188.5,254 188.5,254.6 192.6,252.2 192.6,251.7        "/>
                                                                            </g>
                                                                            <g id="XMLID_874_">
                                                                                <polygon id="XMLID_1710_" class="st32" points="186.7,253 188.5,254 192.6,251.7 190.8,250.6        "/>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g id="XMLID_903_">
                                                                    <g id="XMLID_904_">
                                                                        <polygon id="XMLID_1748_" class="st26" points="193.7,201.3 193.7,210.4 201.6,205.9 201.6,196.8      "/>
                                                                    </g>
                                                                    <g class="st16">
                                                                        <g id="XMLID_906_">
                                                                            <polygon id="XMLID_1697_" class="st32" points="186.1,209.1 186.1,209.5 191.9,206.2 191.9,205.8       "/>
                                                                        </g>
                                                                        <g id="XMLID_907_">
                                                                            <polygon id="XMLID_1696_" class="st32" points="186.1,208 186.1,208.3 191.9,205 191.9,204.7       "/>
                                                                        </g>
                                                                        <g id="XMLID_908_">
                                                                            <polygon id="XMLID_1695_" class="st32" points="186.1,206.8 186.1,207.2 191.8,203.9 191.8,203.5       "/>
                                                                        </g>
                                                                        <g id="XMLID_909_">
                                                                            <polygon id="XMLID_1694_" class="st32" points="186.1,205.7 186.1,206.1 191.8,202.8 191.8,202.4       "/>
                                                                        </g>
                                                                    </g>
                                                                    <g id="XMLID_905_">
                                                                        <polygon id="XMLID_1693_" class="st32" points="186.1,211.4 186.1,211.8 191.9,208.4 191.9,208.1      "/>
                                                                    </g>
                                                                    <g id="XMLID_910_">
                                                                        <polygon id="XMLID_1692_" class="st32" points="186.1,210.3 186.1,210.6 191.9,207.3 191.9,206.9      "/>
                                                                    </g>
                                                                    <g id="XMLID_911_">
                                                                        <polygon id="XMLID_1691_" class="st32" points="187.6,211.7 187.6,212 191.9,209.6 191.9,209.2      "/>
                                                                    </g>
                                                                    <g class="st16">
                                                                        <g id="XMLID_913_">
                                                                            <path id="XMLID_1690_" class="st30" d="M200.5,193.7c-0.2,0.1-0.3,0.3-0.3,0.5c0,0.2,0.1,0.2,0.3,0.2c0.2-0.1,0.3-0.3,0.3-0.5        C200.7,193.7,200.6,193.6,200.5,193.7z"/>
                                                                        </g>
                                                                        <g id="XMLID_914_">
                                                                            <path id="XMLID_915_" class="st32" d="M203,191.8c0.3-0.2,0.5,0,0.5,0.3l0,2.5c0-0.3-0.2-0.4-0.5-0.3l-18.2,10.5        c-0.3,0.2-0.5,0.5-0.5,0.8l0-2.5c0-0.3,0.2-0.7,0.5-0.9L203,191.8z M201.6,193.7c0.2-0.1,0.3-0.3,0.3-0.5        c0-0.2-0.1-0.2-0.3-0.2c-0.2,0.1-0.3,0.3-0.3,0.5C201.3,193.7,201.4,193.8,201.6,193.7 M200.5,194.4c0.2-0.1,0.3-0.3,0.3-0.5        c0-0.2-0.1-0.2-0.3-0.2c-0.2,0.1-0.3,0.3-0.3,0.5C200.2,194.4,200.3,194.4,200.5,194.4 M202.7,193.1c0.2-0.1,0.3-0.3,0.3-0.5        c0-0.2-0.1-0.2-0.3-0.2c-0.2,0.1-0.3,0.3-0.3,0.5C202.4,193.1,202.5,193.2,202.7,193.1"/>
                                                                        </g>
                                                                        <g id="XMLID_916_">
                                                                            <path id="XMLID_917_" class="st1" d="M203,194.3c0.3-0.2,0.5,0,0.5,0.3l0,11.9c0,0.3-0.2,0.7-0.5,0.8l-18.2,10.5        c-0.3,0.2-0.5,0-0.5-0.3l0-11.9c0-0.3,0.2-0.7,0.5-0.8L203,194.3z M193.7,210.4l7.9-4.6l0-9.1l-7.9,4.6L193.7,210.4         M186.1,210.6l5.7-3.3l0-0.4l-5.7,3.3L186.1,210.6 M186.1,207.2l5.7-3.3l0-0.4l-5.7,3.3L186.1,207.2 M186.1,208.3l5.7-3.3        l0-0.4l-5.7,3.3L186.1,208.3 M186.1,206.1l5.7-3.3l0-0.4l-5.7,3.3L186.1,206.1 M186.1,211.8l5.7-3.3l0-0.4l-5.7,3.3        L186.1,211.8 M186.1,209.5l5.7-3.3l0-0.4l-5.7,3.3L186.1,209.5 M187.6,212l4.3-2.5l0-0.4l-4.3,2.5L187.6,212"/>
                                                                        </g>
                                                                    </g>
                                                                    <g id="XMLID_912_">
                                                                        <path id="XMLID_1676_" class="st23" d="M202.7,192.5c-0.2,0.1-0.3,0.3-0.3,0.5c0,0.2,0.1,0.2,0.3,0.2c0.2-0.1,0.3-0.3,0.3-0.5       C202.9,192.4,202.8,192.4,202.7,192.5z"/>
                                                                    </g>
                                                                    <g id="XMLID_918_">
                                                                        <path id="XMLID_1675_" class="st26" d="M201.6,193.1c-0.2,0.1-0.3,0.3-0.3,0.5c0,0.2,0.1,0.2,0.3,0.2c0.2-0.1,0.3-0.3,0.3-0.5       C201.8,193.1,201.7,193,201.6,193.1z"/>
                                                                    </g>
                                                                </g>
                                                                <g id="XMLID_730_">
                                                                    <path id="XMLID_887_" class="st31" d="M232.1,230.7c0,0.1,0,0.1-0.1,0.2c0,0-3.7,2.1-3.7,2.1l-0.6-0.4c1-0.6,3.1-1.7,4.4-2.4      C232.1,230.3,232.1,230.5,232.1,230.7z"/>
                                                                    <path id="XMLID_886_" class="st37" d="M232.1,230.1c-1.2,0.7-3.3,1.8-4.4,2.4l-7.6-4.8c0.7-0.4,1.3-0.7,2-1.1      c1.2-0.7,2.6-1.6,4-1.8c1.1-0.1,2.2,0.3,3.1,0.8C230.1,226.2,231.8,227.3,232.1,230.1z"/>
                                                                    <path id="XMLID_883_" class="st36" d="M228.1,233c0.2,0.1,0.4,0,0.4-0.2c-0.1-3.2-2.2-4.2-3-4.7c-0.9-0.5-3.5-1.6-5.5-0.1      c-0.1,0.1-0.1,0.3,0,0.4C222.9,230,226.8,232.3,228.1,233z"/>
                                                                </g>
                                                            </g>
                                                            <g id="XMLID_919_">
                                                                <g id="XMLID_920_">
                                                                    <path id="XMLID_921_" class="st31" d="M122.9,176.4l-1.3,0.7c0.2-0.1,0.4-0.4,0.4-0.8l1.3-0.7      C123.3,176,123.1,176.3,122.9,176.4z"/>
                                                                    <g id="XMLID_922_">
                                                                        <path id="XMLID_923_" class="st31" d="M85.1,124.9l1.3-0.7c0.2-0.1,0.6-0.1,0.9,0.1L86,125C85.7,124.8,85.3,124.8,85.1,124.9z"/>
                                                                        <g id="XMLID_924_">
                                                                            <polygon id="XMLID_925_" class="st31" points="122.1,147.3 123.3,146.5 123.3,175.6 122,176.4       "/>
                                                                            <polygon id="XMLID_926_" class="st31" points="86,125 87.3,124.2 122,144.3 120.8,145       "/>
                                                                            <path id="XMLID_927_" class="st31" d="M120.8,145l1.3-0.7c0.7,0.4,1.3,1.4,1.3,2.2l-1.3,0.7        C122.1,146.5,121.5,145.5,120.8,145z"/>
                                                                            <path id="XMLID_928_" class="st35" d="M120.8,145c0.7,0.4,1.3,1.4,1.3,2.2l-0.1,29.1c0,0.8-0.6,1.1-1.3,0.7L85.9,157        c-0.7-0.4-1.3-1.4-1.3-2.2l0.1-29.1c0-0.8,0.6-1.2,1.3-0.7L120.8,145z"/>
                                                                            <polygon id="XMLID_1674_" class="st34" points="86,127.9 86,154.1 120.7,174.2 120.8,148       "/>
                                                                        </g>
                                                                    </g>
                                                                    <g id="XMLID_929_">
                                                                        <g id="XMLID_930_">
                                                                            <path id="XMLID_931_" class="st38" d="M121.2,177.9l0,1.5c0,0.3-0.2,0.5-0.5,0.7l0-1.5C121,178.4,121.2,178.1,121.2,177.9z"/>
                                                                            <path id="XMLID_932_" class="st38" d="M95.8,193l0,1.5c-0.7,0.4-1.9,0.4-2.6,0l0-1.5C93.9,193.4,95.1,193.4,95.8,193z"/>
                                                                            <path id="XMLID_933_" class="st38" d="M57.9,173.7l0-1.5c0,0.3,0.2,0.5,0.5,0.7l0,1.5C58.1,174.2,57.9,174,57.9,173.7z"/>
                                                                            <polygon id="XMLID_934_" class="st38" points="120.7,178.6 120.7,180.1 95.8,194.5 95.8,193       "/>
                                                                            <polygon id="XMLID_935_" class="st38" points="93.2,193 93.2,194.5 58.5,174.5 58.5,173       "/>
                                                                            <path id="XMLID_936_" class="st31" d="M120.7,177.1c0.7,0.4,0.7,1.1,0,1.5L95.8,193c-0.7,0.4-1.9,0.4-2.6,0L58.5,173        c-0.7-0.4-0.7-1.1,0-1.5L83.4,157c0.7-0.4,1.9-0.4,2.6,0L120.7,177.1z"/>
                                                                        </g>
                                                                        <g id="XMLID_937_">
                                                                            <g class="st16">
                                                                                <g id="XMLID_939_">
                                                                                    <path id="XMLID_940_" class="st32" d="M92.5,180.9l-12.8-7.4c-0.4-0.2-0.9-0.2-1.3,0l-6.6,3.8c-0.4,0.2-0.4,0.5,0,0.7          l12.8,7.4c0.4,0.2,0.9,0.2,1.3,0l6.6-3.8C92.9,181.4,92.9,181.1,92.5,180.9"/>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                        <g id="XMLID_938_">
                                                                            <g class="st16">
                                                                                <g id="XMLID_942_">
                                                                                    <polygon id="XMLID_943_" class="st35" points="86.3,159.3 86.3,159.7 84,161 84,160.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_944_">
                                                                                    <polygon id="XMLID_945_" class="st35" points="84,160.7 84,161 81.7,159.7 81.7,159.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_946_">
                                                                                    <polygon id="XMLID_947_" class="st15" points="86.3,159.3 84,160.7 81.7,159.3 84,158         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_948_">
                                                                                    <polygon id="XMLID_949_" class="st35" points="89.3,161 89.3,161.4 86.9,162.7 86.9,162.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_950_">
                                                                                    <polygon id="XMLID_951_" class="st35" points="86.9,162.4 86.9,162.7 84.6,161.4 84.6,161         "/>
                                                                                </g>
                                                                                <g id="XMLID_952_">
                                                                                    <polygon id="XMLID_953_" class="st15" points="89.3,161 86.9,162.4 84.6,161 87,159.7         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_954_">
                                                                                    <polygon id="XMLID_955_" class="st35" points="92.2,162.7 92.2,163.1 89.9,164.4 89.9,164.1         "/>
                                                                                </g>
                                                                                <g id="XMLID_956_">
                                                                                    <polygon id="XMLID_957_" class="st35" points="89.9,164.1 89.9,164.4 87.6,163.1 87.6,162.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_958_">
                                                                                    <polygon id="XMLID_959_" class="st15" points="92.2,162.7 89.9,164.1 87.6,162.7 89.9,161.4         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_960_">
                                                                                    <polygon id="XMLID_961_" class="st35" points="95.2,164.4 95.2,164.8 92.8,166.1 92.8,165.8         "/>
                                                                                </g>
                                                                                <g id="XMLID_962_">
                                                                                    <polygon id="XMLID_963_" class="st35" points="92.8,165.8 92.8,166.1 90.5,164.8 90.5,164.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_964_">
                                                                                    <polygon id="XMLID_965_" class="st15" points="95.2,164.4 92.8,165.8 90.5,164.4 92.9,163.1         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_966_">
                                                                                    <polygon id="XMLID_967_" class="st35" points="98.1,166.1 98.1,166.5 95.8,167.9 95.8,167.5         "/>
                                                                                </g>
                                                                                <g id="XMLID_968_">
                                                                                    <polygon id="XMLID_969_" class="st35" points="95.8,167.5 95.8,167.9 93.5,166.5 93.5,166.2         "/>
                                                                                </g>
                                                                                <g id="XMLID_970_">
                                                                                    <polygon id="XMLID_971_" class="st15" points="98.1,166.1 95.8,167.5 93.5,166.2 95.8,164.8         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_972_">
                                                                                    <polygon id="XMLID_973_" class="st35" points="101.1,167.8 101.1,168.2 98.7,169.6 98.7,169.2         "/>
                                                                                </g>
                                                                                <g id="XMLID_974_">
                                                                                    <polygon id="XMLID_975_" class="st35" points="98.7,169.2 98.7,169.6 96.4,168.2 96.4,167.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_976_">
                                                                                    <polygon id="XMLID_977_" class="st15" points="101.1,167.8 98.7,169.2 96.4,167.9 98.8,166.5         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_978_">
                                                                                    <polygon id="XMLID_979_" class="st35" points="104,169.5 104,169.9 101.7,171.3 101.7,170.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_980_">
                                                                                    <polygon id="XMLID_981_" class="st35" points="101.7,170.9 101.7,171.3 99.4,169.9 99.4,169.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_982_">
                                                                                    <polygon id="XMLID_983_" class="st15" points="104,169.5 101.7,170.9 99.4,169.6 101.7,168.2         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_984_">
                                                                                    <polygon id="XMLID_985_" class="st35" points="107,171.2 107,171.6 104.6,173 104.6,172.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_986_">
                                                                                    <polygon id="XMLID_987_" class="st35" points="104.6,172.6 104.6,173 102.3,171.6 102.3,171.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_988_">
                                                                                    <polygon id="XMLID_989_" class="st15" points="107,171.2 104.6,172.6 102.3,171.3 104.7,169.9         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_990_">
                                                                                    <polygon id="XMLID_991_" class="st35" points="109.9,172.9 109.9,173.3 107.6,174.7 107.6,174.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_992_">
                                                                                    <polygon id="XMLID_993_" class="st35" points="107.6,174.3 107.6,174.7 105.3,173.3 105.3,173         "/>
                                                                                </g>
                                                                                <g id="XMLID_994_">
                                                                                    <polygon id="XMLID_995_" class="st15" points="109.9,172.9 107.6,174.3 105.3,173 107.6,171.6         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_996_">
                                                                                    <polygon id="XMLID_997_" class="st35" points="112.9,174.6 112.9,175 110.5,176.4 110.5,176         "/>
                                                                                </g>
                                                                                <g id="XMLID_998_">
                                                                                    <polygon id="XMLID_999_" class="st35" points="110.5,176 110.5,176.4 108.2,175 108.2,174.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_1000_">
                                                                                    <polygon id="XMLID_1001_" class="st15" points="112.9,174.6 110.5,176 108.2,174.7 110.6,173.3         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1002_">
                                                                                    <polygon id="XMLID_1003_" class="st35" points="118.8,178 118.8,178.4 116.4,179.8 116.4,179.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1004_">
                                                                                    <polygon id="XMLID_1005_" class="st35" points="116.4,179.4 116.4,179.8 111.2,176.7 111.2,176.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1006_">
                                                                                    <polygon id="XMLID_1007_" class="st15" points="118.8,178 116.4,179.4 111.2,176.4 113.5,175         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1008_">
                                                                                    <polygon id="XMLID_1009_" class="st35" points="86.3,162.7 86.3,163.1 84,164.5 84,164.1         "/>
                                                                                </g>
                                                                                <g id="XMLID_1010_">
                                                                                    <polygon id="XMLID_1011_" class="st35" points="84,164.1 84,164.5 78.7,161.4 78.7,161.1         "/>
                                                                                </g>
                                                                                <g id="XMLID_1012_">
                                                                                    <polygon id="XMLID_1013_" class="st15" points="86.3,162.7 84,164.1 78.7,161.1 81,159.7         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1014_">
                                                                                    <polygon id="XMLID_1015_" class="st35" points="89.2,164.4 89.2,164.8 86.9,166.2 86.9,165.8         "/>
                                                                                </g>
                                                                                <g id="XMLID_1016_">
                                                                                    <polygon id="XMLID_1017_" class="st35" points="86.9,165.8 86.9,166.2 84.6,164.8 84.6,164.5         "/>
                                                                                </g>
                                                                                <g id="XMLID_1018_">
                                                                                    <polygon id="XMLID_1019_" class="st15" points="89.2,164.4 86.9,165.8 84.6,164.5 86.9,163.1         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1020_">
                                                                                    <polygon id="XMLID_1021_" class="st35" points="92.2,166.2 92.2,166.5 89.9,167.9 89.9,167.5         "/>
                                                                                </g>
                                                                                <g id="XMLID_1022_">
                                                                                    <polygon id="XMLID_1023_" class="st35" points="89.9,167.5 89.9,167.9 87.6,166.5 87.6,166.2         "/>
                                                                                </g>
                                                                                <g id="XMLID_1024_">
                                                                                    <polygon id="XMLID_1025_" class="st15" points="92.2,166.2 89.9,167.5 87.6,166.2 89.9,164.8         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1026_">
                                                                                    <polygon id="XMLID_1027_" class="st35" points="95.1,167.9 95.1,168.2 92.8,169.6 92.8,169.2         "/>
                                                                                </g>
                                                                                <g id="XMLID_1028_">
                                                                                    <polygon id="XMLID_1029_" class="st35" points="92.8,169.2 92.8,169.6 90.5,168.2 90.5,167.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_1030_">
                                                                                    <polygon id="XMLID_1031_" class="st15" points="95.1,167.9 92.8,169.2 90.5,167.9 92.8,166.5         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1032_">
                                                                                    <polygon id="XMLID_1033_" class="st35" points="98.1,169.6 98.1,169.9 95.8,171.3 95.8,170.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_1034_">
                                                                                    <polygon id="XMLID_1035_" class="st35" points="95.8,170.9 95.8,171.3 93.5,170 93.5,169.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_1036_">
                                                                                    <polygon id="XMLID_1037_" class="st15" points="98.1,169.6 95.8,170.9 93.5,169.6 95.8,168.2         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1038_">
                                                                                    <polygon id="XMLID_1039_" class="st35" points="101,171.3 101,171.6 98.7,173 98.7,172.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_1040_">
                                                                                    <polygon id="XMLID_1041_" class="st35" points="98.7,172.6 98.7,173 96.4,171.7 96.4,171.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1042_">
                                                                                    <polygon id="XMLID_1043_" class="st15" points="101,171.3 98.7,172.6 96.4,171.3 98.7,169.9         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1044_">
                                                                                    <polygon id="XMLID_1045_" class="st35" points="104,173 104,173.3 101.7,174.7 101.7,174.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1046_">
                                                                                    <polygon id="XMLID_1047_" class="st35" points="101.7,174.3 101.7,174.7 99.4,173.4 99.4,173         "/>
                                                                                </g>
                                                                                <g id="XMLID_1048_">
                                                                                    <polygon id="XMLID_1049_" class="st15" points="104,173 101.7,174.3 99.4,173 101.7,171.6         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1050_">
                                                                                    <polygon id="XMLID_1051_" class="st35" points="106.9,174.7 106.9,175 104.6,176.4 104.6,176         "/>
                                                                                </g>
                                                                                <g id="XMLID_1052_">
                                                                                    <polygon id="XMLID_1053_" class="st35" points="104.6,176 104.6,176.4 102.3,175.1 102.3,174.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_1054_">
                                                                                    <polygon id="XMLID_1055_" class="st15" points="106.9,174.7 104.6,176 102.3,174.7 104.6,173.3         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1056_">
                                                                                    <polygon id="XMLID_1057_" class="st35" points="109.9,176.4 109.9,176.7 107.6,178.1 107.6,177.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_1058_">
                                                                                    <polygon id="XMLID_1059_" class="st35" points="107.6,177.7 107.6,178.1 105.3,176.8 105.3,176.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1060_">
                                                                                    <polygon id="XMLID_1061_" class="st15" points="109.9,176.4 107.6,177.7 105.3,176.4 107.6,175         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1062_">
                                                                                    <polygon id="XMLID_1063_" class="st35" points="112.8,178.1 112.8,178.4 110.5,179.8 110.5,179.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1064_">
                                                                                    <polygon id="XMLID_1065_" class="st35" points="110.5,179.4 110.5,179.8 108.2,178.5 108.2,178.1         "/>
                                                                                </g>
                                                                                <g id="XMLID_1066_">
                                                                                    <polygon id="XMLID_1067_" class="st15" points="112.8,178.1 110.5,179.4 108.2,178.1 110.5,176.7         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1068_">
                                                                                    <polygon id="XMLID_1069_" class="st35" points="115.8,179.8 115.8,180.1 113.5,181.5 113.5,181.1         "/>
                                                                                </g>
                                                                                <g id="XMLID_1070_">
                                                                                    <polygon id="XMLID_1071_" class="st35" points="113.5,181.1 113.5,181.5 111.1,180.2 111.1,179.8         "/>
                                                                                </g>
                                                                                <g id="XMLID_1072_">
                                                                                    <polygon id="XMLID_1073_" class="st15" points="115.8,179.8 113.5,181.1 111.1,179.8 113.5,178.4         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1074_">
                                                                                    <polygon id="XMLID_1075_" class="st35" points="83.3,164.5 83.3,164.8 81,166.2 81,165.8         "/>
                                                                                </g>
                                                                                <g id="XMLID_1076_">
                                                                                    <polygon id="XMLID_1077_" class="st35" points="81,165.8 81,166.2 75.7,163.2 75.7,162.8         "/>
                                                                                </g>
                                                                                <g id="XMLID_1078_">
                                                                                    <polygon id="XMLID_1079_" class="st15" points="83.3,164.5 81,165.8 75.7,162.8 78.1,161.4         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1080_">
                                                                                    <polygon id="XMLID_1081_" class="st35" points="86.3,166.2 86.3,166.5 83.9,167.9 83.9,167.5         "/>
                                                                                </g>
                                                                                <g id="XMLID_1082_">
                                                                                    <polygon id="XMLID_1083_" class="st35" points="83.9,167.5 83.9,167.9 81.6,166.6 81.6,166.2         "/>
                                                                                </g>
                                                                                <g id="XMLID_1084_">
                                                                                    <polygon id="XMLID_1085_" class="st15" points="86.3,166.2 83.9,167.5 81.6,166.2 84,164.8         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1086_">
                                                                                    <polygon id="XMLID_1087_" class="st35" points="89.2,167.9 89.2,168.2 86.9,169.6 86.9,169.2         "/>
                                                                                </g>
                                                                                <g id="XMLID_1088_">
                                                                                    <polygon id="XMLID_1089_" class="st35" points="86.9,169.2 86.9,169.6 84.6,168.3 84.6,167.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_1090_">
                                                                                    <polygon id="XMLID_1091_" class="st15" points="89.2,167.9 86.9,169.2 84.6,167.9 86.9,166.5         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1092_">
                                                                                    <polygon id="XMLID_1093_" class="st35" points="92.2,169.6 92.2,170 89.8,171.3 89.8,170.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_1094_">
                                                                                    <polygon id="XMLID_1095_" class="st35" points="89.8,170.9 89.8,171.3 87.5,170 87.5,169.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_1096_">
                                                                                    <polygon id="XMLID_1097_" class="st15" points="92.2,169.6 89.8,170.9 87.5,169.6 89.9,168.3         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1098_">
                                                                                    <polygon id="XMLID_1099_" class="st35" points="95.1,171.3 95.1,171.7 92.8,173 92.8,172.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_1100_">
                                                                                    <polygon id="XMLID_1101_" class="st35" points="92.8,172.6 92.8,173 90.5,171.7 90.5,171.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1102_">
                                                                                    <polygon id="XMLID_1103_" class="st15" points="95.1,171.3 92.8,172.6 90.5,171.3 92.8,170         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1104_">
                                                                                    <polygon id="XMLID_1105_" class="st35" points="98.1,173 98.1,173.4 95.7,174.7 95.7,174.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1106_">
                                                                                    <polygon id="XMLID_1107_" class="st35" points="95.7,174.3 95.7,174.7 93.4,173.4 93.4,173         "/>
                                                                                </g>
                                                                                <g id="XMLID_1108_">
                                                                                    <polygon id="XMLID_1109_" class="st15" points="98.1,173 95.7,174.3 93.4,173 95.8,171.7         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1110_">
                                                                                    <polygon id="XMLID_1111_" class="st35" points="101,174.7 101,175.1 98.7,176.4 98.7,176         "/>
                                                                                </g>
                                                                                <g id="XMLID_1112_">
                                                                                    <polygon id="XMLID_1113_" class="st35" points="98.7,176 98.7,176.4 96.4,175.1 96.4,174.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_1114_">
                                                                                    <polygon id="XMLID_1115_" class="st15" points="101,174.7 98.7,176 96.4,174.7 98.7,173.4         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1116_">
                                                                                    <polygon id="XMLID_1117_" class="st35" points="104,176.4 104,176.8 101.6,178.1 101.6,177.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_1118_">
                                                                                    <polygon id="XMLID_1119_" class="st35" points="101.6,177.7 101.6,178.1 99.3,176.8 99.3,176.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1120_">
                                                                                    <polygon id="XMLID_1121_" class="st15" points="104,176.4 101.6,177.7 99.3,176.4 101.7,175.1         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1122_">
                                                                                    <polygon id="XMLID_1123_" class="st35" points="106.9,178.1 106.9,178.5 104.6,179.8 104.6,179.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1124_">
                                                                                    <polygon id="XMLID_1125_" class="st35" points="104.6,179.4 104.6,179.8 102.3,178.5 102.3,178.1         "/>
                                                                                </g>
                                                                                <g id="XMLID_1126_">
                                                                                    <polygon id="XMLID_1127_" class="st15" points="106.9,178.1 104.6,179.4 102.3,178.1 104.6,176.8         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1128_">
                                                                                    <polygon id="XMLID_1129_" class="st35" points="112.8,181.5 112.8,181.9 110.5,183.2 110.5,182.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_1130_">
                                                                                    <polygon id="XMLID_1131_" class="st35" points="110.5,182.9 110.5,183.2 105.2,180.2 105.2,179.8         "/>
                                                                                </g>
                                                                                <g id="XMLID_1132_">
                                                                                    <polygon id="XMLID_1133_" class="st15" points="112.8,181.5 110.5,182.9 105.2,179.8 107.6,178.5         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1134_">
                                                                                    <polygon id="XMLID_1135_" class="st35" points="83.3,167.9 83.3,168.3 81,169.6 81,169.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1136_">
                                                                                    <polygon id="XMLID_1137_" class="st35" points="81,169.3 81,169.6 72.8,164.9 72.8,164.5         "/>
                                                                                </g>
                                                                                <g id="XMLID_1138_">
                                                                                    <polygon id="XMLID_1139_" class="st15" points="83.3,167.9 81,169.3 72.8,164.5 75.1,163.2         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1140_">
                                                                                    <polygon id="XMLID_1141_" class="st35" points="86.2,169.6 86.2,170 83.9,171.3 83.9,171         "/>
                                                                                </g>
                                                                                <g id="XMLID_1142_">
                                                                                    <polygon id="XMLID_1143_" class="st35" points="83.9,171 83.9,171.3 81.6,170 81.6,169.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_1144_">
                                                                                    <polygon id="XMLID_1145_" class="st15" points="86.2,169.6 83.9,171 81.6,169.6 83.9,168.3         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1146_">
                                                                                    <polygon id="XMLID_1147_" class="st35" points="89.2,171.3 89.2,171.7 86.9,173 86.9,172.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_1148_">
                                                                                    <polygon id="XMLID_1149_" class="st35" points="86.9,172.7 86.9,173 84.6,171.7 84.6,171.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1150_">
                                                                                    <polygon id="XMLID_1151_" class="st15" points="89.2,171.3 86.9,172.7 84.6,171.3 86.9,170         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1152_">
                                                                                    <polygon id="XMLID_1153_" class="st35" points="92.1,173 92.1,173.4 89.8,174.7 89.8,174.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1154_">
                                                                                    <polygon id="XMLID_1155_" class="st35" points="89.8,174.4 89.8,174.7 87.5,173.4 87.5,173         "/>
                                                                                </g>
                                                                                <g id="XMLID_1156_">
                                                                                    <polygon id="XMLID_1157_" class="st15" points="92.1,173 89.8,174.4 87.5,173 89.8,171.7         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1158_">
                                                                                    <polygon id="XMLID_1159_" class="st35" points="95.1,174.7 95.1,175.1 92.8,176.4 92.8,176.1         "/>
                                                                                </g>
                                                                                <g id="XMLID_1160_">
                                                                                    <polygon id="XMLID_1161_" class="st35" points="92.8,176.1 92.8,176.4 90.5,175.1 90.5,174.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_1162_">
                                                                                    <polygon id="XMLID_1163_" class="st15" points="95.1,174.7 92.8,176.1 90.5,174.7 92.8,173.4         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1164_">
                                                                                    <polygon id="XMLID_1165_" class="st35" points="98,176.4 98,176.8 95.7,178.1 95.7,177.8         "/>
                                                                                </g>
                                                                                <g id="XMLID_1166_">
                                                                                    <polygon id="XMLID_1167_" class="st35" points="95.7,177.8 95.7,178.1 93.4,176.8 93.4,176.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1168_">
                                                                                    <polygon id="XMLID_1169_" class="st15" points="98,176.4 95.7,177.8 93.4,176.4 95.7,175.1         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1170_">
                                                                                    <polygon id="XMLID_1171_" class="st35" points="101,178.1 101,178.5 98.7,179.8 98.7,179.5         "/>
                                                                                </g>
                                                                                <g id="XMLID_1172_">
                                                                                    <polygon id="XMLID_1173_" class="st35" points="98.7,179.5 98.7,179.8 96.4,178.5 96.4,178.1         "/>
                                                                                </g>
                                                                                <g id="XMLID_1174_">
                                                                                    <polygon id="XMLID_1175_" class="st15" points="101,178.1 98.7,179.5 96.4,178.1 98.7,176.8         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1176_">
                                                                                    <polygon id="XMLID_1177_" class="st35" points="103.9,179.8 103.9,180.2 101.6,181.5 101.6,181.2         "/>
                                                                                </g>
                                                                                <g id="XMLID_1178_">
                                                                                    <polygon id="XMLID_1179_" class="st35" points="101.6,181.2 101.6,181.5 99.3,180.2 99.3,179.8         "/>
                                                                                </g>
                                                                                <g id="XMLID_1180_">
                                                                                    <polygon id="XMLID_1181_" class="st15" points="103.9,179.8 101.6,181.2 99.3,179.8 101.6,178.5         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1182_">
                                                                                    <polygon id="XMLID_1183_" class="st35" points="109.8,183.2 109.8,183.6 107.5,185 107.5,184.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_1184_">
                                                                                    <polygon id="XMLID_1185_" class="st35" points="107.5,184.6 107.5,185 102.3,181.9 102.3,181.5         "/>
                                                                                </g>
                                                                                <g id="XMLID_1186_">
                                                                                    <polygon id="XMLID_1187_" class="st15" points="109.8,183.2 107.5,184.6 102.3,181.5 104.6,180.2         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1188_">
                                                                                    <polygon id="XMLID_1189_" class="st35" points="74.4,166.2 74.4,166.6 72.1,168 72.1,167.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_1190_">
                                                                                    <polygon id="XMLID_1191_" class="st35" points="72.1,167.6 72.1,168 69.8,166.6 69.8,166.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1192_">
                                                                                    <polygon id="XMLID_1193_" class="st15" points="74.4,166.2 72.1,167.6 69.8,166.3 72.1,164.9         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1194_">
                                                                                    <polygon id="XMLID_1195_" class="st35" points="77.4,167.9 77.4,168.3 75,169.7 75,169.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1196_">
                                                                                    <polygon id="XMLID_1197_" class="st35" points="75,169.3 75,169.7 72.7,168.3 72.7,168         "/>
                                                                                </g>
                                                                                <g id="XMLID_1198_">
                                                                                    <polygon id="XMLID_1199_" class="st15" points="77.4,167.9 75,169.3 72.7,168 75.1,166.6         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1200_">
                                                                                    <polygon id="XMLID_1201_" class="st35" points="80.3,169.6 80.3,170 78,171.4 78,171         "/>
                                                                                </g>
                                                                                <g id="XMLID_1202_">
                                                                                    <polygon id="XMLID_1203_" class="st35" points="78,171 78,171.4 75.7,170 75.7,169.7         "/>
                                                                                </g>
                                                                                <g id="XMLID_1204_">
                                                                                    <polygon id="XMLID_1205_" class="st15" points="80.3,169.6 78,171 75.7,169.7 78,168.3         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1206_">
                                                                                    <polygon id="XMLID_1207_" class="st35" points="95.1,178.1 95.1,178.5 92.7,179.9 92.7,179.5         "/>
                                                                                </g>
                                                                                <g id="XMLID_1208_">
                                                                                    <polygon id="XMLID_1209_" class="st35" points="92.7,179.5 92.7,179.9 78.6,171.7 78.6,171.4         "/>
                                                                                </g>
                                                                                <g id="XMLID_1210_">
                                                                                    <polygon id="XMLID_1211_" class="st15" points="95.1,178.1 92.7,179.5 78.6,171.4 81,170         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1212_">
                                                                                    <polygon id="XMLID_1213_" class="st35" points="98,179.8 98,180.2 95.7,181.6 95.7,181.2         "/>
                                                                                </g>
                                                                                <g id="XMLID_1214_">
                                                                                    <polygon id="XMLID_1215_" class="st35" points="95.7,181.2 95.7,181.6 93.4,180.2 93.4,179.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_1216_">
                                                                                    <polygon id="XMLID_1217_" class="st15" points="98,179.8 95.7,181.2 93.4,179.9 95.7,178.5         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1218_">
                                                                                    <polygon id="XMLID_1219_" class="st35" points="101,181.5 101,181.9 98.6,183.3 98.6,182.9         "/>
                                                                                </g>
                                                                                <g id="XMLID_1220_">
                                                                                    <polygon id="XMLID_1221_" class="st35" points="98.6,182.9 98.6,183.3 96.3,182 96.3,181.6         "/>
                                                                                </g>
                                                                                <g id="XMLID_1222_">
                                                                                    <polygon id="XMLID_1223_" class="st15" points="101,181.5 98.6,182.9 96.3,181.6 98.7,180.2         "/>
                                                                                </g>
                                                                            </g>
                                                                            <g class="st16">
                                                                                <g id="XMLID_1224_">
                                                                                    <polygon id="XMLID_1225_" class="st35" points="106.9,185 106.9,185.3 104.5,186.7 104.5,186.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1226_">
                                                                                    <polygon id="XMLID_1227_" class="st35" points="104.5,186.3 104.5,186.7 99.3,183.7 99.3,183.3         "/>
                                                                                </g>
                                                                                <g id="XMLID_1228_">
                                                                                    <polygon id="XMLID_1229_" class="st15" points="106.9,185 104.5,186.3 99.3,183.3 101.6,181.9         "/>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g id="XMLID_941_">
                                                                    <polygon id="XMLID_1673_" class="st1" points="90,153 116.9,168.5 116.9,149.1 116.9,149.1 90,133.6     "/>
                                                                    <polygon id="XMLID_1672_" class="st34" points="115.1,151 105.5,145.4 105.5,158.9 115.1,164.5     "/>
                                                                    <g id="XMLID_1230_">
                                                                        <polygon id="XMLID_1671_" class="st15" points="92.7,138.8 103.5,145 103.5,144.3 92.7,138      "/>
                                                                        <polygon id="XMLID_1670_" class="st15" points="92.7,140.7 103.5,146.9 103.5,146.1 92.7,139.9      "/>
                                                                        <polygon id="XMLID_1669_" class="st15" points="92.7,142.5 103.5,148.7 103.5,147.9 92.7,141.7      "/>
                                                                        <polygon id="XMLID_1668_" class="st15" points="92.7,144.3 103.5,150.5 103.5,149.7 92.7,143.5      "/>
                                                                        <polygon id="XMLID_1667_" class="st15" points="92.7,146.1 103.5,152.4 103.5,151.6 92.7,145.3      "/>
                                                                        <polygon id="XMLID_1666_" class="st15" points="92.7,148 103.5,154.2 103.5,153.4 92.7,147.2      "/>
                                                                        <polygon id="XMLID_1665_" class="st15" points="92.7,151.6 100.2,155.9 100.2,155.2 92.7,150.8      "/>
                                                                        <polygon id="XMLID_1664_" class="st15" points="92.7,149.8 103.5,156 103.5,155.2 92.7,149      "/>
                                                                    </g>
                                                                    <polygon id="XMLID_875_" class="st30" points="109.5,148.9 106.7,153 112.3,156.3     "/>
                                                                    <polygon id="XMLID_1663_" class="st26" points="111.8,151.4 108.9,155.5 114.6,158.8     "/>
                                                                    <path id="XMLID_876_" class="st23" d="M114,159.7c0,1.4-1,2-2.2,1.3c-1.2-0.7-2.2-2.4-2.2-3.8c0-1.4,1-2,2.2-1.3      C113,156.6,114,158.3,114,159.7z"/>
                                                                </g>
                                                            </g>
                                                            <g id="XMLID_1231_">
                                                                <g id="XMLID_1232_">
                                                                    <polygon id="XMLID_1662_" class="st39" points="213.2,106.1 216.1,109.4 217.5,107     "/>
                                                                    <polygon id="XMLID_1661_" class="st26" points="213.2,106.1 214,107 214.4,106.4     "/>
                                                                </g>
                                                                <path id="XMLID_1660_" class="st26" d="M217.5,107c-0.2-0.1-0.4-0.1-0.7,0.1c-0.6,0.3-1,1.1-1,1.8c0,0.3,0.1,0.5,0.3,0.7     l21.2,12.3c-0.2-0.1-0.3-0.3-0.3-0.7c0-0.6,0.5-1.4,1-1.8c0.3-0.2,0.5-0.2,0.7-0.1L217.5,107z"/>
                                                                <g id="XMLID_1233_">
                                                                    <path id="XMLID_1234_" class="st25" d="M238,119.4c0.6-0.3,1-0.1,1,0.6c0,0.6-0.5,1.4-1,1.8c-0.6,0.3-1,0.1-1-0.6      C237,120.5,237.4,119.7,238,119.4z"/>
                                                                </g>
                                                            </g>
                                                            <g id="XMLID_1235_">
                                                                <g id="XMLID_1236_">
                                                                    <polygon id="XMLID_1659_" class="st39" points="223.3,107.9 226.2,111.2 227.6,108.7     "/>
                                                                    <polygon id="XMLID_1658_" class="st23" points="223.3,107.9 224.1,108.8 224.5,108.1     "/>
                                                                </g>
                                                                <path id="XMLID_1657_" class="st23" d="M227.6,108.7c-0.2-0.1-0.4-0.1-0.7,0.1c-0.6,0.3-1,1.1-1,1.8c0,0.3,0.1,0.5,0.3,0.7     l13.7,8c-0.2-0.1-0.3-0.3-0.3-0.7c0-0.6,0.5-1.4,1-1.8c0.3-0.2,0.5-0.2,0.7-0.1L227.6,108.7z"/>
                                                                <g id="XMLID_1237_">
                                                                    <path id="XMLID_1238_" class="st21" d="M240.6,116.7c0.6-0.3,1-0.1,1,0.6c0,0.6-0.5,1.4-1,1.8c-0.6,0.3-1,0.1-1-0.6      C239.6,117.9,240,117.1,240.6,116.7z"/>
                                                                </g>
                                                            </g>
                                                            <g id="XMLID_1239_">
                                                                <path id="XMLID_1656_" class="st25" d="M209.7,112.5c-0.1-0.1-0.2-0.2-0.2-0.3l0,2.7c0,0.1,0.1,0.2,0.2,0.3l3,1.7l0-2.7     L209.7,112.5z"/>
                                                                <polygon id="XMLID_1240_" class="st40" points="216.7,111.9 216.7,114.6 212.7,116.9 212.7,114.3    "/>
                                                                <path id="XMLID_1241_" class="st26" d="M216.7,111.9l-4,2.3l-3-1.7c-0.3-0.2-0.3-0.4,0-0.6l3-1.7c0.3-0.2,0.7-0.2,1,0     L216.7,111.9z"/>
                                                                <polygon id="XMLID_1242_" class="st37" points="218.8,113.1 218.8,115.8 214.8,118.1 214.8,115.5    "/>
                                                                <polygon id="XMLID_1243_" class="st41" points="214.8,115.5 214.8,118.1 212.7,116.9 212.7,114.3    "/>
                                                                <polygon id="XMLID_1244_" class="st39" points="218.8,113.1 214.8,115.5 212.7,114.3 216.7,111.9    "/>
                                                                <path id="XMLID_1655_" class="st21" d="M221.8,115.5l-3,1.7c-0.3,0.2-0.7,0.2-1,0l-3-1.7l0,2.7l3,1.7c0.3,0.2,0.7,0.2,1,0l3-1.7     c0.1-0.1,0.2-0.2,0.2-0.3l0-2.7C222,115.3,221.9,115.4,221.8,115.5z"/>
                                                                <path id="XMLID_1245_" class="st23" d="M221.8,114.9c0.3,0.2,0.3,0.4,0,0.6l-3,1.7c-0.3,0.2-0.7,0.2-1,0l-3-1.7l4-2.3     L221.8,114.9z"/>
                                                            </g>
                                                            <g id="XMLID_1246_">
                                                                <path id="XMLID_1654_" class="st39" d="M181.7,90l-42.5,24.6c-1,0.6-0.9,1.6,0.3,2.2L164,131c1.1,0.7,2.9,0.7,3.8,0.2l42.5-24.6     c1-0.6,0.9-1.6-0.3-2.2l-24.6-14.2C184.4,89.5,182.6,89.4,181.7,90z"/>
                                                                <g id="XMLID_1247_">
                                                                    <polygon id="XMLID_1653_" class="st42" points="185.4,97.9 188.2,96.3 204.5,105.7 201.7,107.3     "/>
                                                                    <polygon id="XMLID_1652_" class="st42" points="179.4,101.4 182.2,99.8 198.5,109.2 195.7,110.8     "/>
                                                                    <polygon id="XMLID_1651_" class="st42" points="173.4,104.8 176.2,103.2 192.5,112.6 189.7,114.2     "/>
                                                                    <polygon id="XMLID_1650_" class="st42" points="167.4,108.3 170.2,106.7 186.5,116.1 183.7,117.7     "/>
                                                                    <polygon id="XMLID_1647_" class="st42" points="161.5,111.7 164.3,110.1 180.5,119.5 177.7,121.1     "/>
                                                                </g>
                                                                <g id="XMLID_1248_">
                                                                    <polygon id="XMLID_1646_" class="st43" points="185.4,97.9 188.2,96.3 192.3,98.6 189.5,100.3     "/>
                                                                    <polygon id="XMLID_1645_" class="st30" points="179.4,101.4 182.2,99.8 191.7,105.2 188.9,106.8     "/>
                                                                    <polygon id="XMLID_1643_" class="st26" points="173.4,104.8 176.2,103.2 183.2,107.2 180.4,108.8     "/>
                                                                    <polygon id="XMLID_1642_" class="st15" points="167.4,108.3 170.2,106.7 182,113.4 179.2,115.1     "/>
                                                                    <polygon id="XMLID_1641_" class="st23" points="161.5,111.7 164.3,110.1 178.1,118.1 175.3,119.7     "/>
                                                                </g>
                                                                <g id="XMLID_1249_">
                                                                    <polygon id="XMLID_1639_" class="st42" points="173.9,122 164.8,127.2 166,127.9 175,122.7     "/>
                                                                    <polygon id="XMLID_1637_" class="st42" points="171.1,120.5 162.1,125.7 163.3,126.4 172.3,121.1     "/>
                                                                    <polygon id="XMLID_1626_" class="st42" points="168.4,118.9 159.4,124.1 160.6,124.8 169.6,119.6     "/>
                                                                    <polygon id="XMLID_1573_" class="st42" points="165.7,117.3 156.7,122.5 157.8,123.2 166.9,118     "/>
                                                                    <polygon id="XMLID_1572_" class="st42" points="163,115.8 154,121 155.1,121.7 164.2,116.4     "/>
                                                                    <polygon id="XMLID_1568_" class="st42" points="160.3,114.2 151.2,119.4 152.4,120.1 161.5,114.9     "/>
                                                                    <polygon id="XMLID_1564_" class="st42" points="154.9,111 148.6,114.7 149.7,115.4 156,111.7     "/>
                                                                    <polygon id="XMLID_1562_" class="st42" points="157.6,112.6 148.5,117.8 149.7,118.5 158.8,113.3     "/>
                                                                </g>
                                                                <polygon id="XMLID_1560_" class="st42" points="185.3,94.7 158.6,110.1 159.8,110.8 186.5,95.3    "/>
                                                            </g>
                                                            <g id="XMLID_1250_">
                                                                <polygon id="XMLID_1559_" class="st30" points="184,128 203,117 213.9,123.3 194.8,134.3    "/>
                                                                <polygon id="XMLID_1558_" class="st27" points="194.8,134.3 196.9,124.5 213.9,123.3    "/>
                                                                <polygon id="XMLID_1557_" class="st28" points="203,117 200.9,126.8 184,128    "/>
                                                            </g>
                                                            <g id="XMLID_1251_">
                                                                <polygon id="XMLID_1555_" class="st39" points="289.3,142.5 322.2,161.5 280.7,185.5 247.8,166.5    "/>
                                                                <g id="XMLID_1252_">
                                                                    <polygon id="XMLID_893_" class="st33" points="280.4,166.7 280.4,166.7 280.4,166.7     "/>
                                                                    <polygon id="XMLID_892_" class="st23" points="280.4,166.7 280.4,166.7 280.4,166.7     "/>
                                                                    <path id="XMLID_889_" class="st23" d="M280.4,166.7l-4.5-7.2c-1.8,0.4-3.5,1-4.9,1.8L280.4,166.7z"/>
                                                                    <path id="XMLID_885_" class="st25" d="M280.4,166.7l9.4-5.5c-3.8-2.2-9.3-2.8-14-1.8L280.4,166.7z"/>
                                                                    <path id="XMLID_884_" class="st23" d="M270.9,172.1l9.4-5.5l-13.2-1C266.6,168.1,268,170.4,270.9,172.1z"/>
                                                                    <path id="XMLID_882_" class="st26" d="M284.9,173.9c1.8-0.4,3.5-1,4.9-1.8c5.2-3,5.2-7.9,0-10.9l-9.4,5.5L284.9,173.9z"/>
                                                                    <path id="XMLID_881_" class="st30" d="M284.9,173.9l-4.5-7.2l-9.4,5.5C274.7,174.3,280.2,174.9,284.9,173.9z"/>
                                                                </g>
                                                                <path id="XMLID_1253_" class="st41" d="M307.2,165.9c-0.1,0-0.1,0-0.2-0.1l-24.8-14.3c-0.2-0.1-0.2-0.3-0.1-0.5     c0.1-0.2,0.3-0.2,0.5-0.1l24.8,14.3c0.2,0.1,0.2,0.3,0.1,0.5C307.5,165.8,307.3,165.9,307.2,165.9z"/>
                                                                <path id="XMLID_1254_" class="st41" d="M310.1,164.2c-0.1,0-0.1,0-0.2-0.1l-24.8-14.3c-0.2-0.1-0.2-0.3-0.1-0.5     c0.1-0.2,0.3-0.2,0.5-0.1l24.8,14.3c0.2,0.1,0.2,0.3,0.1,0.5C310.4,164.1,310.2,164.2,310.1,164.2z"/>
                                                                <path id="XMLID_1255_" class="st41" d="M313,162.5c-0.1,0-0.1,0-0.2-0.1l-24.8-14.3c-0.2-0.1-0.2-0.3-0.1-0.5     c0.1-0.2,0.3-0.2,0.5-0.1l24.8,14.3c0.2,0.1,0.2,0.3,0.1,0.5C313.3,162.4,313.2,162.5,313,162.5z"/>
                                                            </g>
                                                            <g id="XMLID_1256_">
                                                                <g class="st16">
                                                                    <g id="XMLID_1258_">
                                                                        <path id="XMLID_1259_" class="st27" d="M315.5,187.1l0,4.6c0,0.6-0.4,1.2-1.2,1.7l0-4.6C315.1,188.3,315.5,187.7,315.5,187.1z"/>
                                                                    </g>
                                                                    <g id="XMLID_1260_">
                                                                        <path id="XMLID_1261_" class="st28" d="M269.1,191.7l0-4.6c0,0.6,0.4,1.2,1.2,1.7l0,4.6C269.5,192.9,269.1,192.3,269.1,191.7z"/>
                                                                    </g>
                                                                    <g id="XMLID_1262_">
                                                                        <polygon id="XMLID_1263_" class="st27" points="314.3,188.8 314.3,193.4 295.3,204.4 295.3,199.8      "/>
                                                                    </g>
                                                                    <g id="XMLID_1264_">
                                                                        <polygon id="XMLID_1265_" class="st28" points="289.4,199.8 289.4,204.4 270.3,193.4 270.3,188.8      "/>
                                                                    </g>
                                                                    <g id="XMLID_1266_">
                                                                        <path id="XMLID_1709_" class="st28" d="M295.3,199.8l0,4.6c-0.8,0.5-1.9,0.7-2.9,0.7s-2.1-0.2-2.9-0.7v-4.6       c0.8,0.5,1.9,0.7,2.9,0.7C293.4,200.5,294.5,200.3,295.3,199.8z"/>
                                                                    </g>
                                                                    <g id="XMLID_1268_">
                                                                        <path id="XMLID_1269_" class="st30" d="M314.3,185.4c1.6,0.9,1.6,2.5,0,3.4l-19,11c-1.6,0.9-4.2,0.9-5.9,0l-19.1-11       c-1.6-0.9-1.6-2.5,0-3.4l19-11c1.6-0.9,4.2-0.9,5.9,0L314.3,185.4z"/>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="XMLID_1257_">
                                                                <g class="st16">
                                                                    <g id="XMLID_1271_">
                                                                        <path id="XMLID_1272_" class="st20" d="M353.8,174l0,4.6c0,0.6-0.4,1.2-1.2,1.7l0-4.6C353.4,175.2,353.8,174.6,353.8,174z"/>
                                                                    </g>
                                                                    <g id="XMLID_1273_">
                                                                        <path id="XMLID_1274_" class="st22" d="M307.3,178.6l0-4.6c0,0.6,0.4,1.2,1.2,1.7l0,4.6C307.7,179.8,307.3,179.2,307.3,178.6z"/>
                                                                    </g>
                                                                    <g id="XMLID_1275_">
                                                                        <polygon id="XMLID_1276_" class="st20" points="352.6,175.7 352.6,180.3 333.6,191.3 333.6,186.7      "/>
                                                                    </g>
                                                                    <g id="XMLID_1277_">
                                                                        <polygon id="XMLID_1278_" class="st22" points="327.7,186.7 327.7,191.3 308.6,180.3 308.6,175.7      "/>
                                                                    </g>
                                                                    <g id="XMLID_1279_">
                                                                        <path id="XMLID_1708_" class="st20" d="M333.6,186.7v4.6c-0.8,0.5-1.9,0.7-2.9,0.7c-1.1,0-2.1-0.2-2.9-0.7l0-4.6       c0.8,0.5,1.9,0.7,2.9,0.7C331.7,187.4,332.8,187.2,333.6,186.7z"/>
                                                                    </g>
                                                                    <g id="XMLID_1281_">
                                                                        <path id="XMLID_1282_" class="st23" d="M352.6,172.3c1.6,0.9,1.6,2.5,0,3.4l-19,11c-1.6,0.9-4.2,0.9-5.9,0l-19.1-11       c-1.6-0.9-1.6-2.5,0-3.4l19-11c1.6-0.9,4.2-0.9,5.9,0L352.6,172.3z"/>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <text id="XMLID_880_" transform="matrix(-0.866 -0.5 0.866 -0.5 305.0286 190.3642)" class="st39 st44 st45">DATA</text>
                                                            <text id="XMLID_879_" transform="matrix(-0.866 -0.5 0.866 -0.5 345.2026 178.5547)" class="st39 st44 st46">DATA</text>
                                                            <path id="XMLID_1706_" class="st22" d="M330.7,187.4v4.6c-1.1,0-2.1-0.2-2.9-0.7l0-4.6C328.5,187.2,329.6,187.4,330.7,187.4z"/>
                                                            <path id="XMLID_1705_" class="st27" d="M295.3,199.8l0,4.6c-0.8,0.5-1.9,0.7-2.9,0.7v-4.6C293.4,200.5,294.5,200.3,295.3,199.8z"/>
                                                            <g id="XMLID_894_">
                                                                <g id="XMLID_1516_">
                                                                    <path id="XMLID_1534_" class="st8" d="M337.3,166.3c-3.7,1.6-7.1,13.9-5,18.2c2,4.3,5.2,4.6,9.2,3.6c4-1.1,8.6-6.4,10.1-11.3      C353.6,170.1,347.8,161.6,337.3,166.3z"/>
                                                                    <g id="XMLID_1521_">
                                                                        <g id="XMLID_1523_">
                                                                            <path id="XMLID_1533_" class="st2" d="M333,314.1v1c-1.9,1.1-6.3,0.5-7.4,0c-0.7-1.1-2.8-0.8-3.9-0.4        c-4.3,0.4-5.9-0.3-7.4-1.3c-0.7-0.5-2-1.9-1.9-3.4C317.6,311.1,333,314.1,333,314.1z"/>
                                                                            <path id="XMLID_1532_" class="st2" d="M325.6,306.6c0,0-4.7,1.3-7.5,1.7c-2.8,0.4-4.8-0.1-5.5,0.9c-0.7,1,0.8,3.6,3.3,4.5        c2.5,0.9,7.5-0.1,9.4,0.3c1.9,0.4,6.6,1.3,7.7,0.1c1.1-1.2,0-6.8,0-6.8L325.6,306.6z"/>
                                                                            <path id="XMLID_1531_" class="st2" d="M351.8,300.3l-8.5-9.5c-3.4-1-6.9-1.2-6.5,1.9c0.4,2.8,4.8,4,7.8,6.7l2.8,2.5        C349.5,303.7,352.1,302.2,351.8,300.3"/>
                                                                            <path id="XMLID_1530_" class="st8" d="M343.8,181.6c-0.3,0.4-0.7,0.7-1,1c-2.2,1.7-4.3,2.7-7,3.4c-0.4,0.1-0.9,0.2-1.4,0.3        l0.2,2.4c2.9,0.8,5.6-0.4,7.6-1c1.5-0.4,3.7-0.8,3.7-2.3L343.8,181.6L343.8,181.6z"/>
                                                                            <path id="XMLID_1528_" class="st2" d="M347.5,301.9l-2.8-2.5c-3-2.7-7.4-3.9-7.8-6.7l0,0v0l0,0v0l0,0v0l0,0l0,0v0v0l0,0v0v0        l0,0v0l0,0v0v0l0,0l0,0v0l0,0l0,0l0,0l0,0l0,0l0,0l0,0v0c0,0.3,0,0.6,0,0.9c0.4,2.8,4.8,4,7.8,6.7l2.8,2.5        c2.4,2.1,4.9,0.6,4.3-2.5C352.1,302.2,349.5,303.7,347.5,301.9"/>
                                                                            <path id="XMLID_1526_" class="st47" d="M351.8,234.5c2.9,4.1-4.4,15.6-2.4,29.8c1.4,9.7,4,25.9,3.4,35.1        c-0.1,1.7-6.6,2.9-8.4-5.2c-3-13.7-6.8-22.3-8.1-33l0.7-30.9L351.8,234.5z"/>
                                                                            <path id="XMLID_1525_" class="st48" d="M342.4,233c0.8,12.8-8.4,28.5-7.8,38.9c0.6,10.7-0.5,23.7-0.6,35.3        c0,0-9.4,4.5-9.9-2.4c-1.4-22.7-5.7-29.7,0.1-71.2L342.4,233z"/>
                                                                            <path id="XMLID_1524_" class="st14" d="M325.3,220.6c-0.3-12.4,2-24.6,2-24.6c1.1-1.6,2.5-3,4-4.1l3-3.7        c2.1-0.5,4.3-1.1,6.4-1.8c3.4-1.1,7-1,10.4,0l0,0c4.5,1.9,5.3,4.9,3.3,10.7c0,0.3-3.9,16.1-4.4,20.9c0,0.5,3.4,13.3,4.1,18.5        c0,0-3.3,3-4.2,3.7c-6.6,8.2-28.3-1.7-29.1-6.1C320.6,232.5,323.2,227.5,325.3,220.6z"/>
                                                                        </g>
                                                                    </g>
                                                                    <path id="XMLID_1518_" class="st2" d="M335.9,167c0,0-1.1,1-1.8,3.1c-0.7,2.1-0.5,3.6-0.6,4.7c-0.1,1.1-0.5,1.7-0.3,2.3      c0.2,0.6,1.6-2.4,2.9-2.7c1.3-0.3,1.1,3.6-1.7,4.6c-1.2,1.8-0.2,6.3,0.4,7.3c0.7,1,4.8,2.2,8.3,1c3.5-1.2,5.8-4.8,8.7-9.4      c2.9-4.6,0-8,0-8c1.4-3.2-9.4-7.3-14-7.4C335.2,162.6,335.9,167,335.9,167z"/>
                                                                </g>
                                                            </g>
                                                            <g id="XMLID_663_">
                                                                <path id="XMLID_901_" class="st15" d="M341.1,199.1c1.4-4.9-4-10.8-8.8-9.3c-1.7,0.6-3.2,1.1-4.1,2.6c-2.2,3.7-2.6,16.5-4.4,24.2     c-0.3,0.1-0.6,0.1-0.9,0.2c2.9,4,4.3,6,6.9,9.6c0.3-0.1,0.5-0.2,0.6-0.2C331.2,225.9,341.1,199.1,341.1,199.1z"/>
                                                            </g>
                                                            <g id="XMLID_1478_">
                                                                <path id="XMLID_1600_" class="st2" d="M115.3,347.5l7.9-0.7c0,0,5.1,1.4,8.1,1.9c3,0.4,5.2-0.1,5.9,1c0.1,0.2,0.2,0.4,0.2,0.7h0     c0,0,0,0,0,0c0,0,0,0,0,0c0.1,1.6-1.2,3.1-2,3.6c-1.6,1.1-3.3,1.8-7.9,1.4c-1.2-0.5-3.4-0.8-4.2,0.4c-1.2,0.6-5.9,1.2-7.9,0v-1     C114.1,353.6,115.3,347.5,115.3,347.5z"/>
                                                                <path id="XMLID_1597_" class="st6" d="M111.8,274.3c-2.6,13.5,6.8,28.3,6,39.2c-1,15-1.6,21.5-3.2,33.7c0,0,6.1,3.6,10.6-0.5     c4.6-23.9,6.6-28.2,6-71.9L111.8,274.3z"/>
                                                                <g id="XMLID_1554_">
                                                                    <path id="XMLID_1595_" class="st29" d="M148.8,212.1c2.7,3.1,0.4,16-3.3,19.1c-3.8,3.1-6.9,2-10.2-0.8      c-3.3-2.8-5.2-9.7-4.4-14.9C132,208.4,141.2,203.2,148.8,212.1z"/>
                                                                    <path id="XMLID_1556_" class="st14" d="M149.7,213.4c0,0,0.6,1.4,0.2,3.7c-0.3,2.3-1.1,3.5-1.6,4.6c-0.4,1-0.3,1.8-0.7,2.2      c-0.5,0.4-0.4-3-1.4-3.8c-1.1-0.8-2.6,2.8-0.5,5.1c0.3,2.2-2.6,6-3.6,6.6c-1.1,0.6-5.5-0.1-8.2-2.7c-2.7-2.7-3.3-7-4-12.6      c-0.6-5.6,3.5-7.4,3.5-7.4c0.1-3.6,12-2.6,16.2-0.7C152.4,209.6,149.7,213.4,149.7,213.4z"/>
                                                                </g>
                                                                <path id="XMLID_1552_" class="st2" d="M130.5,354.7l7.9-0.7c0,0,5.1,1.4,8.1,1.9c3,0.4,5.2-0.1,5.9,1c0.1,0.2,0.2,0.4,0.2,0.7h0     c0,0,0,0,0,0c0,0,0,0,0,0c0.1,1.6-1.2,3.1-2,3.6c-1.6,1.1-3.3,1.8-7.9,1.4c-1.2-0.5-3.4-0.8-4.2,0.4c-1.2,0.6-5.9,1.2-7.9,0v-1     C129.3,360.8,130.5,354.7,130.5,354.7z"/>
                                                                <path id="XMLID_1551_" class="st6" d="M117.9,277.7c-0.9,13.8,10.4,28.9,11.1,40c0.9,15.3,0.9,26.1,1,38.5c0,0,10.2,4.8,10.6-2.6     c1.5-24.4,3.1-30.7-3.2-75.3L117.9,277.7z"/>
                                                                <path id="XMLID_1481_" class="st11" d="M144.4,233.5c-5.7-2.8-14.9-10.6-22.4-0.4c-7,9.5-9.9,38-10.7,43.7     c-1.1,7.7,20.4,11.8,25.2,11.6c1.1,0,1.7-0.5,2-1.6c0.4-1.4-0.7-2.4-0.4-3.7c0.2-0.7,0.7-1.4,1.1-2c0.5-0.6,0.9-1.2,1-2     c0.2-1.2-0.6-2.4-0.7-3.6c-0.1-0.9,0.1-1.8,0.4-2.7c1.9-7.3,5.3-14,7.2-21.3c1.3-4.9,3.1-12.8-1-16.9     C145.7,234.3,145.1,233.7,144.4,233.5z"/>
                                                                <path id="XMLID_1480_" class="st11" d="M147.9,237.3c4.5,14.4,5,21.5,9.4,27.2c0.3,0.4,12.6,13.6,12.6,13.6s-1.7,3-5.9,3.8     c-6.9-2.9-14.6-13.7-16.7-16c-1.2-1.3-8-13.7-9-20.1C137.3,239.5,146,231.6,147.9,237.3z"/>
                                                            </g>
                                                            <path class="st47" d="M322.9,227.3c4.9-0.3,7.5-1,7.5-1s6-12.8,7.6-19c0,0-2.2,13.2-3.6,17.5c-1.5,4.3-3.5,6-6.6,5.6    c-3.1-0.4-5.6-1-5.6-1L322.9,227.3z"/>
                                                        </g>
                                                        <g>
                                                            <path class="st0" d="M74.4,299.7c2,0.1,4,0.2,6,0.2c0.5,0,1.1-0.2,1.5,0.1c0.5,0.4,0.7,1.7,0.9,2.3c0.2,0.8,1,2.3,0.9,3.1    c0.1-1,0.1-3.2,0.8-4.2c0.6,0.6,1,1.5,1.5,2.1c-0.1-1,0-1.7,0.4-2.5c0.6,0.6,1.7,0.8,2.4,1.1c3.7,1.5,7.8,3.7,9.9,7.2    c2.2,3.8-1.3,7.9-4.1,10.4c-1.4,1.2-3.1,2.4-4.8,3c-0.6,0.2-3.3,0.7-3.3,1.7c-0.5-0.6-1-1.3-1.6-1.8c0,0.6-0.5,1.2-0.3,1.8    c-1,0.3-2.2,0.2-3.2,0.7c-0.2-1.1-1.3-2.1-1.6-3.2c-0.5,0.9-0.9,2-1.1,2.9c-0.7-0.1-1.4-0.1-2.1-0.1c-2.9,0.1-6-0.2-8.9-0.6    c-1.8-0.3-3.5-0.3-5.3-0.4c-0.1-1-0.6-2.1-0.8-3.2c-0.3-1.3-0.5-2.6-0.8-3.9c-0.3,0.4-0.3,1-0.5,1.5c-0.5,1.6-1.2,3.3-1.8,4.9    c-0.6-0.3-7.3-1.1-7.3-1.4c0.1-1.2,0.2-2.7,0.1-3.8c-0.4,1-1.2,1.8-1.9,2.8c-0.7-1.1-0.3-3.7-0.6-5c-0.7,0.6-0.8,1.5-1.3,2.3    c-0.3,0.5-0.8,0.9-0.8,1.5c-1.6-0.8-3.1-1.8-4.6-2.8c-1-0.6-2.9-1.4-3.5-2.4c-0.4-0.7-0.1-1.9-0.5-2.6c-0.5,0.3-0.7,0.8-1,1.2    c-0.3-0.2-5-3.9-4.8-4.1c2.5-2.7,4.9-5.1,8.2-6.7c0.6-0.3,1.2-0.8,1.8-0.6c1.2,0.4,2.1,2.1,3,2.9c-0.3-1.5-0.1-3.2-0.3-4.7    c1.7-0.4,3.2-0.8,5.1-0.8c1.5,0,3.2-0.2,4.7-0.1c0.6,0,1.6-0.1,2.1,0.1c1.3,0.5,2.1,4.5,2.5,5.8c0.7-1.3,0.4-3.2,1.1-4.6    c0.7-1.5,2.2-0.5,3.2-1c-0.3,0.6,0.2,1.8,0.4,2.4c0.4-0.6,0.4-1.5,1-2c0.8,1.3,1.5,2.6,1.9,4.1c0.5-0.8,0.4-1.9,0.8-2.7    c0.2-0.4,0.4-0.8,0.6-1.2c1.8,0.4,3.7,0.3,5.6,0.4C74.2,299.7,74.3,299.7,74.4,299.7z"/>
                                                            <g>
                                                                <path class="st1" d="M37.4,308.7c2.7-0.6,6.2,0.5,8.9,0.9c2.9,0.5,5.8,1.1,8.8,1.6c5.4,0.9,10.9,1.6,16.5,1.6     c11.3,0,22.9,0.8,34-1c0.8-0.1,0.7-1.4-0.1-1.4c-11.6,0.9-23.1,1.6-34.7,1.6c-5.9,0-11.8-0.9-17.6-1.9c-5.2-0.9-10.6-2-15.9-2.2     C36.8,308,36.9,308.9,37.4,308.7L37.4,308.7z"/>
                                                            </g>
                                                        </g>
                                                    </g>
</svg>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif ?>
                            <?php if (($user instanceof Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire) : ?>
                                <li class="relative ">
                                    <button class="block py-2 pl-3 pr-4 h-[4rem]  text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent focus:outline-none md:hover:text-blue-700 md:dark:hover:text-blue-500" id="dropdownButtonEntreprise">
                                        <a href="<?php if ($user instanceof Enseignant && $user->getEstAdmin()) : ?><?= Action::ADMIN_DASH->value ?>
                                    <?php else : ?><?= Action::SECRETAIRE_DASH->value ?><?php endif ?>">Dashboard</a>
                                    </button>
                                </li>
                            <?php endif ?>
                            <li>
                                <button id="dropdownButtonContact" class="block py-2 pl-3 pr-4 h-[4rem]  text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent focus:outline-none md:hover:text-blue-700 md:dark:hover:text-blue-500">
                                    <a href="<?= Action::CONTACT->value ?>">Contact</a>
                                </button>

                                <div class="absolute hidden text-gray-700 pt-1 border border-slate-300 " id="dropdownContentContact">
                                    <div class="rounded  ease-in-out ml-3 mt-3 flex flex-row justify-end ">
                                        <div class="w-1/2">
                                            <span class="font-bold">Contacter les admins !</span>
                                            <p class="mt-2">Besoin de conseil ou de reporté un problème contacté directement les admins.</p>
                                        </div>
                                        <div class="w-1/2">
                                            <svg width="300" height="250" viewBox="0 0 596.37688 544.04108" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <path d="m430.5 409.6c47.5-36.1 68.6-136.2-8.5-185.3-51.1-32.5-82.8-14-140.2-35.5-70.1-26.2-80.6-105.5-165.8-66.5-45.2 20.7-76.5 78.9-82 145.1-5.4 64.7 17.6 109.2 64.5 139.6 110.2 4.7 220.7 3.9 332 2.6z" fill="#dff3fc"/>
                                                <path d="m235.4 124.8c-7.2 28.8 19.5 57.3 47.5 69.1 28.1 11.8 60.2 10.4 90.3 4.8 13-2.4 26.3-5.9 36.4-14.1 10.1-8.3 15.9-22.6 10.4-34.2-4.9-10.2-16.7-15.5-28.1-18.2-11.3-2.7-23.3-3.8-33.4-9.5-9.6-5.4-16.3-14.3-24.6-21.3-15.4-13-36.9-19.4-56.9-15.3-19.9 4.1-35.5 14.2-41.6 38.7z" fill="#dff3fc"/>
                                                <path d="m452.8 254.1v-21.8h-8.3c-1-3.8-2.5-7.4-4.4-10.7l5.8-5.9-15.4-15.4-5.9 5.8c-3.3-1.9-6.9-3.5-10.7-4.4v-8.3h-21.8v8.3c-3.8 1-7.4 2.5-10.7 4.4l-5.9-5.8-15.4 15.4 5.8 5.9c-1.9 3.3-3.4 6.9-4.4 10.7h-8.3v21.8h8.3c1 3.8 2.5 7.4 4.4 10.7l-5.8 5.9 15.4 15.4 5.9-5.8c3.3 1.9 6.9 3.4 10.7 4.4v8.3h21.9v-8.3c3.8-1 7.4-2.5 10.7-4.4l5.9 5.8 15.4-15.4-5.8-5.9c1.9-3.3 3.5-6.9 4.4-10.7zm-49.7 8c-10.4 0-18.9-8.5-18.9-18.9s8.5-18.9 18.9-18.9 18.9 8.5 18.9 18.9-8.5 18.9-18.9 18.9z" fill="#a2c7eb"/>
                                                <path d="m387 308.7-4.1-10.8-4.1 1.6c-1.2-1.7-2.7-3.2-4.2-4.5l1.8-4-10.6-4.7-1.8 4c-2-.3-4.1-.4-6.2-.2l-1.6-4.1-10.8 4.1 1.6 4.1c-1.7 1.2-3.2 2.7-4.5 4.2l-4-1.8-4.7 10.6 4 1.8c-.3 2-.4 4.1-.2 6.2l-4.1 1.6 4.1 10.8 4.1-1.6c1.2 1.7 2.7 3.2 4.2 4.5l-1.8 4 10.6 4.7 1.8-4c2 .3 4.1.4 6.2.2l1.6 4.1 10.8-4.1-1.6-4.1c1.7-1.2 3.2-2.7 4.5-4.2l4 1.8 4.7-10.6-4-1.8c.3-2 .4-4.1.2-6.2zm-23.2 13.4c-5.2 2-11-.6-13-5.8s.6-11 5.8-13 11 .6 12.9 5.8c2.1 5.2-.5 11-5.7 13z" fill="none" stroke="#a2c7eb" stroke-miterlimit="10"/>
                                                <path d="m351.6 270.8-2.8-7.3-2.8 1.1c-.8-1.1-1.8-2.2-2.9-3l1.2-2.7-7.1-3.2-1.2 2.7c-1.4-.2-2.8-.3-4.2-.1l-1.1-2.8-7.3 2.8 1.1 2.8c-1.1.8-2.2 1.8-3 2.9l-2.7-1.2-3.2 7.1 2.7 1.2c-.2 1.4-.3 2.8-.1 4.2l-2.8 1.1 2.8 7.3 2.8-1.1c.8 1.1 1.8 2.2 2.9 3l-1.2 2.7 7.1 3.2 1.2-2.7c1.4.2 2.8.3 4.2.1l1.1 2.8 7.3-2.8-1.1-2.8c1.1-.8 2.2-1.8 3-2.9l2.7 1.2 3.2-7.1-2.7-1.2c.2-1.4.3-2.8.1-4.2zm-15.7 9.1c-3.5 1.3-7.4-.4-8.8-3.9-1.3-3.5.4-7.4 3.9-8.8 3.5-1.3 7.4.4 8.7 3.9 1.5 3.5-.3 7.4-3.8 8.8z" fill="none" stroke="#a2c7eb" stroke-miterlimit="10"/>
                                                <path d="m349 143c0 10.9-5.1 20.7-13.1 27-5.9 4.7-13.3 7.4-21.3 7.4-8.1 0-15.5-2.8-21.3-7.4-8-6.3-13.1-16.1-13.1-27 0-19 15.4-34.4 34.4-34.4s34.4 15.4 34.4 34.4z" fill="#004582" stroke="#a2c7eb" stroke-miterlimit="10"/><ellipse cx="314.6" cy="131.6" fill="#fff" rx="11.3" ry="11.3" transform="matrix(.9925 -.1225 .1225 .9925 -13.7526 39.5288)"/>
                                                <path d="m336 165.6c-5.9 4.7-13.3 7.4-21.3 7.4-8.1 0-15.5-2.8-21.3-7.4 2.2-9.7 4.2-18.1 6.3-20.2 3-3 10.9-4.7 15-4.7s12.4 2.1 13.9 3.6c3 3.2 5.7 11.8 7.4 21.3z" fill="#fff"/>
                                                <path d="m265.1 227.8v-17c0-4.6 3.8-8.4 8.4-8.4h53.6c4.6 0 8.4 3.8 8.4 8.4v17c0 4.6-3.8 8.4-8.4 8.4h-53.6c-4.6.1-8.4-3.7-8.4-8.4z" fill="#004582"/>
                                                <path d="m287.8 227-26 25.2 42-21.2" fill="#004582"/><g fill="#fff"><path d="m271.6 210.4c0-.8.6-1.3 1.2-1.3h26.5c.7 0 1.2.6 1.2 1.2v.1c0 .7-.6 1.2-1.2 1.2h-26.5c-.6.1-1.2-.5-1.2-1.2z"/>
                                                <path d="m301.8 210.4c0-.8.6-1.3 1.2-1.3h23.1c.7 0 1.2.6 1.2 1.2v.1c0 .7-.6 1.2-1.2 1.2h-23.1c-.6.1-1.2-.5-1.2-1.2z"/>
                                                <path d="m291.7 216.1c0-.8.6-1.3 1.2-1.3h33.2c.7 0 1.2.6 1.2 1.2v.1c0 .7-.6 1.2-1.2 1.2h-33.1c-.7.1-1.3-.5-1.3-1.2z"/>
                                                <path d="m271.6 216.1c0-.8.6-1.3 1.2-1.3h14.8c.7 0 1.2.6 1.2 1.2v.1c0 .7-.6 1.2-1.2 1.2h-14.8c-.6.1-1.2-.5-1.2-1.2z"/>
                                                <path d="m296.3 221.8c0-.8.6-1.3 1.2-1.3h28.6c.7 0 1.2.6 1.2 1.2v.1c0 .7-.6 1.2-1.2 1.2h-28.6c-.6.1-1.2-.5-1.2-1.2z"/>
                                                <path d="m271.6 221.8c0-.8.6-1.3 1.2-1.3h19.8c.7 0 1.2.6 1.2 1.2v.1c0 .7-.6 1.2-1.2 1.2h-19.8c-.6.1-1.2-.5-1.2-1.2z"/>
                                                <path d="m271.6 227.5c0-.8.6-1.3 1.2-1.3h7.3c.7 0 1.2.6 1.2 1.2v.1c0 .7-.6 1.2-1.2 1.2h-7.3c-.6 0-1.2-.5-1.2-1.2z"/>
                                                <path d="m284.1 227.5c0-.8.6-1.3 1.2-1.3h40.9c.7 0 1.2.6 1.2 1.2v.1c0 .7-.6 1.2-1.2 1.2h-40.9c-.7 0-1.2-.5-1.2-1.2z"/></g><ellipse cx="102.9" cy="189.8" fill="#004582" rx="33.1" ry="33.1" transform="matrix(.4219 -.9067 .9067 .4219 -112.5897 203.024)"/><ellipse cx="95.1" cy="206.1" fill="#fff" rx="8" ry="8"/>
                                                <path d="m90.9 208.9-.4-5 4.2-2.9 4.6 2.2.4 5.1-4.2 2.9z" fill="#004582"/><ellipse cx="110.7" cy="173.5" fill="#fff" rx="8" ry="8"/>
                                                <path d="m106.7 175.9.3-6.4 4.9-4.3 4.6 2.2-.3 6.5-4.9 4.3z" fill="#004582"/>
                                                <path d="m100.6 202.4-6.1-2.9 4.5-10.5c.3-.7.6-1.3.9-2l5.3-10.1 6.1 2.9-4.4 10.3c-.3.8-.7 1.6-1.1 2.3z" fill="#fff"/>
                                                <path d="m125.9 207.6c1.2-.5 20.2.3 20.2.3l-13.7-12.6z" fill="#004582"/><ellipse cx="179.9" cy="120.9" fill="#004582" rx="32.6" ry="32.6"/>
                                                <path d="m178.8 93.1h2.2v27.3h-2.2z" fill="#fff"/>
                                                <path d="m154 128.2h27.7v2.2h-27.7z" fill="#fff" transform="matrix(.8222 -.5691 .5691 .8222 -43.7237 118.5115)"/>
                                                <path d="m182.9 120.9c0 1.7-1.3 3-3 3s-3-1.3-3-3 1.3-3 3-3c1.6 0 3 1.3 3 3z" fill="#fff"/>
                                                <path d="m268.3 341.3c-1.9-29.8 11.1-60.6 33-78.2.7 29.9-12.2 60.2-33 78.2z" fill="#a8d29f"/>
                                                <path d="m297.7 271.1c-9.2 17.2-17.2 35.2-23.9 53.8-8.1 22.6-14.4 46.5-28.2 65.5" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m261.3 360c11.1-24.8 33.1-43.6 57.4-48.9-10.3 26.6-33.5 46.9-57.4 48.9z" fill="#a8d29f"/>
                                                <path d="m312.8 316.6c-16.6 14.6-33.5 28.8-50.6 42.6" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m254.8 381.7c14.8-22.1 42.2-33.7 64.8-27.4-16.6 21.8-44 33.4-64.8 27.4z" fill="#a8d29f"/>
                                                <path d="m314.2 355.9c-19.4 12.2-40.4 21.1-62 26.5" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m262.8 352.5c4.7-24.9-2.4-52.7-18.2-71.1-6.5 24.5-.3 53.2 18.2 71.1z" fill="#a8d29f"/>
                                                <path d="m246.2 287.7c3.1 23.2 8.7 44.9 17.3 66.2" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m254.7 373.7c-2-25.6-15.2-49.7-34.4-63 1.1 13.6 4.7 26.7 10.5 38.6 6.5 13.7 16.2 22.3 23.9 24.4z" fill="#a8d29f"/>
                                                <path d="m223.1 315.9c7.6 21.4 18.4 41.2 32 58.4" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m403.1 367.6c10.5-27.3 34.6-49.4 61.2-56.2-11.6 26.9-35.4 48.6-61.2 56.2z" fill="#008788"/>
                                                <path d="m457.9 317.1c-15.2 11.6-29.7 24.4-43.2 38.2-16.4 16.8-31.8 35.6-51.8 46.8" fill="#fff" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m389.3 381.4c20-17.6 47.1-25.3 70.8-20.1-20 19.5-48.9 28.1-70.8 20.1z" fill="#008788"/>
                                                <path d="m452.6 363.8c-20.6 6.2-41.4 12-62.2 17.3" fill="#fff" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m374.6 398c22.2-13.7 51.1-12.8 68.5 2.1-23.6 12.7-52.6 11.8-68.5-2.1z" fill="#008788"/>
                                                <path d="m437.7 399.3c-22.2 2.9-44.4 2.3-65.7-1.7" fill="#fff" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m393.7 375.3c14.4-20.3 19.5-47.9 13.1-70.8-15.8 19.2-22.1 47.3-13.1 70.8z" fill="#008788"/>
                                                <path d="m405.6 310.9c-6.8 21.9-10.8 43.6-11.9 66" fill="#fff" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m377.8 390.9c8.7-23.7 7-50.5-4.6-70.2-4.6 12.6-6.8 25.7-6.6 38.6.3 14.9 5.3 26.6 11.2 31.6z" fill="#008788"/>
                                                <path d="m373.6 326.5c-2.1 22.1-.6 44.2 4.4 65.1" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m105.8 319.9c-10.7-32.7-40.5-59.1-75.3-66.6 14.6 28.2 41.1 50.7 75.3 66.6z" fill="#008788"/>
                                                <path d="m107.6 324.9c-23.4-13.2-52.8-16.2-78.2-7.8 23.6 11.8 51.5 15.1 78.2 7.8z" fill="#008788"/>
                                                <path d="m114.1 332c-25.3-3.5-51.8 2.7-72.4 17 23.3 8.5 51.3 3.1 72.4-17z" fill="#008788"/>
                                                <path d="m122 347.5c-25.1-.1-49.7 11.8-64.5 31.2 11.2 2.2 23 .9 33.2-3.7 10.3-4.7 18.9-12.6 31.3-27.5z" fill="#008788"/>
                                                <path d="m139.7 373.5c-24.7-4.2-51.1 3.4-68.9 20 10.6 4 22.6 4.7 33.4 1.8 10.9-2.9 20.7-9.2 35.5-21.8z" fill="#008788"/>
                                                <path d="m113 321.4c-16.3-22-20.8-51.7-11.5-76.9 7.1 12 13.2 24.7 16 38.2 2.9 13.5 2.3 27.8-4.5 38.7z" fill="#008788"/>
                                                <path d="m122.9 342.6c-3.9-23.4 4.1-48.2 21-65.1 2 24.2-5.4 48.9-21 65.1z" fill="#008788"/>
                                                <path d="m38.1 259.1c49.7 31.8 88.5 79.2 109.1 133" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m103 256.1c6 24.5 9.7 49.6 11 74.7" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m140.2 287.1c-2 19.8-8.1 39.1-17.9 56.6" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m39.8 317.7c22.8 4.3 45.9 6.7 69.1 7" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m53.6 347.1c21-1.5 41.7-6.6 60.8-15" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m66.2 375.2c19.4-9.7 38.8-19.3 58.1-29" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m78.8 392.2c25.3-4.9 32.8-10.7 60.9-18.8" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m238.9 345.9s2.2 20.1 4.6 21.7c4.4 2.9 55.1 9.6 55.1 9.6l-1.7 13.2s-69.4 6.2-72.4 2.8c-5.1-6-14.1-35.1-14.1-35.1z" fill="#e06a58"/>
                                                <path d="m205.5 294.2 5.6-13.5s15.2 7.1 20.2 16c5.4 9.4 11.9 59.6 11.9 59.6s-26.9 6.2-31.8 3.6-5.9-65.7-5.9-65.7z" fill="#f2ae30"/>
                                                <path d="m162.7 231.7c-3.9-1.4-8.1-2.7-12.3-2.4s-8.5 2.6-9.9 6.2c-1 2.6-.6 5.7-2.2 8.1-1.5 2.3-4.6 3.2-7.5 3.4s-5.8-.2-8.6.2c-8.8 1.2-15.1 10.7-12.2 18.6 1.2 3.1 3.5 6.1 3 9.4-.6 3.5-4.2 5.8-5.7 9-2 4.3.4 9.5 4.3 12.4s9 4 14 4.8c6.8 1 13.9 1.5 20.6.1s13.2-5 16.7-10.6c1.6-2.5 2.5-5.2 4.3-7.5 3.7-4.8 10.3-6.6 15.5-10 5.7-3.7 9.8-10.9 6.5-16.6-3.2-5.4-11.6-6.6-15-12-1.4-2.2-1.7-4.8-2.6-7.2-.9-2.6-3.1-3.8-8.9-5.9z" fill="#122259"/>
                                                <path d="m185.6 298.3c1 1.1 2.2 2.4 3.8 2.5 1.7.1 3.1-1.1 4.2-2.3 5.7-6 9.4-13.4 10.9-21-1.4-.8-2.8-1.6-4-2.3-1.1-.7-2-1.6-2.5-2.7-.3-.8-.5-1.7-.4-2.6.8-7.5 1.5-11.7 4.1-19.3-12.5-2.8-24.4-6.2-31.2-11.9-.8 3.5-1.8 10.4-3.9 17.1-2.2 7.2-5.7 14.3-11.6 17.4 11.8 6.9 22.1 15.4 30.6 25.1z" fill="#f9a07b"/>
                                                <path d="m197.7 269.9c-.1.9 0 1.8.4 2.6-7.4 9-24-2.8-31.3-16.6 2.1-6.8 3.1-13.6 3.9-17.1 6.8 5.7 18.6 9.1 31.2 11.9-2.6 7.5-3.4 11.7-4.2 19.2z" fill="#e06a58"/>
                                                <path d="m218.4 378.7c-1.6 10.9 10.1 22.5 10.4 28.4-24.9 0-77 1.5-103.6-2.1-1.2-6.7 11.9-21.8 11.9-36.7 0-2-.1-4.1-.2-6.4-.4-6.6-1.4-14.5-2.5-22.6-3-21.7-6.9-45-4-49.8 5.7-9.4 19-15.8 25.6-18.5 2.3-.9 3.8-1.5 3.9-1.5 8.3 14.1 25.2 26.2 31.5 25.7 1.8-.1 7-2 10.5-19.4 1.4.8 2.7 1.5 4 2.2 6.6 3.4 12.8 6.3 14.6 10.7 4.7 11.6 9.3 40.9 8.3 51.3-1 10.5-5.2 18.5-8.2 29.1-.7 2.5-1.3 5.1-1.8 7.9-.2.4-.3 1.1-.4 1.7z" fill="#ffc73c"/>
                                                <path d="m228.8 407.1c-24.9 0-77 1.5-103.6-2.1-1.2-6.7 11.9-21.8 11.9-36.7 0-2-.1-4.1-.2-6.4-.4-6.6-1.4-14.5-2.5-22.6 4.7 5 11.6-16 14.6-9.9 16.4 33.2 29.4 41.9 52 41.9 6.7 0 12.9-.9 19.6-2.5-.7 2.5-1.3 5.1-1.8 7.9-.1.6-.2 1.3-.3 2-1.7 10.9 10 22.6 10.3 28.4z" fill="#fb3"/>
                                                <path d="m205.9 277.8c-1.1 7.8-4.2 18.2-13.5 21-12.4 3.8-30.4-19.5-36.4-27.8 2.3-.9 3.8-1.5 3.9-1.5 8.3 14.1 25.2 26.2 31.5 25.7 1.8-.1 7-2 10.5-19.4 1.3.6 2.7 1.3 4 2z" fill="#fce172"/>
                                                <path d="m211.1 395.4-.1 8.7 155 .9.3-9.8z" fill="#004582"/>
                                                <path d="m433.1 318.1-3.4-3.5-112.9-.8-56.6 81.9 2.9 2.4z" fill="#004582"/>
                                                <path d="m319 316.8-55.9 81.3 106.7.5 63.3-80.5z" fill="#122259"/><ellipse cx="345.9" cy="362.5" fill="#a4d5ff" rx="12.4" ry="6.2"/>
                                                <path d="m213.3 236.6c1.8-9.4 8.2-16.2 14.5-15 6.2 1.2 9.8 9.8 8.1 19.2-1.8 9.4-8.2 16.2-14.5 15-6.2-1.1-9.8-9.7-8.1-19.2z" fill="#004582"/>
                                                <path d="m235.9 211.2c-1.2 8.2-4.8 17.3-10.2 27.3-1.9-8.2-3.1-18.2-4.7-28.2-1.7-10-3.8-20-7.6-28.2-.8-1.8-1.8-3.5-2.7-5.1 2.2-.2 4.4 0 6.6.6 3.3.9 6.4 2.6 9 4.9 4.2 3.8 7.1 8.9 8.8 14.3 1.3 4.5 1.6 9.3.8 14.4z" fill="#0b2d50"/>
                                                <path d="m229.6 219.7c-.1 1.6-.2 3.3-.3 4.9-2.3 26.6-13.4 44.8-30.5 44.8-24.1 0-39.8-27.1-39.8-53.6 0-26.2 16-45.1 34.8-42.9 10.8 1.2 18.7 4.8 24.3 10.1 3.7 3.5 6.4 7.7 8.2 12.5 2.1 5.4 3.1 11.5 3.3 18.1v.1c.1 2 .1 4 0 6z" fill="#f9a07b"/>
                                                <path d="m233.1 203.3c-3.3 2.8-7.5 5.1-12.1 7-13.3 5.4-30.5 7.1-43.9 6.5-6.6 14.5-9.3 19.7-11 32.4-6.4-6.1-11.7-17.1-13.3-25.8-1.5-8.7-1.4-17.8 1-26.3 3.8-13.4 13.4-20.6 20.1-24.1 1.7-.9 3.2-1.5 4.3-2 8.5-3.3 18.1-3 26.8-.3 4.8 1.5 8.8 4 12.1 7.1 6.8 6.2 11 14.5 13.7 20.7 1.1 1.7 1.7 3.4 2.3 4.8z" fill="#122259"/>
                                                <path d="m235.9 211.2c-.6-2.9-1.4-5.7-2.5-8.4-.6-1.5-1.4-3-2.4-4.5-3-4.8-7.4-8.7-12.8-10.4-1.5-2.1-3.1-4.1-4.8-5.8-6.1-6.1-13.2-9.7-20.7-10.9-6.3-1-12.8-.4-18.8 1.6 1.7-.9 3.2-1.5 4.3-2 8.5-3.3 18.1-3 26.8-.3 4.8 1.5 8.8 4 12.1 7.1 3.3.9 6.4 2.6 9 4.9 4.2 3.8 7.1 8.9 8.8 14.3 1.5 4.5 1.8 9.3 1 14.4z" fill="#103a5c"/>
                                                <path d="m166.2 222.9s-.2-12.5 5-24.9c6.5-15.6 19.8-22.2 32.6-22.6 15.5-.6 25.2 9.9 25.2 9.9s-5.1-8.9-15-11.5c-6.5-1.7-16.4-2-24.3 1.3-8.2 3.3-18.3 12.5-22 22.2s-5.5 24.8-5.5 24.8z" fill="#004582"/><ellipse cx="164" cy="237.2" fill="#004582" rx="12.1" ry="18.3" transform="matrix(.9946 -.1034 .1034 .9946 -23.6478 18.2294)"/>
                                                <path d="m158.8 224.8c4.3-.6 8.7 4.9 9.8 12.5 1.1 7.5-1.4 14.2-5.7 14.8s-8.7-4.9-9.8-12.5c-1.2-7.5 1.4-14.1 5.7-14.8z" fill="#a4d5ff"/><ellipse cx="203.9" cy="265.8" fill="#004582" rx="6.4" ry="4"/>
                                                <path d="m171.6 252.4s9.5 12.2 25.9 13.4" fill="none" stroke="#004582" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"/>
                                                <path d="m211 372.3-.6 16s-57.8 17.3-67.4 11.9c-4.7-2.7-9-17.4-12.3-31.8-3.4-15.1-5.6-29.8-5.6-29.8l33.9-6.6s0 20.7 1.2 32.6c.4 4.5 1 7.7 1.8 8.2 3 1.8 49-.5 49-.5z" fill="#f9a07b"/>
                                                <path d="m160.2 364.4c-6.2 2-18.1 5.1-29.5 3.9-3.4-15.1-5.6-29.8-5.6-29.8l33.9-6.6c0-.1 0 20.6 1.2 32.5z" fill="#e06a58"/>
                                                <path d="m209.3 372.4c8.6-1.8 23.2-6.3 29.2-7.8 4.3-1.1 15.5 4.7 18.4 10.2 1.3 2.4 2.5 15.9-2 14.5-2.2-.7-1.9-6.5-2.6-8.8-.6-1.9-2.4-3.8-5.2-5.4 1.8 4.6 1.8 8.6 1.6 13.6 0 1.1-.1 2.2-.6 3.2-.5.9-1.7 1.6-2.7 1.2s-1.4-1.7-1.6-2.8c-.8-3.8-1.6-7.7-1.9-12 .1 4.3 0 8.6-.3 12.8-.2 3.3-1.8 5.1-3.8 4.5-.9-.2-1.2-1.1-1.6-2.1-.6 2.1-2.1 4.4-4 3.5-1.2-.5-1.9-4.8-1.7-9.2-3.7 2.3-7.9 3.3-12.8 3.5-4.3.2-8.8-.6-11.4-3.6.3-4.6 1.8-11.5 3-15.3z" fill="#f9a07b"/>
                                                <path d="m236.3 392.7c.3-3.5 0-7-.9-10.3" fill="none" stroke="#cc454e" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m155.2 298.3c-2.5-6.9-11.5-21.1-11.5-21.1s-13.8 5.7-18.6 15.4c-8.3 16.4-4.1 63.6-4.1 63.6 11.1 4.7 33.5 4.7 43 3.4 0 0-3.9-47.5-8.8-61.3z" fill="#ffc73c"/>
                                                <path d="m157 301.2c3.8 18 5.8 34.7 6.4 51.1" fill="none" stroke="#f2ae30" stroke-linecap="round" stroke-miterlimit="10"/>
                                                <path d="m57 402.1h394.3v9.9h-394.3z" fill="#dff3fc"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </li>
                                <?php if (UserConnection::isInstance(new Etudiant())) : ?>
                                <button class="block py-2 pl-3 pr-4 h-[4rem]  text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent focus:outline-none md:hover:text-blue-700 md:dark:hover:text-blue-500" id="">
                                    <a href="<?= Action::A_PROPOS->value ?>">A propos</a>
                                </button>
                                <?php endif?>
                                <button>
                                    <?php if (UserConnection::isInstance(new Etudiant())) : ?>
                                    <a href="<?= Action::TUTORIEL_ETUDIANT->value?>">Besoin d'aide</a>
                                    <?php elseif (UserConnection::isInstance(new Entreprise())) : ?>
                                        <a href="<?= Action::TUTORIEL_ENTREPRISE->value ?>">Besoin d'aide</a>
                                    <?php elseif (UserConnection::isInstance(new Secretaire())) : ?>
                                        <a href="<?= Action::TUTORIEL_SECRETAIRE->value ?>">Besoin d'aide</a>
                                    <?php elseif (UserConnection::getSignedInUser() instanceof Enseignant && UserConnection::getSignedInUser()->getEstAdmin()) : ?>
                                        <a href="<?= Action::TUTORIEL_ADMIN->value ?>">Besoin d'aide</a>
                                    <?php else : ?>
                                        <a href="<?= Action::TUTORIEL->value ?>">Besoin d'aide</a>
                                    <?php endif?>
                                </button>
                                <div class="absolute hidden text-gray-700 pt-1 border border-slate-300 " id="dropdownContentMission">
                                    <div class="rounded  ease-in-out ml-3 mt-3 flex flex-row justify-end ">
                                        <div class="w-1/2">
                                            <span class="font-bold">Vos tuto Stageo !</span>
                                            <p class="mt-2">Notre mission est de vous assister pour toutes les taches et fonction de notre site.</p>
                                        </div>
                                        <div class="w-1/2">
                                            <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="250" height="170" viewBox="0 0 596.37688 544.04108" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <path d="M855.29485,597.93371c27.13492-18.1824,46.62014-50.4909,42.13358-82.84441a150.49327,150.49327,0,0,1-92.28062,46.47676c-13.61223,1.53821-28.91247,1.83171-38.46765,11.648-5.94558,6.10781-8.39172,14.9551-8.41431,23.47859-.02237,8.52391,2.13257,16.88565,4.27284,25.13654l-.47347,2.07451C794.6883,622.28,828.15993,616.1161,855.29485,597.93371Z" transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                                <path d="M896.74305,515.09107a128.63128,128.63128,0,0,1-50.2678,61.12728,55.39337,55.39337,0,0,1-15.77341,7.24012,31.77037,31.77037,0,0,1-16.71515-.42757c-5.09688-1.42033-10.14595-3.4634-15.49933-3.62a19.453,19.453,0,0,0-14.61047,6.29567c-4.75089,4.91238-7.45336,11.23887-9.88115,17.51748-2.69559,6.97121-5.385,14.25482-10.99,19.46433-.67911.6312.34,1.64805,1.0181,1.0178,9.75164-9.06365,10.65407-23.41657,18.2765-33.88435,3.55676-4.88446,8.60707-8.72664,14.83827-8.96608,5.44891-.20938,10.65736,1.893,15.80563,3.37571a33.90139,33.90139,0,0,0,16.32824,1.027,51.20935,51.20935,0,0,0,15.99357-6.607,124.795,124.795,0,0,0,29.76934-25.20129,130.9121,130.9121,0,0,0,23.10043-37.99415c.33865-.8598-1.05637-1.21917-1.39281-.365Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M854.08147,571.95293a19.29879,19.29879,0,0,0,24.66368,4.02475c.79162-.4809.08152-1.73364-.71116-1.2521a17.87025,17.87025,0,0,1-22.93471-3.79075c-.5968-.70848-1.6112.31368-1.01781,1.0181Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M816.47616,584.09142A37.19687,37.19687,0,0,1,828.13567,559.619c.67686-.63359-.34206-1.65063-1.0181-1.0178a38.69031,38.69031,0,0,0-12.081,25.4904c-.06377.926,1.37618.92073,1.4396-.00021Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M883.027,541.61616a10.924,10.924,0,0,1-4.188-9.48194c.07547-.92469-1.36462-.91847-1.4396.00021a12.24127,12.24127,0,0,0,4.60977,10.49983.744.744,0,0,0,1.018-.00015.72344.72344,0,0,0-.00015-1.01795Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M803.33209,456.98207c-.06355.576-.12709,1.15211-.20124,1.73416a143.86343,143.86343,0,0,1-4.55041,22.88883c-.1558.582-.32245,1.16948-.49465,1.74579a151.66435,151.66435,0,0,1-25.44969,49.70134A147.28527,147.28527,0,0,1,757.62364,549.648c-7.48257,7.10259-16.1607,14.20825-20.72555,23.106a25.26634,25.26634,0,0,0-1.28463,2.85119l23.95767,47.55994c.10869.08076.20685.16749.3158.24878l.86973,1.94266c.298-.24574.60168-.507.89963-.75276.17342-.14183.34151-.29426.51493-.43609.11393-.09791.22765-.19638.33605-.27822.038-.03245.07582-.06543.10307-.09244.1084-.08184.2004-.16937.29794-.24574q2.55274-2.18368,5.08367-4.41085c.01086-.00547.01086-.00547.01638-.02154,12.82741-11.34607,24.82029-23.8627,34.53212-37.80172.29206-.41947.59524-.84388.87635-1.28508a140.54241,140.54241,0,0,0,11.42187-19.88879,124.24716,124.24716,0,0,0,4.73049-11.64761,103.319,103.319,0,0,0,5.66486-31.80352c.41358-21.59478-6.08384-43.08144-20.76839-58.54012C804.08969,457.75694,803.71889,457.37179,803.33209,456.98207Z" transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                                <path d="M802.78232,457.39306a128.6312,128.6312,0,0,1-3.33319,79.0714A55.39286,55.39286,0,0,1,791.214,551.742a31.77037,31.77037,0,0,1-13.60354,9.72229c-4.9247,1.93462-10.18617,3.34323-14.55484,6.44129a19.453,19.453,0,0,0-7.87521,13.82325c-.83573,6.78262.81548,13.461,2.65719,19.93586,2.04487,7.189,4.28275,14.62383,2.944,22.15789-.16221.91286,1.26372,1.11117,1.42569.19969,2.32919-13.108-5.59172-25.1113-5.808-38.05847-.1009-6.04138,1.61823-12.14978,6.44933-16.09257,4.22459-3.44781,9.649-4.905,14.65232-6.82077a33.90136,33.90136,0,0,0,13.65553-9.01071,51.20958,51.20958,0,0,0,8.79212-14.90453,124.79539,124.79539,0,0,0,8.59623-38.045,130.91238,130.91238,0,0,0-4.4307-44.24426c-.24727-.89039-1.57748-.33744-1.33183.54714Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M802.9542,528.47929a19.29879,19.29879,0,0,0,22.11574-11.6357c.34254-.86059-.97868-1.4333-1.32167-.57157a17.87025,17.87025,0,0,1-20.59438,10.78158c-.90306-.20636-1.09759,1.22051-.19969,1.42569Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M780.23668,560.81219a37.1968,37.1968,0,0,1-5.42461-26.55967c.159-.91339-1.2669-1.112-1.42568-.19969a38.69027,38.69027,0,0,0,5.701,27.62627c.50658.77772,1.65314-.09341,1.14932-.86691Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M807.80076,486.82987a10.924,10.924,0,0,1-9.05265-5.04935c-.49647-.78376-1.64255.08825-1.14931.86691a12.24126,12.24126,0,0,0,10.00226,5.60812.744.744,0,0,0,.81269-.613.72344.72344,0,0,0-.613-.81269Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M302.16451,659.03216c2.00293-21.01281,14.38711-42.01532,34.16014-49.40225A97.25292,97.25292,0,0,0,338.245,676.373c3.30661,8.21186,7.83941,17.00112,5.19325,25.449-1.64639,5.25652-5.92524,9.36486-10.76442,11.99581-4.83949,2.631-10.25556,3.97415-15.6041,5.29166l-1.034.90641C306.9383,700.96891,300.16157,680.045,302.16451,659.03216Z" transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                                <path d="M336.53417,610.02013a83.1251,83.1251,0,0,0-19.31411,47.35634,35.7967,35.7967,0,0,0,.72856,11.192,20.53091,20.53091,0,0,0,5.37739,9.37223c2.37311,2.46161,5.08561,4.70476,6.819,7.70037a12.57112,12.57112,0,0,1,.90832,10.24073c-1.33368,4.21007-4.10057,7.68985-6.92461,10.99876-3.13557,3.6739-6.45065,7.44026-7.69093,12.22718-.15028.58-1.04146.31291-.89141-.26622,2.15789-8.32841,10.04119-13.25019,13.65143-20.79932,1.6846-3.52256,2.31784-7.57414.54-11.1905-1.55466-3.16235-4.34983-5.47789-6.7742-7.94956a21.90793,21.90793,0,0,1-5.59936-8.96813,33.093,33.093,0,0,1-1.15618-11.12273,80.64633,80.64633,0,0,1,5.1844-24.66657,84.59938,84.59938,0,0,1,14.50636-24.8044c.38483-.45664,1.01765.22612.63534.67978Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M317.30885,651.74169a12.4714,12.4714,0,0,1-9.86409-12.78653.46556.46556,0,0,1,.93034.01974,11.54825,11.54825,0,0,0,9.2,11.87539c.58612.1217.31655,1.01241-.26622.8914Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M321.95836,676.85108A24.03763,24.03763,0,0,0,332.291,662.70492c.15233-.57945,1.04355-.31253.89141.26622a25.00277,25.00277,0,0,1-10.782,14.69851c-.50688.32067-.9462-.49963-.44207-.81857Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M325.66612,625.96607a7.05941,7.05941,0,0,0,6.67745-.53139c.50256-.32694.94137.49375.44208.81857a7.91067,7.91067,0,0,1-7.38574.60423.4808.4808,0,0,1-.3126-.57882.46751.46751,0,0,1,.57881-.31259Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M394.26507,645.28094c-.308.21307-.616.42615-.92417.64709-4.12735,2.88334-4.00948,6.1053-7.616,9.61779-.28305.26735-.56587.54256-.84065.81748a98.00977,98.00977,0,0,0-20.441,29.73612,95.1784,95.1784,0,0,0-4.82446,13.63312c-1.73988,6.436-3.11428,13.55259-6.771,18.88105a16.32732,16.32732,0,0,1-1.22648,1.60617l-34.39961.98729c-.0793-.037-.15876-.06616-.23845-.10314l-1.37167.10222c.0482-.24488.10346-.49783.15166-.74271.02737-.14217.0624-.28456.08977-.42672.02068-.09485.04173-.18976.055-.27653.00676-.0316.01391-.0632.0209-.087.01323-.08677.03474-.166.0482-.24488q.45744-2.12214.94631-4.24522c-.00022-.00786-.00022-.00786.00722-.01594a139.94787,139.94787,0,0,1,10.88555-31.24489c.14879-.2949.297-.59764.46147-.893a90.82268,90.82268,0,0,1,7.7996-12.60314,80.292,80.292,0,0,1,5.16933-6.26728,66.7677,66.7677,0,0,1,16.34218-12.98969c12.1509-6.86827,22.36313-9.774,35.66288-6.1733C393.59179,645.08821,393.92468,645.18073,394.26507,645.28094Z" transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                                <path d="M394.20026,645.71976c-16.854,3.84769-28.5879,13.10467-39.933,26.183a35.79664,35.79664,0,0,0-6.15666,9.37487,20.53093,20.53093,0,0,0-1.3492,10.72076c.41274,3.39423,1.228,6.81837.80846,10.25383a12.57116,12.57116,0,0,1-5.44038,8.72353c-3.59963,2.55854-7.9039,3.67109-12.15093,4.61279-4.71552,1.04558-9.63,2.0569-13.50239,5.13225-.46919.37262-1.01993-.37719-.55145-.74925,6.73723-5.35057,15.99486-4.534,23.42253-8.388,3.46588-1.79832,6.41082-4.652,7.1686-8.60988.66264-3.461-.175-6.99269-.62264-10.42582a21.908,21.908,0,0,1,.92865-10.53174,33.09308,33.09308,0,0,1,5.77351-9.577,80.6461,80.6461,0,0,1,18.99044-16.57351c8.1356-5.17,13.11949-8.9258,22.51647-11.07109.5822-.13292.6764.79324.098.92528Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M357.73066,667.45712a12.4714,12.4714,0,0,1-.17755-16.14819c.38408-.45909,1.11553.11618.73094.57588a11.54824,11.54824,0,0,0,.19586,15.02085c.39471.45006-.35679.99894-.74925.55146Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M346.32544,690.30489a24.03764,24.03764,0,0,0,16.767-5.07395c.47049-.37094,1.02138.37875.55145.74925a25.00269,25.00269,0,0,1-17.45833,5.24443c-.59778-.04913-.45467-.9686.13986-.91973Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M379.92218,651.90838a7.05937,7.05937,0,0,0,5.6515,3.596c.59811.04154.45436.961-.13986.91974a7.91065,7.91065,0,0,1-6.26089-3.96428.48078.48078,0,0,1,.0989-.65035.4675.4675,0,0,1,.65035.09889Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M731.2907,179.97949H707.76008a17.47213,17.47213,0,0,1-16.17679,24.07086H588.31146a17.4721,17.4721,0,0,1-16.17679-24.07089H550.157a36.77582,36.77582,0,0,0-36.77585,36.77578V682.85712A36.77582,36.77582,0,0,0,550.157,719.633H731.2907a36.77583,36.77583,0,0,0,36.77585-36.77581h0V216.75527A36.7758,36.7758,0,0,0,731.2907,179.97949Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M731.29071,721.63278H550.15716A38.82015,38.82015,0,0,1,511.381,682.8569V216.75534a38.82026,38.82026,0,0,1,38.77588-38.77588h24.95361l-1.124,2.75537a15.47185,15.47185,0,0,0,14.325,21.31543H691.58319a15.47273,15.47273,0,0,0,14.32519-21.31543l-1.12377-2.75537h26.5061a38.81994,38.81994,0,0,1,38.77588,38.77588V682.85739A38.81952,38.81952,0,0,1,731.29071,721.63278ZM550.15692,181.97946A34.81568,34.81568,0,0,0,515.381,216.75534V682.8569a34.81535,34.81535,0,0,0,34.77588,34.77588H731.29071a34.81494,34.81494,0,0,0,34.77588-34.77539v-466.102a34.81536,34.81536,0,0,0-34.77588-34.77588H710.50506a19.47334,19.47334,0,0,1-18.92187,24.0708H588.31146a19.47855,19.47855,0,0,1-18.92163-24.0708Z" transform="translate(-301.81156 -177.97946)" fill="#e4e4e4" />
                                                <path d="M732.64908,251.61253H678.02741a2.31653,2.31653,0,1,1,0-4.63307h54.62167a2.31654,2.31654,0,1,1,0,4.63307Z" transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                                <path d="M732.64908,262.00678H678.02741a2.31653,2.31653,0,1,1,0-4.63307h54.62167a2.31654,2.31654,0,1,1,0,4.63307Z" transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                                <path d="M732.64908,272.401H678.02741a2.31653,2.31653,0,1,1,0-4.63307h54.62167a2.31654,2.31654,0,1,1,0,4.63307Z" transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                                <polygon points="154.571 533.534 163.723 533.533 168.077 498.232 154.57 498.232 154.571 533.534" fill="#ffb6b6" />
                                                <path d="M454.04829,708.52489l18.024-.00073h.00073a11.48692,11.48692,0,0,1,11.48629,11.4861v.37326l-29.51045.0011Z" transform="translate(-301.81156 -177.97946)" fill="#2f2e41" />
                                                <polygon points="118.788 525.015 127.421 528.053 143.248 496.2 130.506 491.716 118.788 525.015" fill="#ffb6b6" />
                                                <path d="M419.3896,699.40109l17.00193,5.98318.00068.00024a11.4869,11.4869,0,0,1,7.02148,14.648l-.12392.35209-27.837-9.79629Z" transform="translate(-301.81156 -177.97946)" fill="#2f2e41" />
                                                <polygon points="113.349 328.346 107.808 334.381 130.205 427.612 153.216 518.531 171.613 518.531 161.032 431.768 161.032 342.537 113.349 328.346" fill="#2f2e41" />
                                                <polygon points="170.599 335.823 173.024 344.852 160.065 425.373 141.663 510.695 120.826 510.695 136.47 406.078 155.586 329.072 170.599 335.823" fill="#2f2e41" />
                                                <path d="M483.86346,380.0269l-8.1-14.54109-19.21464-3.14487h0a48.54943,48.54943,0,0,0-35.9073,42.2181L410.22317,511.2629s53.30848,24.53518,64.61207,10.72165L490.5549,400.86821A23.94366,23.94366,0,0,0,483.86346,380.0269Z" transform="translate(-301.81156 -177.97946)" fill="#3f3d56" />
                                                <circle cx="168.39709" cy="159.2562" r="20.38889" fill="#ffb6b6" />
                                                <path d="M496.99365,326.12061a5.047,5.047,0,0,1-2.98816-2.2978,4.88486,4.88486,0,0,1-.02313-4.9765,7.382,7.382,0,0,0-6.11737-.31109,6.96584,6.96584,0,0,0,2.356-5.88465q-3.67008,1.2421-7.34009,2.48407a5.39457,5.39457,0,0,0,1.85156-5.9563c-2.0083,2.86091-6.16742,3.24512-9.55713,2.39173-3.38965-.85333-6.52136-2.6435-9.975-3.18219a14.16042,14.16042,0,0,0-16.28809,12.74762,5.29652,5.29652,0,0,0-4.14191,3.03314,11.36931,11.36931,0,0,0-.976,5.22955,28.00825,28.00825,0,0,0,11.22565,22.02649l1.12665-.38769a9.0229,9.0229,0,0,1,8.09137-9.47949c2.9906-.18763,6.522,1.01,8.65637-1.09314,1.95263-1.92414,1.254-5.36866,2.84765-7.59919,1.38617-1.94012,4.14368-2.39251,6.48236-1.92779,2.33875.46472,4.46662,1.64911,6.73792,2.37475,2.27136.72565,4.9317.92987,6.88446-.43841A6.97507,6.97507,0,0,0,498.453,327.493a10.0471,10.0471,0,0,0-.0105-1.25482A5.41585,5.41585,0,0,1,496.99365,326.12061Z" transform="translate(-301.81156 -177.97946)" fill="#2f2e41" />
                                                <rect x="59.06516" y="338.52334" width="209.96204" height="60.80078" fill="#fff" />
                                                <path d="M572.7475,579.21232H358.968V514.59405H572.7475Zm-209.962-3.81749H568.93V518.41154H362.78546Z" transform="translate(-301.81156 -177.97946)" fill="#e4e4e4" />
                                                <path d="M530.05323,537.41023h-128.391a2.72217,2.72217,0,1,1,0-5.44434h128.391a2.72217,2.72217,0,1,1,0,5.44434Z" transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                                <path d="M530.05323,549.62572h-128.391a2.72254,2.72254,0,0,1,0-5.44507h128.391a2.72254,2.72254,0,0,1,0,5.44507Z" transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                                <path d="M478.08447,561.84049H401.66223a2.72217,2.72217,0,1,1,0-5.44434h76.42224a2.72217,2.72217,0,1,1,0,5.44434Z" transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                                <path d="M486.02785,524.10038a7.50681,7.50681,0,0,1,.40432-11.50371l-8.59393-25.25455,13.41439,3.49664,6.10437,23.44608a7.5475,7.5475,0,0,1-11.32915,9.81554Z" transform="translate(-301.81156 -177.97946)" fill="#ffb6b6" />
                                                <path d="M480.091,507.26649l-13.90729-51.41262-1.21775-62.637a11.83726,11.83726,0,0,1,8.26524-11.57117h0a11.91077,11.91077,0,0,1,15.54083,11.881l-2.24031,49.28585,11.0338,58.83228Z" transform="translate(-301.81156 -177.97946)" fill="#3f3d56" />
                                                <path d="M435.78853,525.59342a7.50681,7.50681,0,0,1,.40432-11.50371l-8.59393-25.25455,13.41439,3.49664,6.10437,23.44607a7.54751,7.54751,0,0,1-11.32915,9.81555Z" transform="translate(-301.81156 -177.97946)" fill="#ffb6b6" />
                                                <path d="M427.73886,504.86958l-5.94947-52.86272,8.3148-62.16174a11.91033,11.91033,0,1,1,23.48319,3.92l-9.697,48.375,1.97412,59.82562Z" transform="translate(-301.81156 -177.97946)" fill="#3f3d56" />
                                                <path d="M881.80566,689.52373H560.38651V615.5533H881.80566Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M606.77462,640.01143a3.13177,3.13177,0,0,0,0,6.26355H835.43077a3.13178,3.13178,0,0,0,0-6.26355Z" transform="translate(-301.81156 -177.97946)" fill="#e6e6e6" />
                                                <path d="M606.77462,658.80205a3.13178,3.13178,0,0,0-.01322,6.26355H751.32018a3.13178,3.13178,0,1,0,0-6.26355Z" transform="translate(-301.81156 -177.97946)" fill="#e6e6e6" />
                                                <path d="M881.80566,689.52373H560.38651V615.5533H881.80566Zm-316.13555-5.2836h310.852V620.8369H565.67011Z" transform="translate(-301.81156 -177.97946)" fill="#e5e5e5" />
                                                <path d="M375.32638,476.77757a13.42111,13.42111,0,1,1,13.42112-13.4211A13.42112,13.42112,0,0,1,375.32638,476.77757Z" transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                                <path d="M436.55947,286.59079a14.812,14.812,0,1,1,14.812-14.812A14.812,14.812,0,0,1,436.55947,286.59079Z" transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                                <path d="M818.616,392.45655A12.73855,12.73855,0,1,1,831.35451,379.718,12.73855,12.73855,0,0,1,818.616,392.45655Z" transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                                <rect x="240.89923" y="133.27712" width="195.25492" height="147.44576" fill="#fff" />
                                                <path d="M740.52256,461.2592H540.15392V308.69972H740.52256Zm-195.25491-5.11372H735.40884v-142.332H545.26765Z" transform="translate(-301.81156 -177.97946)" fill="#e4e4e4" />
                                                <polygon points="433.936 136.289 244.223 136.289 433.936 279.289 433.936 136.289" fill="#f0f0f0" />
                                                <path d="M845.55064,720.43928a28.73541,28.73541,0,1,1,28.73542-28.7354A28.73541,28.73541,0,0,1,845.55064,720.43928Z" transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                                <path d="M856.88887,688.86936h-8.50362v-8.50374a2.83461,2.83461,0,0,0-5.66922,0v8.50374H834.2123a2.83457,2.83457,0,0,0,0,5.66913H842.716v8.50372a2.83461,2.83461,0,0,0,5.66922,0v-8.50372h8.50362a2.83457,2.83457,0,1,0,0-5.66913Z" transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                                <path d="M880.615,722.02054H303.321a1.19069,1.19069,0,0,1,0-2.38137H880.615a1.19069,1.19069,0,0,1,0,2.38137Z" transform="translate(-301.81156 -177.97946)" fill="#cacaca" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php endif ?>
        <!----------------------------Message Flash----------------------------------------->
        <?php if (!empty($flashMessages)) : ?>
            <ul class="flash-messages-container">
                <?php foreach ($flashMessages as $flashMessage) : ?>
                    <li class="flash-message <?= $flashMessage->getType() ?>">
                        <?php if ($flashMessage->getType() === "success") : ?>
                            <i class="success fi fi-rr-check-circle text-red-500"></i>
                        <?php elseif ($flashMessage->getType() === "info") : ?>
                            <i class="info fi fi-rr-info"></i>
                        <?php elseif ($flashMessage->getType() === "warning") : ?>
                            <i class="warning fi fi-rr-exclamation"></i>
                        <?php elseif ($flashMessage->getType() === "error") : ?>
                            <i class="error fi fi-rr-cross-circle"></i>
                        <?php endif ?>
                        <p><?= $flashMessage->getContent() ?></p>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>
        <p id="cssgenerator" class="!hidden  self-center"></p>
    </header>
    <?php require_once $template ?>
    <!----------------------------bar du bas----------------------------------------->
    <?php if ($footer) : ?>
        <footer class="bg-slate-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800">Stageo</h2>
                        <ul class="text-gray-600 space-y-2">
                            <li><a href="<?= Action::A_PROPOS->value?>">À propos</a></li>
                            <li><a href="<?= Action::CONTACT->value?>">Contact</a></li>
                            <li><a href="<?= Action::CONTACT->value?>"> Nous contacter</a></li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800">Employeurs</h2>
                        <ul class="text-gray-600 space-y-2">
                            <li>
                                <a href="<?= Action::ENTREPRISE_SIGN_UP_STEP_1_FORM->value?>">Créer son compte Entreprise</a>
                            </li>
                            <li>
                                <a href="<?= Action::ENTREPRISE_SIGN_IN_FORM->value?>">Connexion Entreprise</a>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-4 mt-8 sm:mt-0">
                        <h2 class="text-lg font-semibold text-gray-800">Informations</h2>
                        <ul class="text-gray-600 space-y-2">
                            <li>
                                <?php if (UserConnection::isInstance(new Entreprise)) : ?>
                                    <a href="<?= Action::TUTORIEL_ENTREPRISE->value ?>">Aide et contact</a>
                                <?php elseif (UserConnection::isInstance(new Etudiant)) : ?>
                                    <a href="<?= Action::TUTORIEL_ETUDIANT->value ?>">Aide et contact</a>
                                <?php elseif (UserConnection::isInstance(new Secretaire)) : ?>
                                    <a href="<?= Action::TUTORIEL_SECRETAIRE->value ?>">Aide et contact</a>
                                <?php elseif (UserConnection::isInstance(new Admin)) : ?>
                                    <a href="<?= Action::TUTORIEL_ADMIN->value ?>">Aide et contact</a>
                                <?php else: ?>
                                    <a href="<?= Action::TUTORIEL->value ?>">Aide et contact</a>
                                <?php endif; ?>
                            </li>
                            <li>
                                <a href="<?= Action::CONFIDENTIALITE->value ?>">Conditions d'utilisation</a>
                            </li>
                            <li>
                                <a href="<?= Action::CONFIDENTIALITE->value ?>">Confidentialité et cookies</a>
                            </li>
                            <li>
                                <a href="<?= Action::CONFIDENTIALITE->value ?>">Centre de confidentialité</a>
                            </li>
                            <li>
                                <a href="<?= Action::CONFIDENTIALITE->value ?>">Outil de consentement aux cookies</a>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-4 mt-8 sm:mt-0">
                        <h2 class="text-lg font-semibold text-gray-800">Mention légales</h2>
                        <ul class="text-gray-600 space-y-2">
                            <li>
                                <a href="<?= Action::MENTION->value ?>">Mentions</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-4 border-t border-gray-300 pt-3">
                    <p class="text-gray-600 text-center">
                        Se connecter en tant que : Etudiant, Entreprise
                    </p>
                    <p class="text-gray-500 text-xs text-center mt-4">
                        Copyright © 2023, Stageo « Stageo » et son logo sont des branches officiel de l'IUT Montpellier/Sète.
                    </p>
                    <!----------------------------bouton pour connexion Admin----------------------------------------->
                    <p class="text-gray-500 text-xs text-center mt-4"><a href="<?= Action::ADMIN_SIGN_IN_FORM->value ?>">Espace Admin</a></p>
                </div>
            </div>
        </footer>
    <?php endif ?>
</body>

</html>