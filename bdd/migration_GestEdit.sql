-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 10 juil. 2018 à 05:15
-- Version du serveur :  8.0.11
-- Version de PHP :  7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `gestedit`
--

-- --------------------------------------------------------

--
-- Structure de la table `iste_contrat`
--

DROP TABLE IF EXISTS `iste_contrat`;
CREATE TABLE `iste_contrat` (
  `id_contrat` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `param` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `iste_contrat`
--

INSERT INTO `iste_contrat` (`id_contrat`, `nom`, `type`, `url`, `param`) VALUES
(1, 'Contrat de resp. série', 'resp. série', NULL, '{\"params\":[{\"nom\":\"Contrat de resp. s\\u00e9rie\",\"id_contrat\":\"1\",\"recid\":2,\"base_contrat\":\"FR\",\"moisDeb\":\"janvier\",\"dateDeb\":\"01\\/01\",\"dateFin\":\"31\\/12\"},{\"nom\":\"Contrat de resp. s\\u00e9rie\",\"id_contrat\":\"1\",\"recid\":3,\"base_contrat\":\"GB\",\"moisDeb\":\"janvier\",\"dateDeb\":\"01\\/01\",\"dateFin\":\"31\\/12\"}]}'),
(2, 'Contrat auteur', 'auteur', NULL, '{\"params\":[{\"nom\":\"Contrat auteur\",\"id_contrat\":\"2\",\"recid\":3,\"base_contrat\":\"FR\",\"moisDeb\":\"janvier\",\"dateDeb\":\"01\\/01\",\"dateFin\":\"31\\/12\"},{\"nom\":\"Contrat auteur\",\"id_contrat\":\"2\",\"recid\":4,\"base_contrat\":\"GB\",\"moisDeb\":\"janvier\",\"dateDeb\":\"01\\/01\",\"dateFin\":\"31\\/12\"}]}'),
(3, 'Contrat directeur', 'directeur', NULL, '{\"params\":[{\"nom\":\"Contrat directeur\",\"id_contrat\":\"3\",\"recid\":4,\"base_contrat\":\"FR\",\"moisDeb\":\"janvier\",\"dateDeb\":\"01\\/01\",\"dateFin\":\"31\\/12\"},{\"nom\":\"Contrat directeur\",\"id_contrat\":\"3\",\"recid\":5,\"base_contrat\":\"GB\",\"moisDeb\":\"janvier\",\"dateDeb\":\"01\\/01\",\"dateFin\":\"31\\/12\"}]}');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `iste_contrat`
--
ALTER TABLE `iste_contrat`
  ADD PRIMARY KEY (`id_contrat`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `iste_contrat`
--
ALTER TABLE `iste_contrat`
  MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `iste_auteurxcontrat` CHANGE `id_isbn` `id_isbn` INT(11) NULL;


ALTER TABLE  `iste_importfic` CHANGE  `obj`  `obj` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
CHANGE  `id_obj`  `id_obj` INT( 11 ) NULL;
ALTER TABLE `iste_importfic` ADD `conversion_livre_euro` DECIMAL(4,2) NULL ;

# Deleted Tables


# Changed Tables


-- changed table `iste_importdata`

ALTER TABLE `iste_importdata`
  CHANGE COLUMN `commentaire` `commentaire` varchar(255)  NULL AFTER `id_livre`,
  CHANGE COLUMN `col11` `col11` text  NULL AFTER `commentaire`,
  CHANGE COLUMN `col12` `col12` text  NULL AFTER `col11`,
  CHANGE COLUMN `col13` `col13` text  NULL AFTER `col12`,
  CHANGE COLUMN `col14` `col14` text  NULL AFTER `col13`,
  CHANGE COLUMN `col15` `col15` text  NULL AFTER `col14`,
  CHANGE COLUMN `col16` `col16` text  NULL AFTER `col15`,
  CHANGE COLUMN `col17` `col17` text  NULL AFTER `col16`,
  CHANGE COLUMN `col18` `col18` text  NULL AFTER `col17`,
  CHANGE COLUMN `col19` `col19` text  NULL AFTER `col18`,
  CHANGE COLUMN `col20` `col20` text  NULL AFTER `col19`;

-- changed table `iste_royalty`

ALTER TABLE `iste_royalty`
  CHANGE COLUMN `date_paiement` `date_paiement` date  NULL AFTER `pourcentage`,
  CHANGE COLUMN `date_encaissement` `date_encaissement` date  NULL AFTER `date_paiement`,
  CHANGE COLUMN `date_edition` `date_edition` date  NULL AFTER `date_encaissement`,
  CHANGE COLUMN `id_rapport` `id_rapport` int(11)  NULL AFTER `date_edition`;
ALTER TABLE `iste_royalty` ADD `conversion_livre_euro` DECIMAL(4,2) NULL ;
ALTER TABLE `iste_royalty` CHANGE `id_devise` `id_devise` INT(11) NULL;

-- changed table 'iste_histomodif'
ALTER TABLE `iste_histomodif` CHANGE `data` `data` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

INSERT INTO `iste_importfic` (`nom`, `reception`, `url`, `type`, `periode_debut`, `periode_fin`, `reference`, `coldesc`, `content_type`, `size`, `obj`, `id_obj`) VALUES
(NULL, NULL, '/data/modeles/droitFR.odt', 'paiement droits FR', NULL, NULL, NULL, NULL, NULL, NULL, '', 0);

ALTER TABLE `iste_rapport` CHANGE `obj_id` `obj_id` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `iste_rapport` ADD `type` VARCHAR(50) NOT NULL AFTER `maj`;

ALTER TABLE `iste_rapport` ADD `periode_deb` DATE NULL AFTER `type`, ADD `periode_fin` DATE NULL AFTER `periode_deb`;

ALTER TABLE `iste_rapport` ADD `montant` DECIMAL(10,2) NULL AFTER `periode_fin`;

# New Tables

--
-- Structure de la table `iste_parammail`
--

DROP TABLE IF EXISTS `iste_parammail`;
CREATE TABLE `iste_parammail` (
  `id_parammail` int(11) NOT NULL,
  `champ` varchar(45) NOT NULL,
  `contenu` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Déchargement des données de la table `iste_parammail`
--

INSERT INTO `iste_parammail` (`id_parammail`, `champ`, `contenu`) VALUES
(48, 'sans_redevance', '%Cher% %Auteur%,\n\nVous trouverez ci-joint votre relevé de droits ISTE Wiley pour la période allant du %periode1% au %periode2%.\n\n \nLe montant étant inférieur à cent euros, celui-ci est automatiquement reporté sur l’année suivante. \n\nNous vous prions d’agréer, %Agreer%, l’expression de nos salutations distinguées.\n\nLe service de comptabilité des Droits d’auteurs.'),
(49, 'avec_redevance', '%Cher% %Auteur%,\n\nVous trouverez ci-joint votre relevé de droits ISTE Wiley pour la période allant du %periode1% au %periode2%.\n \n\nNous vous prions d’agréer, %Agreer%, l’expression de nos salutations distinguées.\n\nLe service de comptabilité des Droits d’auteurs.'),
(50, 'email', 'toumia.amri@gmail.com'),
(51, 'nom', 'Amri'),
(54, 'password', 'password'),
(55, 'sujet', 'Royalties');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `iste_parammail`
--
ALTER TABLE `iste_parammail`
  ADD PRIMARY KEY (`id_parammail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `iste_parammail`
--
ALTER TABLE `iste_parammail`
  MODIFY `id_parammail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;


--
-- Structure de la table `iste_devise`
--

DROP TABLE IF EXISTS `iste_devise`;
CREATE TABLE `iste_devise` (
  `id_devise` int(11) NOT NULL,
  `date_taux` date DEFAULT NULL,
  `date_taux_fin` date NOT NULL,
  `taux_euro_livre` decimal(10,4) DEFAULT NULL,
  `taux_livre_euro` decimal(10,4) DEFAULT NULL,
  `taux_dollar_livre` decimal(10,4) DEFAULT NULL,
  `taux_livre_dollar` decimal(10,4) DEFAULT NULL,
  `taux_euro_dollar` decimal(10,4)  NULL,
  `taux_dollar_euro` decimal(10,4)  NULL,
  `base_contrat` varchar(2) NOT NULL,
  `taxe_taux` decimal(4,2) NULL,
  `taxe_deduction` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `iste_devise`
--

INSERT INTO `iste_devise` (`id_devise`, `date_taux`, `date_taux_fin`, `taux_euro_livre`, `taux_livre_euro`, `taux_dollar_livre`, `taux_livre_dollar`, `taux_euro_dollar`, `taux_dollar_euro`, `base_contrat`, `taxe_taux`, `taxe_deduction`) VALUES
(9, '2018-01-01', '2019-12-31', '0.1000', '0.1000', '0.1000', '0.1000', '0.1000', '0.1000', 'GB', '0.10', '0.10');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `iste_devise`
--
ALTER TABLE `iste_devise`
  ADD PRIMARY KEY (`id_devise`),
  ADD KEY `base_contrat` (`base_contrat`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `iste_devise`
--
ALTER TABLE `iste_devise`
  MODIFY `id_devise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


-- AJOUT nouveau contrat
ALTER TABLE `iste_auteurxcontrat` ADD `pc_trad` DECIMAL(6,2) NULL AFTER `pc_ebook`;
ALTER TABLE `iste_auteurxcontrat` CHANGE `id_comite` `id_comite` INT(11) NULL;

ALTER TABLE `iste_auteur` ADD `taxe_uk` VARCHAR(3) NULL AFTER `commentaire`;
ALTER TABLE `iste_auteur` ADD `paiement_euro` VARCHAR(3) NULL AFTER `taxe_uk`;


# Disable Foreign Keys Check
SET FOREIGN_KEY_CHECKS = 1;

COMMIT;
