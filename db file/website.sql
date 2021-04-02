-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2021 at 05:46 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `id` int(11) NOT NULL,
  `user_id` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `my_connections` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `request_from` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `request_to` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_bin DEFAULT NULL,
  `school` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `degree` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `edu_field` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `edu_from` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `edu_to` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `id1` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `id2` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `user1` varchar(60) COLLATE utf8mb4_bin DEFAULT NULL,
  `user2` varchar(60) COLLATE utf8mb4_bin DEFAULT NULL,
  `anonymous` int(11) DEFAULT NULL,
  `u_message` text COLLATE utf8mb4_bin DEFAULT NULL,
  `msg_time` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `read_user` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `image` varchar(145) COLLATE utf8mb4_bin DEFAULT NULL,
  `caption` text COLLATE utf8mb4_bin DEFAULT NULL,
  `image_timestamp` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `like_from` varchar(45) COLLATE utf8mb4_bin DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `name` varchar(145) NOT NULL,
  `avatar` varchar(45) NOT NULL,
  `anonymous_id` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `about` text NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_no` int(10) NOT NULL,
  `gender` int(11) NOT NULL,
  `image` varchar(80) NOT NULL,
  `skills` text NOT NULL,
  `modal` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `thought`
--

CREATE TABLE `thought` (
  `id` int(11) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `mood` varchar(45) NOT NULL,
  `thoughts` text NOT NULL,
  `timestamp` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`,`avatar`);

--
-- Indexes for table `thought`
--
ALTER TABLE `thought`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connections`
--
ALTER TABLE `connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thought`
--
ALTER TABLE `thought`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
