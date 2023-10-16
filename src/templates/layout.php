<?php
/**
 * @var string $title
 * @var bool $nav
 * @var ?Stageo\Model\Object\User $user
 * @var string $template
 * @var bool $footer
 */

use Stageo\Lib\enums\Action;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?=$title?> – Stageo</title>
        <link rel="stylesheet" href="assets/css/main.css"">
        <link rel='stylesheet' href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
        <script defer src="assets/js/script.js"></script>
    </head>
    <body>
    <p class="hidden"></p>
        <header id="header" class="mb-3">
            <?php if ($nav):?>
                <nav>
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
                                        class=" relative bg-white m-0 -mr-0.5 block w-auto min-w-0 flex-auto border border-solid border-blue-500 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary "
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
                            <a class="aPropos button " href="?a=about">
                                <span>A Propos</span>
                            </a>
                        </li>
                        <?php if (is_null($user)):?>
                            <li class="sign-in">
                                <a class="sign-in button-ghost" href="?c=etudiant&a=SignInForm">
                                    <span>Se connecter</span>
                                </a>
                            </li>
                            <li class="sign-up">
                                <a class="sign-up button-primary" href="?c=etudiant&a=SignUpForm">
                                    <span>S'inscrire</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class = "sign-out">
                                <a class="sign-out logo-container" href="?a=signOut">
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
    <script>
        // JavaScript
        var header = document.getElementById('header'); // Sélectionnez l'élément du header
        console.log(header);
        var lastScrollY = 0; // Initialisez la position précédente du défilement

        // Définissez une fonction pour gérer le défilement
        function handleScroll() {
            var currentScrollY = window.scrollY; // Obtenez la position actuelle du défilement

            if (currentScrollY > 30) { // Vérifiez si la position actuelle est supérieure à 30 pixels
                header.classList.add('hidden'); // Ajoutez la classe "hidden-header" pour masquer le header
            } else {
                header.classList.remove('hidden'); // Supprimez la classe "hidden-header" pour afficher le header
            }

            // Mettez à jour la position précédente du défilement
            lastScrollY = currentScrollY;
        }

        // Ajoutez un écouteur d'événement pour gérer le défilement
        window.addEventListener('scroll', handleScroll);
    </script>
    </body>
</html>