-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-03-2024 a las 23:37:10
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `seguimiento_moviles`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_guias`
--

CREATE TABLE `registros_guias` (
  `id` int(11) NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `imei` varchar(50) DEFAULT NULL,
  `sim` varchar(50) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `guia` varchar(50) DEFAULT NULL,
  `devuser` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registros_guias`
--

INSERT INTO `registros_guias` (`id`, `tag`, `imei`, `sim`, `fecha`, `guia`, `devuser`) VALUES
(24, 'CELTJZ009', '356552499036929', '3318947336', '2024-03-04 07:00:00', '3-685435', 'Pablo Fernando Rodrí');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `registros_guias`
--
ALTER TABLE `registros_guias`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `registros_guias`
--
ALTER TABLE `registros_guias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
