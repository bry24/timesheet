-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2023 at 12:31 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_timesheet`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `datetime_add` datetime NOT NULL DEFAULT current_timestamp(),
  `datetime_upd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `last_name`, `created_by`, `datetime_add`, `datetime_upd`) VALUES
(40, 'Jon', 'Smith', 1, '2023-02-24 12:30:16', '2023-02-24 11:52:15'),
(42, 'Luke', 'Dell', 1, '2023-02-24 16:49:09', '2023-02-24 11:52:45');

-- --------------------------------------------------------

--
-- Table structure for table `time_records`
--

CREATE TABLE `time_records` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `datetime_add` datetime NOT NULL DEFAULT current_timestamp(),
  `time_in` datetime NOT NULL DEFAULT current_timestamp(),
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `time_records`
--

INSERT INTO `time_records` (`id`, `employee_id`, `user_id`, `datetime_add`, `time_in`, `time_out`) VALUES
(36, 40, 1, '2023-02-24 18:50:41', '2023-02-24 18:50:41', '2023-02-24 11:50:44'),
(37, 40, 1, '2023-02-24 18:51:27', '2023-02-24 18:51:27', '2023-02-24 11:51:30'),
(38, 42, 1, '2023-02-24 19:03:05', '2023-02-24 19:03:05', NULL),
(39, 40, 12, '2023-02-24 19:27:54', '2023-02-24 19:27:54', '2023-02-24 12:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` text NOT NULL,
  `user_type` tinyint(4) NOT NULL,
  `datetime_add` datetime NOT NULL DEFAULT current_timestamp(),
  `datetime_upd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_password`, `user_type`, `datetime_add`, `datetime_upd`) VALUES
(1, 'Kirby', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 1, '2023-02-23 00:10:26', '2023-02-23 20:57:17'),
(12, 'Mike', '7501dcc21e6a5a7200115e41d8886948884824dc', 2, '2023-02-23 21:41:32', '2023-02-24 11:46:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_records`
--
ALTER TABLE `time_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `time_records`
--
ALTER TABLE `time_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
