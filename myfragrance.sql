-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 12, 2025 at 05:05 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myfragrance`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(10, 2, 12, 1, '2025-05-12 16:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_method` enum('cash_on_delivery','credit_card') NOT NULL DEFAULT 'cash_on_delivery',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `total_price`, `created_at`, `payment_method`) VALUES
(1, 1, 6, 1, 199.99, '2025-05-12 15:24:55', 'cash_on_delivery'),
(2, 2, 1, 1, 120.99, '2025-05-12 15:26:50', 'cash_on_delivery'),
(3, 2, 1, 1, 120.99, '2025-05-12 15:29:10', 'cash_on_delivery'),
(4, 2, 1, 3, 362.97, '2025-05-12 15:36:03', 'cash_on_delivery'),
(5, 2, 10, 1, 150.00, '2025-05-12 15:43:23', 'credit_card'),
(6, 2, 11, 1, 160.00, '2025-05-12 16:05:47', 'cash_on_delivery'),
(7, 3, 6, 1, 199.99, '2025-05-12 16:17:49', 'credit_card'),
(8, 1, 10, 5, 750.00, '2025-05-12 16:50:38', 'cash_on_delivery');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int DEFAULT '0',
  `brand` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','unisex') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category`, `image`, `created_at`, `quantity`, `brand`, `gender`) VALUES
(1, 'Sauvage Elixir', 'A premium fragrance.', 120.92, 'Mens Perfumes', 'product1.png', '2022-04-14 23:00:00', 8, 'Sauvage', 'male'),
(6, 'Erba Pura', 'A premium fragrance.', 199.99, 'Unisex Perfumes', 'product2.png', '2025-05-12 14:47:15', 4, 'Xerjoff', 'unisex'),
(11, 'Le Male Elixir', 'Jean Paul Gaultier perfumes', 160.00, 'Mens Perfumes', 'product4', '2025-05-12 15:53:13', 7, 'Jean Paul Gaultier', 'male'),
(10, 'The One', 'A premium fragrance.', 150.00, 'Mens Perfumes', 'product3.png', '2025-05-12 14:48:36', 10, 'DOLCE&GABBANA', 'male'),
(12, 'Uomo Born in Roma', 'Valentino perfumes', 110.50, 'Winter', 'product5', '2025-05-12 16:10:27', 15, 'Valentino', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','client') DEFAULT 'client',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'Skimo', '$2y$10$Tg43gFGnF/EEJi6TPWUFseNgOaiVLPip8rrwXs1r0lX7idCiQHfYW', 'skimox@gmail.com', 'admin', '2025-05-12 13:58:36'),
(2, 'Imad', '$2y$10$msVX0uNdNx.Nz/BeydZG6upmd524UsjNRqE8mUdU1kw8XPfTq4Vxa', 'imadtaj@gmail.com', 'client', '2025-05-12 15:26:29'),
(3, 'Lamiae', '$2y$10$WvWAGMXbsk5VB.MsUCJMn.vZZAwTifmGtmZkTWKzk8nbzHmsdlpHu', 'lamiae2002@gmail.com', 'client', '2025-05-12 16:17:32'),
(4, 'Taha', '$2y$10$jAq5D5OixmTlthb7fQ/zyeBRTNUOr/Ec0SLEBi9j9awaeYu4BA/si', 'abouabdilahtaha@gmail.com', 'admin', '2025-05-12 16:47:48');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
