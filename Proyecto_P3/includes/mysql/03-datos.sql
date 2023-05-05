-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2023 a las 16:49:01
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
('ADMIN@gmail.com', '$2y$10$GK0AkUYD2upID9WolIivV.z0jOqFGUXDD/O2iG2xTOmfcj9DaWp6i', 'Rodrigo', 'Quispe', 'admin');

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idAnuncio`, `rutaAnuncio`) VALUES
(0, './img/anuncios/anuncio.png'),
(1, './img/anuncios/anuncio2.png'),
(2, './img/anuncios/anuncio4.png'),
(3, './img/anuncios/anuncio5.png');

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`idCancion`, `nombreCancion`, `genero`, `nombreAlbum`, `duracion`, `rutaCancion`, `rutaImagen`) VALUES
(0, 'Antes de Perderte', 'Urbano Latino', 'Antes de Perderte', '174', 'music/DUKI - Antes de Perderte.mp3', './img/music/antesDePerderte.jpg'),
(1, 'She Dont Give a FO', 'Trap', 'She Dont Give a FO', '230', 'music/Duki  She Dont Give a FO ft Khea.mp3', './img/music/SheDontGive.jpg'),
(2, 'Jagger.mp3', 'Urbano Latino', 'Jagger.mp3', '156', 'music/Emilia - Jagger.mp3.mp3', './img/music/jaggerEmilia.jpg'),
(3, 'Cuestion de Fe', 'Rap', 'Hijos de la ruina, vol. 3', '290', 'music/Natos, Waor, Recycled J - CUESTION DE FE.mp3', './img/music/cuestionDeFe.jpg'),
(4, 'Cicatrices', 'Rap', 'Cicatrices', '182', 'music/Natos y Waor - CICATRICES.mp3', './img/music/cicatrices.jpg'),
(5, 'Sudores Frios', 'Rap', 'Hijos de la ruina, vol. 3', '275', 'music/Natos,Waor, RecycledJ-SUDORES FRIOS.mp3', './img/music/SudoresFrios.jpg'),
(6, 'Discoteka', 'Reggaeton', 'EL DRAGON', '176', 'music/LolaIndigo,MariaBecerra-DISCOTEKA.mp3', './img/music/discotecaLolaIndigo.jpg'),
(7, 'One day', 'Urbano Latino', 'Future Nostalgia', '249', 'music/JBalvin,DuaLipa,BadBunny,Tainy -ONEDAY.mp3', './img/music/OneDay.jpg'),
(8, 'Yandel 150', 'Reggaeton', 'Yandel 150', '218', 'music/yandel150.mp3', './img/music/yandel150v2.jpg'),
(9, 'Coco Chanel', 'Urbano Latino', '3MEN2 KBRN', '210', 'music/Eladio Carrión ft. Bad Bunny - Coco Chanel.mp3', './img/music/cocoChanel.jpg'),
(10, 'Bottas', 'Urbano Latino', 'SR. SANTOS', '206', 'music/Arcangel, Duki, Bizarrap - Bottas.mp3', './img/music/bottas.jpg'),
(11, 'Tu Principe', 'Reggaeton', 'Barrio fino', '205', 'music/Daddy Yankee, Zion & Lennox - Tu Principe.mp3', './img/music/tuPrincipe.jpg');

--
-- Volcado de datos para la tabla `contienen`
--

INSERT INTO `contienen` (`idPlaylist`, `idCancion`) VALUES
(0, 0),
(0, 2),
(0, 3),
(0, 9),
(3, 2);

--
-- Volcado de datos para la tabla `gestionanuncios`
--

INSERT INTO `gestionanuncios` (`email`, `idAnuncio`) VALUES
('ADMIN@gmail.com', 0),
('ADMIN@gmail.com', 1),
('ADMIN@gmail.com', 2),
('ADMIN@gmail.com', 3);

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`) VALUES
('ADMIN@gmail.com', '$2y$10$GK0AkUYD2upID9WolIivV.z0jOqFGUXDD/O2iG2xTOmfcj9DaWp6i', 'Rodrigo', 'Quispe', 'admin'),
('daddy@gmail.com', '$2y$10$8uGiqjgQcU3gviXJiM5hlOArZJ2cAuZwGTKfhSa/C6voceGFTib2y', 'Daddy', 'Yankee', 'usuario'),
('david@ucm.es', '$2y$10$yC6jBaZlcA93L0lDTfMYBu1tViAPc1knNSKp4Y4MkNqjwYyR.D54S', 'juan', 'Polvoron', 'usuario'),
('dualipa@gmail.com', '$2y$10$K8FYP72.Q55zkCeBrcBRYuGlLuyvraQhHTtyrVLDvZp81bF4W3yBq', 'DuaLipa', 'DuaLipa', 'usuario'),
('duki@gmail.com', '$2y$10$kEA9VtOMQNp.H2h3jjaCMug6yx5qoiqhLEjHV4xq5G3XHEdCrCRey', 'Duki', 'Duko', 'usuario'),
('eladio@gmail.com', '$2y$10$CC5kY/rMc0ifENZoVeK/Q..UNAbKuHm8aP77XReNDqr3N.jlJ6lSC', 'Eladio', 'Carrion', 'usuario'),
('emilia@gmail.com', '$2y$10$51lPhww.tihIHFu9ZH2lVOoRXncbnwCsQFD0P49K.56BJ086SXjQe', 'Emilia', 'Mernes', 'usuario'),
('hdlr@gmail.com', '$2y$10$oGZAp7C2bDrYUSzPA4NJiuhDSA7k0T76gfvLRCiRbf4QDzmJWPC.2', 'HDLR', 'Hijos de la ruina', 'usuario'),
('mariabecerra@gmail.com', '$2y$10$ahtFSA8BClqKKKCYcM.rzeFjYprK2PPMvWolgAfehh4hafsYyTUjO', 'Maria', 'Becerra', 'usuario'),
('pabloregi@ucm.es', '$2y$10$.i/OPE7p1MFw3xfDGceH5ejNvEktl0/UsMBQW/vTVXodnlBOnxfh.', 'Pablo', 'Regidor', 'usuario'),
('tendencias@gmail.com', '$2y$10$CgpQXN0LT/PPkcnWSupj5ey5vpZ5KTwvCer/c1xfevh9/px3KSuxe', 'tendencias', 'tendencias', 'usuario'),
('yandel@gmail.com', '$2y$10$IhjTUYGsBtZctYQ4XfwFs.4l0oPE11InblTAtbTGha.fR4qywxZXK', 'Yandel', 'Yandel', 'usuario');

--
-- Volcado de datos para la tabla `plandepago`
--

INSERT INTO `plandepago` (`tipoPlan`, `precio`, `duracionPlan`) VALUES
('artista', 19.99, '30'),
('basico', 0, '30'),
('premium', 7.99, '30');

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`idPlaylist`, `nombrePlaylist`, `email`, `duracionPlaylist`) VALUES
(0, 'tendencias', 'tendencias@gmail.com', '831'),
(3, 'ME GUSTA', 'pabloregi@ucm.es', '156'),
(4, 'ME GUSTA', 'david@ucm.es', '0'),
(5, 'ME GUSTA', 'tendencias@gmail.com', '0'),
(6, 'ME GUSTA', 'duki@gmail.com', '0'),
(7, 'ME GUSTA', 'emilia@gmail.com', '0'),
(8, 'ME GUSTA', 'hdlr@gmail.com', '0'),
(9, 'ME GUSTA', 'eladio@gmail.com', '0'),
(10, 'ME GUSTA', 'mariabecerra@gmail.com', '0'),
(11, 'ME GUSTA', 'dualipa@gmail.com', '0'),
(12, 'ME GUSTA', 'yandel@gmail.com', '0'),
(13, 'ME GUSTA', 'daddy@gmail.com', '0');

--
-- Volcado de datos para la tabla `subencanciones`
--

INSERT INTO `subencanciones` (`IdCancion`, `email`) VALUES
(0, 'duki@gmail.com'),
(1, 'duki@gmail.com'),
(2, 'emilia@gmail.com'),
(3, 'hdlr@gmail.com'),
(4, 'hdlr@gmail.com'),
(5, 'hdlr@gmail.com'),
(6, 'mariabecerra@gmail.com'),
(7, 'dualipa@gmail.com'),
(8, 'yandel@gmail.com'),
(9, 'eladio@gmail.com'),
(10, 'duki@gmail.com'),
(11, 'daddy@gmail.com');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`, `tipoPlan`, `fechaExpiracionPlan`) VALUES
('daddy@gmail.com', '$2y$10$8uGiqjgQcU3gviXJiM5hlOArZJ2cAuZwGTKfhSa/C6voceGFTib2y', 'Daddy', 'Yankee', 'usuario', 'artista', '2023-06-04'),
('david@ucm.es', '$$2y$10$yC6jBaZlcA93L0lDTfMYBu1tViAPc1knNSKp4Y4MkNqjwYyR.D54S', 'juan', 'Polvoron', 'usuario', 'basico', '2023-04-26'),
('dualipa@gmail.com', '$2y$10$K8FYP72.Q55zkCeBrcBRYuGlLuyvraQhHTtyrVLDvZp81bF4W3yBq', 'DuaLipa', 'DuaLipa', 'usuario', 'artista', '2023-06-04'),
('duki@gmail.com', '$2y$10$kEA9VtOMQNp.H2h3jjaCMug6yx5qoiqhLEjHV4xq5G3XHEdCrCRey', 'Duki', 'Duko', 'usuario', 'artista', '2023-06-04'),
('eladio@gmail.com', '$2y$10$CC5kY/rMc0ifENZoVeK/Q..UNAbKuHm8aP77XReNDqr3N.jlJ6lSC', 'Eladio', 'Carrion', 'usuario', 'artista', '2023-06-04'),
('emilia@gmail.com', '$2y$10$51lPhww.tihIHFu9ZH2lVOoRXncbnwCsQFD0P49K.56BJ086SXjQe', 'Emilia', 'Mernes', 'usuario', 'artista', '2023-06-04'),
('hdlr@gmail.com', '$2y$10$oGZAp7C2bDrYUSzPA4NJiuhDSA7k0T76gfvLRCiRbf4QDzmJWPC.2', 'HDLR', 'Hijos', 'usuario', 'artista', '2023-06-04'),
('mariabecerra@gmail.com', '$2y$10$ahtFSA8BClqKKKCYcM.rzeFjYprK2PPMvWolgAfehh4hafsYyTUjO', 'Maria', 'Becerra', 'usuario', 'artista', '2023-06-04'),
('pabloregi@ucm.es', '$2y$10$.i/OPE7p1MFw3xfDGceH5ejNvEktl0/UsMBQW/vTVXodnlBOnxfh.', 'Pablo', 'Regidor', 'usuario', 'premium', '2023-04-16'),
('tendencias@gmail.com', '$2y$10$CgpQXN0LT/PPkcnWSupj5ey5vpZ5KTwvCer/c1xfevh9/px3KSuxe', 'tendencias', 'tendencias', 'usuario', 'basico', '2023-06-03'),
('yandel@gmail.com', '$2y$10$IhjTUYGsBtZctYQ4XfwFs.4l0oPE11InblTAtbTGha.fR4qywxZXK', 'Yandel', 'Yandel', 'usuario', 'artista', '2023-06-04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
