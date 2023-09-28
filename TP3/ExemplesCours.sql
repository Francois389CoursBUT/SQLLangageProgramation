-- -----------------
delimiter //
DROP procedure IF EXISTS montest1 //
CREATE procedure montest1()
BEGIN
    DECLARE x INT DEFAULT 2;
    DECLARE str1 varchar(50);
	DECLARE str2 varchar(50);
    DECLARE str3 varchar(100);
    SET str1 ='Contenu de la variable 1 ' ;
	SET str2 ='Contenu de la variable 2 ' ;
    SET str3 = CONCAT(str1,'-', str1, x) ; 
    SELECT str3 AS monResultat;
END; //

call montest1() //


-- -----------------
delimiter //
DROP procedure IF EXISTS montest2 //
CREATE procedure montest2()
BEGIN
    DECLARE x INT;
	SET x = (select max(PRIX) from stockprix) ;
	SELECT x AS prixMax;
END; //

call montest2() //

-- 4 -  variables de session

delimiter //
SET @maVariable = 'TEST' //
DROP procedure IF EXISTS montest3 //
CREATE procedure montest3()
BEGIN
	DECLARE x varchar(50);
    set x = @maVariable ;
	SELECT x AS leContenu;
END; //

call montest3() //

-- ---------------
-- 4 - Plusieurs colonnes
delimiter //

DROP procedure IF EXISTS montest4 //
SET @monID = '1' //
CREATE procedure montest4()
BEGIN
	DECLARE code varchar(50);
	DECLARE des varchar(50);
	SELECT CODE_ARTICLE INTO code from articles where ID_ARTICLE = @monID;
	SELECT DESIGNATION INTO des from articles where ID_ARTICLE = @monID;

	SELECT code as codeArticle, des as Designation ;
END; //

call montest4() //

-- 5 - IF
DELIMITER //
DROP function IF EXISTS cherOuPas //
CREATE FUNCTION cherOuPas ( laValeur INT )
RETURNS varchar(30)
BEGIN
   DECLARE cherOuPas varchar(30);
   IF laValeur <= 10 THEN
      SET cherOuPas = 'Ca va...';
   ELSEIF laValeur > 10 AND laValeur <= 49 THEN
      SET cherOuPas = 'Ca pique un peu !';
   ELSEIF laValeur > 50 AND laValeur <= 100 THEN
      SET cherOuPas = 'C\'est hors de prix !';
   ELSE
      SET cherOuPas = 'J\'appelle mon banquier!';
   END IF;
   RETURN cherOuPas;
END; //

DELIMITER ;

select cherOuPas(10) ; 
select cherOuPas(25) ; 
select cherOuPas(90) ; 
select cherOuPas(200) ; 

select A.CODE_ARTICLE, A.DESIGNATION, T.DESIGNATION AS TAILLE, S.STOCK, S.PRIX, cherOuPas(S.PRIX)
from articles A join stockprix S on A.ID_ARTICLE = S.ARTICLE 
join a_tailles T on S.TAILLE = T.CODE_TAILLE 
order by A.CODE_ARTICLE, T.DESIGNATION, S.STOCK;

-- 6 -  CASE Type 1
DELIMITER //
DROP function IF EXISTS typePrix //
CREATE FUNCTION typePrix ( laValeur INT )
RETURNS varchar(30)
BEGIN
   DECLARE typePrix varchar(30);
   CASE laValeur
		WHEN 100 THEN
			SET typePrix = 'C\'est un prix rond';
		WHEN 99 THEN
			SET typePrix = 'C\'est un prix commercial';
	ELSE
		SET typePrix = 'Prix normal';
	END CASE;
	RETURN typePrix;
END; //

DELIMITER ;

select typePrix(10) ; 
select typePrix(99) ; 
select typePrix(100) ; 

select A.CODE_ARTICLE, A.DESIGNATION, T.DESIGNATION AS TAILLE, S.STOCK, S.PRIX, typePrix(S.PRIX)
from articles A join stockprix S on A.ID_ARTICLE = S.ARTICLE 
join a_tailles T on S.TAILLE = T.CODE_TAILLE 
order by A.CODE_ARTICLE, T.DESIGNATION, S.STOCK;

-- 7 -  CASE Type 2
DELIMITER //
DROP function IF EXISTS typePrix2 //
CREATE FUNCTION typePrix2 ( laValeur INT )
RETURNS varchar(30)
BEGIN
   DECLARE typePrix varchar(30);
   CASE 
		WHEN laValeur=100 THEN
			SET typePrix = 'C\'est un prix rond';
		WHEN laValeur=99 THEN
			SET typePrix = 'C\'est un prix commercial';
	ELSE
		SET typePrix = 'Prix normal';
	END CASE;
	RETURN typePrix;
END; //

DELIMITER ;

select typePrix2(10) ; 
select typePrix2(99) ; 
select typePrix2(100) ; 

select A.CODE_ARTICLE, A.DESIGNATION, T.DESIGNATION AS TAILLE, S.STOCK, S.PRIX, typePrix2(S.PRIX)
from articles A join stockprix S on A.ID_ARTICLE = S.ARTICLE 
join a_tailles T on S.TAILLE = T.CODE_TAILLE 
order by A.CODE_ARTICLE, T.DESIGNATION, S.STOCK;


-- 8 - While
DELIMITER //
DROP function IF EXISTS leWhile //
CREATE FUNCTION leWhile (caractere CHAR, nombreDeFois INT )
-- Retourne une chaîne de caractères contenant nombreDeFois le caractere
RETURNS varchar(30)
BEGIN
	DECLARE laChaineDeRetour varchar(30) default '';	-- Variable pour le retour mise à vide pour que la concatenation fonctionne
	DECLARE I int DEFAULT 1 ; 							-- Variable pour compteur 
	IF nombreDeFois>30 THEN 
		SET laChaineDeRetour = 'Erreur, maximum 30';
	ELSE
		WHILE I<=nombreDeFois DO 
			SET laChaineDeRetour = CONCAT(laChaineDeRetour,caractere) ; 
			SET I=I+1 ; 
		END WHILE ;
	END IF;
	RETURN laChaineDeRetour;
END; //

DELIMITER ;

select leWhile('A', 10) AS maChaine ; 
select leWhile('B', 30) AS maChaine ; 
select leWhile('C', 31) AS maChaine; 


-- 9 -  repeat
DELIMITER //
DROP function IF EXISTS leRepeat //
CREATE FUNCTION leRepeat (caractere CHAR, nombreDeFois INT )
-- Retourne une chaîne de caractères contenant nombreDeFois le caractere
RETURNS varchar(30)
BEGIN
	DECLARE laChaineDeRetour varchar(30) default '';	-- Variable pour le retour mise à vide pour que la concatenation fonctionne
	DECLARE I int DEFAULT 0 ; 							-- Variable pour compteur 
	IF nombreDeFois>30 THEN 
		SET laChaineDeRetour = 'Erreur, maximum 30';
	ELSE
		REPEAT  
			SET laChaineDeRetour = CONCAT(laChaineDeRetour,caractere) ; 
			SET I=I+1 ; 
		UNTIL I=nombreDeFois
		END REPEAT ;
	END IF;
	RETURN laChaineDeRetour;
END; //

DELIMITER ;

select leRepeat('A', 10) AS maChaine ; 
select leRepeat('B', 30) AS maChaine ; 
select leRepeat('C', 31) AS maChaine; 




-- 10 - SELECT INTO
DELIMITER //
DROP function IF EXISTS prixMax //
CREATE FUNCTION prixMax ()
-- Retourne le prix maximum 
RETURNS int
BEGIN
	DECLARE lePrixMax decimal(10,2) ;
	select max(prix) into lePrixMax from stockprix ; 
	RETURN lePrixMax;
END; //

DELIMITER ;

select prixMax() AS lePrixMax ; 
 
 
 -- RAND
 select round(rand()*10) ;
 
 -- 11 - Procédures
DELIMITER //
DROP procedure IF EXISTS testCarre//

CREATE procedure testCarre(IN leNombre INT, OUT leCarre INT, INOUT puissance3 INT)
-- Calcul du carré d'un nombre et du cube d'un autre
BEGIN
	SET leCarre=leNombre * leNombre ;
	SET leNombre=122 ;
	SET puissance3=puissance3*puissance3*puissance3 ;
END; //

DELIMITER ;

SET @leNombre = 2 ;
SET @p3 = 10 ;
call  testCarre(@leNombre,@leCalcul, @p3) ;
select  @leNombre ;
select  @leCalcul ;
select  @p3 ;
 
-- 12 - Fonctions
DELIMITER //
DROP function IF EXISTS functionCarre//
CREATE function functionCarre(leNombre INT) RETURNS INT
-- Calcul du carré d'un nombre et du cube d'un autre
BEGIN
   DECLARE carre INT ; 
   SET carre=leNombre * leNombre ;
   SET leNombre=122 ;
   RETURN carre ;
END; //

DELIMITER ;

SET @leNombre = 2 ;
SELECT  functionCarre(@leNombre) ;
select  @leNombre ;



-- (13)- Curseurs
DELIMITER //
DROP function IF EXISTS lesEmails//
CREATE function lesEmails() RETURNS varchar(1000)
-- constitution d'une chaîne de caracteres contenant les adresses email
BEGIN
	DECLARE leResultat VARCHAR(1000) DEFAULT '' ; 
	DECLARE leMail VARCHAR(35) ;
	DECLARE finCurseur INTEGER DEFAULT 0;
	DECLARE Premier INTEGER DEFAULT 1;
	DECLARE curseur CURSOR FOR 
		SELECT EMAIL FROM clients ;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET finCurseur = 1 ;
	OPEN curseur ;
	
	boucle:LOOP
		FETCH curseur INTO leMail; -- Attention nom variable # nom colonne !!
		IF finCurseur = 1 THEN 
			LEAVE boucle;
		END IF;
		IF leResultat!='' THEN 
			SET leResultat = CONCAT(leResultat,";");
		END IF;
		SET leResultat = CONCAT(leResultat,leMail);
		SET Premier=0;
	END LOOP boucle;
	CLOSE curseur;
	RETURN leResultat ;
END; //
DELIMITER ;
SELECT  lesEmails() ;
-- Résultat : vetonline@vet.com;dumont@orange.fr;superu@orange.com;vendeurZ@orange.com

-- (14) TRIGGERS BEFORE INSERT 
DELIMITER //
DROP table IF EXISTS personnes//
DROP trigger IF EXISTS testAge//

CREATE TABLE personnes (ID int(11) NOT NULL AUTO_INCREMENT,nom varchar(30) NOT NULL,age int(11) NOT NULL, Primary key (ID)) //

CREATE TRIGGER testAge BEFORE INSERT ON personnes
FOR EACH ROW
BEGIN
	IF NEW.age < 18 THEN
		SIGNAL SQLSTATE '50001' SET MESSAGE_TEXT = 'La personne doit avoir plus de 18 ans !';
	END IF; 
END//

delimiter ;

INSERT INTO personnes (nom, age) VALUES ('Nom1', 18);
INSERT INTO personnes (nom, age) VALUES ('Nom2', 17);

-- (15)- TRIGGERS BEFORE DELETE 
DELIMITER //
DROP table IF EXISTS personnes_archives//
DROP trigger IF EXISTS archivePersonnes//

CREATE TABLE personnes_archives (ID int(11) NOT NULL ,nom varchar(30) NOT NULL,age int(11) NOT NULL, Primary key (ID)) //

CREATE TRIGGER archivePersonnes BEFORE DELETE ON personnes
FOR EACH ROW
BEGIN
	INSERT INTO personnes_archives (ID, nom, age)
	VALUES (OLD.ID, OLD.nom, OLD.age); 
END//

delimiter ;

SELECT * FROM personnes ; 
SELECT * FROM personnes_archives ; 
DELETE FROM personnes where ID = '1' ;
SELECT * FROM personnes ;
SELECT * FROM personnes_archives ; 
 
-- 16 - Triggers exemple 3 CA d'un client mis à jour automatiquement
DELIMITER //
DROP table IF EXISTS personnes//
CREATE TABLE personnes (ID int(11) NOT NULL AUTO_INCREMENT,nom varchar(30) NOT NULL, CA DECIMAL(10,2) DEFAULT 0, Primary key (ID)) //
INSERT INTO personnes (nom) VALUES ('Nom1')//
INSERT INTO personnes (nom) VALUES ('Nom2')//

DROP table IF EXISTS factures//
CREATE TABLE factures (ID int(11) NOT NULL AUTO_INCREMENT,IDClient INT(11) NOT NULL, article varchar(30) NOT NULL, montant DECIMAL(10,2) NOT NULL, Primary key (ID)) //

-- Trigger pour création d'une ligne de facture
DROP trigger IF EXISTS factureC//
CREATE TRIGGER factureC AFTER INSERT ON factures
FOR EACH ROW
BEGIN
	UPDATE personnes SET CA = CA + NEW.montant WHERE ID = NEW.IDClient;
END//

DELIMITER ;
INSERT INTO factures (IDClient, article, montant) VALUES (1,'Pantalon',49.25);
INSERT INTO factures (IDClient, article, montant) VALUES (1,'Veste',50.75);
INSERT INTO factures (IDClient, article, montant) VALUES (2,'Tee-shirt',12);


-- Trigger pour modification d'une ligne de facture
DELIMITER //
DROP trigger IF EXISTS factureU//
CREATE TRIGGER factureU AFTER UPDATE ON factures
FOR EACH ROW
BEGIN
	UPDATE personnes SET CA = CA - OLD.montant + NEW.montant WHERE ID = OLD.IDClient;
END//

DELIMITER ;
UPDATE factures SET montant = 25 where ID = 1;
UPDATE factures SET montant = 25 where ID = 2;
UPDATE factures SET montant = 25 where ID = 3;



-- Trigger pour suppression d'une ligne de facture
DELIMITER //
DROP trigger IF EXISTS factureD//
CREATE TRIGGER factureD AFTER DELETE ON factures
FOR EACH ROW
BEGIN
	UPDATE personnes SET CA = CA - OLD.montant WHERE ID = OLD.IDClient;
END//

DELIMITER ;
DELETE FROM factures WHERE ID = 1;
DELETE FROM factures WHERE ID = 2;
DELETE FROM factures WHERE ID = 3;




-- Gestion d'erreurs

Select nomClient from personnes ;
select * FROM `maTableQuiNExistePas`;


-- 17 Exemple Exception not Found
DELIMITER //
DROP table IF EXISTS personnes//
CREATE TABLE personnes (ID int(11) NOT NULL AUTO_INCREMENT,nom varchar(30) NOT NULL, CA DECIMAL(10,2) DEFAULT 0, Primary key (ID)) //
INSERT INTO personnes (nom) VALUES ('Nom1')//
INSERT INTO personnes (nom) VALUES ('Nom2')//

DROP procedure IF EXISTS notFound//
CREATE procedure notFound(IDPersonne INT)
-- recherche d'une personne 
BEGIN
	DECLARE flagNotFound INT DEFAULT 0;
	DECLARE leNomPersonne VARCHAR(20);
	BEGIN
		DECLARE EXIT HANDLER FOR NOT FOUND set flagNotFound=1;
		SELECT nom into leNomPersonne from personnes where ID = IDPersonne ;
		SELECT Concat(flagNotFound,' ',IDPersonne,' ',leNomPersonne) as NomPersonne  ;
	END; 
	if flagNotFound=1 THEN
		SELECT CONCAT(flagNotFound,' ',IDPersonne,' Personne non trouvée') as NomPersonne ;
	END IF;
END; //
DELIMITER ;

call notFound(1) ;
call notFound(26) ;

-- 18 Exemple Exception CONTINUE
DELIMITER //
DROP table IF EXISTS personnes//
CREATE TABLE personnes (ID int(11) NOT NULL AUTO_INCREMENT,nom varchar(30) NOT NULL, CA DECIMAL(10,2) DEFAULT 0, Primary key (ID)) //
INSERT INTO personnes (nom) VALUES ('Nom1')//
INSERT INTO personnes (nom) VALUES ('Nom2')//

DROP procedure IF EXISTS testContinue//
CREATE procedure testContinue(IDPersonne INT)
-- recherche d'une personne 
BEGIN
	DECLARE flagNotFound INT DEFAULT 0;
	DECLARE leNomPersonne VARCHAR(20);
	DECLARE CONTINUE HANDLER FOR NOT FOUND set flagNotFound=1;
	SELECT nom into leNomPersonne from personnes where ID = IDPersonne ;
	

	IF flagNotFound=1 THEN
		SELECT CONCAT(flagNotFound,' ',IDPersonne,' Personne non trouvée') as NomPersonne ;
	ELSE 
		SELECT Concat(flagNotFound,' ',IDPersonne,' ',leNomPersonne) as NomPersonne  ;
	END IF;
END; //
DELIMITER ;

call testContinue(1) ;
call testContinue(26) ;

-- 19 - Exemple Exception SQLEXCEPTION
DELIMITER //
DROP table IF EXISTS personnes//
CREATE TABLE personnes (ID int(11) NOT NULL AUTO_INCREMENT,nom varchar(30) NOT NULL, CA DECIMAL(10,2) DEFAULT 0, Primary key (ID)) //
INSERT INTO personnes (nom) VALUES ('Nom1')//
INSERT INTO personnes (nom) VALUES ('Nom2')//

DROP procedure IF EXISTS testSQLException//
CREATE procedure testSQLException(IDPersonne INT)
-- recherche d'une personne 
BEGIN
	DECLARE erreur INT DEFAULT 0;
	DECLARE leNomPersonne VARCHAR(20);
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION set erreur=1;
	-- GESTION DES ERREURS AUTRES QUE NOT FOUND, ICI COLONNE INEXISTANTE
	SELECT NOMCOLONNE into leNomPersonne from personnes where ID = IDPersonne ;

	IF erreur=1 THEN
		SELECT 'ERREUR BD' as NomPersonne  ;
	ELSE 
		SELECT Concat(flagNotFound,' ',IDPersonne,' ',leNomPersonne) as NomPersonne  ;
	END IF;
END; //
DELIMITER ;

call testSQLException(1) ;
call testSQLException(26) ;

-- 20 - Exemple Exception SIGNAL
DELIMITER //

DROP procedure IF EXISTS testSQLSignal1//
CREATE procedure testSQLSignal1(montant INT)
BEGIN
	DECLARE montantTropBas CONDITION FOR SQLSTATE '45000';
	if montant<100 THEN
		SIGNAL montantTropBas
		SET MESSAGE_TEXT='Montant trop bas' , MYSQL_ERRNO = '9000';
	ELSE
		SIGNAL montantTropBas
		SET MESSAGE_TEXT='Montant OK' , MYSQL_ERRNO = '9001';
	END IF;
	SELECT montant;
END; //
DELIMITER ;

call testSQLSignal1(50) ;
call testSQLSignal1(100) ;


DELIMITER //

DROP procedure IF EXISTS testSQLSignal2//
CREATE procedure testSQLSignal2(montant INT)
BEGIN
	DECLARE flag INT DEFAULT 0;
	DECLARE CONTINUE HANDLER FOR SQLSTATE '45000' SET flag=1;
	call testSQLSignal1(montant) ;
	SHOW ERRORS ;
END; //
DELIMITER ;
 
call testSQLSignal2(50) ;
call testSQLSignal2(100) ;

-- AUTOCOMMIT à 0
SELECT * FROM personnes;  
SET autocommit=0;
update personnes SET nom = 'Nouveau' where ID = '1' ;
SELECT * FROM personnes ; 
COMMIT ; 

SET autocommit=0;
update personnes SET nom = 'Nouveau' where ID = '1' ;
SELECT * FROM personnes ; 
ROLLBACK ; 

-- 21 --- Exemple comptes bancaires
DELIMITER //
DROP table IF EXISTS comptes//
CREATE TABLE comptes (IDCompte int(11) NOT NULL AUTO_INCREMENT,NoClient INT, nomCompte varchar(30) NOT NULL, montant DECIMAL(10,2) DEFAULT 0, Primary key (IDCompte)) //
INSERT INTO comptes (NoClient, nomCompte, montant) VALUES (1,'Compte principal',1000)//
INSERT INTO comptes (NoClient, nomCompte, montant) VALUES (1,'Epargne',0)//

CREATE TRIGGER TestSolde BEFORE UPDATE ON comptes
-- Trigger empechant d'avoir un solde <0
FOR EACH ROW
BEGIN
	IF NEW.montant <0 THEN
		SIGNAL SQLSTATE '50001' SET MESSAGE_TEXT = 'Solde insuffisant !';
	END IF; 
END//



DROP procedure IF EXISTS virement//
CREATE procedure virement(IDCompteDepart INT, IDCompteArrivee INT, leMontant DECIMAL(10,2))
-- Virement du compte IDCompteDepart vers IDCompteArrivee du montant 
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
		SET @leRetour = 'KO' ;
		ROLLBACK;
    END;
	
	START TRANSACTION ;
	UPDATE comptes SET montant = montant + leMontant WHERE IDCompte = IDCompteArrivee;
	UPDATE comptes SET montant = montant - leMontant WHERE IDCompte = IDCompteDepart;
	COMMIT ; 
	SET @leRetour = 'OK' ;
END; //

DELIMITER ;

-- Virement qui marche.
SET @leRetour = '' ;
call virement(1,2,10);
SELECT @leRetour ;

-- Virement qui ne marchera pas.
SET @leRetour = '' ;
call virement(1,2,10000);
SELECT @leRetour ;


