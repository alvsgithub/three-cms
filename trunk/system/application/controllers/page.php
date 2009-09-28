<?php

class Page extends Controller
{
	// private $smarty;
	private $idLanguage;
	
	function Page()
	{
		parent::Controller();
		
		// Load page constants:
		include_once(BASEPATH.'application/config/page_config.php');
		
		// Load Smarty Template Engine:
		include_once(SMARTY_DIR.'Smarty.class.php');
		
		$this->idLanguage 				= DEFAULT_LANGUAGE_ID;
		// Load the page model:
		$this->load->model('PageModel', '', true);
		// Load DataModel Class:
		$this->load->model('DataModel', '', true);
	}
	
	function index()
	{
		// Read the parameters:
		$parameters = $this->uri->segment_array();			
		if($this->uri->total_segments() > 0) {
			// Check if this is a multilanguage site. If so, parameter 1 is the language code
			if($this->PageModel->countLanguages() > 1) {
				// Multilanguage, get the language ID according to the language code
				$this->idLanguage = $this->PageModel->getLanguageId($parameters[1]);
				// Shift the remaining parameters (since parameter[1] is the language code:
				array_shift($parameters);
			}			
		} 
		
		// TODO: Get the correct ID of the content to load according to the parameters:
		
		
		// Create the data object:
		$dataObject = $this->PageModel->getDataObject(1, $this->idLanguage);
		$dataObject->render();
		
		// Set each entry in the dataObject as a Smarty parameter:
		/*
		foreach($dataObject as $key=>$value) {
			$this->smarty->assign($key, $value);
		}
		
		// Display the page:
		// TODO: Load the correct template according to the database:
		$this->smarty->display('index.tpl');
		*/
	}
	
}

?>