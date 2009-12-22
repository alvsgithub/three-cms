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
						// Add the groups where this user belongs to:
						$this->db->select('id_group');						
						$this->db->where('id_user', $details[0]['id']);
						$query = $this->db->get('webusers_user_group');
						$groups = array();
						foreach($query->result() as $result) {
							array_push($groups, $result->id_group);
						}
						$details[0]['groups'] = $groups;
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
		
		/**
		 * See if the current user is allowed to see this content
		 * @param	$idContent	int		The ID of the content
		 * @return	boolean				True or false
		 */
		function allowed($idContent)
		{
			$this->db->select('id_group');
			$this->db->where('id_content', $idContent);
			$query = $this->db->get('webusers_content_group');
			if($query->num_rows==0) {
				// No restrictions found
				return true;
			} else {
				// Restrictions found
				// See if the user may view this content:
				if($this->loggedIn()) {					
					$groups = $this->userInfo('groups');					
					foreach($query->result() as $result) {
						if(in_array($result->id_group, $groups)) {
							// Id found, user is allowed to view this content:
							return true;
						}
					}
					// Id not found, user is not allowed to view this content:
					return false;
				} else {
					// Not logged in
					return false;
				}
			}
		}
		
		/**
		 * Get the children of this dataModel that this user is allowed to see.
		 * @param	$idContent	int	The ID of the parent to get the children from. If ID is set to null (default), the current dataobjects' ID is used
		 * @return	array		An array with dataModels
		 */
		function getAllowedChildren($idContent)
		{
		   /*
		   $idContent = $idContent !== null ? $idContent : $this->idContent;
		   if(isset($this->childrenArray[$idContent])) {
			   $children = $this->childrenArray[$idContent];
		   } else {
			   // Retrieve the children of this data object:
			   $children = array();		
			   $this->db->select('id');
			   $this->db->where('id_content', $idContent);
			   $this->db->order_by('order', 'asc');
			   $query = $this->db->get('content');		
			   foreach($query->result() as $result) {
				   $dataObject = new DataModel();
				   $dataObject->load($result->id, $this->idLanguage);
				   array_push($children, $dataObject);
			   }
			   // Store for optimization:
			   $this->childrenArray[$idContent] = $children;
		   }		
		   return $children;
		   */
		}
	}
	
?>