-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2025 a las 01:51:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pilatos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL,
  `cod_estudiante` int(11) NOT NULL,
  `email_estudiante` varchar(100) NOT NULL,
  `nom_estudiante` varchar(100) NOT NULL,
  `tel_estudiante` varchar(12) NOT NULL,
  `foto_estudiante` varchar(150) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `cod_estudiante`, `email_estudiante`, `nom_estudiante`, `tel_estudiante`, `foto_estudiante`, `fecha`) VALUES
(6, 12895432, 'juanignacio@gmail.com', 'Jose Ignacio Silva', '212334444', 'img/fotos/est_12895432_1754867600.png', '2025-08-10 22:11:21'),
(7, 2147483647, 'oscarcordoba@gmail.com', 'OSCAR JAVIER CORDOBA MUÑOZ', '312098765', 'img/fotos/est_4536782992_1754864892.jpeg', '2025-08-10 22:28:12'),
(8, 23456789, 'sandoval@gmail.com', 'SANTIAGO SANDINO SANDOVAL PASTRANA', '323456787', 'img/fotos/est_23456789_1754867466.png', '2025-08-10 22:47:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_sale`
--

CREATE TABLE `registro_sale` (
  `id_sale` int(11) NOT NULL,
  `nombre_sale` varchar(50) NOT NULL,
  `apellido_sale` varchar(50) NOT NULL,
  `edad_sale` int(2) NOT NULL,
  `telefono_sale` bigint(12) NOT NULL,
  `email_sale` varchar(100) NOT NULL,
  `usuario_sale` varchar(100) NOT NULL,
  `password_sale` varchar(50) NOT NULL,
  `date_sale` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `registro_sale`
--

INSERT INTO `registro_sale` (`id_sale`, `nombre_sale`, `apellido_sale`, `edad_sale`, `telefono_sale`, `email_sale`, `usuario_sale`, `password_sale`, `date_sale`) VALUES
(1, 'Kevin Santiago', 'Saavedra Chantris', 16, 3156515447, 'ksaavedrachantris@gmail.com', 'Kevin Saavedra', 'kevin123', '2025-05-21 20:53:07'),
(2, 'Juan David', 'Gomez Martinez', 17, 31454326787, 'juanixb015@gmail.com', 'Juan', '12345', '2025-05-21 22:08:00'),
(3, 'Juan David', 'Gomez Martinez', 17, 3145674310, 'juanixb015@gmail.com', 'Juana', '165234', '2025-05-21 22:08:35'),
(4, 'Laura ', 'Rojas', 16, 345768921, 'lauris@gmail.com', 'Lauris', 'lauris123', '2025-05-21 22:17:40'),
(5, 'TOAMSD', 'ASDA', 12, 123434523, 'ytoamsd@gml', '121212', '12', '2025-05-21 22:29:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

CREATE TABLE `sesion` (
  `id_sesion` int(11) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`id_sesion`, `usuario`, `password`) VALUES
(1, 'delfin.alber@gmail.com', 'delfin'),
(2, 'alberdelfintecnico@gmail.com', 'alber'),
(3, 'caballerooliveroskevininem@gmail.com', 'caballero12345');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD UNIQUE KEY `email_estudiante` (`email_estudiante`) USING BTREE,
  ADD KEY `cod_estudiante` (`cod_estudiante`);

--
-- Indices de la tabla `registro_sale`
--
ALTER TABLE `registro_sale`
  ADD PRIMARY KEY (`id_sale`);

--
-- Indices de la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD PRIMARY KEY (`id_sesion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `registro_sale`
--
ALTER TABLE `registro_sale`
  MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sesion`
--
ALTER TABLE `sesion`
  MODIFY `id_sesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
