-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 11 mai 2025 à 15:50
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hainergie`
--

-- --------------------------------------------------------

--
-- Structure de la table `caracteristique_centrale`
--

CREATE TABLE `caracteristique_centrale` (
  `id_centrale` int(11) NOT NULL,
  `cout_construction_argent` int(11) NOT NULL,
  `cout_construction_metal` int(11) NOT NULL,
  `entretien_argent` int(11) NOT NULL,
  `entretient_metal` int(11) NOT NULL,
  `consommation_100` float NOT NULL,
  `production_centrale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `caracteristique_centrale`
--

INSERT INTO `caracteristique_centrale` (`id_centrale`, `cout_construction_argent`, `cout_construction_metal`, `entretien_argent`, `entretient_metal`, `consommation_100`, `production_centrale`) VALUES
(1, 1500000000, 2000, 30000000, 65, 2.5, 500000000),
(2, 300000000, 600, 10000000, 20, 35000, 20000000),
(3, 50000000, 100, 1500000, 4, 0, 2000000);

-- --------------------------------------------------------

--
-- Structure de la table `caracteristique_mine`
--

CREATE TABLE `caracteristique_mine` (
  `id_mine` int(11) NOT NULL,
  `cout_construction_argent` int(11) NOT NULL,
  `cout_construction_metal` int(11) NOT NULL,
  `entretien_argent` int(11) NOT NULL,
  `entretient_metal` int(11) NOT NULL,
  `production_mine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `caracteristique_mine`
--

INSERT INTO `caracteristique_mine` (`id_mine`, `cout_construction_argent`, `cout_construction_metal`, `entretien_argent`, `entretient_metal`, `production_mine`) VALUES
(1, 200000000, 200, 7000000, 7, 1),
(2, 150000000, 300, 5000000, 10, 15000),
(3, 10000000, 0, 300000, 0, 50);

-- --------------------------------------------------------

--
-- Structure de la table `caracteristique_partie`
--

CREATE TABLE `caracteristique_partie` (
  `id_partie` int(11) NOT NULL,
  `date_partie` date NOT NULL DEFAULT '2025-01-01',
  `nb_tour` int(11) NOT NULL DEFAULT 0,
  `argent_par_tour` int(11) NOT NULL DEFAULT 10000000,
  `energie_par_tour` int(11) NOT NULL DEFAULT 0,
  `quantite_argent` bigint(11) NOT NULL DEFAULT 50000000,
  `quantite_uranium` float NOT NULL DEFAULT 0,
  `quantite_metal` int(11) NOT NULL DEFAULT 0,
  `quantite_petrole` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `caracteristique_partie`
--

INSERT INTO `caracteristique_partie` (`id_partie`, `date_partie`, `nb_tour`, `argent_par_tour`, `energie_par_tour`, `quantite_argent`, `quantite_uranium`, `quantite_metal`, `quantite_petrole`) VALUES
(1, '2026-10-01', 21, 2147483647, 25592953, 13635728752, 0, 4264, -35000),
(2, '2025-01-01', 0, 10000000, 0, 50000000, 0, 0, 0),
(3, '2025-01-01', 0, 10000000, 0, 50000000, 0, 0, 0),
(4, '2025-01-01', 0, 10000000, 0, 50000000, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `centrale_joueur`
--

CREATE TABLE `centrale_joueur` (
  `id_centrale` int(11) NOT NULL,
  `id_partie` int(11) NOT NULL,
  `id_ressource` int(11) NOT NULL,
  `nom_mine` varchar(255) NOT NULL,
  `taux_production` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `centrale_joueur`
--

INSERT INTO `centrale_joueur` (`id_centrale`, `id_partie`, `id_ressource`, `nom_mine`, `taux_production`) VALUES
(3, 1, 3, 'centrale verte', 100),
(3, 1, 3, 'centrale verte', 100),
(3, 1, 3, 'centrale verte', 100),
(2, 1, 4, 'centrale petrole', 100),
(2, 1, 4, 'centrale petrole', 100);

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

CREATE TABLE `contrat` (
  `id_contrat` int(11) NOT NULL,
  `id_ressource` int(11) NOT NULL,
  `id_acceptant` int(11) DEFAULT NULL,
  `id_emeteur` int(11) NOT NULL,
  `temps_contrat` int(11) NOT NULL,
  `quantite_ressource` int(11) DEFAULT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contrat`
--

INSERT INTO `contrat` (`id_contrat`, `id_ressource`, `id_acceptant`, `id_emeteur`, `temps_contrat`, `quantite_ressource`, `prix`) VALUES
(1, 0, 3, 1, 12, 100, 1500000000),
(2, 0, NULL, 3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mine_joueur`
--

CREATE TABLE `mine_joueur` (
  `id_mine` int(11) NOT NULL,
  `id_partie` int(11) NOT NULL,
  `id_ressource` int(11) NOT NULL,
  `nom_mine` varchar(255) NOT NULL,
  `taux_production` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mine_joueur`
--

INSERT INTO `mine_joueur` (`id_mine`, `id_partie`, `id_ressource`, `nom_mine`, `taux_production`) VALUES
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(2, 1, 4, 'mine petrole', 100),
(2, 1, 4, 'mine petrole', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100),
(3, 1, 1, 'mine metal', 100);

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

CREATE TABLE `partie` (
  `id_partie` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`id_partie`, `id_utilisateur`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `ressource_joueur`
--

CREATE TABLE `ressource_joueur` (
  `id_ressource` int(11) NOT NULL,
  `nom_ressource` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ressource_joueur`
--

INSERT INTO `ressource_joueur` (`id_ressource`, `nom_ressource`) VALUES
(0, 'uranium'),
(1, 'metal'),
(2, 'argent'),
(3, 'energie'),
(4, 'petrole');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `date_naissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `email`, `mdp`, `date_naissance`) VALUES
(1, 'gabriel.laboureau@utbm.fr', '$2y$10$8sfHDKkgFSZ3vy6gh6Cnw.G4/txzMpWCxBCLOh2BDrop7zZJbGWPm', '2006-12-18'),
(2, 'utilisateur_fantome@gmail.com', '$2y$10$lnqx6L/sYpLn2yrVSdEJPO2bjpzNnYeoRYLX9iDnHQ6pvH4Y0HQUO', '2000-10-10'),
(3, 'test@gmail.com', '$2y$10$PKELCR2lmp6RmTfd0mIh/O98itdM.ISIA3qN7ayeHs2q/sQZYvSWO', '1000-10-10'),
(4, 'test2@gmail.com', '$2y$10$Uq5xt/2KInTZteqGznLCR.zdTkwV66u7VCVANgV3MXXMB.iuJOLQW', '1500-10-10');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `caracteristique_centrale`
--
ALTER TABLE `caracteristique_centrale`
  ADD PRIMARY KEY (`id_centrale`);

--
-- Index pour la table `caracteristique_mine`
--
ALTER TABLE `caracteristique_mine`
  ADD PRIMARY KEY (`id_mine`);

--
-- Index pour la table `caracteristique_partie`
--
ALTER TABLE `caracteristique_partie`
  ADD KEY `id_partie` (`id_partie`);

--
-- Index pour la table `centrale_joueur`
--
ALTER TABLE `centrale_joueur`
  ADD KEY `id_centrale` (`id_centrale`),
  ADD KEY `id_partie` (`id_partie`),
  ADD KEY `id_ressource` (`id_ressource`);

--
-- Index pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`id_contrat`),
  ADD KEY `id_ressource` (`id_ressource`),
  ADD KEY `id_acceptant` (`id_acceptant`),
  ADD KEY `id_emeteur` (`id_emeteur`);

--
-- Index pour la table `mine_joueur`
--
ALTER TABLE `mine_joueur`
  ADD KEY `id_partie` (`id_partie`),
  ADD KEY `id_ressource` (`id_ressource`),
  ADD KEY `id_mine` (`id_mine`);

--
-- Index pour la table `partie`
--
ALTER TABLE `partie`
  ADD PRIMARY KEY (`id_partie`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `ressource_joueur`
--
ALTER TABLE `ressource_joueur`
  ADD PRIMARY KEY (`id_ressource`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `caracteristique_centrale`
--
ALTER TABLE `caracteristique_centrale`
  MODIFY `id_centrale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `caracteristique_mine`
--
ALTER TABLE `caracteristique_mine`
  MODIFY `id_mine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `partie`
--
ALTER TABLE `partie`
  MODIFY `id_partie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `caracteristique_partie`
--
ALTER TABLE `caracteristique_partie`
  ADD CONSTRAINT `caracteristique_partie_ibfk_1` FOREIGN KEY (`id_partie`) REFERENCES `partie` (`id_partie`);

--
-- Contraintes pour la table `centrale_joueur`
--
ALTER TABLE `centrale_joueur`
  ADD CONSTRAINT `centrale_joueur_ibfk_1` FOREIGN KEY (`id_partie`) REFERENCES `partie` (`id_partie`),
  ADD CONSTRAINT `centrale_joueur_ibfk_2` FOREIGN KEY (`id_centrale`) REFERENCES `caracteristique_centrale` (`id_centrale`),
  ADD CONSTRAINT `centrale_joueur_ibfk_3` FOREIGN KEY (`id_ressource`) REFERENCES `ressource_joueur` (`id_ressource`);

--
-- Contraintes pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD CONSTRAINT `contrat_ibfk_1` FOREIGN KEY (`id_ressource`) REFERENCES `ressource_joueur` (`id_ressource`),
  ADD CONSTRAINT `contrat_ibfk_2` FOREIGN KEY (`id_acceptant`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `contrat_ibfk_3` FOREIGN KEY (`id_emeteur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `mine_joueur`
--
ALTER TABLE `mine_joueur`
  ADD CONSTRAINT `mine_joueur_ibfk_1` FOREIGN KEY (`id_mine`) REFERENCES `caracteristique_mine` (`id_mine`),
  ADD CONSTRAINT `mine_joueur_ibfk_2` FOREIGN KEY (`id_partie`) REFERENCES `partie` (`id_partie`),
  ADD CONSTRAINT `mine_joueur_ibfk_3` FOREIGN KEY (`id_ressource`) REFERENCES `ressource_joueur` (`id_ressource`);

--
-- Contraintes pour la table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `partie_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
