<?php
	if(isset($_POST['delete'])) {
		// Delete the installation folder:
		delTree('../install');
	}
	
	// DelTree function:
	function delTree($dir) {
	    $files = glob( $dir . '/*');
	    foreach( $files as $file ) {
			if(is_dir($file)) {				
	            delTree($file);
			} else {
	            unlink($file);
	        }
	    }
	    if(is_dir($dir)) {
			rmdir($dir);
		}
	}

	$siteAddress = str_replace('/install', '', $_SERVER['HTTP_REFERER']);
	header('Location: '.$siteAddress);
?>