<?php
	if(!isset($_POST['license'])) {
		die('<p class="error">You must agree to the license to install Three CMS.</p>');
	}
	
	function makeSafe($str)
	{
		return htmlentities(strip_tags($str), ENT_QUOTES, 'UTF-8');		
	}
	
	function parseSqlFile($fileName)
	{
		global $dbPrefix;
		global $adminUser;
		global $adminPass;
		global $adminEmail;
		global $base_url;
		
		$content = file_get_contents($fileName);
		
		$content = str_replace(
			array('[[PREFIX]]', '[[ADMINUSER]]', '[[ADMINPASS]]', '[[ADMINEMAIL]]', '[[SITEADDRESS]]'),
			array($dbPrefix, $adminUser, md5($adminPass), $adminEmail, $base_url),
			$content
		);
		
		$lines   = explode("\n", $content);
		foreach($lines as $line) {
			$line = str_replace(array("\n", "\r"), '', $line);
			if(!empty($line) && substr($line, 0, 2)!='--') {
				mysql_query($line) or die('<p class="error">MySQL Error: '.mysql_error().'</p>');
			}
		}
	}
	
	function parseFile($file, $newFile, $parameters)
	{
		$content = file_get_contents($fileName);
		foreach($parameters as $key=>$value) {
			$content = str_replace('[['.strtoupper($key).']]', $value, $content);
		}
		$handle = fopen($newFile, 'w');
		fwrite($handle, $content);
		fclose($handle);
	}
	
	$dbName     = makeSafe($_POST['dbname']);
	$dbHost     = makeSafe($_POST['dbhost']);
	$dbUser     = makeSafe($_POST['dbuser']);
	$dbPass     = makeSafe($_POST['dbpass']);
	$dbPrefix   = makeSafe($_POST['dbprefix']);
	$adminUser  = makeSafe($_POST['adminuser']);
	$adminPass  = makeSafe($_POST['adminpass']);
	$adminEmail = makeSafe($_POST['adminemail']);
	$setup      = makeSafe($_POST['setup']);
	
	$base_url   = str_replace('/install', '', $_SERVER['HTTP_REFERER']);
	
	$link = mysql_connect($dbHost, $dbUser, $dbPass);
	mysql_select_db($dbName, $link);
	
	// Create setup file:
	switch($setup) {
		case 1:			
			parseSqlFile('sql/empty.sql');
			echo '<p class="ok">Three CMS installed with empty database.</p>';
			break;
		case 2:
			parseSqlFile('sql/empty.sql');
			// TODO: Insert default website template:
			echo '<p class="ok">Three CMS installed with default website template.</p>';
			break;
		case 3:
			parseSqlFile('sql/empty.sql');
			// TODO: Insert example news site:
			// TODO: Copy files:
			echo '<p class="ok">Three CMS installed with example multilingual newssite.</p>';
			break;
		case 4:
			parseSqlFile('sql/empty.sql');
			// TODO: Insert example blog:
			// TODO: Copy files:
			echo '<p class="ok">Three CMS installed with example blog.</p>';
			break;
	}
	
	// Write the configuration file:
	$parameters = array(
		'base_url'=>$base_url,
		'dbname'=>$dbName,
		'dbuser'=>$dbUser,
		'dbpass'=>$dbPass,
		'dbhost'=>$dbHost,
		'dbprefix'=>$dbPrefix
	);
	
	// TODO: Make sure to write this file on the correct location:
	parseFile('files/config.php', 'config.php', $parameters);
	parseFile('files/database.php', 'database.php', $parameters);
	
?>