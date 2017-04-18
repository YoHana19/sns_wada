-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017 年 4 月 17 日 20:21
-- サーバのバージョン： 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sns_wada`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL COMMENT 'FK',
  `reciever_id` int(11) NOT NULL COMMENT 'FK',
  `room_id` int(11) NOT NULL COMMENT 'FK',
  `chat_1` varchar(255) NOT NULL,
  `chat_2` varchar(255) NOT NULL,
  `chat_3` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_id` int(11) NOT NULL COMMENT 'FK',
  `comment` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`comment_id`, `member_id`, `haiku_id`, `comment`, `created`, `modified`) VALUES
(1, 1, 3, 'ああああああああああああああああああああああああああああああああああああ', '2017-04-18 02:20:19', '2017-04-17 18:20:19'),
(2, 2, 3, 'いいいいいいいいいいいいいいいい', '2017-04-18 02:20:19', '2017-04-17 18:20:19'),
(3, 1, 3, 'ううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううううう', '2017-04-18 02:20:53', '2017-04-17 18:20:53'),
(4, 4, 3, 'ええええ', '2017-04-18 02:20:53', '2017-04-17 18:20:53');

-- --------------------------------------------------------

--
-- テーブルの構造 `dislikes`
--

CREATE TABLE `dislikes` (
  `member_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_member_id` int(11) NOT NULL COMMENT 'Fk'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `friends`
--

CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `login_member_id` int(11) NOT NULL COMMENT 'FK',
  `friend_member_id` int(11) NOT NULL COMMENT 'FK',
  `state` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `haikus`
--

CREATE TABLE `haikus` (
  `haiku_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_1` varchar(255) NOT NULL,
  `haiku_2` varchar(255) NOT NULL,
  `haiku_3` varchar(255) NOT NULL,
  `short_comment` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `haikus`
--

INSERT INTO `haikus` (`haiku_id`, `member_id`, `haiku_1`, `haiku_2`, `haiku_3`, `short_comment`, `created`, `modified`) VALUES
(1, 1, 'あああああ', 'あああああああ', 'あああああ', NULL, '2017-04-18 02:13:31', '2017-04-17 18:13:31'),
(2, 1, 'いいいいい', 'いいいいいいい', 'いいいいい', NULL, '2017-04-18 02:13:31', '2017-04-17 18:13:31'),
(3, 1, 'ううううう', 'ううううううう', 'ううううう', NULL, '2017-04-18 02:14:13', '2017-04-17 18:14:13'),
(4, 2, 'えええええ', 'えええええええ', 'えええええ', NULL, '2017-04-18 02:14:13', '2017-04-17 18:14:13'),
(5, 2, 'おおおおお', 'おおおおおおお', 'おおおおお', NULL, '2017-04-18 02:14:55', '2017-04-17 18:14:55'),
(6, 1, 'かかかかか', 'かかかかかかか', 'かかかかか', NULL, '2017-04-18 02:14:55', '2017-04-17 18:14:55'),
(7, 3, 'ききききき', 'ききききききき', 'ききききき', NULL, '2017-04-18 02:15:43', '2017-04-17 18:15:43'),
(8, 3, 'くくくくく', 'くくくくくくく', 'くくくくく', NULL, '2017-04-18 02:15:43', '2017-04-17 18:15:43'),
(9, 4, 'けけけけけ', 'けけけけけけけ', 'けけけけけ', NULL, '2017-04-18 02:16:27', '2017-04-17 18:16:27'),
(10, 4, 'こここここ', 'こここここここ', 'こここここ', NULL, '2017-04-18 02:16:27', '2017-04-17 18:16:27'),
(11, 2, 'さささささ', 'さささささささ', 'さささささ', NULL, '2017-04-18 02:17:09', '2017-04-17 18:17:09'),
(12, 4, 'ししししし', 'ししししししし', 'ししししし', NULL, '2017-04-18 02:17:09', '2017-04-17 18:17:09'),
(13, 2, 'すすすすす', 'すすすすすすす', 'すすすすす', NULL, '2017-04-18 02:17:57', '2017-04-17 18:17:57'),
(14, 1, 'せせせせせ', 'せせせせせせせ', 'せせせせせ', NULL, '2017-04-18 02:17:57', '2017-04-17 18:17:57'),
(15, 2, 'そそそそそ', 'そそそそそそそ', 'そそそそそ', NULL, '2017-04-18 02:18:43', '2017-04-17 18:18:43'),
(16, 1, 'たたたたた', 'たたたたたたた', 'たたたたた', NULL, '2017-04-18 02:18:43', '2017-04-17 18:18:43');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `member_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_member_id` int(11) NOT NULL COMMENT 'FK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `nick_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_picture_pass` varchar(255) NOT NULL DEFAULT 'no_img_user.jpg',
  `back_picture_pass` varchar(255) NOT NULL DEFAULT 'no_img_back.jpg',
  `self_intro` varchar(255) DEFAULT NULL,
  `bozu_points` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`member_id`, `nick_name`, `email`, `password`, `user_picture_pass`, `back_picture_pass`, `self_intro`, `bozu_points`, `created`, `modified`) VALUES
(1, '花嶋', 'yohanashima@gmail.com', 'hanashima', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '2017-04-18 02:11:32', '2017-04-17 18:11:32'),
(2, 'たかさん', 'taka@gmail.com', 'taka', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '2017-04-18 02:11:32', '2017-04-17 18:11:32'),
(3, 'こうせい', 'kousei@gmail.com', 'kousei', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '2017-04-18 02:12:32', '2017-04-17 18:12:32'),
(4, 'かみしょー', 'kami@gmail.com', 'kami', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '0000-00-00 00:00:00', '2017-04-17 18:12:32');

-- --------------------------------------------------------

--
-- テーブルの構造 `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL COMMENT 'FK',
  `reciever_id` int(11) NOT NULL COMMENT 'FK',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`);

--
-- Indexes for table `haikus`
--
ALTER TABLE `haikus`
  ADD PRIMARY KEY (`haiku_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `haikus`
--
ALTER TABLE `haikus`
  MODIFY `haiku_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
