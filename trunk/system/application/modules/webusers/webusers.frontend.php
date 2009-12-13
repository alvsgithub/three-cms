<?php
	// This class is used on the frontend.
	// TODO: Figure out why CI sessions fail here
	
	class Webusers extends DataModel
	{
		// Constructor:
		function Webusers()
		{
			@session_start();
			parent::DataModel();			
		}
		
		/**
		 * Check whether the user is logged in or nog
		 * @return	boolean		True on logged in, false if not
		 */
		function loggedIn()
		{
			// echo '---: ';
			// print_r($_SESSION);
			// print_r($this->session->userdata('webuser_loggedin'));
			// return $this->session->userdata('webuser_loggedin');
			return isset($_SESSION['webuser_loggedin']) ? $_SESSION['webuser_loggedin'] : false;
			
		}
		
		/**
		 * Check if the user makes a login- or logout-action:
		 */
		function checkLogin()
		{
			if(isset($_POST['login'])) {
				if(isset($_POST['username']) && isset($_POST['password'])) {
					$username = $this->input->post('username');
					$password = md5($this->input->post('password'));					
					$this->db->where(array(
						'username' => $username,
						'password' => $password
					));
					$query = $this->db->get('webusers');
					if($query->num_rows==1) {						
						//$this->session->set_userdata('webuser_loggedin', true);
						$details = $query->result_array();
						//$this->session->set_userdata('webuser_info', $details[0]);
						$_SESSION['webuser_info'] = $details[0];
						$_SESSION['webuser_loggedin'] = true;
					}
				}
			} elseif(isset($_POST['logout'])) {
				//$this->session->unset_userdata('webuser_loggedin');
				//$this->session->unset_userdata('webuser_info');
				unset($_SESSION['webuser_loggedin']);
				unset($_SESSION['webuser_info']);
			}
		}
		
		/**
		 * Get info from the user
		 * @param	$str	string	The name of the information you want to get
		 * @return	$str			The information
		 */
		function userInfo($str)
		{
			return $_SESSION['webuser_info'][$str];
		}
	}
	
?>