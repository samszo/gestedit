ALTER TABLE `iste_rapport` ADD `ajout_somme` VARCHAR(255) NULL AFTER `montant`, ADD `ajout_commentaire` VARCHAR(255) NULL AFTER `ajout_somme`;

ALTER TABLE `iste_histomodif` CHANGE `id_obj` `id_obj` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `iste_rapport` ADD `montant_ht` DECIMAL(10,2) NULL AFTER `montant`;
ALTER TABLE `iste_rapport` ADD `montant_euro` DECIMAL(10,2) NULL AFTER `montant_ht`;
