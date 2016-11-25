-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 07:49 PM
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
-- Table structure for table `fi_posts`
--

CREATE TABLE `fi_posts` (
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `posttyp` varchar(10) NOT NULL,
  `sharing` enum('M','F','E') NOT NULL DEFAULT 'E',
  `wall` int(11) NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postText` text NOT NULL,
  `media` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_posts`
--

INSERT INTO `fi_posts` (`postId`, `userId`, `posttyp`, `sharing`, `wall`, `postDate`, `postText`, `media`, `photo`, `youtube`) VALUES
(1, 6, 'T', 'E', 6, '2016-03-23 19:47:56', 'judu', '', '', ''),
(2, 6, 'T', 'E', 6, '2016-03-23 19:52:18', 'youtube video', '', '', ''),
(3, 6, 'T', 'E', 6, '2016-03-23 19:53:11', 'the happen', '', '', ''),
(4, 6, 'T', 'E', 6, '2016-03-23 19:57:41', 'how are you', '', '', ''),
(5, 6, 'T', 'E', 6, '2016-03-23 20:00:45', 'he ELearning Institute provides eLearning and', '', '', ''),
(6, 6, 'T', 'F', 6, '2016-03-23 20:02:07', 'my latest post', '', '', ''),
(7, 4, 'P', 'E', 4, '2016-03-24 06:43:25', 'Maya change getSex(F)', '', 'Forest Flowers.jpg', ''),
(8, 4, 'P', 'E', 4, '2016-03-24 06:45:49', 'Maya changed her profile picture ', '', 'Forest Flowers.jpg', ''),
(9, 4, 'P', 'E', 4, '2016-03-24 06:46:20', 'Maya changed her profile picture ', '', 'Forest Flowers.jpg', ''),
(10, 4, 'P', 'E', 4, '2016-03-24 07:23:54', 'Maya changed her profile picture ', '', 'Toco Toucan.jpg', ''),
(11, 4, 'T', 'E', 4, '2016-03-25 21:01:34', 'hey guys', '', '', ''),
(12, 4, 'T', 'E', 4, '2016-03-25 21:08:26', 'say something', '', '', ''),
(13, 4, 'P', 'E', 4, '2016-03-28 09:47:42', 'Maya changed her profile picture ', '', '10649644_574509146015195_2909827983880401343_n.jpg', ''),
(14, 4, 'P', 'E', 4, '2016-03-28 14:32:12', 'Maya changed her profile picture ', '', 'tate.jpg', ''),
(15, 4, 'P', 'E', 4, '2016-03-28 15:21:47', 'Maya changed her profile picture ', '', 'Snapshot_20151025.jpg', ''),
(16, 1, 'P', 'E', 1, '2016-04-08 20:32:15', 'caleb changed his profile picture ', '', 'Snapshot_20151025_1.jpg', ''),
(17, 4, 'T', 'E', 7, '2016-04-16 17:02:21', 'how are you Maya', '', '', ''),
(18, 1, 'T', 'E', 4, '2016-04-16 17:15:05', 'hey maya', '', '', ''),
(19, 1, 'T', 'E', 1, '2016-04-16 17:29:24', 'hey guys', '', '', ''),
(20, 1, 'T', 'E', 4, '2016-04-16 19:28:16', 'hey Maya', '', '', ''),
(21, 7, 'P', 'E', 7, '2016-04-17 11:21:35', 'Steven  changed his profile picture ', '', 'Photo0783.jpg', ''),
(22, 6, 'T', 'E', 1, '2016-04-17 12:52:41', 'ko ndeipi wangu', '', '', ''),
(23, 4, 'P', 'E', 4, '2016-04-18 18:11:53', 'Maya changed her profile picture ', '', 'IMG-20160119-WA0001.jpg', ''),
(24, 1, 'T', 'E', 6, '2016-04-22 12:30:55', 'claud you talk crap', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_posts`
--
ALTER TABLE `fi_posts`
  ADD PRIMARY KEY (`postId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_posts`
--
ALTER TABLE `fi_posts`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
