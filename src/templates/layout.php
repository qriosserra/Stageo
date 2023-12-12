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
    <title><?=$title ?? "Sans titre"?> | Stageo</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-straight/css/uicons-solid-straight.css" >
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css">
    <link rel='stylesheet' href="https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-straight/css/uicons-regular-straight.css">
    <link rel='stylesheet' href="https://cdn-uicons.flaticon.com/2.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.jsdelivr.net/npm/flowbite/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="assets/js/script.js"></script>
    <style>
        #dropdownContentEntreprise,
        #dropdownContentOffres,
        #dropdownContentMission {
            display: block;
            opacity: 0;
            visibility: hidden;
            transition: visibility 0.2s linear, opacity 0.2s ease-in-out;
            position: absolute;
            background-color: #ffffff;
        }

        #dropdownContentEntreprise.active,
        #dropdownContentOffres.active,
        #dropdownContentMission.active {
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
    <?php if ($nav):?>
        <nav class="bg-white w-full z-20 border-b border-gray-200 dark:border-gray-200" >
            <div class="max-w-screen-xl flex flex-wrap md:pl-4 md:pr-4 items-center justify-between mx-auto md:p-0 p-4">
                <a href="<?=Action::HOME->value?>" class="flex items-center">
                    <img src="assets/img/logo.png" alt="logo" class="h-[1.8rem] w-[7rem] mr-3">
                </a>

                <!----------------------------Bouton à droite----------------------------------------->
                <div class="flex md:order-2">
                    <!----------------------------Drop down User !!! ----------------------------------------->
                    <?php if (is_null($user)) : ?>
                        <a href="<?=Action::ETUDIANT_SIGN_IN_FORM->value?>" class="space-x-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fi fi-rr-sign-in-alt flex align-middle text-lg float-left"></i>
                            <span>Se connecter</span>
                        </a>
                    <?php else : ?>
                        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                            <button type="button"
                                    class="flex text-sm rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                                    data-dropdown-placement="bottom">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="assets/img/utilisateur.png" alt="user photo">
                                <!-- //TODO : Photo -->
                            </button>
                            <!-- Dropdown menu -->
                            <div
                                    class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                                    id="user-dropdown">
                                <div class="px-4 py-3">
                                    <span class="block text-sm text-gray-900 dark:text-white">
                                        <?php if ($user instanceof Enseignant || UserConnection::isInstance(new Etudiant())) :?><?=/** @var Admin|Etudiant $user */ $user->getNom()." ".$user->getPrenom()?>
                                        <?php elseif (UserConnection::isInstance(new Entreprise())) : ?><?=/** @var Entreprise $user */ $user->getRaisonSociale()?>
                                        <?php else : ?>secrétariat
                                        <?php endif ?>
                                    </span>
                                    <span class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?=$user->getEmail()?></span>
                                    <!-- //TODO : email du mec et tout -->
                                </div>
                                <!-- Menu étudiant -->
                                <?php if (UserConnection::isInstance(new Etudiant())) :?>
                                <ul class="py-2" aria-labelledby="user-menu-button">
                                    <li>
                                        <a href="<?=Action::PROFILE_ETUDIANT->value?>"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profil</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mes Candidatures</a>
                                    </li>
                                    <li>
                                        <a href="<?=Action::ETUDIANT_CONVENTION_ADD_STEP_1_FORM->value?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Deposer une convention</a>
                                    <li>
                                        <a href="<?=Action::SIGN_OUT->value?>"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                    </li>
                                </ul>
                                <?php endif ?>
                                <!-- Menue entreprise -->
                                <?php if (UserConnection::isInstance(new Entreprise())) :?>
                                    <ul class="py-2" aria-labelledby="user-menu-button">
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profil</a>
                                        </li>
                                        <li>
                                            <a href="<?=Action::ENTREPRISE_POSTULE_OFFRE_ETUDIANT->value?>"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Candidats Offres</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                        </li>
                                        <?php if (UserConnection::isInstance(new Etudiant())) {
                                            echo "<li>
                                        <a href=\"".Action::ETUDIANT_CONVENTION_ADD_FORM->value."\"
                                           class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white\">Deposer une convention</a>";
                                        } ?>
                                        <li>
                                            <a href="<?=Action::SIGN_OUT->value?>"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                        </li>
                                    </ul>
                                <?php endif ?>
                                <!-- Menu Admin -->
                                <?php if (($user instanceof Enseignant && $user->getEstAdmin())) :?>
                                    <ul class="py-2" aria-labelledby="user-menu-button">
                                        <li>
                                            <a href="<?= Action::ADMIN_DASH->value?>"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tableau de bord</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                        </li>
                                        <li>
                                            <a href="<?=Action::SIGN_OUT->value?>"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                        </li>
                                    </ul>
                                <?php endif ?>
                                <!-- Menu Prof -->
                                <?php if (($user instanceof Enseignant && !$user->getEstAdmin())) :?>
                                    <ul class="py-2" aria-labelledby="user-menu-button">
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tableau de bord</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                        </li>
                                        <li>
                                            <a href="<?=Action::SIGN_OUT->value?>"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                        </li>
                                    </ul>
                                <?php endif ?>
                                <!-- Menu Secretaries -->
                                <?php if (UserConnection::isInstance(new Secretaire())) :?>
                                    <ul class="py-2" aria-labelledby="user-menu-button">
                                        <li>
                                            <a href="<?= Action::SECRETAIRE_DASH->value?>"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tableau de bord</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
                                        </li>
                                        <li>
                                            <a href="<?=Action::SIGN_OUT->value?>"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
                                        </li>
                                    </ul>
                                    </ul>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <!----------------------------Menu Burger !!! ----------------------------------------->
                    <button data-collapse-toggle="navbar-user" type="button"
                            class=" ml-4 inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="navbar-user" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>
                <!----------------------------Bouton central----------------------------------------->
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 lg:mr-32" id="navbar-user">
                    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white  dark:border-gray-700">
                        <li class="relative">
                            <button class="block py-2 pl-3 pr-4 h-[4rem] text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700  md:dark:hover:text-blue-500 focus:outline-none" id="dropdownOffres">

                                <?php if(UserConnection::isSignedIn()) :?><a href="<?=Action::LISTE_OFFRE->value?>">Offres</a>
                                <?php else : ?><a href="<?=Action::ETUDIANT_SIGN_IN_FORM->value?>">Offres</a><?php endif ?>
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
                                            <path
                                                    d="M195.70439,282.1061c-9.38575,0-17.02112,7.63537-17.02112,17.02112v26.64175c0,9.38575,7.63537,17.02112,17.02112,17.02112h26.64175c9.38575,0,17.02112-7.63537,17.02112-17.02112v-26.64175c0-9.38575-7.63537-17.02112-17.02112-17.02112h-26.64175Z"
                                                    fill="#f2f2f2" />
                                            <g>
                                                <path
                                                        d="M213.3715,67.1061c-11.82633,0-21.44711,9.62079-21.44711,21.44711v33.56939c0,11.82633,9.62079,21.44711,21.44711,21.44711h33.56939c11.82633,0,21.44711-9.62079,21.44711-21.44711v-33.56939c0-11.82633-9.62079-21.44711-21.44711-21.44711h-33.56939Z"
                                                        fill="#63b4ff" />
                                                <path
                                                        d="M323.89034,160.9186c-11.82633,0-21.44711,9.62079-21.44711,21.44711v33.56939c0,11.82633,9.62079,21.44711,21.44711,21.44711h33.56939c11.82633,0,21.44711-9.62079,21.44711-21.44711v-33.56939c0-11.82633-9.62079-21.44711-21.44711-21.44711h-33.56939Z"
                                                        fill="#63b4ff" />
                                                <g>
                                                    <polygon
                                                            points="275.84229 498.80796 269.02267 498.75047 266.00379 471.83263 276.06892 471.91748 275.84229 498.80796"
                                                            fill="#a0616a" />
                                                    <path
                                                            d="M253.99807,509.65233c-.01481,1.6785,1.33828,3.06028,3.0229,3.07572l13.55914,.11314,2.37372-4.81149,.8718,4.83603,5.11615,.0464-1.2919-17.24842-1.77998-.11842-7.26029-.50048-2.34232-.15686-.0411,4.88024-10.89209,7.38777c-.82869,.56298-1.32776,1.49545-1.33604,2.49637Z"
                                                            fill="#2f2e41" />
                                                </g>
                                                <g>
                                                    <polygon
                                                            points="310.54007 498.80796 303.72044 498.75047 300.70157 471.83263 310.76669 471.91748 310.54007 498.80796"
                                                            fill="#a0616a" />
                                                    <path
                                                            d="M288.69584,509.65233c-.01481,1.6785,1.33828,3.06028,3.0229,3.07572l13.55914,.11314,2.37372-4.81149,.8718,4.83603,5.11615,.0464-1.2919-17.24842-1.77998-.11842-7.26029-.50048-2.34232-.15686-.0411,4.88024-10.89209,7.38777c-.82869,.56298-1.32776,1.49545-1.33604,2.49637Z"
                                                            fill="#2f2e41" />
                                                </g>
                                                <path
                                                        d="M249.08109,281.17831l27.64346,.87295,26.18854,5.81968s-2.61885,3.20082,6.11066,11.93033c0,0,11.63935,20.36886,3.49181,40.15576l-3.49181,79.14758s10.18085,55.79388,2.40219,73.5511l-10.28082,.64255-17.39634-73.54982-8.47914-79.20944-4.07377,77.98365s15.58482,53.52659,5.74359,74.77562l-11.13465-.64255-19.05157-74.13307s-8.14755-85.54922-6.98361-101.84432c1.16394-16.29509,9.31148-35.50002,9.31148-35.50002Z"
                                                        fill="#2f2e41" />
                                                <g>
                                                    <path
                                                            d="M341.91407,156.11273c-3.77892,.97845-6.04918,4.83514-5.07069,8.61407,.44834,1.73156,1.50489,3.14028,2.87746,4.07089l-.00041,.00966-.53609,12.98479,9.93665,4.59846,.7932-19.98146-.06921,.00211c.86159-1.53494,1.15931-3.38933,.68324-5.22793-.97848-3.77893-4.83517-6.04911-8.61416-5.0706Z"
                                                            fill="#a0616a" />
                                                    <path
                                                            d="M286.37793,202.45483c-2.08746-2.06912-3.29844-4.87434-3.34374-7.92486-.06088-4.09228,1.98991-7.80651,5.48559-9.93539,4.02563-2.45174,9.05967-2.20364,12.82498,.63119l31.20286,23.4935,5.55989-33.84423,11.93675,3.84257-2.84806,44.07c-.19948,3.08263-1.94154,5.7983-4.6607,7.26426-2.71916,1.46596-5.94507,1.42927-8.63009-.09817l-45.0929-25.65511c-.90583-.51546-1.7216-1.13691-2.43458-1.84377Z"
                                                            fill="#3f3d56" />
                                                </g>
                                                <g>
                                                    <path
                                                            d="M238.79919,137.1819c1.9947,3.35541,.89159,7.69261-2.46385,9.68729-1.5375,.914-3.27962,1.17053-4.90955,.86503l-.00651,.00715-8.76131,9.59852-10.29404-3.73037,13.50476-14.7482,.04766,.05023c.46883-1.69663,1.563-3.22314,3.19555-4.19363,3.35544-1.99468,7.69258-.89152,9.68729,2.46398Z"
                                                            fill="#a0616a" />
                                                    <path
                                                            d="M242.58351,208.7873l-50.08512-13.52903c-2.98215-.8057-5.29885-3.05086-6.19773-6.00635-.89888-2.95549-.22401-6.11051,1.80467-8.44008l29.00517-33.30129,11.18221,5.67535-19.87987,27.94879,38.69929,5.28473c4.66979,.63785,8.41937,4.00591,9.55199,8.58126,.98359,3.97296-.17507,8.05448-3.09949,10.91773-2.17991,2.13441-5.01491,3.27394-7.95408,3.27362-1.00399,0-2.02084-.13303-3.02702-.40473Z"
                                                            fill="#3f3d56" />
                                                </g>
                                                <path
                                                        d="M313.98891,292.82223l-70.0381,3.21276c-1.92358-2.92109-1.40264-7.31347,1.29122-12.81367,10.17125-20.76721,2.44654-60.05462-2.74985-80.51179-1.45798-5.73976,2.4559-11.44589,8.34855-12.03515l6.60367-.66037,6.10424-18.63399h21.37875l8.86923,10.13266,15.05189,9.14389c-2.73972,28.22064-14.41356,68.0706,2.2172,88.05507,3.63737,4.37087,4.66873,9.09743,2.92321,14.1106Z"
                                                        fill="#3f3d56" />
                                                <circle cx="271.51868" cy="150.9868" r="20.82357" fill="#a0616a" />
                                                <path
                                                        d="M295.08231,137.65762c2.8972-10.56287-28.67928-19.62073-34.81549-11.11444-.85326-1.20934-4.00655-1.9439-5.45336-1.57293-1.44681,.37097-2.66357,1.29841-3.85072,2.19619-1.6323,1.2539-3.32392,2.55231-4.32553,4.35524-1.00909,1.79551-1.16487,4.24398,.19287,5.80205,1.07584,1.23904,2.9663,7.82332,4.58375,8.14978,1.12773,.23,2.07745,.41549,2.89358,.54904,.72714-1.06098,2.58132-2.39375,2.44778-3.67731,1.09807,.7271,.69691,2.00635,.47552,3.31376-.73718,4.35363-17.34626,38.05525-7.83345,28.12415,.9423,.55647,2.10715,1.07583,3.45008,1.55065,2.27775-3.43523,4.14747-7.48625,5.37914-11.7228l.00872,.07826c.42405,3.68168,3.11456,6.70263,6.67421,7.73388,14.27942,4.13681,25.82989-1.93337,29.80326-12.87997-1.45451-2.95297-2.08826-2.63223-1.95797-2.72004,1.81577-1.2238,4.31135-.42345,5.09179,1.62242,.2301,.60321,.43924,1.1182,.62043,1.50569,2.07002-7.40469,4.53201-6.33593-3.38458-21.29362Z"
                                                        fill="#2f2e41" />
                                                <path
                                                        d="M285.23139,129.99395l-1.4586-7.45697c-.12261-.62684-.23896-1.30695,.04369-1.87973,.36317-.73595,1.29668-1.04096,2.10893-.92366,.81225,.11729,1.41978,.85923,2.22791,1.0021,2.80975,.49673,6.52379-2.27858,7.53053,4.7424,.41975,2.92732,5.09082,3.23652,6.65079,5.74883,1.55997,2.51232,1.75148,6.13862-.37749,8.19111-1.70031,1.63923-4.43095,1.82843-6.63933,.99107-2.20838-.83736-3.98071-2.52874-5.52887-4.31237s-2.9501-3.71374-4.73583-5.25948"
                                                        fill="#2f2e41" />
                                                <path
                                                        d="M296.19459,141.33592c-5.69794-.79597-9.5818-2.86826-11.54365-6.15883-2.5677-4.30742-.84774-9.05031-.77338-9.25017l1.20447,.44772c-.016,.04361-1.57626,4.38523,.67957,8.15551,1.75478,2.9329,5.32489,4.79466,10.61057,5.53322l-.17758,1.27255Z"
                                                        fill="#63b4ff" />
                                            </g>
                                            <path
                                                    d="M322.93382,60.76232c-16.75117,0-30.38116-13.62998-30.38116-30.38116S306.18264,0,322.93382,0s30.38116,13.62998,30.38116,30.38116-13.62998,30.38116-30.38116,30.38116Zm0-48.60985c-10.05189,0-18.22869,8.1768-18.22869,18.22869s8.1768,18.22869,18.22869,18.22869,18.22869-8.1768,18.22869-18.22869-8.1768-18.22869-18.22869-18.22869Z"
                                                    fill="#63b4ff" />
                                            <path
                                                    d="M369.67748,81.40904c-1.48939,0-2.98174-.54294-4.15367-1.64367l-28.51497-26.72296c-2.45067-2.29342-2.57528-6.13854-.27889-8.58624,2.29045-2.4566,6.13557-2.57824,8.58624-.27889l28.51497,26.72296c2.45067,2.29342,2.57528,6.13854,.27889,8.58624-1.19566,1.27874-2.81263,1.92256-4.43256,1.92256Z"
                                                    fill="#63b4ff" />
                                            <g>
                                                <path
                                                        d="M498.55135,498.12587c2.06592,.12937,3.20768-2.43737,1.64468-3.93333l-.1555-.61819c.02047-.04951,.04105-.09897,.06178-.14839,2.08924-4.9818,9.16992-4.94742,11.24139,.04177,1.83859,4.42817,4.17942,8.86389,4.75579,13.54594,.25838,2.0668,.14213,4.17236-.31648,6.20047,4.30807-9.41059,6.57515-19.68661,6.57515-30.02077,0-2.59652-.14213-5.19301-.43275-7.78295-.239-2.11854-.56839-4.2241-.99471-6.31034-2.30575-11.2772-7.29852-22.01825-14.50012-30.98962-3.46197-1.89248-6.34906-4.85065-8.09295-8.39652-.62649-1.27891-1.11739-2.65462-1.34991-4.05618,.39398,.05168,1.48556-5.94866,1.18841-6.3168,.54906-.83317,1.53178-1.24733,2.13144-2.06034,2.98232-4.04341,7.0912-3.33741,9.23621,2.15727,4.58224,2.31266,4.62659,6.14806,1.81495,9.83683-1.78878,2.34682-2.03456,5.52233-3.60408,8.03478,.16151,.20671,.32944,.40695,.4909,.61366,2.96106,3.79788,5.52208,7.88002,7.68104,12.16859-.61017-4.76621,.29067-10.50822,1.82641-14.20959,1.74819-4.21732,5.02491-7.76915,7.91045-11.41501,3.46601-4.37924,10.57337-2.46806,11.18401,3.08332,.00591,.05375,.01166,.10745,.01731,.1612-.4286,.24178-.84849,.49867-1.25864,.76992-2.33949,1.54723-1.53096,5.17386,1.24107,5.60174l.06277,.00967c-.15503,1.54366-.41984,3.07444-.80734,4.57937,3.70179,14.31579-4.29011,19.5299-15.70147,19.76412-.25191,.12916-.49738,.25832-.74929,.38109,1.15617,3.25525,2.07982,6.59447,2.76441,9.97891,.61359,2.99043,1.03991,6.01317,1.27885,9.04888,.29715,3.83006,.27129,7.67959-.05168,11.50323l.01939-.13562c.82024-4.21115,3.10671-8.14462,6.4266-10.87028,4.94561-4.06264,11.93282-5.55869,17.26826-8.82425,2.56833-1.57196,5.85945,.45945,5.41121,3.43708l-.02182,.14261c-.79443,.32289-1.56947,.69755-2.31871,1.11733-.4286,.24184-.84848,.49867-1.25864,.76992-2.33949,1.54729-1.53096,5.17392,1.24107,5.6018l.06282,.00965c.0452,.00646,.08397,.01295,.12911,.01944-1.36282,3.23581-3.26168,6.23922-5.63854,8.82922-2.31463,12.49713-12.25603,13.68282-22.89022,10.04354h-.00648c-1.16259,5.06378-2.86128,10.01127-5.0444,14.72621h-18.02019c-.06463-.20022-.12274-.40692-.18089-.60717,1.6664,.10341,3.34571,.00649,4.98629-.29702-1.33701-1.64059-2.67396-3.29409-4.01097-4.93462-.03229-.0323-.05816-.0646-.08397-.09689-.67817-.8396-1.36282-1.67283-2.04099-2.51246l-.00036-.00102c-.04245-2.57755,.26652-5.14662,.87876-7.63984l.00057-.00035Z"
                                                        fill="#f2f2f2" />
                                                <path
                                                        d="M0,514.26882c0,.66003,.53003,1.19,1.19006,1.19H551.48004c.65997,0,1.19-.52997,1.19-1.19,0-.65997-.53003-1.19-1.19-1.19H1.19006c-.66003,0-1.19006,.53003-1.19006,1.19Z"
                                                        fill="#ccc" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="relative">
                            <button class="block py-2 pl-3 pr-4 h-[4rem]  text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent focus:outline-none md:hover:text-blue-700 md:dark:hover:text-blue-500"
                                    id=
                                    <?php if(UserConnection::isInstance(new Etudiant())) :?>""><a href="<?=Action::ABOUT->value?>">Fonctionement</a>
                                <?php else :?>"dropdownButtonMission"><a href="<?=Action::ABOUT->value?>">Notre mission</a><?php endif?>
                            </button>
                            <div class="absolute hidden text-gray-700 pt-1 border border-slate-300 "
                                 id="dropdownContentMission">
                                <div class="rounded  ease-in-out ml-3 mt-3 flex flex-row justify-end ">
                                    <div class="w-1/2">
                                        <span class="font-bold">Votre Guichet Unique</span>
                                        <p class="mt-2">Notre mission est d'assister les étudiants dans la recherche de
                                            stages et d'alternances, en centralisant toutes les informations nécessaires en
                                            un seul lieu accessible à tous.</p>
                                    </div>
                                    <div class="w-1/2">
                                        <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="250" height="170"
                                             viewBox="0 0 596.37688 544.04108" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <path
                                                    d="M855.29485,597.93371c27.13492-18.1824,46.62014-50.4909,42.13358-82.84441a150.49327,150.49327,0,0,1-92.28062,46.47676c-13.61223,1.53821-28.91247,1.83171-38.46765,11.648-5.94558,6.10781-8.39172,14.9551-8.41431,23.47859-.02237,8.52391,2.13257,16.88565,4.27284,25.13654l-.47347,2.07451C794.6883,622.28,828.15993,616.1161,855.29485,597.93371Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                            <path
                                                    d="M896.74305,515.09107a128.63128,128.63128,0,0,1-50.2678,61.12728,55.39337,55.39337,0,0,1-15.77341,7.24012,31.77037,31.77037,0,0,1-16.71515-.42757c-5.09688-1.42033-10.14595-3.4634-15.49933-3.62a19.453,19.453,0,0,0-14.61047,6.29567c-4.75089,4.91238-7.45336,11.23887-9.88115,17.51748-2.69559,6.97121-5.385,14.25482-10.99,19.46433-.67911.6312.34,1.64805,1.0181,1.0178,9.75164-9.06365,10.65407-23.41657,18.2765-33.88435,3.55676-4.88446,8.60707-8.72664,14.83827-8.96608,5.44891-.20938,10.65736,1.893,15.80563,3.37571a33.90139,33.90139,0,0,0,16.32824,1.027,51.20935,51.20935,0,0,0,15.99357-6.607,124.795,124.795,0,0,0,29.76934-25.20129,130.9121,130.9121,0,0,0,23.10043-37.99415c.33865-.8598-1.05637-1.21917-1.39281-.365Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M854.08147,571.95293a19.29879,19.29879,0,0,0,24.66368,4.02475c.79162-.4809.08152-1.73364-.71116-1.2521a17.87025,17.87025,0,0,1-22.93471-3.79075c-.5968-.70848-1.6112.31368-1.01781,1.0181Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M816.47616,584.09142A37.19687,37.19687,0,0,1,828.13567,559.619c.67686-.63359-.34206-1.65063-1.0181-1.0178a38.69031,38.69031,0,0,0-12.081,25.4904c-.06377.926,1.37618.92073,1.4396-.00021Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M883.027,541.61616a10.924,10.924,0,0,1-4.188-9.48194c.07547-.92469-1.36462-.91847-1.4396.00021a12.24127,12.24127,0,0,0,4.60977,10.49983.744.744,0,0,0,1.018-.00015.72344.72344,0,0,0-.00015-1.01795Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M803.33209,456.98207c-.06355.576-.12709,1.15211-.20124,1.73416a143.86343,143.86343,0,0,1-4.55041,22.88883c-.1558.582-.32245,1.16948-.49465,1.74579a151.66435,151.66435,0,0,1-25.44969,49.70134A147.28527,147.28527,0,0,1,757.62364,549.648c-7.48257,7.10259-16.1607,14.20825-20.72555,23.106a25.26634,25.26634,0,0,0-1.28463,2.85119l23.95767,47.55994c.10869.08076.20685.16749.3158.24878l.86973,1.94266c.298-.24574.60168-.507.89963-.75276.17342-.14183.34151-.29426.51493-.43609.11393-.09791.22765-.19638.33605-.27822.038-.03245.07582-.06543.10307-.09244.1084-.08184.2004-.16937.29794-.24574q2.55274-2.18368,5.08367-4.41085c.01086-.00547.01086-.00547.01638-.02154,12.82741-11.34607,24.82029-23.8627,34.53212-37.80172.29206-.41947.59524-.84388.87635-1.28508a140.54241,140.54241,0,0,0,11.42187-19.88879,124.24716,124.24716,0,0,0,4.73049-11.64761,103.319,103.319,0,0,0,5.66486-31.80352c.41358-21.59478-6.08384-43.08144-20.76839-58.54012C804.08969,457.75694,803.71889,457.37179,803.33209,456.98207Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                            <path
                                                    d="M802.78232,457.39306a128.6312,128.6312,0,0,1-3.33319,79.0714A55.39286,55.39286,0,0,1,791.214,551.742a31.77037,31.77037,0,0,1-13.60354,9.72229c-4.9247,1.93462-10.18617,3.34323-14.55484,6.44129a19.453,19.453,0,0,0-7.87521,13.82325c-.83573,6.78262.81548,13.461,2.65719,19.93586,2.04487,7.189,4.28275,14.62383,2.944,22.15789-.16221.91286,1.26372,1.11117,1.42569.19969,2.32919-13.108-5.59172-25.1113-5.808-38.05847-.1009-6.04138,1.61823-12.14978,6.44933-16.09257,4.22459-3.44781,9.649-4.905,14.65232-6.82077a33.90136,33.90136,0,0,0,13.65553-9.01071,51.20958,51.20958,0,0,0,8.79212-14.90453,124.79539,124.79539,0,0,0,8.59623-38.045,130.91238,130.91238,0,0,0-4.4307-44.24426c-.24727-.89039-1.57748-.33744-1.33183.54714Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M802.9542,528.47929a19.29879,19.29879,0,0,0,22.11574-11.6357c.34254-.86059-.97868-1.4333-1.32167-.57157a17.87025,17.87025,0,0,1-20.59438,10.78158c-.90306-.20636-1.09759,1.22051-.19969,1.42569Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M780.23668,560.81219a37.1968,37.1968,0,0,1-5.42461-26.55967c.159-.91339-1.2669-1.112-1.42568-.19969a38.69027,38.69027,0,0,0,5.701,27.62627c.50658.77772,1.65314-.09341,1.14932-.86691Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M807.80076,486.82987a10.924,10.924,0,0,1-9.05265-5.04935c-.49647-.78376-1.64255.08825-1.14931.86691a12.24126,12.24126,0,0,0,10.00226,5.60812.744.744,0,0,0,.81269-.613.72344.72344,0,0,0-.613-.81269Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M302.16451,659.03216c2.00293-21.01281,14.38711-42.01532,34.16014-49.40225A97.25292,97.25292,0,0,0,338.245,676.373c3.30661,8.21186,7.83941,17.00112,5.19325,25.449-1.64639,5.25652-5.92524,9.36486-10.76442,11.99581-4.83949,2.631-10.25556,3.97415-15.6041,5.29166l-1.034.90641C306.9383,700.96891,300.16157,680.045,302.16451,659.03216Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                            <path
                                                    d="M336.53417,610.02013a83.1251,83.1251,0,0,0-19.31411,47.35634,35.7967,35.7967,0,0,0,.72856,11.192,20.53091,20.53091,0,0,0,5.37739,9.37223c2.37311,2.46161,5.08561,4.70476,6.819,7.70037a12.57112,12.57112,0,0,1,.90832,10.24073c-1.33368,4.21007-4.10057,7.68985-6.92461,10.99876-3.13557,3.6739-6.45065,7.44026-7.69093,12.22718-.15028.58-1.04146.31291-.89141-.26622,2.15789-8.32841,10.04119-13.25019,13.65143-20.79932,1.6846-3.52256,2.31784-7.57414.54-11.1905-1.55466-3.16235-4.34983-5.47789-6.7742-7.94956a21.90793,21.90793,0,0,1-5.59936-8.96813,33.093,33.093,0,0,1-1.15618-11.12273,80.64633,80.64633,0,0,1,5.1844-24.66657,84.59938,84.59938,0,0,1,14.50636-24.8044c.38483-.45664,1.01765.22612.63534.67978Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M317.30885,651.74169a12.4714,12.4714,0,0,1-9.86409-12.78653.46556.46556,0,0,1,.93034.01974,11.54825,11.54825,0,0,0,9.2,11.87539c.58612.1217.31655,1.01241-.26622.8914Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M321.95836,676.85108A24.03763,24.03763,0,0,0,332.291,662.70492c.15233-.57945,1.04355-.31253.89141.26622a25.00277,25.00277,0,0,1-10.782,14.69851c-.50688.32067-.9462-.49963-.44207-.81857Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M325.66612,625.96607a7.05941,7.05941,0,0,0,6.67745-.53139c.50256-.32694.94137.49375.44208.81857a7.91067,7.91067,0,0,1-7.38574.60423.4808.4808,0,0,1-.3126-.57882.46751.46751,0,0,1,.57881-.31259Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M394.26507,645.28094c-.308.21307-.616.42615-.92417.64709-4.12735,2.88334-4.00948,6.1053-7.616,9.61779-.28305.26735-.56587.54256-.84065.81748a98.00977,98.00977,0,0,0-20.441,29.73612,95.1784,95.1784,0,0,0-4.82446,13.63312c-1.73988,6.436-3.11428,13.55259-6.771,18.88105a16.32732,16.32732,0,0,1-1.22648,1.60617l-34.39961.98729c-.0793-.037-.15876-.06616-.23845-.10314l-1.37167.10222c.0482-.24488.10346-.49783.15166-.74271.02737-.14217.0624-.28456.08977-.42672.02068-.09485.04173-.18976.055-.27653.00676-.0316.01391-.0632.0209-.087.01323-.08677.03474-.166.0482-.24488q.45744-2.12214.94631-4.24522c-.00022-.00786-.00022-.00786.00722-.01594a139.94787,139.94787,0,0,1,10.88555-31.24489c.14879-.2949.297-.59764.46147-.893a90.82268,90.82268,0,0,1,7.7996-12.60314,80.292,80.292,0,0,1,5.16933-6.26728,66.7677,66.7677,0,0,1,16.34218-12.98969c12.1509-6.86827,22.36313-9.774,35.66288-6.1733C393.59179,645.08821,393.92468,645.18073,394.26507,645.28094Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                            <path
                                                    d="M394.20026,645.71976c-16.854,3.84769-28.5879,13.10467-39.933,26.183a35.79664,35.79664,0,0,0-6.15666,9.37487,20.53093,20.53093,0,0,0-1.3492,10.72076c.41274,3.39423,1.228,6.81837.80846,10.25383a12.57116,12.57116,0,0,1-5.44038,8.72353c-3.59963,2.55854-7.9039,3.67109-12.15093,4.61279-4.71552,1.04558-9.63,2.0569-13.50239,5.13225-.46919.37262-1.01993-.37719-.55145-.74925,6.73723-5.35057,15.99486-4.534,23.42253-8.388,3.46588-1.79832,6.41082-4.652,7.1686-8.60988.66264-3.461-.175-6.99269-.62264-10.42582a21.908,21.908,0,0,1,.92865-10.53174,33.09308,33.09308,0,0,1,5.77351-9.577,80.6461,80.6461,0,0,1,18.99044-16.57351c8.1356-5.17,13.11949-8.9258,22.51647-11.07109.5822-.13292.6764.79324.098.92528Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M357.73066,667.45712a12.4714,12.4714,0,0,1-.17755-16.14819c.38408-.45909,1.11553.11618.73094.57588a11.54824,11.54824,0,0,0,.19586,15.02085c.39471.45006-.35679.99894-.74925.55146Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M346.32544,690.30489a24.03764,24.03764,0,0,0,16.767-5.07395c.47049-.37094,1.02138.37875.55145.74925a25.00269,25.00269,0,0,1-17.45833,5.24443c-.59778-.04913-.45467-.9686.13986-.91973Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M379.92218,651.90838a7.05937,7.05937,0,0,0,5.6515,3.596c.59811.04154.45436.961-.13986.91974a7.91065,7.91065,0,0,1-6.26089-3.96428.48078.48078,0,0,1,.0989-.65035.4675.4675,0,0,1,.65035.09889Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M731.2907,179.97949H707.76008a17.47213,17.47213,0,0,1-16.17679,24.07086H588.31146a17.4721,17.4721,0,0,1-16.17679-24.07089H550.157a36.77582,36.77582,0,0,0-36.77585,36.77578V682.85712A36.77582,36.77582,0,0,0,550.157,719.633H731.2907a36.77583,36.77583,0,0,0,36.77585-36.77581h0V216.75527A36.7758,36.7758,0,0,0,731.2907,179.97949Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M731.29071,721.63278H550.15716A38.82015,38.82015,0,0,1,511.381,682.8569V216.75534a38.82026,38.82026,0,0,1,38.77588-38.77588h24.95361l-1.124,2.75537a15.47185,15.47185,0,0,0,14.325,21.31543H691.58319a15.47273,15.47273,0,0,0,14.32519-21.31543l-1.12377-2.75537h26.5061a38.81994,38.81994,0,0,1,38.77588,38.77588V682.85739A38.81952,38.81952,0,0,1,731.29071,721.63278ZM550.15692,181.97946A34.81568,34.81568,0,0,0,515.381,216.75534V682.8569a34.81535,34.81535,0,0,0,34.77588,34.77588H731.29071a34.81494,34.81494,0,0,0,34.77588-34.77539v-466.102a34.81536,34.81536,0,0,0-34.77588-34.77588H710.50506a19.47334,19.47334,0,0,1-18.92187,24.0708H588.31146a19.47855,19.47855,0,0,1-18.92163-24.0708Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#e4e4e4" />
                                            <path
                                                    d="M732.64908,251.61253H678.02741a2.31653,2.31653,0,1,1,0-4.63307h54.62167a2.31654,2.31654,0,1,1,0,4.63307Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                            <path
                                                    d="M732.64908,262.00678H678.02741a2.31653,2.31653,0,1,1,0-4.63307h54.62167a2.31654,2.31654,0,1,1,0,4.63307Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                            <path
                                                    d="M732.64908,272.401H678.02741a2.31653,2.31653,0,1,1,0-4.63307h54.62167a2.31654,2.31654,0,1,1,0,4.63307Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                            <polygon
                                                    points="154.571 533.534 163.723 533.533 168.077 498.232 154.57 498.232 154.571 533.534"
                                                    fill="#ffb6b6" />
                                            <path
                                                    d="M454.04829,708.52489l18.024-.00073h.00073a11.48692,11.48692,0,0,1,11.48629,11.4861v.37326l-29.51045.0011Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#2f2e41" />
                                            <polygon
                                                    points="118.788 525.015 127.421 528.053 143.248 496.2 130.506 491.716 118.788 525.015"
                                                    fill="#ffb6b6" />
                                            <path
                                                    d="M419.3896,699.40109l17.00193,5.98318.00068.00024a11.4869,11.4869,0,0,1,7.02148,14.648l-.12392.35209-27.837-9.79629Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#2f2e41" />
                                            <polygon
                                                    points="113.349 328.346 107.808 334.381 130.205 427.612 153.216 518.531 171.613 518.531 161.032 431.768 161.032 342.537 113.349 328.346"
                                                    fill="#2f2e41" />
                                            <polygon
                                                    points="170.599 335.823 173.024 344.852 160.065 425.373 141.663 510.695 120.826 510.695 136.47 406.078 155.586 329.072 170.599 335.823"
                                                    fill="#2f2e41" />
                                            <path
                                                    d="M483.86346,380.0269l-8.1-14.54109-19.21464-3.14487h0a48.54943,48.54943,0,0,0-35.9073,42.2181L410.22317,511.2629s53.30848,24.53518,64.61207,10.72165L490.5549,400.86821A23.94366,23.94366,0,0,0,483.86346,380.0269Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#3f3d56" />
                                            <circle cx="168.39709" cy="159.2562" r="20.38889" fill="#ffb6b6" />
                                            <path
                                                    d="M496.99365,326.12061a5.047,5.047,0,0,1-2.98816-2.2978,4.88486,4.88486,0,0,1-.02313-4.9765,7.382,7.382,0,0,0-6.11737-.31109,6.96584,6.96584,0,0,0,2.356-5.88465q-3.67008,1.2421-7.34009,2.48407a5.39457,5.39457,0,0,0,1.85156-5.9563c-2.0083,2.86091-6.16742,3.24512-9.55713,2.39173-3.38965-.85333-6.52136-2.6435-9.975-3.18219a14.16042,14.16042,0,0,0-16.28809,12.74762,5.29652,5.29652,0,0,0-4.14191,3.03314,11.36931,11.36931,0,0,0-.976,5.22955,28.00825,28.00825,0,0,0,11.22565,22.02649l1.12665-.38769a9.0229,9.0229,0,0,1,8.09137-9.47949c2.9906-.18763,6.522,1.01,8.65637-1.09314,1.95263-1.92414,1.254-5.36866,2.84765-7.59919,1.38617-1.94012,4.14368-2.39251,6.48236-1.92779,2.33875.46472,4.46662,1.64911,6.73792,2.37475,2.27136.72565,4.9317.92987,6.88446-.43841A6.97507,6.97507,0,0,0,498.453,327.493a10.0471,10.0471,0,0,0-.0105-1.25482A5.41585,5.41585,0,0,1,496.99365,326.12061Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#2f2e41" />
                                            <rect x="59.06516" y="338.52334" width="209.96204" height="60.80078"
                                                  fill="#fff" />
                                            <path
                                                    d="M572.7475,579.21232H358.968V514.59405H572.7475Zm-209.962-3.81749H568.93V518.41154H362.78546Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#e4e4e4" />
                                            <path
                                                    d="M530.05323,537.41023h-128.391a2.72217,2.72217,0,1,1,0-5.44434h128.391a2.72217,2.72217,0,1,1,0,5.44434Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                            <path
                                                    d="M530.05323,549.62572h-128.391a2.72254,2.72254,0,0,1,0-5.44507h128.391a2.72254,2.72254,0,0,1,0,5.44507Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                            <path
                                                    d="M478.08447,561.84049H401.66223a2.72217,2.72217,0,1,1,0-5.44434h76.42224a2.72217,2.72217,0,1,1,0,5.44434Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                            <path
                                                    d="M486.02785,524.10038a7.50681,7.50681,0,0,1,.40432-11.50371l-8.59393-25.25455,13.41439,3.49664,6.10437,23.44608a7.5475,7.5475,0,0,1-11.32915,9.81554Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#ffb6b6" />
                                            <path
                                                    d="M480.091,507.26649l-13.90729-51.41262-1.21775-62.637a11.83726,11.83726,0,0,1,8.26524-11.57117h0a11.91077,11.91077,0,0,1,15.54083,11.881l-2.24031,49.28585,11.0338,58.83228Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#3f3d56" />
                                            <path
                                                    d="M435.78853,525.59342a7.50681,7.50681,0,0,1,.40432-11.50371l-8.59393-25.25455,13.41439,3.49664,6.10437,23.44607a7.54751,7.54751,0,0,1-11.32915,9.81555Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#ffb6b6" />
                                            <path
                                                    d="M427.73886,504.86958l-5.94947-52.86272,8.3148-62.16174a11.91033,11.91033,0,1,1,23.48319,3.92l-9.697,48.375,1.97412,59.82562Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#3f3d56" />
                                            <path d="M881.80566,689.52373H560.38651V615.5533H881.80566Z"
                                                  transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M606.77462,640.01143a3.13177,3.13177,0,0,0,0,6.26355H835.43077a3.13178,3.13178,0,0,0,0-6.26355Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#e6e6e6" />
                                            <path
                                                    d="M606.77462,658.80205a3.13178,3.13178,0,0,0-.01322,6.26355H751.32018a3.13178,3.13178,0,1,0,0-6.26355Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#e6e6e6" />
                                            <path
                                                    d="M881.80566,689.52373H560.38651V615.5533H881.80566Zm-316.13555-5.2836h310.852V620.8369H565.67011Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#e5e5e5" />
                                            <path
                                                    d="M375.32638,476.77757a13.42111,13.42111,0,1,1,13.42112-13.4211A13.42112,13.42112,0,0,1,375.32638,476.77757Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                            <path
                                                    d="M436.55947,286.59079a14.812,14.812,0,1,1,14.812-14.812A14.812,14.812,0,0,1,436.55947,286.59079Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                            <path
                                                    d="M818.616,392.45655A12.73855,12.73855,0,1,1,831.35451,379.718,12.73855,12.73855,0,0,1,818.616,392.45655Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#f0f0f0" />
                                            <rect x="240.89923" y="133.27712" width="195.25492" height="147.44576"
                                                  fill="#fff" />
                                            <path
                                                    d="M740.52256,461.2592H540.15392V308.69972H740.52256Zm-195.25491-5.11372H735.40884v-142.332H545.26765Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#e4e4e4" />
                                            <polygon
                                                    points="433.936 136.289 244.223 136.289 433.936 279.289 433.936 136.289"
                                                    fill="#f0f0f0" />
                                            <path
                                                    d="M845.55064,720.43928a28.73541,28.73541,0,1,1,28.73542-28.7354A28.73541,28.73541,0,0,1,845.55064,720.43928Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#0a89ff" />
                                            <path
                                                    d="M856.88887,688.86936h-8.50362v-8.50374a2.83461,2.83461,0,0,0-5.66922,0v8.50374H834.2123a2.83457,2.83457,0,0,0,0,5.66913H842.716v8.50372a2.83461,2.83461,0,0,0,5.66922,0v-8.50372h8.50362a2.83457,2.83457,0,1,0,0-5.66913Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#fff" />
                                            <path
                                                    d="M880.615,722.02054H303.321a1.19069,1.19069,0,0,1,0-2.38137H880.615a1.19069,1.19069,0,0,1,0,2.38137Z"
                                                    transform="translate(-301.81156 -177.97946)" fill="#cacaca" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php if (!UserConnection::isSignedIn()|| UserConnection::isInstance(new Entreprise())) : ?>
                        <li class="relative ">
                            <button
                                    class="block py-2 pl-3 pr-4 h-[4rem]  text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent focus:outline-none md:hover:text-blue-700 md:dark:hover:text-blue-500"
                                    id="dropdownButtonEntreprise">

                                <?php if (!UserConnection::isSignedIn()) : ?><a href="<?=Action::ENTREPRISE_SIGN_IN_FORM->value?>">Espace Entreprise</a>
                                <?php elseif(UserConnection::isInstance(new Entreprise())) :?><a href="<?=Action::ENTREPRISE_AFFICHER_OFFRE->value?>">Espace Offre</a>
                                <?php endif?>

                            </button>
                            <div class="relative hidden text-gray-700 border border-slate-300"
                                 id="dropdownContentEntreprise">
                                <div class="flex flex-wrap -mx-2">
                                    <?php if(!UserConnection::isInstance(new Entreprise())) :?>
                                        <a href="<?=Action::ENTREPRISE_SIGN_IN_FORM->value?>" class="w-1/2 p-4" target=""
                                           rel="noopener noreferrer">
                                            <div class="card-entreprise p-5 mr-3">
                                                <span class="font-bold">Connectez-vous à l'Espace Entreprise</span>
                                                <p>Administrez les opportunités de stage et d'alternance de votre entreprise,
                                                    consultez et réagissez aux retours des candidats.</p>
                                            </div>
                                        </a>
                                    <?php endif?>
                                    <a href="<?php if(UserConnection::isInstance(new Entreprise())) :?><?=Action::ENTREPRISE_CREATION_OFFRE_FORM->value?><?php else :?><?=Action::ENTREPRISE_SIGN_IN_FORM->value?><?php endif?>" class="w-1/2 p-4" target=""
                                       rel="noopener noreferrer">
                                        <div class="card-entreprise  p-4  h-full">
                                            <span class="font-bold">Vous voulez proposer des offres ?</span>
                                            <p class="mt-2">
                                                Rejoignez notre plateforme dynamique et rencontrez des candidats talentueux
                                                prêts à s'engager dans des stages et alternances enrichissants.</p>
                                        </div>
                                    </a>
                                    <a href="<?php if(UserConnection::isInstance(new Entreprise())) :?><?=Action::HOME->value?><?php else :?><?=Action::ENTREPRISE_SIGN_IN_FORM->value?><?php endif?>" class="w-1/2 p-4" target=""
                                       rel="noopener noreferrer">
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

                                            <svg xmlns="http://www.w3.org/2000/svg" width="250" height="170"
                                                 viewBox="0 0 537.64 563.26" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <path id="uuid-fb6bba6d-324d-4625-a98c-3d990729dcd8-212"
                                                      d="m294.36,308.7c1.69,8.48,7.72,13.98,13.47,12.28,5.75-1.7,9.04-9.96,7.35-18.44-.63-3.4-2.11-6.52-4.32-9.07l-7.63-35.8-17.84,5.88,9.42,34.67c-1.01,3.51-1.16,7.11-.43,10.48,0,0,0,0,0,0Z"
                                                      fill="#f8a8ab" />
                                                <rect x="254.14" y="514.38" width="20.94" height="29.71"
                                                      transform="translate(529.23 1058.47) rotate(-180)" fill="#f8a8ab" />
                                                <path
                                                        d="m272.77,561.11c-3.58.32-21.5,1.74-22.4-2.37-.82-3.77.39-7.71.56-8.25,1.72-17.14,2.36-17.33,2.75-17.44.61-.18,2.39.67,5.28,2.53l.18.12.04.21c.05.27,1.33,6.56,7.4,5.59,4.16-.66,5.51-1.58,5.94-2.03-.35-.16-.79-.44-1.1-.92-.45-.7-.53-1.6-.23-2.68.78-2.85,3.12-7.06,3.22-7.23l.27-.48,23.8,16.06,14.7,4.2c1.11.32,2,1.11,2.45,2.17h0c.62,1.48.24,3.2-.96,4.28-2.67,2.4-7.97,6.51-13.54,7.02-1.48.14-3.44.19-5.64.19-9.19,0-22.61-.95-22.71-.97Z"
                                                        fill="#2f2e43" />
                                                <rect x="196.13" y="514.38" width="20.94" height="29.71"
                                                      transform="translate(413.21 1058.47) rotate(-180)" fill="#f8a8ab" />
                                                <path
                                                        d="m214.76,561.11c-3.58.32-21.5,1.74-22.4-2.37-.82-3.77.39-7.71.56-8.25,1.72-17.14,2.36-17.33,2.75-17.44.61-.18,2.39.67,5.28,2.53l.18.12.04.21c.05.27,1.33,6.56,7.4,5.59,4.16-.66,5.51-1.58,5.94-2.03-.35-.16-.79-.44-1.1-.92-.45-.7-.53-1.6-.23-2.68.78-2.85,3.12-7.06,3.22-7.23l.27-.48,23.8,16.06,14.7,4.2c1.11.32,2,1.11,2.45,2.17h0c.62,1.48.24,3.2-.96,4.28-2.67,2.4-7.97,6.51-13.54,7.02-1.48.14-3.44.19-5.64.19-9.19,0-22.61-.95-22.71-.97Z"
                                                        fill="#2f2e43" />
                                                <polygon
                                                        points="213.11 100.28 245.58 110.95 245.58 64.21 216.12 64.21 213.11 100.28"
                                                        fill="#f8a8ab" />
                                                <circle cx="241.56" cy="44.8" r="32.35" fill="#f8a8ab" />
                                                <path
                                                        d="m233.32,47.33l4.46,5.41,8.07-14.12s10.3.53,10.3-7.11c0-7.64,9.45-7.86,9.45-7.86,0,0,13.37-23.35-14.33-17.2,0,0-19.21-13.16-28.77-1.91,0,0-29.3,14.75-20.91,40.44l13.93,26.48,3.16-5.99s-1.91-25.16,14.65-18.15Z"
                                                        fill="#2f2e43" />
                                                <path
                                                        d="m0,562.07c0,.66.53,1.19,1.19,1.19h535.26c.66,0,1.19-.53,1.19-1.19s-.53-1.19-1.19-1.19H1.19c-.66,0-1.19.53-1.19,1.19Z"
                                                        fill="#484565" />
                                                <path
                                                        d="m328.8,349.01l-61.13-19.65c-7.54-2.42-15.64,1.63-18.21,9.13l-27.62,80.54c-2.82,8.22,2.16,17.06,10.65,18.92l70.26,15.37c7.72,1.69,15.38-3.1,17.24-10.78l18.49-76.26c1.79-7.4-2.43-14.94-9.68-17.27Z"
                                                        fill="#e2e3e4" />
                                                <path
                                                        d="m322.6,366l-3.94-.7c2.52-14.32,6-52.5-8.05-57.18-6.81-2.27-13.67,1.7-20.38,11.81-5.27,7.95-8.35,16.75-8.38,16.84l-3.78-1.31c.54-1.55,13.39-37.94,33.8-31.14,20.17,6.72,11.12,59.43,10.72,61.67Z"
                                                        fill="#2f2e43" />
                                                <polygon
                                                        points="276.25 254.19 166.98 254.19 193.72 529.88 224.72 527.88 226.25 329.34 245.76 416.47 251.47 526.38 279.72 527.88 283 402.85 276.25 254.19"
                                                        fill="#2f2e43" />
                                                <polygon
                                                        points="211.34 83.19 248.34 92.19 279.97 228.88 276.25 254.19 183.6 269.87 166.98 254.19 211.34 83.19"
                                                        fill="#3e75cb" />
                                                <polygon
                                                        points="211.28 76.35 198.63 90.54 172.97 96.7 129.22 291.22 213.52 305.5 237 107.39 211.28 76.35"
                                                        fill="#2f2e43" />
                                                <polygon
                                                        points="248.32 83.44 241.72 106.96 272.27 317.88 288.03 317.88 280.76 111.48 259.36 94.48 248.32 83.44"
                                                        fill="#2f2e43" />
                                                <path
                                                        d="m268.07,108.87l12.69,2.61s5.56,2.04,7.58,17.84c2.01,15.8,2.37,68.86,2.37,68.86l21.58,85.6-24.51,8.08-11.54-46.06-8.18-136.94Z"
                                                        fill="#2f2e43" />
                                                <polygon
                                                        points="246.9 97.89 240.76 109.15 253.04 241.23 238.71 254.54 225.4 242.26 235.13 109.66 220.95 97.89 225.91 94.3 231.03 100.44 241.27 98.4 245.36 92.25 246.9 97.89"
                                                        fill="#2f2e43" />
                                                <path id="uuid-4155b336-10d9-4b14-826d-07551e167be9-213"
                                                      d="m186.59,275.51c5.15,6.95,12.95,9.34,17.42,5.35,4.47-3.99,3.92-12.86-1.23-19.82-2.02-2.81-4.69-4.99-7.79-6.35l-22.2-29.11-13.62,12.94,23.33,27.32c.59,3.61,1.99,6.92,4.09,9.66,0,0,0,0,0,0Z"
                                                      fill="#f8a8ab" />
                                                <path
                                                        d="m183.11,99.89l-10.14-3.19s-13.74,3.41-18.29,20.57l-22.21,83.6,37.67,66.12,20.13-24.44-18.96-60.7,11.81-81.96Z"
                                                        fill="#2f2e43" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif?>
                        <?php if(($user instanceof Enseignant && $user->getEstAdmin()) || $user instanceof Secretaire) :?>
                            <li class="relative ">
                                <button
                                        class="block py-2 pl-3 pr-4 h-[4rem]  text-gray-900 rounded md:p-0  hover:bg-gray-100 md:hover:bg-transparent focus:outline-none md:hover:text-blue-700 md:dark:hover:text-blue-500"
                                        id="dropdownButtonEntreprise">
                                    <a href="<?php if($user instanceof Enseignant && $user->getEstAdmin()) :?><?=Action::ADMIN_DASH->value?>
                                    <?php else: ?><?=Action::SECRETAIRE_DASH->value?><?php endif ?>">Dashboard</a>
                                </button>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
    <?php endif ?>
                <!----------------------------Message Flash----------------------------------------->
                <?php if (!empty($flashMessages)): ?>
                    <ul class="flash-messages-container">
                        <?php foreach ($flashMessages as $flashMessage): ?>
                            <li class="flash-message <?=$flashMessage->getType()?>">
                                <?php if ($flashMessage->getType() === "success"): ?>
                                    <i class="success fi fi-rr-check-circle text-red-500"></i>
                                <?php elseif ($flashMessage->getType() === "info"): ?>
                                    <i class="info fi fi-rr-info"></i>
                                <?php elseif ($flashMessage->getType() === "warning"): ?>
                                    <i class="warning fi fi-rr-exclamation"></i>
                                <?php elseif ($flashMessage->getType() === "error"): ?>
                                    <i class="error fi fi-rr-cross-circle"></i>
                                <?php endif ?>
                                <p><?=$flashMessage->getContent()?></p>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
                <p id="cssgenerator" class="!hidden"></p>
</header>
<?php require_once $template?>
<!----------------------------bar du bas----------------------------------------->
<?php if ($footer):?>
    <footer class="bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">Stageo</h2>
                    <ul class="text-gray-600 space-y-2">
                        <li>À propos</li>
                        <li>Contact</li>
                        <li>Blog</li>
                        <li>Nous contacter</li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">Employeurs</h2>
                    <ul class="text-gray-600 space-y-2">
                        <li>
                            <a href="">Obtenez un Compte Employeur gratuit</a>
                        </li>
                        <li>
                            <a href="">Centre employeur</a>
                        </li>
                        <li>
                            <a href="">Contacter les services</a>
                        </li>
                    </ul>
                </div>
                <div class="space-y-4 mt-8 sm:mt-0">
                    <h2 class="text-lg font-semibold text-gray-800">Informations</h2>
                    <ul class="text-gray-600 space-y-2">
                        <li>
                            <a href="">Aide et contact</a>
                        </li>
                        <li>
                            <a href="">Règlement</a>
                        </li>
                        <li>
                            <a href="">Conditions d'utilisation</a>
                        </li>
                        <li>
                            <a href="">Confidentialité et cookies</a>
                        </li>
                        <li>
                            <a href="">Centre de confidentialité</a>
                        </li>
                        <li>
                            <a href="">Outil de consentement aux cookies</a>
                        </li>
                    </ul>
                </div>
                <div class="space-y-4 mt-8 sm:mt-0">
                    <h2 class="text-lg font-semibold text-gray-800">Mention légales</h2>
                    <ul class="text-gray-600 space-y-2">
                        <li>
                            <a href="">Mentions</a>
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
                <p class="text-gray-500 text-xs text-center mt-4"><a href="<?=Action::ADMIN_SIGN_IN_FORM->value ?>">Espace Admin</a></p>
            </div>
        </div>
    </footer>
<?php endif ?>
</body>
</html>