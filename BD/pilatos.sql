-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-09-2025 a las 22:39:14
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
(14, 6110400, 'danielsaizaraque@gmail.com', 'DANIEL FERNANDO SAIZ ARAQUE', '3045605664', 'img/fotos/est_6110400_1756209381.jpg', '2025-08-26 11:56:21'),
(15, 3333, 'juan@gmail.com', 'JUAN MARAVILLA', '3132334556', 'img/fotos/est_3333_1756934685.png', '2025-09-03 21:24:45');

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

--
-- Volcado de datos para la tabla `hombre`
--

INSERT INTO `hombre` (`id_hombre`, `cod_hombre`, `img_hombre_1`, `img_hombre_2`, `img_hombre_3`, `img_hombre_4`, `nom_produc_hombre`, `descripcion_hombre`, `precio_hombre`, `fecha_creacion`) VALUES
(7, 1, 'img/fotos/hom_1_450da57d.webp', 'img/fotos/hom_1_e44b35e9.webp', 'img/fotos/hom_1_a5012f68.webp', 'img/fotos/hom_1_8d37047f.webp', 'Jean', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada.', '$30.00', '2025-09-07 19:34:04'),
(8, 2, 'img/fotos/hom_2_133d5d1e.webp', 'img/fotos/hom_2_67944e23.webp', 'img/fotos/hom_2_5230d74d.webp', 'img/fotos/hom_2_9a00a80f.webp', 'Polo', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada.', '$30.00', '2025-09-07 19:40:42'),
(9, 3, 'img/fotos/hom_3_0bba99eb.webp', 'img/fotos/hom_3_7abefbd6.webp', 'img/fotos/hom_3_2704893e.webp', 'img/fotos/hom_3_248223e7.webp', 'Pantalon', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada.', '$30.00', '2025-09-07 19:42:09'),
(10, 4, 'img/fotos/hom_4_5f09dcd8.webp', 'img/fotos/hom_4_64daa618.webp', 'img/fotos/hom_4_85887d69.webp', 'img/fotos/hom_4_c2175e5b.webp', 'Gorra', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada', '$30.00', '2025-09-07 19:46:18'),
(11, 5, 'img/fotos/hom_5_7577ef12.webp', 'img/fotos/hom_5_3fb349d2.webp', 'img/fotos/hom_5_6156f0cb.webp', 'img/fotos/hom_5_9e84e1d8.webp', 'Jean', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada.', '$30.00', '2025-09-07 19:48:01'),
(13, 6, 'img/fotos/hom_6_b2055631.webp', 'img/fotos/hom_6_692f88df.webp', 'img/fotos/hom_6_f20a9aa9.webp', 'img/fotos/hom_6_144d480f.webp', 'Polo', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada.', '$30.00', '2025-09-07 19:58:50'),
(14, 7, 'img/fotos/hom_7_283ece4f.webp', 'img/fotos/hom_7_d81c91f8.webp', 'img/fotos/hom_7_a273dbb2.webp', 'img/fotos/hom_7_3561b383.webp', 'Gorra', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada.', '$30.00', '2025-09-07 20:00:38'),
(15, 8, 'img/fotos/hom_8_7cf31256.webp', 'img/fotos/hom_8_bc5c54ea.webp', 'img/fotos/hom_8_acb93e51.webp', 'img/fotos/hom_8_c2db1ac1.webp', 'Pantalon', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada.', '$30.00', '2025-09-07 20:02:07'),
(16, 9, 'img/fotos/hom_9_fb5b376b.webp', 'img/fotos/hom_9_da0e5473.webp', 'img/fotos/hom_9_b1b69769.webp', 'img/fotos/hom_9_4272a419.webp', 'Pantalon', 'Descripción breve del producto 1. Diseño atractivo y funcionalidad garantizada.', '$30.00', '2025-09-07 20:13:27');

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
(3, 'caballerooliveroskevininem@gmail.com', 'caballero12345'),
(4, 'lauris.srp2009@gmail.com', 'laura12345+*'),
(5, 'hostingdelfin.alber@gmail.com', '123456');

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
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `hombre`
--
ALTER TABLE `hombre`
  MODIFY `id_hombre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `registro_sale`
--
ALTER TABLE `registro_sale`
  MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sesion`
--
ALTER TABLE `sesion`
  MODIFY `id_sesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
