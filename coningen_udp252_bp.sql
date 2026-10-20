-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-11-2025 a las 00:37:04
-- Versión del servidor: 10.6.23-MariaDB-cll-lve
-- Versión de PHP: 8.1.32

-- Betrayal Palace - estructura de la base de datos y datos de catalogo

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

CREATE TABLE `apellido_orden` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `apellido_orden` (`id`, `nombre`, `activo`) VALUES
(1, 'Apellido Paterno Primero', 1),
(2, 'Apellido Materno Primero', 1);

-- --------------------------------------------------------

CREATE TABLE `billetera` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `saldo` int(9) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

CREATE TABLE `billetera_historial` (
  `id` int(11) NOT NULL,
  `billetera_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `monto` int(9) NOT NULL,
  `partida_id` int(11) DEFAULT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

CREATE TABLE `bill_hist_reg_tipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `suma` int(1) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `bill_hist_reg_tipo` (`id`, `nombre`, `suma`, `activo`) VALUES
(1, 'Bono Bienvenida', 1, 1),
(2, 'Apuesta', -1, 1),
(3, 'Retiro', -1, 1),
(4, 'Abono', 1, 1),
(5, 'Gana', 1, 1);

-- --------------------------------------------------------

CREATE TABLE `documento_identidad` (
  `id` int(11) NOT NULL,
  `valor` varchar(50) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `orden_apeliido_id` int(1) NOT NULL,
  `nacionalidad_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL,
  `documento_tipo_id` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

CREATE TABLE `documento_identidad_tipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `documento_identidad_tipo` (`id`, `nombre`, `activo`) VALUES
(1, 'Cédula de Identidad', 1),
(2, 'Licencia de Conducir', 1);

-- --------------------------------------------------------

CREATE TABLE `genero` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `genero` (`id`, `nombre`, `activo`) VALUES
(1, 'Femenino', 1),
(2, 'Masculino', 1);

-- --------------------------------------------------------

CREATE TABLE `juego` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(5000) NOT NULL,
  `reglas_url` varchar(5000) DEFAULT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `juego` (`id`, `nombre`, `descripcion`, `reglas_url`, `activo`) VALUES
(1, 'Ruleta UDP', 'Ruleta clásica', 'https://#', 0);

-- --------------------------------------------------------

CREATE TABLE `juego_color` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `juego_color` (`id`, `nombre`, `activo`) VALUES
(1, 'Negro', 1),
(2, 'Rojo', 1),
(3, 'Verde', 1);

-- --------------------------------------------------------

CREATE TABLE `juego_opcion_apuesta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `pago` int(11) NOT NULL,
  `juego_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `juego_opcion_apuesta` (`id`, `nombre`, `pago`, `juego_id`, `color_id`, `activo`) VALUES
(1, 'Rojo', 1, 1, 2, 1),
(2, 'Negro', 1, 1, 1, 1),
(3, 'Bajos (1 al 18)', 1, 1, NULL, 1),
(4, 'Altos (19 al 36)', 1, 1, NULL, 1),
(5, 'Primera Docena (1 al 12)', 2, 1, NULL, 1),
(6, 'Segunda Docena (13 al 24)', 2, 1, NULL, 1),
(7, 'Tercera Docena (25 al 36)', 2, 1, NULL, 1),
(8, 'Columna 1', 2, 1, NULL, 1),
(9, 'Columna 2', 2, 1, NULL, 1),
(10, 'Columna 3', 2, 1, NULL, 1),
(11, '0 Pleno', 35, 1, NULL, 1),
(12, '1 Pleno', 35, 1, NULL, 1),
(13, '2 Pleno', 35, 1, NULL, 1),
(14, '3 Pleno', 35, 1, NULL, 1),
(15, '4 Pleno', 35, 1, NULL, 1),
(16, '5 Pleno', 35, 1, NULL, 1),
(17, '6 Pleno', 35, 1, NULL, 1),
(18, '7 Pleno', 35, 1, NULL, 1),
(19, '8 Pleno', 35, 1, NULL, 1),
(20, '9 Pleno', 35, 1, NULL, 1),
(21, '10 Pleno', 35, 1, NULL, 1),
(22, '11 Pleno', 35, 1, NULL, 1),
(23, '12 Pleno', 35, 1, NULL, 1),
(24, '13 Pleno', 35, 1, NULL, 1),
(25, '14 Pleno', 35, 1, NULL, 1),
(26, '15 Pleno', 35, 1, NULL, 1),
(27, '16 Pleno', 35, 1, NULL, 1),
(28, '17 Pleno', 35, 1, NULL, 1),
(29, '18 Pleno', 35, 1, NULL, 1),
(30, '19 Pleno', 35, 1, NULL, 1),
(31, '20 Pleno', 35, 1, NULL, 1),
(32, '21 Pleno', 35, 1, NULL, 1),
(33, '22 Pleno', 35, 1, NULL, 1),
(34, '23 Pleno', 35, 1, NULL, 1),
(35, '24 Pleno', 35, 1, NULL, 1),
(36, '25 Pleno', 35, 1, NULL, 1),
(37, '26 Pleno', 35, 1, NULL, 1),
(38, '27 Pleno', 35, 1, NULL, 1),
(39, '28 Pleno', 35, 1, NULL, 1),
(40, '29 Pleno', 35, 1, NULL, 1),
(41, '30 Pleno', 35, 1, NULL, 1),
(42, '31 Pleno', 35, 1, NULL, 1),
(43, '32 Pleno', 35, 1, NULL, 1),
(44, '33 Pleno', 35, 1, NULL, 1),
(45, '34 Pleno', 35, 1, NULL, 1),
(46, '35 Pleno', 35, 1, NULL, 1),
(47, '36 Pleno', 35, 1, NULL, 1);

-- --------------------------------------------------------

CREATE TABLE `mesa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `juego_id` int(11) NOT NULL,
  `monto_min` int(11) NOT NULL,
  `monto_max` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `mesa` (`id`, `nombre`, `juego_id`, `monto_min`, `monto_max`, `estado_id`, `activo`) VALUES
(1, 'Mesa Ruleta 5.000', 1, 5000, 50000, 1, 1),
(2, 'Mesa Ruleta 10.000', 1, 10000, 100000, 1, 1);

-- --------------------------------------------------------

CREATE TABLE `mesa_estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `mesa_estado` (`id`, `nombre`, `activo`) VALUES
(1, 'Disponible', 1),
(2, 'Cerrada', 1);

-- --------------------------------------------------------

CREATE TABLE `mesa_historico` (
  `id` int(11) NOT NULL,
  `mesa_id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

CREATE TABLE `nacionalidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `nacionalidad` (`id`, `nombre`, `activo`) VALUES
(1, 'Chilena', 1),
(2, 'Venezolana', 1),
(3, 'Colombiana', 1),
(4, 'Peruana', 1),
(5, 'Haitiana', 1);

-- --------------------------------------------------------

CREATE TABLE `partida` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mesa_id` int(11) NOT NULL,
  `estado_Id` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

CREATE TABLE `partida_detalle` (
  `id` int(11) NOT NULL,
  `partida_id` int(11) NOT NULL,
  `opcion_id` int(11) NOT NULL,
  `resultado_id` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `monto` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

CREATE TABLE `partida_estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `partida_estado` (`id`, `nombre`, `activo`) VALUES
(1, 'Apuestas', 1),
(2, 'Esperando resultado', 1),
(3, 'Pagando', 1);

-- --------------------------------------------------------

CREATE TABLE `partida_resultado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `partida_resultado` (`id`, `nombre`, `activo`) VALUES
(1, 'Casa Gana', 1),
(2, 'Jugador Gana', 1);

-- --------------------------------------------------------

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Indices
-- --------------------------------------------------------

ALTER TABLE `apellido_orden`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `billetera`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`);

ALTER TABLE `billetera_historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billetera_id` (`billetera_id`),
  ADD KEY `tipo_id` (`tipo_id`),
  ADD KEY `partida_id` (`partida_id`);

ALTER TABLE `bill_hist_reg_tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `documento_identidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`),
  ADD KEY `orden_apeliido_id` (`orden_apeliido_id`),
  ADD KEY `nacionalidad_id` (`nacionalidad_id`),
  ADD KEY `genero_id` (`genero_id`),
  ADD KEY `documento_tipo_id` (`documento_tipo_id`);

ALTER TABLE `documento_identidad_tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `genero`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `juego`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `juego_color`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `juego_opcion_apuesta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `juego_id` (`juego_id`),
  ADD KEY `color_id` (`color_id`);

ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `juego_id` (`juego_id`),
  ADD KEY `estado_id` (`estado_id`);

ALTER TABLE `mesa_estado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `mesa_historico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mesa_id` (`mesa_id`);

ALTER TABLE `nacionalidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `mesa_id` (`mesa_id`),
  ADD KEY `estado_Id` (`estado_Id`);

ALTER TABLE `partida_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partida_id` (`partida_id`),
  ADD KEY `opcion_id` (`opcion_id`),
  ADD KEY `resultado_id` (`resultado_id`);

ALTER TABLE `partida_estado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `partida_resultado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `persona_id` (`persona_id`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `apellido_orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `billetera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `billetera_historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `bill_hist_reg_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `documento_identidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `documento_identidad_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `juego`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `juego_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `juego_opcion_apuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

ALTER TABLE `mesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `mesa_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `mesa_historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `nacionalidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `partida_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `partida_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `partida_resultado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
-- Restricciones (claves foraneas)
-- --------------------------------------------------------

ALTER TABLE `billetera`
  ADD CONSTRAINT `billetera_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

ALTER TABLE `billetera_historial`
  ADD CONSTRAINT `billetera_historial_ibfk_1` FOREIGN KEY (`billetera_id`) REFERENCES `billetera` (`id`),
  ADD CONSTRAINT `billetera_historial_ibfk_2` FOREIGN KEY (`tipo_id`) REFERENCES `bill_hist_reg_tipo` (`id`),
  ADD CONSTRAINT `billetera_historial_ibfk_3` FOREIGN KEY (`partida_id`) REFERENCES `partida` (`id`);

ALTER TABLE `documento_identidad`
  ADD CONSTRAINT `documento_identidad_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `documento_identidad_ibfk_2` FOREIGN KEY (`orden_apeliido_id`) REFERENCES `apellido_orden` (`id`),
  ADD CONSTRAINT `documento_identidad_ibfk_3` FOREIGN KEY (`nacionalidad_id`) REFERENCES `nacionalidad` (`id`),
  ADD CONSTRAINT `documento_identidad_ibfk_4` FOREIGN KEY (`genero_id`) REFERENCES `genero` (`id`),
  ADD CONSTRAINT `documento_identidad_ibfk_5` FOREIGN KEY (`documento_tipo_id`) REFERENCES `documento_identidad_tipo` (`id`);

ALTER TABLE `juego_opcion_apuesta`
  ADD CONSTRAINT `juego_opcion_apuesta_ibfk_1` FOREIGN KEY (`juego_id`) REFERENCES `juego` (`id`),
  ADD CONSTRAINT `juego_opcion_apuesta_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `juego_color` (`id`);

ALTER TABLE `mesa`
  ADD CONSTRAINT `mesa_ibfk_1` FOREIGN KEY (`juego_id`) REFERENCES `juego` (`id`),
  ADD CONSTRAINT `mesa_ibfk_2` FOREIGN KEY (`estado_id`) REFERENCES `mesa_estado` (`id`);

ALTER TABLE `mesa_historico`
  ADD CONSTRAINT `mesa_historico_ibfk_1` FOREIGN KEY (`mesa_id`) REFERENCES `mesa` (`id`);

ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `partida_ibfk_2` FOREIGN KEY (`mesa_id`) REFERENCES `mesa` (`id`),
  ADD CONSTRAINT `partida_ibfk_3` FOREIGN KEY (`estado_Id`) REFERENCES `partida_estado` (`id`);

ALTER TABLE `partida_detalle`
  ADD CONSTRAINT `partida_detalle_ibfk_1` FOREIGN KEY (`partida_id`) REFERENCES `partida` (`id`),
  ADD CONSTRAINT `partida_detalle_ibfk_2` FOREIGN KEY (`opcion_id`) REFERENCES `juego_opcion_apuesta` (`id`),
  ADD CONSTRAINT `partida_detalle_ibfk_3` FOREIGN KEY (`resultado_id`) REFERENCES `partida_resultado` (`id`);

ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;