-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2023 a las 16:11:19
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `beat_house`
--

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`) VALUES
('ADMIN2@gmail.com', '$2y$10$CVBKGkqrIjBSaNpNQuRms.u6WX3o1eWKtYzPpRVnTy9lQyIaLJyF2', 'Rodrigo', 'Diaz de Vivar', 'admin'),
('ADMIN@gmail.com', '$2y$10$GK0AkUYD2upID9WolIivV.z0jOqFGUXDD/O2iG2xTOmfcj9DaWp6i', 'Ricardo', 'Rodriguez', 'admin'),
('david@ucm.es', '$2y$10$4CjTsoBJfPynYq2g2WRPfeXOZlpeIvSmmt4frQArlfPkUXZN4QqwO', 'David', 'Polvoron', 'usuario'),
('franzroq@ucm.es', '$2y$10$wKJQ4W5JpsMkf47dHXag8.1kd7VFywHEUE/SJwMH8aojeqQq4KsGa', 'Rodrigo', 'Quispe', 'usuario'),
('pabloregi@ucm.es', '$2y$10$.i/OPE7p1MFw3xfDGceH5ejNvEktl0/UsMBQW/vTVXodnlBOnxfh.', 'Pablo', 'Regidor', 'usuario');

--
-- Volcado de datos para la tabla `plandepago`
--

INSERT INTO `plandepago` (`tipoPlan`, `precio`, `duracionPlan`) VALUES
('artista', 19.99, '30'),
('basico', 0, '30'),
('premium', 7.99, '30');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`, `tipoPlan`, `fechaExpiracionPlan`) VALUES
('david@ucm.es', '$2y$10$4CjTsoBJfPynYq2g2WRPfeXOZlpeIvSmmt4frQArlfPkUXZN4QqwO', 'David', 'Polvoron', 'usuario', 'basico', '2023-04-16'),
('franzroq@ucm.es', '$2y$10$wKJQ4W5JpsMkf47dHXag8.1kd7VFywHEUE/SJwMH8aojeqQq4KsGa', 'Rodrigo', 'Quispe', 'usuario', 'artista', '2023-04-16'),
('pabloregi@ucm.es', '$2y$10$.i/OPE7p1MFw3xfDGceH5ejNvEktl0/UsMBQW/vTVXodnlBOnxfh.', 'Pablo', 'Regidor', 'usuario', 'premium', '2023-04-16');

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`) VALUES
('ADMIN2@gmail.com', '$2y$10$CVBKGkqrIjBSaNpNQuRms.u6WX3o1eWKtYzPpRVnTy9lQyIaLJyF2', 'Rodrigo', 'Diaz de Vivar', 'admin'),
('ADMIN@gmail.com', '$2y$10$GK0AkUYD2upID9WolIivV.z0jOqFGUXDD/O2iG2xTOmfcj9DaWp6i', 'Ricardo', 'Rodriguez', 'admin');

-- --
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idAnuncio`, `rutaAnuncio`) VALUES
(1, 'rutaAnuncio1'),
(2, 'ruta2');

-- --
-- Volcado de datos para la tabla `gestionanuncios`
--

INSERT INTO `gestionanuncios` (`email`, `idAnuncio`) VALUES
('ADMIN@gmail.com', 1),
('ADMIN2@gmail.com', 2);

-- --
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`idCancion`, `nombreCancion`, `genero`, `nombreAlbum`, `duracion`, `rutaCancion`, `rutaImagen`) VALUES
(1, 'cancion1', 'genero1', 'album1', '180', 'rutaCancion1', 'rutaImgC1'),
(2, 'cancion2', 'genero1', 'album2', '200', 'rutaCancion2', 'rutaImgC2'),
(3, 'cancion3', 'genero2', 'album1', '160', 'rutaCancion3', 'rutaImgC3');
(4, 'Yandel 150', 'Reggaeton', 'Yandel 150', '130', 'music/yandel150.mp3', './img/music/yandel150v2.png'),
(5, 'Duki  She Dont Give ', 'Trap', 'Duki', '120', 'music/Duki  She Dont Give a FO ft Khea.mp3', './img/music/SheDontGive.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
