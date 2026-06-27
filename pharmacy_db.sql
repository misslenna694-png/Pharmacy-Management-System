-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06 يونيو 2026 الساعة 00:34
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy_db`
--

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(2, 'عام', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `expiry_date` date NOT NULL,
  `image_path` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `category_id`, `price`, `quantity`, `expiry_date`, `image_path`) VALUES
(2, 'Panadol', 2, 14.00, 39, '0000-00-00', 'Panadole.jfif'),
(3, 'Prastmol', 1, 7.00, 29, '0000-00-00', 'paracetamol.jfif'),
(5, 'Demra', 1, 15.00, 17, '0000-00-00', 'Demra.jfif'),
(6, 'Betaderm', 1, 10.00, 7, '0000-00-00', 'Betaderm.jfif'),
(8, 'Vitamin C', 1, 9.00, 20, '0000-00-00', 'Vitamin C.jfif'),
(9, 'Adol', 1, 11.00, 20, '0000-00-00', 'Adol.jfif'),
(10, 'Augmentin', 1, 18.00, 39, '0000-00-00', 'Augmentin.jfif'),
(11, 'Otrivin', 1, 5.00, 56, '0000-00-00', 'Otrivin.jfif'),
(12, 'Brufen', 1, 6.00, 30, '0000-00-00', 'Brufen.jfif'),
(13, 'Motilium', 1, 13.00, 25, '0000-00-00', 'Motilium.jfif'),
(15, 'Voltaren', 1, 20.00, 40, '0000-00-00', 'Voltaren.jfif');

-- --------------------------------------------------------

--
-- بنية الجدول `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `medicine_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `total_amount`, `sale_date`, `medicine_id`) VALUES
(7, NULL, 28.00, '2026-06-01 17:03:03', 0),
(8, NULL, 14.00, '2026-06-01 17:03:10', 0),
(11, NULL, 7.00, '2026-06-03 20:41:14', 0),
(12, NULL, 30.00, '2026-06-03 20:42:48', 0),
(14, 8, 0.00, '2026-06-04 23:19:06', 8),
(15, 8, 0.00, '2026-06-05 19:54:11', 6),
(23, NULL, 10.00, '2026-06-05 20:57:45', 0),
(24, NULL, 10.00, '2026-06-05 20:58:01', 0),
(25, NULL, 10.00, '2026-06-05 20:58:15', 0);

-- --------------------------------------------------------

--
-- بنية الجدول `sale_details`
--

CREATE TABLE `sale_details` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `medicine_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `medicine_id`, `quantity`, `price_per_unit`) VALUES
(1, 7, 2, 2, 0.00),
(2, 8, 2, 1, 0.00),
(4, 11, 3, 1, 0.00),
(5, 12, 5, 2, 0.00),
(6, 23, 6, 1, 0.00),
(7, 24, 6, 1, 0.00),
(8, 25, 6, 1, 0.00);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pharmacist') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(3, 'admin1', '$2a$12$ZTYf4xKt9YEC/j3MONifVuByuqhduhFw/6xfkDFwYjlTWU4Ufw7eu', 'admin', '2026-06-01 20:43:54'),
(8, 'User', '$2y$10$sQGd0.SJdBoRNl8wIEJzxOSaLwZIJUwbS136ItFfLhCbTKdt80h3K', 'pharmacist', '2026-06-03 21:57:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- قيود الجداول `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- قيود الجداول `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_details_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
