-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2021 at 10:22 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `connect4db`
--

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `id` int(10) UNSIGNED NOT NULL,
  `b_x` int(7) NOT NULL,
  `b_y` int(6) NOT NULL,
  `b_piece_color` enum('Y','R') COLLATE utf8_bin DEFAULT NULL,
  `b_blocked` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`id`, `b_x`, `b_y`, `b_piece_color`, `b_blocked`) VALUES
(1, 1, 1, NULL, 0),
(2, 1, 2, NULL, 1),
(3, 1, 3, NULL, 1),
(4, 1, 4, NULL, 1),
(5, 1, 5, NULL, 1),
(6, 1, 6, NULL, 1),
(7, 2, 1, NULL, 0),
(8, 2, 2, NULL, 1),
(9, 2, 3, NULL, 1),
(10, 2, 4, NULL, 1),
(11, 2, 5, NULL, 1),
(12, 2, 6, NULL, 1),
(13, 3, 1, NULL, 0),
(14, 3, 2, NULL, 1),
(15, 3, 3, NULL, 1),
(16, 3, 4, NULL, 1),
(17, 3, 5, NULL, 1),
(18, 3, 6, NULL, 1),
(19, 4, 1, NULL, 0),
(20, 4, 2, NULL, 1),
(21, 4, 3, NULL, 1),
(22, 4, 4, NULL, 1),
(23, 4, 5, NULL, 1),
(24, 4, 6, NULL, 1),
(25, 5, 1, NULL, 0),
(26, 5, 2, NULL, 1),
(27, 5, 3, NULL, 1),
(28, 5, 4, NULL, 1),
(29, 5, 5, NULL, 1),
(30, 5, 6, NULL, 1),
(31, 6, 1, NULL, 0),
(32, 6, 2, NULL, 1),
(33, 6, 3, NULL, 1),
(34, 6, 4, NULL, 1),
(35, 6, 5, NULL, 1),
(36, 6, 6, NULL, 1),
(37, 7, 1, NULL, 0),
(38, 7, 2, NULL, 1),
(39, 7, 3, NULL, 1),
(40, 7, 4, NULL, 1),
(41, 7, 5, NULL, 1),
(42, 7, 6, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `board_empty`
--

CREATE TABLE `board_empty` (
  `id` int(10) UNSIGNED NOT NULL,
  `b_x` int(7) NOT NULL,
  `b_y` int(6) NOT NULL,
  `b_piece_color` enum('Y','R') COLLATE utf8_bin DEFAULT NULL,
  `b_blocked` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `board_empty`
--

INSERT INTO `board_empty` (`id`, `b_x`, `b_y`, `b_piece_color`, `b_blocked`) VALUES
(1, 1, 1, NULL, 0),
(2, 1, 2, NULL, 1),
(3, 1, 3, NULL, 1),
(4, 1, 4, NULL, 1),
(5, 1, 5, NULL, 1),
(6, 1, 6, NULL, 1),
(7, 2, 1, NULL, 0),
(8, 2, 2, NULL, 1),
(9, 2, 3, NULL, 1),
(10, 2, 4, NULL, 1),
(11, 2, 5, NULL, 1),
(12, 2, 6, NULL, 1),
(13, 3, 1, NULL, 0),
(14, 3, 2, NULL, 1),
(15, 3, 3, NULL, 1),
(16, 3, 4, NULL, 1),
(17, 3, 5, NULL, 1),
(18, 3, 6, NULL, 1),
(19, 4, 1, NULL, 0),
(20, 4, 2, NULL, 1),
(21, 4, 3, NULL, 1),
(22, 4, 4, NULL, 1),
(23, 4, 5, NULL, 1),
(24, 4, 6, NULL, 1),
(25, 5, 1, NULL, 0),
(26, 5, 2, NULL, 1),
(27, 5, 3, NULL, 1),
(28, 5, 4, NULL, 1),
(29, 5, 5, NULL, 1),
(30, 5, 6, NULL, 1),
(31, 6, 1, NULL, 0),
(32, 6, 2, NULL, 1),
(33, 6, 3, NULL, 1),
(34, 6, 4, NULL, 1),
(35, 6, 5, NULL, 1),
(36, 6, 6, NULL, 1),
(37, 7, 1, NULL, 0),
(38, 7, 2, NULL, 1),
(39, 7, 3, NULL, 1),
(40, 7, 4, NULL, 1),
(41, 7, 5, NULL, 1),
(42, 7, 6, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `game_status`
--

CREATE TABLE `game_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `g_status` enum('0','1','2') COLLATE utf8_bin DEFAULT NULL,
  `g_turn` enum('0','1','2') COLLATE utf8_bin DEFAULT NULL,
  `g_result` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `g_last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `g_logged_in` enum('0','1','2') COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `game_status`
--

INSERT INTO `game_status` (`id`, `g_status`, `g_turn`, `g_result`, `g_last_change`, `g_logged_in`) VALUES
(1, '0', '0', NULL, '2021-01-06 09:21:58', '0');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(10) UNSIGNED NOT NULL,
  `pl_username` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `pl_password` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `pl_color` enum('Y','R') COLLATE utf8_bin NOT NULL,
  `pl_lastaction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `pl_username`, `pl_password`, `pl_color`, `pl_lastaction`) VALUES
(1, 'paiktis1', '1234abc', 'Y', '2021-01-06 09:18:58'),
(2, 'paiktis2', '1234abc', 'R', '2021-01-06 09:18:58');
COMMIT;

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `board_empty`
--
ALTER TABLE `board_empty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `game_status`
--
ALTER TABLE `game_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
