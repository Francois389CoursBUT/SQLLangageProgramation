-- Etape 2 - Fonction genereFacture 
DELIMITER //
DROP function IF EXISTS genereFacture //
CREATE FUNCTION genereFacture (IDClient INT)
-- Paramètre en entrée ID du client pour lequel la fonction va créer l'entête de la facture.
RETURNS int
BEGIN
    DECLARE noFacture INT default 0;
    DECLARE maxExistant INT ; -- Numero de facture maximum existant pour l'année et le mois
    DECLARE dateAAAAMM VARCHAR(6) ;
    
    -- Récupération de la date du jour et mise au format AAAAMM
    SET dateAAAAMM = DATE_FORMAT(CURDATE(), '%Y%m'); -- AAAAMM
    
    -- Récupération du No de facture maximum correspondant au début AAAAMM (Numéro maximum de facture sur le mois)
    SELECT max(NO_FCT) into maxExistant from factures_entetes where No_FCT like concat(dateAAAAMM,'%') ;
    
    -- Si pas de facture existante sur le mois en cours, maxExistant=NULL, on mets dans la variable AAAAMM000
    IF maxExistant IS NULL THEN 
        SET maxExistant= concat(dateAAAAMM,'000') ;
    END IF ;
    
    -- Incrémentation du numero de facture
    SET noFacture=maxExistant+1; 
    
    -- Ajout de la facture dans factures_entetes
    INSERT INTO factures_entetes(CLIENT, NO_FCT, DATE_FCT) Values (IDClient, noFacture, CURDATE()) ;
    
    RETURN noFacture ;
END; //

DELIMITER ;
SELECT genereFacture(1) ; -- Test de la génération d'une facture