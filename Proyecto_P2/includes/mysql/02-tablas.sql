-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2023 a las 18:40:32
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
-- Base de datos: `beat house`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `email` varchar(50) NOT NULL,
  `contraseña` varchar(30) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `rol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `admin`
--

TRUNCATE TABLE `admin`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `idAnuncio` int(11) NOT NULL,
  `rutaAnuncio` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `anuncios`
--

TRUNCATE TABLE `anuncios`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `idCancion` int(11) NOT NULL,
  `nombreCancion` varchar(20) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `nombreAlbum` varchar(20) NOT NULL,
  `duracion` int(11) NOT NULL,
  `rutaCancion` varchar(150) NOT NULL,
  `rutaImagen` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `canciones`
--

TRUNCATE TABLE `canciones`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contienen`
--

CREATE TABLE `contienen` (
  `idPlaylist` int(11) NOT NULL,
  `idCancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `contienen`
--

TRUNCATE TABLE `contienen`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestionanuncios`
--

CREATE TABLE `gestionanuncios` (
  `email` varchar(50) NOT NULL,
  `idAnuncio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `gestionanuncios`
--

TRUNCATE TABLE `gestionanuncios`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `email` varchar(50) NOT NULL,
  `contraseña` varchar(30) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `rol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `perfil`
--

TRUNCATE TABLE `perfil`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plandepago`
--

CREATE TABLE `plandepago` (
  `tipoPlan` varchar(20) NOT NULL,
  `precio` float NOT NULL,
  `duracionPlan` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `plandepago`
--

TRUNCATE TABLE `plandepago`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist`
--

CREATE TABLE `playlist` (
  `idPlaylist` int(11) NOT NULL,
  `nombrePlaylist` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `duracionPlaylist` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `playlist`
--

TRUNCATE TABLE `playlist`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subencanciones`
--

CREATE TABLE `subencanciones` (
  `idCancion` int(11) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `subencanciones`
--

TRUNCATE TABLE `subencanciones`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `email` varchar(50) NOT NULL,
  `contraseña` varchar(30) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `tipoPlan` varchar(20) NOT NULL,
  `fechaExpiracionPlan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`idAnuncio`);

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD PRIMARY KEY (`idCancion`);

--
-- Indices de la tabla `contienen`
--
ALTER TABLE `contienen`
  ADD KEY `idCancion` (`idCancion`),
  ADD KEY `idPlaylist` (`idPlaylist`);

--
-- Indices de la tabla `gestionanuncios`
--
ALTER TABLE `gestionanuncios`
  ADD KEY `email` (`email`),
  ADD KEY `idAnuncio` (`idAnuncio`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `plandepago`
--
ALTER TABLE `plandepago`
  ADD PRIMARY KEY (`tipoPlan`);

--
-- Indices de la tabla `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`idPlaylist`),
  ADD KEY `email` (`email`);

--
-- Indices de la tabla `subencanciones`
--
ALTER TABLE `subencanciones`
  ADD KEY `email` (`email`),
  ADD KEY `idCancion` (`idCancion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`email`),
  ADD KEY `tipoPlan` (`tipoPlan`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`email`) REFERENCES `perfil` (`email`);

--
-- Filtros para la tabla `contienen`
--
ALTER TABLE `contienen`
  ADD CONSTRAINT `contienen_ibfk_1` FOREIGN KEY (`idCancion`) REFERENCES `canciones` (`idCancion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contienen_ibfk_2` FOREIGN KEY (`idPlaylist`) REFERENCES `playlist` (`idPlaylist`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `gestionanuncios`
--
ALTER TABLE `gestionanuncios`
  ADD CONSTRAINT `gestionanuncios_ibfk_1` FOREIGN KEY (`email`) REFERENCES `admin` (`email`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gestionanuncios_ibfk_2` FOREIGN KEY (`idAnuncio`) REFERENCES `anuncios` (`idAnuncio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `subencanciones`
--
ALTER TABLE `subencanciones`
  ADD CONSTRAINT `subencanciones_ibfk_1` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`) ON UPDATE CASCADE,
  ADD CONSTRAINT `subencanciones_ibfk_2` FOREIGN KEY (`idCancion`) REFERENCES `canciones` (`idCancion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`email`) REFERENCES `perfil` (`email`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`tipoPlan`) REFERENCES `plandepago` (`tipoPlan`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
