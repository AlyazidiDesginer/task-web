-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2024 at 06:48 PM
-- Server version: 8.2.0
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskk`
--

-- --------------------------------------------------------

--
-- Table structure for table `task_info`
--

DROP TABLE IF EXISTS `task_info`;
CREATE TABLE IF NOT EXISTS `task_info` (
  `task_id` int NOT NULL AUTO_INCREMENT,
  `t_title` varchar(120) NOT NULL,
  `t_description` text,
  `t_start_time` varchar(100) DEFAULT NULL,
  `t_end_time` varchar(100) DEFAULT NULL,
  `t_user_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0 = incomplete, 1 = In progress, 2 = complete',
  `t_category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `task_info`
--

INSERT INTO `task_info` (`task_id`, `t_title`, `t_description`, `t_start_time`, `t_end_time`, `t_user_id`, `status`, `t_category`) VALUES
(32, 'محمد', 'لا', '2024-06-07 12:00', '2024-06-24 12:00', 28, 0, NULL),
(31, 'مطور تطبيقات', 'تجريبي', '2024-06-26 12:00', '2024-06-30 12:00', 27, 1, NULL),
(29, 'تجريبي', 'تجريبي', '2024-06-18 12:00', '2024-06-23 12:00', 27, 0, NULL),
(30, 'مطور ويب', 'اختبار قبول', '2024-06-18 12:00', '2024-06-30 12:00', 28, 0, NULL),
(28, 'لل', 'لل', '2024-06-18 12:00', '2024-06-19 12:00', 27, 2, NULL),
(27, 'اختبار مطور ويب', 'اختبار قبول', '2024-06-26 12:00', '2024-06-30 12:00', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(120) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `temp_password` varchar(100) DEFAULT NULL,
  `user_role` int NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`user_id`, `fullname`, `username`, `email`, `password`, `temp_password`, `user_role`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', 'd79cd06799863224b7324d969c1e2084', NULL, 1),
(29, 'محمد علي', 'mohammedali', 'mohammed2@gmail.com', 'af0355615a6ff4d0ca3abc603a3d9e02', '1762275', 2),
(28, 'محمد اليزيدي', 'mohammed', 'mohammed@gmail.com', '9116d926e7c691c21aceff04399a4e89', '5874486', 2),
(27, 'محمد', 'test', 'test@gmail.com', '972fb337542cf4dc26878f4a91387dcb', '1722101', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
