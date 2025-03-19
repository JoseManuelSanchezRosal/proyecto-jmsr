-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-03-2025 a las 09:13:52
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
-- Base de datos: `bbdd_catalogo_jmsr`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Moviles'),
(2, 'Tablets'),
(3, 'Portatiles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fabricantes`
--

CREATE TABLE `fabricantes` (
  `id_fabricante` int(11) NOT NULL,
  `nombre_fabricante` varchar(100) NOT NULL,
  `correo_fabricante` varchar(254) NOT NULL,
  `telefono_fabricante` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fabricantes`
--

INSERT INTO `fabricantes` (`id_fabricante`, `nombre_fabricante`, `correo_fabricante`, `telefono_fabricante`) VALUES
(1, 'Samsung', 'samsung@gmail.com', '111111111'),
(2, 'Xiaomi', 'xiaomi@gmail.com', '222222222'),
(3, 'Apple', 'apple@gmail.com', '333333333');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `descripcion_producto` text NOT NULL,
  `cantidad_producto` int(100) NOT NULL,
  `id_fabricante` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `descripcion_producto`, `cantidad_producto`, `id_fabricante`, `id_categoria`) VALUES
(1, 'Samsung Galaxy S24 Ultra', 'Está equipado con una cuádruple cámara de hasta 200 MPX que garantiza fotos claras y detalladas, y una cámara frontal de 12 MPX para selfies perfectas. Su pantalla de 6,8\'\' y la potencia de la red 5G hacen del Samsung Galaxy S24 Ultra una elección inigualable para los amantes de la tecnología.', 20, 1, 1),
(3, 'Apple McBook Air 13\"', 'CPU de 10 núcleos con 4 núcleos de rendimiento y 6 de eficiencia.\r\nGPU de 10 núcleos.\r\nTrazado de rayos acelerado por hardware.\r\nNeural Engine de 16 núcleos.\r\n120 GB/s de ancho de banda de memoria.', 52, 3, 3),
(17, 'Xiaomi Redmi Pad 15 PRO 5G', 'Gran pantalla 2,5K de 12,1\" envolvente con cuidado de la vista\r\nDa rienda suelta a tu imaginación\r\nXiaomi HyperOS proporciona una experiencia fluida insignia\r\nLa plataforma móvil Snapdragon® 7s Gen 2 ofrece un rendimiento eficiente\r\nBatería de gran capacidad de 10 000 mAh (typ)', 66, 2, 2),
(20, 'Pavillion 3D', 'Portátil de 22\" pantalla ultra 3D de alta velocidad de transmisión de datos', 77, 2, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `fabricantes`
--
ALTER TABLE `fabricantes`
  ADD PRIMARY KEY (`id_fabricante`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_fabricante` (`id_fabricante`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `fabricantes`
--
ALTER TABLE `fabricantes`
  MODIFY `id_fabricante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_fabricante`) REFERENCES `fabricantes` (`id_fabricante`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
