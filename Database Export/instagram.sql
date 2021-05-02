-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2020 at 03:12 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instagram`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `countfollowers` (IN `profile_id` INT)  SELECT  COUNT(follower.follower_id) as total_followers
FROM users INNER JOIN follower
ON users.id = follower.account_id
WHERE users.id = profile_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_comments` (IN `post_id` INT)  SELECT COUNT(comment.user_id) as total_comments FROM comment WHERE comment.post_id = post_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_following` (IN `profile_id` INT)  SELECT  COUNT(following.following_id) as total_following
FROM users INNER JOIN following 
ON users.id = following.account_id
WHERE users.id = profile_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_likes` (IN `post_id` INT)  SELECT  COUNT(likes.user_id)
FROM post INNER JOIN likes
ON post.id = likes.post_id
WHERE post.id = post_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `count_posts` (IN `profile_id` INT)  SELECT  COUNT(post.user_id)   FROM `post` WHERE post.user_id =  profile_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_comments` (IN `post_id` INT)  SELECT * FROM user_comment WHERE user_comment.post_id = post_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_followers` (IN `profile_id` INT)  SELECT userfollowers.followers_list as follower_list
FROM `userfollowers` WHERE userfollowers.user_id = profile_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_following` (IN `profile_id` INT)  SELECT userfollowing.following_list as following_list FROM `userfollowing` WHERE userfollowing.user_id = profile_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_likes` (IN `post_id` INT)  SELECT likes.user_id FROM `likes` WHERE likes.post_id= post_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_posts` (IN `profile_id` INT)  SELECT  post.id as post_id, post.title FROM `post` WHERE post.user_id = profile_id ORDER BY `id` DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_random_like` (IN `post_id` INT, IN `user_id` INT)  NO SQL
SELECT * FROM user_like WHERE 
user_like.post_id = post_id And user_like.user_id = user_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `txt` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `txt`, `date`, `user_id`, `post_id`) VALUES
(11, 'Happy Birth Day John', '2020-12-17 02:55:43', 47, 33),
(22, 'kkkkkkkkkk\r\n', '2020-12-17 17:00:31', 47, 35),
(23, 'Pretty PLace ', '2020-12-17 17:25:27', 52, 32),
(24, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaavaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2020-12-17 18:01:23', 52, 32),
(25, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2020-12-17 18:01:36', 52, 32),
(26, 'Nice Photoo Khabib', '2020-12-19 01:44:03', 52, 35),
(27, 'Good\r\n', '2020-12-19 20:42:02', 47, 35),
(28, 'nice\r\n', '2020-12-20 13:45:33', 52, 57),
(29, 'Good Keep it Up Bro\r\n', '2020-12-20 13:50:19', 52, 58);

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE `follower` (
  `account_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `follower`
--

INSERT INTO `follower` (`account_id`, `follower_id`) VALUES
(47, 48),
(47, 52),
(48, 47),
(48, 49),
(48, 51),
(49, 47),
(49, 48),
(49, 50),
(49, 51),
(50, 47),
(50, 49),
(51, 47),
(51, 48),
(51, 49),
(56, 48),
(56, 52),
(58, 48),
(58, 52),
(61, 48);

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `account_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`account_id`, `following_id`) VALUES
(47, 48),
(47, 49),
(47, 50),
(47, 51),
(48, 47),
(48, 49),
(48, 51),
(48, 56),
(48, 58),
(48, 61),
(49, 48),
(49, 50),
(49, 51),
(50, 49),
(51, 48),
(51, 49),
(52, 47),
(52, 56),
(52, 58);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`) VALUES
(47, 33),
(47, 37),
(49, 33),
(50, 33),
(50, 35),
(51, 33),
(52, 32),
(52, 35),
(52, 57),
(52, 58);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `caption` text NOT NULL,
  `added_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `caption`, `added_in`, `user_id`) VALUES
(31, 'f63f65b503e22cb970527f23c9ad7db1_amr2.jpg', 'Summer Vibes  2020 ', '2020-12-16 20:49:00', 47),
(32, 'c90e274d55309db944076afb3ff9c391_white.png', 'NoWhere....', '2020-12-16 20:50:29', 47),
(33, '30d454f09b771b9f65e3eaf6e00fa7bd_STORM4.png', '\" I once saw him kill three men in a bar... with a pencil, with a fucking pencil. Then suddenly one day he asked to leave.\"', '2020-12-16 21:03:55', 48),
(35, '48c3ec5c3a93a9e294a8a6392ccedeb4_khabib11.png', 'Hard Workout \"No Pain No Gain \"', '2020-12-16 21:33:29', 49),
(37, '3b9be7e15b46c42911f39a4a9e861022_89a4779d3836ea432f7ea074e522a17e_bridge-wallpaper-10103009(1).jpg', 'Memories Never Die', '2020-12-19 04:29:53', 47),
(40, 'e1696007be4eefb81b1a1d39ce48681b_omarghaly2.png', 'The reading of all good books is like conversation with the finest men of past centuries ~ Rene’ Descartes ? .', '2020-12-19 19:27:03', 55),
(41, 'e366d105cfd734677897aaccf51e97a3_omarghaly.png', 'My friend asked me why I spoke so softly in the gym, I said I was afraid Mark Zuckerberg was listening ! He laughed I laughed Alexa laughed Siri laughed ??‍♂️', '2020-12-19 19:28:10', 55),
(42, '352407221afb776e3143e8a1a0577885_marwanaboreka.png', 'Everything begins inside your mind. With the right mindset you will succeed ??❤️', '2020-12-19 19:30:26', 56),
(43, '185c29dc24325934ee377cfda20e414c_garage2.png', '', '2020-12-19 19:34:09', 56),
(44, 'ab233b682ec355648e7891e66c54191b_marwanaboreka2.png', '', '2020-12-19 19:35:11', 56),
(45, '3416a75f4cea9109507cacd8e2f2aefc_garage.png', 'Contact Us Now on Whatsapp And Know Latest Offers +2010422734', '2020-12-19 19:37:20', 57),
(46, '362387494f6be6613daea643a7706a42_fiona.bl1.png', 'Love is in the air ', '2020-12-19 19:39:28', 60),
(47, '4e4b5fbbbb602b6d35bea8460aa8f8e5_fiona.bl.png', '', '2020-12-19 19:40:07', 60),
(48, 'fcdf25d6e191893e705819b177cddea0_ibrahimfayek.png', '', '2020-12-19 19:45:36', 62),
(49, '47a658229eb2368a99f1d032c8848542_durah.png', 'My face when @big_ramy came out today. ', '2020-12-19 19:49:20', 58),
(50, '761e6675f9e54673cc778e7fdb2823d2_durah2.png', 'Miss those adventures. Lots of love, energy, smiles, and memories ', '2020-12-19 19:49:53', 58),
(54, 'afd4836712c5e77550897e25711e1d96_freestyle_workout2.png', 'Beach SledgeHammer Workout Routine', '2020-12-19 20:19:13', 61),
(55, 'afa299a4d1d8c52e75dd8a24c3ce534f_freestyle_workout1.png', 'Awsome Change !', '2020-12-19 20:19:33', 61),
(56, '20546457187cf3d52ea86538403e47cc_amr9k8.jpg', 'Hot Weather Summer', '2020-12-19 20:42:56', 47),
(57, 'a376033f78e144f494bfc743c0be3330_garage.png', '', '2020-12-19 23:16:49', 47),
(58, '1ff1de774005f8da13f42943881c655f_freestyle_workout3.png', 'Hello', '2020-12-20 13:49:42', 52);

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE `story` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `storySeen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `storyseen`
--

CREATE TABLE `storyseen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `userfollowers`
-- (See below for the actual view)
--
CREATE TABLE `userfollowers` (
`user_id` int(11)
,`username` varchar(120)
,`followers_list` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `userfollowing`
-- (See below for the actual view)
--
CREATE TABLE `userfollowing` (
`user_id` int(11)
,`username` varchar(120)
,`following_list` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `avatar` varchar(150) NOT NULL DEFAULT 'DefaultAvatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`) VALUES
(47, 'amr9k8', 'amrkhaled@gmail.com', '12345', '9e740b84bb48a64dde25061566299467_amr2.jpg'),
(48, 'john_wick', 'john_wick@gmail.com', '12345', '9eac167ec1efbe078138397fabba902e_2cbd9c540641923027adb8ab89decc05_johnwick1.png'),
(49, 'khabib', 'khabib43@gmail.com', '12345', '14bfa6bb14875e45bba028a21ed38046_khabib11.png'),
(50, 'mcgregor', 'conormcregor@gmail.com', '12345', 'bd3ef5c19067fe179f71c8b86ea4b39b_mcgregor1.jpg'),
(51, 'sylvester', 'sylvesterstallone@gmail.com', '12345', 'c4015b7f368e6b4871809f49debe0579_sylvster1.jpg'),
(52, 'new', 'new123@gmail.com', '12345', '526c321538d951fe8d2b9abf54dbdb91_garage2.png'),
(53, 'naser', 'naser_231@hotmail.com', '12345', 'DefaultAvatar.png'),
(55, 'omar_el_ghaly', 'omarghaly112@hotmail.com', '12345', '573eec40e4ef4f2089531dd5cbf629f8_omarghaly2.png'),
(56, 'marwanaboreka', 'marwan331@gmail.com', '12345', '983a33a9a86796df362c1108e00f54a6_marwanaboreka.png'),
(57, 'real_preformance_garage', 'garage43@gmail.com', '12345', 'DefaultAvatar.png'),
(58, 'thedurrah', 'durrah@yahoo.com', '12345', '2bf283c05b601f21364d052ca0ec798d_durah.png'),
(60, 'fiona.bl', 'fiona_bl@hotmail.com', '12345', 'a01610228fe998f515a72dd730294d87_fiona.bl.png'),
(61, 'freestyle_workout', 'freestylers12@gmail.com', '12345', '06d5ae105ea1bea4d800bc96491876e9_freestyle_workout3.png'),
(62, 'ibrahimfayek', 'hema113@gmail.com', '12345', 'fb7b9ffa5462084c5f4e7e85a093e6d7_ibrahimfayek.png');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_comment`
-- (See below for the actual view)
--
CREATE TABLE `user_comment` (
`user_id` int(11)
,`username` varchar(120)
,`user_avatar` varchar(150)
,`comment_id` int(11)
,`comment_txt` text
,`comment_date` timestamp
,`post_id` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_like`
-- (See below for the actual view)
--
CREATE TABLE `user_like` (
`user_id` int(11)
,`username` varchar(120)
,`user_avatar` varchar(150)
,`post_id` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_post`
-- (See below for the actual view)
--
CREATE TABLE `user_post` (
`user_id` int(11)
,`username` varchar(120)
,`user_avatar` varchar(150)
,`post_id` int(11)
,`post_title` varchar(150)
,`caption` text
,`upload_date` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `userfollowers`
--
DROP TABLE IF EXISTS `userfollowers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `userfollowers`  AS  select `users`.`id` AS `user_id`,`users`.`name` AS `username`,`follower`.`follower_id` AS `followers_list` from (`users` join `follower` on(`users`.`id` = `follower`.`account_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `userfollowing`
--
DROP TABLE IF EXISTS `userfollowing`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `userfollowing`  AS  select `users`.`id` AS `user_id`,`users`.`name` AS `username`,`following`.`following_id` AS `following_list` from (`users` join `following` on(`users`.`id` = `following`.`account_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user_comment`
--
DROP TABLE IF EXISTS `user_comment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_comment`  AS  select `users`.`id` AS `user_id`,`users`.`name` AS `username`,`users`.`avatar` AS `user_avatar`,`comment`.`id` AS `comment_id`,`comment`.`txt` AS `comment_txt`,`comment`.`date` AS `comment_date`,`comment`.`post_id` AS `post_id` from (`users` join `comment` on(`users`.`id` = `comment`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user_like`
--
DROP TABLE IF EXISTS `user_like`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_like`  AS  select `users`.`id` AS `user_id`,`users`.`name` AS `username`,`users`.`avatar` AS `user_avatar`,`likes`.`post_id` AS `post_id` from (`users` join `likes` on(`users`.`id` = `likes`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user_post`
--
DROP TABLE IF EXISTS `user_post`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_post`  AS  select `users`.`id` AS `user_id`,`users`.`name` AS `username`,`users`.`avatar` AS `user_avatar`,`post`.`id` AS `post_id`,`post`.`title` AS `post_title`,`post`.`caption` AS `caption`,`post`.`added_in` AS `upload_date` from (`users` join `post` on(`users`.`id` = `post`.`user_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`account_id`,`follower_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `follower_id` (`follower_id`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`account_id`,`following_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `storySeen_id` (`storySeen_id`);

--
-- Indexes for table `storyseen`
--
ALTER TABLE `storyseen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `story_id` (`story_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `story`
--
ALTER TABLE `story`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storyseen`
--
ALTER TABLE `storyseen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follower`
--
ALTER TABLE `follower`
  ADD CONSTRAINT `follower_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follower_ibfk_2` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `following_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `following_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `story`
--
ALTER TABLE `story`
  ADD CONSTRAINT `story_ibfk_1` FOREIGN KEY (`storySeen_id`) REFERENCES `storyseen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `storyseen`
--
ALTER TABLE `storyseen`
  ADD CONSTRAINT `storyseen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `storyseen_ibfk_2` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
