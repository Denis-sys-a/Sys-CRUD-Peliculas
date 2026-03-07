-- Script para MySQL Workbench
CREATE DATABASE IF NOT EXISTS `bd_peliculas`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
  
USE `bd_peliculas`;

CREATE TABLE IF NOT EXISTS `peliculas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `director` varchar(120) NOT NULL,
  `genero` varchar(80) NOT NULL,
  `anio_estreno` int(4) NOT NULL,
  `duracion_min` int(4) NOT NULL,
  `clasificacion` varchar(10) NOT NULL,
  `sinopsis` text NOT NULL,
  `cartel_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--Ya con la tabla creada, se insertan los datos de las peliculas en la tabla con el siguiente script SQL:
INSERT INTO `peliculas`
  (`titulo`, `director`, `genero`, `anio_estreno`, `duracion_min`, `clasificacion`, `sinopsis`, `cartel_url`)
VALUES
  ('Interstellar', 'Christopher Nolan', 'Ciencia ficción', 2014, 169, 'PG-13', 'Un grupo viaja por un agujero de gusano para salvar a la humanidad.', 'https://m.media-amazon.com/images/I/71n58fD4H-L._AC_UF894,1000_QL80_.jpg'),
  ('Parasite', 'Bong Joon-ho', 'Drama', 2019, 132, 'R', 'Dos familias de clases sociales opuestas se cruzan en una historia intensa.', 'https://m.media-amazon.com/images/I/91B6fC6uYKL.jpg'),
  ('Coco', 'Lee Unkrich', 'Animación', 2017, 105, 'PG', 'Un niño apasionado por la música entra al mundo de los muertos.', 'https://m.media-amazon.com/images/I/81Peasj30sL.jpg');
