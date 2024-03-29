-- MySQL Script generated by MySQL Workbench
-- Tue Dec 19 09:40:53 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema recetario
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema recetario
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `recetario` DEFAULT CHARACTER SET utf8 ;
USE `recetario` ;

-- -----------------------------------------------------
-- Table `recetario`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recetario`.`Usuario` (
  `idUsuario` VARCHAR(50) NOT NULL,
  `NombreUsu` VARCHAR(45) NOT NULL,
  `Clave` VARCHAR(100) NOT NULL,
  `Email` VARCHAR(45) NOT NULL,
  `Sexo` CHAR NOT NULL,
  `FechaNacimiento` DATE NOT NULL,
  `Administrador` TINYINT(2) NOT NULL,
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `recetario`.`Receta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recetario`.`Receta` (
  `idReceta` INT NOT NULL AUTO_INCREMENT,
  `NombreReceta` VARCHAR(45) NOT NULL,
  `Descripcion` VARCHAR(200) NOT NULL,
  `idUsuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idReceta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `recetario`.`Producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recetario`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `NombreProd` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idProducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `recetario`.`UndMedida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recetario`.`UndMedida` (
  `idUndMedida` INT NOT NULL AUTO_INCREMENT,
  `NombreMed` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idUndMedida`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `recetario`.`Producto_Receta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recetario`.`Producto_Receta` (
  `Producto_idProducto` INT NOT NULL,
  `Receta_idReceta` INT NOT NULL,
  `Cantidad` DOUBLE NOT NULL,
  `UndMedida_idUndMedida` INT NOT NULL,
  PRIMARY KEY (`Producto_idProducto`, `Receta_idReceta`),
  INDEX `fk_Producto_has_Receta_Receta1_idx` (`Receta_idReceta` ASC),
  INDEX `fk_Producto_has_Receta_Producto_idx` (`Producto_idProducto` ASC),
  INDEX `fk_Producto_has_Receta_UndMedida1_idx` (`UndMedida_idUndMedida` ASC),
  CONSTRAINT `fk_Producto_has_Receta_Producto`
    FOREIGN KEY (`Producto_idProducto`)
    REFERENCES `recetario`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_has_Receta_Receta1`
    FOREIGN KEY (`Receta_idReceta`)
    REFERENCES `recetario`.`Receta` (`idReceta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Producto_has_Receta_UndMedida1`
    FOREIGN KEY (`UndMedida_idUndMedida`)
    REFERENCES `recetario`.`UndMedida` (`idUndMedida`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `recetario`.`Calificacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recetario`.`Calificacion` (
  `Usuario_idUsuario` VARCHAR(50) NOT NULL,
  `Receta_idReceta` INT NOT NULL,
  `Calificacion` INT NOT NULL,
  PRIMARY KEY (`Usuario_idUsuario`, `Receta_idReceta`),
  INDEX `fk_Usuario_has_Receta_Receta1_idx` (`Receta_idReceta` ASC),
  INDEX `fk_Usuario_has_Receta_Usuario1_idx` (`Usuario_idUsuario` ASC),
  CONSTRAINT `fk_Usuario_has_Receta_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `recetario`.`Usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Usuario_has_Receta_Receta1`
    FOREIGN KEY (`Receta_idReceta`)
    REFERENCES `recetario`.`Receta` (`idReceta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
