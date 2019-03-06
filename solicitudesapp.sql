-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-03-2019 a las 19:23:12
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `solicitudesapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Impresión 3D'),
(2, 'Fabricación Madera'),
(3, 'Electrónica'),
(4, 'Informática'),
(5, 'Diseño Gráfico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costes`
--

CREATE TABLE `costes` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `material` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unidad` float NOT NULL,
  `precio_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `nombre`) VALUES
(1, 'Sin validar'),
(2, 'Validado'),
(3, 'Aprobado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nivel` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`, `nivel`) VALUES
(1, 'Administrador', 1),
(2, 'Director', 2),
(3, 'Grupo de Trabajo', 3),
(4, 'Usuario', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `director` varchar(100) NOT NULL,
  `email_director` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id`, `nombre`, `director`, `email_director`) VALUES
(1, 'Administradores', 'Luis Orta', 'admin@admin.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso`
--

CREATE TABLE `progreso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `progreso`
--

INSERT INTO `progreso` (`id`, `nombre`) VALUES
(1, 'Aprobado'),
(2, 'En Proceso'),
(3, 'Finalizado'),
(4, 'Entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `progreso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `grupo_trabajo_id` int(11) NOT NULL,
  `boceto_url` varchar(255) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `fecha_solicitud` date DEFAULT NULL,
  `fecha_verificacion` date DEFAULT NULL,
  `fecha_aprobacion` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `descripcion` text NOT NULL,
  `necesidad` text NOT NULL,
  `estado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `usuario_id`, `grupo_trabajo_id`, `boceto_url`, `categoria_id`, `tipo_id`, `fecha_solicitud`, `fecha_verificacion`, `fecha_aprobacion`, `fecha_fin`, `fecha_limite`, `descripcion`, `necesidad`, `estado_id`) VALUES
(1, 1, 1, 'boceto.jpg', 5, 5, '2019-03-06', '2019-03-09', NULL, NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Massa dictumst vestibulum aliquam scelerisque accumsan montes cum fames eu, quisque eleifend convallis semper non eget metus ullamcorper maecenas, aenean et pharetra parturient morbi lacinia viverra aliquet. Commodo mauris nec justo posuere montes habitasse penatibus litora quisque nullam, interdum sapien eleifend vivamus nisi conubia orci mus venenatis, netus porttitor proin ligula tortor dictumst tincidunt rutrum convallis. Habitant pellentesque tincidunt pulvinar erat felis viverra vehicula, lobortis volutpat consequat malesuada blandit iaculis justo, tristique massa sociosqu dictum dictumst et.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `categoria_id`, `nombre`) VALUES
(1, 4, 'Programa o Aplicación'),
(2, 4, 'Mantenimiento'),
(3, 5, 'Poster'),
(4, 5, 'Infografía'),
(5, 5, 'Diptico/Triptico'),
(6, 5, 'Dibujo'),
(7, 5, 'Logo'),
(8, 5, 'Mural'),
(9, 5, 'Otro'),
(10, 2, 'Mesa'),
(11, 2, 'Silla'),
(12, 2, 'Estantería o repisa'),
(13, 2, 'Otros'),
(14, 3, 'Circuito'),
(15, 3, 'Robótica'),
(16, 3, 'Programación Arduino'),
(17, 3, 'Otros'),
(18, 1, 'Herramientas'),
(19, 1, 'Juguetes'),
(20, 1, 'Moda'),
(21, 1, 'Hogar'),
(22, 1, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `programa_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `programa_id`, `grupo_id`, `user`, `password`, `last_login`) VALUES
(1, 1, 1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `costes`
--
ALTER TABLE `costes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Solicitud` (`solicitud_id`),
  ADD KEY `FK_Progreso` (`progreso_id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Categoria` (`categoria_id`),
  ADD KEY `FK_Tipo` (`tipo_id`),
  ADD KEY `FK_Estado` (`estado_id`),
  ADD KEY `FK_Usuario` (`usuario_id`),
  ADD KEY `FK_Grupo_Trabajo` (`grupo_trabajo_id`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Tipo_Categorias` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Programas` (`programa_id`),
  ADD KEY `FK_Grupos` (`grupo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `costes`
--
ALTER TABLE `costes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `progreso`
--
ALTER TABLE `progreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD CONSTRAINT `FK_Progreso` FOREIGN KEY (`progreso_id`) REFERENCES `progreso` (`id`),
  ADD CONSTRAINT `FK_Solicitud` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `FK_Categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `FK_Estado` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`),
  ADD CONSTRAINT `FK_Grupo_Trabajo` FOREIGN KEY (`grupo_trabajo_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `FK_Tipo` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`),
  ADD CONSTRAINT `FK_Usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD CONSTRAINT `FK_Tipo_Categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_Grupos` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `FK_Programas` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
