<?php
	// TODO: Delete the installation folder:
	if(isset($_POST['delete'])) {
		
	}
	
	$siteAddress = str_replace('/install', '', $_SERVER['HTTP_REFERER']);
	header('Location: '.$siteAddress);
?>