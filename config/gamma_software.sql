-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 04 mai 2022 à 16:18
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gamma_software`
--
CREATE DATABASE IF NOT EXISTS `gamma_software` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gamma_software`;

-- --------------------------------------------------------

--
-- Structure de la table `rock_band`
--
-- Création :  mer. 04 mai 2022 à 08:18
--

DROP TABLE IF EXISTS `rock_band`;
CREATE TABLE IF NOT EXISTS `rock_band` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) DEFAULT NULL,
  `founder` varchar(255) DEFAULT NULL,
  `member_count` int(11) DEFAULT NULL,
  `music_type` varchar(255) DEFAULT NULL,
  `presentation` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS POUR LA TABLE `rock_band`:
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
