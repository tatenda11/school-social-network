-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 07:50 PM
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
-- Table structure for table `fi_notes`
--

CREATE TABLE `fi_notes` (
  `notesId` int(11) NOT NULL,
  `safename` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `course` varchar(255) NOT NULL DEFAULT 'default',
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_notes`
--

INSERT INTO `fi_notes` (`notesId`, `safename`, `description`, `course`, `uploadDate`, `userId`) VALUES
(1, 'cpp_tutorial.pdf', 'database fandumentals', 'default', '2016-04-21 09:19:06', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_notes`
--
ALTER TABLE `fi_notes`
  ADD PRIMARY KEY (`notesId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_notes`
--
ALTER TABLE `fi_notes`
  MODIFY `notesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
