<?php
	$dbName = $_POST['dbname'];
	$dbHost = $_POST['dbhost'];
	$dbUser = $_POST['dbuser'];
	$dbPass = $_POST['dbpass'];
	
	@$link = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$link) {
		// Could not connect to the database:
		die('<var>0</var><p class="error">Could not connect: '.mysql_error().'</p>');
	} else {
		// Check if the database exists:
		$ok = mysql_select_db($dbName, $link);
		if(!$ok) {
			// Try to create the database:
			$sql = 'CREATE DATABASE `'.$dbName.'`;';
			mysql_query($sql) or die('<var>0</var><p class="error">Could not create database: '.mysql_error().'</p>');
			
			echo '<var>1</var><p class="ok">Settings are correct, new database created.</p>';			
		} else {
			echo '<var>1</var><p class="ok">Settings are correct, database selected.</p>';
		}
	}
?>