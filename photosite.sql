-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2019 at 10:48 PM
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
CREATE DATABASE IF NOT EXISTS `photosite` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `photosite`;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `photo_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `photo_id`, `user_id`) VALUES
(207, 13, 24),
(321, 49, 22);

--
-- Triggers `likes`
--
DROP TRIGGER IF EXISTS `like_delete_update _count`;
DELIMITER $$
CREATE TRIGGER `like_delete_update _count` AFTER DELETE ON `likes` FOR EACH ROW UPDATE `photo_files` SET `likes`= (SELECT COUNT(*) FROM `likes` WHERE `photo_id` = OLD.`photo_id`) WHERE `photo_id` = OLD.`photo_id`
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `like_insert_update_count`;
DELIMITER $$
CREATE TRIGGER `like_insert_update_count` AFTER INSERT ON `likes` FOR EACH ROW UPDATE `photo_files` SET `likes`= (SELECT COUNT(*) FROM `likes` WHERE `photo_id` = NEW.`photo_id`) WHERE `photo_id` = NEW.`photo_id`
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `photo_comments`
--

DROP TABLE IF EXISTS `photo_comments`;
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
(8, 19, 12, '[deleted]', 'another thing', '2019-11-24 00:15:34'),
(9, 21, 12, '[deleted]', 'something', '2019-11-24 00:15:34'),
(10, 22, 12, 'test7', 'one more thing', '2019-11-24 00:15:34'),
(25, 24, 14, 'tester', 'hello', '2019-12-10 05:53:49'),
(27, 24, 51, 'tester', 'hi', '2019-12-10 08:55:33'),
(28, 24, 61, 'tester', '&lt;h1&gt;Quack!&lt;/h1&gt;', '2019-12-10 13:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `photo_files`
--

DROP TABLE IF EXISTS `photo_files`;
CREATE TABLE `photo_files` (
  `photo_id` int(8) NOT NULL,
  `uploaddate` datetime NOT NULL DEFAULT current_timestamp(),
  `uploader` varchar(128) DEFAULT NULL,
  `title` varchar(140) DEFAULT NULL,
  `caption` varchar(128) DEFAULT NULL,
  `likes` int(8) NOT NULL DEFAULT 0,
  `filelocation` varchar(512) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_files`
--

INSERT INTO `photo_files` (`photo_id`, `uploaddate`, `uploader`, `title`, `caption`, `likes`, `filelocation`, `user_id`) VALUES
(12, '2019-11-19 13:43:40', 'tester', 's', NULL, 0, './UPLOADED/archive/tester/pokehyaku02b.jpg', 24),
(13, '2019-11-19 13:52:32', 'tester', '3', NULL, 1, './UPLOADED/archive/tester/pokehyaku03b.jpg', 24),
(14, '2019-11-19 15:55:44', 'tester', 'ghost', NULL, 0, './UPLOADED/archive/tester/pokehyaku04b.jpg', 24),
(49, '2019-12-10 01:02:16', 'tester', 'Mario', 'Fire Flower?', 1, './UPLOADED/archive/tester/marioblock.png', 24),
(50, '2019-12-10 02:53:47', 'tester', 'sun', '<h1>All good!</h1>', 0, './UPLOADED/archive/tester/waterfalls-during-sunset-954929.jpg', 24),
(51, '2019-12-10 03:02:38', 'tester', 'Pardon the Interuption', '<Slurp noise>', 0, './UPLOADED/archive/tester/baby yoda.gif', 24),
(59, '2019-12-10 08:39:22', 'tester', NULL, NULL, 0, './UPLOADED/archive/tester/icon/deer.png', 24),
(61, '2019-12-10 08:49:15', 'tester', '<h1>Quack!</h1>', '<h1>Quack!</h1>', 0, './UPLOADED/archive/tester/blue duck.png', 24);

-- --------------------------------------------------------

--
-- Table structure for table `photo_users`
--

DROP TABLE IF EXISTS `photo_users`;
CREATE TABLE `photo_users` (
  `user_id` int(6) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(20) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `reset_password` tinyint(1) NOT NULL DEFAULT 0,
  `confirm_code` varchar(256) DEFAULT NULL,
  `profile_pic_id` int(8) DEFAULT NULL,
  `bio` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photo_users`
--

INSERT INTO `photo_users` (`user_id`, `joindate`, `username`, `password`, `email`, `reset_password`, `confirm_code`, `profile_pic_id`, `bio`) VALUES
(22, '2019-11-12 16:37:44', 'test7', '$2y$10$lyYFvIp0DOYo9ZrUX6fziux17s.WXF1N0pBVr.89Cv5FHn7xtmWrq', 'they', 0, NULL, 3, 'test guy'),
(24, '2019-11-18 02:01:01', 'tester', '$2y$10$zPlHP.48LAQZ/wq7f9Mw2OUYFc9v.lT55yifHxTMbroyLVjpgvi/u', 'tes.ting.com', 0, '2f8cd645a2008edf7f5bb1234ffa09b39d5b9164', 59, 'The End');

--
-- Triggers `photo_users`
--
DROP TRIGGER IF EXISTS `update_deleted_user_comment`;
DELIMITER $$
CREATE TRIGGER `update_deleted_user_comment` AFTER DELETE ON `photo_users` FOR EACH ROW UPDATE `photo_comments` SET `uploader`= "[deleted]" WHERE `user_id` = OLD.`user_id`
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `photo_id` (`photo_id`);

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
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;

--
-- AUTO_INCREMENT for table `photo_comments`
--
ALTER TABLE `photo_comments`
  MODIFY `comment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `photo_files`
--
ALTER TABLE `photo_files`
  MODIFY `photo_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `photo_users`
--
ALTER TABLE `photo_users`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photo_files` (`photo_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
