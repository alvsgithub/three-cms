-- Content Table:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]content` (`id` int(11) NOT NULL AUTO_INCREMENT, `id_content` int(11) NOT NULL, `id_template` int(11) NOT NULL, `name` tinytext NOT NULL, `alias` tinytext NOT NULL, `order` int(11) NOT NULL, PRIMARY KEY (`id`));

-- Data objects:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]dataobjects` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` tinytext NOT NULL, PRIMARY KEY (`id`));

-- Data object options:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]dataobjects_options` (`id` int(11) NOT NULL AUTO_INCREMENT, `id_dataobject` int(11) NOT NULL, `id_option` int(11) NOT NULL, `order` int(11) NOT NULL, PRIMARY KEY (`id`));

-- Languages (+default language):
CREATE TABLE IF NOT EXISTS `[[PREFIX]]languages` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` tinytext NOT NULL, `code` varchar(2) NOT NULL, `active` tinyint(1) NOT NULL, PRIMARY KEY (`id`));
INSERT INTO `[[PREFIX]]languages` (`id`, `name`, `code`, `active`) VALUES (1, 'English', 'en', 1);

-- Locales:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]locales` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` tinytext NOT NULL, PRIMARY KEY (`id`));

-- Locales values:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]locales_values` (`id` int(11) NOT NULL AUTO_INCREMENT, `id_locale` int(11) NOT NULL, `id_language` int(11) NOT NULL, `value` text NOT NULL, PRIMARY KEY (`id`));

-- Options:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]options` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` tinytext NOT NULL, `description` tinytext NOT NULL, `tooltip` tinytext NOT NULL, `type` enum('small_text','large_text','rich_text','url','image','file','boolean','dropdown','selectbox','date','time') NOT NULL, `options` text NOT NULL, `default_value` text NOT NULL, `multilanguage` tinyint(1) NOT NULL, `required` tinyint(1) NOT NULL, PRIMARY KEY (`id`));

-- Ranks (+ default administrator rank):
CREATE TABLE IF NOT EXISTS `[[PREFIX]]ranks` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` tinytext NOT NULL, `system` tinyint(1) NOT NULL, `users` tinyint(1) NOT NULL, `ranks` tinyint(1) NOT NULL, `configuration` tinyint(1) NOT NULL, PRIMARY KEY (`id`));
INSERT INTO `[[PREFIX]]ranks` (`id`, `name`, `system`, `users`, `ranks`, `configuration`) VALUES (1, 'Administrator', 1, 1, 1, 1);

-- Ranks modules
CREATE TABLE IF NOT EXISTS `[[PREFIX]]ranks_modules` (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `id_rank` INT NOT NULL, `module` TINYTEXT NOT NULL);

-- Settings (+default settings):
CREATE TABLE IF NOT EXISTS `[[PREFIX]]settings` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` tinytext NOT NULL, `value` text NOT NULL, PRIMARY KEY (`id`));
INSERT INTO `[[PREFIX]]settings` (`id`, `name`, `value`) VALUES (1, 'default_language', '1'), (2, 'default_page_id', '1'), (3, 'site_name', 'Empty site'), (4, 'base_url', '[[SITEADDRESS]]'), (5, 'date_format', '%m/%d/%Y');

-- Templates:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]templates` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` tinytext NOT NULL, `id_dataobject` int(11) NOT NULL, `templatefile` tinytext NOT NULL, `root` tinyint(1) NOT NULL, `type` enum('page','content') NOT NULL, PRIMARY KEY (`id`));

-- Templates allowed children:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]templates_allowed_children` (`id` int(11) NOT NULL AUTO_INCREMENT, `id_template` int(11) NOT NULL, `id_child_template` int(11) NOT NULL, PRIMARY KEY (`id`));

-- Templates ranks:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]templates_ranks` (`id` int(11) NOT NULL AUTO_INCREMENT, `id_template` int(11) NOT NULL, `id_rank` int(11) NOT NULL, PRIMARY KEY (`id`));

-- Users (+default admin user)
CREATE TABLE IF NOT EXISTS `[[PREFIX]]users` (`id` int(11) NOT NULL AUTO_INCREMENT, `username` tinytext NOT NULL, `password` tinytext NOT NULL, `name` tinytext NOT NULL, `email` tinytext NOT NULL, `id_rank` int(11) NOT NULL, PRIMARY KEY (`id`));
INSERT INTO `[[PREFIX]]users` (`id`, `username`, `password`, `name`, `email`, `id_rank`) VALUES (1, '[[ADMINUSER]]', '[[ADMINPASS]]', 'Administrator', '[[ADMINEMAIL]]', 1);

-- Values:
CREATE TABLE IF NOT EXISTS `[[PREFIX]]values` (`id` int(11) NOT NULL AUTO_INCREMENT, `id_content` int(11) NOT NULL, `id_option` int(11) NOT NULL, `id_language` int(11) NOT NULL, `value` text NOT NULL, PRIMARY KEY (`id`));
