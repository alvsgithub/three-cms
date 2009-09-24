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
	
	function DataModel()
	{
		parent::Model();
	}
	
	function load($idContent, $idLanguage)
	{
		// Default settings:
		$this->idContent 	= $idContent;
		$this->idLanguage	= $idLanguage;
		$this->options		= array();
		
		// Killer Query to do the magic:
		// What it does: It selects the options that belong to the object of this content,
		// and it retrieves the objects correct values according to the given language, or
		// if the object isn't multilanguage, it returns it's defaults language value.
		$sql = 'SELECT C.`name`, D.`value` FROM
			`content` A,
			`dataobjects_options` B,
			`options` C,
			`values` D,
			`templates` E
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
			`content` A,
			`templates` B
				WHERE
			A.`id_template` = B.`id` AND
			A.`id` = '.$idContent.';
		';
		$query = $this->db->query($sql);
		$this->templateFile = $query->row()->templatefile;
	}
	
	/**
	 * Get the children of this dataModel
	 * @return	array	An array with dataModels
	 */
	function children()
	{
		// Retrieve the children of this data object:
		$children = array();		
		$this->db->select('id');
		$this->db->where('id_content', $this->idContent);
		$query = $this->db->get('content');		
		foreach($query->result() as $result) {
			$dataObject = new DataModel();
			$dataObject->load($result->id, $this->idLanguage);
			array_push($children, $dataObject);
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
		// TODO
		
	}
	
	/**
	 * Create a tree of this dataModel and all it's children (recursive)
	 * @param	$startID			int		The ID to see as te root parent. Set to null to use the current dataModel's ID
	 * @param	$templates			array	An array containing the ID's of the templates to allow in this tree. Set to null to allow all templates.
	 * @param	$optionConditions	array	An associated array holding the name of the options and their value to which the content should be filterd. Set to null to allow all content
	 */
	function getTree($startID=null, $templates=null, $optionConditions=null)
	{
		// TODO
		
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
		$smarty->assign($this->options);
		$smarty->assign('dataObject', $this);
		
		// Render the page:		
		$smarty->display($this->templateFile);
	}
}
?>