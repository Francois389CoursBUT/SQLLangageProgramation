-- Etape 1
CREATE DATABASE IF NOT EXISTS mezabi DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE mezabi;

-- Etape 2
CREATE TABLE IF NOT EXISTS a_categorie (
code_categorie int(10) NOT NULL AUTO_INCREMENT,
designation VARCHAR(30) NOT NULL,
PRIMARY KEY (code_categorie)
);

-- Etape 3
CREATE TABLE IF NOT EXISTS a_couleurs (
    code_couleur INT(10) NOT NULL AUTO_INCREMENT,
    designation VARCHAR(30) NOT NULL,
    PRIMARY KEY (code_couleur)
);

--Etape 4
CREATE TABLE IF NOT EXISTS a_taille (
    code_taille INT(10) NOT NULL AUTO_INCREMENT,
    taille VARCHAR(3) NOT NULL,
    PRIMARY KEY (code_taille)
);

--Etape 5
CREATE TABLE IF NOT EXISTS articles (
    code_article int(15) NOT NULL AUTO_INCREMENT,
    designation VARCHAR(30) NOT NULL,
    categorie int(10) NOT NULL,
    PRIMARY KEY (code_article),
    CONSTRAINT fk_categorie FOREIGN KEY (categorie) REFERENCES a_categorie(code_categorie)
);

--Etape 6 
CREATE TABLE IF NOT EXISTS stocksPrix (
    code_barre VARCHAR(13) NOT NULL,
    articles int(15) NOT NULL,
    couleur  int(10) NOT NULL,
    taille INT(10) NOT NULL,
    prix decimal(10,2) NOT NULL,
    stock INT(11),
    PRIMARY KEY (articles,couleur,taille),

    CONSTRAINT fk_articles FOREIGN KEY (articles) REFERENCES articles(code_articles)
    CONSTRAINT fk_couleur FOREIGN KEY (couleur) REFERENCES a_couleurs(code_couleur)
    CONSTRAINT fk_taille FOREIGN KEY (taille) REFERENCES a_taille(code_taille)
);