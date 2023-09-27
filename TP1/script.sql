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

    CONSTRAINT fk_articles FOREIGN KEY (articles) REFERENCES articles(code_article),
    CONSTRAINT fk_couleur FOREIGN KEY (couleur) REFERENCES a_couleurs(code_couleur),
    CONSTRAINT fk_taille FOREIGN KEY (taille) REFERENCES a_taille(code_taille)
);

-- Etape 7
CREATE TABLE IF NOT EXISTS c_type (
    code_type int(11) not null ,
    designation varchar(30) not null,
    primary key (code_type)
);

-- Etape 8
CREATE TABLE if not exists clients (
    id_client int(11) not null,
    code_client varchar(15) not null,
    nom_magasin varchar(15) not null,
    adresse_1 varchar(35) not null,
    adresse_2 varchar(35) not null,
    code_postal varchar(5) not null,
    ville varchar(35) not null,
    responsable varchar(35) not null,
    telephone varchar(10) not null,
    email varchar(35) not null,
    type_client int(11) not null,
    primary key (id_client),
    constraint  fk_type_client foreign key (type_client) references c_type(code_type)
);

-- Etape 9
create table if not exists devis_entetes (
    id_ent_dev int(11) not null,
    no_devis int(11) not null,
    client int(11) not null,
    date_devis date not null,
    primary key (id_ent_dev),
    constraint fk_client foreign key (client) references clients(id_client)
);

-- Etape 10
create table if not exists devis_lignes (
    id_lig_dev int(11) not null,
    id_devis int(11) not null,
    article int(11) not null,
    couleur int(11) not null,
    taille int(11) not null,
    quantite int(11) not null,
    prix decimal(10,2) not null,
    primary key (id_lig_dev),

    constraint fk_devis_lig_devis foreign key (id_devis) references devis_entetes(id_ent_dev),
    constraint fk_devis_lig_article foreign key (article) references articles(code_article),
    constraint fk_devis_lig_couleur foreign key (couleur) references a_couleurs(code_couleur),
    constraint fk_devis_lig_taille foreign key  (taille) references a_taille(code_taille)
);

-- Etape 11
create table if not exists factures_entetes (
    id_ent_fct int(11) not null,
    no_fact int(11) not null,
    client int(11) not null,
    date_fct date not null,
    primary key (id_ent_fct),
    constraint fk_fct_ent_client foreign key (client) references clients(id_client)
);

-- Etape 12
create table if not exists factures_lignes (
    id_lig_fcct int(11) not null,
    id_fct int(11) not null,
    article int(11) not null,
    couleur int(11) not null,
    taille int(11) not null,
    quantite int(11) not null,
    primary key (id_lig_fcct),
    constraint fk_fct_lig_fct_ent foreign key (id_fct) references factures_entetes(id_ent_fct),
    constraint fk_fct_lig_article foreign key (article) references articles(code_article),
    constraint fk_fct_lig_couleur foreign key (id_fct) references a_couleurs(code_couleur),
    constraint fk_fct_lig_taille foreign key (id_fct) references a_taille(code_taille)

)