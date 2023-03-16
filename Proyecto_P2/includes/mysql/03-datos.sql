-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-03-2023 a las 11:05:26
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
('correo@gmail.com', 'contrasena', 'pablo', 'regi', 'usuario');

--
-- Volcado de datos para la tabla `plandepago`
--

INSERT INTO `plandepago` (`tipoPlan`, `precio`, `duracionPlan`) VALUES
('basico', 13.99, '100:00:00');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`email`, `contraseña`, `nombre`, `apellidos`, `rol`, `tipoPlan`, `fechaExpiracionPlan`) VALUES
('correo@gmail.com', 'contrasena', 'pablo', 'regi', 'usuario', 'basico', '2023-03-16 09:53:10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
