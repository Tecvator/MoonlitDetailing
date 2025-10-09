-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 09, 2025 at 09:43 PM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moonlit`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT 'admin',
  `password` longtext NOT NULL,
  `is_super_admin` enum('yes','no') NOT NULL,
  `admin_unique_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_unique_id` (`admin_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `username`, `password`, `is_super_admin`, `admin_unique_id`) VALUES
(1, 'lordphp319@gmail.com', 'John', '$2y$10$Z634vRUmjiyr0rWstXvdPe5We6R8Q4Cwv9HCpyXSJ.arvgo3qohoa', 'yes', 'super_123'),
(2, 'tino@gmail.com', 'Valentine', '$2y$10$Z634vRUmjiyr0rWstXvdPe5We6R8Q4Cwv9HCpyXSJ.arvgo3qohoa', 'no', 'admin_1234');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` varchar(255) DEFAULT NULL,
  `car_type_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `location_type` varchar(50) DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `washing_date` date DEFAULT NULL,
  `washing_time` varchar(255) DEFAULT NULL,
  `payment_receipt` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_id`, `car_type_id`, `product_id`, `price`, `location_type`, `customer_id`, `washing_date`, `washing_time`, `payment_receipt`, `payment_method`, `payment_status`, `created_at`, `updated_at`) VALUES
(7, 'INV-483388-517956', 7, 1, 200.00, 'moonlit', 1, '2025-10-08', NULL, NULL, 'pay_now', 'paid', '2025-10-06 21:13:12', NULL),
(8, 'INV-848733-208737', 8, 1, 100.00, 'moonlit', 1, '2025-10-07', NULL, NULL, 'pay_now', 'paid', '2025-10-07 19:12:51', NULL),
(9, 'INV-154554-42932', 7, 2, 380.00, 'moonlit', 1, '2025-10-07', NULL, NULL, 'pay_now', 'paid', '2025-10-07 19:28:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `car_types`
--

DROP TABLE IF EXISTS `car_types`;
CREATE TABLE IF NOT EXISTS `car_types` (
  `car_id` int NOT NULL AUTO_INCREMENT,
  `car_name` varchar(255) NOT NULL,
  `car_added_by` varchar(255) NOT NULL,
  `car_uniqe_id` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`car_id`),
  UNIQUE KEY `car_uniqe_id` (`car_uniqe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `car_types`
--

INSERT INTO `car_types` (`car_id`, `car_name`, `car_added_by`, `car_uniqe_id`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Sedan / Coupe', '1', 'Car-989282', 'Active', '2025-10-05 11:40:46', '2025-10-07 18:22:19'),
(7, 'SUV / Bakkie', '1', 'Car-687648', 'Active', '2025-10-05 11:40:57', '2025-10-05 11:40:57'),
(8, 'Van', '1', 'Car-498610', 'Active', '2025-10-05 11:41:06', '2025-10-05 11:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `category_unique_id` varchar(255) NOT NULL,
  `category_added_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_unique_id` (`category_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_unique_id`, `category_added_by`, `status`, `created_at`, `updated_at`) VALUES
(14, 'Mobile Detailing Packages', 'Cat-330995', '1', 'Active', '2025-10-05 11:42:49', '2025-10-05 11:42:49'),
(15, 'Maintenance Detailing packages', 'Cat-481461', '1', 'Active', '2025-10-07 18:25:28', '2025-10-07 18:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'John David Okpe', 'lordphp319@gmail.com', '09024388386', '', '2025-10-06 19:50:29', '2025-10-07 19:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `moonlit_admins`
--

DROP TABLE IF EXISTS `moonlit_admins`;
CREATE TABLE IF NOT EXISTS `moonlit_admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(255) NOT NULL,
  `admin_unique_id` varchar(255) NOT NULL,
  `is_super_admin` enum('yes','no') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_unique_id` varchar(255) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_added_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `max_hours` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_unique_id` (`product_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_unique_id`, `category_id`, `product_description`, `product_name`, `product_added_by`, `created_at`, `updated_at`, `max_hours`) VALUES
(1, 'PROD-347130', '14', '<label>Description</label>\r\n							<div><span><span><span tabindex=\"0\"><svg viewBox=\"0 0 18 18\"><polygon points=\"7 11 9 13 11 11 7 11\"></polygon><polygon points=\"7 7 9 5 11 7 7 7\"></polygon></svg></span><span tabindex=\"-1\" id=\"ql-picker-options-0\"><span tabindex=\"0\" data-value=\"1\"></span><span tabindex=\"0\" data-value=\"2\"></span><span tabindex=\"0\" data-value=\"3\"></span><span tabindex=\"0\"></span></span></span><select><option value=\"1\"></option><option value=\"2\"></option><option value=\"3\"></option><option selected=\"selected\"></option></select></span><span><button type=\"button\"><svg viewBox=\"0 0 18 18\"><path d=\"M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z\"></path><path d=\"M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z\"></path></svg></button><button type=\"button\"><svg viewBox=\"0 0 18 18\"><line x1=\"7\" x2=\"13\" y1=\"4\" y2=\"4\"></line><line x1=\"5\" x2=\"11\" y1=\"14\" y2=\"14\"></line><line x1=\"8\" x2=\"10\" y1=\"14\" y2=\"4\"></line></svg></button><button type=\"button\"><svg viewBox=\"0 0 18 18\"><path d=\"M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3\"></path><rect height=\"1\" rx=\"0.5\" ry=\"0.5\" width=\"12\" x=\"3\" y=\"15\"></rect></svg></button><button type=\"button\"><svg viewBox=\"0 0 18 18\"><line x1=\"7\" x2=\"11\" y1=\"7\" y2=\"11\"></line><path d=\"M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z\"></path><path d=\"M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z\"></path></svg></button></span><span><button type=\"button\" value=\"ordered\"><svg viewBox=\"0 0 18 18\"><line x1=\"7\" x2=\"15\" y1=\"4\" y2=\"4\"></line><line x1=\"7\" x2=\"15\" y1=\"9\" y2=\"9\"></line><line x1=\"7\" x2=\"15\" y1=\"14\" y2=\"14\"></line><line x1=\"2.5\" x2=\"4.5\" y1=\"5.5\" y2=\"5.5\"></line><path d=\"M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z\"></path><path d=\"M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156\"></path><path d=\"M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109\"></path></svg></button><button type=\"button\" value=\"bullet\"><svg viewBox=\"0 0 18 18\"><line x1=\"6\" x2=\"15\" y1=\"4\" y2=\"4\"></line><line x1=\"6\" x2=\"15\" y1=\"9\" y2=\"9\"></line><line x1=\"6\" x2=\"15\" y1=\"14\" y2=\"14\"></line><line x1=\"3\" x2=\"3\" y1=\"4\" y2=\"4\"></line><line x1=\"3\" x2=\"3\" y1=\"9\" y2=\"9\"></line><line x1=\"3\" x2=\"3\" y1=\"14\" y2=\"14\"></line></svg></button></span><span><button type=\"button\"><svg viewBox=\"0 0 18 18\"><line x1=\"5\" x2=\"13\" y1=\"3\" y2=\"3\"></line><line x1=\"6\" x2=\"9.35\" y1=\"12\" y2=\"3\"></line><line x1=\"11\" x2=\"15\" y1=\"11\" y2=\"15\"></line><line x1=\"15\" x2=\"11\" y1=\"11\" y2=\"15\"></line><rect height=\"1\" rx=\"0.5\" ry=\"0.5\" width=\"7\" x=\"2\" y=\"14\"></rect></svg></button></span></div><div><div contenteditable=\"true\"><p><br></p></div><div><a rel=\"noopener noreferrer\" target=\"_blank\" href=\"about:blank\"></a><input type=\"text\" data-formula=\"e=mc^2\" data-link=\"https://quilljs.com\" data-video=\"Embed URL\"><a></a><a></a></div></div>\r\n							<p>Maximum 60 Words</p>', 'Mini Detail', '1', '2025-10-06 18:10:30', '2025-10-06 18:10:30', NULL),
(2, 'PROD-593678', '15', '<p>Maintenance Detailing site </p>', 'Maintenance Detailing', '1', '2025-10-07 18:27:26', '2025-10-07 18:27:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_features`
--

DROP TABLE IF EXISTS `product_features`;
CREATE TABLE IF NOT EXISTS `product_features` (
  `id` int NOT NULL AUTO_INCREMENT,
  `feature` varchar(255) NOT NULL,
  `is_interior` enum('yes','no') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

DROP TABLE IF EXISTS `product_prices`;
CREATE TABLE IF NOT EXISTS `product_prices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `price_unique_id` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `price_added_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` varchar(255) DEFAULT NULL,
  `car_type_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `price_unique_id` (`price_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_prices`
--

INSERT INTO `product_prices` (`id`, `price_unique_id`, `price`, `price_added_by`, `created_at`, `updated_at`, `product_id`, `car_type_id`) VALUES
(6, 'PRi-825839', '100', '1', '2025-10-06 17:58:53', '2025-10-06 17:58:53', NULL, NULL),
(9, 'PRi-876546', '100', '1', '2025-10-06 18:04:42', '2025-10-06 18:04:42', NULL, NULL),
(11, 'PRi-882002', '100', '1', '2025-10-06 18:10:30', '2025-10-06 18:10:30', '1', '8'),
(12, 'PRi-786301', '200', '1', '2025-10-06 18:10:30', '2025-10-06 18:10:30', '1', '7'),
(13, 'PRi-660606', '300', '1', '2025-10-06 18:10:30', '2025-10-06 18:10:30', '1', '6'),
(14, 'PRi-862331', '400', '1', '2025-10-07 18:27:26', '2025-10-07 18:27:26', '2', '8'),
(15, 'PRi-767026', '380', '1', '2025-10-07 18:27:26', '2025-10-07 18:27:26', '2', '7'),
(16, 'PRi-655103', '350', '1', '2025-10-07 18:27:26', '2025-10-07 18:27:26', '2', '6');

-- --------------------------------------------------------

--
-- Table structure for table `site_info`
--

DROP TABLE IF EXISTS `site_info`;
CREATE TABLE IF NOT EXISTS `site_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `site_address` varchar(255) NOT NULL,
  `site_email` varchar(255) NOT NULL,
  `site_phone` varchar(255) NOT NULL,
  `site_city` varchar(255) NOT NULL,
  `site_lat` varchar(255) NOT NULL,
  `site_lon` varchar(255) NOT NULL,
  `site_state` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `site_info`
--

INSERT INTO `site_info` (`id`, `site_name`, `site_logo`, `site_address`, `site_email`, `site_phone`, `site_city`, `site_lat`, `site_lon`, `site_state`, `created_at`, `updated_at`) VALUES
(1, 'Moon Lit', 'http://localserver/moonlit_dashboard/html/template/process/uploads/1759861176_WhatsApp_Image_2025-09-25_at_1.02.04_PM.jpeg', 'kuru', 'lordphp319@gmail.com', '09024388386', 'Karu', '74673648934', '67930303', 'jokwoyi', '2025-09-28 07:38:30', '2025-09-28 07:38:30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
