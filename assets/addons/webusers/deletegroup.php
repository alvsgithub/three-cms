<?php
	if(isset($context['parameters'][1])) {
		$this->db->delete('webusers_groups', array('id'=>$context['parameters'][1]));
		$this->db->delete('webusers_user_group', array('id_group'=>$context['parameters'][1]));
		redirect($this->createLink(array('webusers')));
	}
?>