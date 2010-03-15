<?php
class AddonBaseModel extends Model
{
	var $frontEnd   = false;	// $frontEnd determines if this addon is available on the frontend
	var $dataObject = null;		// $dateObject is a reference to the current data object (for frontend use)
	//var $settings   = array();	// An array with the site settings
	
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
		$this->initializeAdminModel();
		return new AdminModel();
	}
	
	/**
	 * Get the Page Model
	 * @return	PageModel	The Page Model
	 */
	function getPageModel()
	{
		$this->initializePageModel();
		return new PageModel();
	}
	
	/**
	 * Get the Data Model
	 * @return	DataModel	The Data Model
	 */
	function getDataModel()
	{
		$this->initializeDataModel();
		return new DataModel();
	}
	
	/**
	 * Get the global site settings
	 * @return	Array		The settings of the site
	 */
	function getSettings()
	{
		// TODO: Make settings-singleton
        // Caching:
		$cacheFile = 'system/cache/data.settings.php';
		if(file_exists($cacheFile)) {
			include($cacheFile);
		} else {
			$cacheStr = '<?php'."\n\t".'$settings = array('."\n";		// For caching
			$first    = true;
			$settings = array();
			$this->db->select('name,value');
			$query = $this->db->get('settings');
			foreach($query->result() as $setting) {
				$settings[$setting->name] = $setting->value;
				if(!$first) {
					$cacheStr.=','."\n";
				}
				$first = false;
				$cacheStr.= "\t\t".'\''.$setting->name.'\'=>\''.addslashes($setting->value).'\'';
			}
			// Save cache file:			
			$cacheStr.= "\n"."\t".');'."\n".'?>';
			$handle = fopen($cacheFile, 'w');
			fwrite($handle, $cacheStr);
			fclose($handle);
		}
        return $settings;
	}
}
?>