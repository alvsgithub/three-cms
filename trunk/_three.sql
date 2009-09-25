-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 25, 2009 at 04:49 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `id_content`, `id_template`, `name`, `alias`) VALUES
(1, 0, 1, 'Test pagina', 'test'),
(2, 1, 2, 'Blok 1', 'blok1'),
(3, 1, 2, 'Blok 2', 'blok2'),
(4, 2, 2, 'Blok 1.1', 'blok-1-1'),
(5, 2, 2, 'Blok 1.2', 'blok-1-2'),
(6, 1, 3, 'TestBlok', 'testblok');

-- --------------------------------------------------------

--
-- Table structure for table `dataobjects`
--

CREATE TABLE IF NOT EXISTS `dataobjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dataobjects`
--

INSERT INTO `dataobjects` (`id`, `name`) VALUES
(1, 'Default Page'),
(2, 'Content 2'),
(3, 'Blok');

-- --------------------------------------------------------

--
-- Table structure for table `dataobjects_options`
--

CREATE TABLE IF NOT EXISTS `dataobjects_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dataobject` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `dataobjects_options`
--

INSERT INTO `dataobjects_options` (`id`, `id_dataobject`, `id_option`, `order`) VALUES
(61, 1, 6, 4),
(39, 2, 2, 1),
(38, 2, 1, 0),
(60, 1, 2, 3),
(59, 1, 8, 2),
(58, 1, 7, 1),
(57, 1, 1, 0),
(62, 1, 3, 5),
(63, 3, 2, 0),
(64, 3, 3, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `active`) VALUES
(1, 'Nederlands', 'nl', 1),
(2, 'English', 'en', 1),
(3, 'Deutsch', 'de', 1),
(6, 'French', 'fr', 0);

-- --------------------------------------------------------

--
-- Table structure for table `locales`
--

CREATE TABLE IF NOT EXISTS `locales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `locales`
--

INSERT INTO `locales` (`id`, `name`) VALUES
(1, 'Hallo'),
(8, 'Ja'),
(7, 'Nieuw');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `locales_values`
--

INSERT INTO `locales_values` (`id`, `id_locale`, `id_language`, `value`) VALUES
(8, 1, 1, 'Hallo'),
(9, 1, 2, 'Hello'),
(10, 1, 3, 'Guten tag'),
(11, 1, 6, 'Bonjour'),
(43, 8, 6, 'Oui'),
(42, 8, 3, 'Jawohl'),
(41, 8, 2, 'Yes'),
(40, 8, 1, 'Ja'),
(32, 7, 1, 'Nieuw'),
(33, 7, 2, 'New'),
(34, 7, 3, 'Neu'),
(35, 7, 6, 'Nouveau');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `type`, `default_value`, `multilanguage`) VALUES
(1, 'title', 'small_text', '', 1),
(2, 'header', 'small_text', '', 1),
(3, 'content', 'rich_text', '', 1),
(6, 'headerImage', 'image', '', 0),
(7, 'Show in menu', 'boolean', '', 0),
(8, 'summary', 'large_text', '', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `id_dataobject`, `templatefile`) VALUES
(1, 'Default template', 1, 'index.tpl'),
(2, 'Block', 1, 'block.tpl'),
(3, 'Blok', 3, 'block.tpl');

-- --------------------------------------------------------

--
-- Table structure for table `templates_allowed_children`
--

CREATE TABLE IF NOT EXISTS `templates_allowed_children` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_template` int(11) NOT NULL,
  `id_child_template` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `templates_allowed_children`
--

INSERT INTO `templates_allowed_children` (`id`, `id_template`, `id_child_template`) VALUES
(9, 1, 2),
(8, 1, 1),
(7, 2, 2),
(10, 1, 3);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `values`
--

INSERT INTO `values` (`id`, `id_content`, `id_option`, `id_language`, `value`) VALUES
(1, 1, 1, 1, 'Titel (NL)'),
(2, 1, 1, 2, 'Titel (EN) Test'),
(3, 1, 1, 3, 'Titel (DE)'),
(4, 1, 2, 1, 'Header (NL)'),
(5, 1, 2, 2, 'Header (EN)'),
(6, 1, 2, 3, 'Header (DE)'),
(7, 1, 3, 1, ''),
(8, 1, 3, 2, ''),
(9, 1, 3, 3, ''),
(23, 1, 7, 1, '1'),
(22, 1, 1, 6, ''),
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
(21, 3, 3, 3, 'Und nog wat tekscht'),
(24, 1, 7, 2, '1'),
(25, 1, 7, 3, '1'),
(26, 1, 7, 6, '1'),
(27, 1, 8, 1, 'Samenvatting'),
(28, 1, 8, 2, 'Summary'),
(29, 1, 8, 3, 'Die samenvattung'),
(30, 1, 8, 6, 'Voulez vous un samenvatting'),
(31, 1, 2, 6, ''),
(32, 1, 6, 1, 'myImage.jpg'),
(33, 1, 6, 2, 'myImage.jpg'),
(34, 1, 6, 3, 'myImage.jpg'),
(35, 1, 6, 6, 'myImage.jpg'),
(36, 1, 3, 6, ''),
(37, 6, 2, 1, 'Hallo'),
(38, 6, 2, 2, 'Hello'),
(39, 6, 2, 3, 'Guten Tag'),
(40, 6, 2, 6, 'Bonjour'),
(41, 6, 3, 1, ''),
(42, 6, 3, 2, ''),
(43, 6, 3, 3, ''),
(44, 6, 3, 6, '');
