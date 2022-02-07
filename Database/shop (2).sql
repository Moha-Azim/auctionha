-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2022 at 09:53 PM
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
(40, '89', '2022-02-06 22:12:15', 58, 37);

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
(5, 'Hand Made', 'Hand Made Items and Prodects', 0, 1, 1, 1, 1),
(6, 'Computers', 'Computers items', 0, 2, 0, 0, 0),
(7, 'Cell Phones', 'Cell Phones New or Used', 0, 3, 0, 0, 0),
(8, 'Clothing', 'Clothing And Fashion', 0, 4, 0, 0, 0),
(9, 'Tools', 'Home Tools', 0, 5, 0, 0, 0),
(16, 'Computer Components', 'Computer Components like ssd,cpu,gpu and more', 6, 2, 0, 0, 0),
(17, 'Monitors', 'Monitors for computers', 6, 3, 0, 0, 0),
(18, 'Laptop Accessories', 'Laptop Accessories', 6, 4, 0, 0, 0),
(19, 'Docking Stations', 'Docking Stations ', 6, 5, 0, 0, 0),
(20, 'Samsung', 'Samsung cell phones', 7, 6, 0, 0, 0),
(21, 'Sony', 'Sony Cell Phones', 7, 6, 0, 0, 0),
(22, 'Cups, Mugs', 'Cups, Mugs hand made', 5, 7, 0, 0, 0),
(23, 'Artwork', 'Hand Made Artwork', 5, 8, 0, 0, 0),
(24, 'baby', 'baby clothes', 8, 9, 0, 0, 0);

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
  `end_biddingDate` datetime NOT NULL,
  `Conutry_Made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `mainImg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `end_biddingDate`, `Conutry_Made`, `image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`, `mainImg`) VALUES
(35, 'Seagate Portable 2TB', 'External Hard Drive Portable HDD – USB 3.0 for PC, Mac, PlayStation, & Xbox - 1-Year Rescue Service (STGX2000400)', '60', '2022-02-06', '2022-02-07 22:25:07', 'USA', '', '1', 0, 1, 16, 40, 'ssd,memory,storage', '7460242027431_81tjLksKixL._AC_SX679_.jpg'),
(36, 'SAMSUNG 970 EVO', 'SAMSUNG 970 EVO Plus SSD 2TB - M.2 NVMe Interface Internal Solid State Drive with V-NAND Technology (MZ-V7S2T0B/AM)', '219', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '1', 0, 1, 16, 50, 'ssd,memory,storage', '2448633428533_813bvfaxuAL._AC_SL1500_.jpg'),
(37, 'External DVD Drive', 'USB 3.0 Portable CD/DVD +/-RW Drive/DVD Player for Laptop CD ROM Burner Compatible with Laptop Desktop PC Windows Linux OS Apple Mac Black', '29', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '1', 0, 1, 16, 53, 'DVD,Drive', '9974268370480_61+wzHQ4TZL._AC_SL1000_.jpg'),
(38, 'AMD Ryzen 5 5600X', ' 6-core, 12-Thread Unlocked Desktop Processor with Wraith Stealth Cooler', '249', '2022-02-06', '2022-02-07 22:25:07', 'India', '', '1', 0, 1, 16, 43, 'amd,ryzen', '6846144878654_61vGQNUEsGL._AC_SL1384_.jpg'),
(39, 'Corsair Vengeance 16GB', ' LPX 16GB (2x8GB) DDR4 DRAM 3200MHz C16 Desktop Memory Kit', '69', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '1', 0, 1, 16, 37, 'ram,memory,storage', '1876104243490_71fFXHe5+LL._AC_SL1500_.jpg'),
(40, 'GTX 1660 Super', 'MSI Gaming GeForce GTX 1660 Super 192-bit HDMI/DP 6GB GDRR6', '649', '2022-02-06', '2022-02-07 22:25:07', 'USA', '', '1', 0, 1, 16, 44, 'gpu,gtx,1660', '6714511001386_71M4pG5B6zS._AC_SL1500_.jpg'),
(41, 'IronWolf 8TB', ' Seagate IronWolf 8TB NAS Internal Hard Drive HDD – 3.5 Inch SATA 6Gb/s 7200 RPM', '99', '2022-02-06', '2022-02-07 22:25:07', 'UK', '', '1', 0, 1, 16, 43, 'hdd,memory,storage', '7419696587125_815kscMthwL._AC_SL1500_.jpg'),
(42, ' Intel Core i5-10400', 'Desktop Processor 6 Cores up to 4.3 GHz  LGA1200 (Intel 400 Series Chipset)', '189', '2022-02-06', '2022-02-07 22:25:07', 'USA', '', '1', 0, 1, 16, 47, 'intel,cpu', '1991278526816_61mX0OPQguL._AC_SL1500_.jpg'),
(43, 'ASUS Prime B560M-A', 'GA 1200 (Intel 11th/10th Gen) micro ATX motherboard (PCIe 4.0,2x M.2 slots', '109', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '1', 0, 1, 16, 51, 'cpu,motherboard,intel', '9685886330563_91ZmJMlAZZL._AC_SL1500_.jpg'),
(44, 'Logitech MK270', 'Wireless Keyboard and Mouse Combo for Windows, 2.4 GHz Wireless, Compact Mouse', '89', '2022-02-06', '2022-02-07 22:25:07', 'USA', '', '2', 0, 1, 16, 48, 'mouse,keyboard,Logitech', '7197846383933_71uyjnDANeL._AC_SL1500_.jpg'),
(45, ' Noctua NH-D15', 'chromax.Black, Dual-Tower CPU Cooler (140mm, Black)', '79', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '3', 0, 1, 16, 53, 'cpu,motherboard', '9440959218104_91t48GBv8TL._AC_SL1500_.jpg'),
(46, 'HP 24mh FHD Monitor', 'Computer Monitor with 23.8-Inch IPS Display (1080p) - Built-In Speakers and VESA', '226', '2022-02-06', '2022-02-07 22:25:07', 'UK', '', '2', 0, 1, 17, 40, 'monitor,fhd,ips', '399523937479_918LKJhnCjL._AC_SL1500_.jpg'),
(47, 'SAMSUNG LC27F398FWNXZA', ' SAMSUNG LC27F398FWNXZA SAMSUNG C27F398 27 Inch Curved LED Monitor', '199', '2022-02-06', '2022-02-07 22:25:07', 'JOR', '', '1', 0, 1, 17, 47, 'monitor,fhd,ips', '7304609038269_91SZVWfPjdL._AC_SL1500_.jpg'),
(48, 'Sceptre IPS 24-Inch', 'Sceptre IPS 24-Inch Business Computer Monitor 1080p 75Hz with HDMI VGA Build-in Speakers, Machine Black', '266', '2022-02-06', '2022-02-07 22:25:07', 'UK', '', '1', 0, 1, 17, 45, 'monitor,fhd,ips', '4065906812426_71NRUy8pgnL._AC_SL1000_.jpg'),
(49, 'Sceptre Curved 27', '75Hz LED Monitor HDMI VGA Build-In Speakers, EDGE-LESS Metal Black 2019 (C275W-1920RN)', '249', '2022-02-06', '2022-02-07 22:25:07', 'Japan', '', '1', 0, 1, 17, 43, 'msi,gtx,1080Ti', '9234471939358_71Y9OxG2fvL._AC_SL1500_.jpg'),
(50, 'Dell 144Hz Gaming Monitor', 'FHD 24 Inch Monitor - 1ms Response Time, LED Edgelight System, AMD FreeSync Premium, VESA, Gray - S2421HGF', '178', '2022-02-06', '2022-02-07 22:25:07', 'Japan', '', '2', 0, 1, 17, 43, 'monitor,fhd,ips,gaming', '4153979761217_61GwU5pco2L._AC_SL1350_.jpg'),
(51, 'USB-C Portable Monitor', ' USB-C Portable Monitor - 15.6 Inch FHD HDR FreeSync Zero Frame USB-C Computer Display with Dual Type-C Mini HDMI for Laptop PC Phone Mac Surface Xbox PS4', '322', '2022-02-06', '2022-02-07 22:25:07', 'Japan', '', '1', 0, 1, 17, 40, 'monitor,fhd,ips', '4828933235530_51hPlPjvoeS._AC_SL1200_.jpg'),
(52, 'Laptop Stand', 'Laptop Stand, Aluminum Computer Riser, Ergonomic Laptops Elevator for Desk, Metal Holder Compatible with 10 to 15.6', '32', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '3', 0, 1, 18, 43, 'labtop,stand', '6867326300291_81MN9l2nl2S._AC_SL1500_.jpg'),
(53, 'Laptop Stand,Suturun', 'Ergonomic Detachable Computer Stand for Laptop Riser for Desk,Portable Aluminum Laptop Stand Riser Holder Notebook Stand Compatible with 10 to 15.6 Inches Notebook Computer', '35', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '', 0, 1, 18, 43, 'labtop,stand', '1796358041210_411rE25qwCL._AC_.jpg'),
(54, 'Ytonet Laptop Case', 'Ytonet Laptop Case, 15.6 inch TSA Laptop Sleeve Water Resistant Durable Computer Carrying Case for 15.6 inch HP, Dell, Lenovo', '16', '2022-02-06', '2022-02-07 22:25:07', 'India', '', '1', 0, 1, 18, 45, 'labtop,case', '2980737167427_81yhhfcejWL._AC_SL1500_.jpg'),
(55, 'Laptop Cooler', ' havit HV-F2056 15.6\"-17\" Laptop Cooler Cooling Pad - Slim Portable USB Powered (3 Fans), Black/Blue', '37', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '3', 0, 1, 18, 43, 'labtop,cooler,fan', '8408666770172_81k9Wd5QZyL._AC_SL1500_.jpg'),
(56, 'LapGear Home Office', 'LapGear Home Office Lap Desk with Device Ledge, Mouse Pad, and Phone Holder - White Marble - Fits Up To 15.6 Inch', '29', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '1', 0, 1, 18, 50, 'labtop,case', '6329853335178_71NwgN-hNqS._AC_SL1500_.jpg'),
(57, 'Dell USB 3.0 Ultra HD', 'Dell USB 3.0 Ultra HD/4K Triple Display Docking Station (D3100), Black', '20', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '1', 0, 1, 19, 44, 'usb,dell,hd', '1989507384573_71MWYWbzhmL._AC_SL1500_.jpg'),
(58, 'Plugable USB', 'Plugable USB 3.0 Universal Laptop Docking Station Dual Monitor for Windows and Mac', '88', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '2', 0, 1, 19, 47, 'labtop,plugable,USB', '1030154884558_71YmvB+hVJL._AC_SL1500_.jpg'),
(59, 'USB C to Dual HDMI', 'USB C to Dual HDMI Adapter,7 in 1 USB C Docking Station to Dual HDMI Displayport VGA Adapter,', '47', '2022-02-06', '2022-02-07 22:25:07', 'UK', '', '2', 0, 1, 19, 40, 'Adabter,USB,HD,HDMI', '7568620060416_81gBp31X8oL._AC_SL1500_.jpg'),
(60, ' WAVLINK USB 3.0', ' WAVLINK USB 3.0 Universal Laptop Docking Station,USB C to 5K/ Dual 4K @60Hz Video Outputs Dual Monitor for Windows and Mac', '64', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '2', 0, 1, 19, 48, 'Adabter,USB,HD,HDMI', '7779303434713_61SC2xSOl4L._AC_SL1000_.jpg'),
(61, 'Samsung Galaxy S21', ' Samsung Galaxy S21 FE 5G Cell Phone, Factory Unlocked Android Smartphone, 128GB, 120Hz Display, Pro Grade Camera', '500', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '2', 0, 1, 20, 44, 'samsung,galaxy,s21', '1720318338984_61ZNIHIEUqL._AC_SL1500_.jpg'),
(62, 'Samsung Galaxy A12', 'Samsung Galaxy A12 Nacho (64GB, 4GB) 6.5\" HD+, Exynos 850, 48MP Quad Camera', '399', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '2', 0, 1, 20, 51, 'samsung,galaxy,A12', '4233861860603_618LuqyIX6L._AC_SL1000_.jpg'),
(63, 'Galaxy Z Flip 3 ', 'SAMSUNG Electronics Galaxy Z Flip 3 5G Factory Unlocked Android Cell Phone US Version Smartphone Flex Mode', '788', '2022-02-06', '2022-02-07 22:25:07', 'UK', '', '2', 0, 1, 20, 40, 'samsung,galaxy,flib,z', '2255201354744_61bfdXk7nfL._AC_SL1500_.jpg'),
(64, 'SAMSUNG Galaxy S21', 'SAMSUNG Galaxy S21 Ultra 5G Factory Unlocked Android Cell Phone 128GB US Version Smartphone Pro-Grade', '1099', '2022-02-06', '2022-02-07 22:25:07', 'India', '', '1', 0, 1, 20, 47, 'samsung,galaxy', '2372312929979_61O45C5qASL._AC_SL1000_.jpg'),
(65, 'SAMSUNG Galaxy Z Fold 3', 'SAMSUNG Galaxy Z Fold 3 5G Factory Unlocked Android Cell Phone US Version Smartphone Tablet 2-in-1 Foldable Dual Screen', '655', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '', 0, 1, 20, 40, 'samsung,galaxy,flib', '1174250606680_71fZjtFFLsL._AC_SL1500_.jpg'),
(66, 'Sony Xperia 5 III', 'Sony Xperia 5 III XQ-BQ72 5G Dual 256GB 8GB RAM Factory Unlocked (GSM Only | No CDMA - not Compatible with Verizon/Sprint) International Version – Black', '799', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '1', 0, 1, 21, 44, 'sony', '449885673322_51E8hMmClXL._AC_SL1280_.jpg'),
(67, ' Red Pottery Coffee Mug', '15 oz Red Pottery Coffee Mug, Earthen mug, Handmade Ceramic mug, Tea mug, Clay mug', '29', '2022-02-06', '2022-02-07 22:25:07', 'Hand Made', '', '4', 0, 1, 22, 43, 'cub,pottery coffee,mug', '6942333936501_7100Rw8IwHL._SL1500_.jpg'),
(68, '3D Wood World Map', '3D Wood World Map Wall Art Large Wall Decor - World Travel Map All Sizes', '49', '2022-02-06', '2022-02-07 22:25:07', 'USA', '', '1', 0, 1, 23, 48, 'art,world,map,decor', '2845525593931_71zbVOtSeXL._SL1500_.jpg'),
(69, 'CARTMAN 148Piece ', 'CARTMAN 148Piece Tool Set General Household Hand Tool Kit with Plastic Toolbox Storage Case Socket and Socket Wrench Sets', '89', '2022-02-06', '2022-02-07 22:25:07', 'China', '', '1', 0, 1, 9, 51, 'tools,household', '9485176928904_91JQZ+jOi4L._AC_SL1500_.jpg'),
(70, 'Simple Joys ', 'Simple Joys by Carter\'s Unisex Babies\' Hooded Sweater Jacket with Sherpa Lining', '29', '2022-02-06', '2022-02-07 22:25:07', 'India', '', '1', 0, 1, 24, 43, 'clothing,baby', '3079233317050_91m-5CnqR1L._AC_UY550_.jpg');

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
(3, 'khale', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'mohzem332@yahoo.com', 569, 'khaled ali khaled', 0, 0, 1, '2021-10-14', ''),
(37, 'adel', 'f06dc5a06b8855163d5614ef4b315c1311e084cf', 'adell@gmail.com', 35000, 'adel mohammad hammad', 0, 0, 1, '2022-01-11', ''),
(40, 'salllem', 'd7c670a0a01c3464fc62356686b9e13b52fd423e', 'salllem@gmail.com', 969, 'sallem ahmad adil', 0, 0, 1, '2022-01-11', ''),
(43, 'asdfd', '92429d82a41e930486c6de5ebda9602d55c39986', 'mohzem@yahoo.com', 150, '', 0, 0, 1, '2022-01-20', ''),
(44, 'heneen', '627172bda8b8c1544bfff78a643289ac91dc0b6b', 'haneen@yahoo.com', 900, '', 0, 0, 1, '2022-01-20', ''),
(45, 'ayatmo', '3917a68087ffdafb592a46375a1a6291bcf96aa1', 'ayatmo@yahoo.comayatmo', 444, 'ayatmo  ahmad', 0, 0, 1, '2022-01-20', ''),
(47, 'Khaldoon', 'bf241ea526fa6a795f459d99d8b1c5462a57df72', 'Khaldoon@yahoo.com', 410, 'Khaldoon ahmad samy', 0, 0, 1, '2022-01-27', '8455324913253_wallpaperflare.com_wallpaper (17).jpg'),
(48, 'salieeeeeem', 'd930870fb0a2a9944caaf52a9fef6355a240171a', 'salieeeeeem@gmail.com', 0, 'salieeeeeem mohammad adeeeeeeeeeel', 0, 0, 1, '2022-02-03', '374124058836_Screenshot (3).png'),
(50, 'Khaled', '087124957853a98fcfd67fee2730e5a11b5d9523', 'Khaled.Ali@zema.net', 0, 'Khaled mohammad hammad', 1, 0, 1, '2022-02-06', ''),
(51, 'sameeh', '0edea1162e1ff892b5a17b71af95989f5f3adcee', 'sameeh@gmail.com', 0, 'sameeh ali mohammad said', 1, 0, 1, '2022-02-06', ''),
(52, 'alex', '9a85d2d5d44e4830c4f61da53c5d1e03bc7c5362', 'alex@hotmail.com', 0, 'alex alex being', 1, 0, 1, '2022-02-06', ''),
(53, 'salma ali', '5e862ff94f987771e65e40667726462ec7e5a15e', 'salma@gmail.com', 0, 'salma ali sameh atyat', 1, 0, 1, '2022-02-06', '');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_add`
--

CREATE TABLE `wallet_add` (
  `add_ID` int(11) NOT NULL,
  `mony_added` int(11) NOT NULL,
  `Date` datetime NOT NULL COMMENT 'Process date and time',
  `admin_id` int(11) NOT NULL COMMENT 'admin who add mony',
  `user` int(11) NOT NULL COMMENT 'user id who received the money'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='wallet add processes';

--
-- Dumping data for table `wallet_add`
--

INSERT INTO `wallet_add` (`add_ID`, `mony_added`, `Date`, `admin_id`, `user`) VALUES
(6, 69, '2022-02-05 22:38:10', 1, 3);

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
-- Indexes for table `wallet_add`
--
ALTER TABLE `wallet_add`
  ADD PRIMARY KEY (`add_ID`),
  ADD KEY `user_id_mony` (`user`),
  ADD KEY `admin_id_mony` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidding`
--
ALTER TABLE `bidding`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify users', AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `wallet_add`
--
ALTER TABLE `wallet_add`
  MODIFY `add_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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

--
-- Constraints for table `wallet_add`
--
ALTER TABLE `wallet_add`
  ADD CONSTRAINT `admin_id_mony` FOREIGN KEY (`admin_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_mony` FOREIGN KEY (`user`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
