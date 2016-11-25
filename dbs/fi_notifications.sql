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
-- Table structure for table `fi_notifications`
--

CREATE TABLE `fi_notifications` (
  `notificationId` int(11) NOT NULL,
  `notFrom` int(11) NOT NULL,
  `notTo` int(11) NOT NULL,
  `notDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notification` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_notifications`
--

INSERT INTO `fi_notifications` (`notificationId`, `notFrom`, `notTo`, `notDate`, `notification`) VALUES
(1, 4, 4, '2016-03-24 07:23:54', 'Maya changed her profile picture'),
(2, 4, 4, '2016-03-28 09:47:43', 'Maya changed her profile picture'),
(3, 4, 4, '2016-03-28 14:32:13', 'Maya changed her profile picture'),
(4, 4, 4, '2016-03-28 15:21:48', 'Maya changed her profile picture'),
(5, 1, 1, '2016-04-08 20:32:16', 'caleb changed his profile picture'),
(6, 1, 1, '2016-04-16 18:26:16', 'commented'),
(7, 1, 1, '2016-04-16 18:57:04', 'liked'),
(8, 1, 1, '2016-04-16 19:00:52', 'liked'),
(9, 1, 1, '2016-04-16 19:04:20', 'liked'),
(10, 1, 1, '2016-04-16 19:04:56', 'liked'),
(11, 1, 1, '2016-04-16 19:06:44', 'liked'),
(12, 1, 1, '2016-04-16 19:07:19', 'liked'),
(13, 1, 4, '2016-04-16 19:08:32', 'liked'),
(14, 1, 4, '2016-04-16 19:10:35', 'liked'),
(15, 1, 1, '2016-04-16 19:16:07', 'liked'),
(16, 1, 1, '2016-04-16 19:16:55', 'commented'),
(17, 1, 1, '2016-04-16 19:23:26', 'liked'),
(18, 1, 4, '2016-04-16 19:27:34', 'liked'),
(19, 7, 4, '2016-04-17 11:15:27', 'liked'),
(20, 7, 7, '2016-04-17 11:21:35', 'Steven  changed his profile picture'),
(21, 7, 1, '2016-04-17 11:38:13', 'liked'),
(22, 7, 1, '2016-04-17 11:39:27', 'commented'),
(23, 7, 1, '2016-04-17 11:39:55', 'liked'),
(24, 6, 1, '2016-04-17 19:00:08', 'liked'),
(25, 4, 4, '2016-04-18 18:11:54', 'Maya changed her profile picture'),
(26, 4, 4, '2016-04-19 09:59:06', 'liked'),
(27, 4, 6, '2016-04-20 05:58:49', 'liked'),
(28, 1, 7, '2016-04-21 06:19:24', 'liked'),
(29, 1, 4, '2016-04-21 19:28:43', 'liked'),
(30, 1, 4, '2016-04-21 19:28:53', 'liked'),
(31, 1, 6, '2016-04-21 19:29:19', 'liked'),
(32, 1, 6, '2016-04-21 19:41:41', 'commented'),
(33, 1, 6, '2016-04-22 11:49:25', 'liked'),
(34, 1, 6, '2016-04-22 11:49:26', 'liked'),
(35, 1, 1, '2016-04-22 12:07:55', 'liked'),
(36, 1, 4, '2016-04-22 12:08:52', 'liked'),
(37, 1, 4, '2016-04-22 12:09:07', 'liked'),
(38, 1, 4, '2016-04-22 12:19:19', 'liked'),
(39, 1, 4, '2016-04-22 12:21:46', 'liked');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_notifications`
--
ALTER TABLE `fi_notifications`
  ADD PRIMARY KEY (`notificationId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_notifications`
--
ALTER TABLE `fi_notifications`
  MODIFY `notificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
