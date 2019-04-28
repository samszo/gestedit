-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  Dim 28 avr. 2019 à 14:26
-- Version du serveur :  8.0.12
-- Version de PHP :  7.2.11

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
CREATE TABLE `iste_etab` (
  `id_etab` int(11) NOT NULL,
  `affiliation1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `affiliation2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `affiliation3` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `url_labo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `responsable` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `adresse` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ville_cp` varchar(75) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_nomenclature`
--

DROP TABLE IF EXISTS `iste_nomenclature`;
CREATE TABLE `iste_nomenclature` (
  `id_nomenclature` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `label_parent` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Structure de la table `iste_prospect`
--

DROP TABLE IF EXISTS `iste_prospect`;
CREATE TABLE `iste_prospect` (
  `id_prospect` int(11) NOT NULL,
  `nom_prenom` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `email2` varchar(45) DEFAULT NULL,
  `origine` varchar(75) NOT NULL,
  `clientIste` varchar(15) DEFAULT NULL,
  `membreEdito` varchar(15) DEFAULT NULL,
  `unsub` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0',
  `maj` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prospectxetab`
--

DROP TABLE IF EXISTS `iste_prospectxetab`;
CREATE TABLE `iste_prospectxetab` (
  `id_prospect` int(11) NOT NULL,
  `id_etab` int(11) NOT NULL,
  `maj` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prospectxexport`
--

DROP TABLE IF EXISTS `iste_prospectxexport`;
CREATE TABLE `iste_prospectxexport` (
  `id_prospect` int(11) NOT NULL,
  `id_export` int(11) NOT NULL,
  `maj` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prospectxnomenclature`
--

DROP TABLE IF EXISTS `iste_prospectxnomenclature`;
CREATE TABLE `iste_prospectxnomenclature` (
  `id_prospect` int(11) NOT NULL,
  `id_nomenclature` int(11) NOT NULL,
  `maj` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `iste_etab`
--
ALTER TABLE `iste_etab`
  ADD PRIMARY KEY (`id_etab`);

--
-- Index pour la table `iste_nomenclature`
--
ALTER TABLE `iste_nomenclature`
  ADD PRIMARY KEY (`id_nomenclature`);

--
-- Index pour la table `iste_prospect`
--
ALTER TABLE `iste_prospect`
  ADD PRIMARY KEY (`id_prospect`);

--
-- Index pour la table `iste_prospectxetab`
--
ALTER TABLE `iste_prospectxetab`
  ADD PRIMARY KEY (`id_prospect`,`id_etab`),
  ADD KEY `fk_prospect_has_etablissement_etablissement1_idx` (`id_etab`),
  ADD KEY `fk_prospect_has_etablissement_prospect1_idx` (`id_prospect`);

--
-- Index pour la table `iste_prospectxexport`
--
ALTER TABLE `iste_prospectxexport`
  ADD PRIMARY KEY (`id_export`);

--
-- Index pour la table `iste_prospectxnomenclature`
--
ALTER TABLE `iste_prospectxnomenclature`
  ADD PRIMARY KEY (`id_prospect`,`id_nomenclature`),
  ADD KEY `fk_prospect_has_nomenclature_nomenclature1_idx` (`id_nomenclature`),
  ADD KEY `fk_prospect_has_nomenclature_prospect_idx` (`id_prospect`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `iste_etab`
--
ALTER TABLE `iste_etab`
  MODIFY `id_etab` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `iste_nomenclature`
--
ALTER TABLE `iste_nomenclature`
  MODIFY `id_nomenclature` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT pour la table `iste_prospect`
--
ALTER TABLE `iste_prospect`
  MODIFY `id_prospect` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `iste_prospectxexport`
--
ALTER TABLE `iste_prospectxexport`
  MODIFY `id_export` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
