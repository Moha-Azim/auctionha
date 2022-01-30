-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2022 at 08:05 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `bidding`
--

CREATE TABLE `bidding` (
  `ID` int(11) NOT NULL,
  `New_Price` varchar(11) NOT NULL,
  `Date_time` datetime NOT NULL,
  `item_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bidding`
--

INSERT INTO `bidding` (`ID`, `New_Price`, `Date_time`, `item_id`, `member_id`) VALUES
(1, '200', '2022-01-29 19:31:36', 23, 37),
(2, '220', '2022-01-29 22:15:26', 23, 46),
(3, '230', '2022-01-29 22:15:58', 23, 45),
(4, '500', '2022-01-29 22:28:41', 21, 37),
(5, '699', '2022-01-30 15:12:00', 23, 37),
(6, '700', '2022-01-30 15:14:22', 23, 37),
(7, '701', '2022-01-30 15:14:56', 23, 37),
(8, '702', '2022-01-30 15:15:38', 23, 37),
(9, '703', '2022-01-30 15:29:11', 23, 37),
(12, '704', '2022-01-30 15:34:32', 23, 45),
(13, '705', '2022-01-30 15:53:55', 23, 46),
(14, '706', '2022-01-30 16:00:07', 23, 45),
(15, '707', '2022-01-30 17:12:20', 23, 44);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(6) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(5, 'Hand Made', 'Hand Made Items and Prodects', 0, 1, 0, 0, 0),
(6, 'Computers', 'Computers items', 0, 2, 0, 0, 0),
(7, 'Cell Phones', 'Cell Phones New or Used', 0, 3, 1, 1, 1),
(8, 'Clothing', 'Clothing And Fashion', 0, 4, 0, 0, 0),
(9, 'Tools', 'Home Tools', 0, 5, 0, 0, 0),
(10, 'Nokia', 'Nokia Phones', 7, 13, 0, 0, 0),
(13, 'boxes', 'wooden boxes', 5, 12, 0, 0, 0),
(14, 'toys', 'hand mande toys', 9, 35, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(9, 'that was great', 1, '2022-01-11', 14, 47),
(10, 'nice Item', 1, '2022-01-11', 12, 37),
(11, ' this si adel', 1, '2022-01-21', 16, 46),
(12, 'asdf', 1, '2022-01-21', 16, 3),
(13, 'Nice Speaker Khale very Nice', 1, '2022-01-21', 11, 37),
(14, 'the Best Item', 1, '2022-01-21', 11, 37),
(15, 'good very good', 1, '2022-01-21', 14, 45),
(16, 'logitic is the best', 1, '2022-01-21', 14, 37),
(19, 'Good Stuf bro', 1, '2022-01-22', 11, 37);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Conutry_Made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Conutry_Made`, `image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`) VALUES
(11, 'Speaker', 'Speaker 3.1', '10', '2022-01-18', 'USA', '', '1', 0, 1, 6, 3, ''),
(12, 'Microphone', 'Microphone 5.1', '100', '2022-01-18', 'UK', '', '1', 0, 1, 6, 3, ''),
(13, 'iPhone 7s', 'Apple iPhone 7s', '150', '2022-01-18', 'China', '', '3', 0, 1, 7, 40, 'Game'),
(14, 'Logitic Mous', 'Logitic Mous 603 pro', '100', '2022-01-18', 'UK', '', '1', 0, 1, 6, 37, ''),
(15, 'Ethernet Cable', 'Ethernet Cable Cat6', '10', '2022-01-18', 'China', '', '1', 0, 1, 6, 37, 'gtx'),
(16, 'Photo Frame', 'Photo Frame Made At home', '10', '2022-01-20', 'UK', '', '1', 0, 1, 5, 37, 'msi,gtx'),
(17, 'Iphone x', 'Iphone x from Apple very good last update Iphone x from Apple very good last update ', '500', '2022-01-22', 'USA', '', '2', 0, 1, 7, 37, 'gtx'),
(18, 'Hammer', 'Hammer for Home work', '10', '2022-01-22', 'China', '', '3', 0, 1, 9, 37, 'msi,gtx,1080'),
(19, 'Xbox 1', 'Xbox  with for games', '200', '2022-01-22', 'UK', '', '4', 0, 1, 6, 37, 'Online'),
(20, 'Gaming Pc', 'gtx 1080ti cpu: i5 10400', '700', '2022-01-22', 'JOR', '', '2', 0, 1, 6, 37, 'RGB'),
(21, '  Drill', '  Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work Drill for Heavy Work', '  200', '2022-01-22', '  UK', '', '', 0, 1, 9, 37, 'gtx'),
(22, ' Gtx 1080Ti', ' Gtx 1080Ti Msi 2020 ', ' 400', '2022-01-26', ' China', '', '', 0, 1, 6, 40, 'msi,gtx,1080'),
(23, 'Dibalo |||', 'Dibalo ||| online game', '70', '2022-01-27', 'USA', '', '1', 0, 1, 6, 37, 'RGB, Online, Game');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To identify users',
  `Username` varchar(255) NOT NULL COMMENT 'Username to login',
  `Password` varchar(255) NOT NULL COMMENT 'Password to login',
  `Email` varchar(255) NOT NULL,
  `wallet` mediumint(9) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'Identify user Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User Approval',
  `Date` date NOT NULL DEFAULT '2022-01-01',
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `wallet`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'mohammad', '601f1889667efaebb33b8c12572835da3f027f78', 'moha@yahoo.com', 10000, 'mohammad azim', 1, 0, 1, '2022-01-01', ''),
(3, 'khale', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'mohzem332@yahoo.com', 500, 'khaled ali khaled', 0, 0, 1, '2021-10-14', ''),
(37, 'adel', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'adell@gmail.com', 350, 'adeladel', 0, 0, 1, '2022-01-11', ''),
(40, 'salllem', 'd7c670a0a01c3464fc62356686b9e13b52fd423e', 'salllem@gmail.com', 900, 'sallem ahmad adil', 0, 0, 1, '2022-01-11', ''),
(43, 'asdfd', '92429d82a41e930486c6de5ebda9602d55c39986', 'mohzem@yahoo.com', 150, '', 0, 0, 1, '2022-01-20', ''),
(44, 'heneen', '627172bda8b8c1544bfff78a643289ac91dc0b6b', 'haneen@yahoo.com', 900, '', 0, 0, 1, '2022-01-20', ''),
(45, 'ayatmo', '3917a68087ffdafb592a46375a1a6291bcf96aa1', 'ayatmo@yahoo.comayatmo', 444, 'ayatmo  ahmad', 0, 0, 0, '2022-01-20', ''),
(46, 'ahmad junior', '668be06c7ef7fe08f4831de0cf874d6bcd677a3b', 'ahmad@yahoo.com', 756, '', 0, 0, 0, '2022-01-20', ''),
(47, 'Khaldoon', 'bf241ea526fa6a795f459d99d8b1c5462a57df72', 'Khaldoon@yahoo.com', 410, 'Khaldoon ahmad samy', 0, 0, 1, '2022-01-27', '8455324913253_wallpaperflare.com_wallpaper (17).jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidding`
--
ALTER TABLE `bidding`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `bidding_user` (`member_id`),
  ADD KEY `bidding_item` (`item_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidding`
--
ALTER TABLE `bidding`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify users', AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bidding`
--
ALTER TABLE `bidding`
  ADD CONSTRAINT `bidding_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bidding_user` FOREIGN KEY (`member_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
