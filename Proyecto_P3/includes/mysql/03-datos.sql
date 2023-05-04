-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-05-2023 a las 19:06:48
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `beathouse`
--

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`) VALUES
('ADMIN2@gmail.com', '$2y$10$CVBKGkqrIjBSaNpNQuRms.u6WX3o1eWKtYzPpRVnTy9lQyIaLJyF2', 'Rodrigo', 'Diaz de Vivar', 'admin'),
('ADMIN@gmail.com', '$2y$10$GK0AkUYD2upID9WolIivV.z0jOqFGUXDD/O2iG2xTOmfcj9DaWp6i', 'Ricardo', 'Rodriguez', 'admin');

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idAnuncio`, `rutaAnuncio`) VALUES
(17, './img/anuncios/anuncio.png'),
(18, './img/anuncios/anuncio2.png'),
(19, './img/anuncios/anuncio4.png'),
(20, './img/anuncios/anuncio5.png');

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`idCancion`, `nombreCancion`, `genero`, `nombreAlbum`, `duracion`, `rutaCancion`, `rutaImagen`) VALUES
(5, 'She dontgive', 'Trap', 'Duki', '230', 'music/Duki  She Dont Give a FO ft Khea.mp3', './img/music/SheDontGive.jpg'),
(6, 'Sudores Friosss', 'Rap', 'Hijos de la Ruina', '275', 'music/Natos,Waor, RecycledJ-SUDORES FRIOS.mp3', './img/music/SudoresFrios.jpg'),
(7, 'DISCOTEKA', 'Regeton', 'DISCOTEKA', '176', 'music/LolaIndigo,MariaBecerra-DISCOTEKA.mp3', './img/music/discotecaLolaIndigo.jpg'),
(8, 'ONE DAY', 'Trap', 'ONE DAY', '249', 'music/JBalvin,DuaLipa,BadBunny,Tainy -ONEDAY.mp3', './img/music/OneDay.jpg'),
(9, 'Yandel 150', 'Regeton', 'Yandel 150', '218', 'music/yandel150.mp3', './img/music/yandel150v2.jpg');

--
-- Volcado de datos para la tabla `contienen`
--

INSERT INTO `contienen` (`idPlaylist`, `idCancion`) VALUES
(0, 5),
(0, 7),
(1, 6),
(1, 9),
(3, 5),
(3, 6);

--
-- Volcado de datos para la tabla `gestionanuncios`
--

INSERT INTO `gestionanuncios` (`email`, `idAnuncio`) VALUES
('ADMIN@gmail.com', 17),
('ADMIN@gmail.com', 18),
('ADMIN@gmail.com', 19),
('ADMIN@gmail.com', 20);

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`) VALUES
('ADMIN2@gmail.com', '$2y$10$CVBKGkqrIjBSaNpNQuRms.u6WX3o1eWKtYzPpRVnTy9lQyIaLJyF2', 'Rodrigo', 'Diaz de Vivar', 'admin'),
('ADMIN@gmail.com', '$2y$10$GK0AkUYD2upID9WolIivV.z0jOqFGUXDD/O2iG2xTOmfcj9DaWp6i', 'Ricardo', 'Rodriguez', 'admin'),
('david@ucm.es', '$2y$10$yC6jBaZlcA93L0lDTfMYBu1tViAPc1knNSKp4Y4MkNqjwYyR.D54S', 'juan', 'Polvoron', 'usuario'),
('franzroq@ucm.es', '$2y$10$wKJQ4W5JpsMkf47dHXag8.1kd7VFywHEUE/SJwMH8aojeqQq4KsGa', 'Rodrigo', 'Quispe', 'usuario'),
('pabloregi@ucm.es', '$2y$10$.i/OPE7p1MFw3xfDGceH5ejNvEktl0/UsMBQW/vTVXodnlBOnxfh.', 'Pablo', 'Regidor', 'usuario'),
('tendencias@gmail.com', '$2y$10$CgpQXN0LT/PPkcnWSupj5ey5vpZ5KTwvCer/c1xfevh9/px3KSuxe', 'tendencias', 'tendencias', 'usuario');

--
-- Volcado de datos para la tabla `plandepago`
--

INSERT INTO `plandepago` (`tipoPlan`, `precio`, `duracionPlan`) VALUES
('artista', 19.99, '35'),
('basico', 0, '30'),
('premium', 7.99, '30');

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`idPlaylist`, `nombrePlaylist`, `email`, `duracionPlaylist`) VALUES
(0, 'tendencias', 'tendencias@gmail.com', '406'),
(1, 'ME GUSTA', 'franzroq@ucm.es', '250'),
(3, 'ME GUSTA', 'pabloregi@ucm.es', '350'),
(4, 'ME GUSTA', 'david@ucm.es', '0'),
(5, 'ME GUSTA', 'tendencias@gmail.com', '0');

--
-- Volcado de datos para la tabla `subencanciones`
--

INSERT INTO `subencanciones` (`IdCancion`, `email`) VALUES
(6, 'franzroq@ucm.es');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`, `tipoPlan`, `fechaExpiracionPlan`) VALUES
('david@ucm.es', '$$2y$10$yC6jBaZlcA93L0lDTfMYBu1tViAPc1knNSKp4Y4MkNqjwYyR.D54S', 'juan', 'Polvoron', 'usuario', 'basico', '2023-04-26'),
('franzroq@ucm.es', '$2y$10$wKJQ4W5JpsMkf47dHXag8.1kd7VFywHEUE/SJwMH8aojeqQq4KsGa', 'Rodrigo', 'Quispe', 'usuario', 'artista', '2023-04-16'),
('pabloregi@ucm.es', '$2y$10$.i/OPE7p1MFw3xfDGceH5ejNvEktl0/UsMBQW/vTVXodnlBOnxfh.', 'Pablo', 'Regidor', 'usuario', 'premium', '2023-04-16'),
('tendencias@gmail.com', '$2y$10$CgpQXN0LT/PPkcnWSupj5ey5vpZ5KTwvCer/c1xfevh9/px3KSuxe', 'tendencias', 'tendencias', 'usuario', 'basico', '2023-06-03');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
