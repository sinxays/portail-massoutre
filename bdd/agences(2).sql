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
-- Structure de la table `agences`
--

DROP TABLE IF EXISTS `agences`;
CREATE TABLE IF NOT EXISTS `agences` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom_agence` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'nom de l''agence',
  `ville` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `chef_agence` varchar(255) DEFAULT NULL,
  `num_tel_agence` char(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `cp` int NOT NULL,
  `secteur` int DEFAULT NULL COMMENT '1,"Chartres"\r\n2,"Massy"\r\n3,"Etampes"\r\n4,"Orleans"\r\n5,"Blois"\r\n6,"Montargis"\r\n7,"Auxerre"\r\n8,"Nevers"\r\n9,"Clermont"\r\n10,"Bourges"\r\n11,"Montlucon"\r\n',
  `district` int DEFAULT NULL COMMENT '1,"Chartres"\r\n2,"Rungis"\r\n3,"Orleans"\r\n4,"Sens"\r\n5,"Pole Loire"\r\n',
  `commercial` varchar(255) DEFAULT NULL,
  `mail_agence` varchar(255) DEFAULT NULL,
  `code_district` varchar(255) NOT NULL,
  `code_vp_alpha` varchar(255) DEFAULT NULL,
  `code_vp` int DEFAULT NULL,
  `code_vu_alpha` varchar(255) DEFAULT NULL,
  `code_vu` int DEFAULT NULL,
  `code_gare_alpha` varchar(255) DEFAULT NULL,
  `code_gare` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `agences`
--

INSERT INTO `agences` (`ID`, `nom_agence`, `ville`, `chef_agence`, `num_tel_agence`, `adresse`, `cp`, `secteur`, `district`, `commercial`, `mail_agence`, `code_district`, `code_vp_alpha`, `code_vp`, `code_vu_alpha`, `code_vu`, `code_gare_alpha`, `code_gare`) VALUES
(1, 'ANTONY', 'ANTONY', 'Alexandre Brival', '01 46 66 25 20', '107 AV ARISTIDE BRIAND', 92160, 0, 2, 'SYLVIE', 'bernyal@wanadoo.fr', '8422', 'A7N', 4697, 'A8Q', 50910, NULL, NULL),
(2, 'AUXERRE', 'AUXERRE', 'Agent Kristopher', '03 86 46 83 47', '3 RUE PAUL DAUMER', 89000, 7, 4, 'MARINE', 'auxerre@massoutre-locations.com', '65281', 'AXE', 3956, 'X1G', 50912, 'AI9', 1417),
(3, 'BLOIS', 'BLOIS', 'José Escobar', '02 54 45 10 61', '58-60 AV DE VENDOME', 41000, 5, 3, 'MARINE', 'blois@massoutre-locations.com', '7231', 'AD5', 3967, 'D3H', 50920, 'ZS3', 475),
(4, 'BOURGES', 'BOURGES', 'Elodie RIVET', '02 48 24 38 84', '11 CHEMIN DE LA PRAIRIE', 18000, 10, 5, 'PIERRE', 'bourges@massoutre-locations.com', '65466', 'BGS', 3973, 'BG4', 50289, 'AL7', 1410),
(5, 'MONTARGIS', 'CHALETTE S/LOING / MONTARGIS', 'Brigitte ANDRE', '02 38 85 77 77', '47 AV DU GAL LECLERC', 45120, 6, 3, 'MARINE', 'montargis@massoutre-locations.com', '7231', 'WN4', 2172, 'N4W', 50935, NULL, NULL),
(6, 'CHARTRES', 'CHARTRES', 'Baptiste GOUALIN', '02 37 28 37 37', '9 RUE CHARLES COULOMBS', 28000, 1, 1, 'SYLVIE', 'chartres@massoutre-locations.com', '7191', 'HRT', 3994, 'D3J', 50921, 'NI2', 3683),
(7, 'CHATEAUDUN', 'CHATEAUDUN', 'Agent', '02 37 45 21 21', '24 RUE DU VAL SAINT AIGNAN', 28200, 1, 1, 'SYLVIE', 'renou-auto@wanadoo.fr', '7191', 'CH0', 5979, 'C9J', 50924, NULL, NULL),
(8, 'CHATEAUROUX', 'CHATEAUROUX', 'Agent', '02 54 27 45 46', '60 AV DE LA CHATRE', 36000, 11, 5, 'PIERRE', 'chateauroux@massoutre-locations.com', '65466', 'MP5', 3468, 'D2E', 50352, 'ZS8', 1254),
(9, 'CLERMONT FERRAND', 'CLERMONT FERRAND', 'Laetitia LAURENT', '04 73 25 72 06', '3 RUE BERNARD PALISSY', 63100, 9, 5, 'PIERRE', 'clermont@massoutre-locations.com', '65466', 'RR9', 4164, 'RR0', 50889, NULL, NULL),
(10, 'DREUX', 'DREUX', 'Isabelle DAUDRE', '02 37 46 23 58', '3 RUE DES LIVRAINDIERES', 28100, 0, 1, 'SYLVIE', 'dreux@massoutre-locations.com', '7191', 'DRX', 4011, 'R1J', 50929, 'D6X', 1016),
(11, 'ETAMPES', 'ETAMPES', 'Sandrine Duchet', '01 64 94 17 74', '10 RUE DE LA FERTE ALAIS', 91150, 3, 2, 'SYLVIE', 'etampes@massoutre-locations.com', '7191', 'FC5', 2242, 'C5W', 50930, NULL, NULL),
(12, 'ORLEANS NORD', 'FLEURY LES AUBRAIS', 'Corine POIROT', '02 38 62 27 04', '91 AV ANDRE DESSAUX', 45400, 4, 3, 'MARINE', 'orleans@massoutre-locations.com', '7231', 'OLN', 4081, 'O7M', 50944, NULL, NULL),
(13, 'ISSOUDUN', 'ISSOUDUN', 'Agent', '02 54 03 17 19', 'AV JEAN BONNEFONT', 36100, 11, 5, 'PIERRE', 'jacky.feuillade@wanadoo.fr', '65466', 'I4N', 573, 'IV5', 50354, NULL, NULL),
(14, 'TROYES', 'LA CHAPELLE ST LUC / TROYES', 'Fabrice PATOUILLET', '03 51 48 15 00', '4 RUE BONNETIERES ZI', 10600, 0, 4, 'MARINE', 'troyes@massoutre-locations.com', '65281', 'T2F', 2097, 'T8F', 50989, 'CO6', 3579),
(15, 'MASSY', 'MASSY', 'Laurent CHAPEAU\nKassandra HAMEL', '01 69 30 54 82', '38 AV CARNOT', 91300, 2, 2, 'SYLVIE', 'massy@massoutre-locations.com\nkassandra.hamel@massoutre-locations.com', '8422', NULL, NULL, 'Y9M', 50934, 'MY9', 5827),
(16, 'MONTGERON', 'MONTGERON', 'Agent', '01 46 86 28 95', 'MF LOCATION 2 ROUTE DE CORBEIL', 91230, 0, 2, 'SYLVIE', 'mflocation@wanadoo.fr', '8422', 'PA6', 4104, 'YX8', 50983, NULL, NULL),
(17, 'MONTLUCON', 'MONTLUCON', 'Corinne FAUVEAU', '04 70 05 59 02', '8 AVENUE JULES FERRY', 3100, 11, 5, 'PIERRE', 'montlucon@massoutre-locations.com', '65466', 'MT4', 4061, 'M0U', 50890, 'WM7', 2245),
(18, 'NEVERS', 'NEVERS', 'Christophe Miteran', '03 86 57 51 03', '5 BIS RUE DE LA PASSIERE', 58000, 8, 4, 'MARINE', 'nevers@massoutre-locations.com', '65281', 'NVS', 4074, 'NV0', 50288, 'DY2', 3645),
(19, 'NOGENT LE ROTROU', 'NOGENT LE ROTROU', 'Agent', '02 37 52 78 84', '42 AV DE PARIS - MARGON', 28400, 1, 1, 'SYLVIE', 'sarl-cabaret@wanadoo.fr', '7191', 'N03', 1909, 'N40', 50936, NULL, NULL),
(20, 'PITHIVIERS', 'PITHIVIERS', 'Agent', '02 38 34 57 51', 'AV DU 11 NOVEMBRE ST ELOI BP 323', 45303, 3, 2, 'SYLVIE', 'gatinais.pithiviers.compta@opel.gmfrance.fr', '7191', 'PT0', 5832, 'WX6', 50977, NULL, NULL),
(21, 'GIEN', 'POILLY LES GIEN', 'Agent', '02 38 67 02 13', '44 ROUTE DE SAINT MARTIN', 45500, 6, 3, 'MARINE', 'gien@massoutre-locations.com', '7231', 'GW4', 1979, 'W4J', 50931, NULL, NULL),
(22, 'RAMBOUILLET', 'RAMBOUILLET', 'Marine Bouvard', '01 34 83 35 36', '3 RUE DAGUERRE ZA DU PATIS', 78120, 0, 1, 'SYLVIE', 'rambouillet@massoutre-locations.com', '7191', 'RMB', 4098, 'RM0', 50979, NULL, NULL),
(23, 'ROMORANTIN ', 'ROMORANTIN ', '', '02 54 96 11 30', 'Garage Montauger ZI de la bezardiere , Villefranche sur sere', 0, 5, 3, '', '', '7231', 'R0N', 3774, 'R9Q', 50982, NULL, NULL),
(24, 'RUNGIS HALLES', 'RUNGIS HALLES', 'Elma Baraoumi', '01 46 86 33 00', 'BD CIRCULAIRE FRUILEG 235', 94582, 0, 2, 'SYLVIE', 'rungis.halles@massoutre-locations.com', '8422', 'JB6', 4091, 'JB9', 50985, NULL, NULL),
(25, 'SENS', 'SENS', 'Jean-Fran', '03 86 95 27 29', '186 AV SENIGALIA', 89100, 7, 4, 'MARINE', 'sens@massoutre-locations.com', '65281', 'SES', 4107, 'XE3', 50987, 'CN5', 3540),
(26, 'VENDOME', 'ST OUEN', 'Agent', '02 54 77 27 52', '1 ALLEE DU BOIS DE L ORME', 41100, 5, 3, 'MARINE', 'vendome@massoutre-locations.com', '7231', 'VD6', 5099, 'VY9', 50991, 'VD3', 4014),
(27, 'VIERZON', 'VIERZON', 'Agent', '02 48 71 56 68', 'GARAGE VERDIN 58 AV JEAN JAURES', 18100, 10, 5, 'PIERRE', 'garage.du.verdin@wanadoo.fr', '65466', 'VRZ', 4144, 'V1J', 50329, 'CP1', 3577),
(28, 'VILLEBON', 'VILLEBON S/YVETTE', 'Fabrice LEROUX', '01 69 31 60 00', '7 RUE DU GRAND DOME', 91140, 2, 2, 'SYLVIE', 'lesulis@massoutre-locations.com', '8422', 'NJ5', 3695, 'J5N', 50933, NULL, NULL),
(29, 'MOULINS', 'YZEURE / MOULINS', 'Agent', '04 70 46 58 24', 'GARAGE CHAPOTOT 16 RUE VALERY LARBAUD', 3400, 8, 4, 'MARINE', 'garage.carrosserie@chapotot.com', '65281', 'AH3', 1518, 'Y7D', 54767, 'DA5', 4900),
(30, 'ORLEANS GARE', 'ORLEANS', NULL, '0238622704', 'Gare Sncf, Rue Saint-Yves', 45000, 4, 3, NULL, 'orleans.gare@massoutre-locations.com', '', NULL, NULL, NULL, NULL, 'ZS1', 467),
(31, 'CLERMONT GARE', 'CLERMONT', NULL, '0473917294', 'Gare Parking Rue pierre Semard', 63037, 9, 5, NULL, 'clermont.gare@massoutre-locations.com', '', NULL, NULL, NULL, NULL, 'ZT8', 4042);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
