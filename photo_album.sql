-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2022 at 07:25 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photo_album`
--

-- --------------------------------------------------------

--
-- Table structure for table `albummodel`
--

CREATE TABLE `albummodel` (
  `Id` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `commentmodel`
--

CREATE TABLE `commentmodel` (
  `Id` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `StatusId` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `WhoCommented` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likemodel`
--

CREATE TABLE `likemodel` (
  `Id` int(11) NOT NULL,
  `StatusId` int(11) NOT NULL,
  `WhoLiked` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `photomodel`
--

CREATE TABLE `photomodel` (
  `Id` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Path` text NOT NULL,
  `UploadedBy` int(11) NOT NULL,
  `AlbumId` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `statusmodel`
--

CREATE TABLE `statusmodel` (
  `Id` int(11) NOT NULL,
  `Status` text NOT NULL,
  `NumberOfLikes` int(11) NOT NULL,
  `PhotoId` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usermodel`
--

CREATE TABLE `usermodel` (
  `Id` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albummodel`
--
ALTER TABLE `albummodel`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `commentmodel`
--
ALTER TABLE `commentmodel`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `likemodel`
--
ALTER TABLE `likemodel`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `photomodel`
--
ALTER TABLE `photomodel`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `statusmodel`
--
ALTER TABLE `statusmodel`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `usermodel`
--
ALTER TABLE `usermodel`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albummodel`
--
ALTER TABLE `albummodel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `commentmodel`
--
ALTER TABLE `commentmodel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `likemodel`
--
ALTER TABLE `likemodel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `photomodel`
--
ALTER TABLE `photomodel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `statusmodel`
--
ALTER TABLE `statusmodel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `usermodel`
--
ALTER TABLE `usermodel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
