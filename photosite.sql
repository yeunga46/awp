-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2019 at 03:11 AM
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
  `uploader` varchar(20) DEFAULT NULL,
  `comment_text` varchar(128) DEFAULT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_comments`
--

INSERT INTO `photo_comments` (`comment_id`, `user_id`, `photo_id`, `uploader`, `comment_text`, `comment_time`) VALUES
(8, 19, 12, NULL, NULL, '2019-11-24 00:15:34'),
(9, 21, 12, NULL, NULL, '2019-11-24 00:15:34'),
(10, 22, 12, NULL, NULL, '2019-11-24 00:15:34');

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
  `reset_password` tinyint(1) NOT NULL DEFAULT 0,
  `profile_pic_id` int(8) DEFAULT NULL,
  `bio` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_users`
--

INSERT INTO `photo_users` (`user_id`, `joindate`, `username`, `password`, `email`, `reset_password`, `profile_pic_id`, `bio`) VALUES
(19, '2019-11-12 16:33:01', 'yufyufgcyufy', '$2y$10$OonSXnKxMdCvyKaQZc5zxuptX507vBdp6F1HOHl39uexq8ONauSI2', 'fyufufyuf', 0, NULL, NULL),
(21, '2019-11-12 16:37:21', 'test6', '$2y$10$D9YS5sexY/nz6Nb/TjxZgOZd9jVWzC/TGsxA7GRpWYJKCTJ4CT6la', 'hajuwb', 0, NULL, NULL),
(22, '2019-11-12 16:37:44', 'test7', '$2y$10$lyYFvIp0DOYo9ZrUX6fziux17s.WXF1N0pBVr.89Cv5FHn7xtmWrq', 'they', 0, 3, 'test guy'),
(24, '2019-11-18 02:01:01', 'tester', '$2y$10$XH/CQMC3Z77l44N2W8JODuG.VG9XmXcLfPalX7ZaqziDoRq2LO59C', 'tes.ting.com', 0, 6, 'test guy');

--
-- Triggers `photo_users`
--
DELIMITER $$
CREATE TRIGGER `update_deleted_user_comment` AFTER DELETE ON `photo_users` FOR EACH ROW UPDATE `photo_comments` SET `uploader`= "[deleted]" WHERE `user_id` = OLD.`user_id`
$$
DELIMITER ;

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
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `comment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `photo_files`
--
ALTER TABLE `photo_files`
  MODIFY `photo_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `photo_users`
--
ALTER TABLE `photo_users`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `photo_comments`
--
ALTER TABLE `photo_comments`
  ADD CONSTRAINT `photo_comments_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photo_files` (`photo_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `photo_files`
--
ALTER TABLE `photo_files`
  ADD CONSTRAINT `photo_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `photo_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
