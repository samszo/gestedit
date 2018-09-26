-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 10 juil. 2018 à 05:15
-- Version du serveur :  8.0.11
-- Version de PHP :  7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET SQL_SAFE_UPDATES = 0;
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


-- correction isbn
-- supprimer les identifiant de livre obsolète
DELETE FROM iste_isbn 
WHERE
    id_livre IN (SELECT 
        *
    FROM
        (SELECT DISTINCT
            i.id_livre
        FROM
            iste_isbn i
        LEFT JOIN iste_livre l ON i.id_livre = l.id_livre
        
        WHERE
            l.id_livre IS NULL) AS p);

-- modifie les types isbn
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =10;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =11;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =13;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =15;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =18;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =30;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =31;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =33;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =34;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =35;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =36;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =37;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =78;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =80;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =126;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =127;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =128;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =131;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =133;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =134;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =136;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =140;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =142;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =143;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =145;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =148;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =149;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =151;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =152;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =153;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =154;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =156;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =157;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =161;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =162;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =169;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =192;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =217;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =221;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =257;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =259;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =263;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =283;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =286;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =288;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =289;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =290;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =291;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =292;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =293;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =294;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =296;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =297;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =299;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =300;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =301;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =317;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =342;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =344;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =417;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =433;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =440;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =442;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =527;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =536;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =674;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =677;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =682;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =734;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =778;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =781;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =782;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =784;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =808;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =826;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1216;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1217;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1222;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1223;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1225;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1227;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1228;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1229;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1230;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1231;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1232;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1233;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1234;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1235;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1236;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1237;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1240;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1241;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1242;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1243;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1244;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1246;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1247;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1248;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1249;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1250;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1251;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1252;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1253;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1254;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1255;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1256;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1257;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1259;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1260;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1261;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1262;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1263;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1264;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1265;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1266;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1267;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1268;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1269;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1271;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1272;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1273;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1277;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1278;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1279;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1280;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1281;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1282;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1283;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1284;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1285;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1287;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1288;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1289;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1290;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1291;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1292;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1293;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1296;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1297;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1298;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1299;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1300;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1301;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1302;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1303;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1304;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1308;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1309;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1310;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1311;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1313;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1314;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1315;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1316;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1318;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1319;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1320;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1321;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1322;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1323;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1324;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1325;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1326;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1327;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1328;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1329;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1330;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1331;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1332;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1333;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1339;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1340;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1341;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1342;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1343;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1344;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1345;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1346;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1348;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1349;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1351;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1352;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1353;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1354;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1356;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1357;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1358;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1359;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1360;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1361;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1362;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1363;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1364;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1365;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1366;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1367;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1368;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1369;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1371;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1372;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1373;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1375;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1376;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1377;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1378;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1379;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1380;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1381;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1382;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1383;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1384;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1386;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1387;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1388;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1391;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1392;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1393;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1394;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1395;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1396;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1397;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1398;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1400;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1401;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1404;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1405;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1406;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1407;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1408;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1409;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1410;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1412;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1413;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1416;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1417;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1419;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1420;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1421;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1422;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1423;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1424;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1426;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1427;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1428;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1430;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1431;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1432;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1433;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1434;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1435;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1436;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1437;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1438;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1441;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1442;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1444;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1446;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1447;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1448;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1449;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1450;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1451;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1452;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1453;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1454;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1455;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1456;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1457;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1458;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1459;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1460;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1461;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1462;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1463;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1464;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1466;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1467;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1468;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1469;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1470;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1471;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1472;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1473;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1474;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1475;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1476;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1477;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1478;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1479;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1480;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1481;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1482;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1484;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1485;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1486;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1487;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1489;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1490;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1494;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1495;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1499;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1501;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1502;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1503;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1505;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1507;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1508;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1509;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1510;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1511;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1512;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1514;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1515;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1516;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1517;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1518;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1519;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1520;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1521;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1523;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1524;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1525;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1526;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1527;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1528;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1529;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1530;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1531;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1532;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1533;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1534;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1535;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1537;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1538;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1539;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1540;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1542;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1543;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1544;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1545;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1548;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1549;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1551;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1552;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1553;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1554;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1556;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1557;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1558;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1559;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1562;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1563;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1564;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1565;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1569;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1570;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1572;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1573;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1574;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1575;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1576;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1579;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1580;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1582;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1583;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1584;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1585;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1587;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1588;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1589;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1591;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1592;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1595;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1596;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1599;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1603;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1605;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1606;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1607;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1609;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1610;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1615;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1617;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1621;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1622;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1623;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1628;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1630;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1631;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1632;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1633;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1634;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1638;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1639;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1642;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1643;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1646;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1647;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1648;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1652;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1655;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1656;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1658;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1659;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1662;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1663;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1664;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1665;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1667;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1668;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1671;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1672;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1674;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1678;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1684;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1685;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1691;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1693;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1696;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1698;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1699;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1701;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1703;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1706;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1710;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1711;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1712;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1723;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1724;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1725;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1726;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1727;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1730;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1731;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1732;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1734;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1736;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1738;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1740;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1741;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1749;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1755;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1756;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1758;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1759;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1760;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1761;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1762;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1763;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1767;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1768;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1770;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1773;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1775;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1776;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1780;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1781;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1784;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1785;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1790;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1791;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1792;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1793;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1795;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1841;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1864;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1916;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1918;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1919;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1920;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1921;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1922;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1923;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1924;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1926;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1927;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1928;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1929;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1930;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1931;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1933;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1934;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1935;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1936;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1937;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1938;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1940;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1941;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1943;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1944;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1945;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1948;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1949;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1950;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1951;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1952;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1953;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1954;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1955;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1956;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1957;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1958;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1959;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1960;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1961;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1962;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1963;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1964;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1966;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1967;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1968;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1969;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1970;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1971;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1986;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1991;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1994;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =1999;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2005;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2009;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2011;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2012;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2022;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2023;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2025;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2028;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2032;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2033;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2035;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2036;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2040;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2042;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2045;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2071;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =2072;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4012;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4013;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4014;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4015;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4017;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4018;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4019;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4022;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4337;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4937;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4938;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4939;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4940;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4941;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4942;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4943;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4944;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4945;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4946;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4947;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4948;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4949;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4950;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4951;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4954;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4955;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4956;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4958;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4959;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4962;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4965;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4967;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4968;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4971;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4975;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4976;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4977;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4978;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4979;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4980;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4981;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4982;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4986;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4988;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4992;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4993;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4996;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =4998;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5000;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5001;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5002;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5003;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5008;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5013;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5015;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5020;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5021;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5025;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5026;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5030;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5033;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5035;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5040;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5041;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5043;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5047;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5051;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5052;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5054;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5057;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5059;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5066;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5069;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5072;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5073;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5076;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5078;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5081;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5082;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5083;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5084;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5085;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5086;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5087;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5088;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5089;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5105;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5108;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5111;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5120;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5121;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5124;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5126;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5129;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5133;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5134;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5136;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5137;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5138;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5139;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5140;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5141;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5143;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5151;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5153;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5154;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5155;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5160;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5161;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5162;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5163;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5164;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5171;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5172;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5175;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5176;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5179;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5180;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5187;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5190;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5195;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5203;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5208;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5209;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5215;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5216;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5218;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5219;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5220;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5221;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5223;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5226;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5230;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5233;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5235;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5237;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5238;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5239;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5779;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5823;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5856;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5857;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5877;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5878;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5879;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5881;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5882;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5883;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5884;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5885;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =5895;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6018;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6020;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6049;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6050;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6051;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6052;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6053;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6054;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6056;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6058;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6059;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6091;
UPDATE iste_isbn set type ='Hardback EN' WHERE id_isbn =6191;
UPDATE iste_isbn set type ='Ouvrage papier fr' WHERE id_isbn =5387;

UPDATE iste_isbn set type ='E-Book FR' WHERE type='Ebook FR';
UPDATE iste_isbn set type ='Papier FR' WHERE type='Ouvrage papier fr';

-- gestion des type ISBN dans les contrats
ALTER TABLE `iste_auteurxcontrat` ADD `type_isbn` VARCHAR(20) AFTER `id_comite`;

UPDATE `iste_param` SET `nom` = 'Papier FR' WHERE `iste_param`.`id_param` = 44;

ALTER TABLE `iste_isbn` CHANGE `id_licence` `id_licence` INT(11) NULL;

-- executer les corrections d'ISBN
-- http://localhost/gestedit/admin/calculer/corrections

# Disable Foreign Keys Check
SET FOREIGN_KEY_CHECKS = 1;
SET SQL_SAFE_UPDATES = 1;

COMMIT;
