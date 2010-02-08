<?php
// Settings model is a singleton with all the settings

class SettingsModel extends Model
{
	static $instance;
	
	private function SettingsModel()
	{
		parent::Model();
	}
	
	function getInstance()
	{
		if(!is_object($instance)) {
			$instance = new SettingsModel();
		}
	}
}
?>