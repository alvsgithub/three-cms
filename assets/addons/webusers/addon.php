<?php
class Webusers
{
	/**
	 * This function tells Three CMS on which hook a function needs to be called
	 */
	function getHooks()
	{
		$hooks = array(
			array(
				'hook'=>'AppendSubNavigation',
				'callback'=>'addMenuOption'
			)
		);
		return $hooks;
	}
	
	function addMenuOption($context)
	{
		if($context['parent']=='users') {
			echo '<li><a href="#">Webusers</a></li>';
		}
	}
}
?>