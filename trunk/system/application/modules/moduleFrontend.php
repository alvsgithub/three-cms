<?php
	// The base class for the front-end part of some modules who require this.

	class ModuleFrontend
	{
		var $db;
		var $session;
		
		function ModuleFrontend($db, $session)
		{
			$this->db      = $db;
			$this->session = $session;
		}
	}
?>