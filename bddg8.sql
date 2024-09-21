-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 11 déc. 2023 à 19:53
-- Version du serveur : 8.0.35
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bddg8`
--

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `ID` int NOT NULL,
  `numero` int DEFAULT NULL,
  `civilite` varchar(20) DEFAULT NULL,
  `nom_pre` varchar(20) DEFAULT NULL,
  `adresse` varchar(20) DEFAULT NULL,
  `dnaissance` date DEFAULT NULL,
  `Lnaissance` varchar(20) DEFAULT NULL,
  `pays` varchar(20) DEFAULT NULL,
  `grade` varchar(20) DEFAULT NULL,
  `specialite` varchar(20) DEFAULT NULL,
  `na_tiona_lite` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
  `ID` int NOT NULL,
  `code` int DEFAULT NULL,
  `designation` varchar(30) DEFAULT NULL,
  `coefficient` int DEFAULT NULL,
  `volume` float DEFAULT NULL,
  `Filiere` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `moyenne`
--

CREATE TABLE `moyenne` (
  `id_etudient` int NOT NULL,
  `moyenne` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nationality`
--

CREATE TABLE `nationality` (
  `code` int NOT NULL,
  `nom_natio` varchar(40) DEFAULT NULL,
  `libele` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `num_etudient` int DEFAULT NULL,
  `code_module` int DEFAULT NULL,
  `coefficient` int DEFAULT NULL,
  `filiere` varchar(20) DEFAULT NULL,
  `note` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `id` int NOT NULL,
  `Civilité` varchar(20) DEFAULT NULL,
  `Nom_pre` varchar(30) DEFAULT NULL,
  `Adresse` text,
  `cod_post` int DEFAULT NULL,
  `localité` varchar(20) DEFAULT NULL,
  `plat_form` varchar(20) DEFAULT NULL,
  `pays` varchar(20) DEFAULT NULL,
  `application` varchar(20) DEFAULT NULL,
  `natio_nalite` varchar(20) DEFAULT NULL,
  `sport` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` longblob,
  `filiere` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `id_etudient` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `moyenne`
--
ALTER TABLE `moyenne`
  ADD PRIMARY KEY (`id_etudient`);

--
-- Index pour la table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_personne` (`id_etudient`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `code` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_personne` FOREIGN KEY (`id_etudient`) REFERENCES `personne` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
