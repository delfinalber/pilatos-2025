-- Crear tabla hombre para la base de datos pilatos
USE pilatos;

-- Crear tabla hombre
CREATE TABLE IF NOT EXISTS `hombre` (
  `id_hombre` int(11) NOT NULL AUTO_INCREMENT,
  `cod_hombre` int(11) NOT NULL,
  `img_hombre_1` varchar(150) DEFAULT NULL,
  `img_hombre_2` varchar(150) DEFAULT NULL,
  `img_hombre_3` varchar(150) DEFAULT NULL,
  `img_hombre_4` varchar(150) DEFAULT NULL,
  `nom_produc_hombre` varchar(100) NOT NULL,
  `descripcion_hombre` text NOT NULL,
  `precio_hombre` varchar(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_hombre`),
  UNIQUE KEY `cod_hombre` (`cod_hombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos datos de ejemplo
INSERT INTO `hombre` (`cod_hombre`, `nom_produc_hombre`, `descripcion_hombre`, `precio_hombre`) VALUES
(1001, 'Camiseta Básica', 'Camiseta de algodón 100% para hombre', '$45.000'),
(1002, 'Jeans Clásicos', 'Jeans azules de corte recto', '$89.000'),
(1003, 'Zapatos Deportivos', 'Tenis casual para uso diario', '$120.000');
