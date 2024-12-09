-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 09, 2024 at 12:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booknest`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `seller_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `book_category` varchar(50) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `book_name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `wallet_name` varchar(100) DEFAULT NULL,
  `wallet_number` varchar(50) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `payment_reference` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `seller_name`, `email`, `book_category`, `level`, `class`, `book_name`, `author`, `price`, `discount`, `isbn`, `photo`, `description`, `payment_method`, `bank_name`, `account_number`, `wallet_name`, `wallet_number`, `qr_code`, `payment_reference`, `status`) VALUES
(23, 'joyesh', 'joyesh@gmail.com', 'Academic', 'bachelor (BCA)', '4rth sem', 'Operating system', 'Bhupendra Singh Saud ', 400.00, 20, '9789937724715', '../uploads/WhatsApp Image 2024-12-09 at 12.55.54_b25c8552.jpg', 'good condition', '', NULL, NULL, NULL, NULL, NULL, NULL, 'approved'),
(24, 'joyesh', 'joyesh@gmail.com', 'Academic', 'bachelor (BCA)', '4rth sem', 'Database management system ', 'Bhupendra Singh Saud ', 550.00, 20, '9789937724753', '../uploads/WhatsApp Image 2024-12-09 at 12.55.56_166c9c7a.jpg', 'Nice condition', '', NULL, NULL, NULL, NULL, NULL, NULL, 'approved'),
(25, 'joyesh', 'joyesh@gmail.com', 'Academic', 'bachelor (BCA)', '4rth sem', 'Scripting langauge ', 'Ramesh Singh Saud ', 495.00, 30, '9789937724746', '../uploads/WhatsApp Image 2024-12-09 at 12.55.55_a2dceddb.jpg', 'good', '', NULL, NULL, NULL, NULL, NULL, NULL, 'approved'),
(26, 'joyesh', 'joyesh@gmail.com', 'Academic', 'bachelor (BCA)', '4rth sem', 'Software Engineering ', 'Ramesh Singh Saud ', 495.00, 35, '9789937827935', '../uploads/WhatsApp Image 2024-12-09 at 12.55.55_5a39fabf.jpg', 'hello', '', NULL, NULL, NULL, NULL, NULL, NULL, 'approved'),
(27, 'joyesh', 'joyesh@gmail.com', 'Academic', 'bachelor (BCA)', '4rth sem', 'Numerical method ', 'Arjun singh Saud ', 495.00, 40, '9789937724722', '../uploads/WhatsApp Image 2024-12-09 at 12.55.55_41ff2787.jpg', 'good ', '', NULL, NULL, NULL, NULL, NULL, NULL, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `message`, `submitted_at`, `email`, `subject`) VALUES
(1, 'Guest', 'enhance ui ', '2024-12-09 07:54:01', 'helpmail@gmail.com', 'enhance ui');

-- --------------------------------------------------------

--
-- Table structure for table `financial_records`
--

CREATE TABLE `financial_records` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_records`
--

INSERT INTO `financial_records` (`id`, `date`, `type`, `category`, `amount`, `description`, `created_at`, `payment_method`) VALUES
(7, '2024-12-03', 'income', 'Bank charge ', 100.00, 'Bank charge ', '2024-12-03 14:20:12', 'digital_wallet');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `pidx` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `purchase_order_id` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `municipality` varchar(100) DEFAULT NULL,
  `ward_no` int(11) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `job_type` enum('Student','Employed') DEFAULT NULL,
  `college_name` varchar(255) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `post` varchar(100) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `face_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `created_at`, `avatar`, `full_name`, `district`, `municipality`, `ward_no`, `phone_number`, `job_type`, `college_name`, `level`, `subject`, `company_name`, `post`, `role`, `face_data`) VALUES
(21, 'nabarajacharya999@gmail.com', 'user', '$2y$10$XdxqbhWNX.uO1tBARhsGIeVi/CGTnV2g5JDDNF8sLLGM4YDrpuGoK', '2024-11-18 11:10:57', 'my photo.jpg', 'Nabaraj Acharya ', 'Khotang ', 'Diktel Rupakot Municipality -', 1, '986-1404979', 'Student', 'Jana Bhawana Campus', 'bachelor (BCA)', 'BCA', NULL, NULL, 'user', NULL),
(22, 'nepal999@gmail.com', 'Admin', '$2y$10$dRwIJHwtxzsLJhHq3F2YP.TPCB107GfFojW72Z6l0D3b4IyR9w9tC', '2024-11-18 11:53:14', '454019003_835737745290146_8039057100654537596_n.jpg', 'nabaraj acharya', 'Khotang ', 'Diktel Rupakot Municipality -1', 1, '986-1404971', 'Student', 'Jana Bhawana Campus', 'bachelor (BBS)', 'BCA', NULL, NULL, 'admin', NULL),
(23, 'joyesh@gmail.com', 'joyesh', '$2y$10$vhNUULKWMbV0TysVb5OXVe8fKSf2ZU8i5FO/RSNAsVpJ6ZdN8LGPW', '2024-12-04 01:35:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_records`
--
ALTER TABLE `financial_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `financial_records`
--
ALTER TABLE `financial_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
