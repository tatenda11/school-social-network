-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 07:53 PM
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
-- Table structure for table `fi_friends`
--

CREATE TABLE `fi_friends` (
  `friendshipId` int(11) NOT NULL,
  `friendDate` date NOT NULL,
  `friendFrom` int(5) NOT NULL,
  `friendTo` int(5) NOT NULL,
  `status` enum('A','D','P') NOT NULL DEFAULT 'P'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_friends`
--

INSERT INTO `fi_friends` (`friendshipId`, `friendDate`, `friendFrom`, `friendTo`, `status`) VALUES
(1, '2016-04-16', 1, 6, 'P'),
(2, '2016-04-16', 1, 7, 'P'),
(6, '2016-04-17', 7, 6, 'P'),
(7, '2016-04-17', 7, 8, 'P'),
(8, '2016-04-19', 4, 1, 'P'),
(9, '2016-04-20', 4, 5, 'P');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_friends`
--
ALTER TABLE `fi_friends`
  ADD PRIMARY KEY (`friendshipId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_friends`
--
ALTER TABLE `fi_friends`
  MODIFY `friendshipId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
