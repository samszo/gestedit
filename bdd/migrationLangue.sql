-- ESPAGNOL
ALTER TABLE `iste_collection` ADD `titre_es` VARCHAR(255) NULL AFTER `titre_en`;

ALTER TABLE `iste_comite` ADD `soustitre_es` VARCHAR(255) NULL AFTER `titre_en`;
ALTER TABLE `iste_comite` ADD `titre_es` VARCHAR(255) NULL AFTER `titre_en`;

ALTER TABLE `iste_livre` ADD `bio_es` VARCHAR(255) NULL AFTER `titre_en`;
ALTER TABLE `iste_livre` ADD `tdm_es` VARCHAR(255) NULL AFTER `titre_en`;
ALTER TABLE `iste_livre` ADD `contexte_es` VARCHAR(255) NULL AFTER `titre_en`;
ALTER TABLE `iste_livre` ADD `soustitre_es` VARCHAR(255) NULL AFTER `titre_en`;
ALTER TABLE `iste_livre` ADD `titre_es` VARCHAR(255) NULL AFTER `titre_en`;

-- INSERT INTO `iste_param` (`nom`, `type`) VALUES ('espagnol', 'langues');
INSERT INTO `iste_param` (`nom`, `type`) VALUES ('espagnol -> français', 'traduction');
-- INSERT INTO `iste_param` (`nom`, `type`) VALUES ('espagnol -> anglais', 'traduction');
UPDATE `iste_param` SET `nom` = 'espagnol -> anglais' WHERE `iste_param`.`id_param` = 63;
INSERT INTO `iste_param` (`nom`, `type`) VALUES ('français -> espagnol', 'traduction');
INSERT INTO `iste_param` (`nom`, `type`) VALUES ('anglais -> espagnol', 'traduction');
INSERT INTO `iste_param` (`nom`, `type`) VALUES ('prévu ES', 'page');
INSERT INTO `iste_param` (`nom`, `type`) VALUES ('final ES', 'page');
INSERT INTO `iste_param` (`nom`, `type`) VALUES ('E-Book ES', 'typeISBN');
INSERT INTO `iste_param` (`nom`, `type`) VALUES ('Papier ES', 'typeISBN');

ALTER TABLE `iste_proposition` ADD `publication_es` VARCHAR(255) NULL;
ALTER TABLE `iste_proposition` ADD `nb_page_es` int(11) NULL;

ALTER TABLE `iste_serie` ADD `titre_es` VARCHAR(255) NULL;

--processus projet livre
INSERT INTO `iste_tache` (`id_processus`, `nom`, `ordre`) VALUES ('3', 'Réception traduction ES', '8');
INSERT INTO `iste_tache` (`id_processus`, `nom`, `ordre`) VALUES ('3', 'Parution ES', '9');
--processus production ES
INSERT INTO `iste_processus` (`id_processus`, `nom`) VALUES (7, 'Production ES');
INSERT INTO `iste_tache` (`id_processus`, `nom`, `ordre`) VALUES (7, 'Questionnaire', '1');
INSERT INTO `iste_tache` (`id_processus`, `nom`, `ordre`) VALUES (7, 'validation titre/st', '2');


-- gestion des champs null
ALTER TABLE `iste_livre` CHANGE `production` `production` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `iste_prevision` CHANGE `relance` `relance` DATE NULL;
ALTER TABLE `iste_isbn` CHANGE `id_editeur` `id_editeur` INT(11) NULL;
ALTER TABLE `iste_livrexauteur` CHANGE `ordre` `ordre` INT(11) NULL DEFAULT '1';

/* NOTES

- il y a-t-il un éditeur spécifique pour ES ?
cf. models livre getEtatSuivi l:1225

- faut-il ajouter un planning de production ES ?

*/