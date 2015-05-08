-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 06 Mai 2015 à 14:21
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

--
-- Contenu de la table `iste_auteur`
--

INSERT INTO `iste_auteur` (`id_auteur`, `id_institution`, `civilite`, `nom`, `prenom`, `isni`, `adresse`, `ville`, `code_postal`, `pays`, `telephone`, `mail`, `url`) VALUES
(1, NULL, 'Mr', 'szoniecky', 'Samuel Alexandre Jean', NULL, 'Route de Lessard', 'Le Mesnil Simon', '14140', '', '', '', ''),
(2, NULL, NULL, 'semiosis', 'lucky', NULL, 'Bois de Bretonne', 'Le Mesnil Simon', '14140', '', '+33662438756', 'luckysemiosis@free.fr', '');

--
-- Contenu de la table `iste_chapitre`
--

INSERT INTO `iste_chapitre` (`id_chapitre`, `id_livre`, `id_traducteur`, `num`, `titre_fr`, `titre_en`, `resume_fr`, `resume_en`) VALUES
(2, 2, 0, 223, 'jlskd', ' è§çb', 'sldjl pao\nmqsk m^k àç@é"\nir) à"é', 'euz\nkljslkjfs'),
(3, 2, 0, 1234, 'sdsfs', 'sfsdf', 'fsqqsdf\nsdf fd dsf\n qsdf \n', 'dfqsd f\n sdfsqdf \nqsdf'),
(4, 2, 0, 123, 'azeaze', 'azeazeaze', 'dazefozeijf zedjpzeoj', 'podzepk oazejfpozek');

--
-- Contenu de la table `iste_collection`
--

INSERT INTO `iste_collection` (`id_collection`, `titre_fr`, `titre_en`) VALUES
(1, '', 'Optimization in Insurance and Finance'),
(2, 'SmartGrids de nouvelle génération', 'Advanced SmartGrids'),
(3, 'Approche locale de la fracture', 'Local Approach to Fracture'),
(4, 'Ingénierie des biosystèmes: de la cellule au procédé', 'Biosystems Engineering'),
(5, 'Lasers de nouvelle génération', 'Advanced Lasers – A Advanced Structures');

--
-- Contenu de la table `iste_comite`
--

INSERT INTO `iste_comite` (`id_comite`, `titre_fr`, `titre_en`, `soustitre_fr`, `soustitre_en`) VALUES
(1, '', 'Mathematics and Statistics', NULL, NULL),
(2, '', 'Electrical Engineering', NULL, NULL),
(3, '', 'Materials Science', NULL, NULL),
(4, '', 'Chemical Engineering', NULL, NULL),
(5, '', 'Waves', NULL, NULL),
(6, '', 'Earth System – Environmental Sciences', NULL, NULL),
(7, '', 'Nanoscience and Nanotechnology', NULL, NULL),
(8, '', 'Computer Engineering', NULL, NULL),
(9, '', 'Digital Signal and Image Processing', NULL, NULL),
(10, '', 'Bioengineering and Health Science', NULL, NULL),
(11, '', 'Mechanical Engineering and Solid Mechanics', NULL, NULL),
(12, '', 'Electronics Engineering', NULL, NULL);

--
-- Contenu de la table `iste_comitexauteur`
--

INSERT INTO `iste_comitexauteur` (`id_comite`, `id_auteur`) VALUES
(2, 2),
(3, 2);

--
-- Contenu de la table `iste_comitexlivre`
--

INSERT INTO `iste_comitexlivre` (`id_comite`, `id_livre`) VALUES
(7, 1);

--
-- Contenu de la table `iste_coordination`
--

INSERT INTO `iste_coordination` (`id_collection`, `id_auteur`, `prime`) VALUES
(1, 2, '0.000');

--
-- Contenu de la table `iste_editeur`
--

INSERT INTO `iste_editeur` (`id_editeur`, `nom`) VALUES
(1, 'ISTE Editions'),
(2, 'ISTE International'),
(3, 'ISTE Press'),
(4, 'Elsevier'),
(5, 'Wiley');

--
-- Contenu de la table `iste_isbn`
--

INSERT INTO `iste_isbn` (`id_isbn`, `id_livre`, `id_editeur`, `id_licence`, `num`, `tirage`, `nb_page`, `cout_total`, `cout_page`, `prix_catalogue`, `devise`, `date_parution`, `type`) VALUES
(1, 1, 2, 0, 1234, 0, 0, NULL, NULL, NULL, NULL, '2015-05-29', NULL),
(2, 2, 3, 0, 123456, 0, 32, NULL, NULL, NULL, NULL, '2015-05-29', NULL),
(3, 2, 4, 0, 125678, 0, 33, NULL, NULL, NULL, NULL, '2015-07-18', NULL);

--
-- Contenu de la table `iste_livre`
--

INSERT INTO `iste_livre` (`id_livre`, `reference`, `titre_fr`, `titre_en`, `num_vol`, `type_1`, `type_2`, `soustitre_fr`, `soustitre_en`) VALUES
(1, 1234, 'encore un ebeau titre', 'vraiment très beau ça', 0, 'Author', 'Focus', '', ''),
(2, 345, 'encore un fait ça', 'encore', 123, 'Author', 'Focus', 'redf', '''edf'),
(8, 34567, 'ezfef erzazer', '&"é"é&'' &é"&é''(''(éè''(èç', 0, 'Author', 'Set', '', '');

--
-- Contenu de la table `iste_livrexauteur`
--

INSERT INTO `iste_livrexauteur` (`id_livrexauteur`, `id_livre`, `id_auteur`, `role`) VALUES
(1, 1, 1, 'auteur'),
(3, 1, 2, 'auteur'),
(4, 1, 2, 'coordinateur'),
(5, 2, 2, 'auteur');

--
-- Contenu de la table `iste_livrexcollection`
--

INSERT INTO `iste_livrexcollection` (`id_livre`, `id_collection`) VALUES
(1, 1),
(1, 4);

--
-- Contenu de la table `iste_livrexserie`
--

INSERT INTO `iste_livrexserie` (`id_livre`, `id_serie`) VALUES
(1, 2);

--
-- Contenu de la table `iste_prevision`
--

INSERT INTO `iste_prevision` (`id_prevision`, `id_tache`, `id_pxu`, `obj`, `commentaire`, `debut`, `prevision`, `fin`, `alerte`) VALUES
(1, 1, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(2, 2, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(3, 3, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(4, 4, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(5, 5, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(6, 6, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(7, 7, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(8, 8, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(9, 9, 1, 'livre', NULL, NULL, NULL, NULL, NULL),
(10, 1, 2, 'livre', 'éoizae ea!è§', '2015-05-29', '2015-05-22', '2015-05-21', NULL),
(11, 2, 2, 'livre', 'àç!à hiuh', '2015-05-16', NULL, NULL, NULL),
(12, 3, 2, 'livre', NULL, NULL, NULL, NULL, NULL),
(13, 4, 2, 'livre', NULL, NULL, NULL, NULL, NULL),
(14, 5, 2, 'livre', 'ré éç!§"', NULL, NULL, '2015-05-28', NULL),
(15, 6, 2, 'livre', NULL, NULL, NULL, NULL, NULL),
(16, 7, 2, 'livre', NULL, NULL, NULL, NULL, NULL),
(17, 8, 2, 'livre', NULL, NULL, NULL, NULL, NULL),
(18, 9, 2, 'livre', NULL, NULL, NULL, NULL, NULL),
(19, 10, 2, 'chapitre', NULL, NULL, NULL, '2015-05-14', NULL),
(20, 11, 2, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(21, 12, 2, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(22, 13, 2, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(23, 14, 2, 'chapitre', NULL, NULL, NULL, '2015-05-21', NULL),
(24, 10, 4, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(25, 11, 4, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(26, 12, 4, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(27, 13, 4, 'chapitre', NULL, NULL, NULL, '2015-05-22', NULL),
(28, 14, 4, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(29, 10, 6, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(30, 11, 6, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(31, 12, 6, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(32, 13, 6, 'chapitre', NULL, NULL, NULL, NULL, NULL),
(33, 14, 6, 'chapitre', NULL, NULL, NULL, NULL, NULL);

--
-- Contenu de la table `iste_processus`
--

INSERT INTO `iste_processus` (`id_processus`, `nom`) VALUES
(1, 'Traduction livre'),
(2, 'Traduction chapitre');

--
-- Contenu de la table `iste_processusxchapitre`
--

INSERT INTO `iste_processusxchapitre` (`id_pcu`, `id_chapitre`, `id_uti`, `id_processus`, `date_creation`, `commentaire`) VALUES
(1, 2, 1, 0, '2015-05-05 14:48:14', ''),
(2, 2, 1, 2, '2015-05-05 14:48:14', ''),
(3, 3, 1, 0, '2015-05-05 21:38:54', ''),
(4, 3, 1, 2, '2015-05-05 21:38:54', ''),
(5, 4, 1, 0, '2015-05-06 09:24:00', ''),
(6, 4, 1, 2, '2015-05-06 09:24:00', '');

--
-- Contenu de la table `iste_processusxlivre`
--

INSERT INTO `iste_processusxlivre` (`id_plu`, `id_livre`, `id_uti`, `id_processus`, `date_creation`, `commentaire`) VALUES
(1, 1, 1, 1, '2015-05-05 14:41:00', ''),
(2, 2, 1, 1, '2015-05-05 14:43:12', '');

--
-- Contenu de la table `iste_proposition`
--

INSERT INTO `iste_proposition` (`id_proposition`, `id_livre`, `date_debut`, `date_contrat`, `base_contrat`, `date_manuscrit`, `langue`, `traduction`, `publication_fr`, `publication_en`, `nb_page`) VALUES
(1, 1, '2015-04-30', '2015-06-19', 'anglais', '2015-05-22', 'français', 'anglais', 1, 0, 0),
(2, 2, '2015-04-30', '2015-05-14', 'anglais', '2015-05-20', 'anglais', 'français', 1, 1, 0),
(3, 3, '2015-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, '2015-05-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, '2015-05-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, '2015-05-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, '2015-05-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, '2015-05-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Contenu de la table `iste_serie`
--

INSERT INTO `iste_serie` (`id_serie`, `titre_fr`, `titre_en`) VALUES
(1, '', 'Mathematics and Statistics'),
(2, '', 'Electrical Engineering'),
(3, '', 'Materials Science'),
(4, '', 'Chemical Engineering'),
(5, '', 'Waves'),
(6, '', 'Earth System – Environmental Sciences'),
(7, '', 'Nanoscience and Nanotechnology'),
(8, '', 'Computer Engineering'),
(9, '', 'Digital Signal and Image Processing'),
(10, '', 'Bioengineering and Health Science'),
(11, '', 'Mechanical Engineering and Solid Mechanics'),
(12, '', 'Electronics Engineering');

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
(14, 2, 'deadline', 5);

--
-- Contenu de la table `iste_uti`
--

INSERT INTO `iste_uti` (`id_uti`, `nom`, `login`, `mdp`, `role`, `adresse`, `ville`, `code_postal`, `pays`, `telephone`, `mail`, `url`) VALUES
(1, 'Szoniecky', 'samszo', 'samszo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'lucky', 'lucky', 'samszo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
