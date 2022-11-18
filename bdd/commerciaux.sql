-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 27 mai 2022 à 14:30
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
-- Base de données : `portail_massoutre`
--

-- --------------------------------------------------------

--
-- Structure de la table `commerciaux`
--

DROP TABLE IF EXISTS `commerciaux`;
CREATE TABLE IF NOT EXISTS `commerciaux` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom_complet` varchar(255) NOT NULL,
  `adresse_mail` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commerciaux`
--

INSERT INTO `commerciaux` (`ID`, `nom_complet`, `adresse_mail`) VALUES
(1, 'Hasna Rossignol', 'hasna.rossignol@massoutre-locations.com'),
(2, 'sylvie derriennic', 'sylvie.derriennic@massoutre-locations.com'),
(3, 'marine prevost', 'marine.prevost@massoutre-locations.com'),
(4, 'Jean Michel Lassaigne', 'jeanmichel.lassaigne@massoutre-locations.com'),
(5, 'Marion Fontez', 'marion.fontez@massoutre-locations.com'),
(6, 'Benoit Montanier', 'benoit.montanier@massoutre-locations.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
