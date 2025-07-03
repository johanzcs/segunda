-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2025 a las 16:02:12
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

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
  `filtro` varchar(100) NOT NULL,
  `repuesto` varchar(100) NOT NULL,
  `pago_cliente` decimal(10,2) DEFAULT NULL,
  `cambio` decimal(10,2) DEFAULT NULL,
  `metodo_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `correo`, `tipo_carro`, `placa`, `aceite`, `cantidad`, `fecha`, `total`, `filtro`, `repuesto`, `pago_cliente`, `cambio`, `metodo_pago`) VALUES
(1, 'aceite@gmail.com', 'spart gt', 'fis837', '5W-30', 2, '2025-06-26', '90.00', '', '', '0.00', '0.00', ''),
(2, 'aceite@gmail.com', 'kia picanto', 'HJE839', '10W-40', 4, '2025-06-26', '110.00', '', '', '0.00', '0.00', ''),
(3, 'aceite@gmail.com', 'chebrolet aveo', 'JZB829', '5W-30', 5, '2025-06-26', '120.00', '', '', '0.00', '0.00', ''),
(4, 'aceite@gmail.com', 'chevrolet joy', 'HSD319', '10W-40', 6, '2025-06-27', '130.00', 'Filtro de aceite', 'Bujías', '0.00', '0.00', ''),
(5, 'aceite@gmail.com', 'spark', 'THA 234', '5W-30', 2, '2025-07-01', '150.50', 'Filtro de aire', 'Pastillas de freno', '160.00', '9.50', ''),
(6, 'aceite@gmail.com', 'kia picanto', 'THB 345', '15W-50', 4, '2025-07-01', '170.50', 'Filtro de aceite', 'Sensor de oxígeno', '180.00', '9.50', ''),
(7, 'aceite@gmail.com', 'AVEO ', 'SHS 112', '10W-40', 1, '2025-07-01', '165.50', 'Filtro de aceite', 'Bujías', '170.00', '4.50', ''),
(8, 'aceite@gmail.com', 'nissan', 'JSD 832', '10W-40', 1, '2025-07-03', '100.00', 'Filtro de aceite', 'Bujías', '120.00', '20.00', ''),
(9, 'aceite@gmail.com', 'nissan', 'JSD 832', '10W-40', 1, '2025-07-03', '100.00', 'Filtro de aceite', 'Bujías', '120.00', '20.00', ''),
(10, 'aceite@gmail.com', 'nissan', 'JSD 832', '10W-40', 1, '2025-07-03', '100.00', 'Filtro de aceite', 'Bujías', '120.00', '20.00', ''),
(11, 'aceite@gmail.com', 'nissan', 'JSD 832', '10W-40', 1, '2025-07-03', '100.00', 'Filtro de aceite', 'Bujías', '120.00', '20.00', ''),
(12, 'aceite@gmail.com', 'nissan', 'JSD 832', '10W-40', 1, '2025-07-03', '100.00', 'Filtro de aceite', 'Bujías', '120.00', '20.00', ''),
(13, 'aceite@gmail.com', 'nissan', 'JSD 832', '10W-40', 1, '2025-07-03', '100.00', 'Filtro de aceite', 'Bujías', '120.00', '20.00', ''),
(14, 'aceite@gmail.com', 'susuki switch', 'jsg 352', '10w-40', 2, '2025-07-03', '200.00', 'Filtro de aire', 'Pastillas de freno', '250.00', '50.00', ''),
(15, 'aceite@gmail.com', 'fiat mobi', 'nsi 729', 'SKU: 213011CO', 1, '2025-07-03', '34.00', 'Filtro de combustible', 'Correa de repartición', '35.00', '1.00', ''),
(16, 'aceite@gmail.com', 'chevrolet joy', 'hkl 345', '10w-40', 1, '2025-07-03', '100.00', 'No aplica', 'No aplica', '100.00', '0.00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,3) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `producto`, `tipo`, `cantidad`, `precio`, `fecha`, `estado`) VALUES
(1, 'aceite 10w-40 mercado libre', '10w-40', 7, '100.000', '2025-07-01', ''),
(2, 'MOTORLIFE', 'SKU: 213011CO', 1, '34.000', '2025-07-02', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_filtros`
--

CREATE TABLE `inventario_filtros` (
  `id` int(11) NOT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `tipo_marca` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_repuestos`
--

CREATE TABLE `inventario_repuestos` (
  `id` int(11) NOT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `tipo_marca` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `clave`, `telefono`, `rol`) VALUES
(1, 'aceicar', 'carros', 'aceite@gmail.com', '$2y$10$tf6asyxLwqsE56gvxtEmJOPHgyo4KlQcw8K0Pki8j15/oQfVHpjwS', '3228306119', 'cliente'),
(2, 'jorg', 'villamiza', 'jor@gmail.com', '$2y$10$r/c.rf1/yvL7cctV.iXe6ukvxXRnN9pyywNPuXIyvlVehb0kdvUmq', '3228306111', 'cliente'),
(3, 'juan', 'perez', 'juan@aceicar.com', '$2y$10$0Fklw40QE7Ar3reIFTIV2Oy3.10VKq9aV4sp2CIBQv6iJA7puV4F.', '	3228000000', 'empleado');

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
  `metodo_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `producto`, `tipo`, `cantidad_vendida`, `precio`, `total`, `fecha`, `hora`, `metodo_pago`) VALUES
(1, '10W-40', 'nissan', 1, '100.000', '100.000', '2025-07-03', '14:05:33', 'Efectivo'),
(2, '10W-40', 'nissan', 1, '100.000', '100.000', '2025-07-03', '14:09:06', 'Efectivo'),
(3, 'aceite 10w-40 mercado libre', '10w-40', 2, '100.000', '200.000', '2025-07-03', '14:37:52', 'Efectivo'),
(4, 'MOTORLIFE', 'SKU: 213011CO', 1, '34.000', '34.000', '2025-07-03', '15:00:21', 'Efectivo'),
(5, 'aceite 10w-40 mercado libre', '10w-40', 1, '100.000', '100.000', '2025-07-03', '15:02:03', 'Efectivo');

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
-- Indices de la tabla `inventario_filtros`
--
ALTER TABLE `inventario_filtros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario_repuestos`
--
ALTER TABLE `inventario_repuestos`
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
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventario_filtros`
--
ALTER TABLE `inventario_filtros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario_repuestos`
--
ALTER TABLE `inventario_repuestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
