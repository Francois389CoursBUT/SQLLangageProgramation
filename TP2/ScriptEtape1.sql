SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mezabi2`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `ID_ARTICLE` int(11) NOT NULL,
  `CODE_ARTICLE` varchar(15) NOT NULL,
  `DESIGNATION` varchar(30) NOT NULL,
  `CATEGORIE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `a_categories`
--

CREATE TABLE `a_categories` (
  `CODE_CATEGORIE` int(11) NOT NULL,
  `DESIGNATION` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `a_couleurs`
--

CREATE TABLE `a_couleurs` (
  `CODE_COULEUR` int(11) NOT NULL,
  `DESIGNATION` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `a_tailles`
--

CREATE TABLE `a_tailles` (
  `CODE_TAILLE` int(11) NOT NULL,
  `DESIGNATION` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `ID_CLIENT` int(11) NOT NULL,
  `CODE_CLIENT` varchar(15) NOT NULL,
  `NOM_MAGASIN` varchar(35) NOT NULL,
  `ADRESSE_1` varchar(35) NOT NULL,
  `ADRESSE_2` varchar(35) NOT NULL,
  `CODE_POSTAL` varchar(5) NOT NULL,
  `VILLE` varchar(35) NOT NULL,
  `RESPONSABLE` varchar(35) NOT NULL,
  `TELEPHONE` varchar(10) NOT NULL,
  `EMAIL` varchar(35) NOT NULL,
  `TYPE_CLIENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `c_types`
--

CREATE TABLE `c_types` (
  `CODE_TYPE` int(11) NOT NULL,
  `DESIGNATION` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devis_entetes`
--

CREATE TABLE `devis_entetes` (
  `ID_ENT_DEV` int(11) NOT NULL,
  `NO_DEVIS` int(11) NOT NULL,
  `CLIENT` int(11) NOT NULL,
  `DATE_DEVIS` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devis_lignes`
--

CREATE TABLE `devis_lignes` (
  `ID_LIG_DEV` int(11) NOT NULL,
  `ID_DEVIS` int(11) NOT NULL,
  `ARTICLE` int(11) NOT NULL,
  `COULEUR` int(11) NOT NULL,
  `TAILLE` int(11) NOT NULL,
  `QUANTITE` int(11) NOT NULL,
  `PRIX` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `factures_entetes`
--

CREATE TABLE `factures_entetes` (
  `ID_ENT_FCT` int(11) NOT NULL,
  `NO_FCT` int(11) NOT NULL,
  `CLIENT` int(11) NOT NULL,
  `DATE_FCT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `factures_lignes`
--

CREATE TABLE `factures_lignes` (
  `ID_LIG_FCT` int(11) NOT NULL,
  `ID_FCT` int(11) NOT NULL,
  `ARTICLE` int(11) NOT NULL,
  `COULEUR` int(11) NOT NULL,
  `TAILLE` int(11) NOT NULL,
  `QUANTITE` int(11) NOT NULL,
  `PRIX` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stockprix`
--

CREATE TABLE `stockprix` (
  `ARTICLE` int(11) NOT NULL,
  `COULEUR` int(11) NOT NULL,
  `TAILLE` int(11) NOT NULL,
  `PRIX` decimal(10,2) NOT NULL,
  `CODE_BARRE` varchar(13) NOT NULL,
  `STOCK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`ID_ARTICLE`),
  ADD KEY `fk_categorie` (`CATEGORIE`);

--
-- Index pour la table `a_categories`
--
ALTER TABLE `a_categories`
  ADD PRIMARY KEY (`CODE_CATEGORIE`);

--
-- Index pour la table `a_couleurs`
--
ALTER TABLE `a_couleurs`
  ADD PRIMARY KEY (`CODE_COULEUR`);

--
-- Index pour la table `a_tailles`
--
ALTER TABLE `a_tailles`
  ADD PRIMARY KEY (`CODE_TAILLE`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ID_CLIENT`),
  ADD KEY `fk_typeClient` (`TYPE_CLIENT`);

--
-- Index pour la table `c_types`
--
ALTER TABLE `c_types`
  ADD PRIMARY KEY (`CODE_TYPE`);

--
-- Index pour la table `devis_entetes`
--
ALTER TABLE `devis_entetes`
  ADD PRIMARY KEY (`ID_ENT_DEV`),
  ADD KEY `fk_Client` (`CLIENT`);

--
-- Index pour la table `devis_lignes`
--
ALTER TABLE `devis_lignes`
  ADD PRIMARY KEY (`ID_LIG_DEV`),
  ADD KEY `fk_idDevis` (`ID_DEVIS`),
  ADD KEY `fk_articleLig` (`ARTICLE`),
  ADD KEY `fk_couleurLig` (`COULEUR`),
  ADD KEY `fk_tailleLig` (`TAILLE`);

--
-- Index pour la table `factures_entetes`
--
ALTER TABLE `factures_entetes`
  ADD PRIMARY KEY (`ID_ENT_FCT`),
  ADD KEY `fk_ClientFCT` (`CLIENT`);

--
-- Index pour la table `factures_lignes`
--
ALTER TABLE `factures_lignes`
  ADD PRIMARY KEY (`ID_LIG_FCT`),
  ADD KEY `fk_idFCT` (`ID_FCT`),
  ADD KEY `fk_articleLigF` (`ARTICLE`),
  ADD KEY `fk_couleurLigF` (`COULEUR`),
  ADD KEY `fk_tailleLigF` (`TAILLE`);

--
-- Index pour la table `stockprix`
--
ALTER TABLE `stockprix`
  ADD PRIMARY KEY (`ARTICLE`,`COULEUR`,`TAILLE`),
  ADD KEY `fk_couleur` (`COULEUR`),
  ADD KEY `fk_taille` (`TAILLE`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `ID_ARTICLE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `a_categories`
--
ALTER TABLE `a_categories`
  MODIFY `CODE_CATEGORIE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `a_couleurs`
--
ALTER TABLE `a_couleurs`
  MODIFY `CODE_COULEUR` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `a_tailles`
--
ALTER TABLE `a_tailles`
  MODIFY `CODE_TAILLE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `ID_CLIENT` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `c_types`
--
ALTER TABLE `c_types`
  MODIFY `CODE_TYPE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `devis_entetes`
--
ALTER TABLE `devis_entetes`
  MODIFY `ID_ENT_DEV` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `devis_lignes`
--
ALTER TABLE `devis_lignes`
  MODIFY `ID_LIG_DEV` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `factures_entetes`
--
ALTER TABLE `factures_entetes`
  MODIFY `ID_ENT_FCT` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `factures_lignes`
--
ALTER TABLE `factures_lignes`
  MODIFY `ID_LIG_FCT` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_categorie` FOREIGN KEY (`CATEGORIE`) REFERENCES `a_categories` (`CODE_CATEGORIE`);

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_typeClient` FOREIGN KEY (`TYPE_CLIENT`) REFERENCES `c_types` (`CODE_TYPE`);

--
-- Contraintes pour la table `devis_entetes`
--
ALTER TABLE `devis_entetes`
  ADD CONSTRAINT `fk_Client` FOREIGN KEY (`CLIENT`) REFERENCES `clients` (`ID_CLIENT`);

--
-- Contraintes pour la table `devis_lignes`
--
ALTER TABLE `devis_lignes`
  ADD CONSTRAINT `fk_articleLig` FOREIGN KEY (`ARTICLE`) REFERENCES `articles` (`ID_ARTICLE`),
  ADD CONSTRAINT `fk_couleurLig` FOREIGN KEY (`COULEUR`) REFERENCES `a_couleurs` (`CODE_COULEUR`),
  ADD CONSTRAINT `fk_idDevis` FOREIGN KEY (`ID_DEVIS`) REFERENCES `devis_entetes` (`ID_ENT_DEV`),
  ADD CONSTRAINT `fk_tailleLig` FOREIGN KEY (`TAILLE`) REFERENCES `a_tailles` (`CODE_TAILLE`);

--
-- Contraintes pour la table `factures_entetes`
--
ALTER TABLE `factures_entetes`
  ADD CONSTRAINT `fk_ClientFCT` FOREIGN KEY (`CLIENT`) REFERENCES `clients` (`ID_CLIENT`);

--
-- Contraintes pour la table `factures_lignes`
--
ALTER TABLE `factures_lignes`
  ADD CONSTRAINT `fk_articleLigF` FOREIGN KEY (`ARTICLE`) REFERENCES `articles` (`ID_ARTICLE`),
  ADD CONSTRAINT `fk_couleurLigF` FOREIGN KEY (`COULEUR`) REFERENCES `a_couleurs` (`CODE_COULEUR`),
  ADD CONSTRAINT `fk_idFCT` FOREIGN KEY (`ID_FCT`) REFERENCES `factures_entetes` (`ID_ENT_FCT`),
  ADD CONSTRAINT `fk_tailleLigF` FOREIGN KEY (`TAILLE`) REFERENCES `a_tailles` (`CODE_TAILLE`);

--
-- Contraintes pour la table `stockprix`
--
ALTER TABLE `stockprix`
  ADD CONSTRAINT `fk_article` FOREIGN KEY (`ARTICLE`) REFERENCES `articles` (`ID_ARTICLE`),
  ADD CONSTRAINT `fk_couleur` FOREIGN KEY (`COULEUR`) REFERENCES `a_couleurs` (`CODE_COULEUR`),
  ADD CONSTRAINT `fk_taille` FOREIGN KEY (`TAILLE`) REFERENCES `a_tailles` (`CODE_TAILLE`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
