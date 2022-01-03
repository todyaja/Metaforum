-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2021 at 06:20 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `metaforum`
--

-- --------------------------------------------------------

--
-- Table structure for table `forum_category`
--

CREATE TABLE `forum_category` (
  `CategoryID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `CategoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_category`
--

INSERT INTO `forum_category` (`CategoryID`, `GroupID`, `CategoryName`) VALUES
(1, 4, 'First-Person Shooters'),
(2, 4, 'Real-Time Strategy'),
(3, 4, 'RPG'),
(4, 4, 'MOBAGE'),
(5, 4, 'Board Games'),
(6, 4, 'Moba'),
(7, 4, 'Horror'),
(8, 4, 'Survival'),
(9, 4, 'Story Games'),
(10, 4, 'Arcade'),
(11, 4, 'Homebrew'),
(12, 4, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `forum_group`
--

CREATE TABLE `forum_group` (
  `GroupID` int(11) NOT NULL,
  `GroupName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_group`
--

INSERT INTO `forum_group` (`GroupID`, `GroupName`) VALUES
(1, 'General'),
(2, 'World'),
(3, 'Entertainment'),
(4, 'Video Games'),
(5, 'Politics'),
(6, 'Off-Topic');

-- --------------------------------------------------------

--
-- Table structure for table `forum_thread`
--

CREATE TABLE `forum_thread` (
  `ThreadID` varchar(255) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `UserID` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL,
  `View` int(11) NOT NULL,
  `Created_At` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_thread`
--

INSERT INTO `forum_thread` (`ThreadID`, `CategoryID`, `UserID`, `Title`, `Description`, `Status`, `View`, `Created_At`) VALUES
('61a2598c3db36', 1, '61a2592b015dd', 'Thread 1 di fps', 'Desc 1 di fps', 0, 7, '2021-11-27 23:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `moderator_category`
--

CREATE TABLE `moderator_category` (
  `ModeratorCategoryID` int(11) NOT NULL,
  `UserID` varchar(255) NOT NULL,
  `CategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `moderator_category`
--

INSERT INTO `moderator_category` (`ModeratorCategoryID`, `UserID`, `CategoryID`) VALUES
(1, 'moderatorfps', 1);

-- --------------------------------------------------------

--
-- Table structure for table `thread_favorite`
--

CREATE TABLE `thread_favorite` (
  `UserID` varchar(255) NOT NULL,
  `ThreadID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thread_favorite`
--

INSERT INTO `thread_favorite` (`UserID`, `ThreadID`) VALUES
('619391539d344', '619391539d344'),
('619391539d344', ''),
('619391539d344', '6193cb467c9cd'),
('619391539d344', '6194eb62d0da3'),
('619391539d344', '619b42b76be33'),
('619391539d344', '6194b8cf5db56'),
('619391539d344', '61965f7e0dad9'),
('moderatorfps', '619e4bd3f26a2');

-- --------------------------------------------------------

--
-- Table structure for table `thread_reply`
--

CREATE TABLE `thread_reply` (
  `Thread_ReplyID` varchar(255) NOT NULL,
  `ThreadID` varchar(255) NOT NULL,
  `UserID` varchar(255) NOT NULL,
  `ReplyDescription` varchar(255) NOT NULL,
  `Created_At` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thread_reply`
--

INSERT INTO `thread_reply` (`Thread_ReplyID`, `ThreadID`, `UserID`, `ReplyDescription`, `Created_At`) VALUES
('61a25ec6eb06f', '61a2598c3db36', '61a2592b015dd', 'this is the first reply', '2021-11-27 23:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `thread_report`
--

CREATE TABLE `thread_report` (
  `ThreadReportID` varchar(255) NOT NULL,
  `ThreadID` varchar(255) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `UserThreadID` varchar(255) NOT NULL,
  `UserReportID` varchar(255) NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thread_report`
--

INSERT INTO `thread_report` (`ThreadReportID`, `ThreadID`, `CategoryID`, `UserThreadID`, `UserReportID`, `CreatedAt`) VALUES
('61a2602f1579d', '61a2598c3db36', 1, '61a2592b015dd', '61a2592b015dd', '2021-11-27 23:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(25) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Verified` int(11) NOT NULL DEFAULT 0,
  `Role` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Display_Picture` text NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Email_Visibility` int(11) NOT NULL,
  `lastChangedUsername` datetime DEFAULT NULL,
  `Deleted_At` datetime DEFAULT NULL,
  `isLogin` int(11) DEFAULT NULL,
  `banned_date` datetime DEFAULT NULL,
  `banned_ThreadID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Email`, `Password`, `Verified`, `Role`, `Status`, `Display_Picture`, `Description`, `Email_Visibility`, `lastChangedUsername`, `Deleted_At`, `isLogin`, `banned_date`, `banned_ThreadID`) VALUES
('1', 'siteadmin', 'supermetaforum@gmail.com', 'binusmaya123', 1, 0, 0, 'siteadmin.jpg', 'saya site admin', 0, NULL, NULL, NULL, NULL, ''),
('61a2592b015dd', 'Usernomor1', 'usernomor1@gmail.com', '$2y$10$iH1D4l14ZvE/reqwRLACd.csT5BkiaYqrOU0M/TIxh.I7XUHeZy3m', 1, 2, 0, 'guest.jpg', '', 0, NULL, NULL, 0, NULL, NULL),
('61a2594e8ec1a', 'Usernomor2', 'usernomor2@gmail.com', '$2y$10$nZEWvJ5c8oSuaaHWSaAd/.keOzgMjNKbWwo.0WsUVklEhazGQToo.', 0, 2, 0, 'guest.jpg', '', 0, NULL, NULL, 0, NULL, NULL),
('moderatorfps', 'Moderatorfps123', 'moderatorfps@gmail.com', '$2y$10$9dTeogsXE8dU/3kLs9peyesbiTFpgqOzcBxiwNE4uImug2uQbKXnq', 1, 1, 0, 'guest.jpg', '', 0, NULL, NULL, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum_category`
--
ALTER TABLE `forum_category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `forum_group`
--
ALTER TABLE `forum_group`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `forum_thread`
--
ALTER TABLE `forum_thread`
  ADD PRIMARY KEY (`ThreadID`);

--
-- Indexes for table `moderator_category`
--
ALTER TABLE `moderator_category`
  ADD PRIMARY KEY (`ModeratorCategoryID`);

--
-- Indexes for table `thread_reply`
--
ALTER TABLE `thread_reply`
  ADD PRIMARY KEY (`Thread_ReplyID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum_category`
--
ALTER TABLE `forum_category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `forum_group`
--
ALTER TABLE `forum_group`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `moderator_category`
--
ALTER TABLE `moderator_category`
  MODIFY `ModeratorCategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `clear_banned_user` ON SCHEDULE EVERY 1 MINUTE STARTS '2021-11-24 20:59:55' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE user SET Status = 0, banned_date=NULL, banned_ThreadID = NULL WHERE banned_date<now()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
