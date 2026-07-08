-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2026 a las 14:06:58
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

--
-- Volcado de datos para la tabla `administradoras`
--

INSERT INTO `administradoras` (`idAdmin`, `nombre`, `email`, `password`) VALUES
(1, 'Anita', 'ananevadodeoyarbide@gmail.com', '$2y$10$qCQWBaqlKIVE/5CX1PbdYOYIMw7JTdd5a.ET1JBE3yPv04.jmXSW.'),
(5, 'Ana profesional', 'helloanadev@gmail.com', '$2y$10$y6ez7OKcmfva87DcUOK3AOVxG.70Hz26rkmbJmNw7onJjsheF4J5m');

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

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idComentario`, `idMemoria`, `idDispositivo`, `nombre`, `fecha`, `estadoPublicacion`, `texto`) VALUES
(3, 5, 1, 'Alba (Ejemplo)', '2026-03-23 19:47:37', 1, 'Estuve allí!! Qué bien lo pasamos!! (Ejemplo)'),
(4, 5, 1, 'Anónima (Ejemplo)', '2026-03-25 12:51:42', 1, 'Buenas, me gustaría ir a otras actividades que organiceis. Os he mandado un mensaje para que me expliqueis cómo, por favor.\r\nGracias. (Ejemplo)'),
(7, 6, 1, 'Teresa (Ejemplo)', '2026-03-01 00:09:05', 1, 'Por muchos días más así, chicas!!!! (ejemplo)'),
(8, 6, 1, 'Marta (ejemplo)', '2026-03-17 10:07:28', 1, 'Menos mal que el tiempo acompañó!!! Qué ganas de que llegue mayo-junio y poder organizar muchas más actividades al aire libre. Un saludo!!!! (Ejemplo)'),
(9, 6, 1, 'Vecina (Ejemplo)', '2026-03-27 10:07:31', 1, 'Anda Marta, no sabía que fuíste!!! Que guapa sales en las fotos!! (Ejemplo)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentaristas`
--

CREATE TABLE `comentaristas` (
  `idDispositivo` int(11) NOT NULL,
  `token` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentaristas`
--

INSERT INTO `comentaristas` (`idDispositivo`, `token`) VALUES
(1, '38d115d2-8616-4384-9f60-21d2b6084124');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_memorias`
--

CREATE TABLE `imagenes_memorias` (
  `idImagen` int(11) NOT NULL,
  `idMemoria` int(11) NOT NULL,
  `rutaImagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_memorias`
--

INSERT INTO `imagenes_memorias` (`idImagen`, `idMemoria`, `rutaImagen`) VALUES
(10, 5, '1774037884_escola_feminista.jpg'),
(11, 5, '1774037884_images (1).jpg'),
(12, 5, '1774037884_images.jpg'),
(13, 5, '1774037884_mujeres-kBbE-U201239063394k6C-1200x840@El Correo.webp'),
(30, 6, '1774038810_Mesa-redonda-Mujeres-mayores-e-igualdad-2.jpg'),
(31, 6, '1774038810_mujeres-y-periodismo-8.jpeg'),
(32, 6, '1774038830_defensapersonal_thumb_468.jpg'),
(36, 6, '1774529677_Igualdad_club-lectura-feminista-cartel.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memorias`
--

CREATE TABLE `memorias` (
  `idMemoria` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion` text NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT 'LA CASA',
  `likes` int(11) DEFAULT 0,
  `es_borrador` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `memorias`
--

INSERT INTO `memorias` (`idMemoria`, `titulo`, `fecha`, `descripcion`, `id_admin`, `categoria`, `likes`, `es_borrador`) VALUES
(5, 'Enero 2026- EJEMPLO', '2025-12-31 23:00:00', '//EJEMPLO HIPOTETICO// Durante el mes de enero se llevaron a cabo diversas actividades con el objetivo de fomentar la igualdad, la participación comunitaria y la reflexión en torno a los derechos de las mujeres. Estas iniciativas buscaron crear espacios seguros de encuentro, aprendizaje y diálogo, dirigidos a mujeres de diferentes edades y contextos.\r\n\r\nUna de las primeras actividades del mes fue un taller de introducción al feminismo  , en el que se abordaron conceptos básicos sobre igualdad de género, historia del movimiento feminista y las principales reivindicaciones actuales. La sesión se desarrolló de forma participativa, fomentando el intercambio de experiencias entre las asistentes y generando un espacio de debate abierto.\r\n\r\nTambién se realizó un encuentro comunitario de mujeres, orientado a fortalecer redes de apoyo y sororidad entre vecinas. Durante la actividad se compartieron experiencias personales, se reflexionó sobre los retos que enfrentan las mujeres en la vida cotidiana y se propusieron ideas para futuras acciones colectivas en el barrio.\r\n\r\nOtra de las propuestas destacadas fue un taller creativo de pancartas y carteles reivindicativos, donde las participantes elaboraron materiales con mensajes a favor de la igualdad y contra las violencias machistas. Esta actividad permitió combinar la expresión artística con la reflexión social, generando un ambiente colaborativo y dinámico.\r\n\r\nAdemás, se organizó una charla sobre referentes femeninos en la historia, en la que se presentaron ejemplos de mujeres que han contribuido de manera significativa en ámbitos como la ciencia, la educación, la cultura o el activismo social. La actividad tuvo como objetivo visibilizar figuras que con frecuencia han sido olvidadas en los relatos históricos tradicionales.\r\n\r\nEl mes concluyó con una proyección de documental seguida de un coloquio, donde las participantes pudieron debatir sobre los temas tratados y compartir diferentes puntos de vista. Este espacio final permitió reforzar el aprendizaje colectivo y cerrar el ciclo de actividades con una reflexión conjunta.\r\n\r\nEn conjunto, las actividades realizadas durante el mes de enero tuvieron una buena acogida por parte de las participantes y contribuyeron a generar espacios de encuentro, aprendizaje y participación en torno a la igualdad y los derechos de las mujeres.', NULL, 'LA CASA', 0, 0),
(6, 'Febrero 2026 - EJEMPLO', '2026-01-31 23:00:00', 'Durante el mes de febrero se continuó con la programación de actividades orientadas a promover la igualdad de género, el pensamiento crítico y la participación activa de las mujeres en el ámbito social y comunitario. Las propuestas desarrolladas durante este mes buscaron consolidar los espacios de encuentro creados anteriormente y ampliar la participación de nuevas asistentes.\r\n\r\nA comienzos de mes se realizó un taller sobre corresponsabilidad y reparto de cuidados, en el que se reflexionó sobre la importancia de visibilizar el trabajo doméstico y de cuidados, así como la necesidad de avanzar hacia un reparto más equitativo de estas tareas. A través de dinámicas participativas, las asistentes pudieron compartir experiencias personales y debatir sobre posibles cambios en la vida cotidiana.\r\n\r\nOtra de las actividades destacadas fue un encuentro de lectura y debate feminista, en el que se comentaron textos breves relacionados con la igualdad, los derechos de las mujeres y los desafíos actuales del movimiento feminista. La actividad permitió fomentar la reflexión colectiva y generar un espacio de intercambio de ideas en un ambiente cercano y respetuoso.\r\n\r\nDurante el mes también se llevó a cabo un taller de autodefensa feminista, enfocado no solo en técnicas básicas de autoprotección física, sino también en el fortalecimiento de la confianza personal, la identificación de situaciones de riesgo y el desarrollo de estrategias para afrontarlas. La actividad tuvo una buena participación y generó un espacio de aprendizaje práctico y empoderador.\r\n\r\nAdemás, se organizó una mesa de diálogo sobre mujeres y participación social, donde se abordó el papel de las mujeres en los movimientos vecinales, asociaciones y colectivos del entorno. Las participantes compartieron experiencias y reflexionaron sobre la importancia de la organización colectiva para impulsar cambios sociales.\r\n\r\nPara cerrar el mes, se realizó una actividad creativa de elaboración de murales colaborativos, en la que las participantes trabajaron conjuntamente en la creación de un mural con mensajes relacionados con la igualdad, la sororidad y la lucha contra las violencias machistas. Esta actividad permitió combinar expresión artística y trabajo colectivo, reforzando el sentimiento de comunidad entre las asistentes.\r\n\r\nEn conjunto, las actividades desarrolladas durante el mes de febrero contribuyeron a fortalecer los espacios de participación, aprendizaje y apoyo mutuo entre mujeres, consolidando el proyecto como un punto de encuentro activo para la reflexión y la acción feminista.', NULL, 'LA CASA', 0, 0);

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
-- Volcado de datos para la tabla `registro_feminicidios`
--

INSERT INTO `registro_feminicidios` (`id`, `nombre`, `fecha_registro`, `tipo_victima`, `fecha_creacion`) VALUES
(1, 'Pilar', '2026-01-04', 'mayor', '2026-03-25 13:55:26'),
(2, NULL, '2026-01-05', 'mayor', '2026-03-25 13:55:26'),
(3, 'María Isabel', '2026-01-11', 'mayor', '2026-03-25 13:55:26'),
(4, 'María del Carmen', '2026-01-12', 'mayor', '2026-03-25 13:55:26'),
(5, NULL, '2026-01-17', 'mayor', '2026-03-25 13:55:26'),
(6, NULL, '2026-01-24', 'mayor', '2026-03-25 13:55:26'),
(7, NULL, '2026-01-26', 'mayor', '2026-03-25 13:55:26'),
(8, 'María Belén', '2026-02-01', 'mayor', '2026-03-25 13:55:26'),
(9, 'Ana María', '2026-02-16', 'mayor', '2026-03-25 13:55:26'),
(10, 'María José', '2026-02-17', 'mayor', '2026-03-25 13:55:26'),
(11, NULL, '2026-02-18', 'mayor', '2026-03-25 13:55:26'),
(12, 'Tatiana', '2026-02-20', 'mayor', '2026-03-25 13:55:26'),
(13, 'Mercedes', '2026-03-14', 'mayor', '2026-03-25 13:55:26'),
(14, 'Silvia', '2026-03-21', 'mayor', '2026-03-25 13:55:26'),
(15, NULL, '2026-01-24', 'menor', '2026-03-25 13:55:26'),
(16, NULL, '2026-02-17', 'menor', '2026-03-25 13:55:26'),
(17, NULL, '2026-03-23', 'menor', '2026-03-25 13:55:26');

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
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `comentaristas`
--
ALTER TABLE `comentaristas`
  MODIFY `idDispositivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `imagenes_memorias`
--
ALTER TABLE `imagenes_memorias`
  MODIFY `idImagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `memorias`
--
ALTER TABLE `memorias`
  MODIFY `idMemoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `registro_feminicidios`
--
ALTER TABLE `registro_feminicidios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
