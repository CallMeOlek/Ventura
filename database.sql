-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 03-Jul-2022 às 23:21
-- Versão do servidor: 5.7.11
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ventura`
--
CREATE DATABASE IF NOT EXISTS `ventura` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `ventura`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `creation_id` int(11) NOT NULL,
  `part` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `story` text COLLATE utf8_bin,
  `choiceA` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `nextA` int(11) DEFAULT NULL,
  `choiceB` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `nextB` int(11) DEFAULT NULL,
  `choiceC` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `nextC` int(11) DEFAULT NULL,
  `choiceD` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `nextD` int(11) DEFAULT NULL,
  `contentType` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `creations`
--

CREATE TABLE `creations` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_bin NOT NULL,
  `descriptions` text COLLATE utf8_bin,
  `imageSmall` varchar(128) COLLATE utf8_bin DEFAULT 'game-small.jpg',
  `imageBig` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT 'game-big.jpg',
  `createdAt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `creation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `creation_id` int(11) DEFAULT NULL,
  `types` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `usersName` varchar(128) COLLATE utf8_bin NOT NULL,
  `usersUid` varchar(128) COLLATE utf8_bin NOT NULL,
  `usersEmail` varchar(128) COLLATE utf8_bin NOT NULL,
  `usersPwd` varchar(128) COLLATE utf8_bin NOT NULL,
  `usersPhoto` varchar(128) COLLATE utf8_bin DEFAULT 'profile-default.jpg',
  `usersRegAt` date DEFAULT NULL,
  `usersLastLogin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creations`
--
ALTER TABLE `creations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;
--
-- AUTO_INCREMENT for table `creations`
--
ALTER TABLE `creations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
