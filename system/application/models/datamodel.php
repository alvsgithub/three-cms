<?php

/**
 *  DataModel
 *  ---------------------------------------------------------------------------
 *  The DataModel is used by the website to load and format data that can be 
 *  used by the website.
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
	var $options;			// An array holding the options of this data object and it's values
	var $idContent;			// The ID of the content
	var $idLanguage;		// The ID of the language
	var $templateFile;		// The template file	
	var $settings;			// Settings object
	var $parameters;		// An array with parameters in the URL
	var $contentObjects;	// An array with content objects
	
	// The following parameters don't get set until a certain first function call
	// This makes the dataModel load faster in case the parameter is not used.
	// TODO: Is this still done? can it be deleted?
	var $parentsArray  = array();	// A 2-dimensional array holding the parents
	var $childrenArray = array();	// A 2-dimensional array holding the children
	
	function DataModel()
	{
		parent::Model();
		
		// Load the URL helper:
		$this->load->helper('url');
		
		// Load the session library:
		$this->load->library('session');
		
		// Assign Addons:
		// Load the addonBaseModel:
		$this->load->model('AddonBaseModel', '', true);
		
		// Load the addonModel:
		$this->load->model('AddonModel', '', true);
		
		// Default settings:
		$this->parameters     = false;
		$this->contentObjects = false;
	}
	
	function load($idContent, $idLanguage)
	{
		// Default settings:
		$this->idContent  = $idContent;
		$this->idLanguage = $idLanguage;
		$this->settings   = $this->getSettings();
		// Caching:
		// Caching is done by checking if there is a datafile: cache/data.idcontent.idlanguage.php
		// The datafile is nothing more than the options-array and some other variables. If the file
		// does not exist, execute the queries needed and create the datafile, otherwise just
		// include the file.
		// If the content gets edited, the datafile gets deleted
		$cacheFile = 'system/cache/data.'.$idContent.'.'.$idLanguage.'.php';
		if(file_exists($cacheFile)) {
			include($cacheFile);
			$this->options      = $options;
			$this->templateFile = $templateFile;
		} else {		
			$this->options = array();
			
			// Default settings:
			$this->db->select('name,alias,order,id_content,id_template');
			$this->db->where('id', $idContent);
			$query = $this->db->get('content');
			$info  = $query->result_array();
			
			// Some default options:
			$this->options['idContent']   = $idContent;
			$this->options['idLanguage']  = $idLanguage;
			$this->options['idParent']    = $info[0]['id_content'];
			$this->options['idTemplate']  = $info[0]['id_template'];
			$this->options['alias']       = $info[0]['alias'];
			$this->options['contentName'] = $info[0]['name'];
			$this->options['order']       = $info[0]['order'];
			
			// Killer Query to do the magic:
			// What it does: It selects the options that belong to the object of this content,
			// and it retrieves the objects correct values according to the given language, or
			// if the object isn't multilanguage, it returns it's defaults language value.
			$pf = $this->db->dbprefix;
			$sql = 'SELECT C.`type`, C.`name`, D.`value` FROM
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
				D.`id_language`     = IF(C.`multilanguage` = 1, '.$idLanguage.', '.$this->settings['default_language'].');
			';
			$query = $this->db->query($sql);
			
			// Fill the dataObject with the values:
			foreach($query->result() as $result) {
				// Execute Hook to allow to modify the data:
				// Note that here the result-parameter is a pointer to the $result-object. This is because the executeHook()-function cannot return values, only true or false.
				$this->AddonModel->executeHook('ModifyOptionValue', array('result'=>&$result, 'dataObject'=>$this));
				// If type is rich_text, replace id:-links with the correct URL:
				if($result->type=='rich_text') {
					$value = $result->value;
					preg_match_all('/href="id:(.*)"/', $value, $matches);
					for($i=0; $i<count($matches[0]); $i++) {
						$value = str_replace($matches[0][$i], 'href="'.$this->getUrl($matches[1][$i]).'"', $value);
					}
					$this->options[$result->name] = $value;
				} else {		
					$this->options[$result->name] = $result->value;
				}
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
			
			// Save the cache file:
			$cacheStr = '<?php'."\n";
			// The options:
			$cacheStr.= "\t".'$options = array('."\n";
			$first = true;
			foreach($this->options as $key=>$value) {
				if(!$first) { $cacheStr.=','."\n"; }
				$first = false;
				$cacheStr.= "\t\t".'\''.$key.'\'=>\''.str_replace('\'', '\\\'', $value).'\'';
			}
			$cacheStr.= "\n\t".');'."\n";
			$cacheStr.= "\t".'$templateFile = \''.$this->templateFile.'\';'."\n";
			$cacheStr.= '?>';
			$handle = fopen($cacheFile, 'w');
			fwrite($handle, $cacheStr);
			fclose($handle);
		}
	}
	
	/**
	 * Get the children of this dataModel
	 * @param	$idContent	int		The ID of the parent to get the children from. If ID is set to null (default), the current dataobjects' ID is used
	 * @param	$options	array	An array with options to use as filter
	 * @param	$limit		array	An array with one ore two values for the limit-options
	 * @param	$orderby	string	A string to order by: 'optionName asc/desc'. example: 'myDate asc'
	 * @return	array		An array with dataModels
	 */
	function children($idContent = null, $options = null, $limit = null, $orderby = null)
	{
		// TODO: Make Query Active Record Style
		$idContent = $idContent !== null ? $idContent : $this->idContent;
		$depth     = 0;
		$parentIDs = array();
		
		if(!is_numeric($idContent)) {
			// $idContent is a string, now special restrictions apply:
			// examples:
			// 4>		: Get the children of the CHILDREN of id=4
			// 4,8		: Get the children of id=4 and id=8
			// TODO: 4>>		: Get the children of the CHILDREN of the CHILDREN of id=4
			// TODO: 4t2		: Get the children of id=4 with template=2
			// TODO: 4>t2		: Get the children of the children of id=4 with template=2
			// Regular expression:
			$a = explode(",", $idContent);
			if(count($a)==1) {
				$a = explode(">", $idContent);
				$idContent = $a[0];
				// $depth     = count($a)-1;
				$depth = 1;
				$fromAlias = 'd0';
			} else {
				$fromAlias = 'a';
				$parentIDs = $a;
				$idContent = $a[0];
				array_shift($parentIDs);
			}
		} else {
			$fromAlias = 'a';
		}
		// Retrieve the children of this data object:
		$children = array();
		$pf = $this->db->dbprefix;				
		$sql = 'SELECT DISTINCT `'.$fromAlias.'`.`id` FROM (`'.$pf.'content` a ';
		if($depth > 0) {
			for($i=0; $i<$depth; $i++) {
				$sql .= ', `'.$pf.'content` d'.$i;
			}
		}
		$firstWhere = true;
		$where      = '';
		if($options != null) {
			// Create an associated array:
			if(is_string($options)) {
				$options = $this->stringToAssocArray($options);
			}
			// Adjust the query:
			$sql .= ', `'.$pf.'options` b, `'.$pf.'values` c) ';
			foreach($options as $key=>$value) {
				// See if there is an operator present:
				// >,<,>=,<=,!=
				if(preg_match('/(>=|<=|>|<|\!=|=>)/', $value)==1) {
					$operator = preg_replace('/(.*)(>=|<=|>|<|\!=|=>)(.*)/', '\\2', $value);
				} else {
					$operator = '=';
				}
				if($operator != '=') {
					$a = explode($operator, $value);
					$key = $a[0];
					$value = $a[1];
				}
				if($key == 'name' || $key == 'order') {
					if($firstWhere) {
						$firstWhere = false;					
						$where .= 'WHERE a.`'.$key.'` = \''.$value.'\' ';						
					} else {
						$where .= 'AND a.`'.$key.'` = \''.$value.'\' ';						
					}
				} else {
					if($firstWhere) {
						$firstWhere = false;					
						$where .= 'WHERE b.`name` = \''.$key.'\' ';						
					} else {
						$where .= 'AND b.`name` = \''.$key.'\' ';						
					}
					$where .= 'AND c.`id_option` = b.`id` ';
					$where .= 'AND c.`value` '.$operator.' \''.$value.'\' ';
					$where .= 'AND c.`id_content` = '.$fromAlias.'.`id` ';
				}
			}
		} else {
			$sql .= ') ';
		}
		if($orderby != null) {
			// Order by given options:
			$orderby   = explode(' ', $orderby);
			$item      = $orderby[0];
			$direction = isset($orderby[1]) ? strtolower($orderby[1]) : 'asc';				
			if($direction != 'asc' && $direction != 'desc') {
				$direction = 'asc';
			}
			if($item == 'name' || $item == 'order') {
				$orderby = ' ORDER BY a.`'.$item.'` '.$direction.' ';
			} else {
				$sql .= 'JOIN (`'.$pf.'values`, `'.$pf.'options`) ON (`'.$pf.'values`.`id_content` = `'.$fromAlias.'`.`id` AND `'.$pf.'values`.`id_option` = `'.$pf.'options`.`id` AND `'.$pf.'options`.`name` = \''.$item.'\') ';
				$orderby = ' ORDER BY `'.$pf.'values`.`value` '.strtoupper($direction).' ';
			}
		} else {
			// Order by internal order-parameter:
			$orderby = ' ORDER BY a.`order` ASC ';
		}
		
		if($firstWhere) {
			$where .= 'WHERE a.`id_content` = '.$idContent.' ';
			$firstWhere = false;
		} else {
			$where .= 'AND a.`id_content` = '.$idContent.' ';
		}
		
		if(count($parentIDs) > 0) {
			foreach($parentIDs as $pID) {
				$where .= 'OR a.`id_content` = '.$pID.' ';
			}
		}
		
		if($depth > 0) {
			for($i=0; $i<$depth; $i++) {
				$where .= 'AND d'.$i.'.`id_content` = a.`id`';
			}
		}
		
		$sql .= $where.$orderby;
		
		if($limit!=null) {
			if(is_string($limit)) {					
				$limit = $this->stringToAssocArray($limit);
			}
			if(count($limit)==1) {
				$sql .= 'LIMIT '.$limit[0];
			} else {
				$sql .= 'LIMIT '.$limit[1].', '.$limit[0];
			}
		}
		
		$sql .= ';';
		// echo $sql;
		
		$query = $this->db->query($sql);			
		foreach($query->result() as $result) {
			$dataObject = new DataModel();
			$dataObject->load($result->id, $this->idLanguage);
			array_push($children, $dataObject);
		}
		
		return $children;
	}
	
	/**
	 * Convert a string to an associated array
	 * @param	$str	string	The string to convert
	 * @return	array			An associated array
	 */
	function stringToAssocArray($str)
	{
		$array = array();
		$items = explode(',', $str);
		foreach($items as $item) {
			$itemArray = explode('=>', $item);
			if(count($itemArray)==2) {
				$array[$itemArray[0]] = $itemArray[1];
			} else {
				array_push($array, $item);
			}
		}
		return $array;
	}
	
	/**
	 * Get a specific child of this dataModel
	 * @param	$idContent	int		The ID of the parent to get the children from. If ID is set to null (default), the current dataobjects' ID is used
	 * @param	$options	array	An array with options to use as filter
	 * @param	$num	    int		The number of the child to retrieve (default=the first)
	 * @return	DataModel	A single datamodel or false of no model is found
	 */
	function child($idContent = null, $options = null, $num = 0)
	{
		$docs = $this->children($idContent, $options, array(1, $num));
		if(count($docs)>0) {
			return $docs[0];
		} else {
			return false;
		}
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
		// TODO: Filter by optionConditions <- ???
		$query = $this->db->get('content');
		foreach($query->result() as $result) {
			$child = array(
				'id'=>$result->id,
				'children'=>$this->getTree($result->id, $templates, $optionConditions)
			);
			array_push($tree, $child);
		}
		// print_r($tree);
		return $tree;
	}
	
	/**
	 * Create the url to this dataobject.
	 * @param	$idContent	int		The ID of the content to create the URL of, if left empty, the URL of the current page is returned.
	 * @param	$idLanguage	int		The ID of the language to use for this URL. null for current language
	 */
	function getUrl($idContent = null, $idLanguage = null)
	{
		$idContent    = $idContent !== null ? $idContent : $this->idContent;
		$parents      = $this->parents($idContent);
		$languageCode = $this->getLanguageCode($idLanguage);
		$aliases      = array($languageCode);
		foreach($parents as $parentObject)
		{
			array_push($aliases, $parentObject->get('alias'));
		}
		if($idContent != $this->idContent) {			
			array_push($aliases, $this->getAlias($idContent));
		} else {
			array_push($aliases, $this->get('alias'));
		}
		return site_url($aliases);
	}
	
	/**
	 * Get the alias of a given content ID
	 * @param	$idContent	int		The ID of the content to get the alias from
	 * @return	string				The alias
	 */
	function getAlias($idContent)
	{
		$this->db->select('alias');
		$this->db->where('id', $idContent);
		$query = $this->db->get('content');
		$result = $query->result();		
		return $result[0]->alias;
	}
	
	/**
	 * Get the id of a given content alias
	 * @param	$alias	string		The alias of the content to get the id from
	 * @return	int					The id
	 */
	function getId($alias)
	{
		$this->db->select('id');
		$this->db->where('alias', $alias);
		$query = $this->db->get('content');
		$result = $query->result();		
		return $result[0]->id;
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
			$language['url']        = site_url($language['code']);
			$language['currentUrl'] = $this->getUrl($this->idContent, $language['id']);
			array_push($languages, $language);
		}
		return $languages;
	}
	
	/**
	 * Get the first parent
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
        // Caching:
		$cacheFile = 'system/cache/data.settings.php';
		if(file_exists($cacheFile)) {
			include($cacheFile);
		} else {
			$cacheStr = '<?php'."\n\t".'$settings = array('."\n";		// For caching
			$first    = true;
			$settings = array();
			$this->db->select('name,value');
			$query = $this->db->get('settings');
			foreach($query->result() as $setting) {
				$settings[$setting->name] = $setting->value;
				if(!$first) {
					$cacheStr.=','."\n";
				}
				$first = false;
				$cacheStr.= "\t\t".'\''.$setting->name.'\'=>\''.str_replace('\'', '\\\'', $setting->value).'\'';
			}
			// Save cache file:			
			$cacheStr.= "\n"."\t".');'."\n".'?>';
			$handle = fopen($cacheFile, 'w');
			fwrite($handle, $cacheStr);
			fclose($handle);
		}
        return $settings;
    }
	
	/**
	 * Get the locales
	 * @param	$idLanguage		int		The ID of the language, leave null to get the current language
	 * @return	array
	 */
	function getLocales($idLanguage = null)
	{
		$idLanguage = $idLanguage !== null ? $idLanguage : $this->idLanguage;
		// Caching:
		$cacheFile = 'system/cache/data.locales.'.$idLanguage.'.php';
		if(file_exists($cacheFile)) {
			include($cacheFile);
		} else {
			$cacheStr = '<?php'."\n\t".'$locales = array('."\n";		// For caching
			$first    = true;
			$locales = array();
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
				if(!$first) {
					$cacheStr.=','."\n";
				}
				$first = false;
				$cacheStr.= "\t\t".'\''.$locale->name.'\'=>\''.str_replace('\'', '\\\'', $locale->value).'\'';
			}
			// Save cache file:			
			$cacheStr.= "\n"."\t".');'."\n".'?>';
			$handle = fopen($cacheFile, 'w');
			fwrite($handle, $cacheStr);
			fclose($handle);
		}
		return $locales;
	}
	
	/**
	 * Count the amount of records in a database with certain conditions
	 * @param	$where	string	Condition to check for (can be template, parent)
	 * @param	$value	string	The value to check the condition with
	 * @return	int				The number of matches found
	 */
	/*
	function count($where, $value)
	{
		if($where == 'template') { $where = 'id_template'; }
		if($where == 'parent')   { $where = 'id_content'; }
		$pf = $this->db->dbprefix;
		$sql = 'SELECT COUNT(*) AS `total` FROM `'.$pf.'content` WHERE `'.$where.'` = \''.$value.'\';';
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->total;
	}
	*/
	
	/**
	 * Create a new data object with the given parameters
	 * @param	$idContent	int		The ID of the content
	 * @param	$idLanguage	int		The ID of the language
	 * @return	DataModel			The data object
	 */
	function newObject($idContent, $idLanguage)
	{
		$object = new DataModel();
		$object->load($idContent, $idLanguage);
		return $object;
	}
	
	/**
	 * Render this datamodel according to it's template
	 * @param	$display	boolean		Display the page (true) or return it as a string (false)
	 * @return	string					Empty string on success or a string with the content if display is false
	 */
	function render($display = true)
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
		foreach($this->options as $key=>$value) {
			$smarty->assign($key, $value);
		}
		
		// Assign a reference to the dataObject:
		$smarty->assign('dataObject', $this);
		$smarty->assign('this', $this);
		
		// Assign a reference to the settings:
		$smarty->assign('settings', $this->settings);
		
		// Assign a reference to the locales:		
		$smarty->assign('locale', $this->getLocales());
		
		// Assign the parameters:
		$smarty->assign('parameters', $this->parameters);
		
		// Assign the contentObjects:
		$smarty->assign('contentObjects', $this->contentObjects);
		
		// Assign the addons:		
		foreach($this->AddonModel->addons as $addon) {
			if($addon[1]->frontEnd) {
				$addon[1]->dataObject = $this;
				$smarty->assign($addon[0], $addon[1]);
			}
		}
		
		// Render the page:
		if($display) {			
			$smarty->display($this->templateFile);
			return '';
		} else {
			return $smarty->fetch($this->templateFile);
		}
	}
}
?>