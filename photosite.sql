-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2019 at 03:11 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE photosite;
USE photosite;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photosite`
--

-- --------------------------------------------------------

--
-- Table structure for table `photo_comments`
--

CREATE TABLE `photo_comments` (
  `comment_id` int(8) NOT NULL,
  `user_id` int(6) DEFAULT NULL,
  `photo_id` int(8) DEFAULT NULL,
  `comment_text` varchar(128) DEFAULT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_comments`
--

INSERT INTO `photo_comments` (`comment_id`, `user_id`, `photo_id`, `comment_text`, `comment_time`) VALUES
(1, 0, 0, 'test', '0000-00-00 00:00:00'),
(2, 22, 0, 'Howdy', '2019-11-17 23:56:18'),
(3, 22, 0, 'hello world', '2019-11-17 23:56:21'),
(4, 22, 0, 'hello world', '2019-11-17 23:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `photo_files`
--

CREATE TABLE `photo_files` (
  `photo_id` int(8) NOT NULL,
  `uploaddate` datetime NOT NULL DEFAULT current_timestamp(),
  `uploader` varchar(128) DEFAULT NULL,
  `caption` varchar(128) DEFAULT NULL,
  `filelocation` varchar(512) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_files`
--

INSERT INTO `photo_files` (`photo_id`, `uploaddate`, `uploader`, `caption`, `filelocation`, `user_id`) VALUES
(1, '2019-11-12 13:08:14', '', '', './UPLOADED/archive/test2/blue duck.png', 6),
(2, '2019-11-12 13:10:33', NULL, NULL, './UPLOADED/archive/test2/blue duck.png', 6);

-- --------------------------------------------------------

--
-- Table structure for table `photo_users`
--

CREATE TABLE `photo_users` (
  `user_id` int(6) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(20) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `profile_pic_id` int(8) DEFAULT NULL,
  `bio` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_users`
--

INSERT INTO `photo_users` (`user_id`, `joindate`, `username`, `password`, `email`, `profile_pic_id`, `bio`) VALUES
(1, '2019-11-11 22:51:02', 'test', 'blue', 'test.test.com', NULL, NULL),
(2, '2019-11-12 16:13:03', 'test', 'sagugfuisl', 'acisgfui', NULL, NULL),
(5, '2019-11-12 16:14:59', 'test3', 'sasgugfuisl', 'acisgxfui', NULL, NULL),
(6, '2019-11-12 16:20:24', 'test2', 'g@g.com', '$2y$10$6no9n6FDEgcIVTniVLavYeDtyLeT/nSQz9/y9iHmJl.CbmOcO56/e', NULL, NULL),
(7, '2019-11-12 16:20:48', 'test2', 'g@g.com', '$2y$10$dUQs.cssoXnifBAH4qt2NOOH7hlWNBOeOC/xMObuT4Bil8NZoZ4ie', NULL, NULL),
(8, '2019-11-12 16:26:57', 'test4', '$2y$10$BSNhnQPg8YM0toPFswRB0eLVzZ.njdrZpnY/yXRLEwWrzObRsEGOi', 'a@a.com', NULL, NULL),
(19, '2019-11-12 16:33:01', 'yufyufgcyufy', '$2y$10$OonSXnKxMdCvyKaQZc5zxuptX507vBdp6F1HOHl39uexq8ONauSI2', 'fyufufyuf', NULL, NULL),
(21, '2019-11-12 16:37:21', 'test6', '$2y$10$D9YS5sexY/nz6Nb/TjxZgOZd9jVWzC/TGsxA7GRpWYJKCTJ4CT6la', 'hajuwb', NULL, NULL),
(22, '2019-11-12 16:37:44', 'test7', '$2y$10$lyYFvIp0DOYo9ZrUX6fziux17s.WXF1N0pBVr.89Cv5FHn7xtmWrq', 'they', NULL, NULL),
(24, '2019-11-18 02:01:01', 'tester', '$2y$10$XH/CQMC3Z77l44N2W8JODuG.VG9XmXcLfPalX7ZaqziDoRq2LO59C', 'tes.ting.com', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photo_comments`
--
ALTER TABLE `photo_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `photo_files`
--
ALTER TABLE `photo_files`
  ADD PRIMARY KEY (`photo_id`);

--
-- Indexes for table `photo_users`
--
ALTER TABLE `photo_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photo_comments`
--
ALTER TABLE `photo_comments`
  MODIFY `comment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `photo_files`
--
ALTER TABLE `photo_files`
  MODIFY `photo_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `photo_users`
--
ALTER TABLE `photo_users`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
