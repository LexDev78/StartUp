-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 05 juin 2022 à 04:08
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestiondetransport`
--

-- --------------------------------------------------------

--
-- Structure de la table `camions`
--

DROP TABLE IF EXISTS `camions`;
CREATE TABLE IF NOT EXISTS `camions` (
  `idCamion` int NOT NULL AUTO_INCREMENT,
  `chauffeurCamion` varchar(100) NOT NULL,
  `proprietaireCamion` varchar(100) NOT NULL,
  `trajetCamion` varchar(100) NOT NULL,
  PRIMARY KEY (`idCamion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `chargementducamion`
--

DROP TABLE IF EXISTS `chargementducamion`;
CREATE TABLE IF NOT EXISTS `chargementducamion` (
  `idDuChargement` int NOT NULL AUTO_INCREMENT,
  `idCamion` int NOT NULL,
  `lieuDuChargement` varchar(100) NOT NULL,
  `dateDuChargement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fraisDuChargement` int NOT NULL,
  PRIMARY KEY (`idDuChargement`),
  KEY `idDuCamion` (`idCamion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `idClient` int NOT NULL AUTO_INCREMENT,
  `nomClient` varchar(100) NOT NULL,
  `prenomClient` varchar(100) NOT NULL,
  `villeClient` varchar(100) NOT NULL,
  `adresseClient` varchar(100) NOT NULL,
  `genreClient` char(1) NOT NULL,
  `telephoneClient` varchar(100) NOT NULL,
  PRIMARY KEY (`idClient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dechargementducamion`
--

DROP TABLE IF EXISTS `dechargementducamion`;
CREATE TABLE IF NOT EXISTS `dechargementducamion` (
  `idDuDechargement` int NOT NULL AUTO_INCREMENT,
  `idCamion` int NOT NULL,
  `lieuDuDechargement` varchar(100) NOT NULL,
  `dateDuDechargement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fraisDuDechargement` int NOT NULL,
  PRIMARY KEY (`idDuDechargement`),
  KEY `idDuCamion` (`idCamion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `magazins`
--

DROP TABLE IF EXISTS `magazins`;
CREATE TABLE IF NOT EXISTS `magazins` (
  `idMagazin` int NOT NULL AUTO_INCREMENT,
  `localiteMagazin` varchar(100) NOT NULL,
  `numeroMagazin` varchar(100) NOT NULL,
  `chefMagazin` varchar(100) NOT NULL,
  `proprietaireMagazin` varchar(100) NOT NULL,
  PRIMARY KEY (`idMagazin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `marchandises`
--

DROP TABLE IF EXISTS `marchandises`;
CREATE TABLE IF NOT EXISTS `marchandises` (
  `idMarchandise` int NOT NULL AUTO_INCREMENT,
  `idClient` int NOT NULL,
  `stockMarchandise` int NOT NULL,
  `prixMarchandise` int NOT NULL,
  PRIMARY KEY (`idMarchandise`),
  KEY `idDuClient` (`idClient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stocker`
--

DROP TABLE IF EXISTS `stocker`;
CREATE TABLE IF NOT EXISTS `stocker` (
  `idStock` int NOT NULL AUTO_INCREMENT,
  `idMarchandise` int NOT NULL,
  `idMagazin` int NOT NULL,
  `dateStockage` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantiteDuStock` int NOT NULL,
  PRIMARY KEY (`idStock`),
  KEY `idDeLaMarchandise` (`idMarchandise`),
  KEY `idDuMagazin` (`idMagazin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `transporter`
--

DROP TABLE IF EXISTS `transporter`;
CREATE TABLE IF NOT EXISTS `transporter` (
  `idDuTransport` int NOT NULL AUTO_INCREMENT,
  `idMarchandise` int NOT NULL,
  `idCamion` int NOT NULL,
  `dateDeTransport` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idDuTransport`),
  KEY `idDeLaMarchandise` (`idMarchandise`),
  KEY `idDuCamion` (`idCamion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `voyage`
--

DROP TABLE IF EXISTS `voyage`;
CREATE TABLE IF NOT EXISTS `voyage` (
  `idDuVoyage` int NOT NULL AUTO_INCREMENT,
  `idCamion` int NOT NULL,
  `codeDuVoyage` varchar(100) NOT NULL,
  PRIMARY KEY (`idDuVoyage`),
  KEY `idDuCamion` (`idCamion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chargementducamion`
--
ALTER TABLE `chargementducamion`
  ADD CONSTRAINT `chargementducamion_ibfk_1` FOREIGN KEY (`idCamion`) REFERENCES `camions` (`idCamion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dechargementducamion`
--
ALTER TABLE `dechargementducamion`
  ADD CONSTRAINT `dechargementducamion_ibfk_1` FOREIGN KEY (`idCamion`) REFERENCES `camions` (`idCamion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `marchandises`
--
ALTER TABLE `marchandises`
  ADD CONSTRAINT `marchandises_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `clients` (`idClient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stocker`
--
ALTER TABLE `stocker`
  ADD CONSTRAINT `stocker_ibfk_1` FOREIGN KEY (`idMarchandise`) REFERENCES `marchandises` (`idMarchandise`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stocker_ibfk_2` FOREIGN KEY (`idMagazin`) REFERENCES `magazins` (`idMagazin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `transporter`
--
ALTER TABLE `transporter`
  ADD CONSTRAINT `transporter_ibfk_1` FOREIGN KEY (`idMarchandise`) REFERENCES `marchandises` (`idMarchandise`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transporter_ibfk_2` FOREIGN KEY (`idCamion`) REFERENCES `camions` (`idCamion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `voyage`
--
ALTER TABLE `voyage`
  ADD CONSTRAINT `voyage_ibfk_1` FOREIGN KEY (`idCamion`) REFERENCES `camions` (`idCamion`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
