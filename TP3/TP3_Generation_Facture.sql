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
SELECT genereFacture(1) ; -- Test de la génération d'une facture

-- Etape 3 fonction genererCodeBarre
DELIMITER //
DROP PROCEDURE IF EXISTS getLastegencodeAndUdate //
CREATE PROCEDURE getLastegencodeAndUdate (out code_produit VARCHAR(5))
BEGIN
DECLARE code_produit VARCHAR(5); -- Numéro du produit du fabricant
    START TRANSACTION ;
    SELECT CONTENU_N INTO code_produit FROM parametres WHERE ID = 'LAST_GENCODE';
    -- Mise à jour du paramètre LAST_GENCODE
    UPDATE parametres SET CONTENU_N = CONTENU_N + 1 WHERE ID = 'LAST_GENCODE';
    COMMIT ;
END //

DROP function IF EXISTS genererCodeBarre //
CREATE FUNCTION genererCodeBarre ()
RETURNS VARCHAR(13)
BEGIN
    DECLARE resultat VARCHAR(13) ;
    DECLARE deb_gencode VARCHAR(7); -- Début du code barre
    DECLARE code_produit VARCHAR(5); -- Numéro du produit du fabricant
    DECLARE cle_control int; -- Clé de contrôle
    DECLARE somme_rang_pair int; -- Clé de contrôle
    DECLARE somme_rang_impair int; -- Clé de contrôle

    SELECT CONTENU_A  INTO deb_gencode FROM parametres WHERE ID = 'DEB_GENCODE';
    CALL getLastegencodeAndUdate(@code_produit);
    SET code_produit = @code_produit;

    SET code_produit = LPAD(code_produit, 5, '0');

    -- Calcul de la clé de contrôle
    -- 1. Somme des chiffres de rang pair du code barre
    SET somme_rang_pair = SUBSTRING(deb_gencode, 2,1) + SUBSTRING(deb_gencode, 4,1) + SUBSTRING(deb_gencode, 6,1) + SUBSTRING(code_produit, 1,1) + SUBSTRING(code_produit, 3,1) + SUBSTRING(code_produit, 5,1);
    -- 2. Multiplier par 3
    SET somme_rang_pair = somme_rang_pair * 3;
    -- 3. Somme des chiffres de rang impair du code barre
    SET somme_rang_impair = SUBSTRING(deb_gencode, 1,1) + SUBSTRING(deb_gencode, 3,1) + SUBSTRING(deb_gencode, 5,1) + SUBSTRING(deb_gencode, 7,1) + SUBSTRING(code_produit, 2,1) + SUBSTRING(code_produit, 4,1);
    -- 4. Somme des résultats des étapes 2 et 3 et le complément à 10 de cette somme modulo 10
    SET cle_control = RIGHT(10 - ((somme_rang_pair + somme_rang_impair)  % 10), 1);

    -- Concaténation du code barre
    SET resultat = CONCAT(deb_gencode, code_produit, cle_control);
    RETURN resultat;
END //
SELECT genererCodeBarre() ; -- Test de la génération d'un code barre
-- TODO fix bug : Data truncation: Data too long for column 'resultat' at row 1
-- Etape 5 - Générer les coes barres pour toutes les lignes de stockprix

UPDATE stockprix SET CODE_BARRE = genererCodeBarre()