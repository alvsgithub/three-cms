-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 18, 2009 at 09:30 AM
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
  `id_template` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `alias` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `id_content`, `id_template`, `name`, `alias`) VALUES
(1, 0, 1, 'Test pagina', 'test'),
(2, 1, 2, 'Blok 1', 'blok1'),
(3, 1, 2, 'Blok 2', 'blok2');

-- --------------------------------------------------------

--
-- Table structure for table `dataobjects`
--

CREATE TABLE IF NOT EXISTS `dataobjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dataobjects`
--

INSERT INTO `dataobjects` (`id`, `name`) VALUES
(1, 'Default Page');

-- --------------------------------------------------------

--
-- Table structure for table `dataobjects_options`
--

CREATE TABLE IF NOT EXISTS `dataobjects_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dataobject` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dataobjects_options`
--

INSERT INTO `dataobjects_options` (`id`, `id_dataobject`, `id_option`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

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
-- Table structure for table `locales`
--

CREATE TABLE IF NOT EXISTS `locales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `locales`
--


-- --------------------------------------------------------

--
-- Table structure for table `locales_values`
--

CREATE TABLE IF NOT EXISTS `locales_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_locale` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `locales_values`
--


-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `type` enum('small_text','large_text','rich_text','url','image','file','boolean','dropdown','selectbox','date','time','content','content_of_type') NOT NULL,
  `default_value` text NOT NULL,
  `multilanguage` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `type`, `default_value`, `multilanguage`) VALUES
(1, 'title', 'small_text', '', 0),
(2, 'header', 'small_text', '', 1),
(3, 'content', 'small_text', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `id_dataobject` int(11) NOT NULL,
  `templatefile` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `id_dataobject`, `templatefile`) VALUES
(1, 'Default template', 1, 'index.tpl'),
(2, 'Block', 1, 'block.tpl');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

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
(9, 1, 3, 3, 'Content (DE)'),
(10, 2, 2, 1, 'Koptekst'),
(11, 2, 3, 1, 'Inhoud'),
(12, 2, 2, 2, 'Small header'),
(13, 2, 3, 2, 'content'),
(14, 2, 2, 3, 'Eine kopf'),
(15, 2, 3, 3, 'Inhalt'),
(16, 3, 2, 1, 'Nog een koptekst'),
(17, 3, 3, 1, 'Nog wat inhoud'),
(18, 3, 2, 2, 'Another header'),
(19, 3, 3, 2, 'Yet some other content'),
(20, 3, 2, 3, 'Eine header wieder'),
(21, 3, 3, 3, 'Und nog wat tekscht');
