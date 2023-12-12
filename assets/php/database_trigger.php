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




SQL;

echo $query;