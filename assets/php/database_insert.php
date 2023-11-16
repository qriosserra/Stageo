<?php

$query = <<<SQL
INSERT INTO stg_categorie (libelle) VALUES
('PHP'),
('CSS'),
('JavaScript'),
('HTML');

INSERT INTO stg_etape (id_etape, libelle) VALUES
('TAIB21', 'BUT 2 Informatique - Réalisation d''application, conception, développement et validation');

INSERT INTO stg_statut_juridique (id_statut_juridique, libelle) VALUES
('EI', 'EI - Entreprise individuelle'),
('EURL', 'EURL - Entreprise unipersonnelle à responsabilité limitée'),
('SARL', 'SARL - Société à responsabilité limitée'),
('SA', 'SA - Société anonyme'),
('SAS', 'SAS - Société par actions simplifiée'),
('SASU', 'SASU - Société par actions simplifiée unipersonnelle'),
('SNC', 'SNC - Société en nom collectif'),
('SCOP', 'SCOP - Société coopérative ouvrière de production'),
('SCA', 'SCA - Société en commandite par actions'),
('SCS', 'SCS - Société en commandite simple');

INSERT INTO stg_taille_entreprise (id_taille_entreprise, libelle) VALUES
('TPE', 'TPE - moins de 10 salariés'),
('PME', 'PME - 10 à 249 salariés'),
('ETI', 'ETI - 250 à 4999 salariés'),
('GE', 'GE - au moins 5000 salariés');

INSERT INTO stg_type_structure (libelle) VALUES
('Entreprise publique'),
('Entreprise privée');

INSERT INTO stg_ufr (id_ufr, libelle) VALUES
('TE2', 'IUT Montpellier-Sète');

INSERT INTO stg_unite_gratification (libelle) VALUES
('Brut'),
('Net');

INSERT INTO stg_pays (nom)
VALUES
('France');

INSERT INTO stg_distribution_commune(code_postal, commune, id_pays) VALUES
(1400,'L''Abergement-Clémenciat',1),
(1640,'L''Abergement-de-Varey',1),
(1090,'Amareins',1),
(1500,'Ambérieu-en-Bugey',1),
(1330,'Ambérieux-en-Dombes',1),
(1300,'Ambléon',1),
(1500,'Ambronay',1),
(1500,'Ambutrix',1),
(1300,'Andert-et-Condon',1),
(1350,'Anglefort',1),
(1100,'Apremont',1),
(1110,'Aranc',1),
(1230,'Arandas',1);

INSERT INTO `stg_etudiant` (`login`, `nom`, `prenom`, `telephone`, `telephone_fixe`, `email_etudiant`, `annee`, `civilite`, `numero_voie`, `id_ufr`, `id_departement_universitaire`, `id_etape`, `id_distribution_commune`)
VALUES ('levys', 'Levy', 'Sascha', '0612345678', NULL, 'sascha.levy@etu.umontpellier.fr', 'Ann2', 'M', '99 Av. Occitanie', NULL, NULL, NULL, '1');

INSERT INTO `stg_entreprise` (`id_entreprise`, `unverified_email`, `email`, `nonce`, `nonce_timestamp`, `hashed_password`, `raison_sociale`, `siret`, `numero_voie`, `code_naf`, `telephone`, `fax`, `site`, `id_taille_entreprise`, `id_type_structure`, `id_statut_juridique`, `id_distribution_commune`)
VALUES (NULL, NULL, 'entreprise@gmail.com', NULL, NULL, NULL, 'L\'entreprise', '12345678901234', '99 av. du champs de Mars', '1234F', '0412345678', NULL, 'entreprise.com', 'ETI', '2', 'EI', '1');

INSERT INTO `stg_offre` (`id_offre`, `description`, `thematique`, `secteur`, `taches`, `commentaires`, `gratification`, `id_unite_gratification`, `id_entreprise`, `login`,`type`) VALUES
(NULL, 'Recherche d\'un stagiaire en informatique pour participer au développement de l\'interface utilisateur d\'un site web e-commerce.', 'Développement Web Front-End', 'Informatique / E-commerce', 'Développement de fonctionnalités front-end, intégration HTML/CSS, création de composants React.', 'Le stagiaire aura l\'opportunité de travailler sur des technologies modernes et de participer à des réunions de conception.', '4.05', '2', '1', NULL, NULL),
(NULL, 'Stage en sécurité informatique pour aider à protéger les systèmes d\'information de l\'entreprise.', 'Sécurité Informatique', 'Informatique / Sécurité', 'Analyse de vulnérabilités, mise en place de mesures de sécurité, rédaction de rapports de sécurité.', 'Le stagiaire travaillera en étroite collaboration avec notre équipe de sécurité et gagnera une expérience précieuse dans ce domaine critique.', '4.05', '2', '1', NULL, NULL),
(NULL, 'Stage en IA pour contribuer au développement de modèles de machine learning pour un projet de reconnaissance d\'images.', 'Intelligence Artificielle et Machine Learning', 'Informatique / Intelligence Artificielle', 'Collecte et traitement de données, développement de modèles de machine learning, tests et validation des modèles.', 'Le stagiaire aura l\'occasion d\'apprendre les dernières techniques en IA et de travailler sur un projet innovant.', '4.05', '2', '1', NULL, NULL),
(NULL, 'Stage en développement mobile pour créer une application Android innovante.', 'Développement d\'applications mobiles', 'Informatique / Applications mobiles', 'Développement d\'applications Android, tests d\'applications, documentation technique.', 'Le stagiaire pourra exprimer sa créativité tout en apprenant à utiliser des outils de développement mobile de pointe.', '7.77', '1', '1', NULL, NULL),
(NULL, 'Recherche d\'un stagiaire pour assister le chef de projet dans la gestion de projets informatiques.', 'Gestion de projets informatiques', 'Informatique / Gestion de projets', 'Suivi de l\'avancement des projets, préparation des documents de projet, communication avec les membres de l\'équipe.', 'Le stagiaire apprendra les compétences essentielles en gestion de projet et travaillera sur des projets stimulants.', '4.05', '2', '1', NULL, NULL);

SQL;

echo $query;