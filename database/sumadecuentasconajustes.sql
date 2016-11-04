-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2016 a las 18:26:03
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
-- Estructura para la vista `sumadecuentasconajustes`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sumadecuentasconajustes`  AS  select `v`.`year_aj` AS `year_aj`,`v`.`year` AS `year`,`v`.`balance_aj` AS `b_aj`,`v`.`t_bl_inicial_idt_bl_inicial` AS `bl`,`v`.`grupo_aj` AS `g_aj`,`v`.`tipo` AS `g`,`v`.`cod_cuenta_aj` AS `cod_cuenta_aj`,`v`.`cod_cuenta` AS `cod_cuenta`,`v`.`cuenta` AS `cuenta`,`v`.`sld_deudor` AS `sld_deudor`,`v`.`sld_acreedor` AS `sld_acreedor`,`v`.`slddeudor_aj` AS `slddeudor_aj`,`v`.`sldacreedor_aj` AS `sldacreedor_aj`,(sum(coalesce(`v`.`sld_deudor`,0)) + sum(coalesce(`v`.`slddeudor_aj`,0))) AS `sumas_d`,(sum(coalesce(`v`.`sld_acreedor`,0)) + sum(coalesce(`v`.`sldacreedor_aj`,0))) AS `suma_h` from ((`vistabalanceresultadosajustados` `v` join `t_grupo` `g`) join `t_bl_inicial` `b`) where ((convert(`v`.`tipo` using utf8) = `g`.`cod_grupo`) and (convert(`v`.`year` using utf8) = `b`.`year`) and (`v`.`t_bl_inicial_idt_bl_inicial` = `b`.`idt_bl_inicial`)) group by `v`.`cod_cuenta`,`v`.`cod_cuenta_aj` order by `v`.`tipo` ;

--
-- VIEW  `sumadecuentasconajustes`
-- Datos: Ninguna
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
