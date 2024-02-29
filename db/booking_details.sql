-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2024 at 07:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `room_no` int(11) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `phonenum` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`sr_no`, `booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`) VALUES
(0, 16, 'Triple', 300000, 30000000, NULL, 'adsa', '121'),
(0, 17, 'Triple', 300000, 30000000, NULL, 'asd', '123'),
(0, 18, 'Triple', 300000, 30000000, NULL, 'wq', '312'),
(0, 19, 'Triple', 300000, 30000000, NULL, 'dasda', '0123456'),
(0, 20, 'Triple', 300000, 30000000, NULL, 'dada', '0123456'),
(0, 21, 'Triple', 300000, 30000000, NULL, 'dasda', '1312'),
(0, 22, 'Triple', 300000, 30000000, NULL, 'dada', '2131'),
(0, 23, 'Triple', 300000, 30000000, NULL, 'fds', '3123'),
(0, 24, 'Triple', 300000, 30000000, NULL, 'ds', '131'),
(0, 25, 'Triple', 300000, 30000000, NULL, 'dasdas', '2313'),
(0, 26, 'Triple', 300000, 30000000, NULL, 'dada', '31'),
(0, 27, 'Triple', 300000, 30000000, NULL, 'dada', '0123456'),
(0, 28, 'Triple', 300000, 30000000, NULL, 'dsadas', '342'),
(0, 29, 'Triple', 300000, 30000000, NULL, 'dsada', '3131'),
(0, 30, 'Triple', 300000, 30000000, NULL, 'dada', '3342'),
(0, 31, 'Triple', 300000, 30000000, NULL, 'dadas', '0123456'),
(0, 32, 'Triple', 300000, 30000000, NULL, 'dadas', '31231'),
(0, 33, 'Triple', 300000, 30000000, NULL, 'dadasd', '31231');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
