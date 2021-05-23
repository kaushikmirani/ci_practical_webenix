-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2021 at 07:33 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_practical_webenix`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `price` float(10,2) NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `name`, `image`, `description`, `price`, `category_id`, `added_on`, `updated_on`) VALUES
(1, 'product1', 'mercedesbenz_mercedes_silver_130560_3840x2160.jpg', 'product desc1 dfdsf sfsd', 10.50, 4, '2021-05-21 00:00:00', '2021-05-23 13:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_category`
--

CREATE TABLE `tbl_product_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `description` mediumtext NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_category`
--

INSERT INTO `tbl_product_category` (`id`, `name`, `description`, `added_on`, `updated_on`) VALUES
(2, 'Test1', 'test desc1 afsad dsfsd ', '2021-05-21 00:00:00', '2021-05-23 14:10:07'),
(3, 'Test2', 'test desc2', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(4, 'Test3', 'test desc3', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(8, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(9, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(10, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(11, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(12, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(13, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(14, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(15, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(16, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(17, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(18, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(19, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(20, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(21, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(22, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(23, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(24, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(25, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(26, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(27, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(28, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(29, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(30, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(31, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(32, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(33, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(34, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(35, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(36, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(37, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(38, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(39, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(40, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(41, 'Test4', 'test desc4', '2021-05-21 00:00:00', '2021-05-21 00:00:00'),
(44, 'test category from api12345', 'test category from api desc', '2021-05-23 17:14:14', '2021-05-23 18:16:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`) USING BTREE;

--
-- Indexes for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `tbl_product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
