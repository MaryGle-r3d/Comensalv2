-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-05-2025 a las 06:57:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comensal`
--

CREATE TABLE `comensal` (
  `cedula` varchar(15) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `tipo` enum('Estudiante','Docente','Administrativo','Obrero') NOT NULL,
  `departamento` varchar(20) NOT NULL,
  `direccion` varchar(111) NOT NULL,
  `telefono` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comensal`
--

INSERT INTO `comensal` (`cedula`, `nombre`, `apellido`, `tipo`, `departamento`, `direccion`, `telefono`) VALUES
('12312412', 'carl', 'asdasdasd', 'Estudiante', 'calle 13 con 19', 'sadasd', 212331241),
('123342312312', 'red', 'asdd', 'Obrero', '12312312', 'sdasd', 2147483647),
('142223232', 'samuel', 'chat', 'Administrativo', 'farmatodo', 'san juan', 2147483647),
('27994993', 'martin', 'carlos', 'Docente', 'mandalandia', 'martin', 2147483647);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `cantidad`, `unidad`, `estado`, `fecha_ingreso`, `fecha_vencimiento`) VALUES
(1, 'red', 123, '23', 'Inactivo', '4444-03-12', '4445-04-12'),
(2, 'aduanaria', 23, '33', 'Activo', '4444-03-01', '5555-04-04'),
(3, 'nate', 123, '1', 'Activo', '4445-03-12', '6666-12-04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comensal`
--
ALTER TABLE `comensal`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
