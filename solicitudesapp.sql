-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-05-2019 a las 19:55:04
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
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costes`
--

CREATE TABLE `costes` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unidad` float NOT NULL,
  `precio_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `costes`
--

INSERT INTO `costes` (`id`, `solicitud_id`, `concepto`, `cantidad`, `precio_unidad`, `precio_total`) VALUES
(6, 53, 'wrwer', 4, 5, 1),
(7, 53, 'rrrrrrrrrrrrrr', 44, 4, 5),
(8, 53, 'aaaaaaa', 333, 3, 4),
(9, 53, 'aaaaaaa', 333, 3, 4),
(10, 53, 'aaaaaaa', 333, 3, 4),
(11, 53, 'aaaaaaa', 333, 3, 4),
(12, 53, 'werwer', 43, 44, 4),
(13, 53, 'qweqw', 1, 2, 3),
(15, 53, '141', 0, 0, 0),
(16, 53, '13313', 0, 0, 0),
(17, 53, 'ewer', 3, 4, 12),
(18, 53, 'sdafsdf', 32, 3, 96),
(19, 53, 'asd', 3, 22.3, 66.9),
(20, 53, 'erwe', 3, 22, 66),
(21, 53, 'adsa', 22, 3, 66),
(22, 53, '1111', 22, 3, 66),
(23, 53, 'Una cosa', 2, 11, 22),
(24, 41, 'dasdas', 2, 3.67, 7.34),
(25, 41, 'sgsdg', 44, 12, 528);

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
(3, 'Aprobado'),
(4, 'Rechazada');

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
(2, 'Director Territorial', 2),
(3, 'Director de Programa', 3),
(4, 'Grupo de Trabajo', 4),
(5, 'Usuario', 5);

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
(1, 'Administradores', 'Luis Orta', 'informaticacanarias@aldeasinfantiles.es'),
(2, 'Dirección Territorial', 'Javier Apellido Apellido', 'emailjavier@loquesea.com'),
(4, 'Future Makers', 'Carlos González', 'cgonzalez@aldeasinfantiles.com'),
(5, 'Taller de Madera', 'Alberto', 'Albert@santiago.com'),
(10, 'CIIF La Laguna', 'ghjgh', 'hgjh@haijad'),
(11, 'CIIF El Tablero', 'Javier', 'emailjavier@loquesea.com'),
(12, 'Escuela Infantil', 'No sé', 'correo@correo.com'),
(13, 'CIIF Los Realejos', 'No se', 'correo@correo.com');

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
(3, 'Pendiente de Revisión'),
(4, 'FInalizado/Entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `progreso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `seguimiento`
--

INSERT INTO `seguimiento` (`id`, `solicitud_id`, `progreso_id`) VALUES
(1, 52, 4),
(2, 53, 2),
(3, 54, 1),
(4, 55, 1),
(5, 56, 1),
(6, 57, 1),
(7, 58, 1),
(8, 59, 1),
(9, 60, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `grupo_trabajo_id` int(11) NOT NULL,
  `boceto_url` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_solicitud` date DEFAULT NULL,
  `fecha_verificacion` date DEFAULT NULL,
  `fecha_aprobacion` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `descripcion` text NOT NULL,
  `necesidad` text NOT NULL,
  `estado_id` int(11) NOT NULL,
  `eliminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `usuario_id`, `grupo_trabajo_id`, `boceto_url`, `categoria_id`, `tipo_id`, `cantidad`, `fecha_solicitud`, `fecha_verificacion`, `fecha_aprobacion`, `fecha_fin`, `fecha_limite`, `descripcion`, `necesidad`, `estado_id`, `eliminado`) VALUES
(1, 1, 1, 'boceto.jpg', 5, 5, 0, '2019-03-06', '2019-03-09', NULL, NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Massa dictumst vestibulum aliquam scelerisque accumsan montes cum fames eu, quisque eleifend convallis semper non eget metus ullamcorper maecenas, aenean et pharetra parturient morbi lacinia viverra aliquet. Commodo mauris nec justo posuere montes habitasse penatibus litora quisque nullam, interdum sapien eleifend vivamus nisi conubia orci mus venenatis, netus porttitor proin ligula tortor dictumst tincidunt rutrum convallis. Habitant pellentesque tincidunt pulvinar erat felis viverra vehicula, lobortis volutpat consequat malesuada blandit iaculis justo, tristique massa sociosqu dictum dictumst et.', 1, NULL),
(2, 2, 4, NULL, 1, 19, 0, '2019-03-06', NULL, NULL, NULL, NULL, 'yurtuyrtuyrtuyrtyurtyurtu', 'rtuyryurtyurturu', 1, NULL),
(3, 1, 1, NULL, 1, 1, 0, '2019-11-06', NULL, NULL, NULL, NULL, 'oiahaid', 'oahadoahda', 1, NULL),
(6, 1, 4, 'Captura de pantalla de 2019-03-11 17-53-34.png', 2, 12, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'sdfgsdfgs', 'ertes', 1, NULL),
(27, 1, 4, '', 5, 3, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'wert', 'wert', 3, NULL),
(28, 1, 4, '', 5, 3, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'asd', 'asd', 1, NULL),
(29, 1, 4, '', 5, 3, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'sadfasdf', 'asdfafsd', 1, NULL),
(30, 1, 4, '', 5, 3, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'sdsdsf', 'fdfdsf', 1, NULL),
(31, 1, 4, 'Captura de pantalla de 2019-02-19 12-11-59.png', 5, 3, 0, '2019-03-12', NULL, NULL, NULL, NULL, ' erty ', 'ertyrrrrrrrrrr', 3, NULL),
(33, 1, 4, '1', 5, 3, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'sgasgasg', 'agaga', 1, NULL),
(34, 1, 4, '1', 5, 3, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'sgasgasg', 'agaga', 1, NULL),
(35, 1, 4, '1', 2, 10, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'asdad', 'adad', 3, NULL),
(36, 1, 4, '1', 3, 14, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'asdf', 'asdfas', 1, 0),
(37, 1, 4, '1', 3, 14, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'asdfadf', 'asdfasdf', 3, NULL),
(38, 1, 4, '1', 5, 6, 0, '2019-03-12', NULL, NULL, NULL, NULL, 'ffffff', 'asdf', 1, 1),
(41, 1, 7, 'Captura de pantalla de 2019-02-19 16-56-49.png', 5, 6, 0, '2019-03-12', NULL, NULL, NULL, NULL, ' gdfg ', 'frgdf', 3, 1),
(45, 2, 4, '1552562585-Captura de pantalla de 2019-02-19 16-50-38.png', 4, 1, 0, '2019-03-14', NULL, NULL, NULL, NULL, 'sssssssssssss', 'aaaaaaaaaaaaaaaaaaaa', 2, NULL),
(46, 2, 4, '', 4, 2, 0, '2019-03-14', NULL, NULL, NULL, NULL, 'dfgsdfgsdgs', 'sdfgsdfgs', 1, NULL),
(47, 2, 4, '', 4, 2, 0, '2019-03-14', NULL, NULL, NULL, NULL, 'dfgsdfgsdgs', 'sdfgsdfgs', 1, NULL),
(48, 2, 4, '', 1, 22, 0, '2019-03-14', NULL, NULL, NULL, NULL, 'awdad', 'awdawd', 1, NULL),
(49, 2, 4, '', 1, 22, 0, '2019-03-14', NULL, NULL, NULL, NULL, 'awdad', 'awdawd', 1, NULL),
(50, 2, 4, '', 1, 22, 0, '2019-03-14', NULL, NULL, NULL, NULL, 'awdad', 'awdawd', 1, NULL),
(51, 2, 4, '', 1, 22, 0, '2019-03-14', NULL, NULL, NULL, NULL, 'awdad', 'awdawd', 1, NULL),
(52, 2, 4, '', 1, 22, 0, '2019-03-14', NULL, NULL, NULL, NULL, 'awdad', 'awdawd', 3, NULL),
(53, 2, 4, '', 2, 10, 0, '2019-03-14', '2019-03-19', '2019-03-19', NULL, NULL, 'O lo que quieras me da iguaaaaaaal', 'Hazme una mesa de nieveeeeeee', 3, NULL),
(54, 1, 4, '', 4, 1, 0, '2019-03-19', '2019-03-19', '2019-03-19', NULL, NULL, 'asd', 'asd', 3, 0),
(55, 1, 4, '', 5, 3, 0, '2019-03-20', '2019-04-02', NULL, NULL, NULL, 'dadad', 'adawda', 2, 1),
(56, 1, 4, '1553516655-Registro Semanal 7-11 Enero.pdf', 1, 18, 0, '2019-03-25', '2019-03-25', '2019-05-02', NULL, NULL, 'ssssssssssssssssssssssssssssss', 'fgdssssssssssssssssssssssssssssssss', 3, 0),
(57, 1, 4, '', 5, 6, 0, '2019-04-02', '2019-04-02', '2019-05-02', NULL, '0000-00-00', 'sdfsdfsdf', 'asfsfs', 3, 0),
(58, 1, 4, '', 2, 13, 0, '2019-04-08', '2019-04-08', '2019-04-08', NULL, NULL, 'taquillero', 'efafasfa', 1, 0),
(59, 1, 7, '', 2, 12, 0, '2019-05-02', '2019-05-02', '2019-05-02', NULL, NULL, 'asd', 'asd', 4, 0),
(60, 1, 7, '', 2, 12, 7, '2019-05-02', NULL, NULL, NULL, NULL, ' CCCCCCCCCCCCCCCaa ', 'CCCCCCCCCCCCCCCCCCCCCC', 1, 0);

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
(1, 1, 1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2019-05-02 17:20:10'),
(2, 2, 2, 'javier', '828c1a17681e8566a17a1a4801ea67306010b273', '2019-04-08 18:53:01'),
(3, 4, 3, 'cgonzalez', '50e245dbacaf3a9f557b646b3b8369f7fb2a308d', '2019-04-02 17:38:17'),
(4, 4, 4, 'futuremakers', '8d45a798dc2e5244841542908e968a72498d9c83', '2019-05-02 17:18:15'),
(5, 4, 5, 'lorta', '599a581285e9a5b77e36cc531fa9870360974562', '2019-03-07 11:24:43'),
(7, 5, 4, 'tallermadera', 'f8c9d73af3c9b0757252e881bb31edcb3366944b', '2019-05-02 17:19:52'),
(9, 4, 5, 'prueba', '1234', NULL),
(11, 10, 5, 'probando', '69607ed6f195faf4cacbbde58f1721f317342187', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_C_Usuario` (`usuario_id`),
  ADD KEY `FK_C_Solicitud` (`solicitud_id`);

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
  ADD KEY `FK_Progreso` (`progreso_id`),
  ADD KEY `FK_Solicitud` (`solicitud_id`);

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
  ADD UNIQUE KEY `user` (`user`),
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
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `costes`
--
ALTER TABLE `costes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `progreso`
--
ALTER TABLE `progreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `FK_C_Solicitud` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_C_Usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD CONSTRAINT `FK_Progreso` FOREIGN KEY (`progreso_id`) REFERENCES `progreso` (`id`),
  ADD CONSTRAINT `FK_Solicitud` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE;

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
