-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 30, 2014 alle 11:45
-- Versione del server: 5.5.37-MariaDB-log
-- PHP Version: 5.5.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `sessioni`
--

CREATE TABLE IF NOT EXISTS `sessioni` (
  `uid` char(32) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `creation_date` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(32) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `name`, `surname`, `username`, `password`) VALUES
(1, 'Giancarlo', 'Moschitta', 'gm', '8ad8757baa8564dc136c1e07507f4a98'),
(2, 'Gabriele', 'Farina', 'darkbard', '098f6bcd4621d373cade4e832627b4f6'),
(3, 'Fabio', 'Sutto', 'fabio heller', 'ad0234829205b9033196ba818f7a872b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessioni`
--
ALTER TABLE `sessioni`
 ADD KEY `uid` (`uid`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
 ADD PRIMARY KEY (`id`), ADD KEY `username` (`username`,`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
