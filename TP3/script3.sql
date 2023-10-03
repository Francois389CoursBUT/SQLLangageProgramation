-- Etape 1
CREATE DATABASE IF NOT EXISTS mezabi3 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE mezabi3;

-- Etape 2
USE mezabi3;

DELIMITER //
DROP FUNCTION IF EXISTS insererFactureEntete //
CREATE FUNCTION insererFactureEntete(id_client int) RETURNS varchar(9)
BEGIN
    DECLARE annee varchar(4);
    DECLARE mois  varchar(2);
    DECLARE nb    varchar(3);
    DECLARE numero_fct varchar(9);
    DECLARE resultat varchar(10);
    DECLARE date_actuell DATE;

    -- On récupére le mois et l'année actuelle
    SET date_actuell = CURDATE();
    SET annee = DATE_FORMAT(date_actuell,'%Y');
    SET mois = DATE_FORMAT(date_actuell,'%m');

    -- On récupére le nouveau numéro de la facture
    SELECT MAX(MOD(NO_FCT,1000))+1 INTO nb 
    FROM factures_entetes 
    WHERE DATE_FORMAT(DATE_FCT,'%Y') = annee && DATE_FORMAT(DATE_FCT,'%m') = mois;
    
    -- Si il n'y a pas de facture pour ce mois alors la requet renvoie null
    -- On corrige en mettant à zéro
    IF nb IS null THEN
        SET nb = '000';
    END IF;

    -- On compléte le numéro de facture avec l'année est le mois
    SET numero_fct = CONCAT(annee, mois, nb);

    -- On insére la nouvelle facture
    INSERT INTO factures_entetes (no_fct, client, date_fct) VALUES (
        (numero_fct, id_client, date_actuell)
    );

    RETURN numero_fct;

END; //
DELIMITER ;

--Si ausune facture, renvoie null
USE mezabi3;
SELECT MAX(MOD(NO_FCT,1000))+1
FROM factures_entetes
WHERE DATE_FORMAT(DATE_FCT,'%Y') = "2023" && DATE_FORMAT(DATE_FCT,'%m') = "10";

-- Etape 3
USE mezabi3;
SELECT CODE_ARTICLE
FROM articles;

UPDATE articles SET CODE_ARTICLE = '';
