<?php
	// Delete the installation folder:
	if(isset($_POST['delete'])) {
		// TODO
	}
	
	$siteAddress = str_replace('/install', '', $_SERVER['HTTP_REFERER']);
	header('Location: '.$siteAddress);
?>