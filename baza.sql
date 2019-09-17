-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 09, 2019 at 12:50 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osiguranje`
--
CREATE DATABASE IF NOT EXISTS `osiguranje` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `osiguranje`;

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime_i_prezime` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datum_rodjenja` datetime NOT NULL,
  `broj_pasosa` int(9) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefon` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime_i_prezime`, `datum_rodjenja`, `broj_pasosa`, `email`, `telefon`) VALUES
(151, 'Pera Peric', '2019-09-13 00:00:00', 342342342, 'ivan@gmail.com', '56456546546'),
(152, 'Milan Petrovic', '2019-09-20 00:00:00', 342342342, NULL, NULL),
(153, 'Nikola Jankovic', '2019-09-11 00:00:00', 342342342, 'niasdasddkola@gmail.com', '56456546546'),
(154, 'Marija Simic', '2019-09-19 00:00:00', 342342342, NULL, NULL),
(155, 'Stefana Ilic', '2019-09-26 00:00:00', 342342342, NULL, NULL),
(156, 'Snezana Popovic', '2019-09-20 00:00:00', 342342342, 'snezanasdasd@gmail.com', '56456546546'),
(157, 'Petar Ristic', '2019-09-18 00:00:00', 342342342, NULL, NULL),
(158, 'Radovan Petrovic', '2019-09-19 00:00:00', 342342342, 'radovanrewr@gmail.com', '56456546546'),
(159, 'Milos simic', '2019-09-19 00:00:00', 342342342, NULL, NULL),
(160, 'Milan Petrovic', '2019-09-20 00:00:00', 342342342, 'ivan@gmail.com', '56456546546'),
(161, 'Viktor Ristic', '2019-09-11 00:00:00', 342342342, 'viksadtor@gmail.com', '56456546546'),
(162, 'Milica Ilic', '2019-09-05 00:00:00', 555555555, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `polisa`
--

DROP TABLE IF EXISTS `polisa`;
CREATE TABLE IF NOT EXISTS `polisa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum_unosa_polise` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datum_putovanja_od` datetime NOT NULL,
  `datum_putovanja_do` datetime NOT NULL,
  `tip_polise` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `polisa`
--

INSERT INTO `polisa` (`id`, `datum_unosa_polise`, `datum_putovanja_od`, `datum_putovanja_do`, `tip_polise`) VALUES
(120, '2019-09-09 13:58:33', '2019-09-27 00:00:00', '2019-09-28 00:00:00', 2),
(121, '2019-09-09 14:01:26', '2019-09-06 00:00:00', '2019-09-06 00:00:00', 2),
(122, '2019-09-09 14:02:48', '2019-09-19 00:00:00', '2019-09-29 00:00:00', 2),
(123, '2019-09-09 14:04:09', '2019-09-12 00:00:00', '2019-09-21 00:00:00', 2),
(124, '2019-09-09 14:17:37', '2019-09-05 00:00:00', '2019-09-12 00:00:00', 2),
(125, '2019-09-09 14:47:27', '2019-09-10 00:00:00', '2019-09-15 00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `polisaosiguranik`
--

DROP TABLE IF EXISTS `polisaosiguranik`;
CREATE TABLE IF NOT EXISTS `polisaosiguranik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `polisa_id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `nosioc` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `polisa_id` (`polisa_id`),
  KEY `korisnik_id` (`korisnik_id`)
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polisaosiguranik`
--

INSERT INTO `polisaosiguranik` (`id`, `polisa_id`, `korisnik_id`, `nosioc`) VALUES
(154, 120, 151, 1),
(155, 120, 152, 0),
(156, 121, 153, 1),
(157, 121, 154, 0),
(158, 121, 155, 0),
(159, 122, 156, 1),
(160, 122, 157, 0),
(161, 123, 158, 1),
(162, 123, 159, 0),
(163, 124, 160, 1),
(165, 125, 161, 1),
(166, 125, 162, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `polisaosiguranik`
--
ALTER TABLE `polisaosiguranik`
  ADD CONSTRAINT `polisaosiguranik_ibfk_1` FOREIGN KEY (`polisa_id`) REFERENCES `polisa` (`id`),
  ADD CONSTRAINT `polisaosiguranik_ibfk_2` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
