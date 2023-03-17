-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2023 a las 15:48:43
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
('david@ucm.es', '$2y$10$z4pd8C0UUaAA5271oCVMS../qb74O3lNTGP4f/XsaPktfm1mVN8bS', 'David', 'Polvoron', 'usuario'),
('fefwfwf@fefwfe', '$2y$10$aIrWLrgdsK/.BoH7p84OLO/wjqKdy6n2qkQnvdIEHhwvW.cbdG7Ou', 'wewefwfef', 'ewfwefewf', 'usuario'),
('franzroq@ucm.es', '$2y$10$zOefia.2FGU/76jFTkNV1eoA/dabN0WeBxaAqu/i7KOXg8W5asmde', 'rodrigo', 'Quispe', 'usuario'),
('juanito@ucm.es', '$2y$10$vhrLGrDyZuCSLAf6Vk607OUaJhvPw/Tufg72qy8nQd15Wpi1xf77.', 'juanito', 'salzar', 'usuario'),
('pabloregidor@ucm.es', '$2y$10$3uNCpWI75aduAdMtgPUUOuOjgXanQflqXFQYPirPlfSDQXf./O4Ja', 'Pablo', 'Regidor', 'usuario'),
('QERKOJNG@UCM.ES', '$2y$10$RREHsDpNE1G2DMmAV/Vl1ey1sDpVCPsmroLElQLV/1eZb0wwAJitm', 'ERLMKGNR', 'ERGKNQERKG', 'usuario'),
('rodriq@ucm.es', '$2y$10$9gLcDoXt70gJYWBbz/.3fOiw4eLbNE31GQMU.lZVu0Vu9biaz0wCS', 'RodriQ', 'Avila', 'usuario'),
('vlevllew@kllvlevel', '$2y$10$K46d4PTmlZVXJJ/3IP.txuvZLBk9J5Y0kH0yMHVbWT0Fz/jORCJBi', 'ldldflvdflvlds', 'vldvlwevlwl', 'usuario'),
('wklekrnmgokqenrg@ucm.es', '$2y$10$zT/ugTurF2x3QYNxpWkfX.3riJ.IShMthDOtgsJyB5SIKwoxtkabO', '2jfpkjerg', 'qermlngkoqernlg', 'usuario'),
('wqreoiuogn3r@ucm.es', '$2y$10$kjgtcA9UgM.T5XJ9UTGf0OeL1SJZU3cXxqhplULmRodGFuDUFa1h2', 'qwlelfplqerg', 'qer&ntilde;kgmqegt', 'usuario');

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
('david@ucm.es', '$2y$10$z4pd8C0UUaAA5271oCVMS../qb74O3lNTGP4f/XsaPktfm1mVN8bS', 'David', 'Polvoron', 'usuario', 'artista', '2023-04-16'),
('franzroq@ucm.es', '$2y$10$zOefia.2FGU/76jFTkNV1eoA/dabN0WeBxaAqu/i7KOXg8W5asmde', 'rodrigo', 'Quispe', 'usuario', 'basico', '2023-04-16'),
('juanito@ucm.es', '$2y$10$vhrLGrDyZuCSLAf6Vk607OUaJhvPw/Tufg72qy8nQd15Wpi1xf77.', 'juanito', 'salzar', 'usuario', 'basico', '2023-04-16'),
('pabloregidor@ucm.es', '$2y$10$3uNCpWI75aduAdMtgPUUOuOjgXanQflqXFQYPirPlfSDQXf./O4Ja', 'Pablo', 'Regidor', 'usuario', 'premium', '2023-04-16'),
('rodriq@ucm.es', '$2y$10$9gLcDoXt70gJYWBbz/.3fOiw4eLbNE31GQMU.lZVu0Vu9biaz0wCS', 'RodriQ', 'Avila', 'usuario', 'premium', '2023-04-16');

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
(1, 'rutaAnuncio1');

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`idCancion`, `nombreCancion`, `genero`, `nombreAlbum`, `duracion`, `rutaCancion`, `rutaImagen`) VALUES
(1, 'cancion1', 'genero1', 'album1', '180', 'rutaCancion1', 'rutaImgC1'),
(2, 'cancion2', 'genero1', 'album2', '200', 'rutaCancion2', 'rutaImgC2'),
(3, 'cancion3', 'genero2', 'album1', '160', 'rutaCancion3', 'rutaImgC3');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;