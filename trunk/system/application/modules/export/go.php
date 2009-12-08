<?php
	// This file is going to export the entire site.
	
	// Step 1: Create an 'export'-folder on the root of the site:
	// See if the folder exists, if so, empty it:
	if(!file_exists('export')) {
		if(!mkdir('export')) {
			'<p class="error">Cannot create the export-folder. Please create it manually!</p>';
			return;		// Prevent further execution.
		}		
	}
	
	// Step 2: Walk through the site and parse it on the go:
	$startID = $settings['default_page_id'];
	
?>