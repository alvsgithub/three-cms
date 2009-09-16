-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 16, 2009 at 05:27 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9-2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `three`
--

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) NOT NULL,
  `id_object` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `alias` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `id_content`, `id_object`, `name`, `alias`) VALUES
(1, 1, 1, 'Test pagina', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `code` varchar(2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `active`) VALUES
(1, 'Nederlands', 'nl', 1),
(2, 'English', 'en', 1),
(3, 'Deutsch', 'de', 1);

-- --------------------------------------------------------

--
-- Table structure for table `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `objects`
--

INSERT INTO `objects` (`id`, `name`) VALUES
(1, 'Default Page');

-- --------------------------------------------------------

--
-- Table structure for table `objects_options`
--

CREATE TABLE IF NOT EXISTS `objects_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_object` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `objects_options`
--

INSERT INTO `objects_options` (`id`, `id_object`, `id_option`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `multilanguage` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `multilanguage`) VALUES
(1, 'title', 0),
(2, 'header', 1),
(3, 'content', 1);

-- --------------------------------------------------------

--
-- Table structure for table `values`
--

CREATE TABLE IF NOT EXISTS `values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `values`
--

INSERT INTO `values` (`id`, `id_content`, `id_option`, `id_language`, `value`) VALUES
(1, 1, 1, 1, 'Titel (NL)'),
(2, 1, 1, 2, 'Titel (EN)'),
(3, 1, 1, 3, 'Titel (DE)'),
(4, 1, 2, 1, 'Header (NL)'),
(5, 1, 2, 2, 'Header (EN)'),
(6, 1, 2, 3, 'Header (DE)'),
(7, 1, 3, 1, 'Content (NL)'),
(8, 1, 3, 2, 'Content (EN)'),
(9, 1, 3, 3, 'Content (DE)');
