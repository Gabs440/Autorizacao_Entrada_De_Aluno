create database bdauto;
use bdauto;

CREATE TABLE tbregistro (
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `RM` INT(5) NOT NULL,
  `nomealuno` varchar(50) NOT NULL,
  `serie` char(2) NOT NULL,
  `curso` char(1) NOT NULL,
  `serie_curso` varchar(6) NOT NULL DEFAULT CONCAT(serie, curso),
  `data` DATE NOT NULL DEFAULT NOW(),
  `hora` TIME NOT NULL DEFAULT NOW(),
  `motivo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;