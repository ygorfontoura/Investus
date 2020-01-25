-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2020 at 02:35 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `investus`
--
CREATE DATABASE IF NOT EXISTS `investus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `investus`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `pwd` text NOT NULL,
  `phone` text NOT NULL,
  `api_key` text NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user_avatar` varchar(18) NOT NULL DEFAULT 'default.png',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `pwd`, `phone`, `api_key`, `active`, `user_avatar`, `created_at`) VALUES
(1, 'Katrinah Jozefinah', 'katnah@mail.com', '$2y$10$1umhkj8W2l9nOFKJ1vw76.BdZ2q684xZbJK8fZwysBxeFEEmW14eK', '939939939', '4b0f016b0f856e8fd683b2e0111d70e28efde32e71e1dd5a9b02284ed05f6d00', 1, '5e2b5c6c24762.jpg', '2020-01-24 01:51:09'),
(501, 'John R. Cash', 'johnycash@mail.com', '$2y$10$weSde5tL/TMXEwl.9Y4ETu5fL6w8n5Ec.3ml0egmwPC8IvZ6lX9Py', '999999999', '6af929decf7588870a28ad1e7158aa17c04a6646cab2c856dd88ebe7d93eb54b', 1, 'default.png', '2020-01-24 01:53:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=504;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
