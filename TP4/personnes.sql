--
-- Base de données :  `demopdo`
--

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

CREATE TABLE `personnes` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(35) NOT NULL,
  `PRENOM` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `personnes`
--

INSERT INTO `personnes` (`ID`, `NOM`, `PRENOM`) VALUES
(1, 'Dupont', 'Albert'),
(2, 'Dupond', 'Georges'),
(3, 'Soliman', 'Ronald'),
(4, 'Delapersonne', 'Dominique');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

