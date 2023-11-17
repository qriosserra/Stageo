<?php

$query = <<<SQL
DROP DATABASE IF EXISTS `stageo`;
CREATE DATABASE `stageo`;
USE `stageo`;

CREATE TABLE stg_ufr(
   id_ufr VARCHAR(4),
   libelle VARCHAR(256),
   PRIMARY KEY(id_ufr)
);

CREATE TABLE stg_departement_universitaire(
   id_departement_universitaire VARCHAR(32),
   PRIMARY KEY(id_departement_universitaire)
);

CREATE TABLE stg_etape(
   id_etape VARCHAR(64),
   libelle VARCHAR(256),
   PRIMARY KEY(id_etape)
);

CREATE TABLE stg_enseignant(
   id_enseignant INT AUTO_INCREMENT,
   prenom VARCHAR(256),
   nom VARCHAR(256),
   email VARCHAR(320),
   PRIMARY KEY(id_enseignant)
);

CREATE TABLE stg_commune(
   id_commune INT AUTO_INCREMENT,
   commune VARCHAR(256),
   PRIMARY KEY(id_commune)
);

CREATE TABLE stg_pays(
   id_pays INT AUTO_INCREMENT,
   nom VARCHAR(256),
   PRIMARY KEY(id_pays),
   UNIQUE(nom)
);

CREATE TABLE stg_code_postal(
   id_code_postal VARCHAR(50),
   PRIMARY KEY(id_code_postal)
);

CREATE TABLE stg_categorie(
   id_categorie INT AUTO_INCREMENT,
   libelle VARCHAR(256),
   PRIMARY KEY(id_categorie)
);

CREATE TABLE stg_admin(
   id_admin INT AUTO_INCREMENT,
   email VARCHAR(320),
   hashed_password VARCHAR(256),
   nom VARCHAR(256),
   prenom VARCHAR(256),
   PRIMARY KEY(id_admin)
);

CREATE TABLE stg_taille_entreprise(
   id_taille_entreprise VARCHAR(3),
   libelle VARCHAR(256),
   PRIMARY KEY(id_taille_entreprise)
);

CREATE TABLE stg_statut_juridique(
   id_statut_juridique VARCHAR(4),
   libelle VARCHAR(256),
   PRIMARY KEY(id_statut_juridique)
);

CREATE TABLE stg_type_structure(
   id_type_structure INT AUTO_INCREMENT,
   libelle VARCHAR(256),
   PRIMARY KEY(id_type_structure)
);

CREATE TABLE stg_distribution_commune(
   id_distribution_commune INT AUTO_INCREMENT,
   code_postal VARCHAR(5) NOT NULL,
   commune VARCHAR(256),
   id_pays INT,
   PRIMARY KEY(id_distribution_commune),
   FOREIGN KEY(id_pays) REFERENCES stg_pays(id_pays)
);

CREATE TABLE stg_unite_gratification(
   id_unite_gratification INT AUTO_INCREMENT,
   libelle VARCHAR(4) NOT NULL,
   PRIMARY KEY(id_unite_gratification)
);

CREATE TABLE stg_configuration(
   id_configuration INT AUTO_INCREMENT,
   gratification_minimale DECIMAL(15,2),
   annee_scolaire VARCHAR(256),
   PRIMARY KEY(id_configuration)
);

CREATE TABLE stg_secretaire(
   id_secretaire INT AUTO_INCREMENT,
   email VARCHAR(320) NOT NULL,
   hashed_password VARCHAR(256),
   PRIMARY KEY(id_secretaire)
);

CREATE TABLE stg_etudiant(
   login VARCHAR(256),
   nom VARCHAR(256),
   prenom VARCHAR(256),
   telephone VARCHAR(20),
   telephone_fixe VARCHAR(20),
   email_etudiant VARCHAR(320),
   annee VARCHAR(256),
   civilite CHAR(1),
   numero_voie VARCHAR(256),
   id_ufr VARCHAR(4),
   id_departement_universitaire VARCHAR(32),
   id_etape VARCHAR(64),
   id_distribution_commune INT,
   PRIMARY KEY(login),
   FOREIGN KEY(id_ufr) REFERENCES stg_ufr(id_ufr) ON DELETE SET NULL,
   FOREIGN KEY(id_departement_universitaire) REFERENCES stg_departement_universitaire(id_departement_universitaire) ON DELETE SET NULL,
   FOREIGN KEY(id_etape) REFERENCES stg_etape(id_etape) ON DELETE SET NULL,
   FOREIGN KEY(id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL
);

CREATE TABLE stg_entreprise(
   id_entreprise INT AUTO_INCREMENT,
   email VARCHAR(256),
   hashed_password VARCHAR(256),
   raison_sociale VARCHAR(256),
   siret CHAR(14),
   numero_voie VARCHAR(256),
   code_naf VARCHAR(256),
   telephone VARCHAR(20),
   fax VARCHAR(20),
   site VARCHAR(256),
   confirmer BOOL NOT NULL DEFAULT FALSE,
   id_taille_entreprise VARCHAR(3),
   id_type_structure INT,
   id_statut_juridique VARCHAR(4),
   id_distribution_commune INT,
   PRIMARY KEY(id_entreprise),
   FOREIGN KEY(id_taille_entreprise) REFERENCES stg_taille_entreprise(id_taille_entreprise) ON DELETE SET NULL,
   FOREIGN KEY(id_type_structure) REFERENCES stg_type_structure(id_type_structure) ON DELETE SET NULL,
   FOREIGN KEY(id_statut_juridique) REFERENCES stg_statut_juridique(id_statut_juridique) ON DELETE SET NULL,
   FOREIGN KEY(id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL
);

CREATE TABLE stg_tuteur(
   id_tuteur INT AUTO_INCREMENT,
   nom VARCHAR(256),
   prenom VARCHAR(256),
   email VARCHAR(320),
   telephone VARCHAR(20),
   fonction VARCHAR(256),
   id_entreprise INT NOT NULL,
   PRIMARY KEY(id_tuteur),
   FOREIGN KEY(id_entreprise) REFERENCES stg_entreprise(id_entreprise)ON DELETE CASCADE 
);

CREATE TABLE stg_offre(
   id_offre INT AUTO_INCREMENT,
   description TEXT,
   thematique VARCHAR(256),
   secteur VARCHAR(256),
   taches TEXT,
   commentaires TEXT,
   gratification DECIMAL(15,2),
   type VARCHAR(256),
   login VARCHAR(256),
   id_unite_gratification INT,
   id_entreprise INT NOT NULL,
   PRIMARY KEY(id_offre),
   FOREIGN KEY(login) REFERENCES stg_etudiant(login) ON DELETE SET NULL,
   FOREIGN KEY(id_unite_gratification) REFERENCES stg_unite_gratification(id_unite_gratification) ON DELETE SET NULL,
   FOREIGN KEY(id_entreprise) REFERENCES stg_entreprise(id_entreprise) ON DELETE CASCADE
);

CREATE TABLE stg_offre_alternance(
   id_offre INT,
   PRIMARY KEY(id_offre),
   FOREIGN KEY(id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE
);

CREATE TABLE stg_offre_stage(
   id_offre INT,
   PRIMARY KEY(id_offre),
   FOREIGN KEY(id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE
);

CREATE TABLE stg_convention(
   id_convention INT AUTO_INCREMENT,
   type_convention VARCHAR(256),
   origine_stage VARCHAR(256),
   annee_universitaire VARCHAR(256),
   thematique VARCHAR(256),
   sujet VARCHAR(256),
   taches VARCHAR(3064),
   commentaires VARCHAR(3064),
   details VARCHAR(3064),
   date_debut DATE,
   date_fin DATE,
   interruption BOOL,
   date_interruption_debut DATE,
   date_interruption_fin DATE,
   heures_total INT,
   jours_hebdomadaire TINYINT,
   heures_hebdomadaire TINYINT,
   commentaires_duree VARCHAR(3064),
   gratification DECIMAL(15,2),
   avantages_nature VARCHAR(256),
   code_elp VARCHAR(256),
   numero_voie VARCHAR(256),
   id_unite_gratification INT,
   id_enseignant INT,
   id_tuteur INT,
   id_entreprise INT,
   id_distribution_commune INT,
   login VARCHAR(256),
   PRIMARY KEY(id_convention),
   FOREIGN KEY(id_unite_gratification) REFERENCES stg_unite_gratification(id_unite_gratification) ON DELETE SET NULL,
   FOREIGN KEY(id_enseignant) REFERENCES stg_enseignant(id_enseignant) ON DELETE SET NULL,
   FOREIGN KEY(id_tuteur) REFERENCES stg_tuteur(id_tuteur) ON DELETE SET NULL,
   FOREIGN KEY(id_entreprise) REFERENCES stg_entreprise(id_entreprise) ON DELETE SET NULL,
   FOREIGN KEY(id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL,
   FOREIGN KEY(login) REFERENCES stg_etudiant(login) ON DELETE CASCADE
);

CREATE TABLE stg_suivi(
   id_suivi INT AUTO_INCREMENT,
   date_creation DATETIME,
   date_modification DATETIME,
   valide BOOL NOT NULL,
   raison_refus VARCHAR(3064),
   valide_pedagogiquement BOOL NOT NULL DEFAULT FALSE,
   avenants BOOL DEFAULT FALSE,
   details_avenants VARCHAR(256),
   date_retour DATE,
   id_convention INT NOT NULL,
   PRIMARY KEY(id_suivi),
   UNIQUE(id_convention),
   FOREIGN KEY(id_convention) REFERENCES stg_convention(id_convention) ON DELETE CASCADE
);

CREATE TABLE stg_code_postal_commune(
   id_commune INT,
   id_code_postal VARCHAR(50),
   PRIMARY KEY(id_commune, id_code_postal),
   FOREIGN KEY(id_commune) REFERENCES stg_commune(id_commune)ON DELETE CASCADE,
   FOREIGN KEY(id_code_postal) REFERENCES stg_code_postal(id_code_postal)ON DELETE CASCADE
);

CREATE TABLE stg_etape_visee(
   id_etape VARCHAR(64),
   id_offre INT,
   PRIMARY KEY(id_etape, id_offre),
   FOREIGN KEY(id_etape) REFERENCES stg_etape(id_etape) ON DELETE CASCADE,
   FOREIGN KEY(id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE
);

CREATE TABLE stg_offre_categorie(
   id_offre INT,
   id_categorie INT,
   PRIMARY KEY(id_offre, id_categorie),
   FOREIGN KEY(id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE,
   FOREIGN KEY(id_categorie) REFERENCES stg_categorie(id_categorie) ON DELETE CASCADE
);

CREATE TABLE stg_postule(
   login VARCHAR(256),
   id_offre INT,
   cv VARCHAR(256),
   lettre_motivation VARCHAR(256),
   complement TEXT,
   PRIMARY KEY(login, id_offre),
   FOREIGN KEY(login) REFERENCES stg_etudiant(login) ON DELETE CASCADE,
   FOREIGN KEY(id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE
);

SQL;

echo $query;