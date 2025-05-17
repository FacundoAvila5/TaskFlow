-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2025 a las 03:03:55
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
-- Base de datos: `taskflow`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subtareas`
--

CREATE TABLE `subtareas` (
  `id` bigint(20) NOT NULL,
  `tareaId` bigint(20) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estatus` int(11) NOT NULL,
  `prioridad` int(11) NOT NULL,
  `fechaVencimiento` date NOT NULL,
  `fechaRecordatorio` date NOT NULL,
  `responsableId` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subtareas`
--

INSERT INTO `subtareas` (`id`, `tareaId`, `asunto`, `descripcion`, `estatus`, `prioridad`, `fechaVencimiento`, `fechaRecordatorio`, `responsableId`) VALUES
(6, 20, 'Facundo test', 'facundo', 2, 1, '2025-05-14', '2025-05-14', 7),
(7, 21, 'testsubtarea', 'testsubtarea', 1, 1, '2025-05-16', '2025-05-16', 8),
(8, 31, 'Crear front de calculadora', 'Crear index', 1, 1, '2025-05-23', '2025-05-23', 7),
(9, 31, 'Crear backend', 'Realizar api para consultar datos', 1, 1, '2025-05-24', '2025-05-24', 7),
(10, 33, 'Desarrollar frontend', 'Realizar index', 1, 1, '2025-05-22', '2025-05-22', 9),
(12, 34, 'subtarea1', 'subtarea1', 2, 1, '2025-05-16', '2025-05-16', 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `subtareas`
--
ALTER TABLE `subtareas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `subtareas`
--
ALTER TABLE `subtareas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
