-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 07:51 PM
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
-- Table structure for table `fi_messages`
--

CREATE TABLE `fi_messages` (
  `messageId` int(11) NOT NULL,
  `userTo` int(5) NOT NULL,
  `userFrom` int(5) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('P','O') NOT NULL DEFAULT 'P'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_messages`
--

INSERT INTO `fi_messages` (`messageId`, `userTo`, `userFrom`, `attachment`, `message`, `sentDate`, `status`) VALUES
(1, 1, 4, '', 'nice job on the site', '2016-04-17 13:28:08', 'P'),
(2, 4, 6, '', 'ko ndeipi', '2016-04-17 18:59:29', 'P'),
(3, 4, 1, '', 'hey maya kokusataura nevamwe ndozvinei', '2016-04-18 05:03:40', 'P'),
(4, 4, 1, '', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.\n', '2016-04-18 14:11:09', 'P'),
(15, 6, 4, '', 'zvirisei claud', '2016-04-19 17:22:10', 'P'),
(16, 6, 4, '', 'zvirisei claud', '2016-04-20 06:02:57', 'P'),
(17, 1, 4, '', 'ndimi marova imi', '2016-04-20 06:03:22', 'P'),
(18, 1, 4, '', 'ndeipi tatenda', '2016-04-20 18:00:07', 'P'),
(19, 4, 1, '', 'maya zvirisei', '2016-04-21 06:17:59', 'P'),
(20, 4, 1, '', 'hey maya watapp', '2016-04-21 08:58:30', 'P');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_messages`
--
ALTER TABLE `fi_messages`
  ADD PRIMARY KEY (`messageId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_messages`
--
ALTER TABLE `fi_messages`
  MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
