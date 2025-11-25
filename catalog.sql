-- phpMyAdmin SQL Dump
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2017 at 04:49 PM
-- Server Version: 5.5.53
-- PHP Version: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catalog_ecommerce`
--
CREATE DATABASE IF NOT EXISTS `catalog_ecommerce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `catalog_ecommerce`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
                            `id` int(11) NOT NULL,
                            `name` varchar(255) NOT NULL,
                            `sort_order` int(11) NOT NULL DEFAULT '0',
                            `status` int(11) NOT NULL DEFAULT '1' COMMENT '0=Disabled, 1=Enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category` (Improved Demo Data)
--

INSERT INTO `category` (`id`, `name`, `sort_order`, `status`) VALUES
                                                                  (1, 'Laptops', 10, 1),
                                                                  (2, 'Tablets & E-Readers', 20, 1),
                                                                  (3, 'Monitors', 30, 1),
                                                                  (4, 'Gaming PCs', 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
                            `id` int(11) NOT NULL COMMENT 'Product Identifier',
                            `title` varchar(255) DEFAULT NULL COMMENT 'Product Name',
                            `category_id` int(11) NOT NULL COMMENT 'Primary Category ID',
                            `code` varchar(50) NOT NULL COMMENT 'Product Code/SKU',
                            `price` decimal(10,2) NOT NULL COMMENT 'Standard Price',
                            `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Promotional or Sale Price',
                            `availability` int(11) NOT NULL COMMENT 'Stock Availability (e.g., 0=Out of Stock, 1=In Stock)',
                            `brand` varchar(255) NOT NULL COMMENT 'Brand or Manufacturer',
                            `description` text NOT NULL COMMENT 'Full Product Description',
                            `is_new` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Display NEW badge',
                            `is_recommended` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Display in Recommended section',
                            `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Visible in lists, 0=Hidden',
                            `seo_breadcrumbs` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO Breadcrumbs path',
                            `seo_metatags` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta tags for site header (SEO)',
                            `categories_json` text NOT NULL COMMENT 'JSON array of all category IDs (for multi-category support)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products` (Improved Demo Data)
--

INSERT INTO `products` (`id`, `title`, `category_id`, `code`, `price`, `sale_price`, `availability`, `brand`, `description`, `is_new`, `is_recommended`, `status`, `seo_breadcrumbs`, `seo_metatags`, `categories_json`) VALUES
                                                                                                                                                                                                                             (101, 'Dell XPS 13 (9315)', 1, 'DEXPS9315', 1299.99, 1199.99, 10, 'Dell', '13.4" FHD+ InfinityEdge display, 12th Gen Intel i7, 16GB RAM, 512GB SSD. Perfect for professionals.', 1, 1, 1, 'Laptops > Dell XPS', 'dell xps 13, thin laptop, intel i7', '["1"]'),
                                                                                                                                                                                                                             (102, 'Samsung Galaxy Tab S9', 2, 'SMTAB9G', 799.00, 0.00, 5, 'Samsung', '11-inch Dynamic AMOLED 2X display, Snapdragon 8 Gen 2, S Pen included. Great for creative work.', 0, 1, 1, 'Tablets > Samsung', 'galaxy tab s9, android tablet, s pen', '["2"]'),
                                                                                                                                                                                                                             (103, 'LG UltraGear 27GR95QE', 3, 'LGUG27OLED', 999.50, 899.00, 3, 'LG', '27-inch UltraGear OLED Gaming Monitor, 240Hz refresh rate, 0.03ms response time. Ultimate gaming performance.', 1, 0, 1, 'Monitors > Gaming', 'oled monitor, 240hz, ultragear', '["3"]'),
                                                                                                                                                                                                                             (104, 'HP Victus Gaming Desktop', 4, 'HPVGD2024', 1850.00, 0.00, 0, 'HP', 'RTX 4070, AMD Ryzen 7, 32GB RAM. High-end PC for modern gaming titles.', 0, 0, 1, 'Gaming PCs > Desktop', 'rtx 4070, gaming pc, ryzen 7', '["4"]'),
                                                                                                                                                                                                                             (105, 'Lenovo Yoga Slim 7 Carbon', 1, 'LYSCARB7', 950.00, 0.00, 1, 'Lenovo', 'Ultra-lightweight 14" laptop with QHD+ display. Ideal for travel.', 0, 1, 1, 'Laptops > Lenovo', 'yoga slim, carbon laptop', '["1"]');

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
                                 `id` int(11) NOT NULL,
                                 `user_name` varchar(255) NOT NULL,
                                 `user_phone` varchar(255) NOT NULL,
                                 `user_comment` text NOT NULL,
                                 `user_id` int(11) DEFAULT NULL COMMENT 'Optional Foreign Key to user table',
                                 `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                 `products_json` text NOT NULL COMMENT 'JSON string of purchased products (e.g., {"product_id": quantity})',
                                 `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=New, 2=Processing, 3=Shipped, 4=Completed, 5=Cancelled'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_order` (Simplified Demo Data)
--

INSERT INTO `product_order` (`id`, `user_name`, `user_phone`, `user_comment`, `user_id`, `date`, `products_json`, `status`) VALUES
                                                                                                                                (1, 'Jane Doe', '+1-555-1234', 'Please deliver after 5 PM.', 4, '2025-11-20 10:30:00', '{"101":1,"102":1}', 3),
                                                                                                                                (2, 'John Smith', '+44-207-9460', '', 0, '2025-11-25 15:45:00', '{"105":2,"103":1}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
                        `id` int(11) NOT NULL,
                        `name` varchar(255) NOT NULL,
                        `email` varchar(255) NOT NULL,
                        `password` varchar(255) NOT NULL COMMENT 'Hashed password',
                        `role` varchar(50) NOT NULL COMMENT 'e.g., admin, customer, moderator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user` (Improved Demo Data)
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`) VALUES
                                                                   (1, 'Admin User', 'admin@store.com', '$2y$10$42.q9R8f5/wF8J2M/9d0K.O8wL5.3gD0p7B0rC8s0M9j8H8e7O7j.', 'admin'), -- Password: 'password123' (hashed)
                                                                   (2, 'Test Customer', 'customer@test.com', '$2y$10$rC8s0M9j8H8e7O7j42.q9R8f5/wF8J2M/9d0K.O8wL5.3gD0p7B0rC', 'customer'); -- Password: 'testpassword' (hashed)

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Product Identifier', AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;