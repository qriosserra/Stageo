<?php

$query = <<<SQL
ALTER TABLE stg_etudiant
ADD FOREIGN KEY (id_ufr) REFERENCES stg_ufr(id_ufr) ON DELETE SET NULL,
ADD FOREIGN KEY (id_departement_universitaire) REFERENCES stg_departement_universitaire(id_departement_universitaire) ON DELETE SET NULL,
ADD FOREIGN KEY (id_etape) REFERENCES stg_etape(id_etape) ON DELETE SET NULL,
ADD FOREIGN KEY (id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL;

ALTER TABLE stg_entreprise
ADD FOREIGN KEY (id_taille_entreprise) REFERENCES stg_taille_entreprise(id_taille_entreprise) ON DELETE SET NULL,
ADD FOREIGN KEY (id_type_structure) REFERENCES stg_type_structure(id_type_structure) ON DELETE SET NULL,
ADD FOREIGN KEY (id_statut_juridique) REFERENCES stg_statut_juridique(id_statut_juridique) ON DELETE SET NULL,
ADD FOREIGN KEY (id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL;

ALTER TABLE stg_tuteur
ADD FOREIGN KEY (id_entreprise) REFERENCES stg_entreprise(id_entreprise) ON DELETE CASCADE;

ALTER TABLE stg_offre
ADD FOREIGN KEY (login) REFERENCES stg_etudiant(login) ON DELETE SET NULL,
ADD FOREIGN KEY (id_unite_gratification) REFERENCES stg_unite_gratification(id_unite_gratification) ON DELETE SET NULL,
ADD FOREIGN KEY (id_entreprise) REFERENCES stg_entreprise(id_entreprise) ON DELETE CASCADE;

ALTER TABLE stg_offre_alternance
ADD FOREIGN KEY (id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE;

ALTER TABLE stg_offre_stage
ADD FOREIGN KEY (id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE;

ALTER TABLE stg_convention
ADD FOREIGN KEY (id_unite_gratification) REFERENCES stg_unite_gratification(id_unite_gratification) ON DELETE SET NULL,
ADD FOREIGN KEY (id_enseignant) REFERENCES stg_enseignant(id_enseignant) ON DELETE SET NULL,
ADD FOREIGN KEY (id_tuteur) REFERENCES stg_tuteur(id_tuteur) ON DELETE SET NULL,
ADD FOREIGN KEY (id_entreprise) REFERENCES stg_entreprise(id_entreprise) ON DELETE SET NULL,
ADD FOREIGN KEY (id_distribution_commune) REFERENCES stg_distribution_commune(id_distribution_commune) ON DELETE SET NULL,
ADD FOREIGN KEY (login) REFERENCES stg_etudiant(login) ON DELETE CASCADE;

ALTER TABLE stg_suivi
ADD UNIQUE (id_convention),
ADD FOREIGN KEY (id_convention) REFERENCES stg_convention(id_convention) ON DELETE CASCADE;

ALTER TABLE stg_code_postal_commune
ADD FOREIGN KEY (id_commune) REFERENCES stg_commune(id_commune) ON DELETE CASCADE,
ADD FOREIGN KEY (id_code_postal) REFERENCES stg_code_postal(id_code_postal) ON DELETE CASCADE;

ALTER TABLE stg_etape_visee
ADD FOREIGN KEY (id_etape) REFERENCES stg_etape(id_etape) ON DELETE CASCADE,
ADD FOREIGN KEY (id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE;

ALTER TABLE stg_offre_categorie
ADD FOREIGN KEY (id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE,
ADD FOREIGN KEY (id_categorie) REFERENCES stg_categorie(id_categorie) ON DELETE CASCADE;

ALTER TABLE stg_postule
ADD FOREIGN KEY (login) REFERENCES stg_etudiant(login) ON DELETE CASCADE,
ADD FOREIGN KEY (id_offre) REFERENCES stg_offre(id_offre) ON DELETE CASCADE;

SQL;

echo $query;