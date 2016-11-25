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
-- Table structure for table `fi_albums`
--

CREATE TABLE `fi_albums` (
  `photoId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `photoName` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_albums`
--

INSERT INTO `fi_albums` (`photoId`, `userId`, `photoName`, `caption`, `uploadDate`) VALUES
(1, 4, 'Toco Toucan.jpg', 'profile photos', '2016-03-24 07:23:54'),
(2, 4, '10649644_574509146015195_2909827983880401343_n.jpg', 'profile photos', '2016-03-28 09:47:43'),
(3, 4, 'tate.jpg', 'profile photos', '2016-03-28 14:32:13'),
(4, 4, 'Snapshot_20151025.jpg', 'profile photos', '2016-03-28 15:21:48'),
(5, 1, 'Snapshot_20151025_1.jpg', 'profile photos', '2016-04-08 20:32:16'),
(6, 7, 'Photo0783.jpg', 'profile photos', '2016-04-17 11:21:35'),
(7, 4, 'IMG-20160119-WA0001.jpg', 'profile photos', '2016-04-18 18:11:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_albums`
--
ALTER TABLE `fi_albums`
  ADD PRIMARY KEY (`photoId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_albums`
--
ALTER TABLE `fi_albums`
  MODIFY `photoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
