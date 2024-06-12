-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 04:41 PM
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
-- Table structure for table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` int(11) NOT NULL DEFAULT 0,
  `refund` int(11) DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'pending',
  `order_id` varchar(150) NOT NULL,
  `trans_id` varchar(150) DEFAULT NULL,
  `trans_amt` int(11) NOT NULL,
  `trans_status` varchar(100) NOT NULL DEFAULT 'pending',
  `trans_resp_code` varchar(200) DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `trans_id`, `trans_amt`, `trans_status`, `trans_resp_code`, `datetime`) VALUES
(28, 1, 11, '2024-01-01', '2024-01-02', 0, 1, 'cancelled', 'ORD_14899328', '14266867', 30000000, '00', '00', '2024-01-01 23:41:56'),
(29, 1, 11, '2024-01-02', '2024-01-03', 0, 1, 'cancelled', 'ORD_12111714', '14266914', 30000000, '00', '00', '2024-01-02 00:48:01'),
(30, 1, 11, '2024-01-02', '2024-01-03', 0, 0, 'cancelled', 'ORD_12272507', '14266930', 30000000, '00', '00', '2024-01-02 01:11:07'),
(31, 1, 11, '2024-01-02', '2024-01-03', 1, NULL, 'thành công', 'ORD_16882389', '14266932', 30000000, '00', '00', '2024-01-02 01:11:57'),
(32, 1, 11, '2024-01-02', '2024-01-03', 1, NULL, 'thành công', 'ORD_18241294', '14266936', 30000000, '00', '00', '2024-01-02 01:13:05'),
(33, 1, 11, '2024-01-02', '2024-01-03', 1, NULL, 'thành công', 'ORD_1295839', '14266953', 30000000, '00', '00', '2024-01-02 01:31:10'),
(40, 1, 11, '2024-01-04', '2024-01-05', 0, 0, 'cancelled', 'ORD_15132831', '14269340', 30000000, '00', '00', '2024-01-03 23:23:15'),
(41, 1, 11, '2024-01-04', '2024-01-05', 1, NULL, 'thành công', 'ORD_19029371', '14269345', 30000000, '00', '00', '2024-01-03 23:31:00'),
(42, 1, 10, '2024-01-04', '2024-01-05', 0, 0, 'cancelled', 'ORD_15958345', '14269382', 20000000, '00', '00', '2024-01-04 00:32:04'),
(43, 1, 11, '2024-01-07', '2024-01-08', 0, NULL, 'thành công', 'ORD_15014193', '14274013', 30000000, '00', '00', '2024-01-07 17:45:11'),
(44, 1, 11, '2024-01-07', '2024-01-08', 0, NULL, 'thành công', 'ORD_13999752', '14274014', 30000000, '00', '00', '2024-01-07 17:47:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
