-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2019 at 07:03 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `username` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `orderdate` date NOT NULL,
  `pro_code` int(10) NOT NULL,
  `pro_qty` int(10) NOT NULL,
  `pro_price` float NOT NULL,
  `mobile` varchar(11) COLLATE utf8_persian_ci NOT NULL,
  `address` varchar(400) COLLATE utf8_persian_ci NOT NULL,
  `trackcode` varchar(24) COLLATE utf8_persian_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `username`, `orderdate`, `pro_code`, `pro_qty`, `pro_price`, `mobile`, `address`, `trackcode`, `state`) VALUES
(0, 'admin', '2019-05-12', 5, 5, 20000000, '09300725768', 'Ø§Ø±ÙˆÙ…ÛŒÙ‡-Ø® Ú©ÙˆÙ‡Ù†ÙˆØ±Ø¯-Ú©ÙˆÛŒ59', '00000000000000000000000', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pro_code` int(10) NOT NULL,
  `pro_name` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `pro_qty` int(10) NOT NULL,
  `pro_price` float NOT NULL,
  `pro_image` varchar(20000) COLLATE utf8_persian_ci NOT NULL,
  `pro_detail` text COLLATE utf8_persian_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_code`, `pro_name`, `pro_qty`, `pro_price`, `pro_image`, `pro_detail`) VALUES
(2, 'calculator', 10, 500000, '28589Project-Accounting.jpg', 'lsxnzjxmkcv '),
(1, 'board', 20, 8000000, 'board.jpg', ';ldl,cmkdsmv x'),
(3, 'loptop', 5, 30000000, '2868606.jpg', 'x,nfvbhnzcvcxn'),
(5, 'case', 5, 20000000, '1x13.jpg', 'saxvcxv'),
(6, 'mouse', 10, 3000000, '1images (2).jpg', 'hsgsgsgs'),
(7, 'case', 4, 40000000, '111657-2.jpg', 'dcdffvgf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `realname` varchar(25) COLLATE utf8_persian_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(8) COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_persian_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`realname`, `username`, `password`, `email`, `type`) VALUES
('admin', 'admin', '10111213', 'admin@email.com', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
