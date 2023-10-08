<?php

//$prefix= $_ENV["DATABASE_PREFIX"];

$prefix   = "stg_";
$engine   = "InnoDB";
$charset  = "utf8mb4";
$encoding = "_general_ci";
$autoincrement = "1";

$query = <<<SQL
    DROP DATABASE IF EXISTS `stageo`;
    CREATE DATABASE `stageo`;
    USE `stageo`;

    CREATE TABLE `{$prefix}composante`(
        `id_ufr`                    VARCHAR(4)      NOT NULL,
        `libelle`                   VARCHAR(256)    NULL,
        PRIMARY KEY(`id_ufr`)
    );
    
    CREATE TABLE `{$prefix}departement`(
        `id_departement`            VARCHAR(32)     NOT NULL,
        PRIMARY KEY(`id_departement`)
    );
    
    CREATE TABLE `{$prefix}etape`(
        `id_etape`                  VARCHAR(64)     NOT NULL,
        `libelle`                   VARCHAR(256)    NULL,
        PRIMARY KEY                     (`id_etape`)
    );
    
    CREATE TABLE `{$prefix}enseignant`(
        `id_enseignant`             INT(11)         NOT NULL AUTO_INCREMENT,
        `email`                     VARCHAR(320)    NULL,
        `unverified_email`          VARCHAR(320)    NULL,
        `nonce`                     VARCHAR(256)    NULL,
        `nonce_timestamp`           INT(11)         NULL,
        `hashed_password`           VARCHAR(256)    NULL,
        `nom`                       VARCHAR(256)    NULL,
        `prenom`                    VARCHAR(256)    NULL,
        PRIMARY KEY                     (`id_enseignant`)
    );
    
    CREATE TABLE `{$prefix}pays`(
        `id_pays`                   INT(11)         NOT NULL AUTO_INCREMENT,
        `nom`                       VARCHAR(64)     NULL,
        PRIMARY KEY(`id_pays`),
        UNIQUE KEY (`nom`)
    );
    
    CREATE TABLE `{$prefix}commune`(
        `id_commune`                INT(11)         NOT NULL AUTO_INCREMENT,
        `commune`                   VARCHAR(256)    NULL,
        `id_pays`                   INT(11)         NOT NULL,
        PRIMARY KEY(`id_commune`),
        FOREIGN KEY(`id_pays`)          REFERENCES {$prefix}pays(`id_pays`)
    );
    
    CREATE TABLE `{$prefix}code_postal`(
        `id_code_postal`            VARCHAR(32)     NOT NULL,
        `id_commune`                INT(11)         NOT NULL,
        PRIMARY KEY(`id_code_postal`),
        FOREIGN KEY(`id_commune`)       REFERENCES {$prefix}commune(`id_commune`)
    );
    
    CREATE TABLE `{$prefix}etudiant`(
        `id_etudiant`               INT(11) NOT NULL AUTO_INCREMENT,
        `login`                     VARCHAR(256)    NULL,
        `email`                     VARCHAR(320)    NULL,
        `unverified_email`          VARCHAR(320)    NULL,
        `nonce`                     VARCHAR(256)    NULL,
        `nonce_timestamp`           INT(11)         NULL,
        `hashed_password`           VARCHAR(256)    NULL,
        `nom`                       VARCHAR(256)    NULL,
        `prenom`                    VARCHAR(256)    NULL,
        `telephone`                 VARCHAR(20)     NULL,
        `telephone_fixe`            VARCHAR(20)     NULL,
        `email_etudiant`            VARCHAR(320)    NULL,
        `adresse_voie`              VARCHAR(256)    NULL,
        `civilite`                  CHAR(1)         NULL,
        `id_code_postal`            VARCHAR(50)     NULL,
        `id_departement`            VARCHAR(32)     NULL,
        `id_etape`                  VARCHAR(64)     NULL,
        `id_ufr`                    VARCHAR(4)      NULL,
        PRIMARY KEY(`id_etudiant`),
        FOREIGN KEY(`id_code_postal`)   REFERENCES {$prefix}code_postal(`id_code_postal`),
        FOREIGN KEY(`id_departement`)   REFERENCES {$prefix}departement(`id_departement`),
        FOREIGN KEY(`id_etape`)         REFERENCES {$prefix}etape(`id_etape`),
        FOREIGN KEY(`id_ufr`)           REFERENCES {$prefix}composante(`id_ufr`)
    );
    
    CREATE TABLE `{$prefix}entreprise`(
        `id_entreprise`             INT(11)         NOT NULL AUTO_INCREMENT,
        `email`                     VARCHAR(320)    NULL,
        `unverified_email`          VARCHAR(320)    NULL,
        `nonce`                     VARCHAR(256)    NULL,
        `nonce_timestamp`           INT(11)         NULL,
        `hashed_password`           VARCHAR(256)    NULL,
        `raison_sociale`            VARCHAR(256)    NULL,
        `siret`                     CHAR(14)        NULL,
        `adresse_voie`              VARCHAR(256)    NULL,
        `statut_juridique`          VARCHAR(256)    NULL,
        `type_structure`            VARCHAR(256)    NULL,
        `effectif`                  VARCHAR(64)     NULL,
        `code_naf`                  VARCHAR(64)     NULL,
        `telephone`                 VARCHAR(20)     NULL,
        `fax`                       VARCHAR(64)     NULL,
        `site`                      VARCHAR(256)    NULL,
        `id_code_postal`            VARCHAR(50)     NULL,
        PRIMARY KEY(`id_entreprise`),
        FOREIGN KEY(`id_code_postal`)   REFERENCES {$prefix}code_postal(`id_code_postal`)
    );
    
    CREATE TABLE `{$prefix}tuteur`(
        `id_tuteur`                 INT(11)         NOT NULL AUTO_INCREMENT,
        `email`                     VARCHAR(320)    NULL,
        `unverified_email`          VARCHAR(320)    NULL,
        `nonce`                     VARCHAR(256)    NULL,
        `nonce_timestamp`           INT(11)         NULL,
        `hashed_password`           VARCHAR(256)    NULL,
        `nom`                       VARCHAR(256)    NULL,
        `prenom`                    VARCHAR(256)    NULL,
        `telephone`                 VARCHAR(20)     NULL,
        `fonction`                  VARCHAR(256)    NULL,
        `id_entreprise`             INT(11)         NOT NULL,
        PRIMARY KEY(`id_tuteur`),
        FOREIGN KEY(`id_entreprise`)    REFERENCES {$prefix}entreprise(`id_entreprise`)
    );
    
    CREATE TABLE `{$prefix}convention`(
        `id_convention`             INT(11)         NOT NULL AUTO_INCREMENT,
        `type_convention`           VARCHAR(64)     NULL,
        `origine_stage`             VARCHAR(256)    NULL,
        `annee_universitaire`       VARCHAR(64)     NULL,
        `thematique`                VARCHAR(256)    NULL,
        `sujet`                     VARCHAR(256)    NULL,
        `taches`                    TEXT            NULL,
        `commentaires`              TEXT            NULL,
        `details`                   TEXT            NULL,
        `date_debut`                DATE            NULL,
        `date_fin`                  DATE            NULL,
        `interruption`              BOOLEAN         NULL,
        `date_interruption_debut`   DATE            NULL,
        `date_interruption_fin`     DATE            NULL,
        `heures_total`              INT(11)         NULL,
        `jour_hebdomadaire`         VARCHAR(50)     NULL,
        `heure_hebdomadaire`        INT(11)         NULL,
        `commentaires_duree`        TEXT            NULL,
        `gratification`             INT(11)         NULL,
        `unite_gratification`       VARCHAR(64)     NULL,
        `avantages_nature`          VARCHAR(256)    NULL,
        `code_elp`                  VARCHAR(64)     NULL,
        `id_entreprise`             INT(11)         NULL,
        `id_tuteur`                 INT(11)         NULL,
        `id_enseignant`             INT(11)         NULL,
        `id_etudiant`               INT(11)         NOT NULL,
        PRIMARY KEY(`id_convention`),
        FOREIGN KEY(`id_entreprise`)    REFERENCES {$prefix}entreprise(`id_entreprise`),
        FOREIGN KEY(`id_tuteur`)        REFERENCES {$prefix}tuteur(`id_tuteur`),
        FOREIGN KEY(`id_enseignant`)    REFERENCES {$prefix}enseignant(`id_enseignant`),
        FOREIGN KEY(`id_etudiant`)      REFERENCES {$prefix}etudiant(`id_etudiant`)
    );
    
    CREATE TABLE `{$prefix}suivi`(
        `id_suivi`                  INT(11)         NOT NULL AUTO_INCREMENT,
        `date_creation`             DATETIME        NULL,
        `date_modification`         DATETIME        NULL,
        `valide`                    BOOLEAN         NOT NULL,
        `valide_pedagogiquement`    BOOLEAN         NOT NULL,
        `avenants`                  BOOLEAN         NULL,
        `details_avenants`          VARCHAR(256)    NULL,
        `date_retour`               DATE            NULL,
        `id_convention`             INT(11)         NOT NULL,
        PRIMARY KEY(`id_suivi`),
        UNIQUE(`id_convention`),
        FOREIGN KEY(`id_convention`)    REFERENCES {$prefix}convention(`id_convention`)
    );
SQL;

echo $query;