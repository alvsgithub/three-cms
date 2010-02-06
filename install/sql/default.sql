-- Content:
INSERT INTO `[[PREFIX]]content` (`id`, `id_content`, `id_template`, `name`, `alias`, `order`) VALUES (1, 0, 1, 'Home', 'home', 1);

-- Data Objects:
INSERT INTO `[[PREFIX]]dataobjects` (`id`, `name`) VALUES (1, 'Default Page');

-- Data Objects Options:
INSERT INTO `[[PREFIX]]dataobjects_options` (`id`, `id_dataobject`, `id_option`, `order`) VALUES (1, 1, 4, 0), (2, 1, 1, 1), (3, 1, 2, 2), (4, 1, 3, 3);

-- Options:
INSERT INTO `[[PREFIX]]options` (`id`, `name`, `type`, `default_value`, `multilanguage`) VALUES (1, 'header', 'small_text', '', 0), (2, 'description', 'large_text', '', 0), (3, 'content', 'rich_text', '', 0), (4, 'show in menu', 'boolean', '', 0);

-- Templates:
INSERT INTO `[[PREFIX]]templates` (`id`, `name`, `id_dataobject`, `templatefile`, `root`, `type`) VALUES (1, 'Default Page', 1, 'index.tpl', 1, 'page');

-- Templates Allowed Children:
INSERT INTO `[[PREFIX]]templates_allowed_children` (`id`, `id_template`, `id_child_template`) VALUES (1, 1, 1);

-- Templates Ranks:
INSERT INTO `[[PREFIX]]templates_ranks` (`id`, `id_template`, `id_rank`, `visible`, `add`, `modify`, `duplicate`, `move`, `delete`) VALUES (1, 1, 1, 1, 1, 1, 1, 1, 1);

-- Values:
INSERT INTO `[[PREFIX]]values` (`id`, `id_content`, `id_option`, `id_language`, `value`) VALUES (1, 1, 4, 1, '1'), (2, 1, 1, 1, 'My new website'), (3, 1, 2, 1, 'This is a simple page for this new website.'), (4, 1, 3, 1, '<p>\n	The templatefile of this page is located in site/templates. If you <a href="http://index.php/admin">login</a> in the CMS, you can start creating your new site.</p>\n');
