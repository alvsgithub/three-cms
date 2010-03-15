<?php
	class Export extends AddonBaseModel
	{
		/**
		 * Initialize
		 */
		function init()
		{
			@session_start();
			$this->frontEnd = false;
		}
		
		/**
		 * This function tells Three CMS on which hook a function needs to be called
		 */
		function getHooks()
		{
			$hooks = array(
				array(
					'hook'=>'AppendSubNavigation',
					'callback'=>'addMenuOption'
				),
				array(
					'hook'=>'ModuleScreen',
					'callback'=>'showModuleScreen'
				)
			);
			return $hooks;
		}
		
		// Add the menu option to the menu:
		function addMenuOption($context)
		{
			if(in_array('export', $context['allowedAddons'])) {
				if($context['parent']=='configuration') {
					echo '<li><a href="'.$this->createLink(array('export')).'">Export static site</a></li>';
				}
			}
		}
		
		// Show the Module Screen:
		function showModuleScreen($context)
		{
			if($context['alias']=='export') {
				// See if there are parameters set:
				if(count($context['parameters']) > 0) {
					switch($context['parameters'][0]) {
						case 'go' :
							// Export the site:
							include_once('go.php');
							break;
					}
				} else {
					echo '
						<h1>Export Static Site</h1>
						<p>This module will export your site to a static HTML version.</p>
						<p>The site will be stored in a folder called <em>\'export\'</em> on your server.</p>
						<form method="post" action="'.$this->createLink(array('export', 'go')).'">
							<label for="site_url">The URL of the destination site (with a trailing slash):</label>
							<input type="text" name="site_url" id="site_url" value="http://" />
							<input type="submit" value="Export the site" />
						</form>
					';
				}
			}
		}
	}
?>