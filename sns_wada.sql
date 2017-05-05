-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017 年 5 月 05 日 07:42
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
  `back_img` int(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `chats`
--

INSERT INTO `chats` (`chat_id`, `sender_id`, `reciever_id`, `room_id`, `chat_1`, `chat_2`, `chat_3`, `back_img`, `created`, `modified`) VALUES
(6, 15, 17, 15, 'こんにちわ', '英語でいったら', 'グッモーニン', NULL, '2017-05-04 17:11:36', '2017-05-04 09:12:10'),
(7, 17, 15, 15, 'こんばんわ', '英語でいったら', 'グッイブニン', NULL, '2017-05-04 17:11:36', '2017-05-04 09:12:20');

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
(5, 14, 18, '何を思い出すの？', '2017-05-04 01:10:41', '2017-05-03 17:10:41'),
(6, 16, 18, '教えない????', '2017-05-04 01:12:29', '2017-05-03 17:12:29'),
(7, 12, 18, 'なんで？', '2017-05-04 01:41:33', '2017-05-03 17:41:33'),
(8, 14, 22, 'なにがあったの？', '2017-05-04 08:06:39', '2017-05-04 00:06:39'),
(9, 15, 22, 'なにがあった？', '2017-05-04 11:27:16', '2017-05-04 03:27:16'),
(10, 15, 32, '俺もさよちゃんと・・・。', '2017-05-04 17:07:23', '2017-05-04 09:07:23'),
(11, 15, 32, '付き合・・・。', '2017-05-04 17:37:53', '2017-05-04 09:37:53');

-- --------------------------------------------------------

--
-- テーブルの構造 `dislikes`
--

CREATE TABLE `dislikes` (
  `member_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_id` int(11) NOT NULL COMMENT 'FK',
  `haiku_member_id` int(11) NOT NULL COMMENT 'Fk'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `dislikes`
--

INSERT INTO `dislikes` (`member_id`, `haiku_id`, `haiku_member_id`) VALUES
(12, 17, 12),
(12, 18, 16),
(14, 18, 16),
(14, 17, 12),
(15, 20, 13),
(17, 20, 13),
(14, 30, 15),
(15, 30, 15),
(13, 30, 15),
(12, 30, 15),
(12, 29, 15),
(15, 31, 15),
(12, 34, 15);

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
(12, 14, 16, 1, '0000-00-00 00:00:00', '2017-05-03 17:11:16'),
(13, 13, 14, 1, '0000-00-00 00:00:00', '2017-05-03 22:52:14'),
(14, 13, 16, 1, '0000-00-00 00:00:00', '2017-05-03 18:31:03'),
(15, 13, 12, 1, '0000-00-00 00:00:00', '2017-05-03 17:26:55'),
(16, 15, 12, 1, '0000-00-00 00:00:00', '2017-05-04 04:59:50'),
(17, 15, 13, 1, '0000-00-00 00:00:00', '2017-05-04 03:29:45'),
(19, 17, 15, 1, '0000-00-00 00:00:00', '2017-05-04 00:08:14'),
(20, 17, 13, 1, '0000-00-00 00:00:00', '2017-05-04 03:29:46'),
(21, 16, 17, 1, '0000-00-00 00:00:00', '2017-05-04 03:41:17'),
(22, 16, 12, 1, '0000-00-00 00:00:00', '2017-05-04 04:59:52'),
(23, 16, 15, 1, '0000-00-00 00:00:00', '2017-05-04 00:08:15'),
(24, 15, 16, 1, '0000-00-00 00:00:00', '2017-05-04 05:02:36'),
(25, 15, 17, 1, '0000-00-00 00:00:00', '2017-05-04 03:41:18'),
(26, 14, 15, 1, '0000-00-00 00:00:00', '2017-05-04 03:25:59'),
(27, 12, 14, 0, '0000-00-00 00:00:00', '2017-05-04 05:01:57'),
(28, 12, 15, 0, '0000-00-00 00:00:00', '2017-05-04 05:02:05'),
(29, 12, 16, 1, '0000-00-00 00:00:00', '2017-05-04 05:02:37');

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
(17, 12, 'さまざまな', 'ことおもいだす', 'さくらかな', '20170502182448sakura_sample.jpg', 'もうこんな季節か。。。', '2017-05-03 19:06:03', '2017-05-03 11:06:03'),
(18, 16, 'さまざまな', 'ことおもいだす', 'さくらかな', '', 'もうこんな季節か', '2017-05-03 19:10:27', '2017-05-03 11:10:27'),
(19, 14, 'いちおぼえ', 'にわすれてく', 'ろうかかな', '', '最近物覚えが悪いな。。。', '2017-05-04 01:17:46', '2017-05-03 17:17:46'),
(20, 13, 'ボキャたりず', 'へんとういつも', 'ヤーばかり', '', '', '2017-05-04 01:19:35', '2017-05-03 17:19:35'),
(21, 12, 'そらいちめん', 'うろこぐもが', 'うかんでる', '', 'なつだなー', '2017-05-04 01:35:23', '2017-05-03 17:35:23'),
(22, 12, 'めぐるなつ', 'もどれぬあのひ', 'あのえがお', '', '', '2017-05-04 01:37:39', '2017-05-03 17:37:39'),
(23, 12, 'ゆめごごち', 'あめのにおいと', 'かぜのおと', '', '', '2017-05-04 01:39:44', '2017-05-03 17:39:44'),
(24, 15, 'さくらまう', 'きたかぜにのり', 'ひらひらと', '', 'さくらがきれいだなー', '2017-05-04 01:44:42', '2017-05-03 17:44:42'),
(25, 17, 'なつやすみ', 'はやくセブで', 'あそびたい', '', '夏休みにはセブにcome backするぞ！！', '2017-05-04 01:48:44', '2017-05-03 17:48:44'),
(26, 17, 'さくもよし', 'ちるもうつくし', 'さくらかな', '', '', '2017-05-04 01:56:50', '2017-05-03 17:56:50'),
(27, 17, 'よざくらに', 'いろづくあかり', 'さくらいろ', '', 'やっぱりよざくらいいね！！', '2017-05-04 02:30:06', '2017-05-03 18:30:06'),
(28, 16, 'おねえさん', 'トレンディーだね', 'さいとうさん', '', '', '2017-05-04 02:38:07', '2017-05-03 18:38:07'),
(29, 15, 'あかいいと', 'はやくみたいよ', 'いとのさき', '', '運命の人は誰だろう？笑', '2017-05-04 11:09:09', '2017-05-04 03:09:09'),
(30, 15, 'あかいいと', 'さきにはきみが', 'いてほしい', '', 'くさっ！', '2017-05-04 11:12:51', '2017-05-04 03:12:51'),
(31, 15, 'さくらみて', 'きもちあらたに', 'はるのあさ', '', '今日から新年度かー', '2017-05-04 11:15:34', '2017-05-04 03:15:34'),
(32, 14, 'セブにきて', 'またせいしゅん', 'やってきた', '', '毎日楽しいな＼(^o^)／', '2017-05-04 11:24:37', '2017-05-04 03:24:37'),
(34, 15, 'あああああ', 'あああああああ', 'あああああ', '20170504113846', '', '2017-05-04 17:38:46', '2017-05-04 09:38:46');

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
(12, 17, 12),
(12, 18, 16),
(14, 18, 16),
(13, 18, 16),
(12, 22, 12),
(15, 23, 12),
(15, 19, 14),
(17, 24, 15),
(17, 23, 12),
(17, 20, 13),
(16, 27, 17),
(16, 26, 17),
(16, 25, 17),
(14, 23, 12),
(14, 22, 12),
(15, 22, 12),
(15, 20, 13),
(13, 32, 14),
(13, 25, 17),
(12, 32, 14),
(12, 31, 15),
(12, 26, 17),
(15, 32, 14),
(15, 31, 15),
(15, 28, 16),
(13, 34, 15);

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
  `self_intro_1` varchar(255) DEFAULT NULL,
  `self_intro_2` varchar(255) DEFAULT NULL,
  `self_intro_3` varchar(255) DEFAULT NULL,
  `bozu_points` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`member_id`, `nick_name`, `email`, `password`, `user_picture_path`, `back_picture_path`, `self_intro_1`, `self_intro_2`, `self_intro_3`, `bozu_points`, `created`, `modified`) VALUES
(12, '花嶋陽', 'yohanashima@gmail.com', '6a981c2f3a4a50822fcc779fecca012094585816', '20170503144120IMG_1785.JPG', '20170503144120hanabi1.JPG', 'はなびちる', 'そのはかなさに', 'ゆめかたり', 0, '2017-05-03 18:52:46', '2017-05-03 12:41:20'),
(13, 'たか', 'taka@gmail.com', 'c882f80eb6148f8368ddf97fe940f51337f66d42', '201705031507223月10日　Graduation_170503_0021.jpg', '20170503150722himawari.jpg', 'ひまわりに', 'まけないほどの', 'いいえがお', 0, '2017-05-03 18:54:27', '2017-05-03 13:07:22'),
(14, '由佳', 'yuka@gmail.com', '8b53db575bea4ec5ed856b051211083fa1600b6d', '20170503175509yuka.png', '20170503175509sakura_sample.jpg', 'さまざまな', 'ことおもひだす', 'さくらかな', 0, '2017-05-03 18:55:05', '2017-05-03 15:55:09'),
(15, '今人', 'imajin@gmail.com', '6f263507309f6e9461d7c041dfd1fb3c413faf31', '20170503172410IMG_1786.JPG', '20170503172410nanohana3.jpg', 'なのはなと', 'きみのえがおが', 'ならんでる', 6, '2017-05-03 18:55:53', '2017-05-04 09:38:46'),
(16, 'kamiya', 'kamiya@gmail.com', '549c54041db8263bcc72bdfeef842f94059a3258', '20170503190604IMG_1778.JPG', '20170503190604kenka.jpg', 'いまおきた', 'ちこくかくてい', 'ごめんなさい', 0, '2017-05-03 18:56:30', '2017-05-03 17:06:04'),
(17, '晃成', 'kosei@gmail.com', 'ccdb0a5286da3279b7a23798bdbfee8c28d8786a', '20170503172051kosei.jpg', '20170503172051koyo.jpg', 'あきかぜが', 'おちばをおとす', 'なみきみち', 0, '2017-05-03 18:57:22', '2017-05-03 15:20:51');

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
(14, 15, 16, '2017-05-04 16:07:59', '2017-05-04 08:08:37'),
(15, 15, 17, '2017-05-04 16:07:59', '2017-05-04 08:08:48');

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
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `haikus`
--
ALTER TABLE `haikus`
  MODIFY `haiku_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
