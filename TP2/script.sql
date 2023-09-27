-- Etape 1
CREATE DATABASE IF NOT EXISTS mezabi2 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE mezabi2;

-- Etape 2
INSERT INTO a_couleurs (CODE_COULEUR,DESIGNATION) VALUES
     (1,"rouge"),
     (2,"vert"),
     (3, "bleu"),
     (4, "noir")
;

-- Etape 3
INSERT INTO a_categories ( CODE_CATEGORIE, DESIGNATION ) VALUES
    (1,"Pantalons"),
    (2,"Vestes"),
    (3,"Tee-shirt")
;

-- Etape 4
INSERT INTO a_tailles ( CODE_TAILLE,DESIGNATION ) VALUES
    (1, "XS"),
    (2, "S"),
    (3, "M"),
    (4, "L"),
    (5, "XL"),
    (6, "XXL")
;

-- Etape 5
INSERT INTO articles ( ID_ARTICLE, CODE_ARTICLE, DESIGNATION, CATEGORIE ) VALUES
    (2,"PTL002", "Pantalons taille basse", 1)
;

--Etape 6
INSERT INTO stockprix ( ARTICLE, COULEUR, TAILLE, PRIX, CODE_BARRE, STOCK ) VALUES
    (2,1,5,'35.90',"0000000000001",10),
    (2,3,4,'36.90',"0000000000002",150)
;

--Etape 7
UPDATE stockprix SET STOCK = 160 WHERE ARTICLE = 2 and COULEUR = 3 and taille = 4;

--Etape 8
DELETE FROM stockprix WHERE COULEUR = 1;

--Etape 9
DELETE FROM stockprix WHERE ARTICLE = 2;
DELETE FROM articles WHERE ID_ARTICLE = 2;

-- Etape 10
DROP TABLE devis_lignes, factures_lignes, factures_entetes, devis_entetes, stockprix, articles, a_categories, clients, c_types, a_couleurs, a_tailles; 


-- Changment de script
-- Etape 11

-- Etape 12
SELECT CODE_ARTICLE, DESIGNATION
FROM articles
WHERE CATEGORIE = 3;
--Output
--CODE_ARTICLE	DESIGNATION
--TSBATMAN	Tee-shirt Batman
--TSUPER	Tee-shirt Superman

--Etape 13
SELECT art.CODE_ARTICLE, art.DESIGNATION, cat.DESIGNATION
FROM articles art
JOIN a_categories cat
ON art.CATEGORIE = cat.CODE_CATEGORIE
WHERE art.CATEGORIE = 3;


-- Etape 14
SELECT art.CODE_ARTICLE, art.DESIGNATION, stp.STOCK
FROM stockprix stp
JOIN articles art ON stp.ARTICLE = art.ID_ARTICLE
WHERE stp.STOCK < 100
ORDER BY art.CODE_ARTICLE, stp.STOCK;


-- Etape 15
SELECT art.CODE_ARTICLE, art.DESIGNATION, col.DESIGNATION AS "Couleur", tai.DESIGNATION AS "Taille", stp.STOCK, stp.PRIX
FROM stockprix stp
JOIN articles art ON stp.ARTICLE = art.ID_ARTICLE
JOIN a_tailles tai ON stp.TAILLE = tai.CODE_TAILLE
JOIN a_couleurs col ON stp.COULEUR = col.CODE_COULEUR
WHERE stp.STOCK < 100
ORDER BY art.CODE_ARTICLE, stp.COULEUR, stp.TAILLE, stp.STOCK;

-- Etape 16
SELECT MAX(PRIX) 
FROM stockprix

-- Etape 17
SELECT art.CODE_ARTICLE, art.DESIGNATION, col.DESIGNATION AS "Couleur", tai.DESIGNATION AS "Taille", stp.STOCK, stp.PRIX
FROM stockprix stp
JOIN articles art ON stp.ARTICLE = art.ID_ARTICLE
JOIN a_tailles tai ON stp.TAILLE = tai.CODE_TAILLE
JOIN a_couleurs col ON stp.COULEUR = col.CODE_COULEUR
WHERE stp.PRIX = (SELECT MAX(PRIX) 
                  FROM stockprix)
ORDER BY art.CODE_ARTICLE, stp.COULEUR, stp.TAILLE, stp.STOCK;

-- Etape 18
update stockprix
set PRIX = PRIX * 0.9;

SELECT art.CODE_ARTICLE, art.DESIGNATION, col.DESIGNATION AS "Couleur", tai.DESIGNATION AS "Taille", stp.STOCK, stp.PRIX
FROM stockprix stp
JOIN articles art ON stp.ARTICLE = art.ID_ARTICLE
JOIN a_tailles tai ON stp.TAILLE = tai.CODE_TAILLE
JOIN a_couleurs col ON stp.COULEUR = col.CODE_COULEUR
ORDER BY art.CODE_ARTICLE, stp.COULEUR, stp.TAILLE, stp.STOCK;

-- Etape 19
select fe.NO_FCT, fe.DATE_FCT, c.NOM_MAGASIN, c.RESPONSABLE, a.CODE_ARTICLE, a.DESIGNATION, ac.DESIGNATION,
        t.DESIGNATION, fl.QUANTITE, fl.PRIX, (fl.QUANTITE * fl.PRIX) AS Montant
from factures_entetes fe
join clients c on c.ID_CLIENT = fe.CLIENT
join factures_lignes fl on fe.ID_ENT_FCT = fl.ID_FCT
join articles a on a.ID_ARTICLE = fl.ARTICLE
join a_tailles t on t.CODE_TAILLE = fl.TAILLE
join a_couleurs ac on ac.CODE_COULEUR = fl.COULEUR
;

-- Etape 20
select fe.NO_FCT, fe.DATE_FCT, c.NOM_MAGASIN, c.RESPONSABLE, SUM(fl.QUANTITE * fl.PRIX) AS Montant
from factures_entetes fe
join clients c on c.ID_CLIENT = fe.CLIENT
join factures_lignes fl on fe.ID_ENT_FCT = fl.ID_FCT
join articles a on a.ID_ARTICLE = fl.ARTICLE
join a_tailles t on t.CODE_TAILLE = fl.TAILLE
join a_couleurs ac on ac.CODE_COULEUR = fl.COULEUR
group by fe.NO_FCT
order by fe.NO_FCT
;