-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-03-2024 a las 22:40:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nomina_pro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `IDAsistencia` int(11) NOT NULL,
  `IDusuario` int(11) DEFAULT NULL,
  `FechayHora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`IDAsistencia`, `IDusuario`, `FechayHora`) VALUES
(1, 1, '2024-03-13 16:37:51'),
(2, 1, '2024-03-14 16:37:32'),
(3, 123456789, '2024-03-14 16:22:52'),
(4, 1106392385, '2024-03-20 16:39:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bonificaciones`
--

CREATE TABLE `bonificaciones` (
  `IDBonificacion` int(11) NOT NULL,
  `TipoBonificacion` varchar(50) DEFAULT NULL,
  `MontoBonificacion` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bonificaciones`
--

INSERT INTO `bonificaciones` (`IDBonificacion`, `TipoBonificacion`, `MontoBonificacion`) VALUES
(1, 'Auxilio de Transporte', 162000.00),
(2, 'No Aplica', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `IDcargo` int(11) NOT NULL,
  `NombreCargo` varchar(30) NOT NULL,
  `SalarioCargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`IDcargo`, `NombreCargo`, `SalarioCargo`) VALUES
(1, 'Recepcionista', 1500000),
(2, 'Ingeniero en sistemas', 3000000),
(3, 'Director Administrativo', 12500000),
(4, 'Auxiliar Administrativo', 1950000),
(5, 'Abogado', 2800000),
(6, 'Contador Publico', 3000000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `IDciu` int(11) NOT NULL,
  `NombreCiu` varchar(50) DEFAULT NULL,
  `IDdep` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`IDciu`, `NombreCiu`, `IDdep`) VALUES
(1, 'Leticia', 1),
(2, 'Puerto Nariño', 1),
(3, 'El Encanto', 1),
(4, 'La Chorrera', 1),
(5, 'Tarapacá', 1),
(6, 'Puerto Alegría', 1),
(7, 'Caucasia', 2),
(8, 'El Bagre', 2),
(9, 'Cáceres', 2),
(10, 'Puerto Berrío', 2),
(11, 'Tarazá', 2),
(12, 'Nechí', 2),
(13, 'Arauca', 3),
(14, 'Arauquita', 3),
(15, 'Cravo Norte', 3),
(16, 'Fortul', 3),
(17, 'Tame', 3),
(18, 'Saravena', 3),
(19, 'Barranquilla', 4),
(20, 'Malambo', 4),
(21, 'Baranoa', 4),
(22, 'Galapa', 4),
(23, 'Puerto Colombia', 4),
(24, 'Sabanalarga', 4),
(25, 'Arjona', 5),
(26, 'Calamar', 5),
(27, 'El Carmen de Bolívar', 5),
(28, 'Cartagena de Indias', 5),
(29, 'Magangué', 5),
(30, 'Montecristo', 5),
(31, 'Cómbita', 6),
(32, 'Tunja', 6),
(33, 'Samacá', 6),
(34, 'Motavita', 6),
(35, 'Toca', 6),
(36, 'Ventaquemada', 6),
(37, 'Manizales', 7),
(38, 'Chinchiná', 7),
(39, 'La Dorada', 7),
(40, 'Villamaría', 7),
(41, 'Neira', 7),
(42, 'Anserma', 7),
(43, 'Florencia', 8),
(44, 'Puerto Rico', 8),
(45, 'San Vicente del Caguán', 8),
(46, 'El Doncello', 8),
(47, 'La Montañita', 8),
(48, 'Cartagena del Chairá', 8),
(49, 'Yopal', 9),
(50, 'Villanueva', 9),
(51, 'Monterrey', 9),
(52, 'Aguazul', 9),
(53, 'Paz de Ariporo', 9),
(54, 'Tauramena', 9),
(55, 'Popayán', 10),
(56, 'Bolívar', 10),
(57, 'Suárez', 10),
(58, 'Santander de Quilichao', 10),
(59, 'Puerto Tejada', 10),
(60, 'Miranda', 10),
(61, 'Valledupar', 11),
(62, 'Aguachica', 11),
(63, 'Agustín Codazzi', 11),
(64, 'Bosconia', 11),
(65, 'Chimichagua', 11),
(66, 'El Copey', 11),
(67, 'Quibdó', 12),
(68, 'Riosucio', 12),
(69, 'Medio Atrato', 12),
(70, 'Istmina', 12),
(71, 'Belén de Bajirá', 12),
(72, 'Bojayá', 12),
(73, 'Montería', 13),
(74, 'Planeta Rica', 13),
(75, 'Ciénaga de Oro', 13),
(76, 'Cereté', 13),
(77, 'Ayapel', 13),
(78, 'Montelíbano', 13),
(79, 'Girardot', 14),
(80, 'Zipaquirá', 14),
(81, 'Facatativá', 14),
(82, 'Mosquera', 14),
(83, 'Soacha', 14),
(84, 'Fusagasugá', 14),
(85, 'Barrancominas', 15),
(86, 'Cacahual', 15),
(87, 'Inírida', 15),
(88, 'La Guadalupe', 15),
(89, 'Morichal Nuevo', 15),
(90, 'San Felipe', 15),
(91, 'Calamar', 16),
(92, 'El Retorno', 16),
(93, 'Miraflores', 16),
(94, 'San José del Guaviare', 16),
(95, 'Neiva', 17),
(96, 'Garzón', 17),
(97, 'La Plata', 17),
(98, 'Pitalito', 17),
(99, 'Campoalegre', 17),
(100, 'Algeciras', 17),
(101, 'Riohacha', 18),
(102, 'San Juan del Cesar', 18),
(103, 'Uribia', 18),
(104, 'Manaure', 18),
(105, 'Maicao', 18),
(106, 'Dibulla', 18),
(107, 'Santa Marta', 19),
(108, 'Sitionuevo', 19),
(109, 'Plato', 19),
(110, 'Pivijay', 19),
(111, 'Nueva Granada', 19),
(112, 'Guamal', 19),
(113, 'Villavicencio', 20),
(114, 'Acacías', 20),
(115, 'La Macarena', 20),
(116, 'Puerto López', 20),
(117, 'Mesetas', 20),
(118, 'El Dorado', 20),
(119, 'Pasto', 21),
(120, 'Tumaco', 21),
(121, 'Ipiales', 21),
(122, 'Barbacoas', 21),
(123, 'La Tola', 21),
(124, 'Cumbal', 21),
(125, 'Cúcuta', 22),
(126, 'Villa del Rosario', 22),
(127, 'Tibú', 22),
(128, 'Ábrego', 22),
(129, 'Ocaña', 22),
(130, 'Pamplona', 22),
(131, 'Mocoa', 23),
(132, 'Puerto Asís', 23),
(133, 'Puerto Guzmán', 23),
(134, 'Valle del Guamuez', 23),
(135, 'Orito', 23),
(136, 'San Miguel', 23),
(137, 'Armenia', 24),
(138, 'Calarcá', 24),
(139, 'Córdoba', 24),
(140, 'Quimbaya', 24),
(141, 'Filandia', 24),
(142, 'Montenegro', 24),
(143, 'Pereira', 25),
(144, 'Dosquebradas', 25),
(145, 'Santa Rosa de Cabal', 25),
(146, 'Quinchía', 25),
(147, 'La Virginia', 25),
(148, 'Belén de Umbría', 25),
(149, 'Providencia', 26),
(150, 'Bucaramanga', 27),
(151, 'Floridablanca', 27),
(152, 'Barrancabermeja', 27),
(153, 'Charalá', 27),
(154, 'Cimitarra', 27),
(155, 'Girón', 27),
(156, 'Sincelejo', 28),
(157, 'San Onofre', 28),
(158, 'Corozal', 28),
(159, 'Sampués', 28),
(160, 'San Marcos', 28),
(161, 'Majagual', 28),
(162, 'Ibagué', 29),
(163, 'Espinal', 29),
(164, 'Líbano', 29),
(165, 'Mariquita', 29),
(166, 'Melgar', 29),
(167, 'Chaparral', 29),
(168, 'Cali', 30),
(169, 'Buenaventura', 30),
(170, 'Buga', 30),
(171, 'Cartago', 30),
(172, 'Jamundí', 30),
(173, 'Palmira', 30),
(174, 'Carurú', 31),
(175, 'Mitú', 31),
(176, 'Pacoa', 31),
(177, 'Papunaua', 31),
(178, 'Taraira', 31),
(179, 'Yavaraté', 31),
(180, 'Cumaribo', 32),
(181, 'La Primavera', 32),
(182, 'Puerto Carreño', 32),
(183, 'Santa Rosalía', 32),
(184, 'Bogotá', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `IDdep` int(11) NOT NULL,
  `NombreDep` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`IDdep`, `NombreDep`) VALUES
(1, 'Amazonas'),
(2, 'Antioquía'),
(3, 'Arauca'),
(4, 'Atlántico'),
(5, 'Bolívar'),
(6, 'Boyacá'),
(7, 'Caldas'),
(8, 'Caquetá'),
(9, 'Casanare'),
(10, 'Cauca'),
(11, 'Cesar'),
(12, 'Chocó'),
(13, 'Córdoba'),
(14, 'Cundinamarca'),
(15, 'Guainía'),
(16, 'Guaviare'),
(17, 'Huila'),
(18, 'La Guajira'),
(19, 'Magdalena'),
(20, 'Meta'),
(21, 'Nariño'),
(22, 'Norte de Santander'),
(23, 'Putumayo'),
(24, 'Quindío'),
(25, 'Risaralda'),
(26, 'San Andrés y Providencia'),
(27, 'Santander'),
(28, 'Sucre'),
(29, 'Tolima'),
(30, 'Valle del Cauca'),
(31, 'Vaupés'),
(32, 'Vichada'),
(33, 'Bogotá, Distrito Capital');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina`
--

CREATE TABLE `nomina` (
  `IDNomina` int(11) NOT NULL,
  `IDusuario` int(11) DEFAULT NULL,
  `FechaNomina` date DEFAULT NULL,
  `Mes` varchar(10) NOT NULL,
  `DiasTrabajados` int(5) NOT NULL,
  `SalarioNeto` decimal(10,2) DEFAULT NULL,
  `ValorParafiscales` decimal(10,2) NOT NULL,
  `ValorPrestamo` decimal(10,2) NOT NULL,
  `TotalDeducidos` decimal(10,2) DEFAULT NULL,
  `IDBonificacion` int(11) DEFAULT NULL,
  `NetoPagado` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nomina`
--

INSERT INTO `nomina` (`IDNomina`, `IDusuario`, `FechaNomina`, `Mes`, `DiasTrabajados`, `SalarioNeto`, `ValorParafiscales`, `ValorPrestamo`, `TotalDeducidos`, `IDBonificacion`, `NetoPagado`) VALUES
(1, 1, '2024-03-22', 'Marzo', 25, 2500000.00, 225000.00, 125000.00, 350000.00, 2, 2150000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parafiscales`
--

CREATE TABLE `parafiscales` (
  `IDparafiscal` int(11) NOT NULL,
  `TipoParafiscal` varchar(50) DEFAULT NULL,
  `TasaParafiscal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parafiscales`
--

INSERT INTO `parafiscales` (`IDparafiscal`, `TipoParafiscal`, `TasaParafiscal`) VALUES
(1, 'Pension', 0.04),
(2, 'Salud', 0.04),
(3, 'Arl', 0.01);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `IDpres` int(11) NOT NULL,
  `IDusuario` int(11) DEFAULT NULL,
  `Fecha_pres` date DEFAULT NULL,
  `Valor_pres` int(11) DEFAULT NULL,
  `CantidadCuotas` int(10) NOT NULL,
  `ValorCuotas` decimal(10,2) NOT NULL,
  `EstadoPres` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`IDpres`, `IDusuario`, `Fecha_pres`, `Valor_pres`, `CantidadCuotas`, `ValorCuotas`, `EstadoPres`) VALUES
(1, 1, '2024-03-20', 1500000, 12, 125000.00, 'Solicitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `IDrol` int(11) NOT NULL,
  `NombreRol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`IDrol`, `NombreRol`) VALUES
(1, 'Administrador'),
(2, 'Contador'),
(3, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontrato`
--

CREATE TABLE `tipocontrato` (
  `IDtipContrato` int(11) NOT NULL,
  `NombreTipContrato` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipocontrato`
--

INSERT INTO `tipocontrato` (`IDtipContrato`, `NombreTipContrato`) VALUES
(1, 'Termino Fijo'),
(2, 'Termino Indefinido'),
(3, 'Termino Obra o Labor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IDusuario` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(50) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Contraseña` varchar(100) NOT NULL,
  `FechaRegistro` date NOT NULL,
  `Telefono` varchar(11) NOT NULL,
  `IDrol` int(11) NOT NULL,
  `IDcargo` int(11) DEFAULT NULL,
  `IDciu` int(11) DEFAULT NULL,
  `IDtipContrato` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IDusuario`, `Nombre`, `Apellido`, `Correo`, `Contraseña`, `FechaRegistro`, `Telefono`, `IDrol`, `IDcargo`, `IDciu`, `IDtipContrato`) VALUES
(1, 'Alejandro', 'Ortegon', 'ortegonplazas15@gmail.com', 'admin', '2024-03-14', '3213650268', 1, 2, 162, 1),
(123456789, 'Enrique', 'Hernandez', 'enri56@hotmail.com', 'empleado123', '2024-03-28', '182761234', 3, 1, 21, 1),
(1106392385, 'Kevin', 'Sandoval', 'kevinandres204ka@gmail.com', 'kevin2020jk', '2024-03-20', '3209806540', 2, 2, 162, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`IDAsistencia`),
  ADD KEY `IDusuario` (`IDusuario`) USING BTREE;

--
-- Indices de la tabla `bonificaciones`
--
ALTER TABLE `bonificaciones`
  ADD PRIMARY KEY (`IDBonificacion`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`IDcargo`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`IDciu`),
  ADD KEY `IDdep` (`IDdep`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`IDdep`);

--
-- Indices de la tabla `nomina`
--
ALTER TABLE `nomina`
  ADD PRIMARY KEY (`IDNomina`),
  ADD KEY `IDusuario` (`IDusuario`) USING BTREE,
  ADD KEY `IDBonificacion` (`IDBonificacion`);

--
-- Indices de la tabla `parafiscales`
--
ALTER TABLE `parafiscales`
  ADD PRIMARY KEY (`IDparafiscal`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`IDpres`),
  ADD KEY `IDusuario` (`IDusuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`IDrol`);

--
-- Indices de la tabla `tipocontrato`
--
ALTER TABLE `tipocontrato`
  ADD PRIMARY KEY (`IDtipContrato`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IDusuario`),
  ADD KEY `IDcargo` (`IDcargo`),
  ADD KEY `IDciu` (`IDciu`),
  ADD KEY `IDtipContrato` (`IDtipContrato`),
  ADD KEY `IDrol` (`IDrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `IDAsistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `IDcargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `IDciu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `IDdep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `nomina`
--
ALTER TABLE `nomina`
  MODIFY `IDNomina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `IDpres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `IDrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipocontrato`
--
ALTER TABLE `tipocontrato`
  MODIFY `IDtipContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`IDusuario`) REFERENCES `usuario` (`IDusuario`);

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`IDdep`) REFERENCES `departamento` (`IDdep`);

--
-- Filtros para la tabla `nomina`
--
ALTER TABLE `nomina`
  ADD CONSTRAINT `nomina_ibfk_1` FOREIGN KEY (`IDusuario`) REFERENCES `usuario` (`IDusuario`),
  ADD CONSTRAINT `nomina_ibfk_2` FOREIGN KEY (`IDBonificacion`) REFERENCES `bonificaciones` (`IDBonificacion`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`IDusuario`) REFERENCES `usuario` (`IDusuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`IDcargo`) REFERENCES `cargo` (`IDcargo`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`IDciu`) REFERENCES `ciudad` (`IDciu`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`IDtipContrato`) REFERENCES `tipocontrato` (`IDtipContrato`),
  ADD CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`IDrol`) REFERENCES `roles` (`IDrol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
