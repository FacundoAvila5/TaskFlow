-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2025 a las 22:10:23
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
-- Estructura de tabla para la tabla `colaboraciones`
--

CREATE TABLE `colaboraciones` (
  `id` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `tareaId` bigint(20) NOT NULL,
  `invitacionAceptada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colaboraciones`
--

INSERT INTO `colaboraciones` (`id`, `userId`, `tareaId`, `invitacionAceptada`) VALUES
(22, 8, 21, 1),
(23, 7, 33, 1),
(24, 7, 34, 1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `prioridad` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `fechaVencimiento` date NOT NULL,
  `fechaRecordatorio` date DEFAULT NULL,
  `color` varchar(255) NOT NULL,
  `archivada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `userId`, `asunto`, `descripcion`, `prioridad`, `estatus`, `fechaVencimiento`, `fechaRecordatorio`, `color`, `archivada`) VALUES
(21, 7, 'test', 'test', 2, 1, '2025-05-23', '2025-05-17', '#ffc107', 1),
(26, 7, 'Resolve bug', 'bug en backend', 0, 0, '2025-05-20', NULL, '#6f42c1', 0),
(31, 7, 'Proyecto android', 'Aplicacion de calculadora', 1, 1, '2025-05-25', NULL, '#28a745', 1),
(33, 9, 'Proyecto veterinaria', 'Realizar un poyecto de gestion de una veterinaria', 1, 1, '2025-05-23', NULL, '#6f42c1', 0),
(34, 9, 'Proyecto', 'Realizar repo', 1, 0, '2025-05-17', NULL, '#28a745', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) NOT NULL,
  `nombreUsuario` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tiempoDeCreacion` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombreUsuario`, `email`, `password`, `tiempoDeCreacion`) VALUES
(7, 'Facundo', 'facuaviila5@outlook.com', '$2y$10$2UE6xRKQwNKj8rBFs9HhK.hl7eDMvXGbQf3FN3URpVSqdZeG75qQG', '2025-05-05'),
(9, 'Milagros', 'milagros@gmail.com', '$2y$10$c6OJ66sCR.J4danNM/INcuxi8QG7pLtqXmDhGohMM8QwtNyPuqT9q', '2025-05-16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colaboraciones`
--
ALTER TABLE `colaboraciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subtareas`
--
ALTER TABLE `subtareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `colaboraciones`
--
ALTER TABLE `colaboraciones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `subtareas`
--
ALTER TABLE `subtareas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
