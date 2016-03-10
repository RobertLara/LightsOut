-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2016 a las 21:05:19
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lightsout`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `id_level` int(11) NOT NULL,
  `level` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `levels`
--

INSERT INTO `levels` (`id_level`, `level`) VALUES
(1, '0000100011000010000000000'),
(2, '0000000000000001000111011'),
(3, '1100010000001000000000001'),
(4, '0000000000000000000000111'),
(5, '1000101010001000101010001'),
(6, '1010101110111110111010101'),
(7, '0010001010100010101000100'),
(8, '1010101010101010101010101'),
(9, '1001001001001001001001001'),
(10, '1000101110010100111010001'),
(11, '0010001010101010101000100'),
(12, '1010100000101010000010101'),
(13, '0000000000001000000000000'),
(14, '1000001000001000001000001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ranking`
--

CREATE TABLE IF NOT EXISTS `ranking` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_level` int(11) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `clicks` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ranking`
--

INSERT INTO `ranking` (`id`, `id_user`, `id_level`, `time`, `clicks`) VALUES
(2, 2, 2, '00:00:03', 5),
(5, 2, 1, '00:00:00', 1),
(9, 2, 14, '00:00:02', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_level`
--

CREATE TABLE IF NOT EXISTS `tmp_level` (
  `id_level` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` varchar(25) NOT NULL,
  `time` time NOT NULL,
  `clicks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tmp_level`
--

INSERT INTO `tmp_level` (`id_level`, `id_user`, `status`, `time`, `clicks`) VALUES
(3, 2, '0000100000000100100001000', '00:01:21', 78),
(7, 2, '0000000000100010000000000', '00:02:00', 111),
(14, 2, '1000001000001000001000001', '00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 1),
(2, 'player', '0192023a7bbd73250516f069df18b500', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id_level`);

--
-- Indices de la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_level`
--
ALTER TABLE `tmp_level`
  ADD PRIMARY KEY (`id_level`,`id_user`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `levels`
--
ALTER TABLE `levels`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `ranking`
--
ALTER TABLE `ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
