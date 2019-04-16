ALTER TABLE `iste_etab` CHANGE `responsableLabo` `responsable` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `iste_etab` CHANGE `affiliation2` `affiliation2` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `affiliation3` `affiliation3` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `adresse` `adresse` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

ALTER TABLE `iste_etab` CHANGE `affiliation1` `affiliation1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `affiliation2` `affiliation2` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `affiliation3` `affiliation3` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `iste_etab` CHANGE `url_labo` `url_labo` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
