-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2025 a las 22:20:21
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
(7, 2147483647, 'oscarcordoba@gmail.com', 'OSCAR JAVIER CORDOBA MUÑOZ', '312098763', 'img/fotos/est_2147483647_1756749767.jpg', '2025-08-10 22:28:12'),
(9, 1079177484, 'paulasofia08@gmail.com', 'PAULA SOFIA CLAROS NAÑEZ', '3108344128', 'img/fotos/est_1079177484_1755000722.jpg', '2025-08-12 12:12:02'),
(11, 1133313051, 'ramirezfierro34@gmail.com', 'SAMUEL SANTIAGO RAMIREZ FIERRO', '3203150231', 'img/fotos/est_1133313051_1755010278.png', '2025-08-12 14:51:18'),
(12, 1079175634, 'casanovaortizdaniela@gmail.com', 'DANIELA CASANOCA', '3114203191', 'img/fotos/est_1079175634_1755011702.png', '2025-08-12 14:56:00'),
(13, 1077228780, 'tomas@gmail.com', 'TOMAS BARRERA ORTIOZ', '3144514465', 'img/fotos/est_1077228780_1755110443.png', '2025-08-13 18:39:44'),
(14, 6110400, 'danielsaizaraque@gmail.com', 'DANIEL FERNANDO SAIZ ARAQUE', '3045605664', 'img/fotos/est_6110400_1756209381.jpg', '2025-08-26 11:56:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hombre`
--

CREATE TABLE `hombre` (
  `id_hombre` int(11) NOT NULL,
  `cod_hombre` int(3) NOT NULL,
  `img_hombre_1` varchar(200) NOT NULL,
  `img_hombre_2` varchar(200) NOT NULL,
  `img_hombre_3` varchar(200) NOT NULL,
  `img_hombre_4` varchar(200) NOT NULL,
  `nom_produc_hombre` varchar(100) NOT NULL,
  `descripcion_hombre` varchar(300) NOT NULL,
  `precio_hombre` varchar(6) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
-- Indices de la tabla `hombre`
--
ALTER TABLE `hombre`
  ADD PRIMARY KEY (`id_hombre`),
  ADD KEY `cod_hombre` (`cod_hombre`);

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
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `hombre`
--
ALTER TABLE `hombre`
  MODIFY `id_hombre` int(11) NOT NULL AUTO_INCREMENT;

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
