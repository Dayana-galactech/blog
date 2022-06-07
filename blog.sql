-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2022 at 10:05 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `card1`
--

CREATE TABLE `card1` (
  `id` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `card1`
--

INSERT INTO `card1` (`id`, `postID`) VALUES
(1, 22),
(2, 28),
(3, 32),
(4, 22),
(5, 30),
(6, 26),
(7, 29),
(8, 28);

-- --------------------------------------------------------

--
-- Table structure for table `card2`
--

CREATE TABLE `card2` (
  `id` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `card2`
--

INSERT INTO `card2` (`id`, `postID`) VALUES
(1, 22),
(2, 23),
(3, 28),
(4, 22),
(5, 28),
(6, 28),
(7, 30),
(8, 28);

-- --------------------------------------------------------

--
-- Table structure for table `card3`
--

CREATE TABLE `card3` (
  `id` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `card3`
--

INSERT INTO `card3` (`id`, `postID`) VALUES
(1, 22);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `userID`, `name`) VALUES
(57, 1, 'Food'),
(58, 1, 'fashion'),
(59, 1, 'Football'),
(60, 1, 'Travel'),
(61, 1, 'by author'),
(62, 1, 'jj'),
(63, 1, 'bb'),
(64, 4, 'dayana'),
(65, 4, 'okii'),
(66, 1, 'sss'),
(67, 1, 'wewqrwr'),
(68, 1, 'sandjn'),
(69, 1, 'jsakdhjkhdj'),
(70, 4, 'hh');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `userID`, `postID`, `body`) VALUES
(1, 4, 36, '0'),
(2, 4, 36, '0'),
(3, 4, 36, '0'),
(4, 4, 31, '0'),
(5, 4, 31, '0'),
(6, 4, 31, 'sssssss'),
(7, 4, 22, 'hiii'),
(8, 4, 22, 'okayy'),
(9, 4, 22, 'sjabdjsbjdba'),
(10, 4, 22, 'bnnbmn'),
(11, 4, 22, 'hbhjbhjb'),
(12, 4, 23, 'hjbhjbjhbj'),
(13, 4, 26, 'hala madrid\r\n'),
(14, 4, 22, 'snmbdm'),
(15, 4, 22, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?'),
(16, 4, 22, 'new comment'),
(17, 4, 22, 'commmeennttt'),
(18, 4, 22, 'commmeennttt'),
(19, 4, 22, 'okay'),
(20, 4, 22, 'new\r\n'),
(21, 4, 22, 'ddd'),
(22, 4, 22, 'rrr'),
(23, 4, 22, 'dsavdkjsabdjka'),
(24, 4, 22, 'asbdfjksahfdljkasnkjdna'),
(25, 4, 22, 'hellooo'),
(26, 4, 22, 'hhhhhh'),
(27, 4, 22, 'rgrg'),
(28, 4, 22, 'gvghvg   n'),
(29, 4, 22, 'ss'),
(30, 4, 22, 'hsgbdfjsgfj'),
(31, 4, 22, 'dbabdjsbd'),
(32, 4, 22, 'hhhhhhhhhhhhhhhhhhhhhh'),
(33, 4, 22, 'hhey'),
(34, 4, 22, 'inshala'),
(35, 4, 23, 'hhh'),
(36, 1, 28, 'nice\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `postcategory`
--

CREATE TABLE `postcategory` (
  `id` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postcategory`
--

INSERT INTO `postcategory` (`id`, `postID`, `categoryID`) VALUES
(9, 21, 58),
(10, 22, 57),
(11, 23, 58),
(12, 24, 57),
(14, 26, 59),
(15, 27, 59),
(16, 28, 60),
(17, 29, 61),
(18, 30, 60),
(19, 31, 57),
(20, 32, 61),
(21, 33, 61),
(22, 34, 61),
(23, 35, 61),
(24, 36, 64),
(25, 37, 66),
(26, 38, 60);

-- --------------------------------------------------------

--
-- Table structure for table `postcomment`
--

CREATE TABLE `postcomment` (
  `id` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `commentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postcomment`
--

INSERT INTO `postcomment` (`id`, `postID`, `commentID`) VALUES
(1, 22, 11),
(2, 23, 12),
(3, 26, 13),
(4, 22, 14),
(5, 22, 15),
(6, 22, 16),
(7, 22, 17),
(8, 22, 18),
(9, 22, 19),
(10, 22, 20),
(11, 22, 21),
(12, 22, 22),
(13, 22, 23),
(14, 22, 24),
(15, 22, 25),
(16, 22, 26),
(17, 22, 27),
(18, 22, 28),
(19, 22, 29),
(20, 22, 30),
(21, 22, 31),
(22, 22, 32),
(23, 22, 33),
(24, 22, 34),
(25, 23, 35),
(26, 28, 36);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `published` tinyint(1) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `userID`, `title`, `image`, `body`, `published`, `createdAt`) VALUES
(21, 1, 'Tops', 'Screenshot (2).png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Proin sagittis nisl rhoncus mattis rhoncus urna neque. Sit amet consectetur adipiscing elit pellentesque habitant morbi tristique. Aliquam vestibulum morbi blandit cursus risus at ultrices. Turpis cursus in hac habitasse platea dictumst quisque. Scelerisque varius morbi enim nunc faucibus a. Gravida rutrum quisque non tellus orci ac. Tristique et egestas quis ipsum. Fusce ut placerat orci nulla pellentesque dignissim enim. Sed vulputate mi sit amet mauris commodo. Risus nullam eget felis eget nunc lobortis. Nulla facilisi morbi tempus iaculis. Ipsum dolor sit amet consectetur adipiscing. Fames ac turpis egestas sed tempus. Pellentesque adipiscing commodo elit at imperdiet dui accumsan sit amet. Nulla facilisi cras fermentum odio. Sit amet commodo nulla facilisi.', 0, '2022-06-02 19:41:28'),
(22, 1, 'Burger', 'Screenshot (2).png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Proin sagittis nisl rhoncus mattis rhoncus urna neque. Sit amet consectetur adipiscing elit pellentesque habitant morbi tristique. Aliquam vestibulum morbi blandit cursus risus at ultrices. Turpis cursus in hac habitasse platea dictumst quisque. Scelerisque varius morbi enim nunc faucibus a. Gravida rutrum quisque non tellus orci ac. Tristique et egestas quis ipsum. Fusce ut placerat orci nulla pellentesque dignissim enim. Sed vulputate mi sit amet mauris commodo. Risus nullam eget felis eget nunc lobortis. Nulla facilisi morbi tempus iaculis. Ipsum dolor sit amet consectetur adipiscing. Fames ac turpis egestas sed tempus. Pellentesque adipiscing commodo elit at imperdiet dui accumsan sit amet. Nulla facilisi cras fermentum odio. Sit amet commodo nulla facilisi.', 1, '2022-06-02 19:23:26'),
(23, 1, 'Dresses', 'Screenshot (2).png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Vitae et leo duis ut diam. Proin libero nunc consequat interdum varius sit amet mattis. Elementum pulvinar etiam non quam. Donec pretium vulputate sapien nec. Egestas congue quisque egestas diam. Ullamcorper morbi tincidunt ornare massa eget. Commodo nulla facilisi nullam vehicula. Viverra ipsum nunc aliquet bibendum enim. Eget egestas purus viverra accumsan. Nisi lacus sed viverra tellus in. Laoreet suspendisse interdum consectetur libero id faucibus.', 1, '2022-06-02 20:03:46'),
(24, 1, 'pizza', 'Screenshot (2).png', 'sabcmjsbcjm', 0, '2022-06-02 05:54:11'),
(26, 1, 'Real Madrid', 'download.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Proin sagittis nisl rhoncus mattis rhoncus urna neque. Sit amet consectetur adipiscing elit pellentesque habitant morbi tristique. Aliquam vestibulum morbi blandit cursus risus at ultrices. Turpis cursus in hac habitasse platea dictumst quisque. Scelerisque varius morbi enim nunc faucibus a. Gravida rutrum quisque non tellus orci ac. Tristique et egestas quis ipsum. Fusce ut placerat orci nulla pellentesque dignissim enim. Sed vulputate mi sit amet mauris commodo. Risus nullam eget felis eget nunc lobortis. Nulla facilisi morbi tempus iaculis. Ipsum dolor sit amet consectetur adipiscing. Fames ac turpis egestas sed tempus. Pellentesque adipiscing commodo elit at imperdiet dui accumsan sit amet. Nulla facilisi cras fermentum odio. Sit amet commodo nulla facilisi.', 1, '2022-06-02 20:03:12'),
(27, 1, 'new', 'Screenshot (2).png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Proin sagittis nisl rhoncus mattis rhoncus urna neque. Sit amet consectetur adipiscing elit pellentesque habitant morbi tristique. Aliquam vestibulum morbi blandit cursus risus at ultrices. Turpis cursus in hac habitasse platea dictumst quisque. Scelerisque varius morbi enim nunc faucibus a. Gravida rutrum quisque non tellus orci ac. Tristique et egestas quis ipsum. Fusce ut placerat orci nulla pellentesque dignissim enim. Sed vulputate mi sit amet mauris commodo. Risus nullam eget felis eget nunc lobortis. Nulla facilisi morbi tempus iaculis. Ipsum dolor sit amet consectetur adipiscing. Fames ac turpis egestas sed tempus. Pellentesque adipiscing commodo elit at imperdiet dui accumsan sit amet. Nulla facilisi cras fermentum odio. Sit amet commodo nulla facilisi.', 0, '2022-06-02 19:24:39'),
(28, 1, 'Spain', 'Screenshot (2).png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Vitae et leo duis ut diam. Proin libero nunc consequat interdum varius sit amet mattis. Elementum pulvinar etiam non quam. Donec pretium vulputate sapien nec. Egestas congue quisque egestas diam. Ullamcorper morbi tincidunt ornare massa eget. Commodo nulla facilisi nullam vehicula. Viverra ipsum nunc aliquet bibendum enim. Eget egestas purus viverra accumsan. Nisi lacus sed viverra tellus in. Laoreet suspendisse interdum consectetur libero id faucibus.', 1, '2022-06-02 20:00:53'),
(29, 1, 'first', 'Screenshot (2).png', 'first', 1, '2022-06-03 07:56:30'),
(30, 9, 'Italy', 'Screenshot (2).png', 'Roma', 1, '2022-06-03 20:40:08'),
(31, 9, 'Pasta', 'Screenshot (2).png', 'Italian', 1, '2022-06-03 20:45:50'),
(32, 9, 'Thoughts', 'Screenshot (2).png', 'sdbndb', 1, '2022-06-03 20:48:48'),
(33, 9, 'aa', 'Screenshot (2).png', 'aaa', 1, '2022-06-03 20:49:39'),
(34, 9, 'dd', 'Screenshot (2).png', 'dd', 1, '2022-06-03 20:51:06'),
(35, 4, 'hhh', 'Screenshot (2).png', 'hhh', 1, '2022-06-03 21:00:01'),
(36, 4, 'okiiii', 'Screenshot (2).png', 'gggggggggg', 1, '2022-06-05 09:26:32'),
(37, 1, 'ssss', 'Screenshot (2).png', 'sss', 1, '2022-06-05 22:25:38'),
(38, 4, 'new', 'Screenshot (2).png', 'asnkljndkjjalkd', 0, '2022-06-06 21:10:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `type`, `password`) VALUES
(1, 'Admin', 'admin@gmail.com', 'Admin', '$2y$10$NmRNEeAck4V4eHaJfmYKDesnLiYMiwgTUQBLhBhoFKBWvh2HgrvPO'),
(2, 'joe', 'joe@example.com', 'Author', '$2y$10$u8joHkd9eqJkr6OjKcG6keVW7RnfTp4VLe2pUhOcU8xiQqU/GSOxa'),
(4, 'dayana', 'dayana@gmail.com', 'Author', '$2y$10$YOuVTA3hBIf52CJnqlXGdONaCe4O0.vaoKJnWsTun1ZOuJivbyObS'),
(5, 'one', 'one@gmail.com', 'Author', '$2y$10$tmamwHHh5DH3IVKye/.7quuXJkycY1cxozuxFM9xaVVUTJmGzcm6K'),
(6, 'two', 'two@gmail.com', 'Author', '$2y$10$Yu6J4UA9b1oZYlzf0BE4j.8JE7Hnk0VfYooG1rTvygyTJmiFct5BC'),
(8, 'three', 'three@gmaill.com', 'Author', '$2y$10$eDd.aFMuQgXEVEuUyX3kPOOk25SlUvPqU5dHIFzC5mKlnooSlXKJ6'),
(9, 'four', 'four@gmail.com', 'Author', '$2y$10$Ixat650JzzhQ/sBdC0v2h.QyvbImOq2gbmwv/SZy9yVBqUZ3SyvVS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card1`
--
ALTER TABLE `card1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card2`
--
ALTER TABLE `card2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card3`
--
ALTER TABLE `card3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `postID` (`postID`);

--
-- Indexes for table `postcategory`
--
ALTER TABLE `postcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postID` (`postID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `postcomment`
--
ALTER TABLE `postcomment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postID` (`postID`),
  ADD KEY `commentID` (`commentID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card1`
--
ALTER TABLE `card1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `card2`
--
ALTER TABLE `card2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `card3`
--
ALTER TABLE `card3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `postcategory`
--
ALTER TABLE `postcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `postcomment`
--
ALTER TABLE `postcomment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `postcategory`
--
ALTER TABLE `postcategory`
  ADD CONSTRAINT `postcategory_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `postcategory_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `postcomment`
--
ALTER TABLE `postcomment`
  ADD CONSTRAINT `postcomment_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `postcomment_ibfk_2` FOREIGN KEY (`commentID`) REFERENCES `comments` (`commentID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
