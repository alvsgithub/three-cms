<?php
class Webusers extends AddonBaseModel
{
	/**
	 * Initialize
	 */
	function init()
	{
		@session_start();
		$this->frontEnd = true;
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
	
	/*
	// Show the install:
	function showInstall()
	{
		echo '<hr />';
		if(!isset($_POST['install'])) {
			echo '
				<p>It seems that this is the first time you are using the web users module.</p>
				<form method="post" action="'.$this->createLink(array('webusers')).'" />
					<input type="submit" value="Click here to install" name="install" />
				</form>';
		} else {
			// Install:
			
			// Webusers table:
			$fields = array(
				'id' => array(
					'type' => 'INT',
					'auto_increment' => true
				),
				'name' => array(
					'type' => 'TINYTEXT'
				),
				'address' => array(
					'type' => 'TINYTEXT'
				),
				'postalcode' => array(
					'type' => 'TINYTEXT'
				),
				'city' => array(
					'type' => 'TINYTEXT'
				),
				'country' => array(
					'type' => 'TINYTEXT'
				),
				'telephone' => array(
					'type' => 'TINYTEXT'
				),
				'mobile' => array(
					'type' => 'TINYTEXT'
				),
				'email' => array(
					'type' => 'TINYTEXT'
				),
				'username' => array(
					'type' => 'TINYTEXT'
				),
				'password' => array(
					'type' => 'TINYTEXT'
				),
				'blocked' => array(
					'type' => 'BOOL',
					'default' => 0
				)
			);
			// $this->load->dbforge(); // TODO: this function now loads in the admin controller, but it should be able to load at runtime.
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', true);
			$this->dbforge->create_table('webusers', true);
			
			// Webuser groups:
			$fields = array(
				'id' => array(
					'type' => 'INT',
					'auto_increment' => true
				),
				'name' => array(
					'type' => 'TINYTEXT'
				)
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', true);
			$this->dbforge->create_table('webusers_groups', true);
			
			// Linkage between webusers and webuser-groups:
			$fields = array(
				'id' => array(
					'type' => 'INT',
					'auto_increment' => true
				),
				'id_user' => array(
					'type' => 'INT'
				),
				'id_group' => array(
					'type' => 'INT'
				)
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', true);
			$this->dbforge->create_table('webusers_user_group', true);        
			
			// Linkage between groups and content:
			$fields = array(
				'id' => array(
					'type' => 'INT',
					'auto_increment' => true
				),
				'id_content' => array(
					'type' => 'INT'
				),
				'id_group' => array(
					'type' => 'INT'
				)
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', true);
			$this->dbforge->create_table('webusers_content_group', true);        
			
			echo '<p>Module successfully installed...</p>';
			echo '<p><a href="'.$this->createLink(array('webusers')).'">Click here to go to the module</a></p>';
		}
	}
	*/
}
?>