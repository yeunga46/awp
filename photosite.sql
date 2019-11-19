-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2019 at 10:35 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


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
  `user_id` int(6) NOT NULL,
  `photo_id` int(8) NOT NULL,
  `comment_text` varchar(128) DEFAULT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_comments`
--

INSERT INTO `photo_comments` (`comment_id`, `user_id`, `photo_id`, `comment_text`, `comment_time`) VALUES
(1, 1, 3, 'test', '0000-00-00 00:00:00'),
(2, 22, 3, 'Howdy', '2019-11-17 23:56:18'),
(3, 22, 4, 'hello world', '2019-11-17 23:56:21'),
(4, 22, 4, 'hello world', '2019-11-17 23:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `photo_files`
--

CREATE TABLE `photo_files` (
  `photo_id` int(8) NOT NULL,
  `uploaddate` datetime NOT NULL DEFAULT current_timestamp(),
  `uploader` varchar(128) DEFAULT NULL,
  `title` varchar(140) NOT NULL,
  `caption` varchar(128) DEFAULT NULL,
  `filelocation` varchar(512) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_files`
--

INSERT INTO `photo_files` (`photo_id`, `uploaddate`, `uploader`, `title`, `caption`, `filelocation`, `user_id`) VALUES
(2, '2019-11-12 13:10:33', NULL, '', NULL, './UPLOADED/archive/test2/blue duck.png', 6),
(3, '2019-11-18 11:51:52', NULL, '', NULL, './UPLOADED/archive/ay/image1.png', 7),
(4, '2019-11-18 11:53:47', NULL, '', NULL, './UPLOADED/archive/ay/image1.png', 7),
(10, '2019-11-18 11:58:38', 'ay', '', NULL, './UPLOADED/archive/ay/image1.png', 7),
(11, '2019-11-19 13:36:19', 'tester', 'h', 'as', './UPLOADED/archive/tester/pokehyaku01b.jpg', 24),
(12, '2019-11-19 13:43:40', 'tester', 's', NULL, './UPLOADED/archive/tester/pokehyaku02b.jpg', 24),
(13, '2019-11-19 13:52:32', 'tester', '3', NULL, './UPLOADED/archive/tester/pokehyaku03b.jpg', 24),
(14, '2019-11-19 15:55:44', 'tester', 'ghost', NULL, './UPLOADED/archive/tester/pokehyaku04b.jpg', 24);

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
(5, '2019-11-12 16:14:59', 'test3', 'sasgugfuisl', 'acisgxfui', NULL, NULL),
(6, '2019-11-12 16:20:24', 'test8', 'g@g.com', '$2y$10$6no9n6FDEgcIVTniVLavYeDtyLeT/nSQz9/y9iHmJl.CbmOcO56/e', NULL, NULL),
(7, '2019-11-12 16:20:48', 'test2', 'g@g.com', '$2y$10$dUQs.cssoXnifBAH4qt2NOOH7hlWNBOeOC/xMObuT4Bil8NZoZ4ie', NULL, NULL),
(8, '2019-11-12 16:26:57', 'test4', '$2y$10$BSNhnQPg8YM0toPFswRB0eLVzZ.njdrZpnY/yXRLEwWrzObRsEGOi', 'a@a.com', NULL, NULL),
(19, '2019-11-12 16:33:01', 'yufyufgcyufy', '$2y$10$OonSXnKxMdCvyKaQZc5zxuptX507vBdp6F1HOHl39uexq8ONauSI2', 'fyufufyuf', NULL, NULL),
(21, '2019-11-12 16:37:21', 'test6', '$2y$10$D9YS5sexY/nz6Nb/TjxZgOZd9jVWzC/TGsxA7GRpWYJKCTJ4CT6la', 'hajuwb', NULL, NULL),
(22, '2019-11-12 16:37:44', 'test7', '$2y$10$lyYFvIp0DOYo9ZrUX6fziux17s.WXF1N0pBVr.89Cv5FHn7xtmWrq', 'they', 3, 'test guy'),
(24, '2019-11-18 02:01:01', 'tester', '$2y$10$XH/CQMC3Z77l44N2W8JODuG.VG9XmXcLfPalX7ZaqziDoRq2LO59C', 'tes.ting.com', 6, 'test guy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photo_comments`
--
ALTER TABLE `photo_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `photo_id` (`photo_id`);

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
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

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
  MODIFY `photo_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `photo_users`
--
ALTER TABLE `photo_users`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `photo_comments`
--
ALTER TABLE `photo_comments`
  ADD CONSTRAINT `photo_comments_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photo_files` (`photo_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
