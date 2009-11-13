<?php

class Page extends Controller
{
	private $idLanguage;
	private $settings;
	
	function Page()
	{
		parent::Controller();
		
		// Load page constants:
		include_once(BASEPATH.'application/config/page_config.php');
		
		// Load Smarty Template Engine:
		include_once(SMARTY_DIR.'Smarty.class.php');
		
		// Load the page model:
		$this->load->model('PageModel', '', true);
		// Load DataModel Class:
		$this->load->model('DataModel', '', true);
		
		// Load the settings:
		$this->settings   = $this->PageModel->getSettings();
		$this->idLanguage = $this->settings['default_language'];
	}
	
	function index()
	{
		// Set the page to load to default:
		$idPage = $this->settings['default_page_id'];
		// Read the parameters:
		$parameters = $this->uri->segment_array();
		if($this->uri->total_segments() > 0) {
			// Check if this is a multilanguage site. If so, parameter 1 is the language code
			if($this->PageModel->countLanguages() > 1) {
				// Multilanguage, get the language ID according to the language code
				$idLanguage = $this->PageModel->getLanguageId($parameters[1]);
				if($idLanguage!==false) {
					$this->idLanguage = $idLanguage;
					// Shift the remaining parameters (since parameter[1] is the language code):
					array_shift($parameters);
				} else {
					$this->idLanguage = $this->settings['default_language'];
					// Don't shift the remaining parameters, because the first item could be a page item
				}
			}
			// TODO: Get the correct ID of the content to load according to the parameters:
			if(count($parameters) > 0) {
				
			}
		} 
		
		if($this->PageModel->pageExists($idPage)) {		
			// Create the data object:
			$dataObject = $this->PageModel->getDataObject($idPage, $this->idLanguage);
			// Render it:
			$dataObject->render();
		} else {
			echo 'Error: Default page does not exist! (id: '.$idPage.')';
		}
	}
	
}

?>