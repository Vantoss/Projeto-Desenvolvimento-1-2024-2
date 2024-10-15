-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2024 at 12:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `senac`
--
--
-- Procedures
--

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletar_reservas_passadas` ()   DELETE FROM reservas WHERE data < CURRENT_DATE$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inserir_reservas_histórico` ()   INSERT INTO reservas_historico (id, data, docente, participantes, id_turma, id_sala)
SELECT r.id_reserva,r.data,t.docente,t.participantes_qtd,r.id_turma,r.id_sala
FROM reservas as r
INNER JOIN turmas as t
ON r.id_turma = t.id_turma
WHERE r.data < CURRENT_DATE$$

DELIMITER ;
-- --------------------------------------------------------

--
-- Table structure for table `disciplinas`
--

CREATE TABLE `turmas` (
  `id_turma` int(11) NOT NULL,
  `nome` varchar(80) DEFAULT NULL,
  `curso` varchar(80) DEFAULT NULL,
  `docente` varchar(50) DEFAULT NULL,
  `turno` varchar(10) DEFAULT NULL,
  `codigo` varchar(60) DEFAULT NULL,
  `participantes_qtd` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `disciplinas`
--

INSERT INTO `turmas` (`id_turma`, `nome`, `curso`, `docente`, `turno`, `codigo`, `participantes_qtd`) VALUES
(1, 'Desenvolvimento Interface Web', 'SPI', 'Fernando', 'Manhã', 'RS-20231-FSPOA-DlW-PRE-SPI1M24-1A', 20),
(2, 'Desenvolvimento Interface Web', 'SPI', 'Fernando', 'Noite', 'RS-20231-FSPOA-DlW-PRE-SPI1N24-1A', 25),
(3, 'Desenvolvimento Interface Web', 'SPI', 'Rafael', 'Manhã', 'RS-20231-FSPOA-DlW-PRE-SPI1M24-1A', 24),
(4, 'Desenvolvimento Interface Web', 'SPI', 'Rafael', 'Noite', 'RS-20231-FSPOA-DlW-PRE-SPI1N24-1A', 22),
(5, 'Desenvolvimento Gráfico', 'PM', 'Roberto', 'Manhã', 'RS-20242-FSPOA-DGR-PRE-PM1M24-2', 18),
(6, 'Desenvolvimento Gráfico', 'PM', 'Roberto', 'Noite', 'RS-20242-FSPOA-DGR-PRE-PM1N24-2', 25),
(7, 'Desenvolvimento Gráfico', 'PM', 'Pedro', 'Manhã', 'RS-20242-FSPOA-DGR-PRE-PM1M24-2', 28),
(8, 'Desenvolvimento Gráfico', 'PM', 'Pedro', 'Noite', 'RS-20242-FSPOA-DGR-PRE-PM1N24-2', 12),
(9, 'Algoritmos Estruturas de Dados I', 'ADS', 'Roberto', 'Manhã', 'RS-20232-FSPOA-ALG1-PRE-ADS3M24-2', 27),
(10, 'Algoritmos Estruturas de Dados I', 'ADS', 'Roberto', 'Noite', 'RS-20232-FSPOA-ALG1-PRE-ADS3N24-2', 22),
(11, 'Algoritmos Estruturas de Dados I', 'ADS', 'Mario', 'Manhã', 'RS-20232-FSPOA-ALG1-PRE-ADS3M24-2', 31),
(12, 'Algoritmos Estruturas de Dados I', 'ADS', 'Mario', 'Noite', 'RS-20232-FSPOA-ALG1-PRE-ADS3N24-2', 20),
(13, 'Fundamentos Computacionais', 'ADS', 'Reinaldo', 'Manhã', 'RS-20222-FSPOA-FUND-PRE-ADS1M24-2', 19),
(14, 'Fundamentos Computacionais', 'ADS', 'Reinaldo', 'Noite', 'RS-20222-FSPOA-FUND-PRE-ADS1N24-2', 24),
(15, 'Fundamentos Computacionais', 'ADS', 'Ronaldo', 'Manhã', 'RS-20222-FSPOA-FUND-PRE-ADS1M24-2', 22),
(16, 'Fundamentos Computacionais', 'ADS', 'Ronaldo', 'Noite', 'RS-20222-FSPOA-FUND-PRE-ADS1N24-2', 26);

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `data` date NOT NULL,
  `reserva_tipo` varchar(30) DEFAULT NULL,
  `id_sala` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `data`, `reserva_tipo`, `id_sala`, `id_turma`) VALUES
(1, '2024-03-04', 'Semanal', 504, 9),
(2, '2024-03-11', 'Semanal', 504, 9),
(3, '2024-03-18', 'Semanal', 504, 9),
(4, '2024-03-25', 'Semanal', 504, 9),
(5, '2024-04-01', 'Semanal', 504, 9),
(6, '2024-04-08', 'Semanal', 504, 9),
(7, '2024-04-15', 'Semanal', 504, 9),
(8, '2024-04-22', 'Semanal', 504, 9),
(9, '2024-04-29', 'Semanal', 504, 9),
(10, '2024-05-06', 'Semanal', 504, 9),
(11, '2024-05-13', 'Semanal', 504, 9),
(12, '2024-05-20', 'Semanal', 504, 9),
(13, '2024-05-27', 'Semanal', 504, 9),
(14, '2024-06-03', 'Semanal', 504, 9),
(15, '2024-06-10', 'Semanal', 504, 9),
(16, '2024-06-17', 'Semanal', 504, 9),
(17, '2024-06-24', 'Semanal', 504, 9),
(18, '2024-07-01', 'Semanal', 504, 9),
(19, '2024-07-08', 'Semanal', 504, 9),
(20, '2024-07-15', 'Semanal', 504, 9),
(21, '2024-07-22', 'Semanal', 504, 9),
(22, '2024-03-04', 'Semanal', 504, 10),
(23, '2024-03-11', 'Semanal', 504, 10),
(24, '2024-03-18', 'Semanal', 504, 10),
(25, '2024-03-25', 'Semanal', 504, 10),
(26, '2024-04-01', 'Semanal', 504, 10),
(27, '2024-04-08', 'Semanal', 504, 10),
(28, '2024-04-15', 'Semanal', 504, 10),
(29, '2024-04-22', 'Semanal', 504, 10),
(30, '2024-04-29', 'Semanal', 504, 10),
(31, '2024-05-06', 'Semanal', 504, 10),
(32, '2024-05-13', 'Semanal', 504, 10),
(33, '2024-05-20', 'Semanal', 504, 10),
(34, '2024-05-27', 'Semanal', 504, 10),
(35, '2024-06-03', 'Semanal', 504, 10),
(36, '2024-06-10', 'Semanal', 504, 10),
(37, '2024-06-17', 'Semanal', 504, 10),
(38, '2024-06-24', 'Semanal', 504, 10),
(39, '2024-07-01', 'Semanal', 504, 10),
(40, '2024-07-08', 'Semanal', 504, 10),
(41, '2024-07-15', 'Semanal', 504, 10),
(42, '2024-07-22', 'Semanal', 504, 10),
(43, '2024-03-04', 'Semanal', 303, 5),
(44, '2024-03-11', 'Semanal', 303, 5),
(45, '2024-03-18', 'Semanal', 303, 5),
(46, '2024-03-25', 'Semanal', 303, 5),
(47, '2024-04-01', 'Semanal', 303, 5),
(48, '2024-04-08', 'Semanal', 303, 5),
(49, '2024-04-15', 'Semanal', 303, 5),
(50, '2024-04-22', 'Semanal', 303, 5),
(51, '2024-04-29', 'Semanal', 303, 5),
(52, '2024-05-06', 'Semanal', 303, 5),
(53, '2024-05-13', 'Semanal', 303, 5),
(54, '2024-05-20', 'Semanal', 303, 5),
(55, '2024-05-27', 'Semanal', 303, 5),
(56, '2024-06-03', 'Semanal', 303, 5),
(57, '2024-06-10', 'Semanal', 303, 5),
(58, '2024-06-17', 'Semanal', 303, 5),
(59, '2024-06-24', 'Semanal', 303, 5),
(60, '2024-07-01', 'Semanal', 303, 5),
(61, '2024-07-08', 'Semanal', 303, 5),
(62, '2024-07-15', 'Semanal', 303, 5),
(63, '2024-07-22', 'Semanal', 303, 5),
(64, '2024-03-04', 'Semanal', 301, 6),
(65, '2024-03-11', 'Semanal', 301, 6),
(66, '2024-03-18', 'Semanal', 301, 6),
(67, '2024-03-25', 'Semanal', 301, 6),
(68, '2024-04-01', 'Semanal', 301, 6),
(69, '2024-04-08', 'Semanal', 301, 6),
(70, '2024-04-15', 'Semanal', 301, 6),
(71, '2024-04-22', 'Semanal', 301, 6),
(72, '2024-04-29', 'Semanal', 301, 6),
(73, '2024-05-06', 'Semanal', 301, 6),
(74, '2024-05-13', 'Semanal', 301, 6),
(75, '2024-05-20', 'Semanal', 301, 6),
(76, '2024-05-27', 'Semanal', 301, 6),
(77, '2024-06-03', 'Semanal', 301, 6),
(78, '2024-06-10', 'Semanal', 301, 6),
(79, '2024-06-17', 'Semanal', 301, 6),
(80, '2024-06-24', 'Semanal', 301, 6),
(81, '2024-07-01', 'Semanal', 301, 6),
(82, '2024-07-08', 'Semanal', 301, 6),
(83, '2024-07-15', 'Semanal', 301, 6),
(84, '2024-07-22', 'Semanal', 301, 6),
(85, '2024-03-05', 'Semanal', 502, 1),
(86, '2024-03-12', 'Semanal', 502, 1),
(87, '2024-03-19', 'Semanal', 502, 1),
(88, '2024-03-26', 'Semanal', 502, 1),
(89, '2024-04-02', 'Semanal', 502, 1),
(90, '2024-04-09', 'Semanal', 502, 1),
(91, '2024-04-16', 'Semanal', 502, 1),
(92, '2024-04-23', 'Semanal', 502, 1),
(93, '2024-04-30', 'Semanal', 502, 1),
(94, '2024-05-07', 'Semanal', 502, 1),
(95, '2024-05-14', 'Semanal', 502, 1),
(96, '2024-05-21', 'Semanal', 502, 1),
(97, '2024-05-28', 'Semanal', 502, 1),
(98, '2024-06-04', 'Semanal', 502, 1),
(99, '2024-06-11', 'Semanal', 502, 1),
(100, '2024-06-18', 'Semanal', 502, 1),
(101, '2024-06-25', 'Semanal', 502, 1),
(102, '2024-07-02', 'Semanal', 502, 1),
(103, '2024-07-09', 'Semanal', 502, 1),
(104, '2024-07-16', 'Semanal', 502, 1),
(105, '2024-07-23', 'Semanal', 502, 1),
(106, '2024-03-06', 'Semanal', 602, 1),
(107, '2024-03-13', 'Semanal', 602, 1),
(108, '2024-03-14', 'Semanal', 602, 1),
(109, '2024-03-27', 'Semanal', 602, 1),
(110, '2024-04-03', 'Semanal', 602, 1),
(111, '2024-04-10', 'Semanal', 602, 1),
(112, '2024-04-17', 'Semanal', 602, 1),
(113, '2024-04-24', 'Semanal', 602, 1),
(114, '2024-05-01', 'Semanal', 602, 1),
(115, '2024-05-08', 'Semanal', 602, 1),
(116, '2024-05-15', 'Semanal', 602, 1),
(117, '2024-05-22', 'Semanal', 602, 1),
(118, '2024-05-29', 'Semanal', 602, 1),
(119, '2024-06-05', 'Semanal', 602, 1),
(120, '2024-06-12', 'Semanal', 602, 1),
(121, '2024-06-19', 'Semanal', 602, 1),
(122, '2024-06-26', 'Semanal', 602, 1),
(123, '2024-07-03', 'Semanal', 602, 1),
(124, '2024-07-10', 'Semanal', 602, 1),
(125, '2024-07-17', 'Semanal', 602, 1),
(126, '2024-07-24', 'Semanal', 602, 1);

-- --------------------------------------------------------

--
-- Table structure for table `salas`
--

CREATE TABLE `salas` (
  `id_sala` int(11) NOT NULL,
  `tipo_sala` varchar(45) DEFAULT NULL,
  `lugares_qtd` int(11) DEFAULT NULL COMMENT 'capacidade das salas (lotação)',
  `maquinas_qtd` int(11) DEFAULT NULL,
  `maquinas_tipo` varchar(45) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `salas`
--

INSERT INTO `salas` (`id_sala`, `tipo_sala`, `lugares_qtd`, `maquinas_qtd`, `maquinas_tipo`, `descricao`) VALUES
(101, 'Laboratório', 20, 20, 'intel-i5-7', NULL),
(102, 'Laboratório', 40, 30, 'intel-i5-7', NULL),
(103, 'Laboratório', 30, 20, 'intel-i3-7', NULL),
(104, 'Auditório', 100, 2, 'Intel-i3-7', NULL),
(105, 'Laboratório', 30, 20, 'Intel-i3-7', NULL),
(122, 'Estudio de Aúdio', 10, 2, 'Intel-i3-7', NULL),
(201, 'Laboratório', 30, 30, 'Rizen-5', NULL),
(202, 'Laboratório', 40, 30, 'Rizen-5', NULL),
(203, 'Laboratório', 35, 20, 'Rizen-5', NULL),
(204, 'Laboratório', 45, 30, 'Rizen-5', NULL),
(205, 'Laboratório', 45, 30, 'Rizen-5', NULL),
(301, 'Laboratório', 25, 20, 'Intel-i9-12', NULL),
(302, 'Laboratório', 25, 20, 'Intel-i9-12', NULL),
(303, 'Laboratório', 25, 20, 'Intel-i9-12', NULL),
(304, 'Laboratório', 45, 35, 'MAC', NULL),
(305, 'Laboratório', 45, 35, 'MAC', NULL),
(306, 'Laboratório', 45, 35, 'MAC', NULL),
(307, 'Laboratório', 30, 30, 'Intel-i7-10', NULL),
(401, 'Sala de aula', 40, 0, NULL, NULL),
(402, 'Sala de aula', 50, 0, NULL, NULL),
(403, 'Sala de aula', 40, 0, NULL, NULL),
(404, 'Sala de aula', 60, 0, NULL, NULL),
(501, 'Laboratório', 30, 30, 'Rizen-5', NULL),
(502, 'Laboratório', 50, 30, 'Rizen-5', NULL),
(503, 'Laboratório', 25, 25, 'Rizen-5', NULL),
(504, 'Laboratório', 50, 35, 'Rizen-5', NULL),
(505, 'Laboratório', 50, 35, 'Rizen-5', NULL),
(601, 'Laboratório', 30, 30, 'Intel-i5-6', NULL),
(602, 'Laboratório', 40, 28, 'Intel-i5-6', NULL),
(603, 'Laboratório', 20, 22, 'Intel-i5-6', NULL),
(604, 'Laboratório', 30, 35, 'Intel-i5-6', NULL),
(605, 'Laboratório', 30, 30, 'Intel-i5-6', NULL),
(801, 'Auditório', 100, 1, 'Intel-i7-10', NULL),
(802, 'Auditório', 80, 1, 'Intel-i7-10', NULL),
(803, 'Auditório', 150, 1, 'Intel-i7-10', NULL);


--
-- Table structure for table `reservas_historico`
--

CREATE TABLE `reservas_historico` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `docente` varchar(80) NOT NULL,
  `participantes` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL,
  `id_sala` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `disciplinas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id_turma`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_sala` (`id_sala`),
  ADD KEY `id_turma` (`id_turma`);

--
-- Indexes for table `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`id_sala`);



ALTER TABLE `turmas`
  MODIFY `id_turma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id_sala`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
