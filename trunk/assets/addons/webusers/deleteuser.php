<?php
	if(isset($context['parameters'][1])) {
		$this->db->delete('webusers', array('id'=>$context['parameters'][1]));
		$this->db->delete('webusers_user_group', array('id_user'=>$context['parameters'][1]));
		redirect($this->createLink(array('webusers')));
	}
?>