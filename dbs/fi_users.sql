-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 07:48 PM
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
-- Table structure for table `fi_users`
--

CREATE TABLE `fi_users` (
  `safeId` int(11) NOT NULL,
  `systemId` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `mdlname` varchar(50) NOT NULL,
  `majorId` int(2) NOT NULL,
  `hostelId` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `hghschool` varchar(100) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `birthday` date NOT NULL,
  `level` varchar(10) NOT NULL,
  `bio` text NOT NULL,
  `propic` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `studentId` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_users`
--

INSERT INTO `fi_users` (`safeId`, `systemId`, `fname`, `sname`, `mdlname`, `majorId`, `hostelId`, `hometown`, `hghschool`, `gender`, `birthday`, `level`, `bio`, `propic`, `studentId`) VALUES
(1, 1, 'Tatenda', 'Munenge', 'maloka', 2, 2, 'Marondera', 'Fletcher High School', 'M', '1993-02-24', '4.1', 'Studied at Fletcher High School ''1 Lives in Marondera From Marondera Followed by 1 person', 'Snapshot_20151025_1.jpg', '2013050071'),
(4, 4, 'Maya', 'Daniels', 'Tarie', 2, 2, 'Harare', 'Regina Mundi High School', 'F', '0000-00-00', '2.2', 'cool chick', 'IMG-20160119-WA0001.jpg', '2016050088'),
(5, 5, 'natasha', 'munenge', '', 1, 0, '', '', 'F', '0000-00-00', '', '', 'default.jpg', '1234567890'),
(6, 6, 'Claud', 'Makalele', '', 1, 0, '', '', 'M', '0000-00-00', '', '', 'Snapshot_20151025.jpg', '2016050089'),
(7, 7, 'Steven ', 'Masuku', '', 2, 0, '', '', 'M', '0000-00-00', '', '', 'Photo0783.jpg', '2013200'),
(8, 8, 'Lucy', 'Moyo', '', 2, 0, '', '', 'F', '0000-00-00', '', '', 'default.jpg', '3456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_users`
--
ALTER TABLE `fi_users`
  ADD PRIMARY KEY (`safeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_users`
--
ALTER TABLE `fi_users`
  MODIFY `safeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
