-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 13, 2009 at 05:00 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `three_content`
--

INSERT INTO `three_content` (`id`, `id_content`, `id_template`, `name`, `alias`, `order`) VALUES
(50, 0, 1, 'Home', 'home', 0);

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
(1, 'Default Page');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

--
-- Dumping data for table `three_dataobjects_options`
--

INSERT INTO `three_dataobjects_options` (`id`, `id_dataobject`, `id_option`, `order`) VALUES
(91, 1, 6, 5),
(90, 1, 3, 4),
(89, 1, 2, 3),
(88, 1, 7, 2),
(87, 1, 8, 1),
(86, 1, 1, 0);

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
(2, 'English', 'en', 1);

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
(8, 'summary', 'large_text', '', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `three_settings`
--

INSERT INTO `three_settings` (`id`, `name`, `value`) VALUES
(1, 'default_language', '1'),
(2, 'default_page_id', '50'),
(3, 'site_name', 'Three Test Site'),
(4, 'base_url', 'http://localhost/three/');

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
(1, 'Default template', 1, 'index.tpl', 1);

-- --------------------------------------------------------

--
-- Table structure for table `three_templates_allowed_children`
--

CREATE TABLE IF NOT EXISTS `three_templates_allowed_children` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_template` int(11) NOT NULL,
  `id_child_template` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `three_templates_allowed_children`
--

INSERT INTO `three_templates_allowed_children` (`id`, `id_template`, `id_child_template`) VALUES
(32, 1, 3),
(31, 1, 2),
(35, 2, 2),
(30, 1, 1),
(11, 4, 2),
(12, 4, 1),
(13, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `three_templates_ranks`
--

CREATE TABLE IF NOT EXISTS `three_templates_ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_template` int(11) NOT NULL,
  `id_rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `three_templates_ranks`
--

INSERT INTO `three_templates_ranks` (`id`, `id_template`, `id_rank`) VALUES
(1, 1, 1),
(3, 2, 1),
(4, 3, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=293 ;

--
-- Dumping data for table `three_values`
--

INSERT INTO `three_values` (`id`, `id_content`, `id_option`, `id_language`, `value`) VALUES
(286, 50, 7, 2, '1'),
(285, 50, 7, 1, '1'),
(284, 50, 8, 2, 'This is the demonstration page of Three CMS'),
(281, 50, 1, 1, 'Demonstratie Pagina'),
(282, 50, 1, 2, 'Demonstration Page'),
(283, 50, 8, 1, 'Dit is de demonstratiepagina van Three CMS'),
(292, 50, 6, 2, ''),
(290, 50, 3, 2, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit amet sem mauris, nec ullamcorper velit. Quisque risus metus, interdum quis gravida eget, varius eget ligula. Maecenas sed mi mi, quis accumsan ipsum. Suspendisse eget rhoncus diam. Donec rhoncus, lectus sed pellentesque elementum, lorem erat ultrices ligula, at egestas justo ipsum sit amet quam. Nulla sit amet augue arcu, nec pharetra nisl. Proin non dapibus nisl. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis venenatis congue risus ac adipiscing. In hac habitasse platea dictumst. Pellentesque eget mi vel libero egestas varius. In consectetur ipsum et mi iaculis mollis. Nulla dolor elit, convallis a interdum pulvinar, porta et dui. Quisque faucibus lectus leo. Mauris placerat facilisis massa, molestie venenatis lorem tempus in. Sed varius venenatis pharetra. Quisque porttitor ultricies purus ut imperdiet. Aliquam eu est quam, sed egestas eros. Aliquam erat volutpat. Nam tincidunt, nisl tempor pulvinar tincidunt, erat dolor condimentum ante, vitae sagittis tellus sapien ac quam.</p>\n<p>\n	Cras fringilla odio purus. Nullam vitae sapien urna. Aenean accumsan est sit amet orci dignissim volutpat. Maecenas sed gravida orci. Aliquam euismod vestibulum nisi, a auctor massa pulvinar a. Nam non dui a ipsum dapibus tempus. Vivamus ligula magna, euismod ac ornare ut, laoreet ac felis. Nullam ipsum lectus, ornare eget posuere nec, luctus placerat nisi. Curabitur augue ipsum, consectetur sed commodo a, viverra ut quam. Morbi vel purus nec ipsum tincidunt porta. Nunc ac neque ipsum. Nam congue lorem vel diam tincidunt convallis.</p>\n<p>\n	Nam eget dignissim magna. Donec a magna risus, vel sagittis nisl. Sed lobortis turpis malesuada nulla euismod scelerisque. Suspendisse quis pretium nibh. Suspendisse dignissim posuere sollicitudin. Proin est mauris, ornare sed rhoncus eget, eleifend eget ante. Vestibulum dapibus, nisi eget ultricies imperdiet, tellus turpis viverra nunc, sit amet tempus felis nibh ac lectus. Cras bibendum odio condimentum justo mattis viverra. Integer eu leo orci, sed feugiat neque. Ut eget ipsum a neque pharetra luctus. Suspendisse nunc felis, varius ac scelerisque vitae, fringilla sed urna. Phasellus semper mi vitae leo pharetra non imperdiet dolor auctor.</p>\n'),
(291, 50, 6, 1, ''),
(289, 50, 3, 1, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit amet sem mauris, nec ullamcorper velit. Quisque risus metus, interdum quis gravida eget, varius eget ligula. Maecenas sed mi mi, quis accumsan ipsum. Suspendisse eget rhoncus diam. Donec rhoncus, lectus sed pellentesque elementum, lorem erat ultrices ligula, at egestas justo ipsum sit amet quam. Nulla sit amet augue arcu, nec pharetra nisl. Proin non dapibus nisl. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis venenatis congue risus ac adipiscing. In hac habitasse platea dictumst. Pellentesque eget mi vel libero egestas varius. In consectetur ipsum et mi iaculis mollis. Nulla dolor elit, convallis a interdum pulvinar, porta et dui. Quisque faucibus lectus leo. Mauris placerat facilisis massa, molestie venenatis lorem tempus in. Sed varius venenatis pharetra. Quisque porttitor ultricies purus ut imperdiet. Aliquam eu est quam, sed egestas eros. Aliquam erat volutpat. Nam tincidunt, nisl tempor pulvinar tincidunt, erat dolor condimentum ante, vitae sagittis tellus sapien ac quam.</p>\n<p>\n	Cras fringilla odio purus. Nullam vitae sapien urna. Aenean accumsan est sit amet orci dignissim volutpat. Maecenas sed gravida orci. Aliquam euismod vestibulum nisi, a auctor massa pulvinar a. Nam non dui a ipsum dapibus tempus. Vivamus ligula magna, euismod ac ornare ut, laoreet ac felis. Nullam ipsum lectus, ornare eget posuere nec, luctus placerat nisi. Curabitur augue ipsum, consectetur sed commodo a, viverra ut quam. Morbi vel purus nec ipsum tincidunt porta. Nunc ac neque ipsum. Nam congue lorem vel diam tincidunt convallis.</p>\n<p>\n	Nam eget dignissim magna. Donec a magna risus, vel sagittis nisl. Sed lobortis turpis malesuada nulla euismod scelerisque. Suspendisse quis pretium nibh. Suspendisse dignissim posuere sollicitudin. Proin est mauris, ornare sed rhoncus eget, eleifend eget ante. Vestibulum dapibus, nisi eget ultricies imperdiet, tellus turpis viverra nunc, sit amet tempus felis nibh ac lectus. Cras bibendum odio condimentum justo mattis viverra. Integer eu leo orci, sed feugiat neque. Ut eget ipsum a neque pharetra luctus. Suspendisse nunc felis, varius ac scelerisque vitae, fringilla sed urna. Phasellus semper mi vitae leo pharetra non imperdiet dolor auctor.</p>\n'),
(288, 50, 2, 2, 'Welcome'),
(287, 50, 2, 1, 'Welkom');
