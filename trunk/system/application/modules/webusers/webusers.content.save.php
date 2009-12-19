<?php
	// The content of this file is executed after saving the page.
	//
	// Available parameters:
	//
	// $contentData	: all the data of this content object.
	// $idContent	: the ID of the content object that is just saved.
	
	if($this->db->table_exists('webusers')) {
	
	// First, delete all existing links:
	$this->db->delete('webusers_content_group', array('id_content'=>$idContent));
		if(!isset($_POST['webusers_all'])) {
			// Store all links:
			foreach($_POST as $key=>$value) {
				if(substr($key, 0, 9)=='webusers_') {
					$a = explode('_', $key);
					if(count($a)==2) {
						$id_group = $a[1];
						$this->db->insert('webusers_content_group', array('id_content'=>$idContent, 'id_group'=>$id_group));
					}
				}
			}
		}	
	}
?>