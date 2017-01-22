-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Dec 31, 2016 at 11:32 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `thecircle`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `name` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
`id` bigint(20) NOT NULL,
  `follower` varchar(255) NOT NULL,
  `followee` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
`interest_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
`pictureID` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `likes` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `profilePictures`
--

CREATE TABLE `profilePictures` (
  `userEmail` varchar(255) NOT NULL,
  `pictureID` bigint(20) NOT NULL,
  `isCurrent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `status`
--

CREATE TABLE `status` (
`id` bigint(20) NOT NULL,
  `byUser` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `message` text NOT NULL,
  `likes` text NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `preferedname` varchar(250) NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `user_interest`
--

CREATE TABLE `user_interest` (
  `userEmail` varchar(255) NOT NULL,
  `interest_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
 ADD PRIMARY KEY (`interest_id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
 ADD PRIMARY KEY (`pictureID`);

--
-- Indexes for table `profilePictures`
--
ALTER TABLE `profilePictures`
 ADD PRIMARY KEY (`userEmail`,`pictureID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
MODIFY `pictureID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;