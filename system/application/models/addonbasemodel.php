<?php
class AddonBaseModel extends Model
{
	var $frontEnd = false;	// $frontEnd determines if this addon is available on the frontend
	
	function AddonBaseModel()
	{
		parent::Model();
	}
	
	/**
	 * Create a hyperlink-url to use in a module
	 * @param	$array	array	An array with parameters (where the first parameter is most commonly the name of the module)
	 * @return	string			An URL
	 */
	function createLink($array = array())
	{
		array_unshift($array, 'module');
		array_unshift($array, 'admin');
		return site_url($array);
	}
}
?>