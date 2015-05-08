-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 07 Mai 2015 à 11:46
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `iste`
--

-- --------------------------------------------------------

--
-- Structure de la table `iste_auteur`
--

DROP TABLE IF EXISTS `iste_auteur`;
CREATE TABLE IF NOT EXISTS `iste_auteur` (
`id_auteur` int(11) NOT NULL,
  `id_institution` int(11) DEFAULT NULL,
  `civilite` varchar(45) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `isni` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `code_postal` varchar(45) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_auteurxchapitre`
--

DROP TABLE IF EXISTS `iste_auteurxchapitre`;
CREATE TABLE IF NOT EXISTS `iste_auteurxchapitre` (
  `id_auteur` int(11) NOT NULL,
  `id_chapitre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_auteurxcontrat`
--

DROP TABLE IF EXISTS `iste_auteurxcontrat`;
CREATE TABLE IF NOT EXISTS `iste_auteurxcontrat` (
  `id_auteur` int(11) NOT NULL,
  `id_contrat` int(11) NOT NULL,
  `date_signature` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_chapitre`
--

DROP TABLE IF EXISTS `iste_chapitre`;
CREATE TABLE IF NOT EXISTS `iste_chapitre` (
`id_chapitre` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `id_traducteur` int(11) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  `resume_fr` text,
  `resume_en` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_collection`
--

DROP TABLE IF EXISTS `iste_collection`;
CREATE TABLE IF NOT EXISTS `iste_collection` (
`id_collection` int(11) NOT NULL,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_comite`
--

DROP TABLE IF EXISTS `iste_comite`;
CREATE TABLE IF NOT EXISTS `iste_comite` (
`id_comite` int(11) NOT NULL,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  `soustitre_fr` varchar(255) DEFAULT NULL,
  `soustitre_en` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_comitexauteur`
--

DROP TABLE IF EXISTS `iste_comitexauteur`;
CREATE TABLE IF NOT EXISTS `iste_comitexauteur` (
  `id_comite` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_comitexlivre`
--

DROP TABLE IF EXISTS `iste_comitexlivre`;
CREATE TABLE IF NOT EXISTS `iste_comitexlivre` (
  `id_comite` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_contrat`
--

DROP TABLE IF EXISTS `iste_contrat`;
CREATE TABLE IF NOT EXISTS `iste_contrat` (
`id_contrat` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_coordination`
--

DROP TABLE IF EXISTS `iste_coordination`;
CREATE TABLE IF NOT EXISTS `iste_coordination` (
  `id_collection` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `prime` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_devises`
--

DROP TABLE IF EXISTS `iste_devises`;
CREATE TABLE IF NOT EXISTS `iste_devises` (
`id_devise` int(11) NOT NULL,
  `date_taux` varchar(45) DEFAULT NULL,
  `taux_euro_livre` decimal(6,3) DEFAULT NULL,
  `taux_livre_euro` decimal(6,3) DEFAULT NULL,
  `taux_dollar_livre` decimal(6,3) DEFAULT NULL,
  `taux_livre_dollar` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_editeur`
--

DROP TABLE IF EXISTS `iste_editeur`;
CREATE TABLE IF NOT EXISTS `iste_editeur` (
`id_editeur` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `iste_editeur`
--

INSERT INTO `iste_editeur` (`id_editeur`, `nom`) VALUES
(1, 'ISTE Editions'),
(2, 'ISTE International'),
(3, 'ISTE Press'),
(4, 'Elsevier'),
(5, 'Wiley');

-- --------------------------------------------------------

--
-- Structure de la table `iste_institution`
--

DROP TABLE IF EXISTS `iste_institution`;
CREATE TABLE IF NOT EXISTS `iste_institution` (
`id_institution` int(11) NOT NULL,
  `id_coordonnee` int(11) DEFAULT NULL,
  `id_parent` varchar(45) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_isbn`
--

DROP TABLE IF EXISTS `iste_isbn`;
CREATE TABLE IF NOT EXISTS `iste_isbn` (
`id_isbn` int(11) NOT NULL,
  `id_livre` int(11) DEFAULT NULL,
  `id_editeur` int(11) NOT NULL,
  `id_licence` int(11) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `tirage` int(11) DEFAULT NULL,
  `nb_page` int(11) DEFAULT NULL,
  `cout_total` decimal(6,2) DEFAULT NULL,
  `cout_page` decimal(6,2) DEFAULT NULL,
  `date_parution` date DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_licence`
--

DROP TABLE IF EXISTS `iste_licence`;
CREATE TABLE IF NOT EXISTS `iste_licence` (
`id_licence` int(11) NOT NULL,
  `licence_unitaire` decimal(6,2) DEFAULT NULL,
  `licence_coef` decimal(6,2) DEFAULT NULL,
  `licence_illimite` decimal(6,2) DEFAULT NULL,
  `mutiplicateur` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_livre`
--

DROP TABLE IF EXISTS `iste_livre`;
CREATE TABLE IF NOT EXISTS `iste_livre` (
`id_livre` int(11) NOT NULL,
  `reference` int(11) DEFAULT NULL,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  `num_vol` int(11) DEFAULT NULL,
  `type_1` varchar(45) DEFAULT NULL,
  `type_2` varchar(45) DEFAULT NULL,
  `soustitre_fr` varchar(255) DEFAULT NULL,
  `soustitre_en` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_livrexauteur`
--

DROP TABLE IF EXISTS `iste_livrexauteur`;
CREATE TABLE IF NOT EXISTS `iste_livrexauteur` (
`id_livrexauteur` int(11) NOT NULL,
  `id_livre` int(11) DEFAULT NULL,
  `id_auteur` int(11) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_livrexcollection`
--

DROP TABLE IF EXISTS `iste_livrexcollection`;
CREATE TABLE IF NOT EXISTS `iste_livrexcollection` (
  `id_livre` int(11) NOT NULL,
  `id_collection` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_livrexserie`
--

DROP TABLE IF EXISTS `iste_livrexserie`;
CREATE TABLE IF NOT EXISTS `iste_livrexserie` (
  `id_livre` int(11) NOT NULL,
  `id_serie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prevision`
--

DROP TABLE IF EXISTS `iste_prevision`;
CREATE TABLE IF NOT EXISTS `iste_prevision` (
`id_prevision` int(11) NOT NULL,
  `id_tache` int(11) NOT NULL,
  `id_pxu` int(11) NOT NULL,
  `obj` varchar(45) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `debut` date DEFAULT NULL,
  `prevision` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `alerte` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_prix`
--

DROP TABLE IF EXISTS `iste_prix`;
CREATE TABLE IF NOT EXISTS `iste_prix` (
`id_prix` int(11) NOT NULL,
  `id_isbn` int(11) NOT NULL,
  `pdf` int(11) DEFAULT NULL,
  `prix_dollar` decimal(6,2) DEFAULT NULL,
  `prix_euro` decimal(6,2) DEFAULT NULL,
  `prix_livre` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_processus`
--

DROP TABLE IF EXISTS `iste_processus`;
CREATE TABLE IF NOT EXISTS `iste_processus` (
`id_processus` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `iste_processus`
--

INSERT INTO `iste_processus` (`id_processus`, `nom`) VALUES
(1, 'Traduction livre'),
(2, 'Traduction chapitre'),
(3, 'Production livre');

-- --------------------------------------------------------

--
-- Structure de la table `iste_processusxchapitre`
--

DROP TABLE IF EXISTS `iste_processusxchapitre`;
CREATE TABLE IF NOT EXISTS `iste_processusxchapitre` (
`id_pcu` int(11) NOT NULL,
  `id_chapitre` int(11) NOT NULL,
  `id_uti` int(11) NOT NULL,
  `id_processus` int(11) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `commentaire` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_processusxlivre`
--

DROP TABLE IF EXISTS `iste_processusxlivre`;
CREATE TABLE IF NOT EXISTS `iste_processusxlivre` (
`id_plu` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `id_uti` int(11) NOT NULL,
  `id_processus` int(11) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `commentaire` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_proposition`
--

DROP TABLE IF EXISTS `iste_proposition`;
CREATE TABLE IF NOT EXISTS `iste_proposition` (
`id_proposition` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_contrat` date DEFAULT NULL,
  `base_contrat` varchar(45) DEFAULT NULL,
  `date_manuscrit` date DEFAULT NULL,
  `langue` varchar(45) DEFAULT NULL,
  `traduction` varchar(100) DEFAULT NULL,
  `publication_fr` tinyint(1) DEFAULT NULL,
  `publication_en` tinyint(1) DEFAULT NULL,
  `nb_page` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_royalty`
--

DROP TABLE IF EXISTS `iste_royalty`;
CREATE TABLE IF NOT EXISTS `iste_royalty` (
  `id_royalty` int(11) NOT NULL,
  `id_vente` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `montant_livre` decimal(10,2) DEFAULT NULL,
  `montant_euro` decimal(10,2) DEFAULT NULL,
  `montant_dollar` decimal(10,2) DEFAULT NULL,
  `taxe_taux` decimal(4,2) DEFAULT NULL,
  `taxe_deduction` varchar(45) DEFAULT NULL,
  `pourcentage` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_serie`
--

DROP TABLE IF EXISTS `iste_serie`;
CREATE TABLE IF NOT EXISTS `iste_serie` (
`id_serie` int(11) NOT NULL,
  `titre_fr` varchar(255) DEFAULT NULL,
  `titre_en` varchar(255) DEFAULT NULL,
  `ref_racine` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_tache`
--

DROP TABLE IF EXISTS `iste_tache`;
CREATE TABLE IF NOT EXISTS `iste_tache` (
`id_tache` int(11) NOT NULL,
  `id_processus` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `iste_tache`
--

INSERT INTO `iste_tache` (`id_tache`, `id_processus`, `nom`, `ordre`) VALUES
(1, 1, 'Presentation email', 1),
(2, 1, 'Book schedule', 2),
(3, 1, 'Final email', 3),
(4, 1, 'Figures to redraw?', 4),
(5, 1, '2nd proof checks', 7),
(6, 1, '3rd proof checks', 8),
(7, 1, 'Sent to press', 9),
(8, 1, 'Blurb status', 5),
(9, 1, 'PCN status', 6),
(10, 2, 'MS received', 1),
(11, 2, 'proofs sent to author', 2),
(12, 2, 'acknowledged receipt ?', 3),
(13, 2, 'proofs returned from author', 4),
(14, 2, 'deadline', 5),
(15, 3, 'Réception manuscrit', 1),
(16, 3, 'Réception traduction anglaise', 2),
(17, 3, 'Prévision parution GB', 3),
(18, 3, 'Prévision parution FR', 4);

-- --------------------------------------------------------

--
-- Structure de la table `iste_traducteur`
--

DROP TABLE IF EXISTS `iste_traducteur`;
CREATE TABLE IF NOT EXISTS `iste_traducteur` (
`id_traducteur` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
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
  `traduction` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_traducteurxcomite`
--

DROP TABLE IF EXISTS `iste_traducteurxcomite`;
CREATE TABLE IF NOT EXISTS `iste_traducteurxcomite` (
  `id_traducteur` int(11) NOT NULL,
  `id_comite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_traducteurxcontrat`
--

DROP TABLE IF EXISTS `iste_traducteurxcontrat`;
CREATE TABLE IF NOT EXISTS `iste_traducteurxcontrat` (
  `id_traducteur` int(11) NOT NULL,
  `id_contrat` int(11) NOT NULL,
  `date_signature` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `iste_uti`
--

DROP TABLE IF EXISTS `iste_uti`;
CREATE TABLE IF NOT EXISTS `iste_uti` (
`id_uti` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `mdp` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `code_postal` varchar(45) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `iste_uti`
--

INSERT INTO `iste_uti` (`id_uti`, `nom`, `login`, `mdp`, `role`, `adresse`, `ville`, `code_postal`, `pays`, `telephone`, `mail`, `url`) VALUES
(1, 'importateur', 'import', 'Zappa2015', 'agent', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `iste_vente`
--

DROP TABLE IF EXISTS `iste_vente`;
CREATE TABLE IF NOT EXISTS `iste_vente` (
`id_vente` int(11) NOT NULL,
  `id_isbn` int(11) DEFAULT NULL,
  `id_devise` int(11) DEFAULT NULL,
  `date_vente` date DEFAULT NULL,
  `boutique` varchar(45) DEFAULT NULL,
  `nombre` int(11) DEFAULT NULL,
  `montant_livre` decimal(10,3) DEFAULT NULL,
  `montant_euro` decimal(10,3) DEFAULT NULL,
  `montant_dollar` decimal(10,3) DEFAULT NULL,
  `avec_droit` tinyint(1) DEFAULT NULL,
  `prealable` tinyint(1) DEFAULT NULL,
  `acheteur` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `iste_auteur`
--
ALTER TABLE `iste_auteur`
 ADD PRIMARY KEY (`id_auteur`);

--
-- Index pour la table `iste_auteurxchapitre`
--
ALTER TABLE `iste_auteurxchapitre`
 ADD PRIMARY KEY (`id_auteur`,`id_chapitre`);

--
-- Index pour la table `iste_auteurxcontrat`
--
ALTER TABLE `iste_auteurxcontrat`
 ADD PRIMARY KEY (`id_auteur`,`id_contrat`);

--
-- Index pour la table `iste_chapitre`
--
ALTER TABLE `iste_chapitre`
 ADD PRIMARY KEY (`id_chapitre`);

--
-- Index pour la table `iste_collection`
--
ALTER TABLE `iste_collection`
 ADD PRIMARY KEY (`id_collection`);

--
-- Index pour la table `iste_comite`
--
ALTER TABLE `iste_comite`
 ADD PRIMARY KEY (`id_comite`);

--
-- Index pour la table `iste_comitexauteur`
--
ALTER TABLE `iste_comitexauteur`
 ADD PRIMARY KEY (`id_comite`,`id_auteur`);

--
-- Index pour la table `iste_comitexlivre`
--
ALTER TABLE `iste_comitexlivre`
 ADD PRIMARY KEY (`id_comite`,`id_livre`);

--
-- Index pour la table `iste_contrat`
--
ALTER TABLE `iste_contrat`
 ADD PRIMARY KEY (`id_contrat`);

--
-- Index pour la table `iste_coordination`
--
ALTER TABLE `iste_coordination`
 ADD PRIMARY KEY (`id_collection`,`id_auteur`);

--
-- Index pour la table `iste_devises`
--
ALTER TABLE `iste_devises`
 ADD PRIMARY KEY (`id_devise`);

--
-- Index pour la table `iste_editeur`
--
ALTER TABLE `iste_editeur`
 ADD PRIMARY KEY (`id_editeur`);

--
-- Index pour la table `iste_institution`
--
ALTER TABLE `iste_institution`
 ADD PRIMARY KEY (`id_institution`);

--
-- Index pour la table `iste_isbn`
--
ALTER TABLE `iste_isbn`
 ADD PRIMARY KEY (`id_isbn`);

--
-- Index pour la table `iste_licence`
--
ALTER TABLE `iste_licence`
 ADD PRIMARY KEY (`id_licence`);

--
-- Index pour la table `iste_livre`
--
ALTER TABLE `iste_livre`
 ADD PRIMARY KEY (`id_livre`);

--
-- Index pour la table `iste_livrexauteur`
--
ALTER TABLE `iste_livrexauteur`
 ADD PRIMARY KEY (`id_livrexauteur`);

--
-- Index pour la table `iste_livrexcollection`
--
ALTER TABLE `iste_livrexcollection`
 ADD PRIMARY KEY (`id_livre`,`id_collection`);

--
-- Index pour la table `iste_livrexserie`
--
ALTER TABLE `iste_livrexserie`
 ADD PRIMARY KEY (`id_livre`,`id_serie`);

--
-- Index pour la table `iste_prevision`
--
ALTER TABLE `iste_prevision`
 ADD PRIMARY KEY (`id_prevision`);

--
-- Index pour la table `iste_prix`
--
ALTER TABLE `iste_prix`
 ADD PRIMARY KEY (`id_prix`);

--
-- Index pour la table `iste_processus`
--
ALTER TABLE `iste_processus`
 ADD PRIMARY KEY (`id_processus`);

--
-- Index pour la table `iste_processusxchapitre`
--
ALTER TABLE `iste_processusxchapitre`
 ADD PRIMARY KEY (`id_pcu`);

--
-- Index pour la table `iste_processusxlivre`
--
ALTER TABLE `iste_processusxlivre`
 ADD PRIMARY KEY (`id_plu`);

--
-- Index pour la table `iste_proposition`
--
ALTER TABLE `iste_proposition`
 ADD PRIMARY KEY (`id_proposition`);

--
-- Index pour la table `iste_royalty`
--
ALTER TABLE `iste_royalty`
 ADD PRIMARY KEY (`id_royalty`,`id_vente`,`id_auteur`);

--
-- Index pour la table `iste_serie`
--
ALTER TABLE `iste_serie`
 ADD PRIMARY KEY (`id_serie`);

--
-- Index pour la table `iste_tache`
--
ALTER TABLE `iste_tache`
 ADD PRIMARY KEY (`id_tache`,`id_processus`);

--
-- Index pour la table `iste_traducteur`
--
ALTER TABLE `iste_traducteur`
 ADD PRIMARY KEY (`id_traducteur`);

--
-- Index pour la table `iste_traducteurxcomite`
--
ALTER TABLE `iste_traducteurxcomite`
 ADD PRIMARY KEY (`id_traducteur`,`id_comite`);

--
-- Index pour la table `iste_traducteurxcontrat`
--
ALTER TABLE `iste_traducteurxcontrat`
 ADD PRIMARY KEY (`id_traducteur`,`id_contrat`);

--
-- Index pour la table `iste_uti`
--
ALTER TABLE `iste_uti`
 ADD PRIMARY KEY (`id_uti`);

--
-- Index pour la table `iste_vente`
--
ALTER TABLE `iste_vente`
 ADD PRIMARY KEY (`id_vente`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `iste_auteur`
--
ALTER TABLE `iste_auteur`
MODIFY `id_auteur` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_chapitre`
--
ALTER TABLE `iste_chapitre`
MODIFY `id_chapitre` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_collection`
--
ALTER TABLE `iste_collection`
MODIFY `id_collection` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_comite`
--
ALTER TABLE `iste_comite`
MODIFY `id_comite` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_contrat`
--
ALTER TABLE `iste_contrat`
MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_devises`
--
ALTER TABLE `iste_devises`
MODIFY `id_devise` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_editeur`
--
ALTER TABLE `iste_editeur`
MODIFY `id_editeur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `iste_institution`
--
ALTER TABLE `iste_institution`
MODIFY `id_institution` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_isbn`
--
ALTER TABLE `iste_isbn`
MODIFY `id_isbn` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_licence`
--
ALTER TABLE `iste_licence`
MODIFY `id_licence` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_livre`
--
ALTER TABLE `iste_livre`
MODIFY `id_livre` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_livrexauteur`
--
ALTER TABLE `iste_livrexauteur`
MODIFY `id_livrexauteur` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_prevision`
--
ALTER TABLE `iste_prevision`
MODIFY `id_prevision` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_prix`
--
ALTER TABLE `iste_prix`
MODIFY `id_prix` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_processus`
--
ALTER TABLE `iste_processus`
MODIFY `id_processus` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `iste_processusxchapitre`
--
ALTER TABLE `iste_processusxchapitre`
MODIFY `id_pcu` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_processusxlivre`
--
ALTER TABLE `iste_processusxlivre`
MODIFY `id_plu` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_proposition`
--
ALTER TABLE `iste_proposition`
MODIFY `id_proposition` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_serie`
--
ALTER TABLE `iste_serie`
MODIFY `id_serie` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_tache`
--
ALTER TABLE `iste_tache`
MODIFY `id_tache` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `iste_traducteur`
--
ALTER TABLE `iste_traducteur`
MODIFY `id_traducteur` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `iste_uti`
--
ALTER TABLE `iste_uti`
MODIFY `id_uti` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `iste_vente`
--
ALTER TABLE `iste_vente`
MODIFY `id_vente` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
