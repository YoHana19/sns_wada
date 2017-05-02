-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017 年 4 月 26 日 13:55
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
  `back_img` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `chats`
--

INSERT INTO `chats` (`chat_id`, `sender_id`, `reciever_id`, `room_id`, `chat_1`, `chat_2`, `chat_3`, `back_img`, `created`, `modified`) VALUES
(1, 1, 2, 1, 'こんにちわ', 'こんこんにちわ', 'こんにちわ', NULL, '2017-04-26 08:45:35', '2017-04-26 00:45:35'),
(2, 2, 1, 1, 'こんばんわ', 'こんこんばんわ', 'こんばんわ', NULL, '2017-04-26 08:45:35', '2017-04-26 11:53:06'),
(3, 1, 2, 1, 'ははははは', 'ははははははは', 'はははは', NULL, '2017-04-26 13:19:14', '2017-04-26 05:19:14'),
(4, 1, 2, 1, 'ふふふふ', 'ふふふふふふふ', 'ふふふふふ', NULL, '2017-04-26 13:19:14', '2017-04-26 05:19:14'),
(5, 2, 1, 1, 'へへへへ', 'へへへへへへ', 'へへへへへ', NULL, '2017-04-26 13:26:56', '2017-04-26 11:53:51'),
(6, 1, 3, 3, 'ほほおほほ', 'ほほほほほほ', 'ほほほほほほ', NULL, '2017-04-26 13:26:56', '2017-04-26 05:26:56'),
(7, 1, 2, 1, 'あかかかか', 'じゃじゃじゃじ', 'さささささ', '', '2017-04-26 14:09:05', '2017-04-26 06:09:05');

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
(4, 4, 3, 'ええええ', '2017-04-18 02:20:53', '2017-04-17 18:20:53'),
(5, 2, 4, 'かかかっかああああああああああああああああああああああああああああ', '2017-04-19 07:14:12', '2017-04-18 23:14:12'),
(6, 1, 3, 'こんにちわ', '2017-04-19 19:40:49', '2017-04-19 11:40:49'),
(7, 1, 4, 'テスト', '2017-04-19 19:42:11', '2017-04-19 11:42:11'),
(8, 1, 6, 'はーい', '2017-04-19 19:42:49', '2017-04-19 11:42:49'),
(9, 1, 7, 'おーす', '2017-04-19 20:00:36', '2017-04-19 12:00:36'),
(10, 1, 9, 'やっほー', '2017-04-19 20:01:15', '2017-04-19 12:01:15'),
(11, 1, 9, 'なんで', '2017-04-19 20:02:23', '2017-04-19 12:02:23'),
(12, 1, 9, 'きたっしょ', '2017-04-19 20:06:41', '2017-04-19 12:06:41'),
(13, 1, 9, '順序', '2017-04-19 20:11:40', '2017-04-19 12:11:40'),
(14, 1, 9, 'じかん', '2017-04-19 20:13:49', '2017-04-19 12:13:49'),
(15, 1, 6, 'じゃじゃ', '2017-04-19 20:14:02', '2017-04-19 12:14:02'),
(16, 1, 15, 'はあできない', '2017-04-23 23:46:53', '2017-04-23 15:46:53'),
(17, 1, 15, 'いかに', '2017-04-24 01:12:09', '2017-04-23 17:12:09'),
(18, 1, 7, 'どや', '2017-04-24 01:12:17', '2017-04-23 17:12:17'),
(19, 1, 6, 'まじか', '2017-04-24 01:12:24', '2017-04-23 17:12:24'),
(20, 1, 16, 'おーい', '2017-04-24 01:14:51', '2017-04-23 17:14:51'),
(21, 1, 10, 'ｈ', '2017-04-24 01:17:07', '2017-04-23 17:17:07'),
(22, 1, 11, 'ねむい', '2017-04-24 01:17:43', '2017-04-23 17:17:43'),
(23, 1, 15, 'まじでねむい', '2017-04-24 01:17:53', '2017-04-23 17:17:53'),
(24, 1, 4, 'え？', '2017-04-24 02:08:12', '2017-04-23 18:08:12'),
(25, 1, 4, 'まさか', '2017-04-24 02:09:36', '2017-04-23 18:09:36'),
(26, 1, 1, 'だよね', '2017-04-24 02:09:42', '2017-04-23 18:09:42'),
(27, 1, 1, 'ひ', '2017-04-24 02:10:45', '2017-04-23 18:10:45'),
(28, 1, 12, 'うん', '2017-04-24 02:10:50', '2017-04-23 18:10:50');

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

--
-- テーブルのデータのダンプ `friends`
--

INSERT INTO `friends` (`friend_id`, `login_member_id`, `friend_member_id`, `state`, `created`, `modified`) VALUES
(1, 1, 2, 0, '2017-04-25 19:26:16', '2017-04-25 14:36:43'),
(2, 1, 3, 1, '2017-04-25 19:26:16', '2017-04-25 14:46:42');

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
  `back_img` varchar(255) DEFAULT NULL,
  `short_comment` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `haikus`
--

INSERT INTO `haikus` (`haiku_id`, `member_id`, `haiku_1`, `haiku_2`, `haiku_3`, `back_img`, `short_comment`, `created`, `modified`) VALUES
(1, 1, 'あああああ', 'あああああああ', 'あああああ', NULL, NULL, '2017-04-18 02:13:31', '2017-04-17 18:13:31'),
(2, 1, 'いいいいい', 'いいいいいいい', 'いいいいい', NULL, NULL, '2017-04-18 02:13:31', '2017-04-17 18:13:31'),
(3, 1, 'ううううう', 'ううううううう', 'ううううう', NULL, NULL, '2017-04-18 02:14:13', '2017-04-17 18:14:13'),
(4, 2, 'えええええ', 'えええええええ', 'えええええ', NULL, NULL, '2017-04-18 02:14:13', '2017-04-17 18:14:13'),
(5, 2, 'おおおおお', 'おおおおおおお', 'おおおおお', NULL, NULL, '2017-04-18 02:14:55', '2017-04-17 18:14:55'),
(6, 1, 'かかかかか', 'かかかかかかか', 'かかかかか', NULL, NULL, '2017-04-18 02:14:55', '2017-04-17 18:14:55'),
(7, 3, 'ききききき', 'ききききききき', 'ききききき', NULL, NULL, '2017-04-18 02:15:43', '2017-04-17 18:15:43'),
(8, 3, 'くくくくく', 'くくくくくくく', 'くくくくく', NULL, NULL, '2017-04-18 02:15:43', '2017-04-17 18:15:43'),
(9, 4, 'けけけけけ', 'けけけけけけけ', 'けけけけけ', NULL, NULL, '2017-04-18 02:16:27', '2017-04-17 18:16:27'),
(10, 4, 'こここここ', 'こここここここ', 'こここここ', NULL, NULL, '2017-04-18 02:16:27', '2017-04-17 18:16:27'),
(11, 2, 'さささささ', 'さささささささ', 'さささささ', NULL, NULL, '2017-04-18 02:17:09', '2017-04-17 18:17:09'),
(12, 4, 'ししししし', 'ししししししし', 'ししししし', NULL, NULL, '2017-04-18 02:17:09', '2017-04-17 18:17:09'),
(13, 2, 'すすすすす', 'すすすすすすす', 'すすすすす', NULL, NULL, '2017-04-18 02:17:57', '2017-04-17 18:17:57'),
(14, 1, 'せせせせせ', 'せせせせせせせ', 'せせせせせ', NULL, NULL, '2017-04-18 02:17:57', '2017-04-17 18:17:57'),
(15, 2, 'そそそそそ', 'そそそそそそそ', 'そそそそそ', NULL, NULL, '2017-04-18 02:18:43', '2017-04-17 18:18:43'),
(16, 1, 'あいうえお', 'あいうえおかき', 'あいうえお', '', '', '2017-04-25 18:22:41', '2017-04-25 10:22:41'),
(17, 1, 'かいきかか', 'かいうえおかい', 'さしえるか', 'back.jpg', 'かかさしえ', '2017-04-25 18:24:11', '2017-04-25 10:24:11'),
(18, 1, 'ああああ', 'ああああああ', 'ああああ', 'back.jpg', '', '2017-04-25 18:32:19', '2017-04-25 10:32:19');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `member_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_member_id` int(11) NOT NULL COMMENT 'FK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`member_id`, `haiku_id`, `haiku_member_id`) VALUES
(1, 11, 2),
(1, 6, 1),
(1, 15, 2),
(2, 16, 1),
(2, 14, 1),
(1, 16, 1),
(1, 14, 1),
(1, 4, 2),
(1, 1, 1),
(1, 12, 4),
(1, 5, 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `nick_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_picture_path` varchar(255) NOT NULL DEFAULT 'no_img_user.jpg',
  `back_picture_path` varchar(255) NOT NULL DEFAULT 'no_img_back.jpg',
  `self_intro` varchar(255) DEFAULT NULL,
  `bozu_points` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`member_id`, `nick_name`, `email`, `password`, `user_picture_path`, `back_picture_path`, `self_intro`, `bozu_points`, `created`, `modified`) VALUES
(1, '花嶋', 'yohanashima@gmail.com', 'hanashima', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '2017-04-18 02:11:32', '2017-04-17 18:11:32'),
(2, 'たかさん', 'taka@gmail.com', 'taka', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '2017-04-18 02:11:32', '2017-04-17 18:11:32'),
(3, 'こうせい', 'kousei@gmail.com', 'kousei', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '2017-04-18 02:12:32', '2017-04-17 18:12:32'),
(4, 'かみしょー', 'kami@gmail.com', 'kami', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '0000-00-00 00:00:00', '2017-04-17 18:12:32'),
(5, 'ベジータ', 'beji@gmail.com', 'beji', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '2017-04-25 22:34:21', '2017-04-25 14:34:21'),
(6, 'カカロット', 'kaka@gmail.com', 'kaka', 'no_img_user.jpg', 'no_img_back.jpg', NULL, 0, '2017-04-25 22:34:21', '2017-04-25 14:34:21');

-- --------------------------------------------------------

--
-- テーブルの構造 `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `member_id_1` int(11) NOT NULL COMMENT 'FK',
  `member_id_2` int(11) NOT NULL COMMENT 'FK',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `rooms`
--

INSERT INTO `rooms` (`room_id`, `member_id_1`, `member_id_2`, `created`, `modified`) VALUES
(1, 1, 2, '2017-04-26 08:44:12', '2017-04-26 00:44:12'),
(3, 1, 3, '2017-04-26 13:28:01', '2017-04-26 05:28:01'),
(4, 2, 3, '2017-04-26 15:00:46', '2017-04-26 07:00:46'),
(5, 4, 1, '2017-04-26 15:00:46', '2017-04-26 07:00:46');

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
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `haikus`
--
ALTER TABLE `haikus`
  MODIFY `haiku_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
