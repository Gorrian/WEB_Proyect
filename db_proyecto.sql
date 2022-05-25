-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-05-2022 a las 15:55:25
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_proyecto`
--

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `admin_panel`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `admin_panel`;
CREATE TABLE IF NOT EXISTS `admin_panel` (
`DNI` varchar(9)
,`Nombre completo` varchar(50)
,`Departamento` varchar(45)
,`Telefono` varchar(13)
,`C. electronico` varchar(45)
,`Localidad` varchar(50)
,`Change password` tinyint(1)
,`Disabled` tinyint(1)
,`Admin` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaran`
--

DROP TABLE IF EXISTS `albaran`;
CREATE TABLE IF NOT EXISTS `albaran` (
  `ID.Albaran` int(11) NOT NULL,
  `ID_Objeto` int(11) NOT NULL,
  `ID provedor` varchar(9) COLLATE utf16_spanish_ci NOT NULL,
  `Precio` varchar(10) COLLATE utf16_spanish_ci NOT NULL,
  `Fecha adquisicion` datetime NOT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`ID.Albaran`),
  KEY `IDComponentes_idx` (`ID_Objeto`),
  KEY `ID provedor/NIF_idx` (`ID provedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `NIF/CIF` varchar(9) COLLATE utf16_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf16_spanish_ci NOT NULL,
  `C.electronico` varchar(45) COLLATE utf16_spanish_ci DEFAULT NULL,
  `Telefono` varchar(13) COLLATE utf16_spanish_ci DEFAULT NULL,
  `Localidad` varchar(75) COLLATE utf16_spanish_ci DEFAULT NULL,
  `Password` varchar(80) COLLATE utf16_spanish_ci NOT NULL,
  PRIMARY KEY (`NIF/CIF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`NIF/CIF`, `Nombre`, `C.electronico`, `Telefono`, `Localidad`, `Password`) VALUES
('11111111A', 's', NULL, NULL, NULL, '*FCA02337EEB51C3EE398B473FD9A9AFD093F9E64'),
('A11111111', 'Someone', NULL, NULL, NULL, '*BF0F994755B3F6D7D87DD27775B94B0BFCE6F48F'),
('A11111112', 'Someone', NULL, NULL, NULL, '*BF0F994755B3F6D7D87DD27775B94B0BFCE6F48F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp.enviados`
--

DROP TABLE IF EXISTS `comp.enviados`;
CREATE TABLE IF NOT EXISTS `comp.enviados` (
  `ID` int(11) NOT NULL,
  `ID_pedido` int(11) NOT NULL,
  `ID producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID.pedido_idx` (`ID_pedido`),
  KEY `IDComponentes_idx` (`ID producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

DROP TABLE IF EXISTS `componentes`;
CREATE TABLE IF NOT EXISTS `componentes` (
  `IDComponentes` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf16_spanish_ci NOT NULL,
  `ID_prod_tipo` int(11) NOT NULL,
  `Stock` int(11) NOT NULL,
  PRIMARY KEY (`IDComponentes`),
  KEY `ID prod tipo_idx` (`ID_prod_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

DROP TABLE IF EXISTS `departamento`;
CREATE TABLE IF NOT EXISTS `departamento` (
  `ID_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf16_spanish_ci NOT NULL,
  PRIMARY KEY (`ID_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`ID_departamento`, `Nombre`) VALUES
(1, 'Direccion'),
(2, 'Ciberseguridad'),
(3, 'RRHH');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `ID.pedido` int(11) NOT NULL AUTO_INCREMENT,
  `ID.cliente` varchar(9) COLLATE utf16_spanish_ci NOT NULL,
  `Fecha de peticion` datetime NOT NULL,
  `Localizacion` varchar(75) COLLATE utf16_spanish_ci NOT NULL,
  `C.electronico` varchar(45) COLLATE utf16_spanish_ci DEFAULT NULL,
  `Telefono` varchar(13) COLLATE utf16_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ID.pedido`),
  KEY `NIF/CIF_idx` (`ID.cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`ID.pedido`, `ID.cliente`, `Fecha de peticion`, `Localizacion`, `C.electronico`, `Telefono`) VALUES
(3, '11111111A', '2022-05-25 10:42:37', 'dfsf', 'sdffdsf', 'dfsfdsf'),
(4, '11111111A', '2022-05-25 11:12:24', 'Somewhere', 'Somewhere@somewhere.com', '665111222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedor`
--

DROP TABLE IF EXISTS `provedor`;
CREATE TABLE IF NOT EXISTS `provedor` (
  `ID provedor/NIF` varchar(9) COLLATE utf16_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf16_spanish_ci NOT NULL,
  `Telefono` varchar(13) COLLATE utf16_spanish_ci DEFAULT NULL,
  `Localidad` varchar(50) COLLATE utf16_spanish_ci DEFAULT NULL,
  `Correo electronico` varchar(45) COLLATE utf16_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ID provedor/NIF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

DROP TABLE IF EXISTS `provincias`;
CREATE TABLE IF NOT EXISTS `provincias` (
  `id_provincia` smallint(6) NOT NULL AUTO_INCREMENT,
  `provincia` varchar(30) COLLATE utf16_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id_provincia`, `provincia`) VALUES
(1, 'Albacete'),
(2, 'Alicante/Alacant'),
(3, 'Almería'),
(4, 'Araba/Álava'),
(5, 'Asturias'),
(6, 'Ávila'),
(7, 'Badajoz'),
(8, 'Balears, Illes'),
(9, 'Barcelona'),
(10, 'Bizkaia'),
(11, 'Burgos'),
(12, 'Cáceres'),
(13, 'Cádiz'),
(14, 'Cantabria'),
(15, 'Castellón/Castelló'),
(16, 'Ceuta'),
(17, 'Ciudad Real'),
(18, 'Córdoba'),
(19, 'Coruña, A'),
(20, 'Cuenca'),
(21, 'Gipuzkoa'),
(22, 'Girona'),
(23, 'Granada'),
(24, 'Guadalajara'),
(25, 'Huelva'),
(26, 'Huesca'),
(27, 'Jaén'),
(28, 'León'),
(29, 'Lugo'),
(30, 'Lleida'),
(31, 'Madrid'),
(32, 'Málaga'),
(33, 'Melilla'),
(34, 'Murcia'),
(35, 'Navarra'),
(36, 'Ourense'),
(37, 'Palencia'),
(38, 'Palmas, Las'),
(39, 'Pontevedra'),
(40, 'Rioja, La'),
(41, 'Salamanca'),
(42, 'Santa Cruz de Tenerife'),
(43, 'Segovia'),
(44, 'Sevilla'),
(45, 'Soria'),
(46, 'Tarragona'),
(47, 'Teruel'),
(48, 'Toledo'),
(49, 'Valencia/València'),
(50, 'Valladolid'),
(51, 'Zamora'),
(52, 'Zaragoza'),
(53, 'Badalona');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

DROP TABLE IF EXISTS `responsables`;
CREATE TABLE IF NOT EXISTS `responsables` (
  `ID` int(11) NOT NULL,
  `ID encargo` int(11) NOT NULL,
  `ID.trabajador` varchar(9) COLLATE utf16_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID.pedido_idx` (`ID encargo`),
  KEY `DNI_idx` (`ID.trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios-asignados`
--

DROP TABLE IF EXISTS `servicios-asignados`;
CREATE TABLE IF NOT EXISTS `servicios-asignados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID.Servicio` int(11) NOT NULL,
  `ID.Pedido` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID.pedido_idx` (`ID.Pedido`),
  KEY `ID_idx` (`ID.Servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `servicios-asignados`
--

INSERT INTO `servicios-asignados` (`ID`, `ID.Servicio`, `ID.Pedido`) VALUES
(1, 1, 3),
(2, 2, 3),
(3, 3, 3),
(4, 1, 4),
(5, 2, 4),
(6, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t.servicio`
--

DROP TABLE IF EXISTS `t.servicio`;
CREATE TABLE IF NOT EXISTS `t.servicio` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom.servicio` varchar(45) COLLATE utf16_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `t.servicio`
--

INSERT INTO `t.servicio` (`ID`, `Nom.servicio`) VALUES
(1, 'Ciberseguridad'),
(2, 'Implementacion web'),
(3, 'Mantenimiento de equipos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo producto`
--

DROP TABLE IF EXISTS `tipo producto`;
CREATE TABLE IF NOT EXISTS `tipo producto` (
  `ID prod tipo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf16_spanish_ci NOT NULL,
  PRIMARY KEY (`ID prod tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

DROP TABLE IF EXISTS `trabajadores`;
CREATE TABLE IF NOT EXISTS `trabajadores` (
  `DNI` varchar(9) COLLATE utf16_spanish_ci NOT NULL,
  `Nombre completo` varchar(50) COLLATE utf16_spanish_ci NOT NULL,
  `ID departamento` int(11) NOT NULL,
  `Telefono` varchar(13) COLLATE utf16_spanish_ci DEFAULT NULL,
  `C. electronico` varchar(45) COLLATE utf16_spanish_ci DEFAULT NULL,
  `Localidad` varchar(50) COLLATE utf16_spanish_ci DEFAULT NULL,
  `Password` varchar(80) COLLATE utf16_spanish_ci NOT NULL,
  `Change_password` tinyint(1) NOT NULL DEFAULT '1',
  `Disabled` tinyint(1) NOT NULL DEFAULT '1',
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`DNI`),
  KEY `ID departamento_idx` (`ID departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`DNI`, `Nombre completo`, `ID departamento`, `Telefono`, `C. electronico`, `Localidad`, `Password`, `Change_password`, `Disabled`, `Admin`) VALUES
('11111111A', 'Marcos Gorriaran', 1, '+34665123123', 'gorriansan@hotmail.com', 'Badalona', '*4E169FE095B7E4A7A4EB05AAE294B5A17EB8FBF0', 0, 0, 1),
('11111112A', 'Sergi Martinez', 1, '+34665123122', 'Sergi@petits.com', 'Huelva', '*4E169FE095B7E4A7A4EB05AAE294B5A17EB8FBF0', 0, 0, 1),
('11111112G', 'AnotherWorker', 3, '+34665123123', 'Someone@hotmail.com', 'Barcelona', '*FCA02337EEB51C3EE398B473FD9A9AFD093F9E64', 1, 1, 0),
('12345678G', 'Worker the Worker', 2, '+34665123123', 'Worker@hotmail.com', 'Alicante/Alacant', '*4E169FE095B7E4A7A4EB05AAE294B5A17EB8FBF0', 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura para la vista `admin_panel`
--
DROP TABLE IF EXISTS `admin_panel`;

DROP VIEW IF EXISTS `admin_panel`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `admin_panel`  AS  select `t`.`DNI` AS `DNI`,`t`.`Nombre completo` AS `Nombre completo`,`d`.`Nombre` AS `Departamento`,`t`.`Telefono` AS `Telefono`,`t`.`C. electronico` AS `C. electronico`,`t`.`Localidad` AS `Localidad`,`t`.`Change_password` AS `Change password`,`t`.`Disabled` AS `Disabled`,`t`.`Admin` AS `Admin` from (`trabajadores` `t` join `departamento` `d` on((`t`.`ID departamento` = `d`.`ID_departamento`))) ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albaran`
--
ALTER TABLE `albaran`
  ADD CONSTRAINT `Trans4.Componentes` FOREIGN KEY (`ID_Objeto`) REFERENCES `componentes` (`IDComponentes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Trans4.Provedor` FOREIGN KEY (`ID provedor`) REFERENCES `provedor` (`ID provedor/NIF`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comp.enviados`
--
ALTER TABLE `comp.enviados`
  ADD CONSTRAINT `Trans3.Componentes` FOREIGN KEY (`ID producto`) REFERENCES `componentes` (`IDComponentes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Trans3.Pedido` FOREIGN KEY (`ID_pedido`) REFERENCES `pedidos` (`ID.pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD CONSTRAINT `TipoProducto` FOREIGN KEY (`ID_prod_tipo`) REFERENCES `tipo producto` (`ID prod tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `Clientes` FOREIGN KEY (`ID.cliente`) REFERENCES `clientes` (`NIF/CIF`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD CONSTRAINT `Trans.Pedido` FOREIGN KEY (`ID encargo`) REFERENCES `pedidos` (`ID.pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Trans.Trabajador` FOREIGN KEY (`ID.trabajador`) REFERENCES `trabajadores` (`DNI`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `servicios-asignados`
--
ALTER TABLE `servicios-asignados`
  ADD CONSTRAINT `Trans2.Pedido` FOREIGN KEY (`ID.Pedido`) REFERENCES `pedidos` (`ID.pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Trans2.T_servicio` FOREIGN KEY (`ID.Servicio`) REFERENCES `t.servicio` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD CONSTRAINT `ID departamento` FOREIGN KEY (`ID departamento`) REFERENCES `departamento` (`ID_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
