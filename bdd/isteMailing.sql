-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 11 mars 2019 à 13:20
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gestedit`
--

-- --------------------------------------------------------

--
-- Structure de la table `iste_etab`
--

DROP TABLE IF EXISTS `iste_etab`;
CREATE TABLE IF NOT EXISTS `iste_etab` (
  `id_etab` int(11) NOT NULL AUTO_INCREMENT,
  `url_labo_etab` varchar(45) DEFAULT NULL,
  `ville_etab` varchar(45) DEFAULT NULL,
  `cp_etab` int(11) DEFAULT NULL,
  `pays_etab` varchar(45) DEFAULT NULL,
  `responsableLabo_etab` tinyint(4) DEFAULT NULL,
  `affiliation1_etab` varchar(45) DEFAULT NULL,
  `affiliation2_etab` varchar(45) DEFAULT NULL,
  `origine_etab` varchar(45) DEFAULT NULL,
  `adresse_etab` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_etab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_nomenclature`
--

DROP TABLE IF EXISTS `iste_nomenclature`;
CREATE TABLE IF NOT EXISTS `iste_nomenclature` (
  `id_nomenclature` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `id_parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_nomenclature`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `iste_nomenclature`
--

INSERT INTO `iste_nomenclature` (`id_nomenclature`, `code`, `label`, `id_parent`) VALUES
(1, '481', 'Acoustique et son', 110),
(2, '410', 'Agronomie, agriculture', 2),
(3, '421', 'Apprentissage, fouille de données, Big Data', 76),
(4, '580', 'Archéologie', 136),
(5, '572', 'Architecture, urbanisme, aménagement', 136),
(6, '330', 'Arts et sciences', 6),
(7, '511', 'Astrophysique', 157),
(8, '422', 'Automates, logique et jeux', 76),
(9, '221', 'Automatique', 66),
(10, '110', 'Bibliothèques', 10),
(11, '381', 'Biochimie et biogéochimie', 28),
(12, '532', 'Bioéthique', 15),
(13, '531', 'Bioinformatique', 15),
(14, '441', 'Bioinformatique', 76),
(15, '520', 'Biologie', 15),
(16, '529', 'Biologie animale', 15),
(17, '522', 'Biologie cellulaire', 15),
(18, '527', 'Biologie intégrative et Neurosciences', 15),
(19, '523', 'Biologie moléculaire', 15),
(20, '530', 'Biologie végétale', 15),
(21, '243', 'Biomatériaux', 125),
(22, '489', 'Biophysique', 110),
(23, '521', 'Biotechnologie, biologie de synthèse', 15),
(24, '560', 'Business, finance et management', 24),
(25, '423', 'Calcul scientifique, algorithmique', 76),
(26, '250', 'Caractérisation', 125),
(27, '389', 'Catalyse', 28),
(28, '380', 'Chimie', 28),
(29, '388', 'Chimie des matériaux', 28),
(30, '386', 'Chimie des substances naturelles', 28),
(31, '384', 'Chimie et sciences du vivant', 28),
(32, '382', 'Chimie inorganique', 28),
(33, '383', 'Chimie organique', 28),
(34, '385', 'Chimie radicalaire, physique', 28),
(35, '387', 'Chimie théorique et calculs', 28),
(36, '453', 'Climat et atmosphère', 46),
(37, '571', 'Communication, organisation, multimédia', 136),
(38, '249', 'Comportement mécanique', 125),
(39, '244', 'Composites', 125),
(40, '242', 'Couches minces, surfaces et interfaces', 125),
(41, '430', 'Cryptographie, sécurité des données', 76),
(42, '424', 'Décision et recherche opérationnelle', 76),
(43, '584', 'Démographie', 136),
(44, '561', 'Droit', 24),
(45, '588', 'Droit des données, du numérique, des connaissances', 136),
(46, '450', 'Ecologie et environnement', 46),
(47, '545', 'Economie de la santé', 130),
(48, '562', 'Economie et développement durables', 24),
(49, '483', 'Electromagnétisme, métamatériaux', 110),
(50, '180', 'Electronique', 50),
(51, '271', 'Eléments finis / Méthodes numériques', 67),
(52, '200', 'Energie', 52),
(53, '203', 'Energie nucléaire', 52),
(54, '202', 'Energies fossiles', 52),
(55, '201', 'Energies renouvelables', 52),
(56, '563', 'Entrepreunariat, gestion et marketing-management', 24),
(57, '582', 'Epistémologie', 136),
(58, '589', 'Ethique des sciences et des technologies', 136),
(59, '533', 'Evolution', 15),
(60, '223', 'Fiabilité, diagnostic, sécurité, maintenance des systèmes', 66),
(61, '564', 'Finance', 24),
(62, '524', 'Génétique, génomique', 15),
(63, '140', 'Génie civil et construction', 63),
(64, '340', 'Génie des procédés', 64),
(65, '160', 'Génie électrique', 65),
(66, '220', 'Génie industriel', 66),
(67, '270', 'Génie mécanique', 67),
(68, '245', 'Géomatériaux', 125),
(69, '275', 'Géomécanique', 67),
(70, '460', 'Géosciences', 70),
(71, '390', 'Hétérochimie', 28),
(72, '578', 'Histoire des STM', 136),
(73, '576', 'Humanités digitales', 136),
(74, '451', 'Hydrologie et eau', 46),
(75, '525', 'Immunologie, relation hôte pathogène, infections', 15),
(76, '420', 'Informatique', 76),
(77, '431', 'Informatique industrielle', 76),
(78, '432', 'Informatique médicale', 76),
(79, '433', 'Informatique quantique', 76),
(80, '541', 'Ingénierie de la santé', 130),
(81, '566', 'Innovation', 24),
(82, '546', 'Innovation en santé', 130),
(83, '544', 'Instrumentation médicale et bio-médicale', 130),
(84, '484', 'Instrumentation, capteurs, signal et mesures', 110),
(85, '425', 'Intelligence artificielle', 76),
(86, '426', 'Internet, web', 76),
(87, '577', 'Langues enseignement', 136),
(88, '434', 'Linguistique', 76),
(89, '435', 'Machines, architecture et systèmes d’exploitation', 76),
(90, '587', 'Management des connaissances scientifiques', 136),
(91, '247', 'Matériaux autres', 125),
(92, '248', 'Matériaux métalliques', 125),
(93, '350', 'Mathématiques et statistiques', 93),
(94, '485', 'Matière condensée', 110),
(95, '206', 'Matières premières et matériaux pour l’énergie', 52),
(96, '273', 'Mécanique des fluides', 67),
(97, '272', 'Mécanique des solides et des structures', 67),
(98, '276', 'Mécanique du vivant', 67),
(99, '274', 'Mécanique industrielle', 67),
(100, '526', 'Microbiologie et virologie', 15),
(101, '436', 'Multimédia', 76),
(102, '300', 'Nanotechnologies', 102),
(103, '452', 'Océanographie et paleoocéanographie', 46),
(104, '542', 'Oncologie, cancer', 130),
(105, '534', 'Pharmacologie, toxicologie', 15),
(106, '586', 'Philosophie', 136),
(107, '487', 'Photonique, optique et lasers', 110),
(108, '535', 'Physiologie', 15),
(109, '482', 'Physique des particules', 110),
(110, '480', 'Physique et ondes', 110),
(111, '488', 'Physique molle', 110),
(112, '391', 'Phytochimie', 28),
(113, '246', 'Polymères', 125),
(114, '251', 'Procédés', 125),
(115, '224', 'Production industrielle / Logistique', 66),
(116, '427', 'Programmation, logiciels, théorie des automates', 76),
(117, '241', 'Propriétés et traitement des matériaux', 125),
(118, '585', 'Psychologie', 136),
(119, '437', 'Puces / architecture, conception, programmation', 76),
(120, '321', 'Réseaux', 121),
(121, '320', 'Réseaux et télécoms', 121),
(122, '567', 'Ressources humaines', 24),
(123, '226', 'Robotique', 66),
(124, '400', 'Science des aliments', 124),
(125, '240', 'Science des matériaux', 125),
(126, '100', 'Science et Technologie STM  Général', 126),
(127, '392', 'Sciences analytiques chimiques', 28),
(128, '583', 'Sciences cognitives', 136),
(129, '579', 'Sciences de l’éducation et formation', 136),
(130, '540', 'Sciences de la santé', 130),
(131, '581', 'Sciences du langage,TAL', 136),
(132, '101', 'Sciences du vivant Général', 132),
(133, '548', 'Sciences médicales', 130),
(134, '547', 'Sciences pharmaceutiques', 130),
(135, '590', 'Sciences politiques', 136),
(136, '570', 'SHS', 136),
(137, '102', 'SHS Général', 102),
(138, '543', "SI et traitement de l'information pour la santé", 130),
(139, '428', 'SI, traitement données, communication', 76),
(140, '573', 'SIG et géographie', 136),
(141, '574', 'Sociologie et anthropologie', 136),
(142, '470', 'Spatiologie', 142),
(143, '360', 'Statistiques', 143),
(144, '204', "Stockage et distribution de l'énergie", 52),
(145, '536', 'Systématique, taxonomie', 15),
(146, '428', "Systèmes d'information, traitement données, communication", 76),
(147, '225', 'Systèmes homme-machine', 66),
(148, '393', 'Techniques d’analyses chimiques', 28),
(149, '322', 'Télécoms / Antennes', 121),
(150, '438', 'Temps réels, lang.s synchrones, info. embatquée', 76),
(151, '205', 'Thermodynamique et physique de l’énergie', 52),
(152, '440', 'Trait. des connaissances et des sentiments', 76),
(153, '429', 'Traitement de l’image', 76),
(154, '440', 'Traitement des connaissances et des sentiments', 76),
(155, '486', 'Traitement du signal', 110),
(156, '575', 'Transport', 136),
(157, '510', 'Univers', 157),
(158, '528', 'Vieillissement, maladies génétiques', 15),
(159, '439', 'Vision artificielle, reconnaissance des formes', 76),
(160, '537', 'Xénobilogie, astrobiologie, origines de la vie', 15);

-- --------------------------------------------------------

--
-- Structure de la table `iste_prospect`
--

DROP TABLE IF EXISTS `iste_prospect`;
CREATE TABLE IF NOT EXISTS `iste_prospect` (
  `id_prospect` int(11) NOT NULL AUTO_INCREMENT,
  `nom_prenom` varchar(45) DEFAULT NULL,
  `langue_prospect` varchar(45) DEFAULT NULL,
  `email_prospect` varchar(45) DEFAULT NULL,
  `email2_prospect` varchar(45) DEFAULT NULL,
  `clientIste_prospect` varchar(45) DEFAULT NULL,
  `membreEdito_prospect` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_prospect`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prospectxetab`
--

DROP TABLE IF EXISTS `iste_prospectxetab`;
CREATE TABLE IF NOT EXISTS `iste_prospectxetab` (
  `id_prospect` int(11) NOT NULL,
  `id_etab` int(11) NOT NULL,
  `maj` datetime DEFAULT NULL,
  PRIMARY KEY (`id_prospect`,`id_etab`),
  KEY `fk_prospect_has_etablissement_etablissement1_idx` (`id_etab`),
  KEY `fk_prospect_has_etablissement_prospect1_idx` (`id_prospect`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prospectxexport`
--

DROP TABLE IF EXISTS `iste_prospectxexport`;
CREATE TABLE IF NOT EXISTS `iste_prospectxexport` (
  `id_prospect` int(11) NOT NULL,
  `export_id_export` int(11) NOT NULL,
  `maj` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_prospect`,`export_id_export`),
  KEY `fk_prospect_has_export_export1_idx` (`export_id_export`),
  KEY `fk_prospect_has_export_prospect1_idx` (`id_prospect`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prospectxnomenclature`
--

DROP TABLE IF EXISTS `iste_prospectxnomenclature`;
CREATE TABLE IF NOT EXISTS `iste_prospectxnomenclature` (
  `id_prospect` int(11) NOT NULL,
  `id_nomenclature` int(11) NOT NULL,
  `maj` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_prospect`,`id_nomenclature`),
  KEY `fk_prospect_has_nomenclature_nomenclature1_idx` (`id_nomenclature`),
  KEY `fk_prospect_has_nomenclature_prospect_idx` (`id_prospect`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
