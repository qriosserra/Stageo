<?php

$query = <<<SQL
ALTER TABLE stg_etudiant
DROP FOREIGN KEY stg_etudiant_ibfk_1,
DROP FOREIGN KEY stg_etudiant_ibfk_2,
DROP FOREIGN KEY stg_etudiant_ibfk_3,
DROP FOREIGN KEY stg_etudiant_ibfk_4,
ADD FOREIGN KEY (id_ufr) REFERENCES stg_ufr(id_ufr) ON DELETE SET NULL,
ADD FOREIGN KEY (id_departement_universitaire) REFERENCES stg_departement_universitaire(id_departement_universitaire) ON DELETE SET NULL,
ADD FOREIGN KEY (id_etape) REFERENCES stg_etape(id_etape) ON DELETE SET NULL,
ADD FOREIGN KEY (id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL;

ALTER TABLE stg_entreprise
DROP FOREIGN KEY stg_entreprise_ibfk_1,
DROP FOREIGN KEY stg_entreprise_ibfk_2,
DROP FOREIGN KEY stg_entreprise_ibfk_3,
DROP FOREIGN KEY stg_entreprise_ibfk_4,
ADD FOREIGN KEY (id_taille_entreprise) REFERENCES stg_taille_entreprise(id_taille_entreprise) ON DELETE SET NULL,
ADD FOREIGN KEY (id_type_structure) REFERENCES stg_type_structure(id_type_structure) ON DELETE SET NULL,
ADD FOREIGN KEY (id_statut_juridique) REFERENCES stg_statut_juridique(id_statut_juridique) ON DELETE SET NULL,
ADD FOREIGN KEY (id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL;

ALTER TABLE stg_offre
DROP FOREIGN KEY stg_offre_ibfk_1,
DROP FOREIGN KEY stg_offre_ibfk_2,
DROP FOREIGN KEY stg_offre_ibfk_3,
ADD FOREIGN KEY (login) REFERENCES stg_etudiant(login) ON DELETE SET NULL,
ADD FOREIGN KEY (id_unite_gratification) REFERENCES stg_unite_gratification(id_unite_gratification) ON DELETE SET NULL,
ADD FOREIGN KEY (id_entreprise) REFERENCES stg_entreprise(id_entreprise) ON DELETE CASCADE;

ALTER TABLE stg_convention
DROP FOREIGN KEY stg_convention_ibfk_1,
DROP FOREIGN KEY stg_convention_ibfk_2,
DROP FOREIGN KEY stg_convention_ibfk_3,
DROP FOREIGN KEY stg_convention_ibfk_4,
DROP FOREIGN KEY stg_convention_ibfk_5,
ADD FOREIGN KEY (id_unite_gratification) REFERENCES stg_unite_gratification(id_unite_gratification) ON DELETE SET NULL,
ADD FOREIGN KEY (login_enseignant) REFERENCES stg_enseignant(login) ON DELETE SET NULL,
ADD FOREIGN KEY (id_entreprise) REFERENCES stg_entreprise(id_entreprise) ON DELETE SET NULL,
ADD FOREIGN KEY (id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL,
ADD FOREIGN KEY (login) REFERENCES stg_etudiant(login) ON DELETE CASCADE;

ALTER TABLE stg_suivi
ADD UNIQUE (id_convention),
DROP FOREIGN KEY stg_suivi_ibfk_1,
ADD FOREIGN KEY (id_convention) REFERENCES stg_convention(id_convention) ON DELETE CASCADE;

ALTER TABLE stg_code_postal_commune
DROP FOREIGN KEY stg_code_postal_commune_ibfk_1,
DROP FOREIGN KEY stg_code_postal_commune_ibfk_2,
ADD FOREIGN KEY (id_commune) REFERENCES stg_commune(id_commune) ON DELETE CASCADE,
ADD FOREIGN KEY (id_code_postal) REFERENCES stg_code_postal(id_code_postal) ON DELETE CASCADE;

ALTER TABLE stg_etape_visee
DROP FOREIGN KEY stg_etape_visee_ibfk_1,
DROP FOREIGN KEY stg_etape_visee_ibfk_2,
ADD FOREIGN KEY (id_etape) REFERENCES stg_etape(id_etape) ON DELETE CASCADE,
ADD FOREIGN KEY (id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE;

ALTER TABLE stg_offre_categorie
DROP FOREIGN KEY stg_offre_categorie_ibfk_1,
DROP FOREIGN KEY stg_offre_categorie_ibfk_2,
ADD FOREIGN KEY (id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE,
ADD FOREIGN KEY (id_categorie) REFERENCES stg_categorie(id_categorie) ON DELETE CASCADE;

ALTER TABLE stg_postuler
DROP FOREIGN KEY stg_postuler_ibfk_1,
DROP FOREIGN KEY stg_postuler_ibfk_1,
ADD FOREIGN KEY (login) REFERENCES stg_etudiant(login) ON DELETE CASCADE,
ADD FOREIGN KEY (id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE;

SQL;

echo $query;