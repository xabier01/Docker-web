-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-10-2022 a las 15:53:18
-- Versión del servidor: 10.8.2-MariaDB-1:10.8.2+maria~focal
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `erabiltzaileak`
--

CREATE TABLE `erabiltzaileak` (
  `erabiltzaileIzena` varchar(100) NOT NULL,
  `pasahitza` varchar(100) NOT NULL,
  `izenAbizenak` text NOT NULL,
  `nan` varchar(10) NOT NULL,
  `telefonoa` int(9) NOT NULL,
  `jaioData` date NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `erabiltzaileak`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jokoak`
--

CREATE TABLE `jokoak` (
  `titulua` varchar(200) NOT NULL,
  `generoa` text NOT NULL,
  `balorazioa` int(10) NOT NULL,
  `jokoAdina` int(18) NOT NULL,
  `laburpena` varchar(500) NOT NULL,
  `pertsonaiPrin` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jokoak`
--

INSERT INTO `jokoak` (`titulua`, `generoa`, `balorazioa`, `jokoAdina`, `laburpena`, `pertsonaiPrin`) VALUES
('Dragon ball Z 2', 'borroka', 60, 7, 'Gokuk lurra salbatu behar du freezeren aurka borrokatuz', 'Goku, freezer, gohan...'),
('mario party', 'minijokoak', 70, 3, 'Minijokoak jolastu bakarrik edo lagunekin', 'Mario, Luigi, Wario...'),
('zelda', 'abentura', 90, 3, 'Link izeneko pertsonaiak Zelda printzesa salbatu beharko du', 'Link, Zelda eta Ganondorf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pertsonaiak`
--

CREATE TABLE `pertsonaiak` (
  `pertsonaiIzena` varchar(200) NOT NULL,
  `agerpenJokuIzen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pertsonaiak`
--

INSERT INTO `pertsonaiak` (`pertsonaiIzena`, `agerpenJokuIzen`) VALUES
('Ezio', 'Assassins Creed II, Assassins Creed Brotherhood eta Assassins Creed Revelations'),
('mario ', 'mario bros, mario party'),
('sonic', 'sonic 1, sonic 2');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logOnak`
--

CREATE TABLE `logOnak` (
  `erabIzena` varchar(200) NOT NULL,
  `dataOrdua` datetime 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `logOnak`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logTxarrak`
--

CREATE TABLE `logTxarrak` (
  `erabIzena` varchar(100) NOT NULL,
  `pasahitza` varchar(100) ,
  `dataOrdua` datetime ,
  `hutsSaioak` int(3) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `logTxarrak`
--

-- --------------------------------------------------------



--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `erabiltzaileak`
--
ALTER TABLE `erabiltzaileak`
  ADD PRIMARY KEY (`email`,`erabiltzaileIzena`,`telefonoa`,`nan`);

--
-- Indices de la tabla `jokoak`
--
ALTER TABLE `jokoak`
  ADD PRIMARY KEY (`titulua`);

--
-- Indices de la tabla `pertsonaiak`
--
ALTER TABLE `pertsonaiak`
  ADD PRIMARY KEY (`pertsonaiIzena`);


-- Indices de la tabla `logOnak`
--

  
-- Indices de la tabla `logTxarrak`
--
ALTER TABLE `logTxarrak`
  ADD PRIMARY KEY (`erabIzena`);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
