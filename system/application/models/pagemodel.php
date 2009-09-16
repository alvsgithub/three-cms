<?php
class PageModel extends Model
{
	function PageModel()
	{
		parent::Model();
	}
	
	/**
	 * Count the number of languages
	 * @return	int
	 */
	function countLanguages()
	{
		$query = $this->db->query('SELECT COUNT(*) AS `total` FROM `languages` WHERE `active` = 1;');
		$row = $query->row();
		return $row->total;
	}
	
	/**
	 * Get the ID of the language with the code specified
	 * @param	$code	String The code as specified in the database
	 * @return	int
	 */
	function getLanguageId($code)
	{
		$query = $this->db->query('SELECT `id` FROM `languages` WHERE `code` = \''.$code.'\' AND `active` = 1;');
		if($query->num_rows == 1) {
			// Return the ID of this language
			return $query->row()->id;
		} else {
			// Return the default language ID
			return DEFAULT_LANGUAGE_ID;
		}
	}
	
	/**
	 * Get a data object
	 * @param	$idPage		int	the ID of the page
	 * @param	$idLanguage	int	the ID of the language
	 */
	function getDataObject($idPage, $idLanguage)
	{
		// TODO: Create a data object according to database content
		$dataObject = new stdClass();
		
		// TODO: Get the id's of the options according to database content
		$dataObject->title		= $this->getValue(1, $idLanguage);
		$dataObject->header		= $this->getValue(2, $idLanguage);
		$dataObject->content	= $this->getValue(3, $idLanguage);
		
		return $dataObject;
	}
	
	/**
	 * Get the value of an option
	 * @param	$idOption	int	the ID of the option
	 * @param	$idLanguage	int the ID of the language
	 * @return	String
	 */
	function getValue($idOption, $idLanguage) {
		$query = $this->db->query('SELECT `value` FROM `values`
			WHERE `id_option` = '.$idOption.' AND `id_language` = '.$idLanguage.';');
		return $query->row()->value;
	}
}
?>