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
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title?> – Stageo</title>
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
        <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-straight/css/uicons-solid-straight.css" >
        <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css">
        <script async src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <script defer src="assets/js/script.js"></script>
    </head>
    <body>
        <header>
            <?php if ($nav):?>
                <button data-drawer-target="sidenav" data-drawer-toggle="sidenav" aria-controls="sidenav" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fi fi-sr-menu-burger text-2xl"></i>
                </button>
                <nav id="sidenav" class="transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidenav">
                    <div>
                        <ul>
                            <li>
                                <a href="<?=Action::HOME->value?>">
                                    <i aria-hidden="true" class="fi fi-sr-home"></i>
                                    <span>Accueil</span>
                                </a>
                            </li>
                            <?php if (is_null($user)): ?>
                            <li>
                                <a href="<?=Action::ETUDIANT_SIGN_IN_FORM->value?>">
                                    <i aria-hidden="true" class="fi fi-sr-graduation-cap"></i>
                                    <span>Connexion étudiant</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Action::ENTREPRISE_SIGN_IN_FORM->value?>">
                                    <i aria-hidden="true" class="fi fi-ss-building"></i>
                                    <span>Connexion entreprise</span>
                                </a>
                            </li>
                            <?php elseif ($user instanceof Etudiant): ?>
                            <li>
                                <a href="<?=Action::LISTE_OFFRE->value?>">
                                    <i aria-hidden="true" class="fi fi-sr-document"></i>
                                    <span>Rechercher une offre</span>
                                </a>
                            </li>
                            <?php elseif ($user instanceof Entreprise): ?>
                            <li>
                                <button type="button" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                                    <i aria-hidden="true" class="fi fi-sr-document"></i>
                                    <span>Offres</span>
                                    <i aria-hidden="true" class="fi fi-rr-angle-small-down"></i>
                                </button>
                                <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="<?=Action::ENTREPRISE_CREATION_OFFRE_FORM->value?>">Ajouter une nouvelle offre</a>
                                    </li>
                                    <li>
                                        <a href="#">Voir mes offres</a>
                                    </li>
                                </ul>
                            </li>
                            <?php elseif ($user instanceof Admin): ?>
                            <li>
                                <a href="#">
                                    <i aria-hidden="true" class="fi fi-ss-check-circle"></i>
                                    <span>Entreprises à valider</span>
                                    <span class="!flex-none inline-flex justify-center items-center w-6 h-6 text-xs font-semibold rounded-full text-primary-800 bg-primary-100 dark:bg-primary-200 dark:text-primary-800">
                      6
                  </span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                        <ul>
                            <li>
                                <a href="<?=Action::ABOUT->value?>">
                                    <i aria-hidden="true" class="fi fi-sr-info"></i>
                                    <span>A propos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="hidden absolute bottom-0 left-0 p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
                        <?php if (!is_null($user)): ?>
                        <button type="button" data-dropdown-toggle="language-dropdown" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:hover:text-white dark:text-gray-400 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <img src="" class="h-6 w-6 rounded-full mt-0.5" alt="">
                        </button>
                        <!-- Dropdown -->
                        <div class="hidden z-50 my-4 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700" id="language-dropdown">
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="<?=Action::SIGN_OUT->value?>" class="block py-2 px-4 text-sm text-red-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600" role="menuitem">
                                        <i class="fi fi-rr-exit"></i>
                                        <span>Déconnexion</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <?php endif ?>
                    </div>
                </nav>
                <nav class="hidden">
                    <a class="logo-container flex justify-center items-center" href="<?=Action::HOME->value?>">
                        <span>Stageo</span>
                    </a>
                    <?php if ($user != null && !str_contains($_SERVER['REQUEST_URI'],"?a=listeOffre")):?>
                        <form class="" action="<?=Action::LISTE_OFFRE->value?>" method="post">
                            <div class="relative flex flex-row h-1/2  flex-wrap items-stretch">
                                <div class="w-64 ">
                                    <select id="Option" name="OptionL" class="rounded-l-lg w-full  bg-white border border-blue-500 text-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="description" >Description</option>
                                        <option value="secteur">Secteur</option>
                                    </select>
                                </div>
                                <input
                                        type="search"
                                        class=" relative bg-white m-0 -mr-0.5 block w-auto min-w-0  flex-auto border border-solid border-blue-500 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary "
                                        id="searchInput"
                                        name="searchInput"
                                        placeholder="Search"
                                        aria-label="Search"
                                        aria-describedby="button-addon1" />
                                <input type="submit" value="rechercher" class="bg-blue-500 rounded-none !rounded-l-none !rounded-r-lg flex justify-center items-center">
                            </div>
                        </form>
                    <?php endif ?>
                    <ul class="account-buttons-container flex justify-center items-center">
                        <li class="aPropos">
                            <a class="aPropos button " href="<?=Action::ABOUT->value?>">
                                <span>A Propos</span>
                            </a>
                        </li>
                        <?php if (UserConnection::isInstance(new Admin())): ?>
                        <li class="dashboard">
                            <a class="dashboard" href="<?=Action::ADMIN_DASH->value?>">
                                <span>dashboard</span>
                            </a>
                        </li>
                        <?php endif ?>
                        <?php if (is_null($user)):?>
                            <li class="sign-in">
                                <a class="sign-in button-ghost" href="<?=Action::ETUDIANT_SIGN_IN_FORM->value?>">
                                    <span>Connexion à un compte étudiant</span>
                                </a>
                            </li>
                            <li>
                                <a class="sign-up button-primary" href="<?=Action::ENTREPRISE_SIGN_IN_FORM->value?>">
                                    <span>Connexion à un compte entreprise</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class = "sign-out">
                                <a class="sign-out logo-container" href="<?=Action::SIGN_OUT->value?>">
                                    <span>Déconnexion</span>
                                </a>
                            </li>
                            <li class="profile">
                                <a class="profile button" href="?c=user&a=profile&user=">
                                    <span>Profile</span>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </nav>
            <?php endif ?>
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
        </header>
        <?php require_once $template?>
        <?php if ($footer):?>
            <footer class="mt-3">
                <div class="footer-information-container">
                    <div class="footer-section-container">
                        <section class="footer-section">
                            <h6>Plan du site</h6>
                            <ul class="footer-section-list-container ">
                                <li class="footer-section-list-wrapper">
                                    <a href="?a=about">
                                        <span>À propos</span>
                                    </a>
                                </li>
                                <li class="footer-section-list-wrapper">
                                    <a href="?a=contactForm">
                                        <span>Contact</span>
                                    </a>
                                </li>
                                <li class="footer-section-list-wrapper">
                                    <a href="?a=faq">
                                        <span>FAQ</span>
                                    </a>
                                </li>
                                <li class="footer-section-list-wrapper">
                                    <a href="https://github.com/qriosserra/Stageo">
                                        <span>GitHub</span>
                                    </a>
                                </li>
                            </ul>
                        </section>
                        <section class="footer-section">
                            <h6>Groupe</h6>
                            <ul class="footer-section-list-container">
                                <li class="footer-section-list-wrapper">
                                    <a href="https://github.com/YvelGY">
                                        <span>Levy</span>
                                    </a>
                                </li>
                                <li class="footer-section-list-wrapper">
                                    <a href="https://github.com/jins5">
                                        <span>Oubram</span>
                                    </a>
                                </li>
                                <li class="footer-section-list-wrapper">
                                    <a href="https://github.com/BanPerm">
                                        <span>Poirier</span>
                                    </a>
                                </li>
                                <li class="footer-section-list-wrapper">
                                    <a href="https://github.com/">
                                        <span>Ram</span>
                                    </a>
                                </li>
                                <li class="footer-section-list-wrapper">
                                    <a href="https://github.com/qriosserra">
                                        <span>Rios-Serra</span>
                                    </a>
                                </li>
                                <li class="footer-section-list-wrapper">
                                    <a href="https://github.com/LouisTexier3012">
                                        <span>Texier</span>
                                    </a>
                                </li>
                            </ul>
                        </section>
                    </div>
                    <section class="footer-description-container">
                        <h6>Stageo</h6>
                        <p class="footer-description">
                            Stageo est une plateforme de mise en relation entre des entreprises et des étudiants en recherche de
                            stage ou d'alternance. Elle permet aux entreprises de publier des offres auxquelles les étudiants
                            peuvent postuler.
                        </p>
                    </section>
                </div>
                <span class="footer-copyright">Stageo © 2023</span>
            </footer>
        <?php endif ?>
    </body>
</html>