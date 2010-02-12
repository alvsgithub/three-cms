<?php
/*
 
	Webusers v0.1
	---------------------------------------------------------------------------
	Author:		Giel Berkers
	Website:	www.gielberkers.com
	---------------------------------------------------------------------------
	Usage:
	
	Frontend functions:
		loggedIn()			Check to see whether the current user is logged in
		userInfo($str)		Get certain information about the current user
		allowed($id)		Check whether the user is allowed to see the content
							with the given ID
		getErrors()			Check if there are errors
		
	Example #1: login / logout form:
	
		{if $webusers->loggedIn()}
			<h2>Logout</h2>
			<form method="post" action="">
				<input type="submit" name="webusers[logout]" />
			</form>
		{else}
			<h2>Login</h2>
			<form method="post" action="">
				Username:	<input type="text" name="webusers[username]" />
				Password:	<input type="password" name="webusers[password]" />
				<input type="submit" name="webusers[login]" />
			</form>
		{/if}
	
	Example #2: Register form:
	
		<h2>Register</h2>
		<form method="post" action="">
			Username:			<input type="text" name="webusers[username]" />
			Password:			<input type="password" name="webusers[password]" />
			Password (repeat):	<input type="password" name="webusers[passwordrepeat]" />
			E-mail address:		<input type="text" name="webusers[email]" />
			<input type="submit" name="webusers[register]" />
		</form>
	
	Example #3: Show allowed content:
	
		<body>
			{if $webusers->allowed($idContent)}
			
				...(show content)...
				
			{else}
				<p>You are not authorized to view this page!</p>
			{/if}
		</body>
		
	---------------------------------------------------------------------------
 
*/

class Webusers extends AddonBaseModel
{
	var $errors;
	
	/**
	 * Initialize
	 */
	function init()
	{
		@session_start();
		$this->frontEnd = true;
		$this->errors   = array();
	}
	
	/**
	 * This function tells Three CMS on which hook a function needs to be called
	 */
	function getHooks()
	{
		$hooks = array(
			array(
				'hook'=>'AppendSubNavigation',
				'callback'=>'addMenuOption'
			),
			array(
				'hook'=>'ModuleScreen',
				'callback'=>'showModuleScreen'
			),
			array(
				'hook'=>'ContentBelowOptions',
				'callback'=>'showUserGroupSelector'
			),
			array(
				'hook'=>'PostSaveContent',
				'callback'=>'save'
			),
			array(
				'hook'=>'PreRenderPage',
				'callback'=>'preRender'
			)
		);
		return $hooks;
	}
	
	// Add the menu option to the menu:
	function addMenuOption($context)
	{
		if($context['parent']=='users') {
			echo '<li><a href="'.$this->createLink(array('webusers')).'">Webusers</a></li>';			
		}
	}
	
	// Show the Module Screen:
	function showModuleScreen($context)
	{
		if($context['alias']=='webusers') {
			echo '<h1>Web Users</h1>';
			// First, check to see if the webusers-table exists:
			if(!$this->db->table_exists('webusers')) {
				include_once('install.php');
				// $this->showInstall();
			} else {
				if(count($context['parameters'])==0) {					
					include_once('main.php');
				} else {
					switch($context['parameters'][0]) {
						// Users:
						case 'adduser' :
							$details = array(
								'id' => 0,
								'name' => '',
								'address' => '',
								'postalcode' => '',
								'city' => '',
								'country' => '',
								'telephone' => '',
								'mobile' => '',
								'email' => '',
								'username' => '',
								'blocked' => 0
							);
							include_once('formuser.php');
							break;
						case 'edituser' :
							if(isset($context['parameters'][1])) {
								$this->db->where('id', $context['parameters'][1]);
								$query   = $this->db->get('webusers');
								$details = $query->result_array();
								if(count($details) == 1) {
									$details = $details[0];
									include_once('formuser.php');
								}
							}
							break;
						case 'deleteuser' :
							include_once('deleteuser.php');
							break;
						
						// Groups:
						case 'addgroup' :
							$details = array(
								'id' => 0,
								'name' => ''
							);
							include_once('formgroup.php');
							break;
						case 'editgroup' :
							if(isset($context['parameters'][1])) {
								$this->db->where('id', $context['parameters'][1]);
								$query   = $this->db->get('webusers_groups');
								$details = $query->result_array();
								if(count($details) == 1) {
									$details = $details[0];
									include_once('formgroup');
								}
							}
							break;
						case 'deletegroup' :
							include_once('deletegroup.php');
							break;
					}
				}
			}
		}
	}
	
	function showUserGroupSelector($context)
	{
		if($this->db->table_exists('webusers')) {	
			$allowedGroups = array();
			if($context['contentData']['id']==0) {
				// This is new content:
				$allChecked = ' checked="checked" ';
			} else {
				// This is existing content:
				// See which user groups are allowed to see this content, 0 means all
				$query = $this->db->select('id_group');
				$query = $this->db->where('id_content', $context['contentData']['id']);
				$query = $this->db->get('webusers_content_group');
				if($query->num_rows==0) {
					$allChecked = ' checked="checked" ';
				} else {
					// There are restrictions:
					$allChecked = '';
					foreach($query->result() as $result) {
						array_push($allowedGroups, $result->id_group);
					}
				}
			}
			echo '
				<tr>
					<th>Visible for webuser groups:</th>
					<td><input type="checkbox" name="webusers_all" '.$allChecked.' /> <strong>All users can view this page</strong><br />
				';
			// Get all groups:
			$this->db->select('id,name');
			$this->db->order_by('name', 'asc');
			$query = $this->db->get('webusers_groups');
			foreach($query->result() as $result) {
				$checked = in_array($result->id, $allowedGroups) ? ' checked="checked" ' : '';
				echo '
					<input type="checkbox" name="webusers_'.$result->id.'" '.$checked.' /> '.$result->name.'<br />
				';
			}
			echo '
				<script type="text/javascript">
				// jQuery script:
				$(function(){				
					$("input[name=webusers_all]").change(function(){
						if(!$(this).attr("checked")) {
							$("input[name^=webusers_]").removeAttr("disabled");						
						} else {
							$("input[name^=webusers_]").not($(this)).attr("disabled", "disabled");
						}
					});				
					$("input[name!=webusers_all]").change(function(){
						if($(this).attr("checked")) {
							$("input[name=webusers_all]").removeAttr("checked");
						} else {
							// See if there are other checkboxes that are checked
							var otherChecked = false;
							$("input[name!=webusers_all]").each(function(){
								if($(this).attr("checked")) {
									otherChecked = true;
								}
							});
							if(!otherChecked) {
								$("input[name=webusers_all]").attr("checked", "checked");
							}
						}					
					});
				});
				</script>
			</td>
		</tr>
			';
		}
	}
	
	function save($context)
	{
		if($this->db->table_exists('webusers')) {		
			// First, delete all existing links:
			$this->db->delete('webusers_content_group', array('id_content'=>$context['idContent']));
			if(!isset($_POST['webusers_all'])) {
				// Store all links:
				foreach($_POST as $key=>$value) {
					if(substr($key, 0, 9)=='webusers_') {
						$a = explode('_', $key);
						if(count($a)==2) {
							$id_group = $a[1];
							$this->db->insert('webusers_content_group', array('id_content'=>$context['idContent'], 'id_group'=>$id_group));
						}
					}
				}
			}	
		}
	}
	
	function preRender($context)
	{
		// Check if there is a post done to register this user:
		if(isset($_POST['webusers'])) {
			if($this->db->table_exists('webusers')) {
				$vars = $this->input->post('webusers'); 
				// Check what the action is:
				if(isset($vars['login'])) {
					// Login
					if(isset($vars['username']) && isset($vars['password'])) {				
						$username = $vars['username'];
						$password = md5($vars['password']);					
						$this->db->where(array(
							'username' => $username,
							'password' => $password
						));
						$query = $this->db->get('webusers');
						if($query->num_rows==1) {						
							$details = $query->result_array();
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
						} else {
							array_push($this->errors, array('code'=>101, 'message'=>'Login: Failed login attempt'));
						}
					}
				} elseif(isset($vars['logout'])) {
					// Logout
					unset($_SESSION['webuser_loggedin']);
					unset($_SESSION['webuser_info']);
					header('Location: '.$context['dataObject']->getUrl());
				} elseif(isset($vars['register'])) {
					// Register
					// Check if there required fields are not empty:
					if(!empty($vars['username']) && !empty($vars['password']) && !empty($vars['passwordrepeat']) && !empty($vars['email'])) {
						// Save the user:
						$details = array(
							'email' => $vars['email'],
							'username' => $vars['username']
						);
						$details['name'] = isset($vars['name']) ? $vars['name'] : '';
						$details['postalcode'] = isset($vars['postalcode']) ? $vars['postalcode'] : '';
						$details['city'] = isset($vars['city']) ? $vars['city'] : '';
						$details['country'] = isset($vars['country']) ? $vars['country'] : '';
						$details['address'] = isset($vars['address']) ? $vars['address'] : '';
						$details['telephone'] = isset($vars['telephone']) ? $vars['telephone'] : '';
						$details['mobile'] = isset($vars['mobile']) ? $vars['mobile'] : '';
						$details['blocked'] = isset($_POST['blocked']) ? 1 : 0;
						if(!empty($vars['password'])) {
							$password  = md5($vars['password']);
							$password2 = md5($vars['passwordrepeat']);
							if($password == $password2) {
								$details['password'] = $password;
								// Check if there is not already a user with the same e-mail address:
								$this->db->select('id');
								$this->db->where('email', $details['email']);
								$query = $this->db->get('webusers');
								if($query->num_rows >= 1) {
									array_push($this->errors, array('code'=>203, 'message'=>'Register: E-mail address is already in use'));
								} else {
									// New webuser:
									$this->db->insert('webusers', $details);					
									header('Location: '.$context['dataObject']->getUrl());
								}
							} else {
								array_push($this->errors, array('code'=>202, 'message'=>'Register: Passwords do not match'));
							}
						}
					} else {
						array_push($this->errors, array('code'=>201, 'message'=>'Register: Not all required fields are filled in'));						
					}
				}
			}
		}
	}
	
	/// Front-end functions:
	
	/**
	 * Check whether the user is logged in or nog
	 * @return	boolean		True on logged in, false if not
	 */
	function loggedIn()
	{
		return isset($_SESSION['webuser_loggedin']) ? $_SESSION['webuser_loggedin'] : false;
	}
	
	/**
	 * Check if the user makes a login- or logout-action:
	 */
	/*
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
					$details = $query->result_array();
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
			unset($_SESSION['webuser_loggedin']);
			unset($_SESSION['webuser_info']);
		}
	}
	*/
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
	 * Returns errors generated
	 * @return	mixed	array with errors on failure, false on success
	 */
	function getErrors()
	{
		if(count($this->errors)==0) {
			return false;
		} else {
			return $this->errors;
		}
	}
	
}
?>