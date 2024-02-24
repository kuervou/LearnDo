-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2023 a las 18:16:55
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `learndo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `nombre` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`nombre`) VALUES
('Ciencias economicas'),
('Crecimiento Personal'),
('Diseño'),
('Fotografia y Video'),
('Marketing'),
('Musica'),
('Programacion'),
('Salud');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `precio` int(11) NOT NULL,
  `creditos_otorga` int(11) NOT NULL,
  `instructores` text NOT NULL,
  `nick_organizador` varchar(32) NOT NULL,
  `ruta_multimedia` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id_curso`, `descripcion`, `nombre`, `precio`, `creditos_otorga`, `instructores`, `nick_organizador`, `ruta_multimedia`) VALUES
(2, 'Se el mejor fotógrafo de tu región', 'Fotografía', 10, 1, 'Hernan, ', 'Organizador2', ''),
(3, 'Convierte en un desarrollador experto en python.', 'Python Master', 15, 2, 'Nicolas, Eduardo, ', 'Organizador1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_categoria`
--

CREATE TABLE `curso_categoria` (
  `id_curso` int(11) NOT NULL,
  `nombre_cat` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `curso_categoria`
--

INSERT INTO `curso_categoria` (`id_curso`, `nombre_cat`) VALUES
(2, 'Fotografia y Video'),
(3, 'Programacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discusion`
--

CREATE TABLE `discusion` (
  `id_discusion` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `descripcion` text NOT NULL,
  `ruta_multimedia` varchar(128) NOT NULL,
  `nick_organizador` varchar(32) DEFAULT NULL,
  `nick_estudiante` varchar(32) DEFAULT NULL,
  `id_foro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `discusion`
--

INSERT INTO `discusion` (`id_discusion`, `nombre`, `descripcion`, `ruta_multimedia`, `nick_organizador`, `nick_estudiante`, `id_foro`) VALUES
(1, '¡Bienvenidos al Curso de Fotografía - Módulo de Introducción ya ', 'Queridos estudiantes,  Es un verdadero placer darles la bienvenida al Curso de Fotografía online. Espero que todos estén listos para embarcarse en este apasionante viaje a través del mundo de la fotografía.  Me complace informarles que el Módulo de Introducción ya ha sido publicado en la plataforma. Este módulo servirá para establecer nuestras bases y comenzar a construir nuestro camino hacia la maestría en fotografía. Les animo a que comiencen a explorarlo tan pronto como puedan.  Recuerden que este es un espacio de aprendizaje colaborativo. Los invito a utilizar los foros de discusión del curso para compartir sus dudas, ideas, opiniones y, por supuesto, sus trabajos. Estos foros son una gran oportunidad para aprender no sólo de mí, sino también de sus compañeros.  Además, siempre estaré a su disposición para responder a cualquier consulta que puedan tener. Si tienen alguna pregunta, por favor, no duden en ponerse en contacto conmigo a través del chat del curso o los foros de discusión. Mi objetivo es asegurarme de que tengan una experiencia de aprendizaje efectiva, gratificante y agradable.  Estoy emocionado por el viaje que nos espera y no puedo esperar para ver cómo se desarrollan sus habilidades fotográficas.  ¡Vamos a capturar algunos momentos impresionantes juntos!  Saludos cordiales', '1687185687_dc0357a9a7dcad313168.jpg', NULL, NULL, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `nick` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `telefono` varchar(16) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `ruta_multimedia` varchar(128) NOT NULL,
  `biografia` text NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `creditos` int(11) NOT NULL,
  `token` varchar(128) DEFAULT NULL,
  `id_linkedin` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`nick`, `email`, `password`, `telefono`, `nombre`, `apellido`, `ruta_multimedia`, `biografia`, `activo`, `creditos`, `token`, `id_linkedin`) VALUES
('user', 'guzman.vera@estudiantes.utec.edu.uy', '$2y$10$QlL3VV4MyXUiQZWKGD3X1uwaYi.HxqLIJGW8MeZrgbDTia/VpenSC', '099123123', 'usernombre', 'userapellido', 'public/uploads/contenidoMultimedia/fotosPerfil/user.png', 'Una biografía', 1, 987, '1687188532$2y$10$UdrP.SH/mQCPXGhpQeUnEe1J4oZz8YhWlyQ7Ws3PNZE8nmrR5hrZO', NULL),
('ZeCa', 'ze.bautes@utec.edu.uy', '$2y$10$gigO8EeuPgDWJSgNHoeeXuoHaNyXupC.4SD/aeUSNp.YQ0LEFp2Li', '099321123', 'Ze Carlos', 'Bautes', 'public/uploads/contenidoMultimedia/fotosPerfil/1687190330_b67ff0993ed0be09a33a.png', '', 1, 990, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_colabora`
--

CREATE TABLE `estudiante_colabora` (
  `nick_estudiante` varchar(32) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_leccion`
--

CREATE TABLE `estudiante_leccion` (
  `nick_estudiante` varchar(32) NOT NULL,
  `id_leccion` int(11) NOT NULL,
  `descarga` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

CREATE TABLE `evaluacion` (
  `id_evaluacion` int(11) NOT NULL,
  `nota_aprobacion` int(11) NOT NULL,
  `titulo` varchar(32) NOT NULL,
  `id_modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evaluacion`
--

INSERT INTO `evaluacion` (`id_evaluacion`, `nota_aprobacion`, `titulo`, `id_modulo`) VALUES
(1, 60, 'Evaluacion - Modulo 1', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

CREATE TABLE `foro` (
  `id_foro` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `descripcion` text NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`id_foro`, `nombre`, `descripcion`, `id_curso`) VALUES
(4, 'General', 'Foro general del curso', 2),
(5, 'Consultas', 'Foro para consultas sobre el curso', 2),
(6, 'Avisos', 'Foro para avisos relacionados al curso', 2),
(7, 'General', 'Foro general del curso', 3),
(8, 'Consultas', 'Foro para consultas sobre el curso', 3),
(9, 'Avisos', 'Foro para avisos relacionados al curso', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `leccion`
--

CREATE TABLE `leccion` (
  `id_leccion` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `duracion` float NOT NULL,
  `ruta_multimedia` varchar(128) NOT NULL,
  `id_modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `leccion`
--

INSERT INTO `leccion` (`id_leccion`, `nombre`, `duracion`, `ruta_multimedia`, `id_modulo`) VALUES
(1, 'Conociendo tu cámara', 45, '1687185317_780c4521b36a17ee8707.pdf', 2),
(2, 'Las luces y colores en tus fotos', 30, '1687185507_ad26d6df8b26b1f337c8.pdf', 2),
(5, 'Equipos y funcionamiento', 30, '1687186106_24666cf0dfe607a9377d.pdf', 3),
(6, 'Combinando fuentes de luz', 30, '1687186249_9df845e3f81560c788ae.pdf', 3),
(7, '¿Qué es python?', 30, '1687188759_b345a6c08524e907c2f8.pdf', 4),
(8, 'Python y las IA', 40, '1687189006_447bd5bcc1555a6f39ca.pdf', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id_mensaje` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_discusion` int(11) DEFAULT NULL,
  `id_seminario` int(11) DEFAULT NULL,
  `nick_emisor_estudiante` varchar(32) DEFAULT NULL,
  `nick_emisor_organizador` varchar(32) DEFAULT NULL,
  `nick_destinatario_estudiante` varchar(32) DEFAULT NULL,
  `nick_destinatario_organizador` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id_modulo` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id_modulo`, `nombre`, `id_curso`) VALUES
(2, 'Introducción', 2),
(3, 'Fotografía en Estudio', 2),
(4, 'Conociendo el Lenguaje', 3),
(5, 'Librerias en Python', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE `opcion` (
  `id_opcion` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`id_opcion`, `contenido`, `id_pregunta`) VALUES
(1, 'a) Controlar la velocidad del obturador', 1),
(2, 'b) Controlar la cantidad de luz que entra al sensor', 1),
(3, 'c) Ajustar el balance de blancos', 1),
(4, 'd) Ajustar el zoom del lente', 1),
(5, 'a) Imágenes borrosas', 2),
(6, 'b) Mayor profundidad de campo', 2),
(7, 'c) Menor profundidad de campo', 2),
(8, 'd) Congela el movimiento en las imágenes', 2),
(9, 'a) La intensidad del flash en la cámara', 3),
(10, 'b) La sensibilidad del sensor de la cámara a la luz', 3),
(11, 'c) La capacidad de la cámara de capturar imágenes en color', 3),
(12, 'd) El tamaño del sensor de la cámara', 3),
(13, 'a) La distancia entre la cámara y el sujeto', 4),
(14, 'b) El grosor del lente de la cámara', 4),
(15, 'c) El rango de distancia en la imagen que aparece nítido', 4),
(16, 'd) La cantidad de luz que el lente de la cámara puede capturar', 4),
(17, 'a) La medida de cuán blanco es un objeto en la imagen', 5),
(18, 'b) Un ajuste que controla la temperatura del color en una imagen', 5),
(19, 'c) Un ajuste que controla el brillo de una imagen', 5),
(20, 'd) La relación entre los colores primarios en una imagen', 5),
(21, 'a) La foto se vuelve más cálida', 6),
(22, 'b) La foto se vuelve más fría', 6),
(23, 'c) La foto se vuelve más brillante', 6),
(24, 'd) La foto se vuelve más oscura', 6),
(25, 'a) Luminosidad', 7),
(26, 'b) Intensidad', 7),
(27, 'c) Temperatura de color', 7),
(28, 'd) Contraste', 7),
(29, 'a) Dos colores que están uno al lado del otro en el círculo cromático', 8),
(30, 'b) Dos colores que se mezclan para formar blanco', 8),
(31, 'c) Dos colores que están opuestos en el círculo cromático', 8),
(32, 'd) Dos colores que se mezclan para formar negro', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizador`
--

CREATE TABLE `organizador` (
  `nick` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `telefono` varchar(16) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `ruta_multimedia` varchar(128) NOT NULL COMMENT 'Imagen, que sea lo que dios quiera',
  `biografia` text NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `token` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `organizador`
--

INSERT INTO `organizador` (`nick`, `email`, `password`, `telefono`, `nombre`, `apellido`, `ruta_multimedia`, `biografia`, `activo`, `token`) VALUES
('Organizador1', 'mario.caro@estudiantes.utec.edu.uy', '$2y$10$pZ/CU5nSaIrlwj/JVE1l0uXedYLNPEj71WC6yWW7voKJIinpuoJse', '092233522', 'Mario', 'Caro', 'public/assets/images/user.png', '', 1, NULL),
('Organizador2', 'hernan.cabara@estudiantes.utec.edu.uy', '$2y$10$yGCBtVDUFBZrRZkna5i8nOhYDjKcw5Pj0A5j5mxOC1v3tHvNDsgaq', '099123123', 'Hernan', 'Cabara', 'public/assets/images/user.png', '', 1, NULL),
('superAdmin', 'superAdmin@gmail.com', '$2y$10$QlL3VV4MyXUiQZWKGD3X1uwaYi.HxqLIJGW8MeZrgbDTia/VpenSC', '099123123', 'super', 'admin', 'public/uploads/contenidoMultimedia/fotosPerfil/user.png', 'La biografia del superAdmin', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregunta` int(11) NOT NULL,
  `nota_maxima` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `correcta` varchar(128) NOT NULL,
  `id_evaluacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id_pregunta`, `nota_maxima`, `contenido`, `correcta`, `id_evaluacion`) VALUES
(1, 5, '¿Cuál es el propósito de la apertura en una cámara réflex?', 'b) Controlar la cantidad de luz que entra al sensor', 1),
(2, 10, '¿Qué efecto produce una velocidad de obturación alta?', 'd) Congela el movimiento en las imágenes', 1),
(3, 10, 'En fotografía, el término ISO se refiere a:', 'b) La sensibilidad del sensor de la cámara a la luz', 1),
(4, 15, 'En una cámara réflex, ¿qué significa el término \"profundidad de campo\"?', 'c) El rango de distancia en la imagen que aparece nítido', 1),
(5, 5, '¿Qué es el balance de blancos en la fotografía?', 'b) Un ajuste que controla la temperatura del color en una imagen', 1),
(6, 10, '¿Qué sucede si ajustas la temperatura de color hacia el lado azul en la cámara?', 'b) La foto se vuelve más fría', 1),
(7, 5, '¿Cómo se llama la propiedad de la luz que se mide en Kelvin en fotografía?', 'c) Temperatura de color', 1),
(8, 15, 'En la teoría del color, ¿qué se entiende por colores complementarios?', 'c) Dos colores que están opuestos en el círculo cromático', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id_prueba` int(11) NOT NULL,
  `nota_obtenida` int(11) NOT NULL,
  `nick_estudiante` varchar(128) NOT NULL,
  `id_evaluacion` int(11) NOT NULL,
  `aprobado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id_prueba`, `nota_obtenida`, `nick_estudiante`, `id_evaluacion`, `aprobado`) VALUES
(1, 70, 'ZeCa', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `id_publicacion` int(11) NOT NULL,
  `nick_estudiante` varchar(128) DEFAULT NULL,
  `contenido` varchar(256) NOT NULL,
  `ruta_multimedia` varchar(128) DEFAULT NULL,
  `nick_organizador` varchar(128) DEFAULT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`id_publicacion`, `nick_estudiante`, `contenido`, `ruta_multimedia`, `nick_organizador`, `fecha_hora`) VALUES
(2, 'ZeCa', 'Me he inscripto al curso:Fotografía', 'compartir.svg', NULL, '2023-06-19 15:59:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendacion`
--

CREATE TABLE `recomendacion` (
  `id_recomendacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id_respuesta` int(11) NOT NULL,
  `nota_obtenida` int(11) NOT NULL,
  `contenido` char(1) NOT NULL,
  `id_prueba` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id_respuesta`, `nota_obtenida`, `contenido`, `id_prueba`, `id_pregunta`) VALUES
(1, 0, 'c', 1, 1),
(2, 10, 'd', 1, 2),
(3, 10, 'b', 1, 3),
(4, 15, 'c', 1, 4),
(5, 5, 'b', 1, 5),
(6, 10, 'b', 1, 6),
(7, 5, 'c', 1, 7),
(8, 15, 'c', 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seminario_presencial`
--

CREATE TABLE `seminario_presencial` (
  `id_seminario_presencial` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `precio` float NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `ubicacion` varchar(128) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `nick_organizador` varchar(32) NOT NULL,
  `ruta_multimedia` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seminario_presencial`
--

INSERT INTO `seminario_presencial` (`id_seminario_presencial`, `descripcion`, `nombre`, `precio`, `fecha`, `hora`, `ubicacion`, `capacidad`, `nick_organizador`, `ruta_multimedia`) VALUES
(3, 'Aprende a crear tu propia musica.', 'Composición musical', 10, '2023-06-21', '15:00:00', '-34.339894,-56.712208', 50, 'Organizador1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seminario_presencial_categoria`
--

CREATE TABLE `seminario_presencial_categoria` (
  `id_seminario_presencial` int(11) NOT NULL,
  `nombre_cat` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seminario_presencial_categoria`
--

INSERT INTO `seminario_presencial_categoria` (`id_seminario_presencial`, `nombre_cat`) VALUES
(3, 'Musica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seminario_virtual`
--

CREATE TABLE `seminario_virtual` (
  `id_seminario_virtual` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `precio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `plataforma` varchar(32) NOT NULL,
  `nick_organizador` varchar(32) NOT NULL,
  `ruta_multimedia` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seminario_virtual`
--

INSERT INTO `seminario_virtual` (`id_seminario_virtual`, `descripcion`, `nombre`, `precio`, `fecha`, `hora`, `plataforma`, `nick_organizador`, `ruta_multimedia`) VALUES
(3, 'Aprende a crear tu propio negocio.', 'Como emprender?', 15, '2023-06-22', '14:00:00', 'Zoom', 'Organizador2', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seminario_virtual_categoria`
--

CREATE TABLE `seminario_virtual_categoria` (
  `id_seminario_virtual` int(11) NOT NULL,
  `nombre_cat` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seminario_virtual_categoria`
--

INSERT INTO `seminario_virtual_categoria` (`id_seminario_virtual`, `nombre_cat`) VALUES
(3, 'Ciencias economicas'),
(3, 'Crecimiento Personal'),
(3, 'Marketing');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencia`
--

CREATE TABLE `sugerencia` (
  `id_sugerencia` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `ruta_multimedia` varchar(128) NOT NULL,
  `fecha` date NOT NULL,
  `aprobada` tinyint(1) DEFAULT NULL,
  `id_curso` int(11) NOT NULL,
  `nick_estudiante` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Investigar multimedia';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `id_transaccion` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `metodo_pago` varchar(16) NOT NULL,
  `creditos_usados` int(11) NOT NULL,
  `nick_estudiante` varchar(32) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_seminario_presencial` int(11) NOT NULL,
  `id_seminario_virtual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transaccion`
--

INSERT INTO `transaccion` (`id_transaccion`, `precio`, `metodo_pago`, `creditos_usados`, `nick_estudiante`, `id_curso`, `id_seminario_presencial`, `id_seminario_virtual`) VALUES
(6, 10, 'creditos', 10, 'ZeCa', 2, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `id_valoracion` int(11) NOT NULL,
  `nick_estudiante` varchar(128) NOT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `nota` int(11) NOT NULL,
  `opinion` varchar(256) NOT NULL,
  `id_seminario_virtual` int(11) DEFAULT NULL,
  `id_seminario_presencial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoracion`
--

INSERT INTO `valoracion` (`id_valoracion`, `nick_estudiante`, `id_curso`, `nota`, `opinion`, `id_seminario_virtual`, `id_seminario_presencial`) VALUES
(1, 'ZeCa', 2, 5, 'Encantado con el curso!! Recomiendo!', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD KEY `fk_organizador_curso` (`nick_organizador`) USING BTREE;

--
-- Indices de la tabla `curso_categoria`
--
ALTER TABLE `curso_categoria`
  ADD PRIMARY KEY (`nombre_cat`,`id_curso`) USING BTREE,
  ADD KEY `fk_id_curso` (`id_curso`);

--
-- Indices de la tabla `discusion`
--
ALTER TABLE `discusion`
  ADD PRIMARY KEY (`id_discusion`),
  ADD KEY `fk_estudiante_discusion` (`nick_estudiante`),
  ADD KEY `fk_organizador_discusion` (`nick_organizador`),
  ADD KEY `fk_foro_discusion` (`id_foro`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`nick`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `estudiante_colabora`
--
ALTER TABLE `estudiante_colabora`
  ADD KEY `fk_nick_colaborador` (`nick_estudiante`),
  ADD KEY `fk_curso_colaborador` (`id_curso`);

--
-- Indices de la tabla `estudiante_leccion`
--
ALTER TABLE `estudiante_leccion`
  ADD KEY `fk_nick_estudiante` (`nick_estudiante`),
  ADD KEY `fk_leccion` (`id_leccion`);

--
-- Indices de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD PRIMARY KEY (`id_evaluacion`),
  ADD KEY `fk_modulo_evaluacion` (`id_modulo`);

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD PRIMARY KEY (`id_foro`),
  ADD KEY `fk_curso_foro` (`id_curso`);

--
-- Indices de la tabla `leccion`
--
ALTER TABLE `leccion`
  ADD PRIMARY KEY (`id_leccion`),
  ADD KEY `fk_modulo_leccion` (`id_modulo`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `fk_estudiante_emisor` (`nick_emisor_estudiante`),
  ADD KEY `fk_estudiante_destinatario` (`nick_destinatario_estudiante`),
  ADD KEY `fk_organizador_destinatario` (`nick_destinatario_organizador`),
  ADD KEY `fk_organizador_emisor` (`nick_emisor_organizador`),
  ADD KEY `fk_discusion_mensaje` (`id_discusion`),
  ADD KEY `fk_seminario_mensaje` (`id_seminario`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id_modulo`),
  ADD KEY `fk_curso_modulo` (`id_curso`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`id_opcion`),
  ADD KEY `fk_pregunta_opcion` (`id_pregunta`);

--
-- Indices de la tabla `organizador`
--
ALTER TABLE `organizador`
  ADD PRIMARY KEY (`nick`),
  ADD UNIQUE KEY `organizador_email` (`email`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `fk_pregunta_evaluacion` (`id_evaluacion`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id_prueba`),
  ADD KEY `fk_ev_prueba` (`id_evaluacion`),
  ADD KEY `fk_estudiante_prueba` (`nick_estudiante`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `fk_estudiante_publicacion` (`nick_estudiante`);

--
-- Indices de la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  ADD PRIMARY KEY (`id_recomendacion`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `fk_prueba_respuesta` (`id_prueba`),
  ADD KEY `fk_pregunta_respuesta` (`id_pregunta`);

--
-- Indices de la tabla `seminario_presencial`
--
ALTER TABLE `seminario_presencial`
  ADD PRIMARY KEY (`id_seminario_presencial`),
  ADD KEY `fk_organizador_seminario_presencial` (`nick_organizador`);

--
-- Indices de la tabla `seminario_presencial_categoria`
--
ALTER TABLE `seminario_presencial_categoria`
  ADD KEY `fk_seminario_presencial_cat` (`nombre_cat`),
  ADD KEY `fk_seminario_presencial` (`id_seminario_presencial`);

--
-- Indices de la tabla `seminario_virtual`
--
ALTER TABLE `seminario_virtual`
  ADD PRIMARY KEY (`id_seminario_virtual`),
  ADD KEY `fk_organizador_seminario_virtual` (`nick_organizador`);

--
-- Indices de la tabla `seminario_virtual_categoria`
--
ALTER TABLE `seminario_virtual_categoria`
  ADD KEY `fk_seminario_virtual_cat` (`nombre_cat`),
  ADD KEY `fk_seminario_virtual` (`id_seminario_virtual`);

--
-- Indices de la tabla `sugerencia`
--
ALTER TABLE `sugerencia`
  ADD PRIMARY KEY (`id_sugerencia`),
  ADD KEY `fk_estudiante` (`nick_estudiante`),
  ADD KEY `fk_curso` (`id_curso`);

--
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`id_transaccion`),
  ADD KEY `nick_estudiante` (`nick_estudiante`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`id_valoracion`),
  ADD KEY `fk_valorar_curso` (`id_curso`),
  ADD KEY `fk_valorar_seminario_presencial` (`id_seminario_presencial`),
  ADD KEY `fk_valorar_seminario_virtual` (`id_seminario_virtual`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `discusion`
--
ALTER TABLE `discusion`
  MODIFY `id_discusion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  MODIFY `id_evaluacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `foro`
--
ALTER TABLE `foro`
  MODIFY `id_foro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `leccion`
--
ALTER TABLE `leccion`
  MODIFY `id_leccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `id_opcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id_prueba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  MODIFY `id_recomendacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `seminario_presencial`
--
ALTER TABLE `seminario_presencial`
  MODIFY `id_seminario_presencial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `seminario_virtual`
--
ALTER TABLE `seminario_virtual`
  MODIFY `id_seminario_virtual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sugerencia`
--
ALTER TABLE `sugerencia`
  MODIFY `id_sugerencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `id_transaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `id_valoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_organizador` FOREIGN KEY (`nick_organizador`) REFERENCES `organizador` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `curso_categoria`
--
ALTER TABLE `curso_categoria`
  ADD CONSTRAINT `fk_curso_cat` FOREIGN KEY (`nombre_cat`) REFERENCES `categoria` (`nombre`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `discusion`
--
ALTER TABLE `discusion`
  ADD CONSTRAINT `fk_estudiante_discusion` FOREIGN KEY (`nick_estudiante`) REFERENCES `estudiante` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_foro_discusion` FOREIGN KEY (`id_foro`) REFERENCES `foro` (`id_foro`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_organizador_discusion` FOREIGN KEY (`nick_organizador`) REFERENCES `organizador` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante_colabora`
--
ALTER TABLE `estudiante_colabora`
  ADD CONSTRAINT `fk_curso_colaborador` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nick_colaborador` FOREIGN KEY (`nick_estudiante`) REFERENCES `estudiante` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante_leccion`
--
ALTER TABLE `estudiante_leccion`
  ADD CONSTRAINT `fk_leccion` FOREIGN KEY (`id_leccion`) REFERENCES `leccion` (`id_leccion`),
  ADD CONSTRAINT `fk_nick_estudiante` FOREIGN KEY (`nick_estudiante`) REFERENCES `estudiante` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD CONSTRAINT `fk_modulo_evaluacion` FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id_modulo`);

--
-- Filtros para la tabla `foro`
--
ALTER TABLE `foro`
  ADD CONSTRAINT `fk_curso_foro` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `leccion`
--
ALTER TABLE `leccion`
  ADD CONSTRAINT `fk_modulo_leccion` FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id_modulo`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `fk_discusion_mensaje` FOREIGN KEY (`id_discusion`) REFERENCES `discusion` (`id_discusion`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estudiante_destinatario` FOREIGN KEY (`nick_destinatario_estudiante`) REFERENCES `estudiante` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estudiante_emisor` FOREIGN KEY (`nick_emisor_estudiante`) REFERENCES `estudiante` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_organizador_destinatario` FOREIGN KEY (`nick_destinatario_organizador`) REFERENCES `organizador` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_organizador_emisor` FOREIGN KEY (`nick_emisor_organizador`) REFERENCES `organizador` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seminario_mensaje` FOREIGN KEY (`id_seminario`) REFERENCES `seminario_virtual` (`id_seminario_virtual`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `fk_curso_modulo` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD CONSTRAINT `fk_pregunta_opcion` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id_pregunta`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `fk_evaluacion_prueba` FOREIGN KEY (`id_evaluacion`) REFERENCES `evaluacion` (`id_evaluacion`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pregunta_evaluacion` FOREIGN KEY (`id_evaluacion`) REFERENCES `evaluacion` (`id_evaluacion`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD CONSTRAINT `fk_estudiante_prueba` FOREIGN KEY (`nick_estudiante`) REFERENCES `estudiante` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ev_prueba` FOREIGN KEY (`id_evaluacion`) REFERENCES `evaluacion` (`id_evaluacion`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `fk_estudiante_publicacion` FOREIGN KEY (`nick_estudiante`) REFERENCES `estudiante` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `fk_pregunta_respuesta` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id_pregunta`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prueba_respuesta` FOREIGN KEY (`id_prueba`) REFERENCES `prueba` (`id_prueba`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `seminario_presencial`
--
ALTER TABLE `seminario_presencial`
  ADD CONSTRAINT `fk_organizador_seminario_presencial` FOREIGN KEY (`nick_organizador`) REFERENCES `organizador` (`nick`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `seminario_virtual`
--
ALTER TABLE `seminario_virtual`
  ADD CONSTRAINT `fk_organizador_seminario_virtual` FOREIGN KEY (`nick_organizador`) REFERENCES `organizador` (`nick`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
