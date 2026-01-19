-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2026 a las 17:40:19
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
-- Base de datos: `romerojavier`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personajes`
--

CREATE TABLE `personajes` (
  `codigo` varchar(250) NOT NULL,
  `nombre_personaje` varchar(250) NOT NULL,
  `clase` varchar(250) DEFAULT NULL,
  `fuerza` int(10) UNSIGNED DEFAULT NULL,
  `destreza` int(10) UNSIGNED DEFAULT NULL,
  `constitucion` int(10) UNSIGNED DEFAULT NULL,
  `inteligencia` int(10) UNSIGNED DEFAULT NULL,
  `sabiduria` int(10) UNSIGNED DEFAULT NULL,
  `carisma` int(10) UNSIGNED DEFAULT NULL,
  `imagen` varchar(250) DEFAULT NULL,
  `creador` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personajes`
--

INSERT INTO `personajes` (`codigo`, `nombre_personaje`, `clase`, `fuerza`, `destreza`, `constitucion`, `inteligencia`, `sabiduria`, `carisma`, `imagen`, `creador`) VALUES
('asdasd', 'hola', 'guerrero', 1, 1, 1, 1, 1, 1, 'tech error.PNG', 'admin'),
('hola', 'espadas', 'guerrero', 1, 1, 1, 1, 1, 1, 'borjaespobre.PNG', 'daniel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre_usuario` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `contrasena` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre_usuario`, `email`, `contrasena`) VALUES
('admin', 'admin@admin.com', 'admin'),
('daniel', 'daniel@ejemplo.com', '12345'),
('daniel1', 'daniel1@ejemplo.com', '12345'),
('el_cojo', 'cojo@ejemplo.com', '12345'),
('javier', 'javier@ejemplo.com', '12345'),
('mario', 'asassaasas@gmail.com', '123456');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `personajes`
--
ALTER TABLE `personajes`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre_unique` (`nombre_personaje`),
  ADD UNIQUE KEY `imagen` (`imagen`),
  ADD KEY `fk_personajes_usuarios` (`creador`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `personajes`
--
ALTER TABLE `personajes`
  ADD CONSTRAINT `fk_personajes_usuarios` FOREIGN KEY (`creador`) REFERENCES `usuarios` (`nombre_usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
