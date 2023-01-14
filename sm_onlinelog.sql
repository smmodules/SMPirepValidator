-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 14/01/2023 às 15:42
-- Versão do servidor: 5.7.23-23
-- Versão do PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `avianc34_one`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `sm_onlinelog`
--

CREATE TABLE `sm_onlinelog` (
  `id` int(11) UNSIGNED NOT NULL,
  `network` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `userId` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'IVAO or VATSIM Id#',
  `sessionId` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `callsign` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Flitgh #',
  `serverId` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `softwareTypeId` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `softwareVersion` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sessioncreatedAt` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `depairport` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `arrairport` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `alternative` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alternative2` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `route` text COLLATE utf8_unicode_ci,
  `remarks` text COLLATE utf8_unicode_ci,
  `speed` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flightRules` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eet` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `endurance` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `peopleOnBoard` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acftIcao` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acftModel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `simulatorId` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `sm_onlinelog`
--
ALTER TABLE `sm_onlinelog`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `sm_onlinelog`
--
ALTER TABLE `sm_onlinelog`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
