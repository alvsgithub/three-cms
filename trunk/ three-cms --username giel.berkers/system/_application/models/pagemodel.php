<?php
class PageModel extends Model
{
	function PageModel()
	{
		parent::Model();
	}
	
	function countLanguages()
	{
		$query = $this->db->query('SELECT COUNT(*) AS `total` FROM `languages` WHERE `active` = 1;');
		$row = $query->row();
		return $row->total;
	}
}
?>