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
<form method="post" action="<?php echo moduleCreateLink(array('export', 'go')); ?>">
	<label for="site_url">The URL of the destination site (with a trailing slash):</label>
	<input type="text" name="site_url" id="site_url" value="http://" />
	<input type="submit" value="Export the site" />
</form>

<?php
	}
?>