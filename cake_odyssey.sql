-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 23, 2026 at 04:27 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cake_odyssey`
--

-- --------------------------------------------------------

--
-- Table structure for table `cakes`
--

DROP TABLE IF EXISTS `cakes`;
CREATE TABLE IF NOT EXISTS `cakes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cake_type` enum('custom','kilo') COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `base_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cakes`
--

INSERT INTO `cakes` (`id`, `name`, `cake_type`, `size`, `image`, `description`, `base_price`, `created_at`) VALUES
(1, 'Velvet Berry Delight', 'kilo', '1 KG', '1700000001.jpg', 'Red velvet layers with organic cream cheese frosting and fresh berries.', 4500.00, '2026-08-13 18:29:14'),
(2, 'Royal Chocolate Truffle', 'custom', 'Medium', '1700000002.jpg', 'Decadent dark chocolate ganache cake infused with espresso caramel.', 5200.00, '2026-08-13 18:29:14'),
(3, 'Vanilla Bean Mousse', 'kilo', '1 KG', 'fa-wand-magic-sparkles', 'Madagascar vanilla sponge layered with light white chocolate mousse.', 3800.00, '2026-08-13 18:29:14'),
(4, 'Mango Passionfruit Mousse', 'kilo', '1.5 KG', 'fa-lemon', 'Tropical mango puree layers paired with tangy passionfruit curd.', 4800.00, '2026-08-13 18:29:14'),
(5, 'Hazelnut Praline Dream', 'custom', 'Large', 'fa-gift', 'Crunchy hazelnut praline with Belgian milk chocolate sponge layers.', 5500.00, '2026-08-13 18:29:14'),
(6, 'Strawberry Shortcake Supreme', 'kilo', '1 KG', '1786648056_973.jpg', 'Fluffy Japanese sponge filled with fresh farm strawberries & sweet cream.', 4200.00, '2026-08-13 18:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `cake_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `weight_kg` decimal(4,2) NOT NULL DEFAULT '1.00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `cake_id` (`cake_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','paid','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `due_date`, `status`, `created_at`) VALUES
(1, 9, 5200.00, '2026-08-18', 'pending', '2026-08-13 19:33:01'),
(2, 9, 18100.00, '2026-08-16', 'pending', '2026-08-13 19:45:10'),
(3, 9, 71000.00, '2026-08-16', 'pending', '2026-08-14 05:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `cake_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `weight_kg` decimal(4,2) NOT NULL,
  `price_locked` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `cake_id` (`cake_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `cake_id`, `quantity`, `weight_kg`, `price_locked`) VALUES
(1, 1, 2, 1, 1.00, 5200.00),
(2, 2, 1, 1, 1.00, 4500.00),
(3, 2, 2, 1, 1.00, 5200.00),
(4, 2, 6, 2, 1.00, 4200.00),
(5, 3, 2, 5, 1.00, 5200.00),
(6, 3, 1, 10, 1.00, 4500.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_number` (`mobile_number`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `mobile_number`, `password`, `role`, `created_at`) VALUES
(9, 'customer', 'No.123, Kuliyapitiya', '0761234567', '123456', 'customer', '2026-08-13 18:42:36'),
(8, 'Isuru Kulasooriya', 'No 34/2/A, Kirawewa, Ilukhena', '0766961896', '123456', 'admin', '2026-08-13 08:58:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
