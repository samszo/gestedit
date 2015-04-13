-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema iste
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema iste
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `iste` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `iste` ;

-- -----------------------------------------------------
-- Table `iste`.`iste_livre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_livre` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_livre` (
  `id_livre` INT NULL AUTO_INCREMENT,
  `reference` INT NULL,
  `titre_fr` VARCHAR(45) NULL,
  `titre_en` VARCHAR(45) NULL,
  `num_vol` INT NULL,
  `type_1` VARCHAR(45) NULL,
  `type_2` VARCHAR(45) NULL,
  `soustitre_fr` VARCHAR(45) NULL,
  `soustitre_en` VARCHAR(45) NULL,
  PRIMARY KEY (`id_livre`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_contrat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_contrat` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_contrat` (
  `id_contrat` INT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NULL,
  `type` VARCHAR(45) NULL,
  `url` VARCHAR(45) NULL,
  PRIMARY KEY (`id_contrat`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_coordonnee`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_coordonnee` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_coordonnee` (
  `id_coordonnee` INT NOT NULL AUTO_INCREMENT,
  `adresse` VARCHAR(45) NULL,
  `ville` VARCHAR(45) NULL,
  `code_postal` INT NULL,
  `pays` VARCHAR(45) NULL,
  `telephone` VARCHAR(45) NULL,
  `mail` VARCHAR(45) NULL,
  `url` VARCHAR(45) NULL,
  PRIMARY KEY (`id_coordonnee`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_institution`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_institution` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_institution` (
  `id_institution` INT NULL AUTO_INCREMENT,
  `id_coordonnee` INT NULL,
  `id_parent` VARCHAR(45) NULL,
  `nom` VARCHAR(45) NULL,
  PRIMARY KEY (`id_institution`),
  CONSTRAINT `fk_iste_institution_iste_coordonnee1`
    FOREIGN KEY (`id_coordonnee`)
    REFERENCES `iste`.`iste_coordonnee` (`id_coordonnee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_auteur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_auteur` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_auteur` (
  `id_auteur` INT NULL AUTO_INCREMENT,
  `id_institution` INT NULL,
  `id_coordonnee` INT NULL,
  `civilite` VARCHAR(45) NULL,
  `nom` VARCHAR(45) NULL,
  `prenom` VARCHAR(45) NULL,
  `isni` VARCHAR(45) NULL,
  PRIMARY KEY (`id_auteur`),
  CONSTRAINT `fk_iste_auteur_iste_institution`
    FOREIGN KEY (`id_institution`)
    REFERENCES `iste`.`iste_institution` (`id_institution`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_auteur_iste_coordonnee1`
    FOREIGN KEY (`id_coordonnee`)
    REFERENCES `iste`.`iste_coordonnee` (`id_coordonnee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
PACK_KEYS = Default;


-- -----------------------------------------------------
-- Table `iste`.`iste_auteurxcontrat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_auteurxcontrat` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_auteurxcontrat` (
  `id_auteur` INT NOT NULL,
  `id_contrat` INT NOT NULL,
  `date_signature` DATE NULL,
  PRIMARY KEY (`id_auteur`, `id_contrat`),
  CONSTRAINT `fk_iste_auteur_has_iste_contrat_iste_auteur1`
    FOREIGN KEY (`id_auteur`)
    REFERENCES `iste`.`iste_auteur` (`id_auteur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_auteur_has_iste_contrat_iste_contrat1`
    FOREIGN KEY (`id_contrat`)
    REFERENCES `iste`.`iste_contrat` (`id_contrat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_collection`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_collection` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_collection` (
  `id_collection` INT NULL AUTO_INCREMENT,
  `titre_fr` VARCHAR(45) NULL,
  `titre_en` VARCHAR(45) NULL,
  PRIMARY KEY (`id_collection`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_serie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_serie` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_serie` (
  `id_serie` INT NULL AUTO_INCREMENT,
  `titre_fr` VARCHAR(45) NULL,
  `titre_en` VARCHAR(45) NULL,
  PRIMARY KEY (`id_serie`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_proposition`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_proposition` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_proposition` (
  `id_proposition` INT NULL AUTO_INCREMENT,
  `date_debut` DATE NULL,
  `date_contrat` DATE NULL,
  `base_contrat` VARCHAR(45) NULL,
  `date_manuscrit` VARCHAR(45) NULL,
  `langue` VARCHAR(45) NULL,
  `traduction` VARCHAR(45) NULL,
  `publication_fr` TINYINT(1) NULL,
  `publication_en` TINYINT(1) NULL,
  `nb_page` VARCHAR(45) NULL,
  `iste_livre_id_livre` INT NOT NULL,
  PRIMARY KEY (`id_proposition`),
  CONSTRAINT `fk_iste_proposition_iste_livre1`
    FOREIGN KEY (`iste_livre_id_livre`)
    REFERENCES `iste`.`iste_livre` (`id_livre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_processus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_processus` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_processus` (
  `id_processus` INT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NULL,
  PRIMARY KEY (`id_processus`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_tache`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_tache` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_tache` (
  `id_tache` INT NOT NULL AUTO_INCREMENT,
  `id_processus` INT NOT NULL,
  `nom` VARCHAR(45) NULL,
  PRIMARY KEY (`id_tache`, `id_processus`),
  CONSTRAINT `fk_iste_tache_iste_processus1`
    FOREIGN KEY (`id_processus`)
    REFERENCES `iste`.`iste_processus` (`id_processus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_livrexserie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_livrexserie` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_livrexserie` (
  `id_livre` INT NOT NULL,
  `id_serie` INT NOT NULL,
  PRIMARY KEY (`id_livre`, `id_serie`),
  CONSTRAINT `fk_iste_livre_has_iste_set_iste_livre1`
    FOREIGN KEY (`id_livre`)
    REFERENCES `iste`.`iste_livre` (`id_livre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_livre_has_iste_set_iste_set1`
    FOREIGN KEY (`id_serie`)
    REFERENCES `iste`.`iste_serie` (`id_serie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_livrexcollection`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_livrexcollection` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_livrexcollection` (
  `id_livre` INT NOT NULL,
  `id_collection` INT NOT NULL,
  PRIMARY KEY (`id_livre`, `id_collection`),
  CONSTRAINT `fk_iste_livre_has_iste_collection_iste_livre1`
    FOREIGN KEY (`id_livre`)
    REFERENCES `iste`.`iste_livre` (`id_livre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_livre_has_iste_collection_iste_collection1`
    FOREIGN KEY (`id_collection`)
    REFERENCES `iste`.`iste_collection` (`id_collection`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_livrexauteur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_livrexauteur` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_livrexauteur` (
  `id_livre` INT NOT NULL,
  `id_auteur` INT NOT NULL,
  `role` VARCHAR(45) NULL,
  PRIMARY KEY (`id_livre`, `id_auteur`),
  CONSTRAINT `fk_iste_livre_has_iste_auteur_iste_livre1`
    FOREIGN KEY (`id_livre`)
    REFERENCES `iste`.`iste_livre` (`id_livre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_livre_has_iste_auteur_iste_auteur1`
    FOREIGN KEY (`id_auteur`)
    REFERENCES `iste`.`iste_auteur` (`id_auteur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_traducteur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_traducteur` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_traducteur` (
  `id_traducteur` INT NULL AUTO_INCREMENT,
  `id_coordonnee` INT NOT NULL,
  `nom` VARCHAR(45) NULL,
  `prenom` VARCHAR(45) NULL,
  `niveau` VARCHAR(45) NULL,
  PRIMARY KEY (`id_traducteur`),
  CONSTRAINT `fk_iste_traducteur_iste_coordonnee1`
    FOREIGN KEY (`id_coordonnee`)
    REFERENCES `iste`.`iste_coordonnee` (`id_coordonnee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_traducteurxcontrat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_traducteurxcontrat` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_traducteurxcontrat` (
  `id_traducteur` INT NOT NULL,
  `id_contrat` INT NOT NULL,
  `date_signature` DATE NULL,
  PRIMARY KEY (`id_traducteur`, `id_contrat`),
  CONSTRAINT `fk_iste_traducteur_has_iste_contrat_iste_traducteur1`
    FOREIGN KEY (`id_traducteur`)
    REFERENCES `iste`.`iste_traducteur` (`id_traducteur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_traducteur_has_iste_contrat_iste_contrat1`
    FOREIGN KEY (`id_contrat`)
    REFERENCES `iste`.`iste_contrat` (`id_contrat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_uti`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_uti` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_uti` (
  `id_uti` INT NULL AUTO_INCREMENT,
  `id_coordonnee` INT NOT NULL,
  `nom` VARCHAR(45) NULL,
  `login` VARCHAR(45) NULL,
  `mdp` VARCHAR(45) NULL,
  `role` VARCHAR(45) NULL,
  PRIMARY KEY (`id_uti`),
  CONSTRAINT `fk_iste_uti_iste_coordonnee1`
    FOREIGN KEY (`id_coordonnee`)
    REFERENCES `iste`.`iste_coordonnee` (`id_coordonnee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_coordination`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_coordination` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_coordination` (
  `id_collection` INT NOT NULL,
  `id_auteur` INT NOT NULL,
  `prime` INT NULL,
  PRIMARY KEY (`id_collection`, `id_auteur`),
  CONSTRAINT `fk_iste_collection_has_iste_auteur_iste_collection1`
    FOREIGN KEY (`id_collection`)
    REFERENCES `iste`.`iste_collection` (`id_collection`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_collection_has_iste_auteur_iste_auteur1`
    FOREIGN KEY (`id_auteur`)
    REFERENCES `iste`.`iste_auteur` (`id_auteur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_commite`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_commite` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_commite` (
  `id_commite` INT NULL AUTO_INCREMENT,
  `titre_fr` VARCHAR(45) NULL,
  `titre_en` VARCHAR(45) NULL,
  `soustitre_fr` VARCHAR(45) NULL,
  `soustitre_en` VARCHAR(45) NULL,
  PRIMARY KEY (`id_commite`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_commitexauteur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_commitexauteur` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_commitexauteur` (
  `id_commite` INT NOT NULL,
  `id_auteur` INT NOT NULL,
  PRIMARY KEY (`id_commite`, `id_auteur`),
  CONSTRAINT `fk_iste_commite_has_iste_auteur_iste_commite1`
    FOREIGN KEY (`id_commite`)
    REFERENCES `iste`.`iste_commite` (`id_commite`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_commite_has_iste_auteur_iste_auteur1`
    FOREIGN KEY (`id_auteur`)
    REFERENCES `iste`.`iste_auteur` (`id_auteur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_editeur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_editeur` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_editeur` (
  `id_editeur` INT NOT NULL,
  `nom` VARCHAR(45) NULL,
  PRIMARY KEY (`id_editeur`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_licence`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_licence` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_licence` (
  `id_licence` INT NOT NULL AUTO_INCREMENT,
  `licence_unitaire` DECIMAL(6,2) NULL,
  `licence_coef` DECIMAL(6,2) NULL,
  `licence_illimite` DECIMAL(6,2) NULL,
  `mutiplicateur` DECIMAL(4,2) NULL,
  PRIMARY KEY (`id_licence`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_isbn`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_isbn` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_isbn` (
  `id_isbn` INT NULL AUTO_INCREMENT,
  `id_livre` INT NULL,
  `id_editeur` INT NOT NULL,
  `id_licence` INT NOT NULL,
  `num` INT NULL,
  `tirage` INT NULL,
  `nb_page` INT NULL,
  `cout_total` DECIMAL(6,2) NULL,
  `cout_page` DECIMAL(6,2) NULL,
  `prix_catalogue` DECIMAL(6,2) NULL,
  `devise` VARCHAR(45) NULL,
  `date_parution` DATE NULL,
  `type` VARCHAR(45) NULL,
  PRIMARY KEY (`id_isbn`),
  CONSTRAINT `fk_iste_isbn_iste_livre1`
    FOREIGN KEY (`id_livre`)
    REFERENCES `iste`.`iste_livre` (`id_livre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_isbn_iste_editeur1`
    FOREIGN KEY (`id_editeur`)
    REFERENCES `iste`.`iste_editeur` (`id_editeur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_isbn_iste_licence1`
    FOREIGN KEY (`id_licence`)
    REFERENCES `iste`.`iste_licence` (`id_licence`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_prevision`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_prevision` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_prevision` (
  `id_prevision` INT NOT NULL AUTO_INCREMENT,
  `id_tache` INT NOT NULL,
  `commentaire` VARCHAR(255) NULL,
  `debut` DATE NULL,
  `prevision` DATE NULL,
  `fin` DATE NULL,
  `alerte` VARCHAR(45) NULL,
  PRIMARY KEY (`id_prevision`, `id_tache`),
  CONSTRAINT `fk_iste_prevision_iste_tache1`
    FOREIGN KEY (`id_tache`)
    REFERENCES `iste`.`iste_tache` (`id_tache`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_livrexprevision`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_livrexprevision` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_livrexprevision` (
  `id_prevision` INT NOT NULL,
  `id_livre` INT NOT NULL,
  PRIMARY KEY (`id_prevision`, `id_livre`),
  CONSTRAINT `fk_iste_processus_has_iste_prevision_iste_prevision1`
    FOREIGN KEY (`id_prevision`)
    REFERENCES `iste`.`iste_prevision` (`id_prevision`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_processus_prevision_iste_livre1`
    FOREIGN KEY (`id_livre`)
    REFERENCES `iste`.`iste_livre` (`id_livre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_devises`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_devises` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_devises` (
  `id_devise` INT NOT NULL AUTO_INCREMENT,
  `date_taux` VARCHAR(45) NULL,
  `taux_euro_livre` DECIMAL(6,3) NULL,
  `taux_livre_euro` DECIMAL(6,3) NULL,
  `taux_dollar_livre` DECIMAL(6,3) NULL,
  `taux_livre_dollar` VARCHAR(45) NULL,
  PRIMARY KEY (`id_devise`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_vente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_vente` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_vente` (
  `id_vente` INT NULL AUTO_INCREMENT,
  `id_isbn` INT NULL,
  `id_devise` INT NULL,
  `date_vente` DATE NULL,
  `boutique` VARCHAR(45) NULL,
  `nombre` INT NULL,
  `montant_livre` DECIMAL(10,3) NULL,
  `montant_euro` DECIMAL(10,3) NULL,
  `montant_dollar` DECIMAL(10,3) NULL,
  `avec_droit` TINYINT(1) NULL,
  PRIMARY KEY (`id_vente`),
  CONSTRAINT `fk_iste_vente_iste_taux_devise1`
    FOREIGN KEY (`id_devise`)
    REFERENCES `iste`.`iste_devises` (`id_devise`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_vente_iste_isbn1`
    FOREIGN KEY (`id_isbn`)
    REFERENCES `iste`.`iste_isbn` (`id_isbn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_royalty`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_royalty` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_royalty` (
  `id_royalty` INT NOT NULL,
  `id_vente` INT NOT NULL,
  `id_auteur` INT NOT NULL,
  `montant_livre` DECIMAL(10,2) NULL,
  `montant_euro` DECIMAL(10,2) NULL,
  `montant_dollar` DECIMAL(10,2) NULL,
  `taxe_taux` DECIMAL(4,2) NULL,
  `taxe_deduction` VARCHAR(45) NULL,
  `pourcentage` DECIMAL(4,2) NULL,
  PRIMARY KEY (`id_royalty`, `id_vente`, `id_auteur`),
  CONSTRAINT `fk_iste_royalty_iste_vente1`
    FOREIGN KEY (`id_vente`)
    REFERENCES `iste`.`iste_vente` (`id_vente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_royalty_iste_auteur1`
    FOREIGN KEY (`id_auteur`)
    REFERENCES `iste`.`iste_auteur` (`id_auteur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_commitexlivre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_commitexlivre` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_commitexlivre` (
  `id_commite` INT NOT NULL,
  `id_livre` INT NOT NULL,
  PRIMARY KEY (`id_commite`, `id_livre`),
  CONSTRAINT `fk_iste_commite_has_iste_livre_iste_commite1`
    FOREIGN KEY (`id_commite`)
    REFERENCES `iste`.`iste_commite` (`id_commite`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_iste_commite_has_iste_livre_iste_livre1`
    FOREIGN KEY (`id_livre`)
    REFERENCES `iste`.`iste_livre` (`id_livre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iste`.`iste_prix`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iste`.`iste_prix` ;

CREATE TABLE IF NOT EXISTS `iste`.`iste_prix` (
  `id_prix` INT NULL AUTO_INCREMENT,
  `id_editeur` INT NOT NULL,
  `nb_page` INT NULL,
  `pdf` INT NULL,
  `prix_dollar` DECIMAL(6,2) NULL,
  `prix_euro` DECIMAL(6,2) NULL,
  `prix_livre` DECIMAL(6,2) NULL,
  PRIMARY KEY (`id_prix`),
  CONSTRAINT `fk_iste_prix_iste_editeur1`
    FOREIGN KEY (`id_editeur`)
    REFERENCES `iste`.`iste_editeur` (`id_editeur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
