<?php
// Addonmodel handles all the addons

/*

	Hooks:							Context-items:
		AppendMainNavigation			parent
		AppendSubNavigation
		ShowModuleScreen				alias,parameters[]
		ContentAboveOptions				lang,contentData,templates,title,allowedTemplates,settings
		ContentBelowOptions				lang,contentData,templates,title,allowedTemplates,settings
		PreSaveContent					idContent,contentData[]
		PostSaveContent					idContent,contentData[]
		
 
*/

class AddonModel extends Model
{
	var $addons;	
	var $hooks;
	
	function AddonModel()
	{
		parent::Model();
		
		$this->addons = array();
		$this->hooks  = array();
		
		// Lookup addons:
		$folders = glob('assets/addons/*', GLOB_ONLYDIR);
		foreach($folders as $folder) {
			$path = $folder.'/addon.php';
			if(file_exists($path)) {
				$a = explode('/', $folder);
				$folderName = $a[count($a)-1];
				require_once($path);
				$objectName = ucfirst($folderName);
				$object     = new $objectName;
				$object->init();
				$hooks      = $object->getHooks();
				array_push($this->addons, array($folderName, $object, $hooks));
				// Setup the hooks:
				foreach($hooks as $hook) {
					// Set a referece to the object:
					if(!isset($this->hooks[$hook['hook']])) {
						$this->hooks[$hook['hook']] = array(array(&$object, $hook['callback']));
					} else {						
						array_push($this->hooks[$hook['hook']], array(&$object, $hook['callback']));
					}
				}
			}
		}
	}
	
	/**
	 * A Hook gets executed.
	 * @param	$name		string	The name of the hook
	 * @param	$context	array	An array with information to provide with the callback
	 * @return	boolean				true of one ore more hooks are found, false if not
	 */
	function executeHook($name, $context)
	{
		$ok = false;
		// Check if this hook is set:
		if(isset($this->hooks[$name])) {
			// Execute all callbacks for this hook:
			foreach($this->hooks[$name] as $callback) {				
				$callback[0]->$callback[1]($context);
			}
			$ok = true;
		}
		return $ok;
	}
	
}
?>