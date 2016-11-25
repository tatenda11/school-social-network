-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2016 at 07:50 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `solusi_fi`
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
(5, 1, 'Snapshot_20151025_1.jpg', 'profile photos', '2016-04-08 20:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `fi_degrees`
--

CREATE TABLE `fi_degrees` (
  `majorId` int(2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_degrees`
--

INSERT INTO `fi_degrees` (`majorId`, `description`) VALUES
(1, 'BBA C&MIS'),
(2, 'BBA Finance');

-- --------------------------------------------------------

--
-- Table structure for table `fi_hostels`
--

CREATE TABLE `fi_hostels` (
  `hostel` int(5) NOT NULL,
  `hostelName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fi_hostels`
--

INSERT INTO `fi_hostels` (`hostel`, `hostelName`) VALUES
(1, 'Really'),
(2, 'Maenza'),
(3, 'Sweeden'),
(4, 'Palmer');

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
(1, '2013050071', '8699ec3e28394a4fbb52039ad4442932', '0', '2016-03-20 23:29:59', '2016-04-08 20:31:31'),
(2, '2013050072', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-21 20:22:33', '2016-03-21 20:22:33'),
(3, '2013050073', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-21 20:24:33', '2016-03-21 20:24:33'),
(4, '2016050088', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-21 20:30:40', '2016-03-28 14:30:56'),
(5, '1234567890', 'f2c590588026049523c9b1a022fb7e94', '0', '2016-03-22 07:35:13', '2016-03-22 07:35:13'),
(6, '2016050089', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-23 19:20:36', '2016-03-23 19:20:47'),
(7, '2013200', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-27 12:12:22', '2016-03-27 12:12:22'),
(8, '3456789', 'd3d9446802a44259755d38e6d163e820', '0', '2016-03-27 12:13:12', '2016-03-27 12:13:12');

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
(5, 1, 1, '2016-04-08 20:32:16', 'caleb changed his profile picture');

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
(16, 1, 'P', 'E', 1, '2016-04-08 20:32:15', 'caleb changed his profile picture ', '', 'Snapshot_20151025_1.jpg', '');

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
(1, 1, 'caleb', 'Munenge', 'maloka', 2, 2, 'Marondera', 'Fletcher High School', 'M', '1993-02-24', '4.1', 'Studied at Fletcher High School ''1 Lives in Marondera From Marondera Followed by 1 person', 'Snapshot_20151025_1.jpg', '2013050071'),
(4, 4, 'Maya', 'Daniels', 'Tarie', 2, 2, 'Harare', 'Regina Mundi High School', 'F', '0000-00-00', '2.2', 'cool chick', 'Snapshot_20151025.jpg', ''),
(5, 5, 'natasha', 'munenge', '', 1, 0, '', '', 'F', '0000-00-00', '', '', 'default.jpg', ''),
(6, 6, 'Claud', 'Makalele', '', 1, 0, '', '', 'M', '0000-00-00', '', '', 'Snapshot_20151025.jpg', ''),
(7, 7, 'Steven ', 'Masuku', '', 2, 0, '', '', 'M', '0000-00-00', '', '', 'default.jpg', ''),
(8, 8, 'Lucy', 'Moyo', '', 2, 0, '', '', 'F', '0000-00-00', '', '', 'default.jpg', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fi_albums`
--
ALTER TABLE `fi_albums`
  ADD PRIMARY KEY (`photoId`);

--
-- Indexes for table `fi_degrees`
--
ALTER TABLE `fi_degrees`
  ADD PRIMARY KEY (`majorId`);

--
-- Indexes for table `fi_hostels`
--
ALTER TABLE `fi_hostels`
  ADD PRIMARY KEY (`hostel`);

--
-- Indexes for table `fi_login`
--
ALTER TABLE `fi_login`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `fi_notifications`
--
ALTER TABLE `fi_notifications`
  ADD PRIMARY KEY (`notificationId`);

--
-- Indexes for table `fi_posts`
--
ALTER TABLE `fi_posts`
  ADD PRIMARY KEY (`postId`);

--
-- Indexes for table `fi_users`
--
ALTER TABLE `fi_users`
  ADD PRIMARY KEY (`safeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fi_albums`
--
ALTER TABLE `fi_albums`
  MODIFY `photoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fi_degrees`
--
ALTER TABLE `fi_degrees`
  MODIFY `majorId` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fi_hostels`
--
ALTER TABLE `fi_hostels`
  MODIFY `hostel` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fi_login`
--
ALTER TABLE `fi_login`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `fi_notifications`
--
ALTER TABLE `fi_notifications`
  MODIFY `notificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fi_posts`
--
ALTER TABLE `fi_posts`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `fi_users`
--
ALTER TABLE `fi_users`
  MODIFY `safeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
