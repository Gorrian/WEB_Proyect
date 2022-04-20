-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-04-2022 a las 14:52:58
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
  `Localidad` varchar(75) COLLATE utf16_spanish_ci NOT NULL,
  PRIMARY KEY (`NIF/CIF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`ID_departamento`, `Nombre`) VALUES
(1, 'Direccion'),
(2, 'Ciberseguridad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `ID.pedido` int(11) NOT NULL AUTO_INCREMENT,
  `ID.cliente` varchar(9) COLLATE utf16_spanish_ci NOT NULL,
  `Fecha de peticion` datetime NOT NULL,
  PRIMARY KEY (`ID.pedido`),
  KEY `NIF/CIF_idx` (`ID.cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

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
  `ID` int(11) NOT NULL,
  `ID.Servicio` int(11) NOT NULL,
  `ID.Pedido` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID.pedido_idx` (`ID.Pedido`),
  KEY `ID_idx` (`ID.Servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t.servicio`
--

DROP TABLE IF EXISTS `t.servicio`;
CREATE TABLE IF NOT EXISTS `t.servicio` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom.servicio` varchar(45) COLLATE utf16_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

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
  PRIMARY KEY (`DNI`),
  KEY `ID departamento_idx` (`ID departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`DNI`, `Nombre completo`, `ID departamento`, `Telefono`, `C. electronico`, `Localidad`, `Password`, `Change_password`, `Disabled`) VALUES
('11111111A', 'Marcos Gorriaran', 1, '+34665123123', 'gorriansan@hotmail.com', 'Badalona', '*71F379143A5FA64F04D7022596DBB6B21CC4E6C5', 0, 0),
('11111112A', 'Sergi Martinez', 1, '+34665123122', 'Sergi@petits.com', 'Badalona', '*A86D8C82A6DA1B254232E8524E7C0DFC7CEEAEA5', 0, 0);

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
