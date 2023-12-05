-- Etape 1
-- Création table histo_modifs_clients qui enregistrera les Création / Modification / Suppressions clients
DELIMITER //
DROP table IF EXISTS histo_modifs_clients//

CREATE TABLE if not exists histo_modifs_clients (
  ID int(11) NOT NULL AUTO_INCREMENT,
  MODE CHAR(1) NOT NULL, 
  ID_CLIENT int(11) NOT NULL ,
  NOM_COLONNE varchar(12) NOT NULL, 
  ANCIENNE_VALEUR varchar(35) ,
  NOUVELLE_VALEUR varchar(35) , 
  LADATE date NOT NULL, 
  LHEURE time NOT NULL,
  UTILISATEUR varchar(35),
  Primary key (ID)
) //

DELIMITER ;
INSERT INTO clients (CODE_CLIENT,NOM_MAGASIN,ADRESSE_1,ADRESSE_2,CODE_POSTAL,VILLE,RESPONSABLE,TELEPHONE,EMAIL,TYPE_CLIENT) VALUES
('PNY', 'La boutique de Jo', 'Rue des fleurs', 'Lieu Dit les Carcasses', '48200', 'MENDE', 'M. Jo Zéphine', '0000000000', 'zephine@orange.fr', 3);

