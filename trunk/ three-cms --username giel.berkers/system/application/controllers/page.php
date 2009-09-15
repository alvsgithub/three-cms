<?php

class Page extends Controller
{
	private $smarty;
	private $idLanguage;
	
	function Page()
	{
		parent::Controller();
		
		// Load page constants:
		include_once(BASEPATH.'application/config/page_config.php');
		
		// Load Smarty Template Engine:
		include_once(SMARTY_DIR.'Smarty.class.php');
		$this->smarty = new Smarty();
		
		// Set the correct directories:
		$this->smarty->template_dir 	= 'site/templates';					// Location of the Smarty-templates
		$this->smarty->compile_dir  	= 'system/smarty/templates_c';		// Location where to put the compiled templates
		$this->smarty->cache_dir		= 'system/smarty/cache';			// Location of the cached files
		$this->smarty->config_dir   	= 'site/configs';					// Location of the site config files
		$this->smarty->debug_tpl		= '../../system/smarty/debug.tpl';	// Location of the debug template (for some reason this must be reset)
		
		// Default settings:
		$this->smarty->compile_check 	= SMARTY_COMPILE;
		$this->smarty->debugging 		= SMARTY_DEBUG;
		$this->smarty->caching			= SMARTY_CACHE;
		$this->smarty->cache_lifetime	= SMARTY_CACHE_LIFETIME;
		$this->idLanguage 				= DEFAULT_LANGUAGE_ID;
		
		// Load the page model:
		$this->load->model('PageModel', '', true);
		
		// Set the languageID:
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
		
		// TODO: Get the correct ID of the page to load according to the parameters:
		
		// Create the data object:
		$dataObject = $this->PageModel->getDataObject(1, $this->idLanguage);
		
		// Set each entry in the dataObject as a Smarty parameter:
		foreach($dataObject as $key=>$value) {
			$this->smarty->assign($key, $value);
		}
		
		// Display the page:
		// TODO: Load the correct template according to the database:
		$this->smarty->display('index.tpl');
		
		// Assign the variables:
		/*
		$this->smarty->assign("Name","Fred Irving Johnathan Bradley Peppergill");
		$this->smarty->assign("FirstName",array("John","Mary","James","Henry"));
		$this->smarty->assign("LastName",array("Doe","Smith","Johnson","Case"));
		$this->smarty->assign("Class",array(array("A","B","C","D"), array("E", "F", "G", "H"),
			array("I", "J", "K", "L"), array("M", "N", "O", "P")));		
		$this->smarty->assign("contacts", array(array("phone" => "1", "fax" => "2", "cell" => "3"),
			array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")));
		$this->smarty->assign("option_values", array("NY","NE","KS","IA","OK","TX"));
		$this->smarty->assign("option_output", array("New York","Nebraska","Kansas","Iowa","Oklahoma","Texas"));
		$this->smarty->assign("option_selected", "NE");
		*/
		
		// Display the page:
		/*
		$this->smarty->display('index.tpl');
		*/
	}
	
}

?>