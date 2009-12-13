<?php
	if(isset($parameters[1])) {
		$this->db->delete('webusers', array('id'=>$parameters[1]));
		redirect(moduleCreateLink(array('webusers')));
	}
?>