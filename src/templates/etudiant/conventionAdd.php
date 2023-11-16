<?php
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";

/**
 * @var string $token
 * @var string $login
 * @var array $pattern
 */
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déposer une convention</title>
    <!-- Ajoutez ici les liens vers vos fichiers CSS (par exemple Bootstrap) -->
    <!-- <link rel="stylesheet" href="votre-style.css"> -->
    <style>
        /* Ajoutez ici vos styles CSS personnalisés pour rendre les champs de formulaire plus esthétiques */
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .select-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2 class="text-2xl font-bold">Déposer une convention</h2>
                </div>
                <div class="card-body">

                    <form action="<?= Action::ETUDIANT_CONVENTION_ADD->value ?>" method="post">
                        <!-- Insérez ici vos champs de formulaire avec les classes Bootstrap -->
                        <!-- Type de convention -->
                        <div class="form-group">
                           <?=field("type_convention", "Type de convention*", "text", "Entrez le type de convention", null, true) ?>
                        </div>
                        <!-- Année universitaire -->
                        <div class="form-group">
                            <?=field("annee_universitaire", "Année universitaire*", "text", "Entrez l'année universitaire", null, true) ?>
                                <!-- Ajoutez les autres années universitaires au besoin -->
                        </div>
                        <!-- Origine du stage -->
                        <div class="form-group">
                            <?=field("origine_stage", "Origine du stage*", "text", "Entrez l'origine du stage", null, true) ?>
                            </div>
                        <!-- Sujet -->
                        <div class="form-group">
                            <?=field("sujet", "Sujet*", "text", "Entrez le sujet", null, true) ?>
                            </div>
                        <!-- Tâches -->
                        <div class="form-group">
                            <?=field("taches", "Tâches*", "text", "Entrez les tâches", null, true) ?>
                        </div>
                        <!-- Commentaires -->

                        <!-- Détails -->

                        <!-- Date de début -->
                        <div class="form-group">
                            <?=field("date_debut", "Date de début*", "date", "Entrez la date de début", null, true) ?>
                            </div>
                        <!-- Date de fin -->
                        <div class="form-group">
                            <?=field("date_fin", "Date de fin*", "date", "Entrez la date de fin", null, true) ?>
                            </div>
                        <!-- Interruption -->

                        <!-- Date de début de l'interruption -->

                        <!-- Date de fin de l'interruption -->

                        <!-- Heures total -->
                        <div class="form-group">
                            <?=field("heures_total", "Heures total*", "text", "Entrez les heures total", null, true) ?>
                        </div>
                        <!-- Jours hebdomadaire -->
                        <div class="form-group">
                           <?=field("jours_hebdomadaire", "Jours hebdomadaire*", "text", "Entrez les jours hebdomadaire", null, true) ?>
                        </div>
                        <!-- Heures hebdomadaire -->
                        <div class="form-group">
                            <?=field("heures_hebdomadaire", "Heures hebdomadaire*", "text", "Entrez les heures hebdomadaire", null, true) ?>
                        </div>
                        <!-- Commentaires durée -->

                        <!-- Gratification -->
                        <div class="form-group">
                           <?=field("gratification", "Gratification*", "text", "Entrez la gratification", null, true) ?>
                        </div>
                        <!-- Avantages nature -->

                        <!-- Code ELP -->

                        <!-- Numéro de voie -->

                        <!-- Id de l'unité de gratification -->

                        <!-- Id de l'enseignant -->

                        <!-- Id du tuteur -->

                        <!-- Id de l'entreprise -->

                        <!-- Id de la distribution commune -->

                        <!-- Login -->
                        <div class="form-group">
                            <?= field("login", "Login*", "text", "Entrez le login", null, true, $login) ?>
                        </div>
                        <!-- Bouton de soumission -->
                        <div class="form-group">
                            <?= submit("Déposer la convention") ?>
                            <?= token($token) ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

