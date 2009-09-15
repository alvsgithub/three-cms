<?php

class Page extends Controller
{
	private $smarty;
	
	function Page()
	{
		parent::Controller();
		
		// Load Smarty constants:
		
		
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
		
		// Load the page model:
		$this->load->model('PageModel', '', true);
	}
	
	function index()
	{
		// Read the parameters:
		if($this->uri->total_segments() == 0) {
			// TODO: Load the default page.
			echo 'Load default page';
		} else {
			// TODO: Check if this is a multilanguage site. If so, parameter 1 is the language code
			$parameter = $this->uri->total_segments(1);
			if($this->PageModel->countLanguages()==1) {
				// Single language, get the default language
				// TODO: get the default language code
				// TODO: set the current parameters as all the parameters to load the correct page
				
			} else {
				// Multilanguage
				// TODO: get the language ID according to the language code
				// TODO: set the remaining parameters as parameters to load the correct page
				
			}
		}
		
		
		// TODO: Load a page from the database and assign the variables.
		
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