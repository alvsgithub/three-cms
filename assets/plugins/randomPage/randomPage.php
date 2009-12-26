<?php
class RandomPage extends DataModel
{
	/**
	 * Get a random page with a given template
	 * @param	$templateID	int	The ID of the template the random page should have
	 */
	function fromTemplate($templateID, $idLanguage)
	{
		$this->db->where('id_template', $templateID);
		$this->db->select('id');
		$this->db->order_by('id', 'random');
		$query = $this->db->get('content');
		if($query->num_rows > 0) {
			$result = $query->result();
			$contentObject = new DataModel();
			$contentObject->load($result[0]->id, $idLanguage);
			return $contentObject;
		}
		return false;
	}
}
?>