-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2024 a las 01:21:41
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
-- Base de datos: `loginphp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Attempts` int(11) NOT NULL,
  `Role` int(11) NOT NULL,
  `is_blocked` int(11) NOT NULL,
  `password_reset_token` varchar(250) NOT NULL,
  `token_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastName`, `username`, `correo`, `password`, `Attempts`, `Role`, `is_blocked`, `password_reset_token`, `token_expiration`) VALUES
(2, 'Angel', 'romero', 'angel10', '', '$2y$10$zsbeGughGzFEvaDRhrlBa.rHDUdI.myrR2gLbWGElyi/gBAmxHHCu', 5, 1, 0, '', NULL),
(3, 'hola', 'hola', 'hola', '', '$2y$10$.ZJIHeTH/41B0REDvEQqbu54ELZ8OwvnWbepy1vi29N5.cgmk1p0S', 5, 2, 0, '', NULL),
(6, 'Miguel', 'González', 'miguelGR', 'magr10007pz@gmail.com', '$2y$10$Fhg7uz1ESTzqDliZT8ZSFuqfdT4SykA0vqAkcS8rkbsHE9iXHLf8a', 5, 1, 0, '', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
