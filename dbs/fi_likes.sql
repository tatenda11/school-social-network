-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 07:52 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `solusi_fi2`
--

-- --------------------------------------------------------

--
-- Table structure for table `fi_likes`
--

CREATE TABLE `fi_likes` (
  `likeId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `likeTyp` varchar(3) NOT NULL,
  `userId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_likes`
--

INSERT INTO `fi_likes` (`likeId`, `itemId`, `likeTyp`, `userId`) VALUES
(7, 15, 'P', 1),
(13, 18, 'P', 7),
(14, 23, 'P', 4),
(15, 22, 'P', 4),
(16, 21, 'P', 1),
(21, 22, 'P', 1),
(26, 11, 'P', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_likes`
--
ALTER TABLE `fi_likes`
  ADD PRIMARY KEY (`likeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_likes`
--
ALTER TABLE `fi_likes`
  MODIFY `likeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
