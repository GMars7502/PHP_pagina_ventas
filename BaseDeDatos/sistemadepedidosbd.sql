-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sistemapedidos
CREATE DATABASE IF NOT EXISTS `sistemapedidos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sistemapedidos`;

-- Volcando estructura para tabla sistemapedidos.detalles_pedidos
CREATE TABLE IF NOT EXISTS `detalles_pedidos` (
  `idDetalle` int NOT NULL AUTO_INCREMENT,
  `fkPedido` int NOT NULL,
  `fkProducto` int NOT NULL,
  `Cantidad` int DEFAULT NULL,
  PRIMARY KEY (`idDetalle`),
  KEY `FK_detalles_pedidos_pedidos` (`fkPedido`),
  KEY `FK_detalles_pedidos_productos` (`fkProducto`),
  CONSTRAINT `FK_detalles_pedidos_pedidos` FOREIGN KEY (`fkPedido`) REFERENCES `pedidos` (`idPedido`),
  CONSTRAINT `FK_detalles_pedidos_productos` FOREIGN KEY (`fkProducto`) REFERENCES `productos` (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemapedidos.detalles_pedidos: ~5 rows (aproximadamente)
INSERT INTO `detalles_pedidos` (`idDetalle`, `fkPedido`, `fkProducto`, `Cantidad`) VALUES
	(3, 3, 6, 1),
	(4, 4, 7, 10),
	(5, 5, 5, 1),
	(6, 6, 7, 2),
	(7, 7, 5, 1);

-- Volcando estructura para tabla sistemapedidos.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `idPedido` int NOT NULL AUTO_INCREMENT,
  `fkUsuarios` int NOT NULL,
  `Fecha_pedido` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('ENVIADO','ENTREGADO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ENVIADO',
  PRIMARY KEY (`idPedido`),
  KEY `FK_pedidos_usuarios` (`fkUsuarios`),
  CONSTRAINT `FK_pedidos_usuarios` FOREIGN KEY (`fkUsuarios`) REFERENCES `usuarios` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemapedidos.pedidos: ~5 rows (aproximadamente)
INSERT INTO `pedidos` (`idPedido`, `fkUsuarios`, `Fecha_pedido`, `Estado`) VALUES
	(3, 6, '2024-03-10 18:29:00', 'ENVIADO'),
	(4, 6, '2024-03-10 18:29:25', 'ENVIADO'),
	(5, 4, '2024-03-10 18:29:33', 'ENVIADO'),
	(6, 4, '2024-03-10 18:29:41', 'ENTREGADO'),
	(7, 5, '2024-03-10 18:29:49', 'ENVIADO');

-- Volcando estructura para tabla sistemapedidos.perfiles
CREATE TABLE IF NOT EXISTS `perfiles` (
  `idPerfil` int NOT NULL AUTO_INCREMENT,
  `fkUsuario` int NOT NULL,
  `Direccion` varchar(500) DEFAULT NULL,
  `Telefono` int DEFAULT NULL,
  PRIMARY KEY (`idPerfil`),
  KEY `FK_perfiles_usuarios` (`fkUsuario`),
  CONSTRAINT `FK_perfiles_usuarios` FOREIGN KEY (`fkUsuario`) REFERENCES `usuarios` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemapedidos.perfiles: ~3 rows (aproximadamente)
INSERT INTO `perfiles` (`idPerfil`, `fkUsuario`, `Direccion`, `Telefono`) VALUES
	(3, 6, 'dos de mayo', 992728615),
	(4, 5, '4 de julio', 987123456),
	(5, 4, '3 de julio', 1234);

-- Volcando estructura para tabla sistemapedidos.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `idProducto` int NOT NULL AUTO_INCREMENT,
  `Nombre_Producto` varchar(50) NOT NULL,
  `Descripcion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Precio` decimal(20,6) NOT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemapedidos.productos: ~4 rows (aproximadamente)
INSERT INTO `productos` (`idProducto`, `Nombre_Producto`, `Descripcion`, `Precio`) VALUES
	(5, 'polvo', 'algodepolvo', 6.000000),
	(6, 'leche', 'LIQUIDO BLANCO', 7.000000),
	(7, 'yogurt', 'LIQUIDO BLANCO', 8.000000),
	(8, 'zanahoria', 'hola peter', 9.000000);

-- Volcando estructura para tabla sistemapedidos.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idCliente` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `password` varchar(2555) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`idCliente`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemapedidos.usuarios: ~3 rows (aproximadamente)
INSERT INTO `usuarios` (`idCliente`, `Nombre`, `Apellido`, `Correo`, `password`) VALUES
	(4, 'ttttt', '000000', 'viergn@gmail.com', '$2y$10$xXSc/OW44yQsef9FLxLcZO272qBcwJtz8qHjDu55xTap.ePSMizma'),
	(5, 'Kristina', 'Fernandez', 'kristin@gmail.com', '123456'),
	(6, 'fernando', 'hernandez', 'viergn@gmail.com', '123456');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
