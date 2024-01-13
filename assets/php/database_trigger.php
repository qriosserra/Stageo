<?php

$query = <<<SQL
DELIMITER //

CREATE TRIGGER update_estAdmin_trigger BEFORE INSERT ON stg_enseignant FOR EACH ROW
BEGIN
    DECLARE admin_count INT;
    SELECT COUNT(*) INTO admin_count FROM stg_admin WHERE login = NEW.login;
    
    IF admin_count > 0 THEN
        SET NEW.estAdmin = TRUE;
    ELSE
        SET NEW.estAdmin = FALSE;
    END IF;
END //

DELIMITER ;

    DELIMITER //


CREATE TRIGGER update_estAdmin_insert_trigger AFTER INSERT ON stg_admin FOR EACH ROW
BEGIN
    UPDATE stg_enseignant
    SET estAdmin = TRUE
    WHERE login = NEW.login;
END //


CREATE TRIGGER update_estAdmin_delete_trigger AFTER DELETE ON stg_admin FOR EACH ROW
BEGIN
    UPDATE stg_enseignant
    SET estAdmin = FALSE
    WHERE login = OLD.login;
END //

DELIMITER ;

DELIMITER //
CREATE TRIGGER stg_convention_before_delete
BEFORE DELETE ON stg_convention
FOR EACH ROW
BEGIN
    INSERT INTO stg_convention_archive (
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
        login_enseignant,
        id_tuteur,
        id_entreprise,
        id_distribution_commune,
        login
    )
    VALUES (
        OLD.type_convention,
        OLD.origine_stage,
        OLD.annee_universitaire,
        OLD.thematique,
        OLD.sujet,
        OLD.taches,
        OLD.commentaires,
        OLD.details,
        OLD.date_debut,
        OLD.date_fin,
        OLD.interruption,
        OLD.date_interruption_debut,
        OLD.date_interruption_fin,
        OLD.heures_total,
        OLD.jours_hebdomadaire,
        OLD.heures_hebdomadaire,
        OLD.commentaires_duree,
        OLD.gratification,
        OLD.avantages_nature,
        OLD.code_elp,
        OLD.numero_voie,
        OLD.id_unite_gratification,
        OLD.login_enseignant,
        OLD.id_tuteur,
        OLD.id_entreprise,
        OLD.id_distribution_commune,
        OLD.login
    );
END;
//
DELIMITER ;
    
DELIMITER //
CREATE TRIGGER stg_offre_before_delete
BEFORE DELETE ON stg_offre
FOR EACH ROW
BEGIN
    INSERT INTO stg_offre_archive (
        description,
        thematique,
        secteur,
        taches,
        commentaires,
        gratification,
        type,
        date_debut,
        date_fin,
        niveau,
        valider,
        valider_par_etudiant,
        login,
        id_unite_gratification,
        id_entreprise
    )
    VALUES (
        OLD.description,
        OLD.thematique,
        OLD.secteur,
        OLD.taches,
        OLD.commentaires,
        OLD.gratification,
        OLD.type,
        OLD.date_debut,
        OLD.date_fin,
        OLD.niveau,
        OLD.valider,
        OLD.valider_par_etudiant,
        OLD.login,
        OLD.id_unite_gratification,
        OLD.id_entreprise
    );
END;
//
DELIMITER ;

    
DELIMITER //
CREATE TRIGGER stg_entreprise_before_delete
BEFORE DELETE ON stg_entreprise
FOR EACH ROW
BEGIN
    INSERT INTO stg_entreprise_archive (
        email,
        raison_sociale,
        siret,
        numero_voie,
        code_naf,
        telephone,
        fax,
        site,
        valide,
        id_taille_entreprise,
        id_type_structure,
        id_statut_juridique,
        id_distribution_commune
    )
    VALUES (
        OLD.email,
        OLD.raison_sociale,
        OLD.siret,
        OLD.numero_voie,
        OLD.code_naf,
        OLD.telephone,
        OLD.fax,
        OLD.site,
        OLD.valide,
        OLD.id_taille_entreprise,
        OLD.id_type_structure,
        OLD.id_statut_juridique,
        OLD.id_distribution_commune
    );
END;
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER stg_etudiant_before_delete
BEFORE DELETE ON stg_etudiant
FOR EACH ROW
BEGIN
    DELETE FROM stg_convention WHERE login = OLD.login;
    
    UPDATE stg_convention_archive SET login = NULL WHERE login = OLD.login;
END;
//
DELIMITER ;

SQL;

echo $query;