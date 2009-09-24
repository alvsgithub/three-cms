<?php
/**
 *  PageModel
 *  ---------------------------------------------------------------------------
 *  The PageModel is used by the page controller to load the default data that
 *  is used by each page of the website.
 *  ---------------------------------------------------------------------------
 *  Author:     Giel Berkers
 *  E-mail:     giel.berkers@gmail.com
 *  Revision:   1
 *  ---------------------------------------------------------------------------
 *  Changelog:
 *
 *
 */

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
		$this->db->where('active', 1);
		$this->db->from('languages');
		return $this->db->count_all_results();
	}
	
	/**
	 * Get the ID of the language with the code specified
	 * @param	$code	String The code as specified in the database
	 * @return	int
	 */
	function getLanguageId($code)
	{
		$this->select('id');
		$this->where('code', $code);
		$this->where('active', 1);
		$query = $this->get('languages');
		
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
	 * @param	$idContent	int	the ID of the content
	 * @param	$idLanguage	int	the ID of the language
	 */
	function getDataObject($idContent, $idLanguage)
	{
		$dataObject = new DataModel();
		$dataObject->load($idContent, $idLanguage);
		return $dataObject;
	}
	
	/**
	 * Get the value of an option
	 * @param	$idContent	int	the ID of the content
	 * @param	$idOption	int	the ID of the option
	 * @param	$idLanguage	int the ID of the language
	 * @return	String
	 */
	function getValue($idContent, $idOption, $idLanguage) {
		$this->db->select('value');
		$this->db->where('id_content', $idContent);
		$this->db->where('id_option', $idOption);
		$this->db->where('id_language', $idLanguage);
		$query = $this->db->get('values');
		return $query->row()->value;
	}
}
?>