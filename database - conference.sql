-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 27, 2024 at 02:54 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `conference`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `attendance_id` int NOT NULL AUTO_INCREMENT,
  `participant_id` int DEFAULT NULL,
  `session_id` int DEFAULT NULL,
  `check_in_time` datetime DEFAULT NULL,
  PRIMARY KEY (`attendance_id`),
  KEY `participant_id` (`participant_id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `feedback_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `session` int NOT NULL,
  `feedback` text NOT NULL,
  PRIMARY KEY (`feedback_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `name`, `session`, `feedback`) VALUES
(7, 'hgjgjh', 0, 'jhjghjhgj'),
(6, 'cdd', 0, 'nhjhgjhjhg');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
CREATE TABLE IF NOT EXISTS `participants` (
  `participant_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `sessions_registered` int DEFAULT NULL,
  `QR_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`participant_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`participant_id`, `name`, `email`, `phone`, `organization`, `sessions_registered`, `QR_code`) VALUES
(32, 'wodag', 'anjulaparanagama145@gmail.com', '7590666754', '', 0, 'qrcodes/wodag_Blockchain Systems.png'),
(31, 'wodag', 'anjulap145@gmail.com', '7590666754', NULL, 0, 'qrcodes/wodag_Blockchain Systems.png'),
(28, 'wodag', 'anjulap145@gmail.com', '7590666754', '', 0, 'qrcodes/wodag_Blockchain Systems.png'),
(29, 'wodag', 'anjulap145@gmail.com', '7590666754', NULL, 0, 'qrcodes/wodag_Blockchain Systems.png'),
(30, 'wodag', 'anjulap145@gmail.com', '7590666754', NULL, 0, 'qrcodes/wodag_Blockchain Systems.png'),
(33, 'wodag', 'anjulaparanagama145@gmail.com', '7590666754', '', 0, 'qrcodes/wodag_Blockchain Systems.png'),
(34, 'wodag', 'anjulaparanagama145@gmail.com', '7590666754', NULL, 0, 'qrcodes/wodag_Blockchain Systems.png'),
(35, 'wodag', 'anjulaparanagama145@gmail.com', '7590666754', NULL, 0, 'qrcodes/wodag_Blockchain Systems.png'),
(36, 'Anjula', 'anjulac2006@gmail.com', '75904587', 'itum', 2, 'qrcodes/Anjula_2.png'),
(37, 'Anjula', 'anjulac2006@gmail.com', '75904587', 'itum', 2, 'qrcodes/Anjula_2.png'),
(38, 'Anjula', 'anjulac2006@gmail.com', '75904587', 'itum', 2, 'qrcodes/Anjula_2.png'),
(39, 'Anjula', 'anjulac2006@gmail.com', '75904587', 'itum', 2, 'qrcodes/Anjula_2.png');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `speaker` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  `capacity` int NOT NULL,
  `registered_count` int DEFAULT '0',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `title`, `speaker`, `time`, `capacity`, `registered_count`) VALUES
(1, 'Artificial Intelligence and Machine Learning ', 'Dr. Ishara Dharmasena', '2024-12-28 09:00:00', 500, 0),
(2, 'Blockchain and Decentralized Systems ', 'Eng. thusitha perera', '2024-12-28 10:00:00', 200, 0),
(3, 'Cloud Computing and Edge Technologiess ', 'Eng. Amoda rivindu', '2024-12-28 11:00:00', 500, 0),
(4, 'Internet of Things (IoT)', 'Mr. P.K.vidanagamage', '2024-12-28 13:00:00', 200, 0),
(5, 'Cybersecurity and Privacy', 'Prof. P.D.C.Gamage', '2024-12-28 14:00:00', 200, 0),
(6, '5G and Next-Generation Networks', 'Eng. D.N.Rathnayake', '2024-12-28 15:00:00', 200, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone_number`, `organization`, `password`) VALUES
(4, 'Anjula', 'anjulac2006@gmail.com', '771415145', 'NSP', '$2y$10$ScDEvlEmXZkP8L7oly83j.ZBwsbg5/0cYIK/pb7ocySEstwobD0JW'),
(3, 'Test User', 'testuser@example.com', '1234567890', 'Test Org', 'hashedpassword'),
(5, 'Anjula nawoda', 'anjulaparanagama15@gmail.com', '56554', 'itum', '$2y$10$N9o0.WNCr7r8TapELewJ1.qu84aXJE0F7HslEZxy9x2xGeVfEoCCO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
