<?php
/**
 * @var string $title
 * @var bool $nav
 * @var ?Stageo\Model\Object\User $user
 * @var string $template
 * @var bool $footer
 */
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
        <header>
            <?php if ($nav):?>
                <nav>
                    <a class="logo-container" href="/Stageo">
                        <span>Stageo</span>
                    </a>
                    <ul class="account-buttons-container">
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
            <footer>
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