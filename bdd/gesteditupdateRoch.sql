-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 15 avr. 2019 à 12:38
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
-- Structure de la table `iste_auteur`
--

DROP TABLE IF EXISTS `iste_auteur`;
CREATE TABLE IF NOT EXISTS `iste_auteur` (
  `id_auteur` int(11) NOT NULL AUTO_INCREMENT,
  `id_institution` int(11) DEFAULT NULL,
  `civilite` varchar(45) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `isni` varchar(45) DEFAULT NULL,
  `adresse_1` varchar(255) DEFAULT NULL,
  `adresse_2` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` varchar(45) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `telephone_mobile` varchar(45) DEFAULT NULL,
  `telephone_fixe_bureau` varchar(45) DEFAULT NULL,
  `telephone_fixe_dom` varchar(45) DEFAULT NULL,
  `mail_1` varchar(255) DEFAULT NULL,
  `mail_2` varchar(255) DEFAULT NULL,
  `commentaire` text,
  `taxe_uk` varchar(3) DEFAULT NULL,
  `paiement_euro` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id_auteur`)
) ENGINE=InnoDB AUTO_INCREMENT=3122 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_auteurxchapitre`
--

DROP TABLE IF EXISTS `iste_auteurxchapitre`;
CREATE TABLE IF NOT EXISTS `iste_auteurxchapitre` (
  `id_auteur` int(11) NOT NULL,
  `id_chapitre` int(11) NOT NULL,
  PRIMARY KEY (`id_auteur`,`id_chapitre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_auteurxcontrat`
--

DROP TABLE IF EXISTS `iste_auteurxcontrat`;
CREATE TABLE IF NOT EXISTS `iste_auteurxcontrat` (
  `id_auteurxcontrat` int(11) NOT NULL AUTO_INCREMENT,
  `id_auteur` int(11) NOT NULL,
  `id_contrat` int(11) NOT NULL,
  `id_isbn` int(11) DEFAULT NULL,
  `isbn_auteur` varchar(45) DEFAULT NULL,
  `id_livre` int(11) DEFAULT NULL,
  `id_serie` int(11) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `pc_papier` decimal(6,2) DEFAULT NULL,
  `pc_ebook` decimal(6,2) DEFAULT NULL,
  `pc_trad` decimal(6,2) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `id_comite` int(11) DEFAULT NULL,
  `type_isbn` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_auteurxcontrat`),
  KEY `id_auteur` (`id_auteur`),
  KEY `id_contrat` (`id_contrat`),
  KEY `id_livre` (`id_livre`)
) ENGINE=InnoDB AUTO_INCREMENT=7569 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_boutique`
--

DROP TABLE IF EXISTS `iste_boutique`;
CREATE TABLE IF NOT EXISTS `iste_boutique` (
  `id_boutique` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `coef` decimal(6,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_chapitre`
--

DROP TABLE IF EXISTS `iste_chapitre`;
CREATE TABLE IF NOT EXISTS `iste_chapitre` (
  `id_chapitre` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `id_traducteur` int(11) NOT NULL,
  `num` varchar(255) DEFAULT NULL,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  `resume_fr` text,
  `resume_en` text,
  PRIMARY KEY (`id_chapitre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_collection`
--

DROP TABLE IF EXISTS `iste_collection`;
CREATE TABLE IF NOT EXISTS `iste_collection` (
  `id_collection` int(11) NOT NULL AUTO_INCREMENT,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_collection`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_comite`
--

DROP TABLE IF EXISTS `iste_comite`;
CREATE TABLE IF NOT EXISTS `iste_comite` (
  `id_comite` int(11) NOT NULL AUTO_INCREMENT,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  `soustitre_fr` varchar(255) DEFAULT NULL,
  `soustitre_en` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_comite`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_comitexauteur`
--

DROP TABLE IF EXISTS `iste_comitexauteur`;
CREATE TABLE IF NOT EXISTS `iste_comitexauteur` (
  `id_comite` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  PRIMARY KEY (`id_comite`,`id_auteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_comitexlivre`
--

DROP TABLE IF EXISTS `iste_comitexlivre`;
CREATE TABLE IF NOT EXISTS `iste_comitexlivre` (
  `id_comite` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  PRIMARY KEY (`id_comite`,`id_livre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_contrat`
--

DROP TABLE IF EXISTS `iste_contrat`;
CREATE TABLE IF NOT EXISTS `iste_contrat` (
  `id_contrat` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `param` text NOT NULL,
  PRIMARY KEY (`id_contrat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_coordination`
--

DROP TABLE IF EXISTS `iste_coordination`;
CREATE TABLE IF NOT EXISTS `iste_coordination` (
  `id_coordination` int(11) NOT NULL AUTO_INCREMENT,
  `id_serie` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `prime` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`id_coordination`),
  KEY `id_serie` (`id_serie`),
  KEY `id_auteur` (`id_auteur`)
) ENGINE=InnoDB AUTO_INCREMENT=266 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_devise`
--

DROP TABLE IF EXISTS `iste_devise`;
CREATE TABLE IF NOT EXISTS `iste_devise` (
  `id_devise` int(11) NOT NULL AUTO_INCREMENT,
  `date_taux` date DEFAULT NULL,
  `date_taux_fin` date NOT NULL,
  `taux_euro_livre` decimal(10,4) DEFAULT NULL,
  `taux_livre_euro` decimal(10,4) DEFAULT NULL,
  `taux_dollar_livre` decimal(10,4) DEFAULT NULL,
  `taux_livre_dollar` decimal(10,4) DEFAULT NULL,
  `taux_euro_dollar` decimal(10,4) DEFAULT NULL,
  `taux_dollar_euro` decimal(10,4) DEFAULT NULL,
  `base_contrat` varchar(2) NOT NULL,
  `taxe_taux` decimal(4,2) DEFAULT NULL,
  `taxe_deduction` decimal(4,2) NOT NULL,
  PRIMARY KEY (`id_devise`),
  KEY `base_contrat` (`base_contrat`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_editeur`
--

DROP TABLE IF EXISTS `iste_editeur`;
CREATE TABLE IF NOT EXISTS `iste_editeur` (
  `id_editeur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `base_contrat` varchar(2) NOT NULL,
  PRIMARY KEY (`id_editeur`),
  KEY `base_contrat` (`base_contrat`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_etab`
--

DROP TABLE IF EXISTS `iste_etab`;
CREATE TABLE IF NOT EXISTS `iste_etab` (
  `id_etab` int(11) NOT NULL AUTO_INCREMENT,
  `affiliation1` varchar(45) DEFAULT NULL,
  `url_labo` varchar(45) DEFAULT NULL,
  `responsableLabo` varchar(50) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `cp` varchar(11) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `origine` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_etab`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_export`
--

DROP TABLE IF EXISTS `iste_export`;
CREATE TABLE IF NOT EXISTS `iste_export` (
  `id_export` int(11) NOT NULL AUTO_INCREMENT,
  `date_gen` datetime DEFAULT NULL,
  `criteres` varchar(255) DEFAULT NULL,
  `fichier` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_export`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_histomodif`
--

DROP TABLE IF EXISTS `iste_histomodif`;
CREATE TABLE IF NOT EXISTS `iste_histomodif` (
  `id_histomodif` int(11) NOT NULL AUTO_INCREMENT,
  `id_uti` int(11) NOT NULL,
  `obj` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_obj` int(11) DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `action` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maj` datetime NOT NULL,
  PRIMARY KEY (`id_histomodif`)
) ENGINE=InnoDB AUTO_INCREMENT=60218 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `iste_import`
--

DROP TABLE IF EXISTS `iste_import`;
CREATE TABLE IF NOT EXISTS `iste_import` (
  `id_import` int(11) NOT NULL AUTO_INCREMENT,
  `fichier` varchar(45) DEFAULT NULL,
  `maj` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_import`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_importdata`
--

DROP TABLE IF EXISTS `iste_importdata`;
CREATE TABLE IF NOT EXISTS `iste_importdata` (
  `id_importdata` int(11) NOT NULL AUTO_INCREMENT,
  `id_importfic` int(11) NOT NULL,
  `numsheet` int(11) DEFAULT NULL,
  `numrow` int(11) DEFAULT NULL,
  `col1` text,
  `col2` text,
  `col3` text,
  `col4` text,
  `col5` text,
  `col6` text,
  `col7` text,
  `col8` text,
  `col9` text,
  `col10` text,
  `creation` datetime DEFAULT NULL,
  `id_isbn` int(11) DEFAULT NULL,
  `id_livre` int(11) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `col11` text,
  `col12` text,
  `col13` text,
  `col14` text,
  `col15` text,
  `col16` text,
  `col17` text,
  `col18` text,
  `col19` text,
  `col20` text,
  PRIMARY KEY (`id_importdata`),
  KEY `id_importfic` (`id_importfic`,`numsheet`,`numrow`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_importfic`
--

DROP TABLE IF EXISTS `iste_importfic`;
CREATE TABLE IF NOT EXISTS `iste_importfic` (
  `id_importfic` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `reception` datetime DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `periode_debut` date DEFAULT NULL,
  `periode_fin` date DEFAULT NULL,
  `reference` varchar(45) DEFAULT NULL,
  `coldesc` text,
  `content_type` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `obj` varchar(40) DEFAULT NULL,
  `id_obj` int(11) DEFAULT NULL,
  `conversion_livre_euro` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id_importfic`),
  KEY `obj-id_obj` (`obj`,`id_obj`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4491 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_institution`
--

DROP TABLE IF EXISTS `iste_institution`;
CREATE TABLE IF NOT EXISTS `iste_institution` (
  `id_institution` int(11) NOT NULL AUTO_INCREMENT,
  `id_coordonnee` int(11) DEFAULT NULL,
  `id_parent` varchar(45) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_institution`)
) ENGINE=InnoDB AUTO_INCREMENT=647 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_isbn`
--

DROP TABLE IF EXISTS `iste_isbn`;
CREATE TABLE IF NOT EXISTS `iste_isbn` (
  `id_isbn` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `id_editeur` int(11) NOT NULL,
  `id_licence` int(11) DEFAULT NULL,
  `num` varchar(20) DEFAULT NULL,
  `tirage` int(11) DEFAULT NULL,
  `nb_page` int(11) DEFAULT NULL,
  `date_parution` date DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_isbn`),
  KEY `id_livre` (`id_livre`),
  KEY `ordre` (`ordre`)
) ENGINE=InnoDB AUTO_INCREMENT=8369 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_licence`
--

DROP TABLE IF EXISTS `iste_licence`;
CREATE TABLE IF NOT EXISTS `iste_licence` (
  `id_licence` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `licence_unitaire` decimal(6,2) DEFAULT NULL,
  `licence_coef` decimal(6,2) DEFAULT NULL,
  `licence_illimite` decimal(6,2) DEFAULT NULL,
  `mutiplicateur` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id_licence`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_livre`
--

DROP TABLE IF EXISTS `iste_livre`;
CREATE TABLE IF NOT EXISTS `iste_livre` (
  `id_livre` int(11) NOT NULL AUTO_INCREMENT,
  `reference` int(11) DEFAULT NULL,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  `num_vol` int(11) DEFAULT NULL,
  `type_1` varchar(45) DEFAULT NULL,
  `type_2` varchar(45) DEFAULT NULL,
  `soustitre_fr` varchar(255) DEFAULT NULL,
  `soustitre_en` varchar(255) DEFAULT NULL,
  `contexte_fr` text,
  `contexte_en` text,
  `tdm_fr` text,
  `tdm_en` text,
  `bio_fr` text,
  `bio_en` text,
  `commentaire` text,
  `production` varchar(45) NOT NULL,
  PRIMARY KEY (`id_livre`)
) ENGINE=InnoDB AUTO_INCREMENT=5558 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_livrexauteur`
--

DROP TABLE IF EXISTS `iste_livrexauteur`;
CREATE TABLE IF NOT EXISTS `iste_livrexauteur` (
  `id_livrexauteur` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) DEFAULT NULL,
  `id_auteur` int(11) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`id_livrexauteur`),
  KEY `id_livre` (`id_livre`),
  KEY `id_auteur` (`id_auteur`)
) ENGINE=InnoDB AUTO_INCREMENT=6965 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_livrexcollection`
--

DROP TABLE IF EXISTS `iste_livrexcollection`;
CREATE TABLE IF NOT EXISTS `iste_livrexcollection` (
  `id_livre` int(11) NOT NULL,
  `id_collection` int(11) NOT NULL,
  PRIMARY KEY (`id_livre`,`id_collection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_livrexserie`
--

DROP TABLE IF EXISTS `iste_livrexserie`;
CREATE TABLE IF NOT EXISTS `iste_livrexserie` (
  `id_livreserie` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `id_serie` int(11) NOT NULL,
  PRIMARY KEY (`id_livreserie`),
  KEY `id_livre` (`id_livre`),
  KEY `id_serie` (`id_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=4405 DEFAULT CHARSET=utf8;

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
  `label_parent` varchar(100) NOT NULL,
  PRIMARY KEY (`id_nomenclature`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `iste_nomenclature`
--

INSERT INTO `iste_nomenclature` (`id_nomenclature`, `code`, `label`, `id_parent`, `label_parent`) VALUES
(1, '481', 'Acoustique et son', 110, 'Physique et ondes'),
(2, '410', 'Agronomie, agriculture', 2, 'Agronomie, agriculture'),
(3, '421', 'Apprentissage, fouille de données, Big Data', 76, 'Informatique'),
(4, '580', 'Archéologie', 136, 'SHS'),
(5, '572', 'Architecture, urbanisme, aménagement', 136, 'SHS'),
(6, '330', 'Arts et sciences', 6, 'Arts et sciences'),
(7, '511', 'Astrophysique', 157, 'Univers'),
(8, '422', 'Automates, logique et jeux', 76, 'Informatique'),
(9, '221', 'Automatique', 66, 'Génie industriel'),
(10, '110', 'Bibliothèques', 10, 'Bibliothèques'),
(11, '381', 'Biochimie et biogéochimie', 28, 'Chimie'),
(12, '532', 'Bioéthique', 15, 'Biologie'),
(13, '531', 'Bioinformatique', 15, 'Biologie'),
(14, '441', 'Bioinformatique', 76, 'Informatique'),
(15, '520', 'Biologie', 15, 'Biologie'),
(16, '529', 'Biologie animale', 15, 'Biologie'),
(17, '522', 'Biologie cellulaire', 15, 'Biologie'),
(18, '527', 'Biologie intégrative et Neurosciences', 15, 'Biologie'),
(19, '523', 'Biologie moléculaire', 15, 'Biologie'),
(20, '530', 'Biologie végétale', 15, 'Biologie'),
(21, '243', 'Biomatériaux', 125, 'Science des matériaux'),
(22, '489', 'Biophysique', 110, 'Physique et ondes'),
(23, '521', 'Biotechnologie, biologie de synthèse', 15, 'Biologie'),
(24, '560', 'Business, finance et management', 24, 'Business, finance et management'),
(25, '423', 'Calcul scientifique, algorithmique', 76, 'Informatique'),
(26, '250', 'Caractérisation', 125, 'Science des matériaux'),
(27, '389', 'Catalyse', 28, 'Chimie'),
(28, '380', 'Chimie', 28, 'Chimie'),
(29, '388', 'Chimie des matériaux', 28, 'Chimie'),
(30, '386', 'Chimie des substances naturelles', 28, 'Chimie'),
(31, '384', 'Chimie et sciences du vivant', 28, 'Chimie'),
(32, '382', 'Chimie inorganique', 28, 'Chimie'),
(33, '383', 'Chimie organique', 28, 'Chimie'),
(34, '385', 'Chimie radicalaire, physique', 28, 'Chimie'),
(35, '387', 'Chimie théorique et calculs', 28, 'Chimie'),
(36, '453', 'Climat et atmosphère', 46, 'Ecologie et environnement'),
(37, '571', 'Communication, organisation, multimédia', 136, 'SHS'),
(38, '249', 'Comportement mécanique', 125, 'Science des matériaux'),
(39, '244', 'Composites', 125, 'Science des matériaux'),
(40, '242', 'Couches minces, surfaces et interfaces', 125, 'Science des matériaux'),
(41, '430', 'Cryptographie, sécurité des données', 76, 'Informatique'),
(42, '424', 'Décision et recherche opérationnelle', 76, 'Informatique'),
(43, '584', 'Démographie', 136, 'SHS'),
(44, '561', 'Droit', 24, 'Business, finance et management'),
(45, '588', 'Droit des données, du numérique, des connaissances', 136, 'SHS'),
(46, '450', 'Ecologie et environnement', 46, 'Ecologie et environnement'),
(47, '545', 'Economie de la santé', 130, 'Sciences de la santé'),
(48, '562', 'Economie et développement durables', 24, 'Business, finance et management'),
(49, '483', 'Electromagnétisme, métamatériaux', 110, 'Physique et ondes'),
(50, '180', 'Electronique', 50, 'Electronique'),
(51, '271', 'Eléments finis / Méthodes numériques', 67, 'Génie mécanique'),
(52, '200', 'Energie', 52, 'Energie'),
(53, '203', 'Energie nucléaire', 52, 'Energie'),
(54, '202', 'Energies fossiles', 52, 'Energie'),
(55, '201', 'Energies renouvelables', 52, 'Energie'),
(56, '563', 'Entrepreunariat, gestion et marketing-management', 24, 'Business, finance et management'),
(57, '582', 'Epistémologie', 136, 'SHS'),
(58, '589', 'Ethique des sciences et des technologies', 136, 'SHS'),
(59, '533', 'Evolution', 15, 'Biologie'),
(60, '223', 'Fiabilité, diagnostic, sécurité, maintenance des systèmes', 66, 'Génie industriel'),
(61, '564', 'Finance', 24, 'Business, finance et management'),
(62, '524', 'Génétique, génomique', 15, 'Biologie'),
(63, '140', 'Génie civil et construction', 63, 'Génie civil et construction'),
(64, '340', 'Génie des procédés', 64, 'Génie des procédés'),
(65, '160', 'Génie électrique', 65, 'Génie électrique'),
(66, '220', 'Génie industriel', 66, 'Génie industriel'),
(67, '270', 'Génie mécanique', 67, 'Génie mécanique'),
(68, '245', 'Géomatériaux', 125, 'Science des matériaux'),
(69, '275', 'Géomécanique', 67, 'Génie mécanique'),
(70, '460', 'Géosciences', 70, 'Géosciences'),
(71, '390', 'Hétérochimie', 28, 'Chimie'),
(72, '578', 'Histoire des STM', 136, 'SHS'),
(73, '576', 'Humanités digitales', 136, 'SHS'),
(74, '451', 'Hydrologie et eau', 46, 'Ecologie et environnement'),
(75, '525', 'Immunologie, relation hôte pathogène, infections', 15, 'Biologie'),
(76, '420', 'Informatique', 76, 'Informatique'),
(77, '431', 'Informatique industrielle', 76, 'Informatique'),
(78, '432', 'Informatique médicale', 76, 'Informatique'),
(79, '433', 'Informatique quantique', 76, 'Informatique'),
(80, '541', 'Ingénierie de la santé', 130, 'Sciences de la santé'),
(81, '566', 'Innovation', 24, 'Business, finance et management'),
(82, '546', 'Innovation en santé', 130, 'Sciences de la santé'),
(83, '544', 'Instrumentation médicale et bio-médicale', 130, 'Sciences de la santé'),
(84, '484', 'Instrumentation, capteurs, signal et mesures', 110, 'Physique et ondes'),
(85, '425', 'Intelligence artificielle', 76, 'Informatique'),
(86, '426', 'Internet, web', 76, 'Informatique'),
(87, '577', 'Langues enseignement', 136, 'SHS'),
(88, '434', 'Linguistique', 76, 'Informatique'),
(89, '435', 'Machines, architecture et systèmes d’exploitation', 76, 'Informatique'),
(90, '587', 'Management des connaissances scientifiques', 136, 'SHS'),
(91, '247', 'Matériaux autres', 125, 'Science des matériaux'),
(92, '248', 'Matériaux métalliques', 125, 'Science des matériaux'),
(93, '350', 'Mathématiques et statistiques', 93, 'Mathématiques et statistiques'),
(94, '485', 'Matière condensée', 110, 'Physique et ondes'),
(95, '206', 'Matières premières et matériaux pour l’énergie', 52, 'Energie'),
(96, '273', 'Mécanique des fluides', 67, 'Génie mécanique'),
(97, '272', 'Mécanique des solides et des structures', 67, 'Génie mécanique'),
(98, '276', 'Mécanique du vivant', 67, 'Génie mécanique'),
(99, '274', 'Mécanique industrielle', 67, 'Génie mécanique'),
(100, '526', 'Microbiologie et virologie', 15, 'Biologie'),
(101, '436', 'Multimédia', 76, 'Informatique'),
(102, '300', 'Nanotechnologies', 102, 'Nanotechnologies'),
(103, '452', 'Océanographie et paleoocéanographie', 46, 'Ecologie et environnement'),
(104, '542', 'Oncologie, cancer', 130, 'Sciences de la santé'),
(105, '534', 'Pharmacologie, toxicologie', 15, 'Biologie'),
(106, '586', 'Philosophie', 136, 'SHS'),
(107, '487', 'Photonique, optique et lasers', 110, 'Physique et ondes'),
(108, '535', 'Physiologie', 15, 'Biologie'),
(109, '482', 'Physique des particules', 110, 'Physique et ondes'),
(110, '480', 'Physique et ondes', 110, 'Physique et ondes'),
(111, '488', 'Physique molle', 110, 'Physique et ondes'),
(112, '391', 'Phytochimie', 28, 'Chimie'),
(113, '246', 'Polymères', 125, 'Science des matériaux'),
(114, '251', 'Procédés', 125, 'Science des matériaux'),
(115, '224', 'Production industrielle / Logistique', 66, 'Génie industriel'),
(116, '427', 'Programmation, logiciels, théorie des automates', 76, 'Informatique'),
(117, '241', 'Propriétés et traitement des matériaux', 125, 'Science des matériaux'),
(118, '585', 'Psychologie', 136, 'SHS'),
(119, '437', 'Puces / architecture, conception, programmation', 76, 'Informatique'),
(120, '321', 'Réseaux', 121, 'Réseaux et télécoms'),
(121, '320', 'Réseaux et télécoms', 121, 'Réseaux et télécoms'),
(122, '567', 'Ressources humaines', 24, 'Business, finance et management'),
(123, '226', 'Robotique', 66, 'Génie industriel'),
(124, '400', 'Science des aliments', 124, 'Science des aliments'),
(125, '240', 'Science des matériaux', 125, 'Science des matériaux'),
(126, '100', 'Science et Technologie STM  Général', 126, 'Science et Technologie STM  Général'),
(127, '392', 'Sciences analytiques chimiques', 28, 'Chimie'),
(128, '583', 'Sciences cognitives', 136, 'SHS'),
(129, '579', 'Sciences de l’éducation et formation', 136, 'SHS'),
(130, '540', 'Sciences de la santé', 130, 'Sciences de la santé'),
(131, '581', 'Sciences du langage,TAL', 136, 'SHS'),
(132, '101', 'Sciences du vivant Général', 132, 'Sciences du vivant Général'),
(133, '548', 'Sciences médicales', 130, 'Sciences de la santé'),
(134, '547', 'Sciences pharmaceutiques', 130, 'Sciences de la santé'),
(135, '590', 'Sciences politiques', 136, 'SHS'),
(136, '570', 'SHS', 136, 'SHS'),
(137, '102', 'SHS Général', 137, 'SHS Général'),
(138, '543', 'SI et traitement de l\'information pour la santé', 130, 'Sciences de la santé'),
(139, '428', 'SI, traitement données, communication', 76, 'Informatique'),
(140, '573', 'SIG et géographie', 136, 'SHS'),
(141, '574', 'Sociologie et anthropologie', 136, 'SHS'),
(142, '470', 'Spatiologie', 142, 'Spatiologie'),
(143, '360', 'Statistiques', 143, 'Statistiques'),
(144, '204', 'Stockage et distribution de l\'énergie', 52, 'Energie'),
(145, '536', 'Systématique, taxonomie', 15, 'Biologie'),
(146, '428', 'Systèmes d\'information, traitement données, communication', 76, 'Informatique'),
(147, '225', 'Systèmes homme-machine', 66, 'Génie industriel'),
(148, '393', 'Techniques d’analyses chimiques', 28, 'Chimie'),
(149, '322', 'Télécoms / Antennes', 121, 'Réseaux et télécoms'),
(150, '438', 'Temps réels, lang.s synchrones, info. embatquée', 76, 'Informatique'),
(151, '205', 'Thermodynamique et physique de l’énergie', 52, 'Energie'),
(152, '440', 'Trait. des connaissances et des sentiments', 76, 'Informatique'),
(153, '429', 'Traitement de l’image', 76, 'Informatique'),
(154, '440', 'Traitement des connaissances et des sentiments', 76, 'Informatique'),
(155, '486', 'Traitement du signal', 110, 'Physique et ondes'),
(156, '575', 'Transport', 136, 'SHS'),
(157, '510', 'Univers', 157, 'Univers'),
(158, '528', 'Vieillissement, maladies génétiques', 15, 'Biologie'),
(159, '439', 'Vision artificielle, reconnaissance des formes', 76, 'Informatique'),
(160, '537', 'Xénobilogie, astrobiologie, origines de la vie', 15, 'Biologie');

-- --------------------------------------------------------

--
-- Structure de la table `iste_page`
--

DROP TABLE IF EXISTS `iste_page`;
CREATE TABLE IF NOT EXISTS `iste_page` (
  `id_page` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `nombre` int(11) DEFAULT NULL,
  `maj` datetime DEFAULT NULL,
  PRIMARY KEY (`id_page`),
  KEY `id_livre` (`id_livre`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=5343 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_param`
--

DROP TABLE IF EXISTS `iste_param`;
CREATE TABLE IF NOT EXISTS `iste_param` (
  `id_param` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_param`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_parammail`
--

DROP TABLE IF EXISTS `iste_parammail`;
CREATE TABLE IF NOT EXISTS `iste_parammail` (
  `id_parammail` int(11) NOT NULL AUTO_INCREMENT,
  `champ` varchar(45) NOT NULL,
  `contenu` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_parammail`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prevision`
--

DROP TABLE IF EXISTS `iste_prevision`;
CREATE TABLE IF NOT EXISTS `iste_prevision` (
  `id_prevision` int(11) NOT NULL AUTO_INCREMENT,
  `id_tache` int(11) NOT NULL,
  `id_pxu` int(11) NOT NULL,
  `obj` varchar(45) DEFAULT NULL,
  `commentaire` text,
  `debut` date DEFAULT NULL,
  `prevision` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `alerte` date DEFAULT NULL,
  `relance` date NOT NULL,
  PRIMARY KEY (`id_prevision`),
  KEY `id_tache` (`id_tache`),
  KEY `id_pxu` (`id_pxu`),
  KEY `obj` (`obj`)
) ENGINE=InnoDB AUTO_INCREMENT=140939 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prix`
--

DROP TABLE IF EXISTS `iste_prix`;
CREATE TABLE IF NOT EXISTS `iste_prix` (
  `id_prix` int(11) NOT NULL AUTO_INCREMENT,
  `id_devise` int(11) NOT NULL,
  `id_isbn` int(11) NOT NULL,
  `pdf` int(11) DEFAULT NULL,
  `prix_dollar` decimal(6,2) DEFAULT NULL,
  `prix_euro` decimal(6,2) DEFAULT NULL,
  `prix_livre` decimal(6,2) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `maj` datetime DEFAULT NULL,
  PRIMARY KEY (`id_prix`),
  KEY `id_isbn` (`id_isbn`)
) ENGINE=InnoDB AUTO_INCREMENT=4229 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_processus`
--

DROP TABLE IF EXISTS `iste_processus`;
CREATE TABLE IF NOT EXISTS `iste_processus` (
  `id_processus` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_processus`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_processusxchapitre`
--

DROP TABLE IF EXISTS `iste_processusxchapitre`;
CREATE TABLE IF NOT EXISTS `iste_processusxchapitre` (
  `id_pcu` int(11) NOT NULL AUTO_INCREMENT,
  `id_chapitre` int(11) NOT NULL,
  `id_uti` int(11) NOT NULL,
  `id_processus` int(11) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pcu`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_processusxlivre`
--

DROP TABLE IF EXISTS `iste_processusxlivre`;
CREATE TABLE IF NOT EXISTS `iste_processusxlivre` (
  `id_plu` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `id_uti` int(11) NOT NULL,
  `id_processus` int(11) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_plu`),
  KEY `id_processus-id_livre` (`id_processus`,`id_livre`)
) ENGINE=InnoDB AUTO_INCREMENT=21911 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_proposition`
--

DROP TABLE IF EXISTS `iste_proposition`;
CREATE TABLE IF NOT EXISTS `iste_proposition` (
  `id_proposition` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_contrat` date DEFAULT NULL,
  `base_contrat` varchar(45) DEFAULT NULL,
  `date_manuscrit` date DEFAULT NULL,
  `langue` varchar(45) DEFAULT NULL,
  `traduction` varchar(100) DEFAULT NULL,
  `publication_fr` tinyint(1) DEFAULT NULL,
  `publication_en` tinyint(1) DEFAULT NULL,
  `nb_page_fr` int(11) DEFAULT NULL,
  `nb_page_en` int(11) DEFAULT NULL,
  `commentaire` text,
  PRIMARY KEY (`id_proposition`),
  KEY `id_livre` (`id_livre`)
) ENGINE=InnoDB AUTO_INCREMENT=5565 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prospect`
--

DROP TABLE IF EXISTS `iste_prospect`;
CREATE TABLE IF NOT EXISTS `iste_prospect` (
  `id_prospect` int(11) NOT NULL AUTO_INCREMENT,
  `nom_prenom` varchar(45) DEFAULT NULL,
  `langue` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `email2` varchar(45) DEFAULT NULL,
  `affiliation1` varchar(60) NOT NULL,
  `affiliation2` varchar(60) NOT NULL,
  `affiliation3` varchar(60) NOT NULL,
  `code_nomen1` varchar(4) NOT NULL,
  `code_nomen2` varchar(4) NOT NULL,
  `code_nomen3` varchar(4) NOT NULL,
  `clientIste` varchar(15) DEFAULT NULL,
  `membreEdito` varchar(15) DEFAULT NULL,
  `unsub` varchar(15) DEFAULT NULL,
  `maj` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_prospect`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Structure de la table `iste_rapport`
--

DROP TABLE IF EXISTS `iste_rapport`;
CREATE TABLE IF NOT EXISTS `iste_rapport` (
  `id_rapport` int(11) NOT NULL AUTO_INCREMENT,
  `id_importfic` int(11) NOT NULL,
  `obj_type` varchar(45) DEFAULT NULL,
  `obj_id` varchar(300) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` blob,
  `maj` datetime DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `periode_deb` date DEFAULT NULL,
  `periode_fin` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_rapport`)
) ENGINE=InnoDB AUTO_INCREMENT=25746 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_rib`
--

DROP TABLE IF EXISTS `iste_rib`;
CREATE TABLE IF NOT EXISTS `iste_rib` (
  `id_rib` int(11) NOT NULL AUTO_INCREMENT,
  `id_auteur` int(11) NOT NULL,
  `code_banque` varchar(45) DEFAULT NULL,
  `code_guichet` varchar(45) DEFAULT NULL,
  `code_bic` varchar(45) DEFAULT NULL,
  `num_compte` varchar(45) DEFAULT NULL,
  `clef` varchar(45) DEFAULT NULL,
  `domiciliation` varchar(45) DEFAULT NULL,
  `iban` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_rib`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_royalty`
--

DROP TABLE IF EXISTS `iste_royalty`;
CREATE TABLE IF NOT EXISTS `iste_royalty` (
  `id_royalty` int(11) NOT NULL AUTO_INCREMENT,
  `id_vente` int(11) NOT NULL,
  `id_auteurxcontrat` int(11) NOT NULL,
  `id_devise` int(11) DEFAULT NULL,
  `montant_livre` decimal(10,2) DEFAULT NULL,
  `montant_euro` decimal(10,2) DEFAULT NULL,
  `montant_dollar` decimal(10,2) DEFAULT NULL,
  `taxe_taux` decimal(4,2) DEFAULT NULL,
  `taxe_deduction` decimal(4,2) DEFAULT NULL,
  `pourcentage` decimal(4,2) DEFAULT NULL,
  `date_paiement` date DEFAULT NULL,
  `date_encaissement` date DEFAULT NULL,
  `date_edition` date DEFAULT NULL,
  `id_rapport` int(11) DEFAULT NULL,
  `date_envoi` date DEFAULT NULL,
  `conversion_livre_euro` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id_royalty`),
  KEY `id_vente` (`id_vente`),
  KEY `id_auteurxcontrat` (`id_auteurxcontrat`),
  KEY `id_devise` (`id_devise`),
  KEY `date_paiement` (`date_paiement`),
  KEY `date_edition` (`date_edition`),
  KEY `date_encaissement` (`date_encaissement`),
  KEY `id_rapport` (`id_rapport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_serie`
--

DROP TABLE IF EXISTS `iste_serie`;
CREATE TABLE IF NOT EXISTS `iste_serie` (
  `id_serie` int(11) NOT NULL AUTO_INCREMENT,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  `ref_racine` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=626 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_spip`
--

DROP TABLE IF EXISTS `iste_spip`;
CREATE TABLE IF NOT EXISTS `iste_spip` (
  `id_iste_spip` int(11) NOT NULL AUTO_INCREMENT,
  `id_iste` int(11) DEFAULT NULL,
  `id_spip` int(11) DEFAULT NULL,
  `obj_iste` varchar(45) DEFAULT NULL,
  `obj_spip` varchar(45) DEFAULT NULL,
  `lang` varchar(10) NOT NULL,
  PRIMARY KEY (`id_iste_spip`)
) ENGINE=InnoDB AUTO_INCREMENT=11079 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_tache`
--

DROP TABLE IF EXISTS `iste_tache`;
CREATE TABLE IF NOT EXISTS `iste_tache` (
  `id_tache` int(11) NOT NULL AUTO_INCREMENT,
  `id_processus` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_tache`,`id_processus`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_traducteur`
--

DROP TABLE IF EXISTS `iste_traducteur`;
CREATE TABLE IF NOT EXISTS `iste_traducteur` (
  `id_traducteur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `civilite` varchar(50) NOT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `code_postal` varchar(45) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `nationalite` varchar(45) DEFAULT NULL,
  `background` text,
  `word` tinyint(1) DEFAULT NULL,
  `latex` tinyint(1) DEFAULT NULL,
  `mac` tinyint(1) DEFAULT NULL,
  `traduction` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_traducteur`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_traducteurxcomite`
--

DROP TABLE IF EXISTS `iste_traducteurxcomite`;
CREATE TABLE IF NOT EXISTS `iste_traducteurxcomite` (
  `id_traducteur` int(11) NOT NULL,
  `id_comite` int(11) NOT NULL,
  PRIMARY KEY (`id_traducteur`,`id_comite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_traducteurxcontrat`
--

DROP TABLE IF EXISTS `iste_traducteurxcontrat`;
CREATE TABLE IF NOT EXISTS `iste_traducteurxcontrat` (
  `id_traducteurxcontrat` int(11) NOT NULL AUTO_INCREMENT,
  `id_traducteur` int(11) NOT NULL,
  `id_contrat` int(11) NOT NULL,
  `id_isbn` int(11) DEFAULT NULL,
  `id_livre` int(11) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  PRIMARY KEY (`id_traducteurxcontrat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_uti`
--

DROP TABLE IF EXISTS `iste_uti`;
CREATE TABLE IF NOT EXISTS `iste_uti` (
  `id_uti` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `mdp` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `code_postal` varchar(45) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `telephone_mobile` varchar(45) DEFAULT NULL,
  `telephone_fixe_bureau` varchar(45) DEFAULT NULL,
  `telephone_fixe_dom` varchar(45) DEFAULT NULL,
  `mail_1` varchar(255) DEFAULT NULL,
  `mail_2` varchar(255) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  UNIQUE KEY `id_uti` (`id_uti`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_vente`
--

DROP TABLE IF EXISTS `iste_vente`;
CREATE TABLE IF NOT EXISTS `iste_vente` (
  `id_vente` int(11) NOT NULL AUTO_INCREMENT,
  `id_isbn` int(11) DEFAULT NULL,
  `id_importdata` int(11) DEFAULT NULL,
  `id_licence` int(11) NOT NULL,
  `id_prix` int(11) NOT NULL,
  `id_devise` int(11) DEFAULT NULL,
  `date_vente` date DEFAULT NULL,
  `id_boutique` int(11) DEFAULT NULL,
  `nombre` int(11) DEFAULT NULL,
  `montant_livre` decimal(14,6) DEFAULT NULL,
  `montant_euro` decimal(14,6) DEFAULT NULL,
  `montant_dollar` decimal(14,6) DEFAULT NULL,
  `avec_droit` tinyint(1) DEFAULT NULL,
  `prealable` tinyint(1) DEFAULT NULL,
  `acheteur` varchar(45) DEFAULT NULL,
  `type` varchar(45) NOT NULL,
  `maj` datetime NOT NULL,
  PRIMARY KEY (`id_vente`),
  KEY `id_isbn` (`id_isbn`),
  KEY `id_licence` (`id_licence`),
  KEY `id_boutique` (`id_boutique`) USING BTREE,
  KEY `id_importdata` (`id_importdata`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_web`
--

DROP TABLE IF EXISTS `iste_web`;
CREATE TABLE IF NOT EXISTS `iste_web` (
  `id_web` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `url` varchar(2048) DEFAULT NULL,
  `maj` datetime DEFAULT NULL,
  PRIMARY KEY (`id_web`),
  KEY `id_livre` (`id_livre`)
) ENGINE=InnoDB AUTO_INCREMENT=1463 DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
