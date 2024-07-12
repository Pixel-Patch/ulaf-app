-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 08:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ulaf`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_timeline`
--

CREATE TABLE `activity_timeline` (
  `Activity_ID` varchar(11) NOT NULL,
  `Activity_Type` varchar(50) DEFAULT NULL,
  `Record_Type` varchar(50) DEFAULT NULL,
  `Record_ID` varchar(11) DEFAULT NULL,
  `Actor_ID` varchar(11) DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Category_ID` varchar(11) NOT NULL,
  `Category_Name` varchar(100) DEFAULT NULL,
  `Category_Image` varchar(255) DEFAULT NULL,
  `Category_Detail` varchar(255) DEFAULT NULL,
  `Creation_Date` datetime DEFAULT NULL,
  `Last_Update_Date` datetime DEFAULT NULL,
  `User_ID` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Category_ID`, `Category_Name`, `Category_Image`, `Category_Detail`, `Creation_Date`, `Last_Update_Date`, `User_ID`) VALUES
('1', 'Electronics', 'image1.jpg', 'Electronic devices such as laptops, phones, and chargers.', '2023-04-01 12:00:00', NULL, '14-2256'),
('10', 'Musical Instruments', 'image10.jpg', 'Musical instruments such as guitars, flutes, and drums.', '2023-04-19 12:00:00', '2023-04-19 12:00:00', '15-2261'),
('11', 'Toys', 'image11.jpg', 'Toys and games.', '2023-04-21 12:00:00', '2023-04-21 12:00:00', '15-2261'),
('12', 'Documents', 'image12.jpg', 'Documents such as passports, ID cards, and certificates.', '2023-04-23 12:00:00', '2023-04-23 12:00:00', '15-2261'),
('13', 'Cameras', 'image13.jpg', 'Cameras and camera equipment.', '2023-04-25 12:00:00', '2023-04-25 12:00:00', '15-2261'),
('14', 'Wallets', 'image14.jpg', 'Wallets and purses.', '2023-04-27 12:00:00', '2023-04-27 12:00:00', '15-2261'),
('15', 'Headphones', 'image15.jpg', 'Headphones and earbuds.', '2023-04-29 12:00:00', '2023-04-29 12:00:00', '15-2261'),
('16', 'School Supplies', 'image16.jpg', 'School supplies such as pens, pencils, and calculators.', '2023-04-30 12:00:00', '2023-04-30 12:00:00', '15-2261'),
('17', 'Miscellaneous', 'image17.jpg', 'Items that don\'t fit into any other category.', '2023-04-08 12:00:00', '2023-04-08 12:00:00', '15-2261'),
('2', 'Clothing', 'image2.jpg', 'Clothing items such as jackets, hats, and gloves.', '2023-04-03 12:00:00', NULL, '14-2256'),
('3', 'Books', 'image3.jpg', 'Books, notebooks, and other academic materials.', '2023-04-05 12:00:00', NULL, '14-2256'),
('4', 'Keys', 'image4.jpg', 'Keys, ID cards, and access cards.', '2023-04-07 12:00:00', NULL, '14-2256'),
('5', 'Bags', 'image5.jpg', 'Bags, backpacks, and purses.', '2023-04-09 12:00:00', NULL, '14-2256'),
('6', 'Water Bottles', 'image6.jpg', 'Water bottles and thermoses.', '2023-04-11 12:00:00', '2023-04-11 12:00:00', '15-2261'),
('7', 'Glasses', 'image7.jpg', 'Glasses and sunglasses.', '2023-04-13 12:00:00', '2023-04-13 12:00:00', '15-2261'),
('8', 'Umbrellas', 'image8.jpg', 'Umbrellas and rain gear.', '2023-04-15 12:00:00', '2023-04-15 12:00:00', '15-2261'),
('9', 'Sports Equipment', 'image9.jpg', 'Sports equipment such as balls, helmets, and pads.', '2023-04-17 12:00:00', '2023-04-17 12:00:00', '15-2261');

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

CREATE TABLE `claims` (
  `Claim_ID` int(11) NOT NULL,
  `Item_ID` varchar(11) NOT NULL,
  `Claimer_ID` varchar(11) NOT NULL,
  `Claim_Status` varchar(20) DEFAULT NULL,
  `Proof` text DEFAULT NULL,
  `Claim_Date` datetime DEFAULT NULL,
  `Verification_Status` varchar(20) DEFAULT NULL,
  `Verification_Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `User_ID` varchar(11) NOT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Avatar_Image` varchar(255) DEFAULT NULL,
  `Contact` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Item_Name` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Type` varchar(10) DEFAULT NULL,
  `Category_ID` varchar(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Pin_Location` varchar(255) DEFAULT NULL,
  `Posted_Date` datetime DEFAULT NULL,
  `Current_Location` varchar(255) DEFAULT NULL,
  `Poster_ID` varchar(11) DEFAULT NULL,
  `Item_Status` varchar(20) DEFAULT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL,
  `Retrieved_By` varchar(11) DEFAULT NULL,
  `Retrieved_Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Item_Name`, `Image`, `Type`, `Category_ID`, `Description`, `Pin_Location`, `Posted_Date`, `Current_Location`, `Poster_ID`, `Item_Status`, `Latitude`, `Longitude`, `Retrieved_By`, `Retrieved_Date`) VALUES
(1, 'Lost Item TEST', '1-24-0000-1720758039-0.jpg', 'lost', '1', ' dsfsd fds fsd fdsfdsf fdsfdsf dsfdsfs fdsfsdfsdf dsfsd fds fsd fdsfdsf fdsfdsf dsfdsfs fdsfsdfsdf dsfsd fds fsd fdsfdsf fdsfdsf dsfdsfs fdsfsdfsdf dsfsd fds fsd fdsfdsf fdsfdsf dsfdsfs fdsfsdfsdf', 'PWQJ+8X5, Science City of Muñoz, Nueva Ecija, Philippines', '2024-07-12 06:20:39', NULL, '24-0000', 'Posted', 15.73848613, 120.93244783, NULL, NULL),
(2, 'Item Found TEST', '10-24-009-1720758268-0.jpg', 'found', '10', 'shhdjd jsjsjsh jsjsjsj jdjdjjd djjdjdhd jsjsjdj sjjsjdj sjsjhshs jdjsjsjs jsjsjsjs jsjsjsjs', 'PWMJ+C39, Science City of Muñoz, Nueva Ecija, Philippines', '2024-07-12 06:24:28', 'reporter', '24-009', 'Posted', 15.73343917, 120.92995094, NULL, NULL),
(3, 'Item Found TEST 2', '12-24-009-1720758557-0.jpg', 'found', '12', 'shhdjd jsjsjsh jsjsjsj jdjdjjd djjdjdhd jsjsjdj sjjsjdj sjsjhshs jdjsjsjs jsjsjsjs jsjsjsjs', 'PWMH+5M8, Wag wag St, Science City of Muñoz, Nueva Ecija, Philippines', '2024-07-12 06:29:17', 'reporter', '24-009', 'Posted', 15.73321385, 120.92968564, NULL, NULL),
(4, 'Lost Item TEST 2', '12-24-0000-1720761671-0.jpg', 'lost', '12', 'dasdsad dasdsad dsadsadsa dsadsad dsadsadsad dsadsad dsadsad d asd sadsadas dsadsad dsad s dasdsad dasdsad dsadsadsa dsadsad dsadsadsad dsadsad dsadsad d asd sadsadas dsadsad dsad s', 'Home Management Lab Building, Executive Ave, Science City of Muñoz, Nueva Ecija, Philippines', '2024-07-12 07:21:11', NULL, '24-0000', 'Posted', 15.73303360, 120.92794172, NULL, NULL),
(5, 'Item Found', '13-24-0000-1720762591-0.jpg', 'found', '13', 'fsdfdsff f sdfsdfdsf fdsfdsf fdsfdsf fsdfsdf ', 'PWMH+MFV GAMMA EPSILON Fraternity/Sorority Park, Central Luzon State University, CLSU, Science City of Muñoz, Nueva Ecija, Philippines', '2024-07-12 07:36:31', 'reporter', '24-0000', 'Posted', 15.73427283, 120.92845670, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `Message_ID` varchar(11) NOT NULL,
  `Sender_ID` varchar(11) NOT NULL,
  `Receiver_ID` varchar(11) NOT NULL,
  `Message_Text` text NOT NULL,
  `Timestamp` datetime DEFAULT current_timestamp(),
  `Read_Status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `Notification_ID` varchar(11) NOT NULL,
  `User_ID` varchar(11) DEFAULT NULL,
  `Notification_Text` text DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `User_ID` varchar(11) NOT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Avatar_Image` varchar(255) DEFAULT NULL,
  `College` varchar(100) DEFAULT NULL,
  `Course` varchar(100) DEFAULT NULL,
  `CLSU_ID_Image` varchar(255) DEFAULT NULL,
  `Home_Address` varchar(255) DEFAULT NULL,
  `CLSU_Address` varchar(255) DEFAULT NULL,
  `Contact` varchar(20) DEFAULT NULL,
  `Social_Links` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `User_ID`, `Role`, `Username`, `FullName`, `Password`, `Email`, `Avatar_Image`, `College`, `Course`, `CLSU_ID_Image`, `Home_Address`, `CLSU_Address`, `Contact`, `Social_Links`) VALUES
(1, '24-0000', 'Student', 'patty', 'Patricia Bagarra', '$2y$10$8rkgmlSEAVQZRlL8/D1J5uTba4k5OMIn2.qJIh.gHDKKRM6j0X.v6', 'bagarrap@gmail.com', '24-0000.jpg', 'College of Engineering', 'Bachelor of Science in Information Technology (BSIT)', '24-0000.jpg', 'Home Address', 'CLSU Address', '+639760120147', 'm.me/nyaw.cia'),
(2, '24-009', 'Student', 'xavier', 'Xavier Carl Astrero', '$2y$10$ICqreNT8GFW14HLvlQZZ9eHhqTRQb24bme5xpl6p6Ec2szkf21Ugu', 'astreroxavier@gmail.com', '24-009.jpeg', 'College of Engineering', 'Bachelor of Science in Information Technology (BSIT)', '24-009.jpg', 'Home Addresssdsss', 'CLSU Address', '+639667495688', 'm.me/xaviercarlastrero');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_timeline`
--
ALTER TABLE `activity_timeline`
  ADD PRIMARY KEY (`Activity_ID`),
  ADD KEY `Actor_ID` (`Actor_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `claims`
--
ALTER TABLE `claims`
  ADD PRIMARY KEY (`Claim_ID`),
  ADD KEY `Item_ID` (`Item_ID`),
  ADD KEY `Claimer_ID` (`Claimer_ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `Poster_ID` (`Poster_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`Message_ID`),
  ADD KEY `Sender_ID` (`Sender_ID`),
  ADD KEY `Receiver_ID` (`Receiver_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `User_ID` (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `claims`
--
ALTER TABLE `claims`
  MODIFY `Claim_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_timeline`
--
ALTER TABLE `activity_timeline`
  ADD CONSTRAINT `activity_timeline_ibfk_1` FOREIGN KEY (`Actor_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `claims`
--
ALTER TABLE `claims`
  ADD CONSTRAINT `claims_ibfk_2` FOREIGN KEY (`Claimer_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`Sender_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`Receiver_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
