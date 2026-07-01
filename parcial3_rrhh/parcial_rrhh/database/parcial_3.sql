-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2026 a las 18:50:20
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
-- Base de datos: `parcial_3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_motivos_terminacion`
--

CREATE TABLE `cat_motivos_terminacion` (
  `C_TERMINACION` int(11) NOT NULL,
  `MOTIVO` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_motivos_terminacion`
--

INSERT INTO `cat_motivos_terminacion` (`C_TERMINACION`, `MOTIVO`) VALUES
(1, 'JUBILACIÓN'),
(2, 'RENUNCIA'),
(3, 'DESTITUCIÓN'),
(4, 'PENSIONADO'),
(5, 'DEFUNCIÓN'),
(6, 'TERMINACIÓN DE CONTRATO'),
(7, 'ABANDONO DEL CARGO'),
(8, 'AUSENCIA INJUSTIFICADA'),
(9, 'EVALUACIÓN INSATISFACTORIA'),
(10, 'FALTA DE HONRADEZ'),
(11, 'NEGLIGENCIA'),
(12, 'OTRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_nacionalidades`
--

CREATE TABLE `cat_nacionalidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_nacionalidades`
--

INSERT INTO `cat_nacionalidades` (`id`, `nombre`) VALUES
(2, 'Colombiana'),
(4, 'Costarricense'),
(7, 'Española'),
(6, 'Estadounidense'),
(5, 'Mexicana'),
(8, 'Otra'),
(1, 'Panameña'),
(3, 'Venezolana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_ocupaciones`
--

CREATE TABLE `cat_ocupaciones` (
  `C_OCUP` int(11) NOT NULL,
  `OCUPACION` varchar(120) NOT NULL,
  `Activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_ocupaciones`
--

INSERT INTO `cat_ocupaciones` (`C_OCUP`, `OCUPACION`, `Activo`) VALUES
(1, 'ABOGADO I', 1),
(2, 'ADMINISTRADOR', 1),
(3, 'AGENTE DE SEGURIDAD', 1),
(4, 'ALBAÑIL', 1),
(5, 'ALMACENISTA', 1),
(6, 'ANALISTA ADMINISTRATIVO', 1),
(7, 'ANALISTA DE SISTEMA', 1),
(8, 'ASISTENTE ADMINISTRATIVO', 1),
(9, 'AUXILIAR DE CONTABILIDAD', 1),
(10, 'CONTADOR', 1),
(11, 'COORDINADOR DE RECURSOS HUMANOS', 1),
(12, 'DISEÑADOR GRÁFICO', 1),
(13, 'INGENIERO CIVIL', 1),
(14, 'INGENIERO INDUSTRIAL', 1),
(15, 'INGENIERO DE SISTEMAS', 1),
(16, 'OFICINISTA', 1),
(17, 'PROGRAMADOR DE COMPUTADORA', 1),
(18, 'SECRETARIA', 1),
(19, 'SUPERVISOR', 1),
(20, 'TÉCNICO EN SOPORTE', 1),
(21, 'TRABAJADOR MANUAL', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_rutas`
--

CREATE TABLE `cat_rutas` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_rutas`
--

INSERT INTO `cat_rutas` (`id`, `Nombre`) VALUES
(4, 'Panamá Centro'),
(1, 'Panamá Este'),
(3, 'Panamá Norte'),
(2, 'Panamá Oeste');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_sexo`
--

CREATE TABLE `cat_sexo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_sexo`
--

INSERT INTO `cat_sexo` (`id`, `nombre`) VALUES
(1, 'Hombre'),
(2, 'Mujer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tipoempleado`
--

CREATE TABLE `cat_tipoempleado` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(80) NOT NULL,
  `Activo` int(11) NOT NULL DEFAULT 1,
  `Abreviatura` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_tipoempleado`
--

INSERT INTO `cat_tipoempleado` (`id`, `Nombre`, `Activo`, `Abreviatura`) VALUES
(1, 'Administrativo', 1, 'A'),
(2, 'Operativo', 1, 'O'),
(3, 'Técnico', 1, 'T'),
(4, 'Profesional', 1, 'P');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tiposangre`
--

CREATE TABLE `cat_tiposangre` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_tiposangre`
--

INSERT INTO `cat_tiposangre` (`id`, `Nombre`) VALUES
(4, 'A+'),
(3, 'A-'),
(8, 'AB+'),
(7, 'AB-'),
(6, 'B+'),
(5, 'B-'),
(1, 'O+'),
(2, 'O-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tipos_planilla`
--

CREATE TABLE `cat_tipos_planilla` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_tipos_planilla`
--

INSERT INTO `cat_tipos_planilla` (`id`, `nombre`, `activo`) VALUES
(1, 'Eventual', 1),
(2, 'Permanente', 1),
(3, 'Interino', 1),
(4, 'Por Contrato', 1),
(5, 'Servicios Profesionales', 1),
(6, 'Tiempo Probatorio', 1),
(7, 'Práctica Profesional', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datospersonales`
--

CREATE TABLE `datospersonales` (
  `id` int(11) NOT NULL,
  `identidad` varchar(30) NOT NULL,
  `Nombre` varchar(80) NOT NULL,
  `Apellido` varchar(80) NOT NULL,
  `Edad` int(11) NOT NULL,
  `tipo_sangre_id` int(11) NOT NULL,
  `sexo_id` int(11) NOT NULL,
  `nacionalidad_id` int(11) NOT NULL,
  `ruta_id` int(11) NOT NULL,
  `Email1` varchar(120) NOT NULL,
  `Celular` varchar(20) NOT NULL,
  `Empleado_Activo` tinyint(1) NOT NULL DEFAULT 1,
  `motivo_terminacion_id` int(11) DEFAULT NULL,
  `Motivo_Baja` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datospersonales`
--

INSERT INTO `datospersonales` (`id`, `identidad`, `Nombre`, `Apellido`, `Edad`, `tipo_sangre_id`, `sexo_id`, `nacionalidad_id`, `ruta_id`, `Email1`, `Celular`, `Empleado_Activo`, `motivo_terminacion_id`, `Motivo_Baja`, `fecha_registro`) VALUES
(1, '8-7729-7729', 'Carlos', 'Mendoza', 30, 1, 1, 1, 1, 'carlos7729@correo.com', '6000-7729', 1, NULL, NULL, '2026-07-01 15:50:29'),
(2, '8-1011-657', 'Pedro', 'Martínez', 25, 2, 1, 6, 3, 'pedri_m@correoejemplo.com', '6889-0087', 1, NULL, NULL, '2026-07-01 16:07:10'),
(3, '8-2131-5643', 'Cuiske', 'Balde', 19, 7, 1, 8, 4, 'arrobacuike@mail.com', '2313-4211', 1, NULL, NULL, '2026-07-01 16:15:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles_laborales`
--

CREATE TABLE `perfiles_laborales` (
  `id` int(11) NOT NULL,
  `colaborador_id` int(11) NOT NULL,
  `ocupacion_id` int(11) NOT NULL,
  `tipo_empleado_id` int(11) NOT NULL,
  `planilla_id` int(11) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `cargo_activo` tinyint(1) NOT NULL DEFAULT 1,
  `firma_integridad` text NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfiles_laborales`
--

INSERT INTO `perfiles_laborales` (`id`, `colaborador_id`, `ocupacion_id`, `tipo_empleado_id`, `planilla_id`, `salario`, `fecha_inicio`, `fecha_fin`, `cargo_activo`, `firma_integridad`, `fecha_registro`) VALUES
(1, 1, 15, 4, 2, 1200.50, '2026-07-01', '2026-07-01', 0, '02cc7d808a2cf5c8304ed93e91196ba834274924835b21718ef3274592ae1ec9', '2026-07-01 15:52:18'),
(2, 2, 15, 4, 2, 1200.50, '2026-07-01', NULL, 1, 'cd77be37f39f634dfb81d10b9ed7d16eb7a807c617b9ae9b39a4b000bb74e7e7', '2026-07-01 16:10:07'),
(3, 1, 10, 1, 1, 430.25, '2026-07-01', NULL, 1, '91058f048f58108c5499f40579b00f6bdf5aaeb28d5742e8866c5a3d7c37ad5e', '2026-07-01 16:12:31'),
(4, 3, 17, 3, 2, 1750.00, '2026-06-30', NULL, 1, 'f4a166742c0aeac34a0656f5ac20d4cc1616afe966d8ab0dc751378717f9f10e', '2026-07-01 16:16:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cat_motivos_terminacion`
--
ALTER TABLE `cat_motivos_terminacion`
  ADD PRIMARY KEY (`C_TERMINACION`);

--
-- Indices de la tabla `cat_nacionalidades`
--
ALTER TABLE `cat_nacionalidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cat_ocupaciones`
--
ALTER TABLE `cat_ocupaciones`
  ADD PRIMARY KEY (`C_OCUP`);

--
-- Indices de la tabla `cat_rutas`
--
ALTER TABLE `cat_rutas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `cat_sexo`
--
ALTER TABLE `cat_sexo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cat_tipoempleado`
--
ALTER TABLE `cat_tipoempleado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `cat_tiposangre`
--
ALTER TABLE `cat_tiposangre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `cat_tipos_planilla`
--
ALTER TABLE `cat_tipos_planilla`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `datospersonales`
--
ALTER TABLE `datospersonales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identidad` (`identidad`),
  ADD UNIQUE KEY `Email1` (`Email1`),
  ADD UNIQUE KEY `uq_celular` (`Celular`),
  ADD KEY `fk_datos_tiposangre` (`tipo_sangre_id`),
  ADD KEY `fk_datos_sexo` (`sexo_id`),
  ADD KEY `fk_datos_nacionalidad` (`nacionalidad_id`),
  ADD KEY `fk_datos_ruta` (`ruta_id`),
  ADD KEY `fk_datos_motivo` (`motivo_terminacion_id`);

--
-- Indices de la tabla `perfiles_laborales`
--
ALTER TABLE `perfiles_laborales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_perfil_colaborador` (`colaborador_id`),
  ADD KEY `fk_perfil_ocupacion` (`ocupacion_id`),
  ADD KEY `fk_perfil_tipoempleado` (`tipo_empleado_id`),
  ADD KEY `fk_perfil_planilla` (`planilla_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cat_motivos_terminacion`
--
ALTER TABLE `cat_motivos_terminacion`
  MODIFY `C_TERMINACION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `cat_nacionalidades`
--
ALTER TABLE `cat_nacionalidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cat_ocupaciones`
--
ALTER TABLE `cat_ocupaciones`
  MODIFY `C_OCUP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `cat_rutas`
--
ALTER TABLE `cat_rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cat_sexo`
--
ALTER TABLE `cat_sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_tipoempleado`
--
ALTER TABLE `cat_tipoempleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cat_tiposangre`
--
ALTER TABLE `cat_tiposangre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cat_tipos_planilla`
--
ALTER TABLE `cat_tipos_planilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `datospersonales`
--
ALTER TABLE `datospersonales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `perfiles_laborales`
--
ALTER TABLE `perfiles_laborales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datospersonales`
--
ALTER TABLE `datospersonales`
  ADD CONSTRAINT `fk_datos_motivo` FOREIGN KEY (`motivo_terminacion_id`) REFERENCES `cat_motivos_terminacion` (`C_TERMINACION`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_datos_nacionalidad` FOREIGN KEY (`nacionalidad_id`) REFERENCES `cat_nacionalidades` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_datos_ruta` FOREIGN KEY (`ruta_id`) REFERENCES `cat_rutas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_datos_sexo` FOREIGN KEY (`sexo_id`) REFERENCES `cat_sexo` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_datos_tiposangre` FOREIGN KEY (`tipo_sangre_id`) REFERENCES `cat_tiposangre` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `perfiles_laborales`
--
ALTER TABLE `perfiles_laborales`
  ADD CONSTRAINT `fk_perfil_colaborador` FOREIGN KEY (`colaborador_id`) REFERENCES `datospersonales` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_perfil_ocupacion` FOREIGN KEY (`ocupacion_id`) REFERENCES `cat_ocupaciones` (`C_OCUP`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_perfil_planilla` FOREIGN KEY (`planilla_id`) REFERENCES `cat_tipos_planilla` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_perfil_tipoempleado` FOREIGN KEY (`tipo_empleado_id`) REFERENCES `cat_tipoempleado` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
