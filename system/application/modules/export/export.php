<?php
	// Show the name of this module:
	echo '<h1>'.$info['name'].' <em>'.$info['version'].'</em></h1>';
	
	// See if there are parameters set:
	if(count($parameters) > 0) {
		switch($parameters[0]) {
			case 'go' :
				// Export the site:
				include_once('go.php');
				break;
		}
	} else {
		// Show the default startpage of this module:
?>
<p>This module will export your site to a static HTML version.</p>
<p>The site will be stored in a folder called <em>'export'</em> on your server.</p>
<p><a href="<?php echo moduleCreateLink(array('export', 'go')); ?>" class="button">Export the site</a></p>
<?php
	}
?>