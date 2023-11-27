<?php

$query = <<<SQL
DROP PROCEDURE IF EXISTS importationCSV;
DELIMITER //
CREATE PROCEDURE importationCSV () NOT DETERMINISTIC
 begin
 	DECLARE v_IdSuivie INT;
  DECLARE v_IdStructure INT;
  DECLARE v_idTaille VARCHAR(3);
   DECLARE v_idJuridique VARCHAR(4);
 DECLARE  v_idEntreprise INT;
  DECLARE v_idTuteur INT;
 DECLARE  v_IdGrat INT;
  DECLARE v_IdEnseignant INT;
 DECLARE  v_idCommune INT;

 DECLARE  v_EtudiantExiste INT;
 DECLARE  v_TuteurExiste INT;
 DECLARE  v_EntrepriseExiste INT;
 DECLARE  v_EnseignantExiste INT;
 DECLARE  v_DepartementUniv INT;
DECLARE  v_idEtapExiste INT;
DECLARE  v_convExists INT;


SELECT count(id_etape) INTO v_idEtapExiste
FROM  stg_etape
WHERE id_etape = (SELECT Code_etape FROM table_temporaire WHERE id_table = 1);


IF v_idEtapExiste < 1 THEN

INSERT INTO stg_etape (id_etape,libelle) 
SELECT Code_etape, Libelle_Etape FROM table_temporaire WHERE id_table = 1;

END IF;


SELECT count(id_departement_universitaire) INTO v_DepartementUniv
FROM  stg_departement_universitaire
WHERE id_departement_universitaire = (SELECT Code_departement FROM table_temporaire WHERE id_table = 1);

IF v_DepartementUniv < 1 THEN 
INSERT INTO stg_departement_universitaire (id_departement_universitaire)
SELECT Code_departement FROM table_temporaire WHERE id_table = 1;
END IF;


SELECT count(login) INTO v_EtudiantExiste
FROM stg_etudiant
WHERE login = (SELECT Numero_etudiant FROM table_temporaire WHERE id_table = 1);

IF v_EtudiantExiste < 1 THEN 
INSERT INTO stg_etudiant (login, nom, prenom, telephone, telephone_fixe, email_etudiant, annee, civilite, numero_voie, id_departement_universitaire, id_etape) 
SELECT Numero_etudiant,Nom_etudiant, Prenom_etudiant,Telephone_Portable_etudiant,Telephone_Perso_etudiant, Mail_Universitaire_etudiant,annee_universitaire, Code_sexe_etudiant,NULL,Code_departement, Code_etape FROM table_temporaire WHERE id_table = 1;
UPDATE stg_etudiant
SET id_ufr = (SELECT code_ufr FROM table_temporaire WHERE id_table = 1)
WHERE login = (SELECT Numero_etudiant FROM table_temporaire WHERE id_table = 1);
ELSE
UPDATE stg_etudiant AS e
JOIN table_temporaire AS t ON e.login = t.Numero_etudiant
SET
    e.login = t.Numero_etudiant,
    e.nom = t.Nom_etudiant,
    e.prenom = t.Prenom_etudiant,
    e.telephone = t.Telephone_Portable_etudiant,
    e.telephone_fixe = t.Telephone_Perso_etudiant,
    e.email_etudiant = t.Mail_Universitaire_etudiant,
    e.annee = t.annee_universitaire,
    e.civilite = t.Code_sexe_etudiant,
    e.id_ufr = t.code_ufr,
    e.id_departement_universitaire = t.Code_departement,
    e.id_etape = t.Code_etape;


END IF;
UPDATE stg_etudiant
SET id_distribution_commune = (SELECT id_distribution_commune FROM stg_distribution_commune WHERE code_postal = (SELECT Code_postal_etudiant FROM table_temporaire where id_table = 1))
WHERE login = (SELECT Numero_etudiant FROM table_temporaire WHERE id_table = 1);


INSERT INTO stg_Ufr (id_ufr, libelle)
SELECT code_ufr, Libelle_UFR FROM table_temporaire WHERE id_table = 1;


INSERT INTO stg_unite_gratification(libelle) 
SELECT Unite_Gratification FROM table_temporaire WHERE id_table = 1;
SET v_IdGrat = LAST_INSERT_ID();


SELECT COUNT(id_enseignant) INTO v_EnseignantExiste
FROM stg_enseignant
WHERE prenom = (SELECT Prenom_Enseignant_referent FROM table_temporaire WHERE id_table = 1 LIMIT 1)
    AND nom = (SELECT Nom_Enseignant_referent FROM table_temporaire WHERE id_table = 1 LIMIT 1)
    AND email = (SELECT Email_Enseignant_referent FROM table_temporaire WHERE id_table = 1 LIMIT 1);

IF v_EnseignantExiste < 1 THEN 
INSERT INTO stg_enseignant (prenom, nom, email)
SELECT Prenom_Enseignant_referent, Nom_Enseignant_referent, Email_Enseignant_referent FROM table_temporaire WHERE id_table = 1;
SET v_IdEnseignant = LAST_INSERT_ID();

ELSE 

SELECT id_enseignant INTO v_IdEnseignant
FROM stg_enseignant
WHERE prenom = (SELECT Prenom_Enseignant_referent FROM table_temporaire WHERE id_table = 1 LIMIT 1)
    AND nom = (SELECT Nom_Enseignant_referent FROM table_temporaire WHERE id_table = 1 LIMIT 1)
    AND email = (SELECT Email_Enseignant_referent FROM table_temporaire WHERE id_table = 1 LIMIT 1);

END IF;

INSERT INTO stg_suivi (date_creation, date_modification, valide, valide_pedagogiquement, avenants, details_avenants)
SELECT STR_TO_DATE(Date_creation_conv, '%d/%m/%Y'),STR_TO_DATE(Date_modi_conv, '%d/%m/%Y') , Convention_Validee ,Con_Vali_Peda, Avenant_a_la_convention, details_avenants FROM table_temporaires WHERE id_table =1;

SET v_IdSuivie = LAST_INSERT_ID();

UPDATE stg_suivi
SET id_convention = Numero_Convention
WHERE id_suivie = v_IdSuivie;

INSERT INTO stg_type_structure (libelle)
SELECT Type_de_Structure FROM table_temporaire WHERE id_table =1;

SET v_IdStructure = LAST_INSERT_ID();

INSERT INTO stg_taille_entreprise (libelle)
SELECT Effectif FROM table_temporaire WHERE id_table =1;
SET v_idTaille = LAST_INSERT_ID();

INSERT INTO stg_statut_juridique (id_statut_juridique)
SELECT Statut_Juridique FROM table_temporaire WHERE id_table =1;
SET v_idJuridique = LAST_INSERT_ID();


SELECT COUNT(id_entreprise) INTO v_EntrepriseExiste
FROM stg_entreprise
WHERE siret = (SELECT siret FROM table_temporaire WHERE id_table = 1 LIMIT 1);

IF v_EntrepriseExiste < 1  THEN 

INSERT INTO stg_entreprise (
   email,
   siret,
   numero_voie,
   code_naf,
   telephone,
   fax,
   site,

   id_commune
) 
SELECT Mail_Structure,siret,Adresse_Voie,Code_NAF,Telephone,Fax,SiteWeb,Eta_Accueil_Com FROM table_temporaire WHERE id_table = 1;
SET v_idEntreprise = LAST_INSERT_ID();

ELSE 

SELECT id_entreprise INTO v_idEntreprise
FROM stg_entreprise
WHERE siret = (SELECT siret FROM table_temporaire WHERE id_table = 1 LIMIT 1);

UPDATE stg_entreprise
SET 
    id_taille_entreprise = v_idTaille,
    id_type_structure = v_IdStructure,
    id_statut_juridique = v_idJuridique
WHERE id_entreprise = v_idEntreprise;

END IF;


SELECT COUNT(id_tuteur) INTO v_TuteurExiste
FROM stg_tuteur
WHERE nom = (SELECT Nom_Tuteur_Professionnel FROM table_temporaire WHERE id_table = 1)
    AND prenom = (SELECT Prenom_Tuteur_Professionnel FROM table_temporaire WHERE id_table = 1)
    AND email = (SELECT Mail_Tuteur_professionnel FROM table_temporaire WHERE id_table = 1 )
    AND telephone = (SELECT Telephone_Tuteur_Professionnel FROM table_temporaire WHERE id_table = 1)
    AND fonction = (SELECT Fonction_Tuteur_Professionnel FROM table_temporaire WHERE id_table = 1)
    AND id_entreprise = v_idEntreprise;

IF v_TuteurExiste < 1 THEN 
INSERT INTO stg_tuteur (nom, prenom, email, telephone, fonction, id_entreprise)
SELECT Nom_Tuteur_Professionnel, Prenom_Tuteur_Professionnel, Mail_Tuteur_professionnel,Telephone_Tuteur_Professionnel, Fonction_Tuteur_Professionnel,v_idEntreprise FROM table_temporaire WHERE id_table = 1;
SET v_idTuteur = LAST_INSERT_ID();
ELSE

SELECT id_tuteur INTO v_idTuteur
FROM stg_tuteur
WHERE nom = (SELECT Nom_Tuteur_Professionnel FROM table_temporaire WHERE id_table = 1)
    AND prenom = (SELECT Prenom_Tuteur_Professionnel FROM table_temporaire WHERE id_table = 1)
    AND email = (SELECT Mail_Tuteur_professionnel FROM table_temporaire WHERE id_table = 1 )
    AND telephone = (SELECT Telephone_Tuteur_Professionnel FROM table_temporaire WHERE id_table = 1)
    AND fonction = (SELECT Fonction_Tuteur_Professionnel FROM table_temporaire WHERE id_table = 1)
    AND id_entreprise = v_idEntreprise;

END IF;


SELECT id_commune INTO v_idCommune
FROM stg_distribution_commune
where id_code_postal =(
    SELECT Code_Postal
    FROM table_temporaire
    where id_table = 1
);

SELECT count(id_convention) INTO v_convExists
FROM stg_convention
WHERE id_convention = (SELECT Numero_Convention FROM table_temporaire where id_table = 1);

IF v_convExists < 1 THEN 

INSERT INTO stg_convention (
   id_convention,
   type_convention,
   origine_stage,
   annee_universitaire,
   thematique,
   sujet,
   taches,
   commentaires,
   details,
   date_debut,
   date_fin,
   interruption,
   date_interruption_debut,
   date_interruption_fin,
   heures_total,
   jours_hebdomadaire,
   heures_hebdomadaire,
   commentaires_duree,
   gratification,
   avantages_nature,
   code_elp,
   numero_voie,
   id_unite_gratification,
   id_enseignant,
   id_tuteur,
   id_entreprise,
   id_commune,
   login
)
SELECT Numero_Convention,
       Type_de_Convention,
       origine_stage,
       annee_universitaire,
       thematique,
       sujet,
       Fonctions_et_Taches,
       Commentaire_Stage,
       Detail_du_Projet,
       STR_TO_DATE(Date_Debut_Stage, '%d/%m/%Y'),
       STR_TO_DATE(Date_Fin_Stage, '%d/%m/%Y'),
       Interruption,
       STR_TO_DATE(date_interruption_debut, '%d/%m/%Y'),
        STR_TO_DATE(date_interruption_fin, '%d/%m/%Y'),
       NULL,
       Nb_de_jours_de_travail,
       Nombre_d_heures_hebdomadaire,
       Commentaire_Duree_Travail,
       gratification,
       Avantages_nature,
       Code_ELP,
       Adresse_Voie,
       v_IdGrat,
       v_IdEnseignant,
       v_idTuteur,
       v_idEntreprise,
       v_idCommune,
       Numero_etudiant
FROM table_temporaire 
WHERE id_table = 1;

ELSE 

UPDATE stg_convention
SET 
   type_convention = (SELECT Type_de_Convention FROM table_temporaire WHERE id_table = 1),
   origine_stage = (SELECT origine_stage FROM table_temporaire WHERE id_table = 1),
   annee_universitaire = (SELECT annee_universitaire FROM table_temporaire WHERE id_table = 1),
   thematique = (SELECT thematique FROM table_temporaire WHERE id_table = 1),
   sujet = (SELECT sujet FROM table_temporaire WHERE id_table = 1),
   taches = (SELECT Fonctions_et_Taches FROM table_temporaire WHERE id_table = 1),
   commentaires = (SELECT Commentaire_Stage FROM table_temporaire WHERE id_table = 1),
   details = (SELECT Detail_du_Projet FROM table_temporaire WHERE id_table = 1),
   date_debut = STR_TO_DATE((SELECT Date_Debut_Stage FROM table_temporaire WHERE id_table = 1), '%d/%m/%Y'),
   date_fin = STR_TO_DATE((SELECT Date_Fin_Stage FROM table_temporaire WHERE id_table = 1), '%d/%m/%Y'),
   interruption = (SELECT Interruption FROM table_temporaire WHERE id_table = 1),
   date_interruption_debut = STR_TO_DATE((SELECT date_interruption_debut FROM table_temporaire WHERE id_table = 1), '%d/%m/%Y'),
   date_interruption_fin = STR_TO_DATE((SELECT date_interruption_fin FROM table_temporaire WHERE id_table = 1), '%d/%m/%Y'),
   heures_total = NULL, -- Remplacez cette valeur par la logique appropriée,
   jours_hebdomadaire = (SELECT Nb_de_jours_de_travail FROM table_temporaire WHERE id_table = 1),
   heures_hebdomadaire = (SELECT Nombre_d_heures_hebdomadaire FROM table_temporaire WHERE id_table = 1),
   commentaires_duree = (SELECT Commentaire_Duree_Travail FROM table_temporaire WHERE id_table = 1),
   gratification = (SELECT gratification FROM table_temporaire WHERE id_table = 1),
   avantages_nature = (SELECT Avantages_nature FROM table_temporaire WHERE id_table = 1),
   code_elp = (SELECT Code_ELP FROM table_temporaire WHERE id_table = 1),
   numero_voie = (SELECT Adresse_Voie FROM table_temporaire WHERE id_table = 1),
   id_unite_gratification = (SELECT v_IdGrat FROM table_temporaire WHERE id_table = 1),
   id_enseignant = (SELECT v_IdEnseignant FROM table_temporaire WHERE id_table = 1),
   id_tuteur = (SELECT v_idTuteur FROM table_temporaire WHERE id_table = 1),
   id_entreprise = (SELECT v_idEntreprise FROM table_temporaire WHERE id_table = 1),
   id_commune = (SELECT v_idCommune FROM table_temporaire WHERE id_table = 1)
WHERE id_convention = (SELECT Numero_Convention FROM table_temporaire WHERE id_table = 1);


END IF;

DELETE FROM table_temporaire;
DEALLOCATE PREPARE stmt;
end;
//

DELIMITER ;


SQL;
echo $query;