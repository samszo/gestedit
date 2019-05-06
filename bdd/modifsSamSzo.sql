-- modifs Samszo --

ALTER TABLE `iste_etab` CHANGE `responsableLabo` `responsable` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `iste_etab` CHANGE `affiliation2` `affiliation2` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `affiliation3` `affiliation3` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `adresse` `adresse` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

ALTER TABLE `iste_etab` CHANGE `affiliation1` `affiliation1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `affiliation2` `affiliation2` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `affiliation3` `affiliation3` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `iste_etab` CHANGE `url_labo` `url_labo` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

--modifs Roch--

ALTER TABLE `iste_prospect` CHANGE `unsub` `unsub` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0';

ALTER TABLE `iste_prospectxexport` CHANGE `export_id_export` `id_export` INT(11) NOT NULL;

ALTER TABLE ``iste_prospectxexport`` DROP INDEX ``fk_prospect_has_export_prospect1_idx``;

ALTER TABLE ``iste_prospectxexport`` DROP INDEX ``fk_prospect_has_export_export1_idx``;

ALTER TABLE ``iste_prospectxexport`` DROP PRIMARY KEY;

ALTER TABLE `iste_prospectxexport` ADD PRIMARY KEY( `id_export`);

ALTER TABLE `iste_prospectxexport` CHANGE `maj` `maj` DATETIME(6) NULL DEFAULT NULL;

ALTER TABLE `iste_prospectxexport` ADD `nom` VARCHAR(255) NOT NULL AFTER `id_export`;

ALTER TABLE `iste_prospect` ADD `langue` VARCHAR(70) NOT NULL AFTER `email2`, ADD `pays` VARCHAR(70) NOT NULL AFTER `langue`;

ALTER TABLE `iste_etab` ADD `langue` VARCHAR(70) NOT NULL AFTER `pays`;

