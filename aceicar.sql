-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2025 a las 01:00:08
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
-- Base de datos: `aceicar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(12) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `tipo_carro` varchar(50) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `aceite` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `pago_cliente` decimal(10,2) DEFAULT NULL,
  `cambio` decimal(10,2) DEFAULT NULL,
  `metodo_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `correo`, `tipo_carro`, `placa`, `aceite`, `cantidad`, `fecha`, `total`, `pago_cliente`, `cambio`, `metodo_pago`) VALUES
(16, 'aceite@gmail.com', 'chevrolet joy', 'hkl 345', '10w-40', 1, '2025-07-03', 100.00, 100.00, 0.00, ''),
(17, 'aceite@gmail.com', 'sparkt', 'ght234', 'uuu', 2, '2025-07-11', 13400.00, 14000.00, 600.00, ''),
(18, 'aceite@gmail.com', 'sparkt', 'ght234', 'e', 1, '2025-07-12', 45500.00, 46000.00, 500.00, ''),
(19, 'aceite@gmail.com', 'sparkt', 'ght234', 'w', 1, '2025-07-12', 26900.00, 30000.00, 3100.00, ''),
(20, 'aceite@gmail.com', 'sparkt', 'ght234', 'SKU: 213011CO', 1, '2025-07-12', 34000.00, 35000.00, 1000.00, ''),
(21, 'aceite@gmail.com', 'sparkt', 'ght234', 'uuu', 1, '2025-07-12', 6700.00, 7000.00, 300.00, ''),
(22, 'aceite@gmail.com', 'sparkt', 'ght234', 'w', 1, '2025-07-12', 26900.00, 30000.00, 3100.00, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `producto`, `tipo`, `cantidad`, `precio`, `fecha`, `estado`) VALUES
(1, 'aceite 10w-40 mercado libre', '10w-40', 7, 100000, '2025-07-01', ''),
(2, 'MOTORLIFE', 'SKU: 213011CO', 0, 34000, '2025-07-02', ''),
(3, 'lll', 'gggg', 48, 11, '2025-07-11', ''),
(4, 'aceite', 'sae 50', 50, 27, '2025-07-11', ''),
(5, 'aceite', 'mobil', 40, 27, '2025-07-11', ''),
(6, 'aceite', 'atfy', 30, 10000, '2025-07-11', ''),
(8, 'q', 'w', 7, 26900, '2025-07-11', ''),
(9, 'w', 'e', 7, 45500, '2025-07-11', ''),
(10, 'r', 't', 7, 27, '2025-07-11', ''),
(11, 'yyyy', 'uuu', 4, 6700, '2025-07-11', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rol` enum('cliente','empleado','admin') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `clave`, `telefono`, `rol`) VALUES
(1, 'aceicar', 'carros', 'aceite@gmail.com', '$2y$10$tf6asyxLwqsE56gvxtEmJOPHgyo4KlQcw8K0Pki8j15/oQfVHpjwS', '3228306119', 'cliente'),
(2, 'jorg', 'villamiza', 'jor@gmail.com', '$2y$10$r/c.rf1/yvL7cctV.iXe6ukvxXRnN9pyywNPuXIyvlVehb0kdvUmq', '3228306111', 'cliente'),
(3, 'juan', 'perez', 'juan@aceicar.com', '$2y$10$0Fklw40QE7Ar3reIFTIV2Oy3.10VKq9aV4sp2CIBQv6iJA7puV4F.', '	3228000000', 'empleado'),
(4, 'javi', '', 'javi@aceicar.com', '$2y$10$tTrhgkbR0CuPOVS1fngDAeBAcKqdiM4VSezRzshtRYWUnBRxS8cdW', NULL, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `cantidad_vendida` int(11) NOT NULL,
  `precio` decimal(10,3) NOT NULL,
  `total` decimal(10,3) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `empleado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `producto`, `tipo`, `cantidad_vendida`, `precio`, `total`, `fecha`, `hora`, `metodo_pago`, `empleado`) VALUES
(1, '10W-40', 'nissan', 1, 100.000, 100.000, '2025-07-03', '14:05:33', 'Efectivo', ''),
(2, '10W-40', 'nissan', 1, 100.000, 100.000, '2025-07-03', '14:09:06', 'Efectivo', ''),
(3, 'aceite 10w-40 mercado libre', '10w-40', 2, 100.000, 200.000, '2025-07-03', '14:37:52', 'Efectivo', ''),
(4, 'MOTORLIFE', 'SKU: 213011CO', 1, 34.000, 34.000, '2025-07-03', '15:00:21', 'Efectivo', ''),
(5, 'aceite 10w-40 mercado libre', '10w-40', 1, 100.000, 100.000, '2025-07-03', '15:02:03', 'Efectivo', ''),
(6, 'yyyy', 'uuu', 2, 6700.000, 13400.000, '2025-07-11', '16:47:57', 'Efectivo', ''),
(7, 'w', 'e', 1, 45500.000, 45500.000, '2025-07-12', '14:13:02', 'Efectivo', ''),
(8, 'q', 'w', 1, 26900.000, 26900.000, '2025-07-12', '14:16:13', 'Efectivo', ''),
(9, 'MOTORLIFE', 'SKU: 213011CO', 1, 34000.000, 34000.000, '2025-07-12', '14:24:44', 'Efectivo', ''),
(10, 'q', 'w', 1, 26900.000, 26900.000, '2025-07-12', '16:58:31', 'Efectivo', 'juan');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
