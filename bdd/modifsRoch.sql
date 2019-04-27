ALTER TABLE `iste_prospect` CHANGE `unsub` `unsub` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0';

ALTER TABLE `iste_prospectxexport` CHANGE `export_id_export` `id_export` INT(11) NOT NULL;

ALTER TABLE ``iste_prospectxexport`` DROP INDEX ``fk_prospect_has_export_prospect1_idx``;

ALTER TABLE ``iste_prospectxexport`` DROP INDEX ``fk_prospect_has_export_export1_idx``;

ALTER TABLE ``iste_prospectxexport`` DROP PRIMARY KEY;

ALTER TABLE `iste_prospectxexport` ADD PRIMARY KEY( `id_export`);
