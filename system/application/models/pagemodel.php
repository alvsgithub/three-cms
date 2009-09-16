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
	 * @param	$idContent	int	the ID of the content
	 * @param	$idLanguage	int	the ID of the language
	 */
	function getDataObject($idContent, $idLanguage)
	{
		$dataObject = new stdClass();
		
		// Killer Query to do the magic:
		// What it does: It selects the options that belong to the object of this content,
		// and it retrieves the objects correct values according to the given language, or
		// if the object isn't multilanguage, it returns it's defaults language value.
		$sql = 'SELECT C.`name`, D.`value` FROM
			`content` A,
			`objects_options` B,
			`options` C,
			`values` D
				WHERE
			A.`id_content`  = '.$idContent.' AND
			A.`id_object`   = B.`id_object` AND
			C.`id`          = B.`id_option` AND
			D.`id_content`  = '.$idContent.' AND
			D.`id_option`   = B.`id_option` AND
			D.`id_language` = IF(C.`multilanguage` = 1, '.$idLanguage.', '.DEFAULT_LANGUAGE_ID.')
			;';
		$query = $this->db->query($sql);
		
		// Fill the dataObject with the values:
		foreach($query->result() as $result) {
			$dataObject->{$result->name} = $result->value;
		}
		
		// Return the dataObject:
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
		$query = $this->db->query('SELECT `value` FROM `values`	WHERE
			`id_content` = '.$idContent.' AND
			`id_option` = '.$idOption.' AND
			`id_language` = '.$idLanguage.';');
		return $query->row()->value;
	}
}
?>