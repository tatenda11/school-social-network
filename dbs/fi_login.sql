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
-- Table structure for table `fi_login`
--

CREATE TABLE `fi_login` (
  `userId` int(11) NOT NULL,
  `studentId` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` enum('0','1','2') NOT NULL,
  `signDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_login`
--

INSERT INTO `fi_login` (`userId`, `studentId`, `password`, `status`, `signDate`, `lastLogin`) VALUES
(1, '2013050071', '8699ec3e28394a4fbb52039ad4442932', '0', '2016-03-20 23:29:59', '2016-04-24 17:01:49'),
(2, '2013050072', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-21 20:22:33', '2016-03-21 20:22:33'),
(3, '2013050073', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-21 20:24:33', '2016-03-21 20:24:33'),
(4, '2016050088', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-21 20:30:40', '2016-04-21 08:59:04'),
(5, '1234567890', 'f2c590588026049523c9b1a022fb7e94', '0', '2016-03-22 07:35:13', '2016-03-22 07:35:13'),
(6, '2016050089', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-23 19:20:36', '2016-04-19 17:22:36'),
(7, '2013200', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-27 12:12:22', '2016-04-19 10:59:32'),
(8, '3456789', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-27 12:13:12', '2016-03-27 12:13:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_login`
--
ALTER TABLE `fi_login`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_login`
--
ALTER TABLE `fi_login`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
