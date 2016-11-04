-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2016 a las 18:36:13
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
-- Estructura para la vista `vmayorizacionajustes`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vmayorizacionajustes`  AS  select `e`.`fecha` AS `fecha`,`e`.`ejercicio` AS `ejercicio`,`e`.`cod_cuenta` AS `cod_cuenta`,`e`.`cuenta` AS `cuenta`,`e`.`valor` AS `debe`,`e`.`valorp` AS `haber`,`e`.`tipo` AS `grupo`,`e`.`t_bl_inicial_idt_bl_inicial` AS `balance`,`e`.`logeo_idlogeo` AS `logeo`,`e`.`mes` AS `mes`,`e`.`year` AS `year` from `ajustesejercicio` `e` ;

--
-- VIEW  `vmayorizacionajustes`
-- Datos: Ninguna
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
