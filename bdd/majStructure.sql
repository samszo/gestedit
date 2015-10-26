ALTER TABLE `iste_isbn` ADD `ordre` INT NOT NULL DEFAULT '1' , ADD INDEX (`ordre`) ;

UPDATE `iste`.`iste_processus` SET `nom` = 'Production FR' WHERE `iste_processus`.`id_processus` = 4;