-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 04:39 PM
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
-- Database: `aquiladb`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `applied_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `applied_job` varchar(255) NOT NULL,
  `status` enum('In Process','Selected','Rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `name`, `applied_date`, `email`, `age`, `contact_number`, `applied_job`, `status`) VALUES
(7, 'Joseph Paulo Afalla', '2024-11-13', 'pauloafalla@gmail.com', 69, '09090909', 'Developer', 'Rejected'),
(8, 'Carlos Gamil', '2024-11-13', 'carlos@gmail.com', 21, '09612179566', 'Back-End Developer', 'In Process'),
(9, 'Dexter Cui', '2024-11-13', 'cdex@gmail.com', 21, '092022020', 'Front-End Developer', 'Selected');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `project_name` varchar(20) NOT NULL,
  `appointment_date` date NOT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `project_name`, `appointment_date`, `created_at`) VALUES
(16, '1', 'paulo ', '2024-11-22', '2024-11-09'),
(18, '3', 'need wifi', '2024-11-22', '2024-11-13'),
(20, '3', 'wifi service', '2024-11-30', '2024-11-13'),
(24, '3', 'vpn service', '2024-11-29', '2024-11-13');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` int(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `salary` double(15,3) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `last_name`, `age`, `city`, `position`, `salary`, `email`, `phone`) VALUES
(5, 'Carlos Eduardo', 'Gamil', 22, 'Quezon City', 'Back-End Developer', 28000.000, 'adoygamil@gmail.com', '0916457830'),
(7, 'Dexter', 'Cui', 22, 'Taguig City', 'Front-End Developer', 24000.000, 'gg@gmail.com', '1'),
(8, 'Joseph Paulo', 'Afalla', 21, 'Makati City', 'Front-End Developer', 25000.000, 'pauloafalla@gmail.com', '09612179566'),
(9, 'Diana Ross', 'Gamil', 29, 'Quezon City', 'HR', 36000.000, 'dianaross@gmail.com', '0933232323');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `role` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `username`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'client', 'clgamil', 'carlos', 'gamil', 'gamilcarloseduardof@gmail.com', '$2y$10$5I1bpYxDxKkVuuqPr0l53edVSGTyrKUhgnsEWFhCxvw9PtN9WzjfS'),
(2, 'admin', 'admin1', 'ralph', 'gamil', 'ralph.gamil@gmail.com', '$2y$10$/ENLoGnn53yJiQg.NRqvr.T2MNNCTDeAsXoNC3Lw5Bj/5tYztJNvm'),
(3, 'client', 'cljohn', 'John', 'Peru', 'johnperu@gmail.com', '$2y$10$4aWoi80MqmPIs0AfcSd94uLjjGnVLuJS5WqgytG0hsGpKSIp9Agfm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
