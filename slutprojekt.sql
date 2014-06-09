-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 09 jun 2014 kl 16:25
-- Serverversion: 5.5.16
-- PHP-version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `slutprojekt`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `summary_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `summary_id` (`summary_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumpning av Data i tabell `comments`
--

INSERT INTO `comments` (`id`, `date`, `content`, `summary_id`, `user_id`) VALUES
(1, '2014-06-09 01:09:12', 'Detaljerat och sånt.', 8, 2),
(2, '2014-06-09 01:53:58', 'Klaga och sånt.', 8, 1),
(3, '2014-06-09 01:56:20', 'Onödiga kommentarer och sånt.', 8, 4),
(4, '2014-06-09 02:04:18', 'Lättare sagt än gjort!', 1, 2),
(5, '2014-06-09 13:52:24', 'Tunga sidor magistern..', 9, 1),
(6, '2014-06-09 14:12:25', 'Vad gör du här ens?', 10, 17),
(7, '2014-06-09 14:13:26', 'Hörni allihopa det är Emannel!', 10, 26),
(8, '2014-06-09 14:14:45', 'Hur kom ni ens in hit?', 10, 16),
(9, '2014-06-09 14:48:02', 'Jag vet hur man gör!', 11, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vote` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=11 ;

--
-- Dumpning av Data i tabell `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Engelska 6'),
(2, 'Fysik 1'),
(3, 'Gränssnitt'),
(4, 'Idrott 1'),
(5, 'Matte 3C'),
(6, 'Programering 1'),
(7, 'Svenska 2'),
(8, 'Teknik 1'),
(9, 'Webbserverprogrammering'),
(10, 'Webbutveckling');

-- --------------------------------------------------------

--
-- Tabellstruktur `summaries`
--

CREATE TABLE IF NOT EXISTS `summaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `subject_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumpning av Data i tabell `summaries`
--

INSERT INTO `summaries` (`id`, `title`, `date`, `content`, `subject_id`, `user_id`) VALUES
(1, 'Dagbok', '2014-05-20 12:23:35', 'Träna och skriv!', 4, 4),
(6, 'Comperative analysis.', '2014-05-27 13:36:09', 'Just look, see and try to describe.. ', 1, 1),
(7, 'Detbatt', '2014-06-04 21:19:13', 'Stå för din sak!', 7, 1),
(8, 'Geometri', '2014-06-04 21:38:03', 'Trianglar och sånt.', 5, 8),
(9, 'Muskelbygge', '2014-06-09 13:50:59', 'Kom ihåg att läsa igenom läroboken, kapitel 3-5.', 4, 26),
(10, 'Integraler', '2014-06-09 14:11:29', 'Tror du jag behöver kunna sånt.', 5, 12),
(11, 'Project of awesome', '2014-06-09 14:47:43', 'Få det att funka!', 9, 28);

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`) VALUES
(1, 'Anton', 'Pettersson'),
(2, 'Elias', 'Axelsson'),
(4, 'Carl', 'Zetterberg'),
(8, 'Erik', 'Källberg'),
(10, 'Edwin', 'Gustafsson'),
(12, 'Aron', 'Ingmyr'),
(14, 'Anna', 'Rosén'),
(16, 'August', 'Alexandersson'),
(17, 'Ludvig', 'Zälter'),
(18, 'Matilda', 'Märs'),
(19, 'Samuel', 'Albinsson'),
(20, 'Teddy', 'Lathvenis'),
(21, 'Philip', 'Gustavsson'),
(22, 'Johannes', 'Grönlund'),
(23, 'Jonathan', 'Sarge'),
(24, 'Jonathan', 'Pettersson'),
(26, 'Emanuel', 'Nordberg'),
(27, 'Egon', 'Runedahl'),
(28, 'Niklas', 'Mårdby');

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`summary_id`) REFERENCES `summaries` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `summaries`
--
ALTER TABLE `summaries`
  ADD CONSTRAINT `summaries_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `summaries_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
