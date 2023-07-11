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

-- Volcando estructura para tabla iotonrumbo.asignacion
CREATE TABLE IF NOT EXISTS `asignacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empleado_id` int DEFAULT NULL,
  `desde` timestamp NULL DEFAULT NULL,
  `hasta` timestamp NULL DEFAULT NULL,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `device_id` (`device_id`),
  KEY `empleado_id` (`empleado_id`),
  CONSTRAINT `asignacion_ibfk_2` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `asignacion_ibfk_3` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla iotonrumbo.asignacion: ~0 rows (aproximadamente)
INSERT INTO `asignacion` (`id`, `device_id`, `empleado_id`, `desde`, `hasta`, `estado`) VALUES
	(1, 'arduni_ec_1', 1, NULL, NULL, 1);

-- Volcando estructura para tabla iotonrumbo.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla iotonrumbo.cliente: ~1 rows (aproximadamente)
INSERT INTO `cliente` (`id`, `nombre`, `direccion`, `email`) VALUES
	(1, 'Cliente 1', 'Ibarra', NULL),
	(5, 'cliente 2', 'ibarra', 'yo@yo.com');

-- Volcando estructura para tabla iotonrumbo.device
CREATE TABLE IF NOT EXISTS `device` (
  `id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cliente_id` int DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ubicacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` int DEFAULT '1',
  `last_original_imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_procesada_imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_tracking` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `device_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla iotonrumbo.device: ~0 rows (aproximadamente)
INSERT INTO `device` (`id`, `cliente_id`, `nombre`, `ubicacion`, `estado`, `last_original_imagen`, `last_procesada_imagen`, `last_tracking`) VALUES
	('arduni_ec_1', 1, 'ARDUINO EC 1', 'AUTO 1', 1, NULL, NULL, NULL);

-- Volcando estructura para tabla iotonrumbo.empleado
CREATE TABLE IF NOT EXISTS `empleado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int DEFAULT NULL,
  `nombres` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla iotonrumbo.empleado: ~0 rows (aproximadamente)
INSERT INTO `empleado` (`id`, `cliente_id`, `nombres`, `apellidos`, `email`, `imagen`, `estado`) VALUES
	(1, 1, 'JUAN', 'PEREZ', NULL, NULL, '1');

-- Volcando estructura para tabla iotonrumbo.tracking
CREATE TABLE IF NOT EXISTS `tracking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asignacion_id` int DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `basepath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asignacion_id` (`asignacion_id`),
  CONSTRAINT `tracking_ibfk_2` FOREIGN KEY (`asignacion_id`) REFERENCES `asignacion` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla iotonrumbo.tracking: ~0 rows (aproximadamente)
INSERT INTO `tracking` (`id`, `asignacion_id`, `ip`, `fecha`, `basepath`, `imagename`) VALUES
	(115, 1, '192.168.200.17', '2023-05-16 21:45:57', 'arduni_ec_1/2023/05/16/16/45/', '20230516164557123987.jpg'),
	(116, 1, '192.168.200.17', '2023-05-16 21:45:57', 'arduni_ec_1/2023/05/16/16/45/', '20230516164557701221.jpg'),
	(117, 1, '192.168.200.17', '2023-05-16 21:45:58', 'arduni_ec_1/2023/05/16/16/45/', '20230516164558264544.jpg'),
	(118, 1, '192.168.200.17', '2023-05-16 21:45:58', 'arduni_ec_1/2023/05/16/16/45/', '20230516164558787045.jpg'),
	(119, 1, '192.168.200.17', '2023-05-16 21:46:00', 'arduni_ec_1/2023/05/16/16/46/', '20230516164600366249.jpg'),
	(120, 1, '192.168.200.17', '2023-05-16 21:46:00', 'arduni_ec_1/2023/05/16/16/46/', '20230516164600678187.jpg'),
	(121, 1, '192.168.200.17', '2023-05-16 21:46:01', 'arduni_ec_1/2023/05/16/16/46/', '20230516164601036750.jpg'),
	(122, 1, '192.168.200.17', '2023-05-16 21:46:01', 'arduni_ec_1/2023/05/16/16/46/', '20230516164601462237.jpg'),
	(123, 1, '192.168.200.17', '2023-05-16 21:46:02', 'arduni_ec_1/2023/05/16/16/46/', '20230516164602225293.jpg'),
	(124, 1, '192.168.200.17', '2023-05-16 21:46:02', 'arduni_ec_1/2023/05/16/16/46/', '20230516164602515892.jpg'),
	(125, 1, '192.168.200.17', '2023-05-16 21:46:02', 'arduni_ec_1/2023/05/16/16/46/', '20230516164602992737.jpg'),
	(126, 1, '192.168.200.17', '2023-05-16 21:46:03', 'arduni_ec_1/2023/05/16/16/46/', '20230516164603427886.jpg'),
	(127, 1, '192.168.200.17', '2023-05-16 21:46:03', 'arduni_ec_1/2023/05/16/16/46/', '20230516164603928959.jpg'),
	(128, 1, '192.168.200.17', '2023-05-16 21:46:04', 'arduni_ec_1/2023/05/16/16/46/', '20230516164604369310.jpg'),
	(129, 1, '192.168.200.17', '2023-05-16 21:46:04', 'arduni_ec_1/2023/05/16/16/46/', '20230516164604835057.jpg'),
	(130, 1, '192.168.200.17', '2023-05-16 21:46:05', 'arduni_ec_1/2023/05/16/16/46/', '20230516164605237329.jpg'),
	(131, 1, '192.168.200.17', '2023-05-16 21:46:05', 'arduni_ec_1/2023/05/16/16/46/', '20230516164605613068.jpg'),
	(132, 1, '192.168.200.17', '2023-05-16 21:46:06', 'arduni_ec_1/2023/05/16/16/46/', '20230516164606031296.jpg'),
	(133, 1, '192.168.200.17', '2023-05-16 21:46:06', 'arduni_ec_1/2023/05/16/16/46/', '20230516164606533520.jpg'),
	(134, 1, '192.168.200.17', '2023-05-16 21:46:07', 'arduni_ec_1/2023/05/16/16/46/', '20230516164607390969.jpg'),
	(135, 1, '192.168.200.17', '2023-05-16 21:46:08', 'arduni_ec_1/2023/05/16/16/46/', '20230516164608722347.jpg'),
	(136, 1, '192.168.200.17', '2023-05-16 21:46:09', 'arduni_ec_1/2023/05/16/16/46/', '20230516164609114583.jpg'),
	(137, 1, '192.168.200.17', '2023-05-16 21:46:09', 'arduni_ec_1/2023/05/16/16/46/', '20230516164609548835.jpg'),
	(138, 1, '192.168.200.17', '2023-05-16 21:46:10', 'arduni_ec_1/2023/05/16/16/46/', '20230516164610063073.jpg'),
	(139, 1, '192.168.200.17', '2023-05-16 21:46:10', 'arduni_ec_1/2023/05/16/16/46/', '20230516164610410091.jpg'),
	(140, 1, '192.168.200.17', '2023-05-16 21:46:10', 'arduni_ec_1/2023/05/16/16/46/', '20230516164610825653.jpg'),
	(141, 1, '192.168.200.17', '2023-05-16 21:46:11', 'arduni_ec_1/2023/05/16/16/46/', '20230516164611295418.jpg'),
	(142, 1, '192.168.200.17', '2023-05-16 21:46:11', 'arduni_ec_1/2023/05/16/16/46/', '20230516164611769685.jpg'),
	(143, 1, '192.168.200.17', '2023-05-16 21:46:12', 'arduni_ec_1/2023/05/16/16/46/', '20230516164612298698.jpg'),
	(144, 1, '192.168.200.17', '2023-05-16 21:46:12', 'arduni_ec_1/2023/05/16/16/46/', '20230516164612937000.jpg'),
	(145, 1, '192.168.200.17', '2023-05-16 21:46:13', 'arduni_ec_1/2023/05/16/16/46/', '20230516164613274556.jpg'),
	(146, 1, '192.168.200.17', '2023-05-16 21:46:13', 'arduni_ec_1/2023/05/16/16/46/', '20230516164613508580.jpg'),
	(147, 1, '192.168.200.17', '2023-05-16 21:46:13', 'arduni_ec_1/2023/05/16/16/46/', '20230516164613719528.jpg'),
	(148, 1, '192.168.200.17', '2023-05-16 21:46:13', 'arduni_ec_1/2023/05/16/16/46/', '20230516164613924382.jpg'),
	(149, 1, '192.168.200.17', '2023-05-16 21:46:14', 'arduni_ec_1/2023/05/16/16/46/', '20230516164614243469.jpg'),
	(150, 1, '192.168.200.17', '2023-05-16 21:46:14', 'arduni_ec_1/2023/05/16/16/46/', '20230516164614467403.jpg'),
	(151, 1, '192.168.200.17', '2023-05-16 21:46:14', 'arduni_ec_1/2023/05/16/16/46/', '20230516164614581761.jpg'),
	(152, 1, '192.168.200.17', '2023-05-16 21:46:14', 'arduni_ec_1/2023/05/16/16/46/', '20230516164614866638.jpg'),
	(153, 1, '192.168.200.17', '2023-05-16 21:46:15', 'arduni_ec_1/2023/05/16/16/46/', '20230516164615462360.jpg'),
	(154, 1, '192.168.200.17', '2023-05-16 21:46:15', 'arduni_ec_1/2023/05/16/16/46/', '20230516164615786862.jpg'),
	(155, 1, '192.168.200.17', '2023-05-16 21:46:16', 'arduni_ec_1/2023/05/16/16/46/', '20230516164616501047.jpg'),
	(156, 1, '192.168.200.17', '2023-05-16 21:46:17', 'arduni_ec_1/2023/05/16/16/46/', '20230516164617043129.jpg'),
	(157, 1, '192.168.200.17', '2023-05-16 21:46:17', 'arduni_ec_1/2023/05/16/16/46/', '20230516164617592784.jpg'),
	(158, 1, '192.168.200.17', '2023-05-16 21:46:17', 'arduni_ec_1/2023/05/16/16/46/', '20230516164617967139.jpg'),
	(159, 1, '192.168.200.17', '2023-05-16 21:46:18', 'arduni_ec_1/2023/05/16/16/46/', '20230516164618480859.jpg'),
	(160, 1, '192.168.200.17', '2023-05-16 21:46:18', 'arduni_ec_1/2023/05/16/16/46/', '20230516164618850889.jpg'),
	(161, 1, '192.168.200.17', '2023-05-16 21:46:19', 'arduni_ec_1/2023/05/16/16/46/', '20230516164619255026.jpg'),
	(162, 1, '192.168.200.17', '2023-05-16 21:46:19', 'arduni_ec_1/2023/05/16/16/46/', '20230516164619661510.jpg'),
	(163, 1, '192.168.200.17', '2023-05-16 21:46:20', 'arduni_ec_1/2023/05/16/16/46/', '20230516164620275839.jpg'),
	(164, 1, '192.168.200.17', '2023-05-16 21:46:20', 'arduni_ec_1/2023/05/16/16/46/', '20230516164620668248.jpg'),
	(165, 1, '192.168.200.17', '2023-05-16 21:46:21', 'arduni_ec_1/2023/05/16/16/46/', '20230516164621166444.jpg'),
	(166, 1, '192.168.200.17', '2023-05-16 21:46:21', 'arduni_ec_1/2023/05/16/16/46/', '20230516164621647840.jpg'),
	(167, 1, '192.168.200.17', '2023-05-16 21:46:22', 'arduni_ec_1/2023/05/16/16/46/', '20230516164622169635.jpg'),
	(168, 1, '192.168.200.17', '2023-05-16 21:46:22', 'arduni_ec_1/2023/05/16/16/46/', '20230516164622482634.jpg'),
	(169, 1, '192.168.200.17', '2023-05-16 21:46:23', 'arduni_ec_1/2023/05/16/16/46/', '20230516164623058954.jpg'),
	(170, 1, '192.168.200.17', '2023-05-16 21:46:24', 'arduni_ec_1/2023/05/16/16/46/', '20230516164624620303.jpg'),
	(171, 1, '192.168.200.17', '2023-05-16 21:46:25', 'arduni_ec_1/2023/05/16/16/46/', '20230516164625227515.jpg'),
	(172, 1, '192.168.200.17', '2023-05-16 21:46:25', 'arduni_ec_1/2023/05/16/16/46/', '20230516164625734354.jpg'),
	(173, 1, '192.168.200.17', '2023-05-16 21:46:26', 'arduni_ec_1/2023/05/16/16/46/', '20230516164626143363.jpg'),
	(174, 1, '192.168.200.17', '2023-05-16 21:46:26', 'arduni_ec_1/2023/05/16/16/46/', '20230516164626561502.jpg'),
	(175, 1, '192.168.200.17', '2023-05-16 21:46:27', 'arduni_ec_1/2023/05/16/16/46/', '20230516164627223637.jpg'),
	(176, 1, '192.168.200.17', '2023-05-16 21:46:27', 'arduni_ec_1/2023/05/16/16/46/', '20230516164627737125.jpg'),
	(177, 1, '192.168.200.17', '2023-05-16 21:46:28', 'arduni_ec_1/2023/05/16/16/46/', '20230516164628227964.jpg'),
	(178, 1, '192.168.200.17', '2023-05-16 21:46:28', 'arduni_ec_1/2023/05/16/16/46/', '20230516164628644608.jpg'),
	(179, 1, '192.168.200.17', '2023-05-16 21:46:28', 'arduni_ec_1/2023/05/16/16/46/', '20230516164628988814.jpg'),
	(180, 1, '192.168.200.17', '2023-05-16 21:46:29', 'arduni_ec_1/2023/05/16/16/46/', '20230516164629819719.jpg'),
	(181, 1, '192.168.200.17', '2023-05-16 21:46:30', 'arduni_ec_1/2023/05/16/16/46/', '20230516164630260791.jpg'),
	(182, 1, '192.168.200.17', '2023-05-16 21:46:30', 'arduni_ec_1/2023/05/16/16/46/', '20230516164630768128.jpg'),
	(183, 1, '192.168.200.17', '2023-05-16 21:46:31', 'arduni_ec_1/2023/05/16/16/46/', '20230516164631862339.jpg'),
	(184, 1, '192.168.200.17', '2023-05-16 21:46:32', 'arduni_ec_1/2023/05/16/16/46/', '20230516164632985101.jpg'),
	(185, 1, '192.168.200.17', '2023-05-16 21:46:33', 'arduni_ec_1/2023/05/16/16/46/', '20230516164633329792.jpg'),
	(186, 1, '192.168.200.17', '2023-05-16 21:46:33', 'arduni_ec_1/2023/05/16/16/46/', '20230516164633725091.jpg'),
	(187, 1, '192.168.200.17', '2023-05-16 21:46:34', 'arduni_ec_1/2023/05/16/16/46/', '20230516164634113865.jpg'),
	(188, 1, '192.168.200.17', '2023-05-16 21:47:58', 'arduni_ec_1/2023/05/16/16/47/', '20230516164758848186.jpg'),
	(189, 1, '192.168.200.17', '2023-05-16 21:47:59', 'arduni_ec_1/2023/05/16/16/47/', '20230516164759298612.jpg'),
	(190, 1, '192.168.200.17', '2023-05-16 21:47:59', 'arduni_ec_1/2023/05/16/16/47/', '20230516164759945514.jpg'),
	(191, 1, '192.168.200.17', '2023-05-16 21:48:00', 'arduni_ec_1/2023/05/16/16/48/', '20230516164800449938.jpg'),
	(192, 1, '192.168.200.17', '2023-05-16 21:48:00', 'arduni_ec_1/2023/05/16/16/48/', '20230516164800785379.jpg'),
	(193, 1, '192.168.200.17', '2023-05-16 21:48:01', 'arduni_ec_1/2023/05/16/16/48/', '20230516164801053609.jpg'),
	(194, 1, '192.168.200.17', '2023-05-16 21:48:01', 'arduni_ec_1/2023/05/16/16/48/', '20230516164801437900.jpg'),
	(195, 1, '192.168.200.17', '2023-05-16 21:48:01', 'arduni_ec_1/2023/05/16/16/48/', '20230516164801836947.jpg'),
	(196, 1, '192.168.200.17', '2023-05-16 21:48:02', 'arduni_ec_1/2023/05/16/16/48/', '20230516164802172030.jpg'),
	(197, 1, '192.168.200.17', '2023-05-16 21:48:02', 'arduni_ec_1/2023/05/16/16/48/', '20230516164802473409.jpg'),
	(198, 1, '192.168.200.17', '2023-05-16 21:48:03', 'arduni_ec_1/2023/05/16/16/48/', '20230516164803103354.jpg'),
	(199, 1, '192.168.200.17', '2023-05-16 21:48:03', 'arduni_ec_1/2023/05/16/16/48/', '20230516164803341610.jpg'),
	(200, 1, '192.168.200.17', '2023-05-16 21:48:03', 'arduni_ec_1/2023/05/16/16/48/', '20230516164803703514.jpg'),
	(201, 1, '192.168.200.17', '2023-05-16 21:48:04', 'arduni_ec_1/2023/05/16/16/48/', '20230516164804060938.jpg'),
	(202, 1, '192.168.200.17', '2023-05-16 21:48:04', 'arduni_ec_1/2023/05/16/16/48/', '20230516164804395338.jpg'),
	(203, 1, '192.168.200.17', '2023-05-16 21:48:04', 'arduni_ec_1/2023/05/16/16/48/', '20230516164804736131.jpg'),
	(204, 1, '192.168.200.17', '2023-05-16 21:48:05', 'arduni_ec_1/2023/05/16/16/48/', '20230516164805243294.jpg'),
	(205, 1, '192.168.200.17', '2023-05-16 21:48:05', 'arduni_ec_1/2023/05/16/16/48/', '20230516164805446831.jpg'),
	(206, 1, '192.168.200.17', '2023-05-16 21:48:05', 'arduni_ec_1/2023/05/16/16/48/', '20230516164805995528.jpg'),
	(207, 1, '192.168.200.17', '2023-05-16 21:48:06', 'arduni_ec_1/2023/05/16/16/48/', '20230516164806528877.jpg'),
	(208, 1, '192.168.200.17', '2023-05-16 21:48:07', 'arduni_ec_1/2023/05/16/16/48/', '20230516164807114568.jpg'),
	(209, 1, '192.168.200.17', '2023-05-16 21:48:07', 'arduni_ec_1/2023/05/16/16/48/', '20230516164807715315.jpg'),
	(210, 1, '192.168.200.17', '2023-05-16 21:48:08', 'arduni_ec_1/2023/05/16/16/48/', '20230516164808492593.jpg'),
	(211, 1, '192.168.200.17', '2023-05-16 21:48:08', 'arduni_ec_1/2023/05/16/16/48/', '20230516164808837622.jpg'),
	(212, 1, '192.168.200.17', '2023-05-16 21:48:09', 'arduni_ec_1/2023/05/16/16/48/', '20230516164809293875.jpg'),
	(213, 1, '192.168.200.17', '2023-05-16 21:48:09', 'arduni_ec_1/2023/05/16/16/48/', '20230516164809602256.jpg'),
	(214, 1, '192.168.200.17', '2023-05-16 21:48:09', 'arduni_ec_1/2023/05/16/16/48/', '20230516164809835490.jpg'),
	(215, 1, '192.168.200.17', '2023-05-16 21:48:10', 'arduni_ec_1/2023/05/16/16/48/', '20230516164810113757.jpg'),
	(216, 1, '192.168.200.17', '2023-05-16 21:48:10', 'arduni_ec_1/2023/05/16/16/48/', '20230516164810365298.jpg'),
	(217, 1, '192.168.200.17', '2023-05-16 21:48:10', 'arduni_ec_1/2023/05/16/16/48/', '20230516164810709983.jpg'),
	(218, 1, '192.168.200.17', '2023-05-16 21:48:10', 'arduni_ec_1/2023/05/16/16/48/', '20230516164810930952.jpg'),
	(219, 1, '192.168.200.17', '2023-05-16 21:48:11', 'arduni_ec_1/2023/05/16/16/48/', '20230516164811282669.jpg'),
	(220, 1, '192.168.200.17', '2023-05-16 21:48:11', 'arduni_ec_1/2023/05/16/16/48/', '20230516164811567367.jpg'),
	(221, 1, '192.168.200.17', '2023-05-16 21:48:11', 'arduni_ec_1/2023/05/16/16/48/', '20230516164811896766.jpg'),
	(222, 1, '192.168.200.17', '2023-05-16 21:48:12', 'arduni_ec_1/2023/05/16/16/48/', '20230516164812242265.jpg'),
	(223, 1, '192.168.200.17', '2023-05-16 21:48:12', 'arduni_ec_1/2023/05/16/16/48/', '20230516164812593813.jpg'),
	(224, 1, '192.168.200.17', '2023-05-16 21:48:12', 'arduni_ec_1/2023/05/16/16/48/', '20230516164812896950.jpg'),
	(225, 1, '192.168.200.17', '2023-05-16 21:48:13', 'arduni_ec_1/2023/05/16/16/48/', '20230516164813125913.jpg'),
	(226, 1, '192.168.200.17', '2023-05-16 21:48:13', 'arduni_ec_1/2023/05/16/16/48/', '20230516164813389510.jpg'),
	(227, 1, '192.168.200.17', '2023-05-16 21:48:13', 'arduni_ec_1/2023/05/16/16/48/', '20230516164813731723.jpg'),
	(228, 1, '192.168.200.17', '2023-05-16 21:48:13', 'arduni_ec_1/2023/05/16/16/48/', '20230516164813906115.jpg'),
	(229, 1, '192.168.200.17', '2023-05-16 21:48:14', 'arduni_ec_1/2023/05/16/16/48/', '20230516164814093305.jpg'),
	(230, 1, '192.168.200.17', '2023-05-16 21:48:14', 'arduni_ec_1/2023/05/16/16/48/', '20230516164814358422.jpg'),
	(231, 1, '192.168.200.17', '2023-05-16 21:48:14', 'arduni_ec_1/2023/05/16/16/48/', '20230516164814564118.jpg'),
	(232, 1, '192.168.200.17', '2023-05-16 21:48:14', 'arduni_ec_1/2023/05/16/16/48/', '20230516164814744061.jpg');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;