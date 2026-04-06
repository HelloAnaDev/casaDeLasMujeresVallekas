-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-04-2026 a las 02:24:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `casamujeresvallekas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradoras`
--

CREATE TABLE `administradoras` (
  `idAdmin` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `idMemoria` int(11) NOT NULL,
  `idDispositivo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estadoPublicacion` tinyint(1) NOT NULL DEFAULT 0,
  `texto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentaristas`
--

CREATE TABLE `comentaristas` (
  `idDispositivo` int(11) NOT NULL,
  `token` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_memorias`
--

CREATE TABLE `imagenes_memorias` (
  `idImagen` int(11) NOT NULL,
  `idMemoria` int(11) NOT NULL,
  `rutaImagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memorias`
--

CREATE TABLE `memorias` (
  `idMemoria` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion` text NOT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_feminicidios`
--

CREATE TABLE `registro_feminicidios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `tipo_victima` enum('mayor','menor') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradoras`
--
ALTER TABLE `administradoras`
  ADD PRIMARY KEY (`idAdmin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`),
  ADD KEY `idMemoria` (`idMemoria`),
  ADD KEY `idDispositivo` (`idDispositivo`);

--
-- Indices de la tabla `comentaristas`
--
ALTER TABLE `comentaristas`
  ADD PRIMARY KEY (`idDispositivo`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `imagenes_memorias`
--
ALTER TABLE `imagenes_memorias`
  ADD PRIMARY KEY (`idImagen`),
  ADD KEY `idMemoria` (`idMemoria`);

--
-- Indices de la tabla `memorias`
--
ALTER TABLE `memorias`
  ADD PRIMARY KEY (`idMemoria`);

--
-- Indices de la tabla `registro_feminicidios`
--
ALTER TABLE `registro_feminicidios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradoras`
--
ALTER TABLE `administradoras`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentaristas`
--
ALTER TABLE `comentaristas`
  MODIFY `idDispositivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes_memorias`
--
ALTER TABLE `imagenes_memorias`
  MODIFY `idImagen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memorias`
--
ALTER TABLE `memorias`
  MODIFY `idMemoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_feminicidios`
--
ALTER TABLE `registro_feminicidios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idMemoria`) REFERENCES `memorias` (`idMemoria`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idDispositivo`) REFERENCES `comentaristas` (`idDispositivo`);

--
-- Filtros para la tabla `imagenes_memorias`
--
ALTER TABLE `imagenes_memorias`
  ADD CONSTRAINT `imagenes_memorias_ibfk_1` FOREIGN KEY (`idMemoria`) REFERENCES `memorias` (`idMemoria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
