<?php
	/**
	 * Create a hyperlink-url to use in a module
	 * @param	$array	array	An array with parameters (where the first parameter is most commonly the name of the module)
	 * @return	string			An URL
	 */
	function moduleCreateLink($array)
	{
		array_unshift($array, 'module');
		array_unshift($array, 'admin');
		return site_url($array);
	}
	
	/**
	 * Make the Smarty class available
	 */
	function initalizeSmarty()
	{
		require_once(SMARTY_DIR.'Smarty.class.php');
	}
	
	/**
	 * Make the Page Model available
	 */
	function initializePageModel()
	{
		require_once('system/application/models/pagemodel.php');
	}
	
	/**
	 * Make the Admin Model available
	 */
	function initializeAdminModel()
	{
		require_once('system/application/models/adminmodel.php');	
	}
	
	/**
	 * Make the Data Model available
	 */
	function initializeDataModel()
	{
		require_once('system/application/models/datamodel.php');
	}
	
	/**
	 * Get the Admin Model
	 * @return	AdminModel	The Admin Model
	 */
	function getAdminModel()
	{
		initializeAdminModel();
		return new AdminModel();
	}
	
	/**
	 * Get the Page Model
	 * @return	PageModel	The Page Model
	 */
	function getPageModel()
	{
		initializePageModel();
		return new PageModel();
	}
	
	/**
	 * Get the Data Model
	 * @return	DataModel	The Data Model
	 */
	function getDataModel()
	{
		initializeDataModel();
		return new DataModel();
	}
	
?>