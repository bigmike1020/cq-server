-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2012 at 12:23 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chunky`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `picture_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `picture_id` (`picture_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `user_id`, `answer`, `date`, `picture_id`) VALUES
(1, 2, 'Not a real dress fool!', '2012-08-25 16:46:36', 1),
(2, 3, 'Dude its awesome.', '2012-08-25 17:46:15', 2),
(3, 1, 'Shucks', '2012-08-25 17:46:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rel_path` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `rel_path`, `user_id`, `question`, `upload_date`) VALUES
(1, 'dress001.jpg', 1, 'Who makes this dress?', '2012-08-25 16:45:33'),
(2, 'bridge001.png', 2, 'Do you like this bridge?', '2012-08-25 17:44:20'),
(4, '1345932739.jpeg', 5, '', '2012-08-25 22:12:19'),
(5, '1345933012.jpeg', 5, 'nothing', '2012-08-25 22:16:52'),
(6, '1345933139.jpeg', 5, 'who mad ethos', '2012-08-25 22:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `join_date`) VALUES
(1, 'Mike', '2012-08-25 16:45:58'),
(2, 'Ed', '2012-08-25 16:45:58'),
(3, 'Matt', '2012-08-25 16:46:08'),
(4, '1', '2012-08-25 18:34:12'),
(5, 'Anonymous', '2012-08-25 21:38:39');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
