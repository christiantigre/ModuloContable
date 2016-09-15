-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2016 a las 21:16:06
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `condata`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajustesejercicio`
--

CREATE TABLE `ajustesejercicio` (
  `idajustesejercicio` int(11) NOT NULL,
  `ejercicio` char(45) DEFAULT NULL,
  `cod_cuenta` char(45) DEFAULT NULL,
  `cuenta` char(45) DEFAULT NULL,
  `fecha` char(45) DEFAULT NULL,
  `valor` decimal(15,2) DEFAULT '0.00',
  `valorp` decimal(15,2) DEFAULT '0.00',
  `t_bl_inicial_idt_bl_inicial` int(11) DEFAULT NULL,
  `tipo` char(11) DEFAULT NULL,
  `logeo_idlogeo` int(11) DEFAULT NULL,
  `mes` char(45) NOT NULL,
  `year` char(45) NOT NULL,
  `num_asientos_ajustes_idnum_asientos_ajustes` int(11) NOT NULL,
  `t_ejercicio_idt_corrientes` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ajustesejercicio`
--

INSERT INTO `ajustesejercicio` (`idajustesejercicio`, `ejercicio`, `cod_cuenta`, `cuenta`, `fecha`, `valor`, `valorp`, `t_bl_inicial_idt_bl_inicial`, `tipo`, `logeo_idlogeo`, `mes`, `year`, `num_asientos_ajustes_idnum_asientos_ajustes`, `t_ejercicio_idt_corrientes`) VALUES
(1, ' 1', '1.1.1.1.', 'CAJAS', '2016-03-31', '1.00', '0.00', 1, '1.1.', 1, 'Marzo', '2016', 1, 1),
(2, ' 1', '1.1.1.2.', 'BANCOS', '2016-03-31', '0.00', '1.00', 1, '1.1.', 1, 'Marzo', '2016', 1, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `balance`
--
CREATE TABLE `balance` (
`t_bl_inicial_idt_bl_inicial` int(11)
,`ejercicio` char(45)
,`fecha_balance` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`valor` decimal(15,2)
,`valorp` decimal(15,2)
,`mes` char(45)
,`year` char(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idempresa` int(11) NOT NULL,
  `nombre` char(45) CHARACTER SET latin1 DEFAULT NULL,
  `direccion` char(45) CHARACTER SET latin1 DEFAULT NULL,
  `ruc` char(45) CHARACTER SET latin1 DEFAULT NULL,
  `email` char(45) CHARACTER SET latin1 DEFAULT NULL,
  `telefono` char(45) CHARACTER SET latin1 DEFAULT NULL,
  `fax` char(45) CHARACTER SET latin1 DEFAULT NULL,
  `propietario` char(45) CHARACTER SET latin1 DEFAULT NULL,
  `funcion` char(45) CHARACTER SET latin1 DEFAULT NULL,
  `logo` blob,
  `tipo` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `nomimg` char(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `nombre`, `direccion`, `ruc`, `email`, `telefono`, `fax`, `propietario`, `funcion`, `logo`, `tipo`, `nomimg`) VALUES
(1, 'Vadimir Enderica', 'Av. EspaÃƒÂ±a 10-50 y Elia Liut', '0000000000001', 'vladimirei@hotmail.com', '072806688 / 0998166265', '', 'Vladimir Enderica', 'Comisionista de Atomotores', 0x2e2e2f2e2e2f2e2e2f696d616765732f75706c6f6164732f6c6f676f2e706e67, 'image/png', 'logo.png');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `hoja_de_trabajo`
--
CREATE TABLE `hoja_de_trabajo` (
`fecha_aj` char(45)
,`cod_cuenta_aj` char(45)
,`cuenta_aj` char(45)
,`debe_aj` decimal(37,2)
,`haber_aj` decimal(37,2)
,`slddeudor_aj` varchar(40)
,`sldacreedor_aj` varchar(40)
,`grupo_aj` char(11)
,`year_aj` char(45)
,`mes_aj` char(45)
,`balance_aj` int(11)
,`fecha` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`debe` decimal(37,2)
,`haber` decimal(37,2)
,`t_bl_inicial_idt_bl_inicial` int(11)
,`tipo` char(45)
,`sld_deudor` varchar(40)
,`sld_acreedor` varchar(40)
,`year` char(45)
,`mes` char(45)
,`sum_deudor` double
,`sum_acreedor` double
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `idlibro` int(11) NOT NULL,
  `fecha` char(45) DEFAULT NULL,
  `asiento` char(45) DEFAULT NULL,
  `ref` char(45) DEFAULT NULL,
  `cuenta` char(45) DEFAULT NULL,
  `debe` decimal(15,2) DEFAULT NULL,
  `haber` decimal(15,2) DEFAULT NULL,
  `t_bl_inicial_idt_bl_inicial` int(11) NOT NULL,
  `t_cuenta_idt_cuenta` int(11) NOT NULL,
  `grupo` char(45) NOT NULL,
  `logeo_idlogeo` int(11) NOT NULL,
  `mes` char(45) NOT NULL,
  `year` char(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`idlibro`, `fecha`, `asiento`, `ref`, `cuenta`, `debe`, `haber`, `t_bl_inicial_idt_bl_inicial`, `t_cuenta_idt_cuenta`, `grupo`, `logeo_idlogeo`, `mes`, `year`) VALUES
(1, '2016-01-07', '2', '5.1.1.2.5.', 'Gastos x monitoreo y seguridad', '23.00', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(2, '2016-01-07', '2', '1.1.5.1.1.', 'Iva en Compras', '2.76', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(3, '2016-01-07', '2', '1.1.1.1.2.', 'Caja General', '0.00', '25.76', 1, 11, '1.1.', 0, 'Enero', '2016'),
(4, '2016-01-04', '3', '5.1.1.1.3.', 'Gastos x mantenimiento', '22.32', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(5, '2016-01-04', '3', '1.1.5.1.1.', 'Iva en Compras', '2.68', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(6, '2016-01-04', '3', '1.1.1.1.2.', 'Caja General', '0.00', '25.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(7, '2016-01-04', '4', '5.1.1.1.3.', 'Gastos x mantenimiento', '65.00', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(8, '2016-01-04', '4', '1.1.1.1.2.', 'Caja General', '0.00', '65.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(9, '2016-01-06', '5', '5.1.1.1.11.', 'Gastos x notaria', '7.32', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(10, '2016-01-06', '5', '1.1.5.1.1.', 'Iva en Compras', '0.88', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(11, '2016-01-06', '5', '1.1.1.1.2.', 'Caja General', '0.00', '8.20', 1, 11, '1.1.', 0, 'Enero', '2016'),
(12, '2016-01-06', '6', '5.1.1.1.11.', 'Gastos x notaria', '6.00', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(13, '2016-01-06', '6', '1.1.1.1.2.', 'Caja General', '0.00', '6.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(14, '2016-01-07', '7', '5.1.1.2.1.', 'Gastos x Arriendo', '1428.57', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(15, '2016-01-07', '7', '1.1.5.1.1.', 'Iva en Compras', '171.43', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(16, '2016-01-07', '7', '1.1.1.1.2.', 'Caja General', '0.00', '1600.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(17, '2016-01-07', '8', '5.1.1.1.1.', 'Gastos x combustible', '4.46', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(18, '2016-01-07', '8', '1.1.5.1.1.', 'Iva en Compras', '0.54', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(19, '2016-01-07', '8', '1.1.1.1.2.', 'Caja General', '0.00', '5.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(20, '2016-01-09', '9', '5.1.1.1.9.', 'Gastos x suministros de limpieza', '7.90', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(21, '2016-01-09', '9', '1.1.5.1.1.', 'Iva en Compras', '0.95', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(22, '2016-01-09', '9', '1.1.1.1.2.', 'Caja General', '0.00', '8.85', 1, 11, '1.1.', 0, 'Enero', '2016'),
(23, '2016-01-09', '10', '5.1.1.1.1.', 'Gastos x combustible', '4.46', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(24, '2016-01-09', '10', '1.1.5.1.1.', 'Iva en Compras', '0.54', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(25, '2016-01-09', '10', '1.1.1.1.2.', 'Caja General', '0.00', '5.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(26, '2016-01-11', '11', '5.1.1.1.3.', 'Gastos x mantenimiento', '280.00', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(27, '2016-01-11', '11', '1.1.1.1.2.', 'Caja General', '0.00', '280.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(28, '2016-01-11', '12', '5.1.1.1.3.', 'Gastos x mantenimiento', '220.00', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(29, '2016-01-11', '12', '1.1.1.1.2.', 'Caja General', '0.00', '220.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(30, '2016-01-11', '13', '5.1.1.1.1.', 'Gastos x combustible', '2.68', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(31, '2016-01-11', '13', '1.1.5.1.1.', 'Iva en Compras', '0.32', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(32, '2016-01-11', '13', '1.1.1.1.2.', 'Caja General', '0.00', '3.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(33, '2016-01-12', '14', '5.1.1.1.10.', 'Otros Gastos Operativos', '2.41', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(34, '2016-01-12', '14', '1.1.5.1.1.', 'Iva en Compras', '0.29', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(35, '2016-01-12', '14', '1.1.1.1.2.', 'Caja General', '0.00', '2.70', 1, 11, '1.1.', 0, 'Enero', '2016'),
(36, '2016-01-12', '15', '5.1.1.1.1.', 'Gastos x combustible', '4.46', '0.00', 1, 51, '5.1.', 1, 'Enero', '2016'),
(37, '2016-01-12', '15', '1.1.5.1.1.', 'Iva en Compras', '0.54', '0.00', 1, 11, '1.1.', 1, 'Enero', '2016'),
(38, '2016-01-12', '15', '1.1.1.1.1.', 'Caja Chica', '0.00', '5.00', 1, 11, '1.1.', 1, 'Enero', '2016'),
(39, '2016-01-12', '16', '5.1.1.1.1.', 'Gastos x combustible', '4.46', '0.00', 1, 51, '5.1.', 2, 'Enero', '2016'),
(40, '2016-01-12', '16', '1.1.5.1.1.', 'Iva en Compras', '0.54', '0.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(41, '2016-01-12', '16', '1.1.1.1.2.', 'Caja General', '0.00', '5.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(42, '2016-01-14', '17', '5.1.1.2.2.', 'Gastos x suministros de oficina', '33.93', '0.00', 1, 51, '5.1.', 2, 'Enero', '2016'),
(43, '2016-01-14', '17', '1.1.5.1.1.', 'Iva en Compras', '4.07', '0.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(44, '2016-01-14', '17', '1.1.1.1.2.', 'Caja General', '0.00', '38.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(45, '2016-01-14', '18', '5.1.1.1.1.', 'Gastos x combustible', '4.46', '0.00', 1, 51, '5.1.', 2, 'Enero', '2016'),
(46, '2016-01-14', '18', '1.1.5.1.1.', 'Iva en Compras', '0.54', '0.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(47, '2016-01-14', '18', '1.1.1.1.2.', 'Caja General', '0.00', '5.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(48, '2016-01-04', '19', '5.1.1.1.3.', 'Gastos x mantenimiento', '5.00', '0.00', 1, 51, '5.1.', 0, 'Enero', '2016'),
(49, '2016-01-04', '19', '1.1.5.1.1.', 'Iva en Compras', '0.60', '0.00', 1, 11, '1.1.', 0, 'Enero', '2016'),
(50, '2016-01-04', '19', '1.1.1.1.2.', 'Caja General', '0.00', '5.60', 1, 11, '1.1.', 0, 'Enero', '2016'),
(51, '2016-01-16', '20', '5.1.1.1.1.', 'Gastos x combustible', '4.46', '0.00', 1, 51, '5.1.', 2, 'Enero', '2016'),
(52, '2016-01-16', '20', '1.1.5.1.1.', 'Iva en Compras', '0.54', '0.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(53, '2016-01-16', '20', '1.1.1.1.2.', 'Caja General', '0.00', '5.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(54, '2016-01-18', '21', '5.1.1.1.9.', 'Gastos x suministros de limpieza', '113.36', '0.00', 1, 51, '5.1.', 2, 'Enero', '2016'),
(55, '2016-01-18', '21', '1.1.5.1.1.', 'Iva en Compras', '13.60', '0.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(56, '2016-01-18', '21', '1.1.1.1.2.', 'Caja General', '0.00', '126.96', 1, 11, '1.1.', 2, 'Enero', '2016'),
(57, '2016-01-20', '22', '5.1.1.1.1.', 'Gastos x combustible', '13.39', '0.00', 1, 51, '5.1.', 2, 'Enero', '2016'),
(58, '2016-01-20', '22', '1.1.5.1.1.', 'Iva en Compras', '1.61', '0.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(59, '2016-01-20', '22', '1.1.1.1.2.', 'Caja General', '0.00', '15.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(60, '2016-01-28', '23', '5.1.1.1.10.', 'Otros Gastos Operativos', '40.18', '0.00', 1, 51, '5.1.', 2, 'Enero', '2016'),
(61, '2016-01-28', '23', '1.1.5.1.1.', 'Iva en Compras', '4.82', '0.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(62, '2016-01-28', '23', '1.1.1.1.2.', 'Caja General', '0.00', '45.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(63, '2016-01-28', '24', '5.1.1.1.11.', 'Gastos x notaria', '43.92', '0.00', 1, 51, '5.1.', 2, 'Enero', '2016'),
(64, '2016-01-28', '24', '1.1.5.1.1.', 'Iva en Compras', '5.27', '0.00', 1, 11, '1.1.', 2, 'Enero', '2016'),
(65, '2016-01-28', '24', '1.1.1.1.2.', 'Caja General', '0.00', '49.19', 1, 11, '1.1.', 2, 'Enero', '2016'),
(66, '2016-01-05', '25', '1.1.3.2.26.', 'GRAND VITARA SZ 2.0L 5P TM 4X2 ROJO 2009', '16500.00', '0.00', 1, 11, '1.1.', 1, 'Enero', '2016'),
(67, '2016-01-05', '25', '1.1.1.2.', 'BANCOS', '0.00', '1473.96', 1, 11, '1.1.', 1, 'Enero', '2016'),
(68, '2016-01-05', '25', '1.1.1.1.2.', 'Caja Genearl', '0.00', '50.00', 1, 11, '1.1.', 1, 'Enero', '2016'),
(69, '2016-01-05', '25', '1.1.3.', 'REALIZABLE', '0.00', '11200.00', 1, 11, '1.1.', 1, 'Enero', '2016'),
(70, '2016-01-05', '25', '1.1.1.1.2.', 'Caja General', '0.00', '3776.04', 1, 11, '1.1.', 1, 'Enero', '2016'),
(71, '2016-01-07', '26', '1.1.3.2.8.', 'X-TRAIL ADAVENCE CBT AC 2.5 5P 4X2, PLOMO, 20', '40000.00', '0.00', 1, 11, '1.1.', 1, 'Enero', '2016'),
(72, '2016-01-07', '26', '1.1.1.2.2.', 'Banco de Guayaquil', '0.00', '20000.00', 1, 11, '1.1.', 1, 'Enero', '2016'),
(73, '2016-01-07', '26', '1.1.1.2.1.', 'Banco del Pichincha', '0.00', '20000.00', 1, 11, '1.1.', 1, 'Enero', '2016'),
(91, '2016-03-29', '34', '2.1.1.3.', 'DEUDAS FISCALES', '0.00', '33.00', 1, 21, '2.1.', 1, 'Marzo', '2016'),
(90, '2016-03-29', '34', '2.1.1.', 'EXIGIBLE', '33.00', '0.00', 1, 21, '2.1.', 1, 'Marzo', '2016'),
(89, '2016-03-29', '34', '1.1.1.2.', 'BANCOS', '0.00', '12.00', 1, 11, '1.1.', 1, 'Marzo', '2016'),
(88, '2016-03-29', '34', '1.1.2.1.', 'CUENTAS X COBRAR CLIENTES', '12.00', '0.00', 1, 11, '1.1.', 1, 'Marzo', '2016'),
(87, '2016-03-28', '33', '1.2.2.', 'NO DEPRECIABLE', '0.00', '5.55', 1, 12, '1.2.', 1, 'Marzo', '2016'),
(86, '2016-03-28', '33', '1.1.1.1.', 'CAJAS', '5.55', '0.00', 1, 11, '1.1.', 1, 'Marzo', '2016'),
(85, '2016-03-28', '32', '1.2.1.3.', '(-) DEP. ACUM. MUEBLES Y ENSERES', '0.00', '4.33', 1, 12, '1.2.', 1, 'Marzo', '2016'),
(84, '2016-03-28', '32', '1.1.2.', 'EXIGIBLE', '4.33', '0.00', 1, 11, '1.1.', 1, 'Marzo', '2016'),
(83, '2016-03-28', '31', '1.1.1.2.', 'BANCOS', '0.00', '2.00', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(82, '2016-03-28', '31', '1.1.1.1.', 'CAJAS', '2.00', '0.00', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(81, '2016-03-28', '30', '1.1.1.2.', 'BANCOS', '0.00', '3.00', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(80, '2016-03-28', '30', '1.1.1.2.', 'BANCOS', '3.00', '0.00', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(79, '2016-03-28', '29', '1.1.1.2.', 'BANCOS', '0.00', '3.33', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(78, '2016-03-28', '29', '1.1.1.2.', 'BANCOS', '3.33', '0.00', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(77, '2016-03-28', '28', '1.1.1.1.', 'CAJAS', '0.00', '1.00', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(76, '2016-03-28', '28', '1.1.1.1.', 'CAJAS', '1.00', '0.00', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(75, '2016-03-28', '27', '1.1.1.2.', 'BANCOS', '0.00', '2.22', 1, 11, '1.1.', 3, 'Marzo', '2016'),
(74, '2016-03-28', '27', '1.1.1.1.', 'CAJAS', '2.22', '0.00', 1, 11, '1.1.', 3, 'Marzo', '2016');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mes`
--

CREATE TABLE `mes` (
  `mes_id` int(11) NOT NULL,
  `mes` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mes`
--

INSERT INTO `mes` (`mes_id`, `mes`) VALUES
(1, 'Enero'),
(2, 'Febrero'),
(3, 'Marzo'),
(4, 'Abril'),
(5, 'Mayo'),
(6, 'Junio'),
(7, 'Julio'),
(8, 'Agosto'),
(9, 'Septiembre'),
(10, 'Octubre'),
(11, 'Noviembre'),
(12, 'Diciembre'),
(13, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `num_asientos`
--

CREATE TABLE `num_asientos` (
  `idnum_asientos` int(11) NOT NULL,
  `concepto` char(250) NOT NULL,
  `t_ejercicio_idt_corrientes` int(11) NOT NULL,
  `fecha` char(45) DEFAULT NULL,
  `t_bl_inicial_idt_bl_inicial` int(11) NOT NULL,
  `mes` char(45) NOT NULL,
  `year` char(45) NOT NULL,
  `saldodebe` decimal(15,2) DEFAULT '0.00',
  `saldohaber` decimal(15,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `num_asientos`
--

INSERT INTO `num_asientos` (`idnum_asientos`, `concepto`, `t_ejercicio_idt_corrientes`, `fecha`, `t_bl_inicial_idt_bl_inicial`, `mes`, `year`, `saldodebe`, `saldohaber`) VALUES
(1, '', 1, '2016-01-01', 1, 'Enero', '2016', '0.00', '0.00'),
(2, 'Pago de servicios de monitoreo , efectivo', 2, '2016-01-07', 1, 'Enero', '2016', '0.00', '0.00'),
(3, 'pago x arreglo de vidrio', 3, '2016-01-04', 1, 'Enero', '2016', '0.00', '0.00'),
(4, 'pago x mantenimiento vehiculo', 4, '2016-01-04', 1, 'Enero', '2016', '0.00', '0.00'),
(5, 'pago x servicios de notaria, reconocimiento de firmas', 5, '2016-01-06', 1, 'Enero', '2016', '0.00', '0.00'),
(6, 'pago x servicios de notaria, contrato de reserva, efectivo', 6, '2016-01-06', 1, 'Enero', '2016', '0.00', '0.00'),
(7, 'pago x arriendo de local, efectivo', 7, '2016-01-07', 1, 'Enero', '2016', '0.00', '0.00'),
(8, 'pago x FC#139616 de EUGAS S.A.combustible, efectivo', 8, '2016-01-07', 1, 'Enero', '2016', '0.00', '0.00'),
(9, 'pago x suministros de limpieza, FC#58951, Comercial Kywi, efectivo', 9, '2016-01-09', 1, 'Enero', '2016', '0.00', '0.00'),
(10, 'pago x compra de combustible, FC#321401, Adapaustro, efectivo', 10, '2016-01-09', 1, 'Enero', '2016', '0.00', '0.00'),
(11, 'pago x mantenimiento de vehiculo, FC#629, Alvarez Emilio, efectivo', 11, '2016-01-11', 1, 'Enero', '2016', '0.00', '0.00'),
(12, 'pago x mantenimiento de vehiculo, FC#724, Alvarez Emilio, efectivo', 12, '2016-01-11', 1, 'Enero', '2016', '0.00', '0.00'),
(13, 'pago x compra de combustible, FC#89351, Eugas Cia. Ltda., efectivo', 13, '2016-01-11', 1, 'Enero', '2016', '0.00', '0.00'),
(14, 'pago x envio de documentos, FC#90154, Tame Linea Aerea, efectivo', 14, '2016-01-12', 1, 'Enero', '2016', '0.00', '0.00'),
(15, 'pago x compra de combustible, FC#96608, Eugas Cia. Ltda, efectivo', 15, '2016-01-12', 1, 'Enero', '2016', '0.00', '0.00'),
(16, 'pago x compra de combustible, FC#184178, Eugas Cia. Ltda, efectivo', 16, '2016-01-12', 1, 'Enero', '2016', '0.00', '0.00'),
(17, 'pago x compra de tinta y mantenimiento de impresora, FC#72737, Abraham Cajarmarca Cia. Ltda., efectivo', 17, '2016-01-14', 1, 'Enero', '2016', '0.00', '0.00'),
(18, 'pago x compra de combustible, FC#97181, Eugas Cia. Ltda, efectivo', 18, '2016-01-14', 1, 'Enero', '2016', '0.00', '0.00'),
(19, 'pago x arreglo de llanta, FC#5375, Bermeo Ana, efectivo', 19, '2016-01-04', 1, 'Enero', '2016', '0.00', '0.00'),
(20, 'pago x compra de combustible, FC#128730, Rolando Rios Cia.Ltda.,', 20, '2016-01-16', 1, 'Enero', '2016', '0.00', '0.00'),
(21, 'pago x compra de suministros de limpieza, FC#192582, Megalimpio, efectivo', 21, '2016-01-18', 1, 'Enero', '2016', '0.00', '0.00'),
(22, 'compra de combustible FC#227039, Nuevas Operaciones Comerciales, efectivo', 22, '2016-01-20', 1, 'Enero', '2016', '0.00', '0.00'),
(23, 'compra lona impresa, FC#3615, Ordoñez Cristian, efectivo', 23, '2016-01-28', 1, 'Enero', '2016', '0.00', '0.00'),
(24, 'gasto x realizacion de poder especial, FC#2472, Arias Mayra, efectivo', 24, '2016-01-28', 1, 'Enero', '2016', '0.00', '0.00'),
(25, '.../ Asiento generado / INGRESO vehÃ­culo de placa ABA1348 por cliente con Id num 0102417417', 25, '2016-01-05', 1, 'Enero', '2016', '0.00', '0.00'),
(26, '.../ Asiento generado / INGRESO veh?culo de placa LBB8708 por cliente con Id num 0100832591', 26, '2016-01-07', 1, 'Enero', '2016', '0.00', '0.00'),
(27, '27', 27, '2016-03-28', 1, 'Marzo', '2016', '0.00', '0.00'),
(28, '28', 28, '2016-03-28', 1, 'Marzo', '2016', '0.00', '0.00'),
(29, '29', 29, '2016-03-28', 1, 'Marzo', '2016', '0.00', '0.00'),
(30, '30', 30, '2016-03-28', 1, 'Marzo', '2016', '0.00', '0.00'),
(31, '31', 31, '2016-03-28', 1, 'Marzo', '2016', '0.00', '0.00'),
(32, '32', 32, '2016-03-28', 1, 'Marzo', '2016', '0.00', '0.00'),
(33, '33', 33, '2016-03-28', 1, 'Marzo', '2016', '0.00', '0.00'),
(34, 'as 34', 34, '2016-03-29', 1, 'Marzo', '2016', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `num_asientos_ajustes`
--

CREATE TABLE `num_asientos_ajustes` (
  `idnum_asientos_ajustes` int(11) NOT NULL,
  `concepto` char(250) NOT NULL,
  `t_ejercicio_idt_corrientes` int(11) NOT NULL,
  `fecha` char(45) DEFAULT NULL,
  `t_bl_inicial_idt_bl_inicial` int(11) NOT NULL,
  `mes` char(45) NOT NULL,
  `year` char(45) NOT NULL,
  `saldodebe` decimal(15,2) DEFAULT NULL,
  `saldohaber` decimal(15,2) DEFAULT NULL,
  `num_asientos_idnum_asientos` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `num_asientos_ajustes`
--

INSERT INTO `num_asientos_ajustes` (`idnum_asientos_ajustes`, `concepto`, `t_ejercicio_idt_corrientes`, `fecha`, `t_bl_inicial_idt_bl_inicial`, `mes`, `year`, `saldodebe`, `saldohaber`, `num_asientos_idnum_asientos`) VALUES
(1, 'aj', 1, '2016-03-31', 1, 'Marzo', '2016', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saldosajustados`
--

CREATE TABLE `saldosajustados` (
  `idsaldosajustados` int(11) NOT NULL,
  `deudor` decimal(15,2) DEFAULT NULL,
  `acreedor` decimal(15,2) DEFAULT NULL,
  `num_asientos_idnum_asientos` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `sumadecuentasconajustes`
--
CREATE TABLE `sumadecuentasconajustes` (
`year_aj` char(45)
,`year` char(45)
,`b_aj` int(11)
,`bl` int(11)
,`g_aj` char(11)
,`g` char(45)
,`cod_cuenta_aj` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`sld_deudor` varchar(40)
,`sld_acreedor` varchar(40)
,`slddeudor_aj` varchar(40)
,`sldacreedor_aj` varchar(40)
,`sumas_d` double
,`suma_h` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `sumasparaestadoderesultados`
--
CREATE TABLE `sumasparaestadoderesultados` (
`clase` char(11)
,`nom` char(45)
,`grupo` char(11)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`year` char(45)
,`balance` int(11)
,`total` double
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tip_cuenta`
--

CREATE TABLE `tip_cuenta` (
  `idtip_cuenta` int(11) NOT NULL,
  `tipo` char(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tip_cuenta`
--

INSERT INTO `tip_cuenta` (`idtip_cuenta`, `tipo`) VALUES
(1, 'DEBE'),
(2, 'HABER');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `totasientos`
--
CREATE TABLE `totasientos` (
`asiento` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`fecha` char(45)
,`debe` decimal(15,2)
,`haber` decimal(15,2)
,`balance` int(11)
,`grupo` char(45)
,`logeo` int(11)
,`mes` char(45)
,`year` char(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_auxiliar`
--

CREATE TABLE `t_auxiliar` (
  `nombre_cauxiliar` char(185) NOT NULL,
  `cod_cauxiliar` char(20) NOT NULL,
  `descrip_auxiliar` varchar(100) DEFAULT NULL,
  `t_subcuenta_cod_subcuenta` varchar(11) NOT NULL,
  `t_cuenta_cod_cuenta` char(11) NOT NULL,
  `t_grupo_cod_grupo` char(11) NOT NULL,
  `t_clase_cod_clase` char(11) NOT NULL,
  `placa_id` char(8) NOT NULL,
  `cli_id` char(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_auxiliar`
--

INSERT INTO `t_auxiliar` (`nombre_cauxiliar`, `cod_cauxiliar`, `descrip_auxiliar`, `t_subcuenta_cod_subcuenta`, `t_cuenta_cod_cuenta`, `t_grupo_cod_grupo`, `t_clase_cod_clase`, `placa_id`, `cli_id`) VALUES
('Caja Chica', '1.1.1.1.1.', '', '1.1.1.1.', '1.1.1.', '1.1.', '1.', '', ''),
('Caja General', '1.1.1.1.2.', '', '1.1.1.1.', '1.1.1.', '1.1.', '1.', '', ''),
('Banco del Pichincha', '1.1.1.2.1.', '', '1.1.1.2.', '1.1.1.', '1.1.', '1.', '', ''),
('Banco de Guayaquil', '1.1.1.2.2.', '', '1.1.1.2.', '1.1.1.', '1.1.', '1.', '', ''),
('Iva en Compras', '1.1.5.1.1.', '', '1.1.5.1.', '1.1.5.', '1.1.', '1.', '', ''),
('Sueldos y Salarios X Pagar', '2.1.1.1.1.', '', '2.1.1.1.', '2.1.1.', '2.1.', '2.', '', ''),
('Decimo tercer sueldo', '2.1.1.1.2.', '', '2.1.1.1.', '2.1.1.', '2.1.', '2.', '', ''),
('Decimo cuarto sueldo', '2.1.1.1.3.', '', '2.1.1.1.', '2.1.1.', '2.1.', '2.', '', ''),
('Fondos de Reserva', '2.1.1.1.4.', '', '2.1.1.1.', '2.1.1.', '2.1.', '2.', '', ''),
('Aporte Patronal', '2.1.1.1.5.', '', '2.1.1.1.', '2.1.1.', '2.1.', '2.', '', ''),
('Vacaciones', '2.1.1.1.6.', '', '2.1.1.1.', '2.1.1.', '2.1.', '2.', '', ''),
('Iva en Ventas', '2.1.1.3.1.', '', '2.1.1.3.', '2.1.1.', '2.1.', '2.', '', ''),
('Gastos x combustible', '5.1.1.1.1.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x repuestos', '5.1.1.1.2.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x mantenimiento', '5.1.1.1.3.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x servicios de electricista', '5.1.1.1.4.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x plasticos y tapices', '5.1.1.1.5.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos de latoneria', '5.1.1.1.6.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos de mecanico', '5.1.1.1.7.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x neumaticos', '5.1.1.1.8.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x suministros de limpieza', '5.1.1.1.9.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Otros Gastos Operativos', '5.1.1.1.10.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x Arriendo', '5.1.1.2.1.', '', '5.1.1.2.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x suministros de oficina', '5.1.1.2.2.', '', '5.1.1.2.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x sueldos y salarios', '5.1.1.2.3.', '', '5.1.1.2.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x servicios basicos', '5.1.1.2.4.', '', '5.1.1.2.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x monitoreo y seguridad', '5.1.1.2.5.', '', '5.1.1.2.', '5.1.1.', '5.1.', '5.', '', ''),
('Otros Gastos Administrativos', '5.1.1.2.6.', '', '5.1.1.2.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x suministros de oficina', '5.1.1.3.1.', '', '5.1.1.3.', '5.1.1.', '5.1.', '5.', '', ''),
('Otros gastos de ventas', '5.1.1.3.2.', '', '5.1.1.3.', '5.1.1.', '5.1.', '5.', '', ''),
('Arevalo Gomez Luis Robbinson', '1.1.2.1.1.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1400211056'),
('Romo Padilla Alexandra Judiht', '1.1.2.1.2.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0702423773'),
('Torres Pesantez Maria Paulina', '1.1.2.1.3.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103215943'),
('Shinig Cobo Jorge Marcelo', '1.1.2.1.4.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102560869'),
('Calvache Rodas Carlos Luis', '1.1.2.1.5.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102797966'),
('Dominguez Cabrera Geovanny Humberto', '1.1.2.1.6.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103621009'),
('Pinos Ochoa Esteban Fernando', '1.1.2.1.7.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102655172'),
('Albuja Maldonado Franklin Teddy', '1.1.2.1.8.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1103238703'),
('Enderica Izquierdo Boris Esteban', '1.1.2.1.9.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101995272'),
('Cruz Segarra Rodrigo Alexander', '1.1.2.1.10.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1708195316'),
('Salamea Maldonado Christian Gonzalo', '1.1.2.1.11.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103893954'),
('Calvache Rodas Jorge Andres', '1.1.2.1.12.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102419728'),
('Vera Valdez Victor Guillermo', '1.1.2.1.13.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0701770711'),
('Arciniegas Avila Patricio Nicloas', '1.1.2.1.14.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101310746'),
('Calle Calle Cesar Alfredo', '1.1.2.1.15.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104932728'),
('Pesantez Lucuriaga Patricio Aurelio', '1.1.2.1.16.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101064046'),
('Gonzalez Zapata Erica Maria', '1.1.2.1.17.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', 'FB448775'),
('Pihuave Cruz Karla Elizabeth', '1.1.2.1.18.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0922194238'),
('Pelaez Luzuriaga Jprge Rafael', '1.1.2.1.19.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0703034090'),
('LLivicura Tacuri Jaime Eduardo', '1.1.2.1.20.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102807971'),
('Cojitambo Pinza Elvia de Jesus', '1.1.2.1.21.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1104104722'),
('Deleg Guzman Rosa Elvira', '1.1.2.1.22.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101079739'),
('Dreer Ginanneschi Esteban Javier', '1.1.2.1.23.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0932099633'),
('Bautista Guzman Jose Fernando', '1.1.2.1.24.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103317301'),
('Espinoza Calle Juan Pablo', '1.1.2.1.25.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0301390795'),
('Vera Guilindro JazmaÂ­n Elizabeth', '1.1.2.1.26.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0918946948'),
('Moscoso Loyola Juana Katalina', '1.1.2.1.27.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102753845'),
('Ramirez Yazbeka Plino Yamil', '1.1.2.1.28.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0702723370'),
('Paredes Quintero Viviana Carolina', '1.1.2.1.29.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104868195'),
('Fraga Luke Odalis', '1.1.2.1.30.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1756478119'),
('Nagua Loja Jorge Luis', '1.1.2.1.31.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0704239326'),
('MejiÂ­a Cuesta Marlon Patricio', '1.1.2.1.32.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102777968'),
('Montesdeoca Coraizaca Gonzalo Eduardo', '1.1.2.1.33.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103609665'),
('Lazo Loja Mauricio Salvador', '1.1.2.1.34.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104978416'),
('Murillo Cobos Jose Vicente', '1.1.2.1.35.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0701503633'),
('Leon Nazareno Jerry Gabriel', '1.1.2.1.36.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0927581744'),
('Choez Tomala Juan Antonio', '1.1.2.1.37.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0922067400'),
('Zambrano Bravo Marcelo Andres', '1.1.2.1.38.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0918816638'),
('Chico Vasquez Jonathan Javier', '1.1.2.1.39.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0704885342'),
('Andrade Torres Daniel Alejandro', '1.1.2.1.40.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104137633'),
('Ramirez Infante Miguel Angel', '1.1.2.1.41.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0705440758'),
('Corozo Junco Carlos Ricardo', '1.1.2.1.42.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1205556911'),
('Fernandez Bermeo Marco Antonio', '1.1.2.1.43.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103750659'),
('Santana Vera Luis Bernardo', '1.1.2.1.44.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0923594873'),
('Gonzalez Tapia Lauro Bolivar', '1.1.2.1.45.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102175916'),
('MuÃ±oz Cabrera Efrain Estuardo', '1.1.2.1.46.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102896883'),
('Rosales Bailon Milton Ricardo', '1.1.2.1.47.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0923527287'),
('Gonzalez Lopez Carlos Fernando', '1.1.2.1.48.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102196441'),
('Vazquez Vintimilla Pablo Andres', '1.1.2.1.49.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102317328'),
('Zhaguay Maquiza Juan Manuel', '1.1.2.1.50.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0105508287'),
('Flores GarciÂ­a Marcos Antonio', '1.1.2.1.51.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0700832413'),
('Mayaguari Zhunio Ramiro de Jesus', '1.1.2.1.52.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1400354211'),
('Portilla Rodas Roberto Carlos', '1.1.2.1.53.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1400552079'),
('Segovia Barros Evelyn Patricia', '1.1.2.1.54.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1400552079'),
('Astudillo Valdiviezo Paul Marcelo', '1.1.2.1.55.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104169818'),
('MuÃ±oz Granda Ivan Eduardo', '1.1.2.1.56.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103654430'),
('Berru Medina MariÂ­a Jose', '1.1.2.1.57.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0703391573'),
('Maldonado Quezada Rolando Eduardo', '1.1.2.1.58.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0105163760'),
('Delgado Leon Carlos Alberto', '1.1.2.1.59.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103790390'),
('Loyola Zambrano Arturo Leonardo', '1.1.2.1.60.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0301463568'),
('Campoverde Borja Geovanny Paul', '1.1.2.1.61.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104712302'),
('Paz Reyes Hector Arcersio', '1.1.2.1.62.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0501835615'),
('Zhunio Malla Efrain Lizardo', '1.1.2.1.63.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1400354211'),
('Coella Ugalde Christian Ernesto', '1.1.2.1.64.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102424637'),
('Lema Paredes Cleofe Edelmira', '1.1.2.1.65.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0200827244'),
('Matailo Cajamarca Felix Isaac', '1.1.2.1.66.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0105764195'),
('Tamayo Cabrera Juan Diego', '1.1.2.1.67.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104200779'),
('Bonete Leon Cinthia Liliana', '1.1.2.1.68.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104360169'),
('Vargas Chuquimarca Luis Antonio', '1.1.2.1.69.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101049450'),
('Herdoiza Bermeo Carmen Filomena', '1.1.2.1.70.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0700445398'),
('Vitonera Ayala Feliz Antonio', '1.1.2.1.71.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0702370925'),
('Amoroso Abril Carla Paola', '1.1.2.1.72.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103854360'),
('Tamayo Anzotegui Alez Ivan', '1.1.2.1.73.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103869319'),
('Plua Pilay Jorge Marcelino', '1.1.2.1.74.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0923509640'),
('Chacon Narea Elsa Maribel', '1.1.2.1.75.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102830106'),
('Moran Ochoa Oscar Vinicio', '1.1.2.1.76.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1203872898'),
('Tenezaca Minchalo Luis Antonio', '1.1.2.1.77.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0300598281'),
('Tenempaguay Guaman Jorge Adrian', '1.1.2.1.78.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0302068945'),
('Coellar Iñiguez Gladys Marlene', '1.1.2.1.79.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101372027'),
('Marí­n Muñoz Rodrigo Domingo', '1.1.2.1.80.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101005924'),
('Rosales Gonzalez Miguel Klever', '1.1.2.1.81.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1305698563'),
('Aucacama Chabla Marco Vinicio', '1.1.2.1.82.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0301319505'),
('Pulla Aguilar Esther Maria', '1.1.2.1.83.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0701675431'),
('Samaniego Sanchez Wilmer Leonardo', '1.1.2.1.84.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0919887794'),
('Chungata Pillajo Rigoberto Wilfrido', '1.1.2.1.85.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0702411232'),
('Tamay Saa Henry Lenin', '1.1.2.1.86.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103568861'),
('Leon Alvarez Milton Ricardo', '1.1.2.1.87.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101662716'),
('Armijos Astudillo Clodomiro', '1.1.2.1.88.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0700540552'),
('Galan Sanchez Monica Catalina', '1.1.2.1.89.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103218228'),
('Coellar Ugalde Christian Ernesto', '1.1.2.1.90.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102424637'),
('Alvarez Palacios Pedro Xavier', '1.1.2.1.91.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102494937'),
('Caldas Atiencia Mirian Patricia', '1.1.2.1.92.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0105797641'),
('Abad Molina Pablo Antonio', '1.1.2.1.93.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102483385'),
('Mora Matamorros Manuel Alberto', '1.1.2.1.94.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0915378806'),
('Guzman Moyano Pablo Ramiro', '1.1.2.1.95.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102497898'),
('Yuqui Ponce Hilda Raquel', '1.1.2.1.96.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0101991743'),
('Guadalupe Bravo Nicolay Emerson', '1.1.2.1.97.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103273249'),
('Chapa Perez Sandra Nivelia', '1.1.2.1.98.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0104502877'),
('TUCKSON GL GAA 4x2 T/A BHWDS6B, AZUL, 2006, P', '1.1.3.1.1.', '', '1.1.3.1.', '1.1.3.', '1.1.', '1.', 'POY0529', ''),
('OPTRA ADVANCE 1.8L 4P TM, PLATEADO, 2012, ABB', '1.1.3.1.2.', '', '1.1.3.1.', '1.1.3.', '1.1.', '1.', '', ''),
('MONTERO SPORT 5P 3.0TM FULL EQUIPO, PLOMO, 20', '1.1.3.2.1.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PVO0698', ''),
('AVEO FAMILY STD 1.5 4P 4X2, PLOMO, 2013, ABD4', '1.1.3.2.2.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABD4172', ''),
('AVEO ACTIVO 1.6L 5P AC, NEGRO, 2010, ABA1261', '1.1.3.2.3.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABA1261', ''),
('SPORTAGE LX, 2013, PLATEADO, ABD6611', '1.1.3.2.4.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABD6611', ''),
('ECOSPORT XLT 4X2, 2007, PLOMO, AFN0761', '1.1.3.2.5.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'AFN0761', ''),
('GOL HB POWER AC 5U 11 F4, BLANCO, 2012, PCA506', '1.1.3.2.6.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PCA5064', ''),
('DUSTER TM 2.0 5P 4X2, PLOMO, 2013, LBB3338', '1.1.3.2.7.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'LBB3338', ''),
('X-TRAIL ADAVENCE CBT AC 2.5 5P 4X2, PLOMO, 20', '1.1.3.2.8.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'LBB8708', ''),
('AVEO FAMILY STD 1.5 4P 4X2 TM, NEGRO, 2015, A', '1.1.3.2.9.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABE1457', ''),
('DMAX CRDI 3.0 CD 4X2 TM DIESEL, PLATEADO, 201', '1.1.3.2.10.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABE2530', ''),
('LUV D-MAX 3.0L DIESEL CD TM 4X4, PLATEADO, 20', '1.1.3.2.11.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PBI7326', ''),
('RIO REX TM 1.39 4P 4X2 ,AZUL, 2013, PCB1210', '1.1.3.2.12.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PCB1210', ''),
('AA PRIUS C SPORT TA 1.5 5P 4X2, BLANCO, 2012,', '1.1.3.2.13.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PBP3617', ''),
('CET HILUX 4X2 CD NO AA DIESEL, BLANCO, 2010,', '1.1.3.2.14.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABA9588', ''),
('MAZDA3 SPORT 2.0 MT FL, PLOMO, 2008', '1.1.3.2.15.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PDA5996', ''),
('GRAND VITARA SZ 2.7L B6 5P TA 4X4, BLANCO,', '1.1.3.2.16.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABA2605', ''),
('LUV C/S 4X2 T/M INYEC, PLOMO, 2005, HCI0914', '1.1.3.2.17.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'HCI0914', ''),
('AVEO ACTIVO 1.6L 4P AC, PLOMO, 2009, PBG1685', '1.1.3.1.3.', '', '1.1.3.1.', '1.1.3.', '1.1.', '1.', 'PBG1685', ''),
('SPORTAGE R 2.06L 4X2 GSL MT AC, NEGRO, 2011,', '1.1.3.2.18.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PBT5676', ''),
('SAIL STD TM 1.4 4P 4X2, PLATEADO, 2014, ABD96', '1.1.3.2.19.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABD9602', ''),
('GRAND CHEROKEE LAREDO 4X2, CREMA, 2006, PQG05', '1.1.3.2.20.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PQG0597', ''),
('RANGER XLS 2.5 CD 4X2 TM, PLOMO, 2012, ABD323', '1.1.3.2.21.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABD3233', ''),
('FORSA, 1988, ROJO, PJE0649', '1.1.3.2.22.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PJE0649', ''),
('D-MAX SERDI 3.0 CD 4X2 TM DIESEL, NEGRO, 2014', '1.1.3.2.23.', '', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABE4799', ''),
('Escritorio 5 cajones', '1.2.1.1.16.', NULL, '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Escritorio 3 cajones', '1.2.1.1.2.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Esquinero pequeÃ±o', '1.2.1.1.3.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Mueble Cafetera', '1.2.1.1.4.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Archivador grande 4 cajones', '1.2.1.1.5.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Archivador pequeÃ±o 4 cajones', '1.2.1.1.6.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Escritorio 1 cajon', '1.2.1.1.7.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Mesa vidrio', '1.2.1.1.8.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Escritorio 2 cajones', '1.2.1.1.9.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Archivador', '1.2.1.1.10.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Estante Metalico', '1.2.1.1.11.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Silla individual', '1.2.1.1.12.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Sillas de espera', '1.2.1.1.13.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Silla giratoria pequeÃ±a', '1.2.1.1.14.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Silla giratoria grande', '1.2.1.1.15.', '', '1.2.1.1.', '1.2.1.', '1.2.', '1.', '', ''),
('Impresora EPSON L355', '1.2.1.2.1.', '', '1.2.1.2.', '1.2.1.', '1.2.', '1.', '', ''),
('Computadora Portatil HP', '1.2.1.2.2.', '', '1.2.1.2.', '1.2.1.', '1.2.', '1.', '', ''),
('Computadora de escritorio', '1.2.1.2.3.', '', '1.2.1.2.', '1.2.1.', '1.2.', '1.', '', ''),
('Computadora Portatil Sonic Master', '1.2.1.2.4.', '', '1.2.1.2.', '1.2.1.', '1.2.', '1.', '', ''),
('Otero Cordova Carla', '1.1.2.1.99.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0103660395'),
('Aporte Personal', '2.1.1.1.7.', '', '2.1.1.1.', '2.1.1.', '2.1.', '2.', '', ''),
('Gastos x notaria', '5.1.1.1.11.', '', '5.1.1.1.', '5.1.1.', '5.1.', '5.', '', ''),
('Gastos x honorarios profesionales', '5.1.1.2.7.', '', '5.1.1.2.', '5.1.1.', '5.1.', '5.', '', ''),
('GONZALEZ PEÃ‘AFIEL CRISTIAN DAMIAN', '1.1.2.1.100.', ' ', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0301652905'),
('SPORTAGE LX PLATEADO 2013', '1.1.3.2.24.', ' ', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PCF6529', ''),
('ALVAREZ SUAREZ CHRISTIAN JOFFRE', '1.1.2.1.101.', ' ', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1717779266'),
('X-TRAIL ADVANCE CVT AC 2.5 5P 4X2 PLOMO 2015', '1.1.3.2.25.', ' ', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'LBB8708', ''),
('GRAND VITARA SZ 2.0L 5P TM 4X2 ROJO 2009', '1.1.3.2.26.', ' ', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABA1348', ''),
('RANGER XLS 2.5 CD 4X2 TM PLOMO 2012', '1.1.3.2.27.', ' ', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABD3233', ''),
('SAIL AC 1.4 4P 4X2 TM PLOMO 2014', '1.1.3.2.28.', ' ', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'ABD8415', ''),
('AVEO FAMILY AC 1.5 4P 4X2 TM BLANCO 2014', '1.1.3.2.29.', ' ', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'GSJ5779', ''),
('OPTRA 1.8L T/M LIMITED CREMA 2006', '1.1.3.2.30.', ' ', '1.1.3.2.', '1.1.3.', '1.1.', '1.', 'PVB0955', ''),
('SARMIENTO DAVILA OMAR RENE', '1.1.2.1.102.', ' ', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0102417417'),
('ROMERO ARMIJOS RENE ANTONIO', '1.1.2.1.103.', '', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '0100832591'),
('AREVALO GOMEZ MERCEDES ELIZABETH', '1.1.2.1.104.', ' ', '1.1.2.1.', '1.1.2.', '1.1.', '1.', '', '1400369037');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_bl_inicial`
--

CREATE TABLE `t_bl_inicial` (
  `idt_bl_inicial` int(11) NOT NULL,
  `fecha_balance` char(45) DEFAULT NULL,
  `logeo_idlogeo` int(11) DEFAULT NULL,
  `year` char(45) NOT NULL,
  `estado` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_bl_inicial`
--

INSERT INTO `t_bl_inicial` (`idt_bl_inicial`, `fecha_balance`, `logeo_idlogeo`, `year`, `estado`) VALUES
(1, '2016-01-26', 2, '2016', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_clase`
--

CREATE TABLE `t_clase` (
  `nombre_clase` char(45) NOT NULL,
  `cod_clase` char(11) NOT NULL,
  `descrip_class` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_clase`
--

INSERT INTO `t_clase` (`nombre_clase`, `cod_clase`, `descrip_class`) VALUES
('ACTIVO', '1.', ''),
('PASIVO', '2.', ''),
('PATRIMONIO', '3.', ''),
('INGRESOS', '4.', ''),
('COSTOS Y GASTOS', '5.', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_cuenta`
--

CREATE TABLE `t_cuenta` (
  `nombre_cuenta` char(45) NOT NULL,
  `cod_cuenta` char(11) NOT NULL,
  `descrip_cuenta` varchar(100) DEFAULT NULL,
  `t_grupo_cod_grupo` char(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_cuenta`
--

INSERT INTO `t_cuenta` (`nombre_cuenta`, `cod_cuenta`, `descrip_cuenta`, `t_grupo_cod_grupo`) VALUES
('DISPONIBLE', '1.1.1.', '', '1.1.'),
('EXIGIBLE', '1.1.2.', '', '1.1.'),
('REALIZABLE', '1.1.3.', '', '1.1.'),
('DEPRECIABLE', '1.2.1.', '', '1.2.'),
('NO DEPRECIABLE', '1.2.2.', '', '1.2.'),
('SERVICIOS Y PAGOS ANTICIPADOS', '1.1.4.', '', '1.1.'),
('ACTIVOS POR IMPUESTOS CORRIENTES', '1.1.5.', '', '1.1.'),
('EXIGIBLE', '2.1.1.', '', '2.1.'),
('EXIGIBLE A LARGO PLAZO', '2.2.1.', '', '2.2.'),
('CAPITAL Y RESERVAS', '3.1.1.', '', '3.1.'),
('INGRESOS X COMISION Y CONSIGNACION', '4.1.1.', '', '4.1.'),
('OTROS INGRESOS NO OPERACIONALES', '4.2.1.', '', '4.2.'),
('GASTOS OPERATIVOS, ADMINISTRACION Y VENTAS', '5.1.1.', '', '5.1.'),
('INTERESES GANADOS', '4.1.2.', '', '4.1.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_ejercicio`
--

CREATE TABLE `t_ejercicio` (
  `idt_corrientes` int(11) NOT NULL,
  `ejercicio` char(45) DEFAULT NULL,
  `cod_cuenta` char(45) DEFAULT NULL,
  `cuenta` char(45) DEFAULT NULL,
  `fecha` char(45) DEFAULT NULL,
  `valor` decimal(15,2) DEFAULT '0.00',
  `valorp` decimal(15,2) DEFAULT '0.00',
  `t_bl_inicial_idt_bl_inicial` int(11) DEFAULT NULL,
  `tipo` char(11) DEFAULT NULL,
  `logeo_idlogeo` int(11) DEFAULT NULL,
  `mes` char(45) NOT NULL,
  `year` char(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_ejercicio`
--

INSERT INTO `t_ejercicio` (`idt_corrientes`, `ejercicio`, `cod_cuenta`, `cuenta`, `fecha`, `valor`, `valorp`, `t_bl_inicial_idt_bl_inicial`, `tipo`, `logeo_idlogeo`, `mes`, `year`) VALUES
(1, '1', '1.1.1.2.2.', 'Banco de Guayaquil', '2016-01-01', '1915.94', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(2, '1', '1.1.2.1.1.', 'Arevalo Gomez Luis Robbinson', '2016-01-01', '6500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(3, '1', '1.1.2.1.10.', 'Cruz Segarra Rodrigo Alexander', '2016-01-01', '2200.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(4, '1', '1.1.2.1.11.', 'Salamea Maldonado Christian Gonzalo', '2016-01-01', '23500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(5, '1', '1.1.2.1.12.', 'Calvache Rodas Jorge Andres', '2016-01-01', '40000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(6, '1', '1.1.2.1.13.', 'Vera Valdez Victor Guillermo', '2016-01-01', '3545.83', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(7, '1', '1.1.2.1.14.', 'Arciniegas Avila Patricio Nicloas', '2016-01-01', '3483.33', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(8, '1', '1.1.2.1.15.', 'Calle Calle Cesar Alfredo', '2016-01-01', '5175.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(9, '1', '1.1.2.1.16.', 'Pesantez Lucuriaga Patricio Aurelio', '2016-01-01', '1000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(10, '1', '1.1.2.1.18.', 'Pihuave Cruz Karla Elizabeth', '2016-01-01', '11144.44', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(11, '1', '1.1.2.1.19.', 'Pelaez Luzuriaga Jprge Rafael', '2016-01-01', '2999.98', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(12, '1', '1.1.2.1.2.', 'Romo Padilla Alexandra Judiht', '2016-01-01', '14000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(13, '1', '1.1.2.1.20.', 'LLivicura Tacuri Jaime Eduardo', '2016-01-01', '7000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(14, '1', '1.1.2.1.21.', 'Cojitambo Pinza Elvia de Jesus', '2016-01-01', '600.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(15, '1', '1.1.2.1.22.', 'Deleg Guzman Rosa Elvira', '2016-01-01', '7200.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(16, '1', '1.1.2.1.23.', 'Dreer Ginanneschi Esteban Javier', '2016-01-01', '3920.90', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(17, '1', '1.1.2.1.24.', 'Bautista Guzman Jose Fernando', '2016-01-01', '5625.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(18, '1', '1.1.2.1.25.', 'Espinoza Calle Juan Pablo', '2016-01-01', '8312.48', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(19, '1', '1.1.2.1.26.', 'Vera Guilindro JazmaÂ­n Elizabeth', '2016-01-01', '5997.04', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(20, '1', '1.1.2.1.27.', 'Moscoso Loyola Juana Katalina', '2016-01-01', '9500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(21, '1', '1.1.2.1.28.', 'Ramirez Yazbeka Plino Yamil', '2016-01-01', '2537.48', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(22, '1', '1.1.2.1.29.', 'Paredes Quintero Viviana Carolina', '2016-01-01', '1049.52', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(23, '1', '1.1.2.1.3.', 'Torres Pesantez Maria Paulina', '2016-01-01', '5000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(24, '1', '1.1.2.1.30.', 'Fraga Luke Odalis', '2016-01-01', '8433.32', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(25, '1', '1.1.2.1.31.', 'Nagua Loja Jorge Luis', '2016-01-01', '4266.68', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(26, '1', '1.1.2.1.32.', 'MejiÂ­a Cuesta Marlon Patricio', '2016-01-01', '10458.30', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(27, '1', '1.1.2.1.33.', 'Montesdeoca Coraizaca Gonzalo Eduardo', '2016-01-01', '7373.32', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(28, '1', '1.1.2.1.34.', 'Lazo Loja Mauricio Salvador', '2016-01-01', '8515.30', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(29, '1', '1.1.2.1.35.', 'Murillo Cobos Jose Vicente', '2016-01-01', '23749.98', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(30, '1', '1.1.2.1.36.', 'Leon Nazareno Jerry Gabriel', '2016-01-01', '6833.32', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(31, '1', '1.1.2.1.38.', 'Zambrano Bravo Marcelo Andres', '2016-01-01', '2955.52', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(32, '1', '1.1.2.1.39.', 'Chico Vasquez Jonathan Javier', '2016-01-01', '10200.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(33, '1', '1.1.2.1.4.', 'Shinig Cobo Jorge Marcelo', '2016-01-01', '12800.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(34, '1', '1.1.2.1.40.', 'Andrade Torres Daniel Alejandro', '2016-01-01', '2953.32', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(35, '1', '1.1.2.1.41.', 'Ramirez Infante Miguel Angel', '2016-01-01', '5199.96', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(36, '1', '1.1.2.1.42.', 'Corozo Junco Carlos Ricardo', '2016-01-01', '10874.98', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(37, '1', '1.1.2.1.44.', 'Santana Vera Luis Bernardo', '2016-01-01', '21886.88', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(38, '1', '1.1.2.1.45.', 'Gonzalez Tapia Lauro Bolivar', '2016-01-01', '2291.74', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(39, '1', '1.1.2.1.47.', 'Rosales Bailon Milton Ricardo', '2016-01-01', '4399.96', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(40, '1', '1.1.2.1.48.', 'Gonzalez Lopez Carlos Fernando', '2016-01-01', '12300.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(41, '1', '1.1.2.1.49.', 'Vazquez Vintimilla Pablo Andres', '2016-01-01', '7779.82', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(42, '1', '1.1.2.1.5.', 'Calvache Rodas Carlos Luis', '2016-01-01', '13500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(43, '1', '1.1.2.1.50.', 'Zhaguay Maquiza Juan Manuel', '2016-01-01', '2933.29', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(44, '1', '1.1.2.1.51.', 'Flores GarciÂ­a Marcos Antonio', '2016-01-01', '1233.30', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(45, '1', '1.1.2.1.52.', 'Mayaguari Zhunio Ramiro de Jesus', '2016-01-01', '4000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(46, '1', '1.1.2.1.53.', 'Portilla Rodas Roberto Carlos', '2016-01-01', '4949.94', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(47, '1', '1.1.2.1.54.', 'Segovia Barros Evelyn Patricia', '2016-01-01', '4756.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(48, '1', '1.1.2.1.55.', 'Astudillo Valdiviezo Paul Marcelo', '2016-01-01', '900.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(49, '1', '1.1.2.1.57.', 'Berru Medina MariÂ­a Jose', '2016-01-01', '8500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(50, '1', '1.1.2.1.58.', 'Maldonado Quezada Rolando Eduardo', '2016-01-01', '32.40', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(51, '1', '1.1.2.1.59.', 'Delgado Leon Carlos Alberto', '2016-01-01', '5350.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(52, '1', '1.1.2.1.6.', 'Dominguez Cabrera Geovanny Humberto', '2016-01-01', '9843.50', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(53, '1', '1.1.2.1.60.', 'Loyola Zambrano Arturo Leonardo', '2016-01-01', '1400.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(54, '1', '1.1.2.1.61.', 'Campoverde Borja Geovanny Paul', '2016-01-01', '9094.40', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(55, '1', '1.1.2.1.62.', 'Paz Reyes Hector Arcersio', '2016-01-01', '400.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(56, '1', '1.1.2.1.63.', 'Zhunio Malla Efrain Lizardo', '2016-01-01', '2212.40', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(57, '1', '1.1.2.1.64.', 'Coella Ugalde Christian Ernesto', '2016-01-01', '13000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(58, '1', '1.1.2.1.65.', 'Lema Paredes Cleofe Edelmira', '2016-01-01', '588.05', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(59, '1', '1.1.2.1.66.', 'Matailo Cajamarca Felix Isaac', '2016-01-01', '855.72', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(60, '1', '1.1.2.1.67.', 'Tamayo Cabrera Juan Diego', '2016-01-01', '4012.40', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(61, '1', '1.1.2.1.68.', 'Bonete Leon Cinthia Liliana', '2016-01-01', '6200.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(62, '1', '1.1.2.1.69.', 'Vargas Chuquimarca Luis Antonio', '2016-01-01', '937.50', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(63, '1', '1.1.2.1.7.', 'Pinos Ochoa Esteban Fernando', '2016-01-01', '18700.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(64, '1', '1.1.2.1.70.', 'Herdoiza Bermeo Carmen Filomena', '2016-01-01', '3239.52', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(65, '1', '1.1.2.1.71.', 'Vitonera Ayala Feliz Antonio', '2016-01-01', '2459.97', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(66, '1', '1.1.2.1.72.', 'Amoroso Abril Carla Paola', '2016-01-01', '549.94', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(67, '1', '1.1.2.1.73.', 'Tamayo Anzotegui Alez Ivan', '2016-01-01', '1033.20', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(68, '1', '1.1.2.1.74.', 'Plua Pilay Jorge Marcelino', '2016-01-01', '3483.33', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(69, '1', '1.1.2.1.75.', 'Chacon Narea Elsa Maribel', '2016-01-01', '5980.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(70, '1', '1.1.2.1.76.', 'Moran Ochoa Oscar Vinicio', '2016-01-01', '3375.46', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(71, '1', '1.1.2.1.77.', 'Tenezaca Minchalo Luis Antonio', '2016-01-01', '1254.11', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(72, '1', '1.1.2.1.78.', 'Tenenpaguay Guaman Jorge Adrian', '2016-01-01', '2824.90', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(73, '1', '1.1.2.1.79.', 'Coellar IÃ±iguez Gladys Marlene', '2016-01-01', '2522.60', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(74, '1', '1.1.2.1.81.', 'Rosales Gonzalez Miguel Klever', '2016-01-01', '625.02', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(75, '1', '1.1.2.1.82.', 'Aucacama Chabla Marco Vinicio', '2016-01-01', '2443.77', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(76, '1', '1.1.2.1.83.', 'Pulla Aguilar Esther Maria', '2016-01-01', '1691.61', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(77, '1', '1.1.2.1.84.', 'Samaniego Sanchez Wilmnr Leonardo', '2016-01-01', '1212.43', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(78, '1', '1.1.2.1.88.', 'Armijos Astudillo Clodomiro', '2016-01-01', '1000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(79, '1', '1.1.2.1.89.', 'Galin Sanchez Monica Catalina', '2016-01-01', '900.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(80, '1', '1.1.2.1.9.', 'Enderica Izquierdo Boris Esteban', '2016-01-01', '4800.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(81, '1', '1.1.2.1.91.', 'Alvarez Palacios Pedro Xavier', '2016-01-01', '2800.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(82, '1', '1.1.2.1.92.', 'Caldas Atiencia Mirian Patricia', '2016-01-01', '5008.50', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(83, '1', '1.1.2.1.93.', 'Abad Molina Pablo Antonio', '2016-01-01', '10000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(84, '1', '1.1.2.1.95.', 'Guzman Moyano Pablo Ramiro', '2016-01-01', '2450.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(85, '1', '1.1.2.1.96.', 'Yuqui Ponce Hilda Raquel', '2016-01-01', '7000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(86, '1', '1.1.2.1.97.', 'Guadalupe Bravo Nicolay Emerson', '2016-01-01', '4700.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(87, '1', '1.1.3.1.1.', 'TUCKSON GL GAA 4x2 T/A BHWDS6B, AZUL, 2006, P', '2016-01-01', '16700.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(88, '1', '1.1.3.1.2.', 'OPTRA ADVANCE 1.8L 4P TM, PLATEADO, 2012, ABB', '2016-01-01', '17900.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(89, '1', '1.1.3.1.3.', 'AVEO ACTIVO 1.6L 4P AC, PLOMO, 2009, PBG1685', '2016-01-01', '12200.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(90, '1', '1.1.3.2.1.', 'MONTERO SPORT 5P 3.0TM FULL EQUIPO, PLOMO, 20', '2016-01-01', '21900.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(91, '1', '1.1.3.2.10.', 'DMAX CRDI 3.0 CD 4X2 TM DIESEL, PLATEADO, 201', '2016-01-01', '24500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(92, '1', '1.1.3.2.11.', 'LUV D-MAX 3.0L DIESEL CD TM 4X4, PLATEADO, 20', '2016-01-01', '33500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(93, '1', '1.1.3.2.12.', 'RIO REX TM 1.39 4P 4X2 ,AZUL, 2013, PCB1210', '2016-01-01', '18800.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(94, '1', '1.1.3.2.13.', 'AA PRIUS C SPORT TA 1.5 5P 4X2, BLANCO, 2012,', '2016-01-01', '20500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(95, '1', '1.1.3.2.15.', 'MAZDA3 SPORT 2.0 MT FL, PLOMO, 2008, PDA5696', '2016-01-01', '16800.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(96, '1', '1.1.3.2.17.', 'LUV C/S 4X2 T/M INYEC, PLOMO, 2005, HCI0914', '2016-01-01', '10800.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(97, '1', '1.1.3.2.2.', 'AVEO FAMILY STD 1.5 4P 4X2, PLOMO, 2013, ABD4', '2016-01-01', '11100.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(98, '1', '1.1.3.2.20.', 'GRAND CHEROKEE LAREDO 4X2, CREMA, 2006, PQG05', '2016-01-01', '28000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(99, '1', '3.1.1.1.', 'CAPITAL', '2016-01-01', '0.00', '1085502.30', 1, '3.1.', 2, 'Enero', '2016'),
(100, '1', '1.2.1.2.1.', 'Impresora EPSON L355', '2016-01-01', '285.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(101, '1', '1.2.1.1.2.', 'Escritorio 3 cajones', '2016-01-01', '300.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(102, '1', '1.2.1.1.3.', 'Esquinero pequeño', '2016-01-01', '150.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(103, '1', '1.2.1.1.4.', 'Mueble Cafetera', '2016-01-01', '150.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(104, '1', '1.2.1.1.5.', 'Archivador grande 4 cajones', '2016-01-01', '200.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(105, '1', '1.2.1.1.6.', 'Archivador pequeño 4 cajones', '2016-01-01', '180.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(106, '1', '1.2.1.1.7.', 'Escritorio 1 cajon', '2016-01-01', '150.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(107, '1', '1.2.1.1.8.', 'Mesa vidrio', '2016-01-01', '300.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(108, '1', '1.2.1.1.9.', 'Escritorio 2 cajones', '2016-01-01', '400.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(109, '1', '1.2.1.1.10.', 'Archivador', '2016-01-01', '450.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(110, '1', '1.2.1.1.11.', 'Estante Metalico', '2016-01-01', '60.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(111, '1', '1.2.1.2.2.', 'Computadora Portatil HP', '2016-01-01', '500.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(112, '1', '1.2.1.2.3.', 'Computadora de escritorio', '2016-01-01', '700.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(113, '1', '1.2.1.2.4.', 'Computadora Portatil Sonic Master', '2016-01-01', '600.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(114, '1', '1.2.1.1.12.', 'Silla individual', '2016-01-01', '50.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(115, '1', '1.2.1.1.13.', 'Sillas de espera', '2016-01-01', '230.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(116, '1', '1.2.1.1.14.', 'Silla giratoria pequeña', '2016-01-01', '90.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(117, '1', '1.2.1.1.15.', 'Silla giratoria grande', '2016-01-01', '160.00', '0.00', 1, '1.2.', 2, 'Enero', '2016'),
(118, '1', '1.1.2.1.99.', 'Otero Cordova Carla', '2016-01-01', '18241.66', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(119, '1', '1.1.2.1.8.', 'Albuja Maldonado Franklin Teddy', '2016-01-01', '66731.46', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(120, '1', '1.1.2.1.37.', 'Choez Tomala Juan Antonio', '2016-01-01', '9941.58', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(121, '1', '1.1.2.1.43.', 'Fernandez Bermeo Marco Antonio', '2016-01-01', '23200.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(122, '1', '1.1.3.2.21.', 'RANGER XLS 2.5 CD 4X2 TM, PLOMO, 2012, ABD323', '2016-01-01', '28000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(123, '1', '1.1.3.2.19.', 'SAIL STD TM 1.4 4P 4X2, PLATEADO, 2014, ABD96', '2016-01-01', '14000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(124, '1', '1.1.3.2.22.', 'FORSA, 1988, ROJO, PJE0649', '2016-01-01', '4000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(125, '1', '1.1.3.2.10.', 'DMAX CRDI 3.0 CD 4X2 TM DIESEL, PLATEADO, 201', '2016-01-01', '29000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(126, '1', '1.1.3.2.3.', 'AVEO ACTIVO 1.6L 5P AC, NEGRO, 2010, ABA1261', '2016-01-01', '12100.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(127, '1', '1.1.3.2.4.', 'SPORTAGE LX, 2013, PLATEADO, ABD6611', '2016-01-01', '22000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(128, '1', '1.1.3.2.5.', 'ECO SPORT XLT 4X2, 2007, PLOMO, AFN0761', '2016-01-01', '13500.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(129, '1', '1.1.3.2.6.', 'GOLHB POWER AC 5U 11 F4, BLANCO, 2012, PCA506', '2016-01-01', '14100.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(130, '1', '1.1.3.2.7.', 'DUSTER TM 2.0 5P 4X2, PLOMO, 2013, LBB3338', '2016-01-01', '20000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(131, '1', '1.1.3.2.8.', 'X-TRAIL ADAVENCE CBT AC 2.5 5P 4X2, PLOMO, 20', '2016-01-01', '40000.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(132, '1', '1.1.3.2.9.', 'AVEO FAMILY STD 1.5 4P 4X2 TM, NEGRO, 2015, A', '2016-01-01', '12800.00', '0.00', 1, '1.1.', 2, 'Enero', '2016'),
(576, '1', '5.1.1.2.2.', 'Gastos x suministros de oficina', '2016-03-28', '33.93', '0.00', 2, '5.1.', 1, 'Marzo', '2017'),
(575, '1', '5.1.1.1.1.', 'Gastos x combustible', '2016-03-28', '42.83', '0.00', 2, '5.1.', 1, 'Marzo', '2017'),
(574, '1', '5.1.1.2.5.', 'Gastos x monitoreo y seguridad', '2016-03-28', '23.00', '0.00', 2, '5.1.', 1, 'Marzo', '2017'),
(573, '1', '5.1.1.1.3.', 'Gastos x mantenimiento', '2016-03-28', '592.32', '0.00', 2, '5.1.', 1, 'Marzo', '2017'),
(572, '1', '5.1.1.1.9.', 'Gastos x suministros de limpieza', '2016-03-28', '121.26', '0.00', 2, '5.1.', 1, 'Marzo', '2017'),
(571, '1', '5.1.1.1.11.', 'Gastos x notaria', '2016-03-28', '57.24', '0.00', 2, '5.1.', 1, 'Marzo', '2017'),
(570, '1', '5.1.1.1.10.', 'Otros Gastos Operativos', '2016-03-28', '42.59', '0.00', 2, '5.1.', 1, 'Marzo', '2017'),
(569, '1', '5.1.1.2.1.', 'Gastos x Arriendo', '2016-03-28', '1428.57', '0.00', 2, '5.1.', 1, 'Marzo', '2017'),
(568, '1', '3.1.1.1.', 'CAPITAL', '2016-03-28', '0.00', '1085502.30', 2, '3.1.', 1, 'Marzo', '2017'),
(567, '1', '1.2.1.1.6.', 'Archivador pequeÃ±o 4 cajones', '2016-03-28', '180.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(566, '1', '1.2.1.1.12.', 'Silla individual', '2016-03-28', '50.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(565, '1', '1.2.1.2.3.', 'Computadora de escritorio', '2016-03-28', '700.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(564, '1', '1.2.1.1.7.', 'Escritorio 1 cajon', '2016-03-28', '150.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(563, '1', '1.2.1.1.13.', 'Sillas de espera', '2016-03-28', '230.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(562, '1', '1.2.1.2.4.', 'Computadora Portatil Sonic Master', '2016-03-28', '600.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(561, '1', '1.2.1.1.2.', 'Escritorio 3 cajones', '2016-03-28', '300.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(560, '1', '1.2.1.1.8.', 'Mesa vidrio', '2016-03-28', '300.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(559, '1', '1.2.1.1.14.', 'Silla giratoria pequeÃ±a', '2016-03-28', '90.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(558, '1', '1.2.1.1.3.', 'Esquinero pequeÃ±o', '2016-03-28', '150.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(557, '1', '1.2.1.1.9.', 'Escritorio 2 cajones', '2016-03-28', '400.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(556, '1', '1.2.1.1.15.', 'Silla giratoria grande', '2016-03-28', '160.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(555, '1', '1.2.1.1.4.', 'Mueble Cafetera', '2016-03-28', '150.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(554, '1', '1.2.1.1.10.', 'Archivador', '2016-03-28', '450.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(553, '1', '1.2.1.2.1.', 'Impresora EPSON L355', '2016-03-28', '285.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(552, '1', '1.2.1.1.5.', 'Archivador grande 4 cajones', '2016-03-28', '200.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(551, '1', '1.2.1.1.11.', 'Estante Metalico', '2016-03-28', '60.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(550, '1', '1.2.1.2.2.', 'Computadora Portatil HP', '2016-03-28', '500.00', '0.00', 2, '1.2.', 1, 'Marzo', '2017'),
(549, '1', '1.1.2.1.34.', 'Lazo Loja Mauricio Salvador', '2016-03-28', '8515.30', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(548, '1', '1.1.3.2.7.', 'DUSTER TM 2.0 5P 4X2, PLOMO, 2013, LBB3338', '2016-03-28', '20000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(547, '1', '1.1.2.1.71.', 'Vitonera Ayala Feliz Antonio', '2016-03-28', '2459.97', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(546, '1', '1.1.2.1.4.', 'Shinig Cobo Jorge Marcelo', '2016-03-28', '12800.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(545, '1', '1.1.2.1.40.', 'Andrade Torres Daniel Alejandro', '2016-03-28', '2953.32', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(544, '1', '1.1.3.2.13.', 'AA PRIUS C SPORT TA 1.5 5P 4X2, BLANCO, 2012,', '2016-03-28', '20500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(543, '1', '1.1.2.1.10.', 'Cruz Segarra Rodrigo Alexander', '2016-03-28', '2200.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(542, '1', '1.1.2.1.77.', 'Tenezaca Minchalo Luis Antonio', '2016-03-28', '1254.11', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(541, '1', '1.1.2.1.47.', 'Rosales Bailon Milton Ricardo', '2016-03-28', '4399.96', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(540, '1', '1.1.3.2.21.', 'RANGER XLS 2.5 CD 4X2 TM, PLOMO, 2012, ABD323', '2016-03-28', '28000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(539, '1', '1.1.2.1.16.', 'Pesantez Lucuriaga Patricio Aurelio', '2016-03-28', '1000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(538, '1', '1.1.2.1.84.', 'Samaniego Sanchez Wilmnr Leonardo', '2016-03-28', '1212.43', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(537, '1', '1.1.1.2.', 'BANCOS', '2016-03-28', '0.00', '1473.96', 2, '1.1.', 1, 'Marzo', '2017'),
(536, '1', '1.1.2.1.53.', 'Portilla Rodas Roberto Carlos', '2016-03-28', '4949.94', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(535, '1', '1.1.2.1.23.', 'Dreer Ginanneschi Esteban Javier', '2016-03-28', '3920.90', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(534, '1', '1.1.2.1.95.', 'Guzman Moyano Pablo Ramiro', '2016-03-28', '2450.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(533, '1', '1.1.5.1.1.', 'Iva en Compras', '2016-03-28', '212.52', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(532, '1', '1.1.2.1.60.', 'Loyola Zambrano Arturo Leonardo', '2016-03-28', '1400.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(531, '1', '1.1.2.1.29.', 'Paredes Quintero Viviana Carolina', '2016-03-28', '1049.52', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(530, '1', '1.1.3.2.2.', 'AVEO FAMILY STD 1.5 4P 4X2, PLOMO, 2013, ABD4', '2016-03-28', '11100.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(529, '1', '1.1.2.1.66.', 'Matailo Cajamarca Felix Isaac', '2016-03-28', '855.72', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(528, '1', '1.1.2.1.35.', 'Murillo Cobos Jose Vicente', '2016-03-28', '23749.98', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(527, '1', '1.1.3.2.8.', 'X-TRAIL ADAVENCE CBT AC 2.5 5P 4X2, PLOMO, 20', '2016-03-28', '80000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(526, '1', '1.1.2.1.72.', 'Amoroso Abril Carla Paola', '2016-03-28', '549.94', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(525, '1', '1.1.2.1.5.', 'Calvache Rodas Carlos Luis', '2016-03-28', '13500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(524, '1', '1.1.2.1.41.', 'Ramirez Infante Miguel Angel', '2016-03-28', '5199.96', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(523, '1', '1.1.3.2.15.', 'MAZDA3 SPORT 2.0 MT FL, PLOMO, 2008', '2016-03-28', '16800.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(522, '1', '1.1.2.1.11.', 'Salamea Maldonado Christian Gonzalo', '2016-03-28', '23500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(521, '1', '1.1.2.1.78.', 'Tenenpaguay Guaman Jorge Adrian', '2016-03-28', '2824.90', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(520, '1', '1.1.2.1.48.', 'Gonzalez Lopez Carlos Fernando', '2016-03-28', '12300.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(519, '1', '1.1.3.2.22.', 'FORSA, 1988, ROJO, PJE0649', '2016-03-28', '4000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(518, '1', '1.1.2.1.18.', 'Pihuave Cruz Karla Elizabeth', '2016-03-28', '11144.44', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(517, '1', '1.1.2.1.88.', 'Armijos Astudillo Clodomiro', '2016-03-28', '1000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(516, '1', '1.1.2.1.54.', 'Segovia Barros Evelyn Patricia', '2016-03-28', '4756.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(515, '1', '1.1.2.1.24.', 'Bautista Guzman Jose Fernando', '2016-03-28', '5625.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(514, '1', '1.1.2.1.96.', 'Yuqui Ponce Hilda Raquel', '2016-03-28', '7000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(513, '1', '1.1.2.1.61.', 'Campoverde Borja Geovanny Paul', '2016-03-28', '9094.40', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(512, '1', '1.1.2.1.30.', 'Fraga Luke Odalis', '2016-03-28', '8433.32', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(511, '1', '1.1.3.2.3.', 'AVEO ACTIVO 1.6L 5P AC, NEGRO, 2010, ABA1261', '2016-03-28', '12100.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(510, '1', '1.1.2.1.67.', 'Tamayo Cabrera Juan Diego', '2016-03-28', '4012.40', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(509, '1', '1.1.2.1.36.', 'Leon Nazareno Jerry Gabriel', '2016-03-28', '6833.32', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(508, '1', '1.1.3.2.9.', 'AVEO FAMILY STD 1.5 4P 4X2 TM, NEGRO, 2015, A', '2016-03-28', '12800.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(507, '1', '1.1.2.1.6.', 'Dominguez Cabrera Geovanny Humberto', '2016-03-28', '9843.50', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(506, '1', '1.1.2.1.73.', 'Tamayo Anzotegui Alez Ivan', '2016-03-28', '1033.20', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(505, '1', '1.1.2.1.42.', 'Corozo Junco Carlos Ricardo', '2016-03-28', '10874.98', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(504, '1', '1.1.3.2.17.', 'LUV C/S 4X2 T/M INYEC, PLOMO, 2005, HCI0914', '2016-03-28', '10800.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(503, '1', '1.1.2.1.12.', 'Calvache Rodas Jorge Andres', '2016-03-28', '40000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(502, '1', '1.1.2.1.79.', 'Coellar IÃ±iguez Gladys Marlene', '2016-03-28', '2522.60', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(501, '1', '1.1.2.1.49.', 'Vazquez Vintimilla Pablo Andres', '2016-03-28', '7779.82', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(500, '1', '1.1.2.1.19.', 'Pelaez Luzuriaga Jprge Rafael', '2016-03-28', '2999.98', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(499, '1', '1.1.2.1.89.', 'Galin Sanchez Monica Catalina', '2016-03-28', '900.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(498, '1', '1.1.1.1.1.', 'Caja Chica', '2016-03-28', '0.00', '5.00', 2, '1.1.', 1, 'Marzo', '2017'),
(497, '1', '1.1.2.1.55.', 'Astudillo Valdiviezo Paul Marcelo', '2016-03-28', '900.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(496, '1', '1.1.2.1.25.', 'Espinoza Calle Juan Pablo', '2016-03-28', '8312.48', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(495, '1', '1.1.2.1.97.', 'Guadalupe Bravo Nicolay Emerson', '2016-03-28', '4700.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(494, '1', '1.1.2.1.62.', 'Paz Reyes Hector Arcersio', '2016-03-28', '400.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(493, '1', '1.1.2.1.31.', 'Nagua Loja Jorge Luis', '2016-03-28', '4266.68', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(492, '1', '1.1.3.2.4.', 'SPORTAGE LX, 2013, PLATEADO, ABD6611', '2016-03-28', '22000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(491, '1', '1.1.2.1.1.', 'Arevalo Gomez Luis Robbinson', '2016-03-28', '6500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(490, '1', '1.1.2.1.68.', 'Bonete Leon Cinthia Liliana', '2016-03-28', '6200.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(489, '1', '1.1.2.1.99.', 'Otero Cordova Carla', '2016-03-28', '18241.66', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(488, '1', '1.1.2.1.37.', 'Choez Tomala Juan Antonio', '2016-03-28', '9941.58', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(487, '1', '1.1.3.2.10.', 'DMAX CRDI 3.0 CD 4X2 TM DIESEL, PLATEADO, 201', '2016-03-28', '53500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(486, '1', '1.1.2.1.7.', 'Pinos Ochoa Esteban Fernando', '2016-03-28', '18700.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(485, '1', '1.1.2.1.74.', 'Plua Pilay Jorge Marcelino', '2016-03-28', '3483.33', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(484, '1', '1.1.2.1.43.', 'Fernandez Bermeo Marco Antonio', '2016-03-28', '23200.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(483, '1', '1.1.3.1.3.', 'AVEO ACTIVO 1.6L 4P AC, PLOMO, 2009, PBG1685', '2016-03-28', '12200.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(482, '1', '1.1.2.1.13.', 'Vera Valdez Victor Guillermo', '2016-03-28', '3545.83', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(481, '1', '1.1.2.1.81.', 'Rosales Gonzalez Miguel Klever', '2016-03-28', '625.02', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(480, '1', '1.1.2.1.50.', 'Zhaguay Maquiza Juan Manuel', '2016-03-28', '2933.29', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(479, '1', '1.1.2.1.20.', 'LLivicura Tacuri Jaime Eduardo', '2016-03-28', '7000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(478, '1', '1.1.2.1.91.', 'Alvarez Palacios Pedro Xavier', '2016-03-28', '2800.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(477, '1', '1.1.1.1.2.', 'Caja General', '2016-03-28', '0.00', '6375.30', 2, '1.1.', 1, 'Marzo', '2017'),
(476, '1', '1.1.2.1.57.', 'Berru Medina MariÂ­a Jose', '2016-03-28', '8500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(475, '1', '1.1.2.1.26.', 'Vera Guilindro JazmaÂ­n Elizabeth', '2016-03-28', '5997.04', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(474, '1', '1.1.3.1.1.', 'TUCKSON GL GAA 4x2 T/A BHWDS6B, AZUL, 2006, P', '2016-03-28', '16700.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(473, '1', '1.1.2.1.63.', 'Zhunio Malla Efrain Lizardo', '2016-03-28', '2212.40', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(472, '1', '1.1.2.1.32.', 'MejiÂ­a Cuesta Marlon Patricio', '2016-03-28', '10458.30', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(471, '1', '1.1.3.2.5.', 'ECO SPORT XLT 4X2, 2007, PLOMO, AFN0761', '2016-03-28', '13500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(470, '1', '1.1.2.1.2.', 'Romo Padilla Alexandra Judiht', '2016-03-28', '14000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(469, '1', '1.1.2.1.69.', 'Vargas Chuquimarca Luis Antonio', '2016-03-28', '937.50', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(468, '1', '1.1.2.1.38.', 'Zambrano Bravo Marcelo Andres', '2016-03-28', '2955.52', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(467, '1', '1.1.3.2.11.', 'LUV D-MAX 3.0L DIESEL CD TM 4X4, PLATEADO, 20', '2016-03-28', '33500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(466, '1', '1.1.2.1.8.', 'Albuja Maldonado Franklin Teddy', '2016-03-28', '66731.46', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(465, '1', '1.1.2.1.75.', 'Chacon Narea Elsa Maribel', '2016-03-28', '5980.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(464, '1', '1.1.2.1.44.', 'Santana Vera Luis Bernardo', '2016-03-28', '21886.88', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(463, '1', '1.1.3.2.19.', 'SAIL STD TM 1.4 4P 4X2, PLATEADO, 2014, ABD96', '2016-03-28', '14000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(462, '1', '1.1.2.1.14.', 'Arciniegas Avila Patricio Nicloas', '2016-03-28', '3483.33', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(461, '1', '1.1.2.1.82.', 'Aucacama Chabla Marco Vinicio', '2016-03-28', '2443.77', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(460, '1', '1.1.2.1.51.', 'Flores GarciÂ­a Marcos Antonio', '2016-03-28', '1233.30', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(459, '1', '1.1.2.1.21.', 'Cojitambo Pinza Elvia de Jesus', '2016-03-28', '600.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(458, '1', '1.1.2.1.92.', 'Caldas Atiencia Mirian Patricia', '2016-03-28', '5008.50', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(457, '1', '1.1.1.2.1.', 'Banco del Pichincha', '2016-03-28', '0.00', '20000.00', 2, '1.1.', 1, 'Marzo', '2017'),
(456, '1', '1.1.2.1.58.', 'Maldonado Quezada Rolando Eduardo', '2016-03-28', '32.40', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(455, '1', '1.1.2.1.27.', 'Moscoso Loyola Juana Katalina', '2016-03-28', '9500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(454, '1', '1.1.3.1.2.', 'OPTRA ADVANCE 1.8L 4P TM, PLATEADO, 2012, ABB', '2016-03-28', '17900.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(453, '1', '1.1.2.1.64.', 'Coella Ugalde Christian Ernesto', '2016-03-28', '13000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(452, '1', '1.1.2.1.33.', 'Montesdeoca Coraizaca Gonzalo Eduardo', '2016-03-28', '7373.32', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(451, '1', '1.1.3.2.6.', 'GOLHB POWER AC 5U 11 F4, BLANCO, 2012, PCA506', '2016-03-28', '14100.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(450, '1', '1.1.2.1.70.', 'Herdoiza Bermeo Carmen Filomena', '2016-03-28', '3239.52', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(449, '1', '1.1.3.2.26.', 'GRAND VITARA SZ 2.0L 5P TM 4X2 ROJO 2009', '2016-03-28', '16500.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(448, '1', '1.1.2.1.3.', 'Torres Pesantez Maria Paulina', '2016-03-28', '5000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(447, '1', '1.1.2.1.39.', 'Chico Vasquez Jonathan Javier', '2016-03-28', '10200.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(446, '1', '1.1.3.2.12.', 'RIO REX TM 1.39 4P 4X2 ,AZUL, 2013, PCB1210', '2016-03-28', '18800.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(445, '1', '1.1.2.1.9.', 'Enderica Izquierdo Boris Esteban', '2016-03-28', '4800.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(444, '1', '1.1.2.1.76.', 'Moran Ochoa Oscar Vinicio', '2016-03-28', '3375.46', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(443, '1', '1.1.2.1.45.', 'Gonzalez Tapia Lauro Bolivar', '2016-03-28', '2291.74', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(442, '1', '1.1.3.2.20.', 'GRAND CHEROKEE LAREDO 4X2, CREMA, 2006, PQG05', '2016-03-28', '28000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(441, '1', '1.1.2.1.15.', 'Calle Calle Cesar Alfredo', '2016-03-28', '5175.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(440, '1', '1.1.2.1.83.', 'Pulla Aguilar Esther Maria', '2016-03-28', '1691.61', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(439, '1', '1.1.3.', 'REALIZABLE', '2016-03-28', '0.00', '11200.00', 2, '1.1.', 1, 'Marzo', '2017'),
(438, '1', '1.1.2.1.52.', 'Mayaguari Zhunio Ramiro de Jesus', '2016-03-28', '4000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(437, '1', '1.1.2.1.22.', 'Deleg Guzman Rosa Elvira', '2016-03-28', '7200.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(436, '1', '1.1.2.1.93.', 'Abad Molina Pablo Antonio', '2016-03-28', '10000.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(435, '1', '1.1.1.2.2.', 'Banco de Guayaquil', '2016-03-28', '0.00', '18084.06', 2, '1.1.', 1, 'Marzo', '2017'),
(434, '1', '1.1.2.1.59.', 'Delgado Leon Carlos Alberto', '2016-03-28', '5350.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(433, '1', '1.1.2.1.28.', 'Ramirez Yazbeka Plino Yamil', '2016-03-28', '2537.48', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(432, '1', '1.1.3.2.1.', 'MONTERO SPORT 5P 3.0TM FULL EQUIPO, PLOMO, 20', '2016-03-28', '21900.00', '0.00', 2, '1.1.', 1, 'Marzo', '2017'),
(431, '1', '1.1.2.1.65.', 'Lema Paredes Cleofe Edelmira', '2016-03-28', '588.05', '0.00', 2, '1.1.', 1, 'Marzo', '2017');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_grupo`
--

CREATE TABLE `t_grupo` (
  `nombre_grupo` char(45) NOT NULL,
  `cod_grupo` char(11) NOT NULL,
  `descrip_grupo` varchar(100) DEFAULT NULL,
  `t_clase_cod_clase` char(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_grupo`
--

INSERT INTO `t_grupo` (`nombre_grupo`, `cod_grupo`, `descrip_grupo`, `t_clase_cod_clase`) VALUES
('ACTIVO CORRIENTE', '1.1.', '', '1.'),
('ACTIVO NO CORRIENTE', '1.2.', '', '1.'),
('PASIVO CORRIENTE', '2.1.', '', '2.'),
('PASIVO NO CORRIENTE', '2.2.', '', '2.'),
('PATRIMONIO', '3.1.', '', '3.'),
('INGRESOS OPERACIONALES', '4.1.', '', '4.'),
('INGRESOS NO OPERACIONALES', '4.2.', '', '4.'),
('GASTOS NO OPERACIONALES', '5.1.', '', '5.'),
('COSTOS Y GASTOS OPERACIONALES', '5.2.', '', '5.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_plan_de_cuentas`
--

CREATE TABLE `t_plan_de_cuentas` (
  `idt_plan_de_cuentas` int(11) NOT NULL,
  `cod_cuenta` char(14) NOT NULL,
  `nombre_cuenta_plan` char(185) DEFAULT NULL,
  `descripcion_cuenta_plan` char(100) DEFAULT NULL,
  `t_clase_cod_clase` char(11) DEFAULT NULL,
  `t_grupo_cod_grupo` char(11) DEFAULT NULL,
  `t_cuenta_cod_cuenta` char(11) DEFAULT NULL,
  `t_subcuenta_cod_subcuenta` char(20) DEFAULT NULL,
  `t_auxiliar_cod_cauxiliar` char(20) DEFAULT NULL,
  `t_subauxiliar_cod_subauxiliar` char(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_plan_de_cuentas`
--

INSERT INTO `t_plan_de_cuentas` (`idt_plan_de_cuentas`, `cod_cuenta`, `nombre_cuenta_plan`, `descripcion_cuenta_plan`, `t_clase_cod_clase`, `t_grupo_cod_grupo`, `t_cuenta_cod_cuenta`, `t_subcuenta_cod_subcuenta`, `t_auxiliar_cod_cauxiliar`, `t_subauxiliar_cod_subauxiliar`) VALUES
(1, '1.', 'ACTIVO', '', '1.', NULL, NULL, NULL, NULL, ''),
(2, '2.', 'PASIVO', '', '2.', NULL, NULL, NULL, NULL, ''),
(3, '3.', 'PATRIMONIO', '', '3.', NULL, NULL, NULL, NULL, ''),
(4, '4.', 'INGRESOS', '', '4.', NULL, NULL, NULL, NULL, ''),
(5, '5.', 'COSTOS Y GASTOS', '', '5.', NULL, NULL, NULL, NULL, ''),
(7, '1.1.', 'ACTIVO CORRIENTE', '', '1.', '1.1.', NULL, NULL, NULL, ''),
(8, '1.2.', 'ACTIVO NO CORRIENTE', '', '1.', '1.2.', NULL, NULL, NULL, ''),
(9, '2.1.', 'PASIVO CORRIENTE', '', '2.', '2.1.', NULL, NULL, NULL, ''),
(10, '2.2.', 'PASIVO NO CORRIENTE', '', '2.', '2.2.', NULL, NULL, NULL, ''),
(11, '3.1.', 'PATRIMONIO', '', '3.', '3.1.', NULL, NULL, NULL, ''),
(12, '4.1.', 'INGRESOS OPERACIONALES', '', '4.', '4.1.', NULL, NULL, NULL, ''),
(13, '4.2.', 'INGRESOS NO OPERACIONALES', '', '4.', '4.2.', NULL, NULL, NULL, ''),
(14, '5.1.', 'COSTOS Y GASTOS OPERACIONALES', '', '5.', '5.1.', NULL, NULL, NULL, ''),
(15, '5.2.', 'GASTOS NO OPERACIONALES', '', '5.', '5.2.', NULL, NULL, NULL, ''),
(16, '1.1.1.', 'DISPONIBLE', '', NULL, '1.1.', '1.1.1.', NULL, NULL, ''),
(17, '1.1.2.', 'EXIGIBLE', '', NULL, '1.1.', '1.1.2.', NULL, NULL, ''),
(18, '1.1.3.', 'REALIZABLE', '', NULL, '1.1.', '1.1.3.', NULL, NULL, ''),
(19, '1.2.1.', 'DEPRECIABLE', '', NULL, '1.2.', '1.2.1.', NULL, NULL, ''),
(20, '1.2.2.', 'NO DEPRECIABLE', '', NULL, '1.2.', '1.2.2.', NULL, NULL, ''),
(21, '1.1.4.', 'SERVICIOS Y PAGOS ANTICIPADOS', '', NULL, '1.1.', '1.1.4.', NULL, NULL, ''),
(22, '1.1.5.', 'ACTIVOS POR IMPUESTOS CORRIENTES', '', NULL, '1.1.', '1.1.5.', NULL, NULL, ''),
(23, '2.1.1.', 'EXIGIBLE', '', NULL, '2.1.', '2.1.1.', NULL, NULL, ''),
(24, '2.2.1.', 'EXIGIBLE A LARGO PLAZO', '', NULL, '2.2.', '2.2.1.', NULL, NULL, ''),
(25, '3.1.1.', 'CAPITAL Y RESERVAS', '', NULL, '3.1.', '3.1.1.', NULL, NULL, ''),
(26, '4.1.1.', 'INGRESOS X COMISION Y CONSIGNACION', '', NULL, '4.1.', '4.1.1.', NULL, NULL, ''),
(27, '4.2.1.', 'OTROS INGRESOS NO OPERACIONALES', '', NULL, '4.2.', '4.2.1.', NULL, NULL, ''),
(28, '5.1.1.', 'GASTOS OPERATIVOS, ADMINISTRACION Y VENTAS', '', NULL, '5.1.', '5.1.1.', NULL, NULL, ''),
(29, '1.1.1.1.', 'CAJAS', '', NULL, '1.1.', '1.1.1.', '1.1.1.1.', NULL, ''),
(30, '2.1.1.1.', 'SUELDOS Y BENEFICIOS SOCIALES X PAGAR', '', NULL, '2.1.', '2.1.1.', '2.1.1.1.', NULL, ''),
(31, '2.1.1.2.', 'PROVEEDORES', '', NULL, '2.1.', '2.1.1.', '2.1.1.2.', NULL, ''),
(32, '2.1.1.3.', 'DEUDAS FISCALES', '', NULL, '2.1.', '2.1.1.', '2.1.1.3.', NULL, ''),
(33, '2.2.1.1.', 'BANCARIOS X PAGAR A LARGO PLAZO', '', NULL, '2.2.', '2.2.1.', '2.2.1.1.', NULL, ''),
(34, '2.2.1.2.', 'CUENTAS X PAGAR LARGO PLAZO', '', NULL, '2.2.', '2.2.1.', '2.2.1.2.', NULL, ''),
(35, '1.2.1.1.', 'MUEBLES Y ENSERES', '', NULL, '1.2.', '1.2.1.', '1.2.1.1.', NULL, ''),
(36, '1.2.1.2.', 'EQUIPOS DE COMPUTACION', '', NULL, '1.2.', '1.2.1.', '1.2.1.2.', NULL, ''),
(37, '1.2.1.3.', '(-) DEP. ACUM. MUEBLES Y ENSERES', '', NULL, '1.2.', '1.2.1.', '1.2.1.3.', NULL, ''),
(38, '1.2.1.4.', '(-) DEP. ACUM. EQUIPOS DE COMPUTACION', '', NULL, '1.2.', '1.2.1.', '1.2.1.4.', NULL, ''),
(39, '1.1.2.1.', 'CUENTAS X COBRAR CLIENTES', '', NULL, '1.1.', '1.1.2.', '1.1.2.1.', NULL, ''),
(40, '1.1.3.1.', 'INVENTARIOS DE VEHICULOS EN CONSIGNACION', '', NULL, '1.1.', '1.1.3.', '1.1.3.1.', NULL, ''),
(41, '1.1.5.1.', 'IMPUESTOS', '', NULL, '1.1.', '1.1.5.', '1.1.5.1.', NULL, ''),
(42, '1.1.1.2.', 'BANCOS', '', NULL, '1.1.', '1.1.1.', '1.1.1.2.', NULL, ''),
(43, '3.1.1.1.', 'CAPITAL', '', NULL, '3.1.', '3.1.1.', '3.1.1.1.', NULL, ''),
(44, '3.1.1.2.', 'RESERVAS', '', NULL, '3.1.', '3.1.1.', '3.1.1.2.', NULL, ''),
(45, '4.1.1.1.', 'INGRESOS X COMISION EN VENTA DE VEHICULOS', '', NULL, '4.1.', '4.1.1.', '4.1.1.1.', NULL, ''),
(46, '4.1.1.2.', 'INGRESOS X CONSIGNACION DE VEHICULOS', '', NULL, '4.1.', '4.1.1.', '4.1.1.2.', NULL, ''),
(47, '5.1.1.1.', 'GASTOS OPERATIVOS', '', NULL, '5.1.', '5.1.1.', '5.1.1.1.', NULL, ''),
(48, '5.1.1.2.', 'GASTOS ADMINISTRATIVOS', '', NULL, '5.1.', '5.1.1.', '5.1.1.2.', NULL, ''),
(49, '5.1.1.3.', 'GASTOS DE VENTAS', '', NULL, '5.1.', '5.1.1.', '5.1.1.3.', NULL, ''),
(50, '1.1.3.2.', 'INVENTARIO DE VEHICULOS COMISION', '', NULL, '1.1.', '1.1.3.', '1.1.3.2.', NULL, ''),
(51, '1.1.1.1.1.', 'Caja Chica', '', '1.', '1.1.', '1.1.1.', '1.1.1.1.', '1.1.1.1.1.', 'NULL'),
(52, '1.1.1.1.2.', 'Caja General', '', '1.', '1.1.', '1.1.1.', '1.1.1.1.', '1.1.1.1.2.', 'NULL'),
(53, '1.1.1.2.1.', 'Banco del Pichincha', '', '1.', '1.1.', '1.1.1.', '1.1.1.2.', '1.1.1.2.1.', 'NULL'),
(54, '1.1.1.2.2.', 'Banco de Guayaquil', '', '1.', '1.1.', '1.1.1.', '1.1.1.2.', '1.1.1.2.2.', 'NULL'),
(55, '1.1.5.1.1.', 'Iva en Compras', '', '1.', '1.1.', '1.1.5.', '1.1.5.1.', '1.1.5.1.1.', 'NULL'),
(56, '2.1.1.1.1.', 'Sueldos y Salarios X Pagar', '', '2.', '2.1.', '2.1.1.', '2.1.1.1.', '2.1.1.1.1.', 'NULL'),
(57, '2.1.1.1.2.', 'Decimo tercer sueldo', '', '2.', '2.1.', '2.1.1.', '2.1.1.1.', '2.1.1.1.2.', 'NULL'),
(58, '2.1.1.1.3.', 'Decimo cuarto sueldo', '', '2.', '2.1.', '2.1.1.', '2.1.1.1.', '2.1.1.1.3.', 'NULL'),
(59, '2.1.1.1.4.', 'Fondos de Reserva', '', '2.', '2.1.', '2.1.1.', '2.1.1.1.', '2.1.1.1.4.', 'NULL'),
(60, '2.1.1.1.5.', 'Aporte Patronal', '', '2.', '2.1.', '2.1.1.', '2.1.1.1.', '2.1.1.1.5.', 'NULL'),
(61, '2.1.1.1.6.', 'Vacaciones', '', '2.', '2.1.', '2.1.1.', '2.1.1.1.', '2.1.1.1.6.', 'NULL'),
(62, '2.1.1.3.1.', 'Iva en Ventas', '', '2.', '2.1.', '2.1.1.', '2.1.1.3.', '2.1.1.3.1.', 'NULL'),
(63, '5.1.1.1.1.', 'Gastos x combustible', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.1.', 'NULL'),
(64, '5.1.1.1.2.', 'Gastos x repuestos', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.2.', 'NULL'),
(65, '5.1.1.1.3.', 'Gastos x mantenimiento', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.3.', 'NULL'),
(66, '5.1.1.1.4.', 'Gastos x servicios de electricista', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.4.', 'NULL'),
(67, '5.1.1.1.5.', 'Gastos x plasticos y tapices', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.5.', 'NULL'),
(68, '5.1.1.1.6.', 'Gastos de latoneria', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.6.', 'NULL'),
(69, '5.1.1.1.7.', 'Gastos de mecanico', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.7.', 'NULL'),
(70, '5.1.1.1.8.', 'Gastos x neumaticos', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.8.', 'NULL'),
(71, '5.1.1.1.9.', 'Gastos x suministros de limpieza', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.9.', 'NULL'),
(72, '5.1.1.1.10.', 'Otros Gastos Operativos', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.10.', 'NULL'),
(73, '5.1.1.2.1.', 'Gastos x Arriendo', '', '5.', '5.1.', '5.1.1.', '5.1.1.2.', '5.1.1.2.1.', 'NULL'),
(74, '5.1.1.2.2.', 'Gastos x suministros de oficina', '', '5.', '5.1.', '5.1.1.', '5.1.1.2.', '5.1.1.2.2.', 'NULL'),
(75, '5.1.1.2.3.', 'Gastos x sueldos y salarios', '', '5.', '5.1.', '5.1.1.', '5.1.1.2.', '5.1.1.2.3.', 'NULL'),
(76, '5.1.1.2.4.', 'Gastos x servicios basicos', '', '5.', '5.1.', '5.1.1.', '5.1.1.2.', '5.1.1.2.4.', 'NULL'),
(77, '5.1.1.2.5.', 'Gastos x monitoreo y seguridad', '', '5.', '5.1.', '5.1.1.', '5.1.1.2.', '5.1.1.2.5.', 'NULL'),
(78, '5.1.1.2.6.', 'Otros Gastos Administrativos', '', '5.', '5.1.', '5.1.1.', '5.1.1.2.', '5.1.1.2.6.', 'NULL'),
(80, '5.1.1.3.1.', 'Gastos x suministros de oficina', '', '5.', '5.1.', '5.1.1.', '5.1.1.3.', '5.1.1.3.1.', 'NULL'),
(81, '5.1.1.3.2.', 'Otros gastos de ventas', '', '5.', '5.1.', '5.1.1.', '5.1.1.3.', '5.1.1.3.2.', 'NULL'),
(82, '1.1.2.1.1.', 'Arevalo Gomez Luis Robbinson', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.1.', 'NULL'),
(83, '1.1.2.1.2.', 'Romo Padilla Alexandra Judiht', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.2.', 'NULL'),
(84, '1.1.2.1.3.', 'Torres Pesantez Maria Paulina', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.3.', 'NULL'),
(85, '1.1.2.1.4.', 'Shinig Cobo Jorge Marcelo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.4.', 'NULL'),
(86, '1.1.2.1.5.', 'Calvache Rodas Carlos Luis', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.5.', 'NULL'),
(87, '1.1.2.1.6.', 'Dominguez Cabrera Geovanny Humberto', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.6.', 'NULL'),
(88, '1.1.2.1.7.', 'Pinos Ochoa Esteban Fernando', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.7.', 'NULL'),
(89, '1.1.2.1.8.', 'Albuja Maldonado Franklin Teddy', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.8.', 'NULL'),
(90, '1.1.2.1.9.', 'Enderica Izquierdo Boris Esteban', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.9.', 'NULL'),
(91, '1.1.2.1.10.', 'Cruz Segarra Rodrigo Alexander', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.10.', 'NULL'),
(92, '1.1.2.1.11.', 'Salamea Maldonado Christian Gonzalo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.11.', 'NULL'),
(93, '1.1.2.1.12.', 'Calvache Rodas Jorge Andres', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.12.', 'NULL'),
(94, '1.1.2.1.13.', 'Vera Valdez Victor Guillermo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.13.', 'NULL'),
(95, '1.1.2.1.14.', 'Arciniegas Avila Patricio Nicloas', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.14.', 'NULL'),
(96, '1.1.2.1.15.', 'Calle Calle Cesar Alfredo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.15.', 'NULL'),
(97, '1.1.2.1.16.', 'Pesantez Lucuriaga Patricio Aurelio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.16.', 'NULL'),
(98, '1.1.2.1.17.', 'Gonzalez Zapata Erica Maria', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.17.', 'NULL'),
(99, '1.1.2.1.18.', 'Pihuave Cruz Karla Elizabeth', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.18.', 'NULL'),
(100, '1.1.2.1.19.', 'Pelaez Luzuriaga Jprge Rafael', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.19.', 'NULL'),
(101, '1.1.2.1.20.', 'LLivicura Tacuri Jaime Eduardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.20.', 'NULL'),
(102, '1.1.2.1.21.', 'Cojitambo Pinza Elvia de Jesus', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.21.', 'NULL'),
(103, '1.1.2.1.22.', 'Deleg Guzman Rosa Elvira', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.22.', 'NULL'),
(104, '1.1.2.1.23.', 'Dreer Ginanneschi Esteban Javier', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.23.', 'NULL'),
(105, '1.1.2.1.24.', 'Bautista Guzman Jose Fernando', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.24.', 'NULL'),
(106, '1.1.2.1.25.', 'Espinoza Calle Juan Pablo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.25.', 'NULL'),
(107, '1.1.2.1.26.', 'Vera Guilindro JazmaÂ­n Elizabeth', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.26.', 'NULL'),
(108, '1.1.2.1.27.', 'Moscoso Loyola Juana Katalina', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.27.', 'NULL'),
(109, '1.1.2.1.28.', 'Ramirez Yazbeka Plino Yamil', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.28.', 'NULL'),
(110, '1.1.2.1.29.', 'Paredes Quintero Viviana Carolina', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.29.', 'NULL'),
(111, '1.1.2.1.30.', 'Fraga Luke Odalis', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.30.', 'NULL'),
(112, '1.1.2.1.31.', 'Nagua Loja Jorge Luis', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.31.', 'NULL'),
(113, '1.1.2.1.32.', 'MejiÂ­a Cuesta Marlon Patricio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.32.', 'NULL'),
(114, '1.1.2.1.33.', 'Montesdeoca Coraizaca Gonzalo Eduardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.33.', 'NULL'),
(115, '1.1.2.1.34.', 'Lazo Loja Mauricio Salvador', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.34.', 'NULL'),
(116, '1.1.2.1.35.', 'Murillo Cobos Jose Vicente', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.35.', 'NULL'),
(117, '1.1.2.1.36.', 'Leon Nazareno Jerry Gabriel', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.36.', 'NULL'),
(118, '1.1.2.1.37.', 'Choez Tomala Juan Antonio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.37.', 'NULL'),
(119, '1.1.2.1.38.', 'Zambrano Bravo Marcelo Andres', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.38.', 'NULL'),
(120, '1.1.2.1.39.', 'Chico Vasquez Jonathan Javier', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.39.', 'NULL'),
(121, '1.1.2.1.40.', 'Andrade Torres Daniel Alejandro', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.40.', 'NULL'),
(122, '1.1.2.1.41.', 'Ramirez Infante Miguel Angel', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.41.', 'NULL'),
(123, '1.1.2.1.42.', 'Corozo Junco Carlos Ricardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.42.', 'NULL'),
(124, '1.1.2.1.43.', 'Fernandez Bermeo Marco Antonio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.43.', 'NULL'),
(125, '1.1.2.1.44.', 'Santana Vera Luis Bernardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.44.', 'NULL'),
(126, '1.1.2.1.45.', 'Gonzalez Tapia Lauro Bolivar', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.45.', 'NULL'),
(127, '1.1.2.1.46.', 'MuÃ±oz Cabrera Efrain Estuardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.46.', 'NULL'),
(128, '1.1.2.1.47.', 'Rosales Bailon Milton Ricardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.47.', 'NULL'),
(129, '1.1.2.1.48.', 'Gonzalez Lopez Carlos Fernando', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.48.', 'NULL'),
(130, '1.1.2.1.49.', 'Vazquez Vintimilla Pablo Andres', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.49.', 'NULL'),
(131, '1.1.2.1.50.', 'Zhaguay Maquiza Juan Manuel', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.50.', 'NULL'),
(132, '1.1.2.1.51.', 'Flores GarciÂ­a Marcos Antonio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.51.', 'NULL'),
(133, '1.1.2.1.52.', 'Mayaguari Zhunio Ramiro de Jesus', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.52.', 'NULL'),
(134, '1.1.2.1.53.', 'Portilla Rodas Roberto Carlos', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.53.', 'NULL'),
(135, '1.1.2.1.54.', 'Segovia Barros Evelyn Patricia', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.54.', 'NULL'),
(136, '1.1.2.1.55.', 'Astudillo Valdiviezo Paul Marcelo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.55.', 'NULL'),
(137, '1.1.2.1.56.', 'MuÃ±oz Granda Ivan Eduardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.56.', 'NULL'),
(138, '1.1.2.1.57.', 'Berru Medina MariÂ­a Jose', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.57.', 'NULL'),
(139, '1.1.2.1.58.', 'Maldonado Quezada Rolando Eduardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.58.', 'NULL'),
(140, '1.1.2.1.59.', 'Delgado Leon Carlos Alberto', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.59.', 'NULL'),
(141, '1.1.2.1.60.', 'Loyola Zambrano Arturo Leonardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.60.', 'NULL'),
(142, '1.1.2.1.61.', 'Campoverde Borja Geovanny Paul', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.61.', 'NULL'),
(143, '1.1.2.1.62.', 'Paz Reyes Hector Arcersio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.62.', 'NULL'),
(144, '1.1.2.1.63.', 'Zhunio Malla Efrain Lizardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.63.', 'NULL'),
(145, '1.1.2.1.64.', 'Coella Ugalde Christian Ernesto', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.64.', 'NULL'),
(146, '1.1.2.1.65.', 'Lema Paredes Cleofe Edelmira', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.65.', 'NULL'),
(147, '1.1.2.1.66.', 'Matailo Cajamarca Felix Isaac', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.66.', 'NULL'),
(148, '1.1.2.1.67.', 'Tamayo Cabrera Juan Diego', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.67.', 'NULL'),
(149, '1.1.2.1.68.', 'Bonete Leon Cinthia Liliana', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.68.', 'NULL'),
(150, '1.1.2.1.69.', 'Vargas Chuquimarca Luis Antonio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.69.', 'NULL'),
(151, '1.1.2.1.70.', 'Herdoiza Bermeo Carmen Filomena', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.70.', 'NULL'),
(152, '1.1.2.1.71.', 'Vitonera Ayala Feliz Antonio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.71.', 'NULL'),
(153, '1.1.2.1.72.', 'Amoroso Abril Carla Paola', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.72.', 'NULL'),
(154, '1.1.2.1.73.', 'Tamayo Anzotegui Alez Ivan', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.73.', 'NULL'),
(155, '1.1.2.1.74.', 'Plua Pilay Jorge Marcelino', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.74.', 'NULL'),
(156, '1.1.2.1.75.', 'Chacon Narea Elsa Maribel', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.75.', 'NULL'),
(157, '1.1.2.1.76.', 'Moran Ochoa Oscar Vinicio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.76.', 'NULL'),
(158, '1.1.2.1.77.', 'Tenezaca Minchalo Luis Antonio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.77.', 'NULL'),
(159, '1.1.2.1.78.', 'Tenenpaguay Guaman Jorge Adrian', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.78.', 'NULL'),
(160, '1.1.2.1.79.', 'Coellar IÃ±iguez Gladys Marlene', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.79.', 'NULL'),
(161, '1.1.2.1.80.', 'MariÂ­n MuÃ±oz Rodrigo Domingo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.80.', 'NULL'),
(162, '1.1.2.1.81.', 'Rosales Gonzalez Miguel Klever', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.81.', 'NULL'),
(163, '1.1.2.1.82.', 'Aucacama Chabla Marco Vinicio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.82.', 'NULL'),
(164, '1.1.2.1.83.', 'Pulla Aguilar Esther Maria', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.83.', 'NULL'),
(165, '1.1.2.1.84.', 'Samaniego Sanchez Wilmnr Leonardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.84.', 'NULL'),
(166, '1.1.2.1.85.', 'Chungata Pillajo Rigoberto Wilfrido', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.85.', 'NULL'),
(167, '1.1.2.1.86.', 'Tamay Saa Henry Lenin', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.86.', 'NULL'),
(168, '1.1.2.1.87.', 'Leon Alvarez Milton Ricardo', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.87.', 'NULL'),
(169, '1.1.2.1.88.', 'Armijos Astudillo Clodomiro', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.88.', 'NULL'),
(170, '1.1.2.1.89.', 'Galin Sanchez Monica Catalina', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.89.', 'NULL'),
(171, '1.1.2.1.90.', 'Coellar Ugalde Christian Ernesto', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.90.', 'NULL'),
(172, '1.1.2.1.91.', 'Alvarez Palacios Pedro Xavier', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.91.', 'NULL'),
(173, '1.1.2.1.92.', 'Caldas Atiencia Mirian Patricia', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.92.', 'NULL'),
(174, '1.1.2.1.93.', 'Abad Molina Pablo Antonio', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.93.', 'NULL'),
(175, '1.1.2.1.94.', 'Mora Matamorros Manuel Alberto', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.94.', 'NULL'),
(176, '1.1.2.1.95.', 'Guzman Moyano Pablo Ramiro', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.95.', 'NULL'),
(177, '1.1.2.1.96.', 'Yuqui Ponce Hilda Raquel', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.96.', 'NULL'),
(178, '1.1.2.1.97.', 'Guadalupe Bravo Nicolay Emerson', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.97.', 'NULL'),
(179, '1.1.2.1.98.', 'Chapa Perez Sandra Nivelia', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.98.', 'NULL'),
(180, '1.1.3.1.1.', 'TUCKSON GL GAA 4x2 T/A BHWDS6B, AZUL, 2006, P', '', '1.', '1.1.', '1.1.3.', '1.1.3.1.', '1.1.3.1.1.', 'NULL'),
(181, '1.1.3.1.2.', 'OPTRA ADVANCE 1.8L 4P TM, PLATEADO, 2012, ABB', '', '1.', '1.1.', '1.1.3.', '1.1.3.1.', '1.1.3.1.2.', 'NULL'),
(182, '1.1.3.2.1.', 'MONTERO SPORT 5P 3.0TM FULL EQUIPO, PLOMO, 20', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.1.', 'NULL'),
(183, '1.1.3.2.2.', 'AVEO FAMILY STD 1.5 4P 4X2, PLOMO, 2013, ABD4', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.2.', 'NULL'),
(184, '1.1.3.2.3.', 'AVEO ACTIVO 1.6L 5P AC, NEGRO, 2010, ABA1261', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.3.', 'NULL'),
(185, '1.1.3.2.4.', 'SPORTAGE LX, 2013, PLATEADO, ABD6611', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.4.', 'NULL'),
(186, '1.1.3.2.5.', 'ECO SPORT XLT 4X2, 2007, PLOMO, AFN0761', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.5.', 'NULL'),
(187, '1.1.3.2.6.', 'GOLHB POWER AC 5U 11 F4, BLANCO, 2012, PCA506', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.6.', 'NULL'),
(188, '1.1.3.2.7.', 'DUSTER TM 2.0 5P 4X2, PLOMO, 2013, LBB3338', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.7.', 'NULL'),
(189, '1.1.3.2.8.', 'X-TRAIL ADAVENCE CBT AC 2.5 5P 4X2, PLOMO, 20', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.8.', 'NULL'),
(190, '1.1.3.2.9.', 'AVEO FAMILY STD 1.5 4P 4X2 TM, NEGRO, 2015, A', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.9.', 'NULL'),
(191, '1.1.3.2.10.', 'DMAX CRDI 3.0 CD 4X2 TM DIESEL, PLATEADO, 201', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.10.', 'NULL'),
(192, '1.1.3.2.11.', 'LUV D-MAX 3.0L DIESEL CD TM 4X4, PLATEADO, 20', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.11.', 'NULL'),
(193, '1.1.3.2.12.', 'RIO REX TM 1.39 4P 4X2 ,AZUL, 2013, PCB1210', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.12.', 'NULL'),
(194, '1.1.3.2.13.', 'AA PRIUS C SPORT TA 1.5 5P 4X2, BLANCO, 2012,', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.13.', 'NULL'),
(195, '1.1.3.2.14.', 'CET HILUX 4X2 CD NO AA DIESEL, BLANCO, 2010,', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.14.', 'NULL'),
(196, '1.1.3.2.15.', 'MAZDA3 SPORT 2.0 MT FL, PLOMO, 2008', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.15.', 'NULL'),
(197, '1.1.3.2.16.', 'GRAGRAND VITARA SZ 2.7L B6 5P TA 4X4, BLANCO,', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.16.', 'NULL'),
(198, '1.1.3.2.17.', 'LUV C/S 4X2 T/M INYEC, PLOMO, 2005, HCI0914', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.17.', 'NULL'),
(199, '1.1.3.1.3.', 'AVEO ACTIVO 1.6L 4P AC, PLOMO, 2009, PBG1685', '', '1.', '1.1.', '1.1.3.', '1.1.3.1.', '1.1.3.1.3.', 'NULL'),
(200, '1.1.3.2.18.', 'SPORTAGE R 2.06L 4X2 GSL MT AC, NEGRO, 2011,', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.18.', 'NULL'),
(201, '1.1.3.2.19.', 'SAIL STD TM 1.4 4P 4X2, PLATEADO, 2014, ABD96', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.19.', 'NULL'),
(202, '1.1.3.2.20.', 'GRAND CHEROKEE LAREDO 4X2, CREMA, 2006, PQG05', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.20.', 'NULL'),
(203, '1.1.3.2.21.', 'RANGER XLS 2.5 CD 4X2 TM, PLOMO, 2012, ABD323', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.21.', 'NULL'),
(204, '1.1.3.2.22.', 'FORSA, 1988, ROJO, PJE0649', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.22.', 'NULL'),
(205, '1.1.3.2.23.', 'D-MAX SERDI 3.0 CD 4X2 TM DIESEL, NEGRO, 2014', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.23.', 'NULL'),
(206, '1.2.1.1.16.', 'Escritorio 5 cajones', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.16.', 'NULL'),
(207, '1.2.1.1.2.', 'Escritorio 3 cajones', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.2.', 'NULL'),
(208, '1.2.1.1.3.', 'Esquinero pequeÃ±o', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.3.', 'NULL'),
(209, '1.2.1.1.4.', 'Mueble Cafetera', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.4.', 'NULL'),
(210, '1.2.1.1.5.', 'Archivador grande 4 cajones', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.5.', 'NULL'),
(211, '1.2.1.1.6.', 'Archivador pequeÃ±o 4 cajones', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.6.', 'NULL'),
(212, '1.2.1.1.7.', 'Escritorio 1 cajon', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.7.', 'NULL'),
(213, '1.2.1.1.8.', 'Mesa vidrio', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.8.', 'NULL'),
(214, '1.2.1.1.9.', 'Escritorio 2 cajones', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.9.', 'NULL'),
(215, '1.2.1.1.10.', 'Archivador', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.10.', 'NULL'),
(216, '1.2.1.1.11.', 'Estante Metalico', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.11.', 'NULL'),
(217, '1.2.1.1.12.', 'Silla individual', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.12.', 'NULL'),
(218, '1.2.1.1.13.', 'Sillas de espera', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.13.', 'NULL'),
(219, '1.2.1.1.14.', 'Silla giratoria pequeÃ±a', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.14.', 'NULL'),
(220, '1.2.1.1.15.', 'Silla giratoria grande', '', '1.', '1.2.', '1.2.1.', '1.2.1.1.', '1.2.1.1.15.', 'NULL'),
(221, '1.2.1.2.1.', 'Impresora EPSON L355', '', '1.', '1.2.', '1.2.1.', '1.2.1.2.', '1.2.1.2.1.', 'NULL'),
(222, '1.2.1.2.2.', 'Computadora Portatil HP', '', '1.', '1.2.', '1.2.1.', '1.2.1.2.', '1.2.1.2.2.', 'NULL'),
(223, '1.2.1.2.3.', 'Computadora de escritorio', '', '1.', '1.2.', '1.2.1.', '1.2.1.2.', '1.2.1.2.3.', 'NULL'),
(224, '1.2.1.2.4.', 'Computadora Portatil Sonic Master', '', '1.', '1.2.', '1.2.1.', '1.2.1.2.', '1.2.1.2.4.', 'NULL'),
(225, '1.1.2.1.99.', 'Otero Cordova Carla', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.99.', 'NULL'),
(226, '2.1.1.1.7.', 'Aporte Personal', '', '2.', '2.1.', '2.1.1.', '2.1.1.1.', '2.1.1.1.7.', 'NULL'),
(227, '5.1.1.1.11.', 'Gastos x notaria', '', '5.', '5.1.', '5.1.1.', '5.1.1.1.', '5.1.1.1.11.', 'NULL'),
(228, '5.1.1.2.7.', 'Gastos x honorarios profesionales', '', '5.', '5.1.', '5.1.1.', '5.1.1.2.', '5.1.1.2.7.', 'NULL'),
(229, '1.1.2.1.100.', 'GONZALEZ PEÃ‘AFIEL CRISTIAN DAMIAN', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.100.', ''),
(230, '1.1.3.2.24.', 'SPORTAGE LX PLATEADO 2013', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.24.', ''),
(231, '1.1.2.1.101.', 'ALVAREZ SUAREZ CHRISTIAN JOFFRE', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.101.', ''),
(232, '4.1.2.', 'INTERESES GANADOS', '', NULL, '4.1.', '4.1.2.', NULL, NULL, ''),
(233, '4.1.2.1.', 'INTERESES GANADOS', '', NULL, '4.1.', '4.1.2.', '4.1.2.1.', NULL, ''),
(234, '1.1.3.2.25.', 'X-TRAIL ADVANCE CVT AC 2.5 5P 4X2 PLOMO 2015', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.25.', ''),
(235, '1.1.3.2.26.', 'GRAND VITARA SZ 2.0L 5P TM 4X2 ROJO 2009', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.26.', ''),
(236, '1.1.3.2.27.', 'RANGER XLS 2.5 CD 4X2 TM PLOMO 2012', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.27.', ''),
(237, '1.1.3.2.28.', 'SAIL AC 1.4 4P 4X2 TM PLOMO 2014', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.28.', ''),
(238, '1.1.3.2.29.', 'AVEO FAMILY AC 1.5 4P 4X2 TM BLANCO 2014', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.29.', ''),
(239, '1.1.3.2.30.', 'OPTRA 1.8L T/M LIMITED CREMA 2006', '', '1.', '1.1.', '1.1.3.', '1.1.3.2.', '1.1.3.2.30.', ''),
(240, '1.1.2.1.102.', 'SARMIENTO DAVILA OMAR RENE', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.102.', ''),
(241, '1.1.2.1.103.', 'ROMERO ARMIJOS RENE ANTONIO', '', '1.', '1.1.', '1.1.2.', '1.1.2.1.', '1.1.2.1.103.', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_subauxiliar`
--

CREATE TABLE `t_subauxiliar` (
  `nom_cuenta` char(45) DEFAULT NULL,
  `cod_subauxiliar` char(45) NOT NULL,
  `t_auxiliar_cod_cauxiliar` char(20) NOT NULL,
  `descrip` char(150) DEFAULT NULL,
  `t_subcuenta_cod_subcuenta` char(20) NOT NULL,
  `t_cuenta_cod_cuenta` char(11) NOT NULL,
  `t_grupo_cod_grupo` char(11) NOT NULL,
  `t_clase_cod_clase` char(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_subcuenta`
--

CREATE TABLE `t_subcuenta` (
  `nombre_subcuenta` char(45) NOT NULL,
  `cod_subcuenta` char(20) NOT NULL,
  `descrip_subcuenta` varchar(100) DEFAULT NULL,
  `t_cuenta_cod_cuenta` char(11) NOT NULL,
  `t_grupo_cod_grupo` char(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_subcuenta`
--

INSERT INTO `t_subcuenta` (`nombre_subcuenta`, `cod_subcuenta`, `descrip_subcuenta`, `t_cuenta_cod_cuenta`, `t_grupo_cod_grupo`) VALUES
('CAJAS', '1.1.1.1.', '', '1.1.1.', '1.1.'),
('SUELDOS Y BENEFICIOS SOCIALES X PAGAR', '2.1.1.1.', '', '2.1.1.', '2.1.'),
('PROVEEDORES', '2.1.1.2.', '', '2.1.1.', '2.1.'),
('DEUDAS FISCALES', '2.1.1.3.', '', '2.1.1.', '2.1.'),
('BANCARIOS X PAGAR A LARGO PLAZO', '2.2.1.1.', '', '2.2.1.', '2.2.'),
('CUENTAS X PAGAR LARGO PLAZO', '2.2.1.2.', '', '2.2.1.', '2.2.'),
('MUEBLES Y ENSERES', '1.2.1.1.', '', '1.2.1.', '1.2.'),
('EQUIPOS DE COMPUTACION', '1.2.1.2.', '', '1.2.1.', '1.2.'),
('(-) DEP. ACUM. MUEBLES Y ENSERES', '1.2.1.3.', '', '1.2.1.', '1.2.'),
('(-) DEP. ACUM. EQUIPOS DE COMPUTACION', '1.2.1.4.', '', '1.2.1.', '1.2.'),
('CUENTAS X COBRAR CLIENTES', '1.1.2.1.', '', '1.1.2.', '1.1.'),
('INVENTARIOS DE VEHICULOS EN CONSIGNACION', '1.1.3.1.', '', '1.1.3.', '1.1.'),
('IMPUESTOS', '1.1.5.1.', '', '1.1.5.', '1.1.'),
('BANCOS', '1.1.1.2.', '', '1.1.1.', '1.1.'),
('CAPITAL', '3.1.1.1.', '', '3.1.1.', '3.1.'),
('RESERVAS', '3.1.1.2.', '', '3.1.1.', '3.1.'),
('INGRESOS X COMISION EN VENTA DE VEHICULOS', '4.1.1.1.', '', '4.1.1.', '4.1.'),
('INGRESOS X CONSIGNACION DE VEHICULOS', '4.1.1.2.', '', '4.1.1.', '4.1.'),
('GASTOS OPERATIVOS', '5.1.1.1.', '', '5.1.1.', '5.1.'),
('GASTOS ADMINISTRATIVOS', '5.1.1.2.', '', '5.1.1.', '5.1.'),
('GASTOS DE VENTAS', '5.1.1.3.', '', '5.1.1.', '5.1.'),
('INVENTARIO DE VEHICULOS COMISION', '1.1.3.2.', '', '1.1.3.', '1.1.'),
('INTERESES GANADOS', '4.1.2.1.', '', '4.1.2.', '4.1.');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vautomayorizacionajustes`
--
CREATE TABLE `vautomayorizacionajustes` (
`fecha` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`debe` decimal(37,2)
,`haber` decimal(37,2)
,`balance` int(11)
,`grupo` char(11)
,`sld_deudor` varchar(40)
,`sld_acreedor` varchar(40)
,`year` char(45)
,`mes` char(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vissumasclasesygrupos`
--
CREATE TABLE `vissumasclasesygrupos` (
`cod` char(11)
,`cuenta` char(45)
,`year` char(45)
,`balance` int(11)
,`sb` double
,`sh` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistaautomayorizacion`
--
CREATE TABLE `vistaautomayorizacion` (
`fecha` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`debe` decimal(37,2)
,`haber` decimal(37,2)
,`t_bl_inicial_idt_bl_inicial` int(11)
,`tipo` char(45)
,`sld_deudor` varchar(40)
,`sld_acreedor` varchar(40)
,`year` char(45)
,`mes` char(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistabalanceresultadosajustados`
--
CREATE TABLE `vistabalanceresultadosajustados` (
`fecha_aj` char(45)
,`cod_cuenta_aj` char(45)
,`cuenta_aj` char(45)
,`debe_aj` decimal(37,2)
,`haber_aj` decimal(37,2)
,`slddeudor_aj` varchar(40)
,`sldacreedor_aj` varchar(40)
,`grupo_aj` char(11)
,`year_aj` char(45)
,`mes_aj` char(45)
,`balance_aj` int(11)
,`fecha` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`debe` decimal(37,2)
,`haber` decimal(37,2)
,`t_bl_inicial_idt_bl_inicial` int(11)
,`tipo` char(45)
,`sld_deudor` varchar(40)
,`sld_acreedor` varchar(40)
,`year` char(45)
,`mes` char(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vmayorizacionajustes`
--
CREATE TABLE `vmayorizacionajustes` (
`fecha` char(45)
,`ejercicio` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`debe` decimal(15,2)
,`haber` decimal(15,2)
,`grupo` char(11)
,`balance` int(11)
,`logeo` int(11)
,`mes` char(45)
,`year` char(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_mayorizacionaux`
--
CREATE TABLE `v_mayorizacionaux` (
`fecha` char(45)
,`ejercicio` char(45)
,`cod_cuenta` char(45)
,`cuenta` char(45)
,`valor` decimal(15,2)
,`valorp` decimal(15,2)
,`tipo` char(45)
,`t_bl_inicial_idt_bl_inicial` int(11)
,`mes` char(45)
,`year` char(45)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `balance`
--
DROP TABLE IF EXISTS `balance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `balance`  AS  select `j`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`j`.`ejercicio` AS `ejercicio`,`b`.`fecha_balance` AS `fecha_balance`,`j`.`cod_cuenta` AS `cod_cuenta`,`j`.`cuenta` AS `cuenta`,`j`.`valor` AS `valor`,`j`.`valorp` AS `valorp`,`j`.`mes` AS `mes`,`j`.`year` AS `year` from (`t_ejercicio` `j` join `t_bl_inicial` `b`) where (`j`.`t_bl_inicial_idt_bl_inicial` = `b`.`idt_bl_inicial`) union select `j`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`j`.`ejercicio` AS `ejercicio`,`b`.`fecha_balance` AS `fecha_balance`,`j`.`cod_cuenta` AS `cod_cuenta`,`j`.`cuenta` AS `cuenta`,`j`.`valor` AS `valor`,`j`.`valorp` AS `valorp`,`j`.`mes` AS `mes`,`j`.`year` AS `year` from (`t_ejercicio` `j` join `t_bl_inicial` `b`) where (`j`.`t_bl_inicial_idt_bl_inicial` = `b`.`idt_bl_inicial`) group by `j`.`tipo` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `hoja_de_trabajo`
--
DROP TABLE IF EXISTS `hoja_de_trabajo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `hoja_de_trabajo`  AS  select `vistabalanceresultadosajustados`.`fecha_aj` AS `fecha_aj`,`vistabalanceresultadosajustados`.`cod_cuenta_aj` AS `cod_cuenta_aj`,`vistabalanceresultadosajustados`.`cuenta_aj` AS `cuenta_aj`,`vistabalanceresultadosajustados`.`debe_aj` AS `debe_aj`,`vistabalanceresultadosajustados`.`haber_aj` AS `haber_aj`,`vistabalanceresultadosajustados`.`slddeudor_aj` AS `slddeudor_aj`,`vistabalanceresultadosajustados`.`sldacreedor_aj` AS `sldacreedor_aj`,`vistabalanceresultadosajustados`.`grupo_aj` AS `grupo_aj`,`vistabalanceresultadosajustados`.`year_aj` AS `year_aj`,`vistabalanceresultadosajustados`.`mes_aj` AS `mes_aj`,`vistabalanceresultadosajustados`.`balance_aj` AS `balance_aj`,`vistabalanceresultadosajustados`.`fecha` AS `fecha`,`vistabalanceresultadosajustados`.`cod_cuenta` AS `cod_cuenta`,`vistabalanceresultadosajustados`.`cuenta` AS `cuenta`,`vistabalanceresultadosajustados`.`debe` AS `debe`,`vistabalanceresultadosajustados`.`haber` AS `haber`,`vistabalanceresultadosajustados`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`vistabalanceresultadosajustados`.`tipo` AS `tipo`,`vistabalanceresultadosajustados`.`sld_deudor` AS `sld_deudor`,`vistabalanceresultadosajustados`.`sld_acreedor` AS `sld_acreedor`,`vistabalanceresultadosajustados`.`year` AS `year`,`vistabalanceresultadosajustados`.`mes` AS `mes`,(coalesce(`vistabalanceresultadosajustados`.`slddeudor_aj`,0) + coalesce(`vistabalanceresultadosajustados`.`sld_deudor`,0)) AS `sum_deudor`,(coalesce(`vistabalanceresultadosajustados`.`sldacreedor_aj`,0) + coalesce(`vistabalanceresultadosajustados`.`sld_acreedor`,0)) AS `sum_acreedor` from `vistabalanceresultadosajustados` group by `vistabalanceresultadosajustados`.`cod_cuenta` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `sumadecuentasconajustes`
--
DROP TABLE IF EXISTS `sumadecuentasconajustes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sumadecuentasconajustes`  AS  select `v`.`year_aj` AS `year_aj`,`v`.`year` AS `year`,`v`.`balance_aj` AS `b_aj`,`v`.`t_bl_inicial_idt_bl_inicial` AS `bl`,`v`.`grupo_aj` AS `g_aj`,`v`.`tipo` AS `g`,`v`.`cod_cuenta_aj` AS `cod_cuenta_aj`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,`v`.`sld_deudor` AS `sld_deudor`,`v`.`sld_acreedor` AS `sld_acreedor`,`v`.`slddeudor_aj` AS `slddeudor_aj`,`v`.`sldacreedor_aj` AS `sldacreedor_aj`,(sum(coalesce(`v`.`sld_deudor`,0)) + sum(coalesce(`v`.`slddeudor_aj`,0))) AS `sumas_d`,(sum(coalesce(`v`.`sld_acreedor`,0)) + sum(coalesce(`v`.`sldacreedor_aj`,0))) AS `suma_h` from ((`vistabalanceresultadosajustados` `v` join `t_grupo` `g`) join `t_bl_inicial` `b`) where ((convert(`v`.`tipo` using utf8) = `g`.`cod_grupo`) and (convert(`v`.`year` using utf8) = `b`.`year`) and (`v`.`t_bl_inicial_idt_bl_inicial` = `b`.`idt_bl_inicial`)) group by `v`.`cod_cuenta`,`v`.`cod_cuenta_aj` order by `v`.`tipo` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `sumasparaestadoderesultados`
--
DROP TABLE IF EXISTS `sumasparaestadoderesultados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sumasparaestadoderesultados`  AS  select `c`.`cod_clase` AS `clase`,`c`.`nombre_clase` AS `nom`,`g`.`cod_grupo` AS `grupo`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,`v`.`year` AS `year`,`v`.`t_bl_inicial_idt_bl_inicial` AS `balance`,sum((`v`.`sum_deudor` + `v`.`sum_acreedor`)) AS `total` from ((`hoja_de_trabajo` `v` join `t_grupo` `g`) join `t_clase` `c`) where ((convert(`v`.`tipo` using utf8) = `g`.`cod_grupo`) and (`c`.`cod_clase` = `g`.`t_clase_cod_clase`)) group by `v`.`cuenta` having (sum(`v`.`sum_deudor`) > sum(`v`.`sum_acreedor`)) union select `c`.`cod_clase` AS `clase`,`c`.`nombre_clase` AS `nom`,`g`.`cod_grupo` AS `grupo`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,`v`.`year` AS `year`,`v`.`t_bl_inicial_idt_bl_inicial` AS `balance`,sum((`v`.`sum_acreedor` + `v`.`sum_deudor`)) AS `total` from ((`hoja_de_trabajo` `v` join `t_grupo` `g`) join `t_clase` `c`) where ((convert(`v`.`tipo` using utf8) = `g`.`cod_grupo`) and (`c`.`cod_clase` = `g`.`t_clase_cod_clase`)) group by `v`.`cuenta` having (sum(`v`.`sum_deudor`) < sum(`v`.`sum_acreedor`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `totasientos`
--
DROP TABLE IF EXISTS `totasientos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `totasientos`  AS  select `t_ejercicio`.`ejercicio` AS `asiento`,`t_ejercicio`.`cod_cuenta` AS `cod_cuenta`,`t_ejercicio`.`cuenta` AS `cuenta`,`t_ejercicio`.`fecha` AS `fecha`,`t_ejercicio`.`valor` AS `debe`,`t_ejercicio`.`valorp` AS `haber`,`t_ejercicio`.`t_bl_inicial_idt_bl_inicial` AS `balance`,`t_ejercicio`.`tipo` AS `grupo`,`t_ejercicio`.`logeo_idlogeo` AS `logeo`,`t_ejercicio`.`mes` AS `mes`,`t_ejercicio`.`year` AS `year` from `t_ejercicio` union select `libro`.`asiento` AS `asiento`,`libro`.`ref` AS `cod_cuenta`,`libro`.`cuenta` AS `cuenta`,`libro`.`fecha` AS `fecha`,`libro`.`debe` AS `debe`,`libro`.`haber` AS `haber`,`libro`.`t_bl_inicial_idt_bl_inicial` AS `balance`,`libro`.`grupo` AS `grupo`,`libro`.`logeo_idlogeo` AS `logeo`,`libro`.`mes` AS `mes`,`libro`.`year` AS `year` from `libro` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vautomayorizacionajustes`
--
DROP TABLE IF EXISTS `vautomayorizacionajustes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vautomayorizacionajustes`  AS  select `v`.`fecha` AS `fecha`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,sum(`v`.`debe`) AS `debe`,sum(`v`.`haber`) AS `haber`,`v`.`balance` AS `balance`,`v`.`grupo` AS `grupo`,(sum(`v`.`debe`) - sum(`v`.`haber`)) AS `sld_deudor`,concat(_utf8'0.00') AS `sld_acreedor`,`v`.`year` AS `year`,`v`.`mes` AS `mes` from (`vmayorizacionajustes` `v` join `t_bl_inicial` `n`) where ((`v`.`balance` = `n`.`idt_bl_inicial`) and (`n`.`year` = convert(`v`.`year` using utf8))) group by `v`.`cod_cuenta` having (sum(`v`.`debe`) > sum(`v`.`haber`)) union select `v`.`fecha` AS `fecha`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,sum(`v`.`debe`) AS `debe`,sum(`v`.`haber`) AS `haber`,`v`.`balance` AS `balance`,`v`.`grupo` AS `grupo`,concat(_utf8'0.00') AS `sld_deudor`,(sum(`v`.`haber`) - sum(`v`.`debe`)) AS `sld_acreedor`,`v`.`year` AS `year`,`v`.`mes` AS `mes` from (`vmayorizacionajustes` `v` join `t_bl_inicial` `n`) where ((`v`.`balance` = `n`.`idt_bl_inicial`) and (`n`.`year` = convert(`v`.`year` using utf8))) group by `v`.`cod_cuenta` having (sum(`v`.`debe`) < sum(`v`.`haber`)) union select `v`.`fecha` AS `fecha`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,sum(`v`.`debe`) AS `debe`,sum(`v`.`haber`) AS `haber`,`v`.`balance` AS `balance`,`v`.`grupo` AS `grupo`,concat(_utf8'0.00') AS `sld_deudor`,concat(_utf8'0.00') AS `sld_acreedor`,`v`.`year` AS `year`,`v`.`mes` AS `mes` from (`vmayorizacionajustes` `v` join `t_bl_inicial` `n`) where ((`v`.`balance` = `n`.`idt_bl_inicial`) and (`n`.`year` = convert(`v`.`year` using utf8))) group by `v`.`cod_cuenta` having (sum(`v`.`debe`) = sum(`v`.`haber`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vissumasclasesygrupos`
--
DROP TABLE IF EXISTS `vissumasclasesygrupos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vissumasclasesygrupos`  AS  select `g`.`t_clase_cod_clase` AS `cod`,`c`.`nombre_clase` AS `cuenta`,`v`.`year` AS `year`,`v`.`t_bl_inicial_idt_bl_inicial` AS `balance`,sum(`v`.`sum_deudor`) AS `sb`,sum(`v`.`sum_acreedor`) AS `sh` from ((`hoja_de_trabajo` `v` join `t_grupo` `g`) join `t_clase` `c`) where ((convert(`v`.`tipo` using utf8) = `g`.`cod_grupo`) and (`g`.`t_clase_cod_clase` = `c`.`cod_clase`)) group by `c`.`nombre_clase` union select `g`.`cod_grupo` AS `cod`,`g`.`nombre_grupo` AS `cuenta`,`v`.`year` AS `year`,`v`.`t_bl_inicial_idt_bl_inicial` AS `balance`,sum(`v`.`sum_deudor`) AS `sb`,sum(`v`.`sum_acreedor`) AS `sh` from ((`hoja_de_trabajo` `v` join `t_grupo` `g`) join `t_clase` `c`) where ((convert(`v`.`tipo` using utf8) = `g`.`cod_grupo`) and (`g`.`t_clase_cod_clase` = `c`.`cod_clase`)) group by `g`.`nombre_grupo` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistaautomayorizacion`
--
DROP TABLE IF EXISTS `vistaautomayorizacion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistaautomayorizacion`  AS  select `v`.`fecha` AS `fecha`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,sum(`v`.`valor`) AS `debe`,sum(`v`.`valorp`) AS `haber`,`v`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`v`.`tipo` AS `tipo`,(sum(`v`.`valor`) - sum(`v`.`valorp`)) AS `sld_deudor`,concat(_utf8'0.00') AS `sld_acreedor`,`v`.`year` AS `year`,`v`.`mes` AS `mes` from (`v_mayorizacionaux` `v` join `t_bl_inicial` `n`) where ((`v`.`t_bl_inicial_idt_bl_inicial` = `n`.`idt_bl_inicial`) and (`n`.`year` = convert(`v`.`year` using utf8))) group by `v`.`cod_cuenta`,`v`.`year` having (sum(`v`.`valor`) > sum(`v`.`valorp`)) union select `v`.`fecha` AS `fecha`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,sum(`v`.`valor`) AS `debe`,sum(`v`.`valorp`) AS `haber`,`v`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`v`.`tipo` AS `tipo`,concat(_utf8'0.00') AS `sld_deudor`,(sum(`v`.`valorp`) - sum(`v`.`valor`)) AS `sld_acreedor`,`v`.`year` AS `year`,`v`.`mes` AS `mes` from (`v_mayorizacionaux` `v` join `t_bl_inicial` `n`) where ((`v`.`t_bl_inicial_idt_bl_inicial` = `n`.`idt_bl_inicial`) and (`n`.`year` = convert(`v`.`year` using utf8))) group by `v`.`cod_cuenta`,`v`.`year` having (sum(`v`.`valor`) < sum(`v`.`valorp`)) union select `v`.`fecha` AS `fecha`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,sum(`v`.`valor`) AS `debe`,sum(`v`.`valorp`) AS `haber`,`v`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`v`.`tipo` AS `tipo`,concat(_utf8'0.00') AS `sld_deudor`,concat(_utf8'0.00') AS `sld_acreedor`,`v`.`year` AS `year`,`v`.`mes` AS `mes` from (`v_mayorizacionaux` `v` join `t_bl_inicial` `n`) where ((`v`.`t_bl_inicial_idt_bl_inicial` = `n`.`idt_bl_inicial`) and (`n`.`year` = convert(`v`.`year` using utf8))) group by `v`.`cod_cuenta`,`v`.`year` having (sum(`v`.`valor`) = sum(`v`.`valorp`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistabalanceresultadosajustados`
--
DROP TABLE IF EXISTS `vistabalanceresultadosajustados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistabalanceresultadosajustados`  AS  select `v`.`fecha` AS `fecha_aj`,`v`.`cod_cuenta` AS `cod_cuenta_aj`,`v`.`cuenta` AS `cuenta_aj`,`v`.`debe` AS `debe_aj`,`v`.`haber` AS `haber_aj`,`v`.`sld_deudor` AS `slddeudor_aj`,`v`.`sld_acreedor` AS `sldacreedor_aj`,`v`.`grupo` AS `grupo_aj`,`v`.`year` AS `year_aj`,`v`.`mes` AS `mes_aj`,`v`.`balance` AS `balance_aj`,`va`.`fecha` AS `fecha`,`va`.`cod_cuenta` AS `cod_cuenta`,`va`.`cuenta` AS `cuenta`,`va`.`debe` AS `debe`,`va`.`haber` AS `haber`,`va`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`va`.`tipo` AS `tipo`,`va`.`sld_deudor` AS `sld_deudor`,`va`.`sld_acreedor` AS `sld_acreedor`,`va`.`year` AS `year`,`va`.`mes` AS `mes` from (`vistaautomayorizacion` `va` left join `vautomayorizacionajustes` `v` on(((`v`.`balance` = `va`.`t_bl_inicial_idt_bl_inicial`) and (convert(`va`.`tipo` using utf8) = convert(`v`.`grupo` using utf8)) and (`v`.`balance` = `va`.`t_bl_inicial_idt_bl_inicial`) and (convert(`v`.`cod_cuenta` using utf8) = convert(`va`.`cod_cuenta` using utf8))))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vmayorizacionajustes`
--
DROP TABLE IF EXISTS `vmayorizacionajustes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vmayorizacionajustes`  AS  select `e`.`fecha` AS `fecha`,`e`.`ejercicio` AS `ejercicio`,`e`.`cod_cuenta` AS `cod_cuenta`,`e`.`cuenta` AS `cuenta`,`e`.`valor` AS `debe`,`e`.`valorp` AS `haber`,`e`.`tipo` AS `grupo`,`e`.`t_bl_inicial_idt_bl_inicial` AS `balance`,`e`.`logeo_idlogeo` AS `logeo`,`e`.`mes` AS `mes`,`e`.`year` AS `year` from `ajustesejercicio` `e` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_mayorizacionaux`
--
DROP TABLE IF EXISTS `v_mayorizacionaux`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_mayorizacionaux`  AS  select `e`.`fecha` AS `fecha`,`e`.`ejercicio` AS `ejercicio`,`e`.`cod_cuenta` AS `cod_cuenta`,`e`.`cuenta` AS `cuenta`,`e`.`valor` AS `valor`,`e`.`valorp` AS `valorp`,`e`.`tipo` AS `tipo`,`e`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`e`.`mes` AS `mes`,`e`.`year` AS `year` from `t_ejercicio` `e` union select `l`.`fecha` AS `fecha`,`l`.`asiento` AS `asiento`,`l`.`ref` AS `ref`,`l`.`cuenta` AS `cuenta`,`l`.`debe` AS `debe`,`l`.`haber` AS `haber`,`l`.`grupo` AS `grupo`,`l`.`t_bl_inicial_idt_bl_inicial` AS `t_bl_inicial_idt_bl_inicial`,`l`.`mes` AS `mes`,`l`.`year` AS `year` from `libro` `l` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ajustesejercicio`
--
ALTER TABLE `ajustesejercicio`
  ADD PRIMARY KEY (`idajustesejercicio`),
  ADD KEY `fk_t_corrientes_t_bl_inicial10` (`t_bl_inicial_idt_bl_inicial`),
  ADD KEY `fk_t_corrientes_tip_cuenta10` (`tipo`),
  ADD KEY `fk_t_ejercicio_logeo10` (`logeo_idlogeo`),
  ADD KEY `fk_ajustesejercicio_num_asientos_ajustes1` (`num_asientos_ajustes_idnum_asientos_ajustes`),
  ADD KEY `fk_ajustesejercicio_t_ejercicio1` (`t_ejercicio_idt_corrientes`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`idlibro`),
  ADD KEY `fk_libro_t_bl_inicial1` (`t_bl_inicial_idt_bl_inicial`),
  ADD KEY `fk_libro_t_cuenta1` (`t_cuenta_idt_cuenta`),
  ADD KEY `fk_libro_logeo1` (`logeo_idlogeo`);

--
-- Indices de la tabla `num_asientos_ajustes`
--
ALTER TABLE `num_asientos_ajustes`
  ADD PRIMARY KEY (`idnum_asientos_ajustes`),
  ADD KEY `fk_num_asientos_t_ejercicio10` (`t_ejercicio_idt_corrientes`),
  ADD KEY `fk_num_asientos_t_bl_inicial10` (`t_bl_inicial_idt_bl_inicial`),
  ADD KEY `fk_num_asientos_ajustes_num_asientos1` (`num_asientos_idnum_asientos`);

--
-- Indices de la tabla `saldosajustados`
--
ALTER TABLE `saldosajustados`
  ADD PRIMARY KEY (`idsaldosajustados`),
  ADD KEY `fk_saldosajustados_num_asientos1` (`num_asientos_idnum_asientos`);

--
-- Indices de la tabla `tip_cuenta`
--
ALTER TABLE `tip_cuenta`
  ADD PRIMARY KEY (`idtip_cuenta`);

--
-- Indices de la tabla `t_auxiliar`
--
ALTER TABLE `t_auxiliar`
  ADD PRIMARY KEY (`cod_cauxiliar`),
  ADD KEY `fk_t_auxiliar_t_subcuenta1` (`t_subcuenta_cod_subcuenta`),
  ADD KEY `fk_t_auxiliar_t_cuenta1` (`t_cuenta_cod_cuenta`),
  ADD KEY `fk_t_auxiliar_t_grupo1` (`t_grupo_cod_grupo`),
  ADD KEY `fk_t_auxiliar_t_clase1` (`t_clase_cod_clase`);

--
-- Indices de la tabla `t_bl_inicial`
--
ALTER TABLE `t_bl_inicial`
  ADD PRIMARY KEY (`idt_bl_inicial`),
  ADD KEY `fk_t_bl_inicial_logeo1_idx` (`logeo_idlogeo`);

--
-- Indices de la tabla `t_clase`
--
ALTER TABLE `t_clase`
  ADD PRIMARY KEY (`cod_clase`),
  ADD UNIQUE KEY `cod_clase_UNIQUE` (`cod_clase`);

--
-- Indices de la tabla `t_cuenta`
--
ALTER TABLE `t_cuenta`
  ADD PRIMARY KEY (`cod_cuenta`),
  ADD UNIQUE KEY `cod_cuenta_UNIQUE` (`cod_cuenta`),
  ADD KEY `fk_t_cuenta_t_grupo1_idx` (`t_grupo_cod_grupo`);

--
-- Indices de la tabla `t_ejercicio`
--
ALTER TABLE `t_ejercicio`
  ADD PRIMARY KEY (`idt_corrientes`),
  ADD KEY `fk_t_corrientes_t_bl_inicial1_idx` (`t_bl_inicial_idt_bl_inicial`),
  ADD KEY `fk_t_corrientes_tip_cuenta1_idx` (`tipo`),
  ADD KEY `fk_t_ejercicio_logeo1_idx` (`logeo_idlogeo`);

--
-- Indices de la tabla `t_grupo`
--
ALTER TABLE `t_grupo`
  ADD PRIMARY KEY (`cod_grupo`),
  ADD UNIQUE KEY `cod_grupo_UNIQUE` (`cod_grupo`),
  ADD KEY `fk_t_grupo_t_clase_idx` (`t_clase_cod_clase`);

--
-- Indices de la tabla `t_plan_de_cuentas`
--
ALTER TABLE `t_plan_de_cuentas`
  ADD PRIMARY KEY (`idt_plan_de_cuentas`),
  ADD KEY `fk_t_plan_de_cuentas_t_clase1` (`t_clase_cod_clase`),
  ADD KEY `fk_t_plan_de_cuentas_t_grupo1` (`t_grupo_cod_grupo`),
  ADD KEY `fk_t_plan_de_cuentas_t_cuenta1` (`t_cuenta_cod_cuenta`),
  ADD KEY `fk_t_plan_de_cuentas_t_subcuenta1` (`t_subcuenta_cod_subcuenta`),
  ADD KEY `fk_t_plan_de_cuentas_t_auxiliar1` (`t_auxiliar_cod_cauxiliar`),
  ADD KEY `fk_t_plan_de_cuentas_t_subauxiliar1` (`t_subauxiliar_cod_subauxiliar`);

--
-- Indices de la tabla `t_subauxiliar`
--
ALTER TABLE `t_subauxiliar`
  ADD PRIMARY KEY (`cod_subauxiliar`),
  ADD KEY `fk_t_subauxiliar_t_auxiliar1` (`t_auxiliar_cod_cauxiliar`),
  ADD KEY `fk_t_subauxiliar_t_subcuenta1` (`t_subcuenta_cod_subcuenta`),
  ADD KEY `fk_t_subauxiliar_t_cuenta1` (`t_cuenta_cod_cuenta`),
  ADD KEY `fk_t_subauxiliar_t_grupo1` (`t_grupo_cod_grupo`),
  ADD KEY `fk_t_subauxiliar_t_clase1` (`t_clase_cod_clase`);

--
-- Indices de la tabla `t_subcuenta`
--
ALTER TABLE `t_subcuenta`
  ADD PRIMARY KEY (`cod_subcuenta`),
  ADD UNIQUE KEY `cod_subcuenta_UNIQUE` (`cod_subcuenta`),
  ADD KEY `fk_t_subcuenta_t_cuenta1_idx` (`t_cuenta_cod_cuenta`),
  ADD KEY `fk_t_subcuenta_t_grupo1_idx` (`t_grupo_cod_grupo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ajustesejercicio`
--
ALTER TABLE `ajustesejercicio`
  MODIFY `idajustesejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `idlibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT de la tabla `num_asientos_ajustes`
--
ALTER TABLE `num_asientos_ajustes`
  MODIFY `idnum_asientos_ajustes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `saldosajustados`
--
ALTER TABLE `saldosajustados`
  MODIFY `idsaldosajustados` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tip_cuenta`
--
ALTER TABLE `tip_cuenta`
  MODIFY `idtip_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `t_ejercicio`
--
ALTER TABLE `t_ejercicio`
  MODIFY `idt_corrientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=577;
--
-- AUTO_INCREMENT de la tabla `t_plan_de_cuentas`
--
ALTER TABLE `t_plan_de_cuentas`
  MODIFY `idt_plan_de_cuentas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
