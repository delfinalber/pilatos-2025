-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2025 a las 15:49:04
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

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
-- Estructura de tabla para la tabla `registro_sale`
--

CREATE TABLE `registro_sale` (
  `id_sale` int(11) NOT NULL,
  `nombre_sale` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido_sale` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `edad_sale` int(2) NOT NULL,
  `telefono_sale` bigint(12) NOT NULL,
  `email_sale` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_sale` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `password_sale` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `registro_sale`
--
ALTER TABLE `registro_sale`
  ADD PRIMARY KEY (`id_sale`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `registro_sale`
--
ALTER TABLE `registro_sale`
  MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
