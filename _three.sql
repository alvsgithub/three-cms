-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 11, 2009 at 04:59 PM
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
-- Table structure for table `three_content`
--

CREATE TABLE IF NOT EXISTS `three_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) NOT NULL,
  `id_template` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `alias` tinytext NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `three_content`
--

INSERT INTO `three_content` (`id`, `id_content`, `id_template`, `name`, `alias`, `order`) VALUES
(1, 0, 1, 'Test pagina', 'test', 0),
(2, 1, 2, 'Blok 1', 'blok1', 1),
(3, 1, 2, 'Blok 2', 'blok2', 2),
(4, 2, 2, 'Blok 1.1', 'blok-1-1', 0),
(5, 2, 2, 'Blok 1.2', 'blok-1-2', 0),
(6, 1, 3, 'TestBlok', 'testblok', 0);

-- --------------------------------------------------------

--
-- Table structure for table `three_dataobjects`
--

CREATE TABLE IF NOT EXISTS `three_dataobjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `three_dataobjects`
--

INSERT INTO `three_dataobjects` (`id`, `name`) VALUES
(1, 'Default Page'),
(2, 'Content 2'),
(3, 'Blok');

-- --------------------------------------------------------

--
-- Table structure for table `three_dataobjects_options`
--

CREATE TABLE IF NOT EXISTS `three_dataobjects_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dataobject` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `three_dataobjects_options`
--

INSERT INTO `three_dataobjects_options` (`id`, `id_dataobject`, `id_option`, `order`) VALUES
(84, 1, 10, 6),
(39, 2, 2, 1),
(38, 2, 1, 0),
(83, 1, 3, 5),
(82, 1, 6, 4),
(81, 1, 2, 3),
(80, 1, 8, 2),
(79, 1, 7, 1),
(63, 3, 2, 0),
(64, 3, 3, 1),
(85, 1, 11, 7),
(78, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `three_languages`
--

CREATE TABLE IF NOT EXISTS `three_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `code` varchar(2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `three_languages`
--

INSERT INTO `three_languages` (`id`, `name`, `code`, `active`) VALUES
(1, 'Nederlands', 'nl', 1),
(2, 'English', 'en', 1),
(3, 'Deutsch', 'de', 1),
(6, 'French', 'fr', 0);

-- --------------------------------------------------------

--
-- Table structure for table `three_locales`
--

CREATE TABLE IF NOT EXISTS `three_locales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `three_locales`
--

INSERT INTO `three_locales` (`id`, `name`) VALUES
(1, 'Hallo'),
(8, 'Ja'),
(7, 'Nieuw');

-- --------------------------------------------------------

--
-- Table structure for table `three_locales_values`
--

CREATE TABLE IF NOT EXISTS `three_locales_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_locale` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `three_locales_values`
--

INSERT INTO `three_locales_values` (`id`, `id_locale`, `id_language`, `value`) VALUES
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
-- Table structure for table `three_options`
--

CREATE TABLE IF NOT EXISTS `three_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `type` enum('small_text','large_text','rich_text','url','image','file','boolean','dropdown','selectbox','date','time','content','content_of_type') NOT NULL,
  `default_value` text NOT NULL,
  `multilanguage` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `three_options`
--

INSERT INTO `three_options` (`id`, `name`, `type`, `default_value`, `multilanguage`) VALUES
(1, 'title', 'small_text', '', 1),
(2, 'header', 'small_text', '', 1),
(3, 'content', 'rich_text', '', 1),
(6, 'headerImage', 'image', '', 0),
(7, 'Show in menu', 'boolean', '', 0),
(8, 'summary', 'large_text', '', 1),
(10, 'Kleur', 'dropdown', 'rood==#FF0000||groen==#00FF00||blauw==#0000FF||paars==#FF00FF||geel==#FFFF00', 0),
(11, 'Zichtbare elementen', 'selectbox', 'Heeft foto aan de linkerkant==fotoLinks||Heeft foto in het midden==fotoMidden||Heeft foto aan de rechterkant==fotoRechts', 0);

-- --------------------------------------------------------

--
-- Table structure for table `three_ranks`
--

CREATE TABLE IF NOT EXISTS `three_ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `system` tinyint(1) NOT NULL,
  `users` tinyint(1) NOT NULL,
  `ranks` tinyint(1) NOT NULL,
  `configuration` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `three_ranks`
--

INSERT INTO `three_ranks` (`id`, `name`, `system`, `users`, `ranks`, `configuration`) VALUES
(1, 'Administrator', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `three_settings`
--

CREATE TABLE IF NOT EXISTS `three_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `three_settings`
--

INSERT INTO `three_settings` (`id`, `name`, `value`) VALUES
(1, 'default_language', '2'),
(2, 'default_page_id', '1');

-- --------------------------------------------------------

--
-- Table structure for table `three_templates`
--

CREATE TABLE IF NOT EXISTS `three_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `id_dataobject` int(11) NOT NULL,
  `templatefile` tinytext NOT NULL,
  `root` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `three_templates`
--

INSERT INTO `three_templates` (`id`, `name`, `id_dataobject`, `templatefile`, `root`) VALUES
(1, 'Default template', 1, 'index.tpl', 1),
(2, 'Block', 1, 'block.tpl', 0),
(3, 'Blok', 3, 'block.tpl', 0);

-- --------------------------------------------------------

--
-- Table structure for table `three_templates_allowed_children`
--

CREATE TABLE IF NOT EXISTS `three_templates_allowed_children` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_template` int(11) NOT NULL,
  `id_child_template` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `three_templates_allowed_children`
--

INSERT INTO `three_templates_allowed_children` (`id`, `id_template`, `id_child_template`) VALUES
(28, 1, 3),
(27, 1, 2),
(7, 2, 2),
(26, 1, 1),
(11, 4, 2),
(12, 4, 1),
(13, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `three_users`
--

CREATE TABLE IF NOT EXISTS `three_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `id_rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `three_users`
--

INSERT INTO `three_users` (`id`, `username`, `password`, `name`, `email`, `id_rank`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Administrator', 'admin@domain.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `three_values`
--

CREATE TABLE IF NOT EXISTS `three_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=281 ;

--
-- Dumping data for table `three_values`
--

INSERT INTO `three_values` (`id`, `id_content`, `id_option`, `id_language`, `value`) VALUES
(1, 1, 1, 1, 'Titel (NL)'),
(2, 1, 1, 2, 'Titel (EN) Test'),
(3, 1, 1, 3, 'Titel (DE)'),
(4, 1, 2, 1, 'Header (NL)'),
(5, 1, 2, 2, 'Header (EN)'),
(6, 1, 2, 3, 'Header (DE)'),
(7, 1, 3, 1, '<p>\n	Dit is een tekst die hier <strong>geplaatst </strong>is door ckEditor.</p>\n'),
(8, 1, 3, 2, ''),
(9, 1, 3, 3, ''),
(23, 1, 7, 1, '1'),
(22, 1, 1, 6, ''),
(10, 2, 2, 1, 'Koptekst'),
(11, 2, 3, 1, '<p>\n	Inhoud</p>\n'),
(12, 2, 2, 2, 'Small header'),
(13, 2, 3, 2, '<p>\n	content</p>\n'),
(14, 2, 2, 3, 'Eine kopf'),
(15, 2, 3, 3, '<p>\n	Inhalt</p>\n'),
(16, 3, 2, 1, 'Nog een koptekst'),
(17, 3, 3, 1, '<p>\n	Nog wat inhoud</p>\n'),
(18, 3, 2, 2, 'Another header'),
(19, 3, 3, 2, '<p>\n	Yet some other content</p>\n'),
(20, 3, 2, 3, 'Eine header wieder'),
(21, 3, 3, 3, '<p>\n	Und nog wat tekscht</p>\n'),
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
(44, 6, 3, 6, ''),
(155, 1, 11, 1, 'fotoLinks;fotoMidden'),
(154, 1, 10, 6, '#00FF00'),
(153, 1, 10, 3, '#00FF00'),
(152, 1, 10, 2, '#00FF00'),
(151, 1, 10, 1, '#00FF00'),
(267, 3, 2, 6, ''),
(268, 3, 6, 1, ''),
(266, 3, 8, 6, ''),
(265, 3, 8, 3, ''),
(264, 3, 8, 2, ''),
(262, 3, 7, 6, '0'),
(263, 3, 8, 1, ''),
(261, 3, 7, 3, '0'),
(260, 3, 7, 2, '0'),
(259, 3, 7, 1, '0'),
(258, 3, 1, 6, ''),
(257, 3, 1, 3, ''),
(256, 3, 1, 2, ''),
(255, 3, 1, 1, ''),
(254, 2, 11, 6, ''),
(253, 2, 11, 3, ''),
(252, 2, 11, 2, ''),
(251, 2, 11, 1, ''),
(250, 2, 10, 6, '#FF0000'),
(249, 2, 10, 3, '#FF0000'),
(248, 2, 10, 2, '#FF0000'),
(247, 2, 10, 1, '#FF0000'),
(246, 2, 3, 6, ''),
(245, 2, 6, 6, ''),
(244, 2, 6, 3, ''),
(235, 2, 7, 3, '0'),
(236, 2, 7, 6, '0'),
(237, 2, 8, 1, ''),
(238, 2, 8, 2, ''),
(239, 2, 8, 3, ''),
(240, 2, 8, 6, ''),
(241, 2, 2, 6, ''),
(242, 2, 6, 1, ''),
(243, 2, 6, 2, ''),
(271, 3, 6, 6, ''),
(270, 3, 6, 3, ''),
(269, 3, 6, 2, ''),
(229, 2, 1, 1, ''),
(230, 2, 1, 2, ''),
(231, 2, 1, 3, ''),
(232, 2, 1, 6, ''),
(233, 2, 7, 1, '0'),
(234, 2, 7, 2, '0'),
(190, 5, 11, 6, 'fotoMidden'),
(189, 5, 11, 3, 'fotoMidden'),
(188, 5, 11, 2, 'fotoMidden'),
(187, 5, 11, 1, 'fotoMidden'),
(186, 5, 10, 6, '#FF00FF'),
(185, 5, 10, 3, '#FF00FF'),
(184, 5, 10, 2, '#FF00FF'),
(183, 5, 10, 1, '#FF00FF'),
(182, 5, 3, 6, ''),
(181, 5, 3, 3, ''),
(180, 5, 3, 2, ''),
(179, 5, 3, 1, ''),
(178, 5, 6, 6, ''),
(177, 5, 6, 3, ''),
(176, 5, 6, 2, ''),
(175, 5, 6, 1, ''),
(174, 5, 2, 6, ''),
(173, 5, 2, 3, ''),
(172, 5, 2, 2, ''),
(171, 5, 2, 1, ''),
(170, 5, 8, 6, ''),
(169, 5, 8, 3, ''),
(168, 5, 8, 2, ''),
(167, 5, 8, 1, ''),
(166, 5, 7, 6, '0'),
(165, 5, 7, 3, '0'),
(164, 5, 7, 2, '0'),
(163, 5, 7, 1, '0'),
(162, 5, 1, 6, ''),
(161, 5, 1, 3, ''),
(160, 5, 1, 2, 'Content of block 1.2'),
(159, 5, 1, 1, 'Inhoud van blok 1.2'),
(158, 1, 11, 6, 'fotoLinks;fotoMidden'),
(157, 1, 11, 3, 'fotoLinks;fotoMidden'),
(156, 1, 11, 2, 'fotoLinks;fotoMidden'),
(272, 3, 3, 6, ''),
(273, 3, 10, 1, '#FF0000'),
(274, 3, 10, 2, '#FF0000'),
(275, 3, 10, 3, '#FF0000'),
(276, 3, 10, 6, '#FF0000'),
(277, 3, 11, 1, ''),
(278, 3, 11, 2, ''),
(279, 3, 11, 3, ''),
(280, 3, 11, 6, '');
