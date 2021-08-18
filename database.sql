CREATE DATABASE crud_php_mysql;

USE crud_php_mysql;

CREATE TABLE `veiculos` (
	`cod_veiculo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`placa` VARCHAR(10) NOT NULL,
	`marca` VARCHAR(30) NOT NULL,
	`modelo` VARCHAR(30) NOT NULL,
	`ano_fabricacao` YEAR NOT NULL,
	PRIMARY KEY (`cod_veiculo`) USING BTREE,
	UNIQUE INDEX `veiculos_01_ix` (`placa`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=INNODB;

INSERT INTO `veiculos` (`placa`, `marca`, `modelo`, `ano_fabricacao`)
VALUES ('ABC-1234', 'Ford', 'Fiesta', 2010),
       ('XYZ-9876', 'Fiat', 'Palio', 2012),
	   ('AAA-1122', 'Fiat', 'Strada', 2019),
	   ('BBB-5599', 'Volkswagen', 'Golf', 2015),
	   ('CCC-4466', 'Ford', 'Fiesta', 2017);