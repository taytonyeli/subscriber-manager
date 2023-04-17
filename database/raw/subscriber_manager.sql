-- phpMyAdmin SQL Dump
-- version 5.2.0-rc1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 04:16 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `subscriber_manager`
--
CREATE DATABASE IF NOT EXISTS `subscriber_manager` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `subscriber_manager`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `api_key` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `api_key`, `created_at`, `updated_at`) VALUES
(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiODk5OGZhMzgzMWJjZGY0YzZiZWQ2ZjA2YThiNzY2ZmY2ZjRhY2M2YzE2YjM4MGVmM2I1NmU1NDgyZDliNzgyZjQ0MTg5YmY5MmJlMDExODQiLCJpYXQiOjE2ODEyNDkxMTAuMjI4MjMyLCJuYmYiOjE2ODEyNDkxMTAuMjI4MjM1LCJleHAiOjQ4MzY5MjI3MTAuMjIwODIyLCJzdWIiOiI0Mjc2NjUiLCJzY29wZXMiOltdfQ.Qa-4PHQdg6FTECsdy-ndz9c7vK_qqbehgWhikLFf732HqEk0ZDIrZ-1YKpQN9nBAW1uKm8lZfApG2Ujh3iST_UPRxY8JFZV2MVIBdpx02B0yBFXpTQUsCy23vxa569K-F87d2TvK7DNcoSOfRAnT2b-NJJqINR8XSNI1RVy3WYyZv74PVQRO4oUo8fHas9IZeFO05i2EX-ZsusoT5SJ9gWRmildose6aAznSD7aPD9DeFD6cQoLsttPCxfCOpd4u9H_XCEsiQN15S_WpsoX5kaiWrEO3jON2v3LTTx8K_AlfUBzBRDrZ0VDLJU8xn_eXQ0mRWk-gXVvS5Dn_XAq60MDGatFMNIFrCb5xGt53SJjJtGe09m4-z4_nJoE4r4aNDa_AJb4r1CChM46XShqGmdgh_PsrqvldUHVn2O4sH8prjnsHs1pNRcArJWXxt2wQcZN2g1-bdweY2gM_QCA2r6_HLhnwTxakatOSgtLHLh9XQwdzXt-dyN7F6UG3-C1Bn9bLB6V3kc52bBH9QFTr_IEFjk89hFRN7PpJUthjhVQGoJCu-a9TvH-kRTAen3Ihg50dxNobXRGzN8UI54yXCmCDCx60uHfSuDHY3z1N_VCreYHQWAiRbg11xJ6Irj9pgdNO4mFI7BM0lZEb7uuoa09p1s7uJIGejlsanTsGCQo', '2023-04-17 01:26:47', '2023-04-17 01:26:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
