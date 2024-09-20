-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2024 at 02:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `senac`
--

-- --------------------------------------------------------

--
-- Table structure for table `salas`
--

CREATE TABLE `salas` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `sala` varchar(5) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `capacidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salas`
--

INSERT INTO `salas` (`sala`, `tipo`, `capacidade`) VALUES
( '101', 'laboratorio', 35),
( '102', 'laboratorio', 40),
( '103', 'auditorio', 70),
( '104', 'auditorio', 40),
( '105', 'cozinha', 30),
( '201', 'auditorio', 25),
( '202', 'cozinha', 20),
( '203', 'laboratorio', 30),
( '204', 'auditorio', 40),
( '205', 'laboratorio', 30);

