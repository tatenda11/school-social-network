-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 07:55 PM
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
-- Table structure for table `fi_comments`
--

CREATE TABLE `fi_comments` (
  `commentId` int(11) NOT NULL,
  `userId` int(5) NOT NULL,
  `comment` text NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_comments`
--

INSERT INTO `fi_comments` (`commentId`, `userId`, `comment`, `commentDate`, `postId`) VALUES
(1, 1, 'ko ndeipi', '2016-04-16 18:26:16', 18),
(2, 1, 'zviri sei sei', '2016-04-16 19:16:55', 18),
(3, 7, 'maya musieyiyi boyz', '2016-04-17 11:39:27', 18),
(4, 1, 'so what', '2016-04-21 19:41:41', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_comments`
--
ALTER TABLE `fi_comments`
  ADD PRIMARY KEY (`commentId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_comments`
--
ALTER TABLE `fi_comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
