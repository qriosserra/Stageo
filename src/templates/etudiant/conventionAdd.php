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
                            <label for="type_convention" class="form-label">Type de convention*</label>
                            <select id="type_convention" name="type_convention" class="select-input" required>
                                <option value="stage">Stage</option>
                                <option value="alternance">Alternance</option>
                            </select>
                        </div>
                        <!-- Année universitaire -->
                        <div class="form-group">
                            <label for="annee_universitaire" class="form-label">Année universitaire*</label>
                            <select id="annee_universitaire" name="annee_universitaire" class="select-input" required>
                                <option value="2022-2023">2022-2023</option>
                                <option value="2023-2024">2023-2024</option>
                                <!-- Ajoutez les autres années universitaires au besoin -->
                            </select>
                        </div>
                        <!-- Origine du stage -->
                        <div class="form-group">
                            <label for="origine_stage" class="form-label">Origine du stage*</label>
                            <input type="text" id="origine_stage" name="origine_stage" class="form-input" placeholder="Entrez l'origine du stage" required>
                        </div>
                        <!-- Sujet -->
                        <div class="form-group">
                            <label for="sujet" class="form-label">Sujet*</label>
                            <input type="text" id="sujet" name="sujet" class="form-input" placeholder="Entrez le sujet" required>
                        </div>
                        <!-- Tâches -->
                        <div class="form-group">
                            <label for="taches" class="form-label">Tâches*</label>
                            <input type="text" id="taches" name="taches" class="form-input" placeholder="Entrez les tâches" required>
                        </div>
                        <!-- Commentaires -->
                        <div class="form-group">
                            <label for="commentaires" class="form-label">Commentaires</label>
                            <input type="text" id="commentaires" name="commentaires" class="form-input" placeholder="Entrez les commentaires">
                        </div>
                        <!-- Détails -->
                        <div class="form-group">
                            <label for="details" class="form-label">Détails</label>
                            <input type="text" id="details" name="details" class="form-input" placeholder="Entrez les détails">
                        </div>
                        <!-- Date de début -->
                        <div class="form-group">
                            <label for="date_debut" class="form-label">Date de début*</label>
                            <input type="date" id="date_debut" name="date_debut" class="form-input" required>
                        </div>
                        <!-- Date de fin -->
                        <div class="form-group">
                            <label for="date_fin" class="form-label">Date de fin*</label>
                            <input type="date" id="date_fin" name="date_fin" class="form-input" required>
                        </div>
                        <!-- Interruption -->
                        <div class="form-group">
                            <label for="interruption" class="form-label">Interruption</label>
                            <input type="text" id="interruption" name="interruption" class="form-input" placeholder="Entrez l'interruption">
                        </div>
                        <!-- Date de début de l'interruption -->
                        <div class="form-group">
                            <label for="date_interruption_debut" class="form-label">Date de début de l'interruption</label>
                            <input type="date" id="date_interruption_debut" name="date_interruption_debut" class="form-input">
                        </div>
                        <!-- Date de fin de l'interruption -->
                        <div class="form-group">
                            <label for="date_interruption_fin" class="form-label">Date de fin de l'interruption</label>
                            <input type="date" id="date_interruption_fin" name="date_interruption_fin" class="form-input">
                        </div>
                        <!-- Heures total -->
                        <div class="form-group">
                            <label for="heures_total" class="form-label">Heures total*</label>
                            <input type="text" id="heures_total" name="heures_total" class="form-input" placeholder="Entrez les heures total" required>
                        </div>
                        <!-- Jours hebdomadaire -->
                        <div class="form-group">
                            <label for="jours_hebdomadaire" class="form-label">Jours hebdomadaire*</label>
                            <input type="text" id="jours_hebdomadaire" name="jours_hebdomadaire" class="form-input" placeholder="Entrez les jours hebdomadaire" required>
                        </div>
                        <!-- Heures hebdomadaire -->
                        <div class="form-group">
                            <label for="heures_hebdomadaire" class="form-label">Heures hebdomadaire*</label>
                            <input type="text" id="heures_hebdomadaire" name="heures_hebdomadaire" class="form-input" placeholder="Entrez les heures hebdomadaires" required>
                        </div>
                        <!-- Commentaires durée -->
                        <div class="form-group">
                            <label for="commentaires_duree" class="form-label">Commentaires durée</label>
                            <input type="text" id="commentaires_duree" name="commentaires_duree" class="form-input" placeholder="Entrez les commentaires sur la durée">
                        </div>
                        <!-- Gratification -->
                        <div class="form-group">
                            <label for="gratification" class="form-label">Gratification*</label>
                            <input type="text" id="gratification" name="gratification" class="form-input" placeholder="Entrez la gratification" required>
                        </div>
                        <!-- Avantages nature -->
                        <div class="form-group">
                            <label for="avantages_nature" class="form-label">Avantages nature</label>
                            <input type="text" id="avantages_nature" name="avantages_nature" class="form-input" placeholder="Entrez les avantages nature">
                        </div>
                        <!-- Code ELP -->
                        <div class="form-group">
                            <label for="code_elp" class="form-label">Code ELP</label>
                            <input type="text" id="code_elp" name="code_elp" class="form-input" placeholder="Entrez le code ELP">
                        </div>
                        <!-- Numéro de voie -->
                        <div class="form-group">
                            <label for="numero_voie" class="form-label">Numéro de voie</label>
                            <input type="text" id="numero_voie" name="numero_voie" class="form-input" placeholder="Entrez le numéro de voie">
                        </div>
                        <!-- Id de l'unité de gratification -->
                        <div class="form-group">
                            <label for="id_unite_gratification" class="form-label">Id de l'unité de gratification</label>
                            <input type="text" id="id_unite_gratification" name="id_unite_gratification" class="form-input" placeholder="Entrez l'id de l'unité de gratification">
                        </div>
                        <!-- Id de l'enseignant -->
                        <div class="form-group">
                            <label for="id_enseignant" class="form-label">Id de l'enseignant</label>
                            <input type="text" id="id_enseignant" name="id_enseignant" class="form-input" placeholder="Entrez l'id de l'enseignant">
                        </div>
                        <!-- Id du tuteur -->
                        <div class="form-group">
                            <label for="id_tuteur" class="form-label">Id du tuteur</label>
                            <input type="text" id="id_tuteur" name="id_tuteur" class="form-input" placeholder="Entrez l'id du tuteur">
                        </div>
                        <!-- Id de l'entreprise -->
                        <div class="form-group">
                            <label for="id_entreprise" class="form-label">Id de l'entreprise</label>
                            <input type="text" id="id_entreprise" name="id_entreprise" class="form-input" placeholder="Entrez l'id de l'entreprise">
                        </div>
                        <!-- Id de la distribution commune -->
                        <div class="form-group">
                            <label for="id_distribution_commune" class="form-label">Id de la distribution commune</label>
                            <input type="text" id="id_distribution_commune" name="id_distribution_commune" class="form-input" placeholder="Entrez l'id de la distribution commune">
                        </div>
                        <!-- Login -->
                        <div class="form-group">
                            <label for="login" class="form-label">Login*</label>
                            <input type="text" id="login" name="login" class="form-input" placeholder="Entrez le login" required>
                        </div>
                        <!-- Bouton de soumission -->
                        <div class="form-group">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <button type="submit" class="btn btn-primary">Déposer la convention</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

