-- Etape 1
CREATE DATABASE IF NOT EXISTS mezabi3 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE mezabi3;

USE mezabi3;
delimiter //
DROP procedure IF EXISTS insererFactureEntete //
CREATE procedure insererFactureEntete(id_client int) RETURNS varchar(9)
BEGIN
    DECLARE annee varchar(4);
    DECLARE mois varchar(2);
    DECLARE nb varchar(3);
    DECLARE numero_fct varchar(9);

    SET annee = DATE_FORMAT(CURDATE(),'%Y');
    SET mois = DATE_FORMAT(CURDATE(),'%m');
    SELECT MAX(MOD(NO_FCT,1000))+1 INTO nb FROM factures_entetes WHERE DATE_FORMAT(DATE_FCT,'%Y') = annee && DATE_FORMAT(DATE_FCT,'%m') = mois;
    SET numero_fct = CONCAT(annee, mois, nb);

    INSERT INTO factures_entetes (no_fct, client, date_fct) VALUES (
        (numero_fct, id_client, CURDATE())
    );
    RETURN numero_fct;

END; //
DELIMITER ;

--Si ausune facture, renvoie null
USE mezabi3;
SELECT MAX(MOD(NO_FCT,1000))+1
FROM factures_entetes
WHERE DATE_FORMAT(DATE_FCT,'%Y') = "2023" && DATE_FORMAT(DATE_FCT,'%m') = "09"
