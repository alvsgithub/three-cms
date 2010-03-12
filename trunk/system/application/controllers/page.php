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
		
		// Assign Addons:
		// Load the addonBaseModel:
		$this->load->model('AddonBaseModel', '', true);
		
		// Load the addonModel:
		$this->load->model('AddonModel', '', true);
		
		// Load DataModel Class:
		$this->load->model('DataModel', '', true);
		
		// Load the settings:
		$this->settings   = $this->PageModel->getSettings();
		$this->idLanguage = $this->settings['default_language'];
		
		// Execute hook that the page is loaded:
		// This must be a reference since the executeHook()-function only returns true or false
		$this->AddonModel->executeHook('LoadPage', array('page'=>&$this));		
	}
	
	function index()
	{
		// Set the page to load to default:
		$idPage         = $this->settings['default_page_id'];
		$idLanguage     = $this->idLanguage;
		$contentObjects = array();
		$contentParams  = array();
		// Read the parameters:
		$parameters = $this->uri->segment_array();
		// Reset numeral array keys, so they start counting at zero:
		array_unshift($parameters, array_shift($parameters));
		if($this->uri->total_segments() > 0) {
			// Check if this is a multilanguage site. If so, parameter 1 is the language code
			if($this->PageModel->countLanguages() > 1) {
				// Multilanguage, get the language ID according to the language code
				$idLanguage = $this->PageModel->getLanguageId($parameters[0]);
				if($idLanguage!==false) {
					$this->idLanguage = $idLanguage;
					// Shift the remaining parameters (since parameter[1] is the language code):
					array_shift($parameters);	
				} else {
					$this->idLanguage = $this->settings['default_language'];
					// Don't shift the remaining parameters, because the first item could be a page item
				}
			}
			// Get the correct ID of the content to load according to the parameters:
			if(count($parameters) > 0) {
				// The URL is generated from one or more aliases.
				// If there is only one parameter, get the ID of the page:				
				if(count($parameters)==1) {					
					$id = $this->PageModel->getPageId($parameters[0]);					
					if($id!==false) {
						$idPage = $id;
					}
				} else {
					// If there are more parameters, get the ID of the last page:
					// AJAX functionality:
					// website.com/alias/new-building    : Load only the content with the alias new-building.
					if($parameters[0]=='alias') {
						// AJAX Functionality : Load the chunk:
						$id = !is_numeric($parameters[1]) ? $this->PageModel->getPageId($parameters[1]) : intval($parameters[1]);
						if($id!==false) {
							$idPage = $id;
						}
					} else {
						// Loop from the right to the left through the parameters, halting when there is a type of 'page' detected.
						for($i=count($parameters); $i>0; $i--) {
							$id   = $this->PageModel->getPageId($parameters[$i-1]);
							$type = $this->PageModel->getPageType($id);
							switch($type) {
								case 'content' :
									{
										// Content, add a new content-object to parse in the page:
										array_push($contentObjects, $this->PageModel->getDataObject($id, $this->idLanguage));
										break;
									}
								case 'page' :
									{
										// Page, also break the loop here:
										$idPage = $id;
										break 2;
									}
								default:
									{
										// Parameter:
										array_push($contentParams, $parameters[$i-1]);
										break;
									}
							}
						}
					}
				}
			}
		} 
		
		if($this->PageModel->pageExists($idPage)) {		
			// Create the data object:
			$dataObject = $this->PageModel->getDataObject($idPage, $this->idLanguage);
			$dataObject->parameters     = $contentParams;
			$dataObject->contentObjects = $contentObjects;
			// Render it:
			$this->AddonModel->executeHook('PreRenderPage', array('idPage'=>$idPage, 'idLanguage'=>$idLanguage, 'dataObject'=>$dataObject, 'parameters'=>$contentParams, 'dateObjects'=>$contentObjects));
			$dataObject->render();
			$this->AddonModel->executeHook('PostRenderPage', array('idPage'=>$idPage, 'idLanguage'=>$idLanguage, 'dataObject'=>$dataObject, 'parameters'=>$contentParams, 'dateObjects'=>$contentObjects));
		} else {
			echo 'Error: Page does not exist! (id: '.$idPage.')';
		}
	}
	
}

?>