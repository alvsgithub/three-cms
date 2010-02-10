-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 10 Feb 2010 om 15:47
-- Serverversie: 5.1.36
-- PHP-Versie: 5.3.0

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
-- Tabelstructuur voor tabel `three_content`
--

CREATE TABLE IF NOT EXISTS `three_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) NOT NULL,
  `id_template` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `alias` tinytext NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_content`
--

INSERT INTO `three_content` (`id`, `id_content`, `id_template`, `name`, `alias`, `order`) VALUES
(54, 52, 5, 'Value 2', 'value-2', 2),
(52, 0, 6, 'Core Values', 'core-values', 2),
(53, 52, 5, 'Value 1', 'value-1', 1),
(50, 0, 1, 'Home', 'home', 0),
(51, 0, 1, 'What is Three CMS', 'what-is-three-cms', 1),
(55, 52, 5, 'Value 3', 'value-3', 3),
(56, 0, 7, 'News', 'news', 3),
(57, 56, 8, 'New CMS', 'new-cms', 1),
(58, 56, 8, 'Public news item', 'public-news-item', 2),
(59, 56, 8, 'Alleen voor groep B', 'alleen-voor-groep-b', 3),
(60, 0, 1, 'Example page', 'example-page', 4),
(61, 0, 1, 'Example page', 'example-page-1', 5),
(62, 61, 1, 'Subpage', 'subpage', 6);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_dataobjects`
--

CREATE TABLE IF NOT EXISTS `three_dataobjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_dataobjects`
--

INSERT INTO `three_dataobjects` (`id`, `name`) VALUES
(1, 'Default Page'),
(5, 'Core Value'),
(6, 'News Item'),
(7, 'Core Values Page');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_dataobjects_options`
--

CREATE TABLE IF NOT EXISTS `three_dataobjects_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dataobject` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_dataobjects_options`
--

INSERT INTO `three_dataobjects_options` (`id`, `id_dataobject`, `id_option`, `order`) VALUES
(148, 7, 6, 6),
(140, 1, 6, 5),
(139, 1, 3, 4),
(138, 1, 2, 3),
(137, 1, 7, 2),
(93, 5, 3, 1),
(92, 5, 2, 0),
(136, 1, 8, 1),
(107, 6, 8, 4),
(106, 6, 12, 3),
(105, 6, 14, 2),
(104, 6, 13, 1),
(103, 6, 2, 0),
(108, 6, 3, 5),
(135, 1, 1, 0),
(147, 7, 3, 5),
(146, 7, 2, 4),
(145, 7, 7, 3),
(144, 7, 8, 2),
(143, 7, 12, 1),
(142, 7, 1, 0),
(141, 1, 15, 6),
(149, 7, 15, 7);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_languages`
--

CREATE TABLE IF NOT EXISTS `three_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `code` varchar(2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_languages`
--

INSERT INTO `three_languages` (`id`, `name`, `code`, `active`) VALUES
(1, 'Nederlands', 'nl', 1),
(2, 'English', 'en', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_locales`
--

CREATE TABLE IF NOT EXISTS `three_locales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_locales`
--

INSERT INTO `three_locales` (`id`, `name`) VALUES
(12, 'coreValues'),
(11, 'languagePicker'),
(13, 'readMore'),
(14, 'date'),
(15, 'author');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_locales_values`
--

CREATE TABLE IF NOT EXISTS `three_locales_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_locale` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_locales_values`
--

INSERT INTO `three_locales_values` (`id`, `id_locale`, `id_language`, `value`) VALUES
(57, 12, 2, 'Core Values'),
(54, 11, 1, 'Taal kiezer'),
(55, 11, 2, 'Language picker'),
(56, 12, 1, 'Kernwaarden'),
(58, 13, 1, 'lees verder'),
(59, 13, 2, 'read more'),
(60, 14, 1, 'Datum'),
(61, 14, 2, 'Date'),
(62, 15, 1, 'Auteur'),
(63, 15, 2, 'Author');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_options`
--

CREATE TABLE IF NOT EXISTS `three_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `tooltip` tinytext NOT NULL,
  `type` enum('small_text','large_text','rich_text','url','image','file','boolean','dropdown','selectbox','date','time','content','content_of_type') NOT NULL,
  `options` text NOT NULL,
  `default_value` text NOT NULL,
  `multilanguage` tinyint(1) NOT NULL,
  `required` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_options`
--

INSERT INTO `three_options` (`id`, `name`, `description`, `tooltip`, `type`, `options`, `default_value`, `multilanguage`, `required`) VALUES
(1, 'title', 'Title', '', 'small_text', '', '', 1, 0),
(2, 'header', 'Header', '', 'small_text', '', '', 1, 0),
(3, 'content', 'Content', '', 'rich_text', '', '', 1, 0),
(6, 'headerImage', 'HeaderImage', '', 'image', '', '', 0, 0),
(7, 'Show in menu', 'Show in menu', '', 'boolean', '', '', 0, 0),
(8, 'summary', 'Summary', '', 'large_text', '', '', 1, 0),
(12, 'author', 'Author', '', 'small_text', '', '', 0, 0),
(13, 'date', 'Date', '', 'date', '', '', 0, 0),
(14, 'time', 'Time', 'The time of this item', 'time', '', '', 0, 0),
(15, 'published', 'Published', '', 'boolean', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_ranks`
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
-- Gegevens worden uitgevoerd voor tabel `three_ranks`
--

INSERT INTO `three_ranks` (`id`, `name`, `system`, `users`, `ranks`, `configuration`) VALUES
(1, 'Administrator', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_ranks_addons`
--

CREATE TABLE IF NOT EXISTS `three_ranks_addons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rank` int(11) NOT NULL,
  `addon` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_ranks_addons`
--

INSERT INTO `three_ranks_addons` (`id`, `id_rank`, `addon`) VALUES
(8, 1, 'webusers');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_settings`
--

CREATE TABLE IF NOT EXISTS `three_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_settings`
--

INSERT INTO `three_settings` (`id`, `name`, `value`) VALUES
(1, 'default_language', '1'),
(2, 'default_page_id', '50'),
(3, 'site_name', 'Three Test Site'),
(4, 'base_url', 'http://localhost/three/'),
(5, 'date_format', '%m/%d/%Y');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_templates`
--

CREATE TABLE IF NOT EXISTS `three_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `id_dataobject` int(11) NOT NULL,
  `templatefile` tinytext NOT NULL,
  `root` tinyint(1) NOT NULL,
  `type` enum('page','content') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_templates`
--

INSERT INTO `three_templates` (`id`, `name`, `id_dataobject`, `templatefile`, `root`, `type`) VALUES
(1, 'Default Template', 1, 'index.tpl', 1, 'page'),
(5, 'Single Core Value Template', 5, 'coreValue.tpl', 0, 'content'),
(6, 'Core Values Template', 7, 'coreValues.tpl', 1, 'page'),
(7, 'News Template', 1, 'news.tpl', 1, 'page'),
(8, 'News Item Template', 6, 'newsItem.tpl', 0, 'content');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_templates_allowed_children`
--

CREATE TABLE IF NOT EXISTS `three_templates_allowed_children` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_template` int(11) NOT NULL,
  `id_child_template` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_templates_allowed_children`
--

INSERT INTO `three_templates_allowed_children` (`id`, `id_template`, `id_child_template`) VALUES
(44, 6, 5),
(35, 2, 2),
(11, 4, 2),
(12, 4, 1),
(13, 4, 3),
(42, 5, 6),
(43, 7, 8),
(58, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_templates_ranks`
--

CREATE TABLE IF NOT EXISTS `three_templates_ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_template` int(11) NOT NULL,
  `id_rank` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `add` tinyint(1) NOT NULL,
  `modify` tinyint(1) NOT NULL,
  `duplicate` tinyint(1) NOT NULL,
  `move` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_templates_ranks`
--

INSERT INTO `three_templates_ranks` (`id`, `id_template`, `id_rank`, `visible`, `add`, `modify`, `duplicate`, `move`, `delete`) VALUES
(26, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 2, 1, 1, 1, 1, 1, 1, 1),
(4, 3, 1, 1, 1, 1, 1, 1, 1),
(11, 5, 1, 1, 1, 1, 1, 1, 1),
(15, 6, 1, 1, 1, 1, 1, 1, 1),
(14, 7, 1, 1, 1, 1, 1, 1, 1),
(13, 8, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_users`
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
-- Gegevens worden uitgevoerd voor tabel `three_users`
--

INSERT INTO `three_users` (`id`, `username`, `password`, `name`, `email`, `id_rank`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Administrator', 'admin@domain.com', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_values`
--

CREATE TABLE IF NOT EXISTS `three_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=410 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_values`
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
(287, 50, 2, 1, 'Welkom'),
(293, 51, 1, 1, 'Wat is Three CMS?'),
(294, 51, 1, 2, 'What is Three CMS?'),
(295, 51, 8, 1, ''),
(296, 51, 8, 2, ''),
(297, 51, 7, 1, '1'),
(298, 51, 7, 2, '1'),
(299, 51, 2, 1, 'Wat is Three CMS?'),
(300, 51, 2, 2, 'What is Three CMS?'),
(301, 51, 3, 1, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu dolor dolor, eu egestas lectus. Aenean elementum feugiat velit non vulputate. Nulla iaculis accumsan congue. Fusce sed lectus et felis sollicitudin viverra ac sed justo. Aliquam mauris nulla, lobortis dignissim cursus at, laoreet vel sem. Duis sit amet massa tortor. Nam nec pharetra ante. Vestibulum congue lobortis porta. Suspendisse eget velit et nisl tempus ullamcorper ut eu sem. Suspendisse tortor nunc, lobortis a pulvinar tristique, pretium nec nunc. Nulla et pellentesque lacus.</p>\n<p>\n	Nam neque mauris, ultrices non fermentum dictum, tincidunt at sapien. Aliquam a nulla eros, nec vestibulum sapien. Suspendisse potenti. Vestibulum adipiscing malesuada sapien vel sodales. Suspendisse potenti. Donec posuere augue mauris, at feugiat purus. Quisque ut ultricies tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris mi augue, posuere sed tincidunt sit amet, dictum id neque. Sed at eros augue. Praesent quis nisi eu mi facilisis ornare. Vivamus tempor feugiat diam vel consectetur. In sit amet pellentesque mi. Vivamus nisl ipsum, porta ut lobortis condimentum, scelerisque non erat.</p>\n<p>\n	Proin urna leo, eleifend vel condimentum a, laoreet non elit. Donec quis arcu ac ipsum porta venenatis. Pellentesque tristique augue tortor, sit amet mollis augue. Maecenas augue est, porttitor et convallis eget, congue id arcu. Sed feugiat faucibus lorem ac tempor. Praesent nec pretium turpis. Aenean tincidunt rhoncus scelerisque. Nam quam est, commodo non commodo sed, mattis sollicitudin tellus. Mauris eget turpis eu risus ultrices faucibus eget nec nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas ultricies accumsan turpis nec cursus. Vivamus et tempor sem.</p>\n'),
(302, 51, 3, 2, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu dolor dolor, eu egestas lectus. Aenean elementum feugiat velit non vulputate. Nulla iaculis accumsan congue. Fusce sed lectus et felis sollicitudin viverra ac sed justo. Aliquam mauris nulla, lobortis dignissim cursus at, laoreet vel sem. Duis sit amet massa tortor. Nam nec pharetra ante. Vestibulum congue lobortis porta. Suspendisse eget velit et nisl tempus ullamcorper ut eu sem. Suspendisse tortor nunc, lobortis a pulvinar tristique, pretium nec nunc. Nulla et pellentesque lacus.</p>\n<p>\n	Nam neque mauris, ultrices non fermentum dictum, tincidunt at sapien. Aliquam a nulla eros, nec vestibulum sapien. Suspendisse potenti. Vestibulum adipiscing malesuada sapien vel sodales. Suspendisse potenti. Donec posuere augue mauris, at feugiat purus. Quisque ut ultricies tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris mi augue, posuere sed tincidunt sit amet, dictum id neque. Sed at eros augue. Praesent quis nisi eu mi facilisis ornare. Vivamus tempor feugiat diam vel consectetur. In sit amet pellentesque mi. Vivamus nisl ipsum, porta ut lobortis condimentum, scelerisque non erat.</p>\n<p>\n	Proin urna leo, eleifend vel condimentum a, laoreet non elit. Donec quis arcu ac ipsum porta venenatis. Pellentesque tristique augue tortor, sit amet mollis augue. Maecenas augue est, porttitor et convallis eget, congue id arcu. Sed feugiat faucibus lorem ac tempor. Praesent nec pretium turpis. Aenean tincidunt rhoncus scelerisque. Nam quam est, commodo non commodo sed, mattis sollicitudin tellus. Mauris eget turpis eu risus ultrices faucibus eget nec nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas ultricies accumsan turpis nec cursus. Vivamus et tempor sem.</p>\n'),
(303, 51, 6, 1, ''),
(304, 51, 6, 2, ''),
(305, 52, 1, 1, 'Kernwaarden'),
(306, 52, 1, 2, 'Core Values'),
(307, 52, 8, 1, ''),
(308, 52, 8, 2, ''),
(309, 52, 7, 1, '1'),
(310, 52, 7, 2, '1'),
(311, 52, 2, 1, 'Kernwaarden'),
(312, 52, 2, 2, 'Core Values'),
(313, 52, 3, 1, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu dolor dolor, eu egestas lectus. Aenean elementum feugiat velit non vulputate. Nulla iaculis accumsan congue. Fusce sed lectus et felis sollicitudin viverra ac sed justo. Aliquam mauris nulla, lobortis dignissim cursus at, laoreet vel sem. Duis sit amet massa tortor. Nam nec pharetra ante. Vestibulum congue lobortis porta. Suspendisse eget velit et nisl tempus ullamcorper ut eu sem. Suspendisse tortor nunc, lobortis a pulvinar tristique, pretium nec nunc. Nulla et pellentesque lacus.</p>\n<p>\n	Nam neque mauris, ultrices non fermentum dictum, tincidunt at sapien. Aliquam a nulla eros, nec vestibulum sapien. Suspendisse potenti. Vestibulum adipiscing malesuada sapien vel sodales. Suspendisse potenti. Donec posuere augue mauris, at feugiat purus. Quisque ut ultricies tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris mi augue, posuere sed tincidunt sit amet, dictum id neque. Sed at eros augue. Praesent quis nisi eu mi facilisis ornare. Vivamus tempor feugiat diam vel consectetur. In sit amet pellentesque mi. Vivamus nisl ipsum, porta ut lobortis condimentum, scelerisque non erat.</p>\n<p>\n	Proin urna leo, eleifend vel condimentum a, laoreet non elit. Donec quis arcu ac ipsum porta venenatis. Pellentesque tristique augue tortor, sit amet mollis augue. Maecenas augue est, porttitor et convallis eget, congue id arcu. Sed feugiat faucibus lorem ac tempor. Praesent nec pretium turpis. Aenean tincidunt rhoncus scelerisque. Nam quam est, commodo non commodo sed, mattis sollicitudin tellus. Mauris eget turpis eu risus ultrices faucibus eget nec nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas ultricies accumsan turpis nec cursus. Vivamus et tempor sem.</p>\n'),
(314, 52, 3, 2, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu dolor dolor, eu egestas lectus. Aenean elementum feugiat velit non vulputate. Nulla iaculis accumsan congue. Fusce sed lectus et felis sollicitudin viverra ac sed justo. Aliquam mauris nulla, lobortis dignissim cursus at, laoreet vel sem. Duis sit amet massa tortor. Nam nec pharetra ante. Vestibulum congue lobortis porta. Suspendisse eget velit et nisl tempus ullamcorper ut eu sem. Suspendisse tortor nunc, lobortis a pulvinar tristique, pretium nec nunc. Nulla et pellentesque lacus.</p>\n<p>\n	Nam neque mauris, ultrices non fermentum dictum, tincidunt at sapien. Aliquam a nulla eros, nec vestibulum sapien. Suspendisse potenti. Vestibulum adipiscing malesuada sapien vel sodales. Suspendisse potenti. Donec posuere augue mauris, at feugiat purus. Quisque ut ultricies tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris mi augue, posuere sed tincidunt sit amet, dictum id neque. Sed at eros augue. Praesent quis nisi eu mi facilisis ornare. Vivamus tempor feugiat diam vel consectetur. In sit amet pellentesque mi. Vivamus nisl ipsum, porta ut lobortis condimentum, scelerisque non erat.</p>\n<p>\n	Proin urna leo, eleifend vel condimentum a, laoreet non elit. Donec quis arcu ac ipsum porta venenatis. Pellentesque tristique augue tortor, sit amet mollis augue. Maecenas augue est, porttitor et convallis eget, congue id arcu. Sed feugiat faucibus lorem ac tempor. Praesent nec pretium turpis. Aenean tincidunt rhoncus scelerisque. Nam quam est, commodo non commodo sed, mattis sollicitudin tellus. Mauris eget turpis eu risus ultrices faucibus eget nec nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas ultricies accumsan turpis nec cursus. Vivamus et tempor sem.</p>\n'),
(315, 52, 6, 1, ''),
(316, 52, 6, 2, ''),
(317, 53, 2, 1, 'Kernwaarde 1'),
(318, 53, 2, 2, 'Core Value 1'),
(319, 53, 3, 1, '<p>\n	Praesent eu ipsum ac mauris lobortis tempus. Donec ullamcorper, eros eu mollis facilisis, massa est consectetur purus, pretium rutrum lorem dui eget metus. Pellentesque ullamcorper scelerisque erat non bibendum. In placerat molestie quam, ut pellentesque purus sodales non. Nam vitae dolor a ligula tincidunt vestibulum. Nullam ante leo, tristique a suscipit vel, semper ullamcorper sapien. Nulla facilisi.</p>\n'),
(320, 53, 3, 2, '<p>\n	Praesent eu ipsum ac mauris lobortis tempus. Donec ullamcorper, eros eu mollis facilisis, massa est consectetur purus, pretium rutrum lorem dui eget metus. Pellentesque ullamcorper scelerisque erat non bibendum. In placerat molestie quam, ut pellentesque purus sodales non. Nam vitae dolor a ligula tincidunt vestibulum. Nullam ante leo, tristique a suscipit vel, semper ullamcorper sapien. Nulla facilisi.</p>\n'),
(321, 54, 2, 1, 'Kernwaarde 2'),
(322, 54, 2, 2, 'Core Value 2'),
(323, 54, 3, 1, '<p>\n	Nulla eu lectus eu neque ornare ullamcorper vel ac sapien. Duis at mauris in eros tincidunt scelerisque in ac urna. Etiam quis quam eu velit aliquet ultricies adipiscing vitae orci. Vestibulum ac nibh sit amet sapien consectetur viverra sed at leo. Proin eget tellus sit amet ante dignissim tincidunt. In lacinia velit ut leo pharetra in laoreet mauris euismod.</p>\n'),
(324, 54, 3, 2, '<p>\n	Nulla eu lectus eu neque ornare ullamcorper vel ac sapien. Duis at mauris in eros tincidunt scelerisque in ac urna. Etiam quis quam eu velit aliquet ultricies adipiscing vitae orci. Vestibulum ac nibh sit amet sapien consectetur viverra sed at leo. Proin eget tellus sit amet ante dignissim tincidunt. In lacinia velit ut leo pharetra in laoreet mauris euismod.</p>\n'),
(325, 55, 2, 1, 'Kernwaarde 3'),
(326, 55, 2, 2, 'Core Value 3'),
(327, 55, 3, 1, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquam, risus ut sollicitudin fermentum, sem ipsum auctor urna, a cursus velit nulla at lectus. Etiam odio nunc, ultrices ut hendrerit quis, convallis non ipsum. Vestibulum placerat, dui sit amet varius placerat, odio sapien volutpat est, at bibendum mauris lorem non massa. Maecenas augue justo, molestie at scelerisque at, gravida sit amet nibh.</p>\n'),
(328, 55, 3, 2, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquam, risus ut sollicitudin fermentum, sem ipsum auctor urna, a cursus velit nulla at lectus. Etiam odio nunc, ultrices ut hendrerit quis, convallis non ipsum. Vestibulum placerat, dui sit amet varius placerat, odio sapien volutpat est, at bibendum mauris lorem non massa. Maecenas augue justo, molestie at scelerisque at, gravida sit amet nibh.</p>\n'),
(329, 56, 1, 1, 'Nieuws'),
(330, 56, 1, 2, 'News'),
(331, 56, 8, 1, ''),
(332, 56, 8, 2, ''),
(333, 56, 7, 1, '1'),
(334, 56, 7, 2, '1'),
(335, 56, 2, 1, 'Nieuws'),
(336, 56, 2, 2, 'News'),
(337, 56, 3, 1, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin risus leo, bibendum semper mauris. Donec vel tellus vitae felis rutrum scelerisque. Cras luctus molestie tempor. Maecenas a porta metus. Pellentesque auctor mattis tincidunt. Proin porttitor nulla et turpis euismod egestas.</p>\n'),
(338, 56, 3, 2, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin risus leo, bibendum semper mauris. Donec vel tellus vitae felis rutrum scelerisque. Cras luctus molestie tempor. Maecenas a porta metus. Pellentesque auctor mattis tincidunt. Proin porttitor nulla et turpis euismod egestas.</p>\n'),
(339, 56, 6, 1, ''),
(340, 56, 6, 2, ''),
(341, 57, 2, 1, 'Nieuw CMS'),
(342, 57, 2, 2, 'New CMS'),
(343, 57, 13, 1, '01/27/2010'),
(344, 57, 13, 2, '01/27/2010'),
(345, 57, 12, 1, 'Giel Berkers'),
(346, 57, 12, 2, 'Giel Berkers'),
(347, 57, 3, 1, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin risus leo, bibendum semper mauris. Donec vel tellus vitae felis rutrum scelerisque. Cras luctus molestie tempor. Maecenas a porta metus. Pellentesque auctor mattis tincidunt. Proin porttitor nulla et turpis euismod egestas.</p>\n<p>\n	Maecenas sagittis commodo libero eu consectetur. Nulla et ante enim, a sollicitudin mi. Vestibulum lectus est, aliquet eu pharetra a, laoreet ut elit. Phasellus porttitor, eros eget adipiscing malesuada, massa nunc tincidunt elit, eget iaculis magna orci luctus eros.</p>\n'),
(348, 57, 3, 2, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin risus leo, bibendum semper mauris. Donec vel tellus vitae felis rutrum scelerisque. Cras luctus molestie tempor. Maecenas a porta metus. Pellentesque auctor mattis tincidunt. Proin porttitor nulla et turpis euismod egestas.</p>\n<p>\n	Maecenas sagittis commodo libero eu consectetur. Nulla et ante enim, a sollicitudin mi. Vestibulum lectus est, aliquet eu pharetra a, laoreet ut elit. Phasellus porttitor, eros eget adipiscing malesuada, massa nunc tincidunt elit, eget iaculis magna orci luctus eros.</p>\n'),
(349, 57, 8, 1, 'Sinds vandaag is er een nieuw CMS!'),
(350, 57, 8, 2, 'Since today there is a new CMS!'),
(351, 58, 2, 1, 'Publiek nieuws bericht'),
(352, 58, 2, 2, 'Public news item'),
(353, 58, 13, 1, ''),
(354, 58, 13, 2, ''),
(355, 58, 12, 1, 'Mr. Public'),
(356, 58, 12, 2, 'Mr. Public'),
(357, 58, 8, 1, 'Een korte introductie'),
(358, 58, 8, 2, 'A short introduction'),
(359, 58, 3, 1, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec risus mauris. Suspendisse consectetur tristique odio. Donec vitae ante a enim varius commodo. Cras non tortor eros, ac sollicitudin lectus. Curabitur nec leo ac sapien porttitor eleifend ac non nibh. Vestibulum egestas condimentum lectus et malesuada. Cras imperdiet malesuada tincidunt. Phasellus condimentum justo eu ipsum viverra suscipit pretium diam auctor. Curabitur consectetur odio vehicula ipsum posuere tempor nec at est. Vivamus arcu urna, semper ut condimentum et, commodo at mauris. Fusce nec libero turpis. Quisque dictum sagittis tincidunt. Maecenas sem dolor, sollicitudin ultricies pulvinar vel, ullamcorper id nisl. Donec suscipit elit eu justo commodo pretium. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br />\n	<br />\n	Donec pellentesque, sem ac aliquam convallis, lectus purus auctor odio, id rutrum felis neque sit amet metus. Nulla facilisi. Etiam at dapibus ligula. Morbi feugiat, massa in tempus tincidunt, diam mi egestas nibh, non sagittis lectus sem vel enim. Praesent luctus dolor et quam facilisis tristique. Pellentesque convallis elit quis leo malesuada condimentum. Integer mollis dui sit amet lorem mattis aliquet. Aenean tincidunt mattis aliquam. Praesent sed libero turpis. Nulla laoreet, erat ut pharetra pellentesque, lorem urna bibendum libero, non commodo purus nulla et massa. Fusce sagittis sapien in ipsum mattis rhoncus. Nunc ullamcorper porttitor quam, sit amet pulvinar magna fermentum et. Donec dictum aliquam nulla id iaculis. Fusce orci diam, rhoncus id volutpat ut, dignissim varius magna. Phasellus ullamcorper, purus sit amet malesuada mollis, magna libero laoreet nulla, sed convallis sem urna in augue. Vestibulum et tellus nunc, eu cursus sem. Sed iaculis sapien eget mauris posuere a pharetra turpis suscipit.<br />\n	<br />\n	Integer vitae velit eget risus viverra hendrerit nec ut ipsum. Donec sagittis sem vitae felis imperdiet non consequat orci tempor. Suspendisse vulputate, velit quis posuere ullamcorper, mauris urna accumsan nulla, eget mattis tortor elit ac magna. Ut ullamcorper purus eget nibh rhoncus sit amet cursus ante sagittis. Aliquam felis enim, aliquet et aliquam nec, dictum nec magna. Morbi in dui vel diam vulputate malesuada id vitae lectus. Nunc tincidunt bibendum vulputate. Vivamus eros ante, facilisis eget ultricies quis, fringilla ut odio. Ut ut lacus nec velit ultrices lacinia ac rutrum eros. Praesent sit amet erat at dolor porta facilisis. Donec posuere porta diam eget venenatis. Cras eleifend tristique urna, a scelerisque nisi cursus id.</p>\n'),
(360, 58, 3, 2, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec risus mauris. Suspendisse consectetur tristique odio. Donec vitae ante a enim varius commodo. Cras non tortor eros, ac sollicitudin lectus. Curabitur nec leo ac sapien porttitor eleifend ac non nibh. Vestibulum egestas condimentum lectus et malesuada. Cras imperdiet malesuada tincidunt. Phasellus condimentum justo eu ipsum viverra suscipit pretium diam auctor. Curabitur consectetur odio vehicula ipsum posuere tempor nec at est. Vivamus arcu urna, semper ut condimentum et, commodo at mauris. Fusce nec libero turpis. Quisque dictum sagittis tincidunt. Maecenas sem dolor, sollicitudin ultricies pulvinar vel, ullamcorper id nisl. Donec suscipit elit eu justo commodo pretium. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br />\n	<br />\n	Donec pellentesque, sem ac aliquam convallis, lectus purus auctor odio, id rutrum felis neque sit amet metus. Nulla facilisi. Etiam at dapibus ligula. Morbi feugiat, massa in tempus tincidunt, diam mi egestas nibh, non sagittis lectus sem vel enim. Praesent luctus dolor et quam facilisis tristique. Pellentesque convallis elit quis leo malesuada condimentum. Integer mollis dui sit amet lorem mattis aliquet. Aenean tincidunt mattis aliquam. Praesent sed libero turpis. Nulla laoreet, erat ut pharetra pellentesque, lorem urna bibendum libero, non commodo purus nulla et massa. Fusce sagittis sapien in ipsum mattis rhoncus. Nunc ullamcorper porttitor quam, sit amet pulvinar magna fermentum et. Donec dictum aliquam nulla id iaculis. Fusce orci diam, rhoncus id volutpat ut, dignissim varius magna. Phasellus ullamcorper, purus sit amet malesuada mollis, magna libero laoreet nulla, sed convallis sem urna in augue. Vestibulum et tellus nunc, eu cursus sem. Sed iaculis sapien eget mauris posuere a pharetra turpis suscipit.<br />\n	<br />\n	Integer vitae velit eget risus viverra hendrerit nec ut ipsum. Donec sagittis sem vitae felis imperdiet non consequat orci tempor. Suspendisse vulputate, velit quis posuere ullamcorper, mauris urna accumsan nulla, eget mattis tortor elit ac magna. Ut ullamcorper purus eget nibh rhoncus sit amet cursus ante sagittis. Aliquam felis enim, aliquet et aliquam nec, dictum nec magna. Morbi in dui vel diam vulputate malesuada id vitae lectus. Nunc tincidunt bibendum vulputate. Vivamus eros ante, facilisis eget ultricies quis, fringilla ut odio. Ut ut lacus nec velit ultrices lacinia ac rutrum eros. Praesent sit amet erat at dolor porta facilisis. Donec posuere porta diam eget venenatis. Cras eleifend tristique urna, a scelerisque nisi cursus id.</p>\n'),
(361, 59, 2, 1, 'Alleen voor groep B'),
(362, 59, 2, 2, 'Only for group B'),
(363, 59, 13, 1, ''),
(364, 59, 13, 2, ''),
(365, 59, 12, 1, ''),
(366, 59, 12, 2, ''),
(367, 59, 8, 1, 'Alleen groep B kan dit nieuwsbericht zien.'),
(368, 59, 8, 2, 'Only Group B can view this news message.'),
(369, 59, 3, 1, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec risus mauris. Suspendisse consectetur tristique odio. Donec vitae ante a enim varius commodo. Cras non tortor eros, ac sollicitudin lectus. Curabitur nec leo ac sapien porttitor eleifend ac non nibh. Vestibulum egestas condimentum lectus et malesuada. Cras imperdiet malesuada tincidunt. Phasellus condimentum justo eu ipsum viverra suscipit pretium diam auctor. Curabitur consectetur odio vehicula ipsum posuere tempor nec at est. Vivamus arcu urna, semper ut condimentum et, commodo at mauris. Fusce nec libero turpis. Quisque dictum sagittis tincidunt. Maecenas sem dolor, sollicitudin ultricies pulvinar vel, ullamcorper id nisl. Donec suscipit elit eu justo commodo pretium. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>\n<p>\n	Donec pellentesque, sem ac aliquam convallis, lectus purus auctor odio, id rutrum felis neque sit amet metus. Nulla facilisi. Etiam at dapibus ligula. Morbi feugiat, massa in tempus tincidunt, diam mi egestas nibh, non sagittis lectus sem vel enim. Praesent luctus dolor et quam facilisis tristique. Pellentesque convallis elit quis leo malesuada condimentum. Integer mollis dui sit amet lorem mattis aliquet. Aenean tincidunt mattis aliquam. Praesent sed libero turpis. Nulla laoreet, erat ut pharetra pellentesque, lorem urna bibendum libero, non commodo purus nulla et massa. Fusce sagittis sapien in ipsum mattis rhoncus. Nunc ullamcorper porttitor quam, sit amet pulvinar magna fermentum et. Donec dictum aliquam nulla id iaculis. Fusce orci diam, rhoncus id volutpat ut, dignissim varius magna. Phasellus ullamcorper, purus sit amet malesuada mollis, magna libero laoreet nulla, sed convallis sem urna in augue. Vestibulum et tellus nunc, eu cursus sem. Sed iaculis sapien eget mauris posuere a pharetra turpis suscipit.</p>\n<p>\n	Integer vitae velit eget risus viverra hendrerit nec ut ipsum. Donec sagittis sem vitae felis imperdiet non consequat orci tempor. Suspendisse vulputate, velit quis posuere ullamcorper, mauris urna accumsan nulla, eget mattis tortor elit ac magna. Ut ullamcorper purus eget nibh rhoncus sit amet cursus ante sagittis. Aliquam felis enim, aliquet et aliquam nec, dictum nec magna. Morbi in dui vel diam vulputate malesuada id vitae lectus. Nunc tincidunt bibendum vulputate. Vivamus eros ante, facilisis eget ultricies quis, fringilla ut odio. Ut ut lacus nec velit ultrices lacinia ac rutrum eros. Praesent sit amet erat at dolor porta facilisis. Donec posuere porta diam eget venenatis. Cras eleifend tristique urna, a scelerisque nisi cursus id.</p>\n'),
(370, 59, 3, 2, '<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec risus mauris. Suspendisse consectetur tristique odio. Donec vitae ante a enim varius commodo. Cras non tortor eros, ac sollicitudin lectus. Curabitur nec leo ac sapien porttitor eleifend ac non nibh. Vestibulum egestas condimentum lectus et malesuada. Cras imperdiet malesuada tincidunt. Phasellus condimentum justo eu ipsum viverra suscipit pretium diam auctor. Curabitur consectetur odio vehicula ipsum posuere tempor nec at est. Vivamus arcu urna, semper ut condimentum et, commodo at mauris. Fusce nec libero turpis. Quisque dictum sagittis tincidunt. Maecenas sem dolor, sollicitudin ultricies pulvinar vel, ullamcorper id nisl. Donec suscipit elit eu justo commodo pretium. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>\n<p>\n	Donec pellentesque, sem ac aliquam convallis, lectus purus auctor odio, id rutrum felis neque sit amet metus. Nulla facilisi. Etiam at dapibus ligula. Morbi feugiat, massa in tempus tincidunt, diam mi egestas nibh, non sagittis lectus sem vel enim. Praesent luctus dolor et quam facilisis tristique. Pellentesque convallis elit quis leo malesuada condimentum. Integer mollis dui sit amet lorem mattis aliquet. Aenean tincidunt mattis aliquam. Praesent sed libero turpis. Nulla laoreet, erat ut pharetra pellentesque, lorem urna bibendum libero, non commodo purus nulla et massa. Fusce sagittis sapien in ipsum mattis rhoncus. Nunc ullamcorper porttitor quam, sit amet pulvinar magna fermentum et. Donec dictum aliquam nulla id iaculis. Fusce orci diam, rhoncus id volutpat ut, dignissim varius magna. Phasellus ullamcorper, purus sit amet malesuada mollis, magna libero laoreet nulla, sed convallis sem urna in augue. Vestibulum et tellus nunc, eu cursus sem. Sed iaculis sapien eget mauris posuere a pharetra turpis suscipit.</p>\n<p>\n	Integer vitae velit eget risus viverra hendrerit nec ut ipsum. Donec sagittis sem vitae felis imperdiet non consequat orci tempor. Suspendisse vulputate, velit quis posuere ullamcorper, mauris urna accumsan nulla, eget mattis tortor elit ac magna. Ut ullamcorper purus eget nibh rhoncus sit amet cursus ante sagittis. Aliquam felis enim, aliquet et aliquam nec, dictum nec magna. Morbi in dui vel diam vulputate malesuada id vitae lectus. Nunc tincidunt bibendum vulputate. Vivamus eros ante, facilisis eget ultricies quis, fringilla ut odio. Ut ut lacus nec velit ultrices lacinia ac rutrum eros. Praesent sit amet erat at dolor porta facilisis. Donec posuere porta diam eget venenatis. Cras eleifend tristique urna, a scelerisque nisi cursus id.</p>\n'),
(371, 51, 12, 1, 'Piet'),
(372, 60, 1, 1, 'Dit is een voorbeeldpagina'),
(373, 60, 1, 2, 'This is an example page'),
(374, 60, 8, 1, ''),
(375, 60, 8, 2, ''),
(376, 60, 7, 1, '1'),
(377, 60, 2, 1, 'Voorbeeld pagina'),
(378, 60, 2, 2, 'Example page'),
(379, 60, 3, 1, '<p>\n	Voorbeeld inhoud</p>\n'),
(380, 60, 3, 2, '<p>\n	Example content</p>\n'),
(381, 60, 6, 1, ''),
(382, 61, 1, 1, 'Dit is een voorbeeldpagina'),
(383, 61, 1, 2, 'This is an example page'),
(384, 61, 8, 1, ''),
(385, 61, 8, 2, ''),
(386, 61, 7, 1, '1'),
(387, 61, 2, 1, 'Voorbeeld pagina'),
(388, 61, 2, 2, 'Example page'),
(389, 61, 3, 1, '<p>\n	Voorbeeld inhoud</p>\n'),
(390, 61, 3, 2, '<p>\n	Example content</p>\n'),
(391, 61, 6, 1, ''),
(392, 62, 1, 1, 'Subpage'),
(393, 62, 1, 2, ''),
(394, 62, 8, 1, ''),
(395, 62, 8, 2, ''),
(396, 62, 7, 1, '0'),
(397, 62, 2, 1, ''),
(398, 62, 2, 2, ''),
(399, 62, 3, 1, ''),
(400, 62, 3, 2, ''),
(401, 62, 6, 1, ''),
(402, 51, 15, 1, '1'),
(403, 50, 15, 1, '1'),
(404, 52, 12, 1, ''),
(405, 52, 15, 1, '1'),
(406, 56, 15, 1, '1'),
(407, 60, 15, 1, '1'),
(408, 61, 15, 1, '1'),
(409, 62, 15, 1, '1');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_webusers`
--

CREATE TABLE IF NOT EXISTS `three_webusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `address` tinytext,
  `postalcode` tinytext,
  `city` tinytext,
  `country` tinytext,
  `telephone` tinytext,
  `mobile` tinytext,
  `email` tinytext,
  `username` tinytext,
  `password` tinytext,
  `blocked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_webusers`
--

INSERT INTO `three_webusers` (`id`, `name`, `address`, `postalcode`, `city`, `country`, `telephone`, `mobile`, `email`, `username`, `password`, `blocked`) VALUES
(1, 'Testuser', '', '', '', '', '', '', '', 'test', '81dc9bdb52d04dc20036dbd8313ed055', 0),
(2, '', '', '', '', '', '', '', '', 'test2', '81dc9bdb52d04dc20036dbd8313ed055', 0),
(3, 'name', 'address', 'postalcode', 'city', 'country', 'telephone', 'mobile', 'example@example.com', 'username', '81dc9bdb52d04dc20036dbd8313ed055', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_webusers_content_group`
--

CREATE TABLE IF NOT EXISTS `three_webusers_content_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) DEFAULT NULL,
  `id_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_webusers_content_group`
--

INSERT INTO `three_webusers_content_group` (`id`, `id_content`, `id_group`) VALUES
(5, 59, 2),
(4, 57, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_webusers_groups`
--

CREATE TABLE IF NOT EXISTS `three_webusers_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_webusers_groups`
--

INSERT INTO `three_webusers_groups` (`id`, `name`) VALUES
(1, 'Group A'),
(2, 'Group B');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `three_webusers_user_group`
--

CREATE TABLE IF NOT EXISTS `three_webusers_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `three_webusers_user_group`
--

INSERT INTO `three_webusers_user_group` (`id`, `id_user`, `id_group`) VALUES
(3, 1, 1),
(2, 2, 2),
(4, 1, 2),
(5, 3, 1),
(6, 3, 2);
