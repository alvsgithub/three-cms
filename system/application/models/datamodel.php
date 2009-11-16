<?php

/**
 *  DataModel
 *  ---------------------------------------------------------------------------
 *  The DataModel is used by the website to load and format data that can be 
 *  used by the website. *  
 *  ---------------------------------------------------------------------------
 *  Author:     Giel Berkers
 *  E-mail:     giel.berkers@gmail.com
 *  Revision:   1
 *  ---------------------------------------------------------------------------
 *  Changelog:
 *
 *
 */


// TODO: Make queries with Active Record Class

class DataModel extends Model
{
	var $options;		// An array holding the options of this data object and it's values
	var $idContent;		// The ID of the content
	var $idLanguage;	// The ID of the language
	var $templateFile;	// The template file
	
	// The following parameters don't get set until a certain first function call
	// This makes the dataModel load faster in case the parameter is not used.
	var $parentsArray  = array();	// A 2-dimensional array holding the parents
	var $childrenArray = array();	// A 2-dimensional array holding the children
	
	function DataModel()
	{
		parent::Model();
		// Load the URL helper:
		$this->load->helper('url');
	}
	
	function load($idContent, $idLanguage)
	{
		// Default settings:
		$this->idContent 	= $idContent;
		$this->idLanguage	= $idLanguage;
		$this->options		= array();
		
		// TODO: Add settings-object to the content
		
		
		// Default settings:
		$this->db->select('name,alias,order');
		$this->db->where('id', $idContent);
		$query = $this->db->get('content');
		$info  = $query->result_array();
		
		// Some default options:
		$this->options['idContent']   = $idContent;
		$this->options['idLanguage']  = $idLanguage;
		// $this->options['url']         = $this->getUrl();
		$this->options['alias']       = $info[0]['alias'];
		$this->options['contentName'] = $info[0]['name'];
		$this->options['order']       = $info[0]['order'];
		
		// Killer Query to do the magic:
		// What it does: It selects the options that belong to the object of this content,
		// and it retrieves the objects correct values according to the given language, or
		// if the object isn't multilanguage, it returns it's defaults language value.
		$pf = $this->db->dbprefix;
		$sql = 'SELECT C.`name`, D.`value` FROM
			`'.$pf.'content` A,
			`'.$pf.'dataobjects_options` B,
			`'.$pf.'options` C,
			`'.$pf.'values` D,
			`'.$pf.'templates` E		
				WHERE
			A.`id`              = '.$idContent.' AND
			A.`id_template`     = E.`id` AND
			E.`id_dataobject`   = B.`id_dataobject` AND
			C.`id`              = B.`id_option` AND
			D.`id_content`      = '.$idContent.' AND
			D.`id_option`       = B.`id_option` AND
			D.`id_language`     = IF(C.`multilanguage` = 1, '.$idLanguage.', '.DEFAULT_LANGUAGE_ID.');
		';
		$query = $this->db->query($sql);
		
		// Fill the dataObject with the values:
		foreach($query->result() as $result) {
			$this->options[$result->name] = $result->value;
		}
		
		// Retrieve the template file:
		$sql = 'SELECT B.`templatefile` FROM
			`'.$pf.'content` A,
			`'.$pf.'templates` B
				WHERE
			A.`id_template` = B.`id` AND
			A.`id` = '.$idContent.';
		';
		$query = $this->db->query($sql);
		$this->templateFile = $query->row()->templatefile;
	}
	
	/**
	 * Get the children of this dataModel
	 * @param	$idContent	int	The ID of the parent to get the children from. If ID is set to null (default), the current dataobjects' ID is used
	 * @return	array		An array with dataModels
	 */
	function children($idContent = null)
	{
		$idContent = $idContent !== null ? $idContent : $this->idContent;
		if(isset($this->childrenArray[$idContent])) {
			$children = $this->childrenArray[$idContent];
		} else {
			// Retrieve the children of this data object:
			$children = array();		
			$this->db->select('id');
			$this->db->where('id_content', $idContent);
			$this->db->order_by('order', 'asc');
			$query = $this->db->get('content');		
			foreach($query->result() as $result) {
				$dataObject = new DataModel();
				$dataObject->load($result->id, $this->idLanguage);
				array_push($children, $dataObject);
			}
			// Store for optimization:
			$this->childrenArray[$idContent] = $children;
		}		
		return $children;
	}
	
	/**
	 * Get a specific child of this dataModel
	 * @param	$num	int	The number of the child to retrieve
	 * @return	DataModel	A single datamodel
	 */
	function child($num)
	{
		// TODO (what is this function supposed to do anyway?)
		
	}
	
	/**
	 * Create a tree of this dataModel and all it's children (recursive)
	 * @param	$startID			int		The ID to see as te root parent. Set to null to use the current dataModel's ID
	 * @param	$templates			array	An array containing the ID's of the templates to allow in this tree. Set to null to allow all templates.
	 * @param	$optionConditions	array	An associated array holding the name of the options and their value to which the content should be filterd. Set to null to allow all content
	 * @return	array						A multi-dimensional array of the whole tree
	 */
	function getTree($startID=null, $templates=null, $optionConditions=null)
	{
		$startID = $startID !== null ? $startID : $this->idContent;
		$tree = array();
		$this->db->select('id');
		$this->db->where('id_content', $startID);
		if($templates !== null) {
			$first = true;
			foreach($templates as $id_template) {
				if($first) {
					$this->db->where('id_template', $id_template);
					$first = false;
				} else {
					$this->db->or_where('id_template', $id_template);
				}
			}
		}
		// TODO: Filter by optionConditions
		$query = $this->db->get('content');
		foreach($query->result() as $result) {
			$child = array(
				'id'=>$result->id,
				'children'=>$this->getTree($result->id, $templates, $optionConditions)
			);
			array_push($tree, $child);
		}
		return $tree;
	}
	
	/**
	 * Create the url to this dataobject.
	 * @param	$idContent	int		The ID of the content to create the URL of, if left empty, the URL of the current page is returned.
	 */
	function getUrl($idContent = null)
	{
		$idContent = $idContent !== null ? $idContent : $this->idContent;
		$parents = $this->parents($idContent);
		$aliases = array($this->getLanguageCode());
		foreach($parents as $parentObject)
		{
			array_push($aliases, $parentObject->get('alias'));
		}
		array_push($aliases, $this->get('alias'));
		// print_r($aliases);
		return site_url($aliases);
	}
	
	/**
	 * Get the language code
	 * @param	$idLanguage		int		The ID of the language
	 * @return	string					The code of the language
	 */
	function getLanguageCode($idLanguage = null)
	{
		$idLanguage = $idLanguage !== null ? $idLanguage : $this->idLanguage;
		$this->db->select('code');
		$this->db->where('id', $idLanguage);
		$query = $this->db->get('languages');
		$result = $query->result();
		return $result[0]->code;
	}
	
	/**
	 * Get an array with all the parents
	 * @param	$idContent	int	The ID of the child to get the parents from. If ID is set to null (default), the current dataObjects' ID is used
	 * @return	array	An array with dataModels
	 */
	function parents($idContent = null)
	{
		$idContent = $idContent !== null ? $idContent : $this->idContent;
		if(!isset($this->parentsArray[$idContent])) {
			// Create an array in which the first entry is the root parent:
			$parents = array();
			$idParent = $idContent;
			// Add a safety counter, so this will not become an infinite loop:
			$safetyCounter = 0;
			$infiniteLoop  = false;			
			while($safetyCounter < 100) {
				$this->db->select('id_content');
				$this->db->where('id', $idParent);
				$query = $this->db->get('content');
				if($this->db->count_all_results() > 0) {
					$idParent = $query->row()->id_content;
					if($idParent==0) {
						break;
					}
					$dataObject = new DataModel();
					$dataObject->load($idParent, $this->idLanguage);					
					array_unshift($parents, $dataObject);
				}				
				$safetyCounter++;
				if($safetyCounter>=100) {
					$infiniteLoop = true;
					break;
				}				
			}
			
			if($infiniteLoop) {
				// Error in loop
				log_message('error', 'Infinite loop detected when determing the parent. Content ID: '.$idContent, true);				
				return false;
			} else {
				$this->parentsArray[$idContent] = $parents;				
			}
		}
		return $this->parentsArray[$idContent];
	}
	
	/**
	 * Create an array with the different languages this website uses
	 * @return	array	A 2-dimensional array
	 */
	function getLanguages()
	{
		$languages = array();
		$query = $this->db->where('active', 1);
		$query = $this->db->get('languages');
		foreach($query->result_array() as $language) {
			$language['url'] = site_url($language['code']);
			array_push($languages, $language);
		}
		return $languages;
	}
	
	/**
	 * Get an array with all the parents
	 * @param	$idContent	int	The ID of the child to get the first parent from. If ID is set to null (default), the current dataobjects' ID is used
	 * @return	DataModel	A single datamodel
	 */
	function firstParent($idContent = null)
	{
		$parents = isset($this->parentsArray[$idContent]) ? $this->parentsArray[$idContent] : $this->parents($idContent);
		return $parents[0];	// The first entry in the array is the first parent.
	}
	
	/**
	 * Get the parent
	 * @param	$idContent	int	The ID of the child to get the parent from. If ID is set to null (default), the current dataobjects' ID is used
	 * @return	DataModel	A single datamodel
	 */
	function getParent($idContent = null)
	{
		$parents = isset($this->parentsArray[$idContent]) ? $this->parentsArray[$idContent] : $this->parents($idContent);
		return $parents[count($parents)-1];	// The last entry in the array is the parent.
	}
	
	/**
	 * Get a specific parameter
	 * @param	$parameter	string	The name of the parameter
	 * @return	string	The value
	 */
	function get($parameter)
	{
		if(isset($this->options[$parameter])) {
			return $this->options[$parameter];
		} else {
			return false;
		}
	}
	
    /**
     * Get the settings
     * TODO: This is the same function as in the admin model. Is there a way that these two can be combined?
     * @return  array   Associated array with the settings
     */
    function getSettings()
    {
        $settings = array();
        $this->db->select('name,value');
        $query = $this->db->get('settings');
        foreach($query->result() as $setting) {
            $settings[$setting->name] = $setting->value;
        }
        return $settings;
    }
	
	/**
	 * Get the locales
	 * @param	$idLanguage		int		The ID of the language, leave null to get the current language
	 */
	function getLocales($idLanguage = null)
	{
		$locales = array();
		$idLanguage = $idLanguage !== null ? $idLanguage : $this->idLanguage;
		/*
		$this->db->select('name','value');
		$this->db->where('id_language', $idLanguage);
		$this->db->join('locales_values', 'locales.id = locales_values.id_locale');
		*/
		
		// TODO: Make this query active-record-style:
		$pf = $this->db->dbprefix;
		$sql = 'SELECT A.`name`, B.`value` FROM
			`'.$pf.'locales` A,
			`'.$pf.'locales_values` B
				WHERE
			B.`id_language` = '.$idLanguage.' AND
			B.`id_locale`   = A.`id`';		
		$query = $this->db->query($sql);
		foreach($query->result() as $locale) {
			$locales[$locale->name] = $locale->value;
		}
		return $locales;
	}
	
	/**
	 * Render this datamodel according to it's template
	 */
	function render()
	{
		// Initialize smarty:
		$smarty = new Smarty();
		
		// Set the correct directories:
		$smarty->template_dir	= SMARTY_TEMPLATE_DIR;
		$smarty->compile_dir	= SMARTY_COMPILE_DIR;
		$smarty->cache_dir		= SMARTY_CACHE_DIR;
		$smarty->config_dir 	= SMARTY_CONFIG_DIR;
		$smarty->debug_tpl		= SMARTY_DEBUG_TPL;
		
		// Default settings:
		$smarty->compile_check 	= SMARTY_COMPILE;
		$smarty->debugging 		= SMARTY_DEBUG;
		$smarty->caching		= SMARTY_CACHE;
		$smarty->cache_lifetime	= SMARTY_CACHE_LIFETIME;
		
		// Assign the options:
		// $smarty->assign($this->options);
		foreach($this->options as $key=>$value) {
			$smarty->assign($key, $value);
		}
		
		// Assign a reference to the dataObject:
		$smarty->assign('dataObject', $this);
		
		// Assign a reference to the settings:
		$smarty->assign('settings', $this->getSettings());
		
		// Assign a reference to the locales:		
		$smarty->assign('locale', $this->getLocales());
		
		// Render the page:		
		$smarty->display($this->templateFile);
	}
}
?>