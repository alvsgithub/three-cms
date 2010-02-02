<?php
class Admin extends Controller
{
    private $loggedIn;
    private $rank;
	private $settings;
	private $messages;
	
    function Admin()
    {
        parent::Controller();
        
		// Include default config:
		include_once(BASEPATH.'application/config/page_config.php');
		
		// Load the Session library:
		$this->load->library('session');
		
		// Set the tree Array, which makes sure the tree on the right is properly expanded on a page refresh:
		if($this->session->userdata('treeArray')==false) {
			$this->session->set_userdata('treeArray', array());
		}
		
		// Load the Helpers:
		$this->load->helper('url');		
		$this->load->helper('stringencrypter');		
		$this->load->helper('module');
		
		// Load dbforge (in case some modules need it)
		$this->load->dbforge();
		
        // Load the Language Class:
        $this->lang->load('admin');
        
        // See if the user is logged in:
        $this->loggedIn = $this->session->userdata('loggedIn');
		if(!$this->loggedIn) {
			if($this->uri->segment(2)!='login') {
				redirect(site_url(array('admin', 'login')));		// TODO: In case of an AJAX call the whole site must be refreshed
			}
        }
		
		// Get the rank of this user:
		$this->rank     = $this->session->userdata('rank');
		
        // Load the adminModel:
        $this->load->model('AdminModel', '', true);
		
		// Load the settings:
		$this->settings = $this->AdminModel->getSettings();
		
		// Set the messages:
		$this->messages = $this->session->userdata('messages');		
		$this->session->set_userdata('messages', array());		
    }
    
	/**
	 * Default index function
	 */
    function index()
    {
        $this->showHeader();
		$this->showTree();
        // By default, load the dashboard:
		$this->showDashBoard();
        $this->showFooter();
    }
    
	/**
	 * Default login
	 */
	function login()
	{
		$error = false;
		if(isset($_POST['login'])) {
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			$info     = $this->AdminModel->checkLogin($username, $password);
			if($info==false) {
				$error = true;
				sleep(3);	// Sleep 3 seconds (security)
			} else {
				$this->session->set_userdata(array('loggedIn'=>true, 'rank'=>$info['id_rank']));
				redirect(site_url('admin'));
			}
		}
		$data = array(
			'lang'=>$this->lang,
			'error'=>$error
		);
		$this->load->view('admin/login.php', $data);
	}
	
	/**
	 * Default logout
	 */
	function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url('admin'));
	}
	
	/**
	 * The default manager. This manages the data
	 */
    function manage()
    {
        $this->showHeader();
		$this->showTree();
        // Get the item to manage:
        $action = $this->uri->segment(3);
        // Show the data:
		// SubForm is used to show secondary data (linked tables for instance)
        switch($action) {
            case 'templates':
                {
                    $title          = $this->lang->line('title_templates');
                    $name           = $this->lang->line('name_template');
                    $description    = $this->lang->line('desc_templates');
                    $tableData      = $this->AdminModel->getTableData('templates', 'id,name,type,templatefile');
                    $tableHeaders   = array('id', 'name', 'type', 'templatefile');
                    break;
                }
            case 'dataobjects':
                {
                    $title          = $this->lang->line('title_data_objects');
                    $name           = $this->lang->line('name_data_object');
                    $description    = $this->lang->line('desc_data_objects');
                    $tableData      = $this->AdminModel->getTableData('dataobjects', 'id,name');
                    $tableHeaders   = array('id', 'name');
                    break;
                }
            case 'options' :
                {
                    $title          = $this->lang->line('title_options');
                    $name           = $this->lang->line('name_option');
                    $description    = $this->lang->line('desc_options');
                    $tableData      = $this->AdminModel->getTableData('options', 'id,name,type,multilanguage');
                    $tableHeaders   = array('id', 'name', 'type', 'multilanguage');
                    break;
                }
            case 'languages' :
                {
                    $title          = $this->lang->line('title_languages');
                    $name           = $this->lang->line('name_language');
                    $description    = $this->lang->line('desc_languages');
                    $tableData      = $this->AdminModel->getTableData('languages', 'id,name,code,active');
                    $tableHeaders   = array('id', 'name', 'code', 'active');
                    break;
                }
            case 'locales' :
                {
                    $title          = $this->lang->line('title_locales');
                    $name           = $this->lang->line('name_locale');
                    $description    = $this->lang->line('desc_locales');
                    $tableData      = $this->AdminModel->getTableData('locales', 'id,name');
                    $tableHeaders   = array('id', 'name');
                    break;
                }
            default :
                {
                    // Non existing action
                    $this->showNotFound();
                    $this->showFooter();
                    return;
                    break;
                }
        }
        $data = array(
            'tableData'=>$tableData,
            'tableHeaders'=>$tableHeaders,
            'action'=>$action,
            'title'=>$title,
            'description'=>$description,
            'button_text'=>str_replace('%s', $name, $this->lang->line('button_add_new_item')),
            'lang'=>$this->lang
        );
        $this->load->view('admin/manage/table.php', $data);
        $this->showFooter();
    }
    
	/**
	 * Template functions
	 */
	function templates()
	{
		$action = $this->uri->segment(3);
		$id     = $this->uri->segment(4);
		// Check for the action:
		switch($action) {
			case 'save' :
				{
					// Save the data (POST-action)
					$root = isset($_POST['root']) ? 1 : 0;
					$data = array(
						'name'=>$this->makeSafe($this->input->post('name')),
						'id_dataobject'=>$this->input->post('id_dataobject'),
						'templatefile'=>$this->input->post('templatefile'),
						'root'=>$root,
						'type'=>$this->input->post('type')
					);
					$id = $this->AdminModel->saveData('templates', $data, $this->input->post('id'));
					// Save the allowed templates:
					$childTemplates = $this->AdminModel->getChildTemplates($id);
					for($i=0; $i<count($childTemplates); $i++) {
						$childTemplates[$i]['allowed'] = isset($_POST['allow_template_'.$childTemplates[$i]['id']]);
					}
					$this->AdminModel->saveChildTemplates($id, $childTemplates);
					// Save the allowed ranks:
					$allowedRanks = $this->AdminModel->getAllowedRanks($id);					
					for($i=0; $i<count($allowedRanks); $i++) {
						$allowedRanks[$i]['allowed'] = isset($_POST['allow_rank_'.$allowedRanks[$i]['id']]);
					}
					$this->AdminModel->saveAllowedRanks($id, $allowedRanks);
					// Redirect away:
					redirect(site_url(array('admin', 'manage', 'templates')));
					break;
				}
			case 'delete' :
				{
					// Delete
					if($id!=false) {
						$this->AdminModel->deleteData(array('templates'=>'id', 'content'=>'id_template', 'templates_ranks'=>'id_template'), $id);
						redirect(site_url(array('admin', 'manage', 'templates')));
					}
					break;
				}
			case 'duplicate' :
				{
					// Duplicate
					if($id!=false) {
						$this->AdminModel->duplicateTemplate($id);
						redirect(site_url(array('admin', 'manage', 'templates')));
					}
					break;
				}
			case 'add' :
			case 'edit' :
				{
					// Add or edit
					$name  = $this->lang->line('name_template');
					if($action=='add') {
						$title = str_replace('%s', $name, $this->lang->line('title_add_new_item'));
					} else {
						$title = str_replace('%s', $name, $this->lang->line('title_modify_item'));
					}
					$data = array(
						'lang'=>$this->lang,
						'title'=>$title,
						'values'=>$this->AdminModel->getData('templates', $id),
						'dataObjects'=>$this->AdminModel->getDataObjects(),
						'childTemplates'=>$this->AdminModel->getChildTemplates($id),
						'ranks'=>$this->AdminModel->getAllowedRanks($id)
					);
					$this->showHeader();
					$this->showTree();
					$this->load->view('admin/templates/add_edit.php', $data);
			        $this->showFooter();
					break;
				}
		}
	}
	
	
	/**
	 * Data object functions
	 */
	function dataobjects()
	{
		$action = $this->uri->segment(3);
		$id     = $this->uri->segment(4);
		// Check for the action:
		switch($action) {
			case 'save' :
				{
					// Save the data (POST-action)
					$data = array(						
						'name'=>$this->makeSafe($this->input->post('name'))
					);
					$id = $this->AdminModel->saveData('dataobjects', $data, $this->input->post('id'));
					// Save the options:
					$options = explode('-', $this->input->post('optionString'));
					$this->AdminModel->saveDataObjectOptions($options, $id);
					redirect(site_url(array('admin', 'manage', 'dataobjects')));
					break;
				}
			case 'delete' :
				{
					// Delete
					if($id!=false) {
						$this->AdminModel->deleteData(array('dataobjects'=>'id', 'dataobjects_options'=>'id_dataobject', 'templates'=>'id_dataobject'), $id);
						redirect(site_url(array('admin', 'manage', 'dataobjects')));
					}
					break;
				}
			case 'duplicate' :
				{
					// Duplicate
					if($id!=false) {
						$this->AdminModel->duplicateDataObject($id);
						redirect(site_url(array('admin', 'manage', 'dataobjects')));
					}
					break;
				}
			case 'add' :
			case 'edit' :
				{
					// Add or edit
					$name  = $this->lang->line('name_data_object');
					if($action=='add') {
						$title = str_replace('%s', $name, $this->lang->line('title_add_new_item'));
					} else {
						$title = str_replace('%s', $name, $this->lang->line('title_modify_item'));
					}
					$data = array(
						'lang'=>$this->lang,
						'title'=>$title,
						'values'=>$this->AdminModel->getData('dataobjects', $id),
						'options'=>$this->AdminModel->getDataObjectOptions($id),
						'optionList'=>$this->AdminModel->getOptions()
					);
					$this->showHeader();
					$this->showTree();
					$this->load->view('admin/dataobjects/add_edit.php', $data);
			        $this->showFooter();
					break;
				}
		}
	}
	
	/**
	 * Options functions
	 */
	function options()
	{
		$action = $this->uri->segment(3);
		$id     = $this->uri->segment(4);
		// Check for the action:
		switch($action) {
			case 'save':
				{
					$data = array(
						'name'=>$this->makeSafe($this->input->post('name')),
						'description'=>$this->makeSafe($this->input->post('description')),
						'tooltip'=>$this->makeSafe($this->input->post('tooltip')),
						'type'=>$this->input->post('type'),
						'options'=>$this->makeSafe($this->input->post('options')),
						'default_value'=>$this->makeSafe($this->input->post('default_value')),
						'multilanguage'=>isset($_POST['multilanguage']) ? 1 : 0,
						'required'=>isset($_POST['required']) ? 1 : 0
					);
					if(empty($data['description'])) { $data['description'] = ucfirst($data['name']); }
					$this->AdminModel->saveData('options', $data, $this->input->post('id'));
					redirect(site_url(array('admin', 'manage', 'options')));
					break;
				}
			case 'delete' :
				{
					if($id!=false) {
						$this->AdminModel->deleteData(array('options'=>'id', 'values'=>'id_option', 'dataobjects_options'=>'id_option'), $id);
						redirect(site_url(array('admin', 'manage', 'options')));
					}
					break;
				}
			case 'duplicate' :
				{
					if($id!=false) {
						$this->AdminModel->duplicateOption($id);
						redirect(site_url(array('admin', 'manage', 'options')));
					}
					break;
				}
			case 'add' :
			case 'edit' :
				{
					$name = $this->lang->line('name_option');
					if($action=='add') {
						$title = str_replace('%s', $name, $this->lang->line('title_add_new_item'));
					} else {
						$title = str_replace('%s', $name, $this->lang->line('title_modify_item'));
					}
					$data = array(
						'lang'=>$this->lang,
						'title'=>$title,
						'values'=>$this->AdminModel->getData('options', $id)
					);					
					$this->showHeader();
					$this->showTree();
					$this->load->view('admin/options/add_edit.php', $data);
			        $this->showFooter();
					break;
				}
		}
	}
	
	
	/**
	 * Languages functions
	 */
	function languages()
	{
		$action = $this->uri->segment(3);
		$id     = $this->uri->segment(4);
		// Check for the action:
		switch($action) {
			case 'save' :
				{
					// Save the data (POST-action)
					$data = array(						
						'name'=>$this->makeSafe($this->input->post('name')),
						'code'=>$this->input->post('code'),
						'active'=>isset($_POST['active']) ? 1 : 0
					);
					$this->AdminModel->saveData('languages', $data, $this->input->post('id'));
					redirect(site_url(array('admin', 'manage', 'languages')));
					break;
				}
			case 'delete' :
				{
					// Delete
					if($id!=false) {
						$this->AdminModel->deleteData(array('languages'=>'id', 'values'=>'id_language', 'locales_values'=>'id_language'), $id);
						redirect(site_url(array('admin', 'manage', 'languages')));
					}
					break;
				}
			case 'duplicate' :
				{
					// Duplicate
					if($id!=false) {
						$this->AdminModel->duplicateLanguage($id);
						redirect(site_url(array('admin', 'manage', 'languages')));
					}
					break;
				}
			case 'add' :
			case 'edit' :
				{
					// Add or edit
					$name  = $this->lang->line('name_language');
					if($action=='add') {
						$title = str_replace('%s', $name, $this->lang->line('title_add_new_item'));
					} else {
						$title = str_replace('%s', $name, $this->lang->line('title_modify_item'));
					}
					$data = array(
						'lang'=>$this->lang,
						'title'=>$title,
						'values'=>$this->AdminModel->getData('languages', $id)
					);
					$this->showHeader();
					$this->showTree();
					$this->load->view('admin/languages/add_edit.php', $data);
			        $this->showFooter();
					break;
				}
		}
	}
	
	/**
	 * Locales functions
	 */
	function locales()
	{
		$action = $this->uri->segment(3);
		$id     = $this->uri->segment(4);
		// Check for the action:
		switch($action) {
			case 'save' :
				{
					// Save the data (POST-action)
					$data = array(						
						'name'=>$this->makeSafe($this->input->post('name'))
					);
					$id = $this->AdminModel->saveData('locales', $data, $this->input->post('id'));
					// Save the language-entries:
					$locales = $this->AdminModel->getLocaleValues($id);
					for($i=0; $i < count($locales); $i++) {						
						// $locales[$i]['value'] = $this->makeSafe($_POST['language_'.$locales[$i]['id']]);
						// $locales[$i]['value'] = $this->makeSafe($this->input->post('language_'.$locales[$i]['id']));
						
						// TODO: Weird issue: when the makeSafe()-function is used, an empty string returns when characters like ä or é are present. But when saving regular content, the makeSafe()-function works just fine.
						$locales[$i]['value'] = htmlentities($this->input->post('language_'.$locales[$i]['id']), ENT_QUOTES, 'ISO-8859-15');
						// echo htmlentities($this->input->post('language_'.$locales[$i]['id']), ENT_QUOTES, 'ISO-8859-15');
					}
					
					// print_r($locales);
					// die();
					
					$this->AdminModel->saveLocaleValues($id, $locales);
					redirect(site_url(array('admin', 'manage', 'locales')));					
					break;
				}
			case 'delete' :
				{
					// Delete
					if($id!=false) {
						$this->AdminModel->deleteData(array('locales'=>'id', 'locales_values'=>'id_locale'), $id);
						redirect(site_url(array('admin', 'manage', 'locales')));
					}
					break;
				}
			case 'duplicate' :
				{
					// Duplicate
					if($id!=false) {
						$this->AdminModel->duplicateLocale($id);
						redirect(site_url(array('admin', 'manage', 'locales')));
					}
					break;
				}
			case 'add' :
			case 'edit' :
				{
					// Add or edit
					$name  = $this->lang->line('name_locale');
					if($action=='add') {
						$title = str_replace('%s', $name, $this->lang->line('title_add_new_item'));
					} else {
						$title = str_replace('%s', $name, $this->lang->line('title_modify_item'));
					}
					$data = array(
						'lang'=>$this->lang,
						'title'=>$title,
						'values'=>$this->AdminModel->getData('locales', $id),
						'locales'=>$this->AdminModel->getLocaleValues($id)
					);
					$this->showHeader();
					$this->showTree();
					$this->load->view('admin/locales/add_edit.php', $data);
			        $this->showFooter();
					break;
				}
		}
	}
	
	/**
	 * AJAX Calls are done here
	 */
	function ajax()
	{
		// Get the requisted action:
		$action = $this->uri->segment(3);
		switch($action) {
			case 'tree' :
				{
					// Show the tree:					
					$id   = $this->uri->segment(4);					
					$data = array(
						'lang'=>$this->lang,
						'tree'=>$this->AdminModel->getTree($id)
					);
					$this->load->view('admin/ajax/tree.php', $data);
					break;
				}
			case 'fulltree' :
				{
					// Show the complete tree:
					$this->showTree();
					break;
				}
			case 'treeclose' :
				{
					// Remove this id from the treeArray:
					$id   = $this->uri->segment(4);					
					$treeArray = $this->session->userdata('treeArray');
					$newArray  = array();
					foreach($treeArray as $id_tree) {
						if($id_tree != $id) {
							array_push($newArray, $id_tree);
						}
					}
					$this->session->set_userdata('treeArray', $newArray);
				}
			case 'show_options' :
				{
					$options = $this->uri->segment(4);
					if($options!=false) {
						$optionList = explode('-', $options);
						$optionData = array();
						foreach($optionList as $optionID) {
							$option = $this->AdminModel->getData('options', $optionID);
							array_push($optionData, $option);
						}
						$this->load->view('admin/ajax/show_options.php', array('optionData'=>$optionData));
					}
					break;
				}
			case 'page_summary' :
				{
					$id = $this->uri->segment(4);					
					if($id!=false) {
						$content = $this->AdminModel->getContent($id);
						$data = array(
							'content'=>$content,
							'lang'=>$this->lang,
							'childTemplates'=>$this->AdminModel->getChildTemplates($content['id_template'])
						);
						$this->load->view('admin/ajax/page_summary.php', $data);
					}
					break;
				}
			case 'checkdescendant' :
				{
					$idParent  = $this->uri->segment(4);
					$idContent = $this->uri->segment(5);
					if($idParent!=false && $idParent!=false) {
						$isDescendant = $this->AdminModel->checkDescendant($idContent, $idParent);
						echo $isDescendant ? 'error' : 'ok';
					} else {
						echo 'error';
					}
					break;
				}
			case 'keepalive' :
				{
					// This function is used to keep the session allive. It is called every 5 minutes.
					echo '1';
					break;
				}
			case 'loadoptions' :
				{
					$idTemplate = $this->input->post('template');
					$idParent   = $this->input->post('parent');
					$idContent  = $this->input->post('id');
					if($idTemplate!=false) {
						// Get ContentData, according to chosen template:
						$contentData = $this->AdminModel->getContentData($idContent, $idParent, $idTemplate);
						$data = array(
							'lang'=>$this->lang,
							'contentData'=>$contentData,
							'settings'=>$this->settings
						);
						$this->load->view('admin/content/options_field.php', $data);
					}
					break;
				}
		}
	}
	
	/**
	 * Content editing is done here
	 */
	function content()
	{
		// TODO: If content is added, saved and saved again, it gets stored as a new item again
		if(!isset($_POST['ajax'])) {
			$this->showHeader();
		}
		$action = $this->uri->segment(3);
		$id     = $this->uri->segment(4);
		switch($action) {
			case 'save' :
				{
					$this->showTree();
					// Default values:
					$idContent  = $this->input->post('id');
					$idParent   = $this->input->post('parent');
					$idTemplate = $this->input->post('template');
					$contentData = $this->AdminModel->getContentData($idContent, $idParent, $idTemplate);
					// Adjust the contentData according to the parameters:
					$contentData['id_template'] = $idTemplate;
					$contentData['name']        = $this->makeSafe($this->input->post('name'));
					$contentData['alias']       = $this->input->post('alias');
					$contentData['order']		= $this->input->post('order');
					if(empty($contentData['name'])) { $contentData['name'] = 'Untitled'; }
					// Check if the parent is not a descendant of this content and if the parent is not itself:					
					if(!$this->AdminModel->checkDescendant($idContent, $idParent) && $idContent != $idParent) {
						$contentData['id_content']  = $idParent;		// id_content is the parent of this content
					}
					// Get the values:
					for($item=0; $item<count($contentData['content']); $item++) {
						if($contentData['content'][$item]['multilanguage']==1) {
							$iterations = count($contentData['languages']);
						} else {
							$iterations = 1;
						}						
						for($i=0; $i<$iterations; $i++) {
							$languageID = $contentData['content'][$item]['multilanguage']==1 ? $contentData['languages'][$i]['id'] : 0;	// 0 stands for non-multilanguage
							$type       = $contentData['content'][$item]['type'];
							// Store the value in the array:
							for($j=0; $j < count($contentData['content'][$item]['value']); $j++) {
								if($contentData['content'][$item]['value'][$j]['id_language']==$languageID || $languageID==0) {
									$name       = 'input_'.$contentData['content'][$item]['id_option'].'_'.$languageID;
									switch($type) {
										case 'boolean' :
										{
											$value = isset($_POST[$name]) ? 1 : 0;
											break;
										}
										case 'selectbox' :
										{
											$values = explode('||', $contentData['content'][$item]['default_value']);
											$valueArray = array();
											foreach($values as $option) {
												$optionArray = explode('==', $option);
												$optionName  = $optionArray[0];
												$optionValue = count($optionArray)==1 ? $optionArray[0] : $optionArray[1];
												if(isset($_POST[$name.'_'.md5($optionValue)])) {
													array_push($valueArray, $optionValue);
												}
											}
											$value = implode(';', $valueArray);
											break;
										}
										case 'rich_text' :
										{
											// Rich text already has it's entities converted, and html-tags are allowed:
											$value = isset($_POST[$name]) ? $this->input->post($name) : '';											
											break;
										}
										case 'date' :
										{
											// TODO: Should date be formatted to timestamp?
											$value = isset($_POST[$name]) ? $this->makeSafe($this->input->post($name)) : '';
											break;
										}										
										default:
										{
											$value = isset($_POST[$name]) ? $this->makeSafe($this->input->post($name)) : '';
											break;
										}
									}
									$contentData['content'][$item]['value'][$j]['value'] = $value;
								}
							}
						}
					}
					// All the values are retreived, now save the data:
					$idContent = $this->AdminModel->saveContentData($idContent, $contentData);
					// Execute external module-commands:
					$modules   = $this->AdminModel->getModules();
					foreach($modules as $module) {
						$moduleName = strtolower($module['name']);
						$path = 'system/application/modules/'.$moduleName.'/'.$moduleName.'.content.save.php';
						if(file_exists($path)) {			
							include_once($path);			
						}
					}
					// See if this action was send using ajax:
					if(isset($_POST['ajax'])) {
						echo '1;'.$this->lang->line('content_stored');
						die();
					} else {
						// Redirect to the editing-page:
						redirect(site_url(array('admin', 'content', 'edit', $idContent)));
					}
					break;
				}
			case 'add' :
				{
					$this->showTree();
					$id_template = $this->uri->segment(5);
					if($id!==false && $id_template!==false) {
						// In this case, $id is the parent.
						$contentData = $this->AdminModel->getContentData(0, $id, $id_template);
						$data = array(
							'lang'=>$this->lang,
							'contentData'=>$contentData,
							// 'templates'=>$this->AdminModel->getTableData('templates', 'id,name,templatefile'),
							'templates'=>$this->AdminModel->getAvailableTemplates($id, true),
							'title'=>$this->lang->line('title_add_content'),
							'allowedTemplates'=>$this->AdminModel->getAllowedTemplates($this->rank),
							'settings'=>$this->settings,
							'modules'=>$this->AdminModel->getModules()
						);
						$this->load->view('admin/content/add_edit.php', $data);
					}
					break;
				}
			case 'edit' :
				{
					$this->showTree();
					if($id!=false) {
						$contentData = $this->AdminModel->getContentData($id);
						$data = array(
							'lang'=>$this->lang,
							'contentData'=>$contentData,
							// 'templates'=>$this->AdminModel->getTableData('templates', 'id,name,templatefile'),
							'templates'=>$this->AdminModel->getAvailableTemplates($id),
							'title'=>$this->lang->line('title_modify_content'),
							'allowedTemplates'=>$this->AdminModel->getAllowedTemplates($this->rank),
							'settings'=>$this->settings,
							'modules'=>$this->AdminModel->getModules()
						);
						$this->load->view('admin/content/add_edit.php', $data);
					}
					break;
				}
			case 'duplicate' :
				{
					if($id!=false) {
						$this->AdminModel->duplicateContent($id);
					}
					$this->showTree();
					$this->showDashBoard();
					break;
				}
			case 'move' :
				{
					if($id!=false) {
						$contentData = $this->AdminModel->getContentData($id);
						// Change the parent:
						$contentData['id_content'] = $this->input->post('id_content');
						$this->AdminModel->saveContentData($id, $contentData);
						die();	// Function can die here, this action is done with AJAX
					}
					break;
				}
			case 'delete' :
				{
					if($id!=false) {
						$this->AdminModel->deleteContent($id);
					}
					$this->showTree();
					$this->showDashBoard();
					break;
				}
			case 'root' :
				{
					$this->showTree();
					$data = array(
						'lang'=>$this->lang,
						'templates'=>$this->AdminModel->getRootTemplates(),
						'allowedTemplates'=>$this->AdminModel->getAllowedTemplates($this->rank)
					);
					$this->load->view('admin/content/new_content.php', $data);
					break;
				}
			default :
				{
					// Not a valid action
					$this->showNotFound();
					break;
				}
		}
		$this->showFooter();
	}
	
	/**
	 * Show the site settings
	 */
	function settings()
	{
		$action = $this->uri->segment(3);
		if($action=='save') {
			// Save the settings:
			$settings = array();
			foreach($_POST as $key=>$value) {
				$settings[$key] = $this->makeSafe($this->input->post($key));
			}
			$this->AdminModel->saveSettings($settings);
			redirect(site_url(array('admin')));
		}
		$this->showHeader();
		$this->showTree();
		$data = array(
			'lang'=>$this->lang,
			'tree'=>$this->AdminModel->getTree(),
			'settings'=>$this->AdminModel->getSettings(),
			'languages'=>$this->AdminModel->getLanguages()
		);
		$this->load->view('admin/settings.php', $data);
		$this->showFooter();
	}
	
	/**
	 * Show the initial tree
	 */
    function showTree()
	{
		$data = array(
			'lang'=>$this->lang,
			'tree'=>$this->AdminModel->getTree(),
			'sitename'=>$this->settings['site_name']
		);
		$this->load->view('admin/tree.php', $data);
	}
	
	/**
	 * Show the header
	 */
	function showHeader()
    {
        $data = array(
            'lang'=>$this->lang,
			'rank'=>$this->AdminModel->getRank($this->rank),
			'modules'=>$this->AdminModel->getModules(),
			'allowedModules'=>$this->AdminModel->getRankModules($this->rank)
        );		
		$this->load->view('admin/header.php', $data);
    }
    
	/**
	 * Show the dashboard
	 */
	function showDashBoard()
	{
        $data = array(
            'lang'=>$this->lang
        );
        $this->load->view('admin/dashboard.php', $data);
	}
	
	/**
	 * Show the footer
	 */
    function showFooter()
    {
        $data = array(
            'lang'=>$this->lang,
			'version'=>$this->config->item('version')
        );
		$this->load->view('admin/footer.php', $data);
    }
    
	/**
	 * Show the not-found page
	 */
	function showNotFound()
	{
		$data = array(
			'lang'=>$this->lang
		);
        $this->load->view('admin/manage/notfound.php', $data);
	}
	
	function showMessages()
	{
		
		$data = array(
			'messages'=>$this->messages
		);		
		$this->load->view('admin/messages.php', $data);		
	}
	
	/**
	 * Show the file browser:
	 */
	function browser()
	{
		$data = array(
			'lang'=>$this->lang
		);
		$action = $this->uri->segment(3);
		if($action!=false) {			
			switch($action) {
				case 'files' :
					{
						$data['path'] = $this->uri->segment(4);
						$this->load->view('admin/browser/files.php', $data);
						break;
					}
				case 'delete' :
					{
						$fileName = decodeFileName($this->uri->segment(4));
						// Delete file:
						unlink($fileName);
						// Delete thumb:
						$a         = explode('/', $fileName);
						$file  	   = $a[count($a)-1];
						$a         = glob('system/cache/thumbs/'.$file.'*.*');						
						unlink($a[0]);
						// Redirect back to the browser:
						redirect(site_url(array('admin', 'browser')));
						break;
					}
				case 'newfolder' :
					{
						$currentFolder = $this->uri->segment(4);
						$name          = $this->uri->segment(5);
						$this->AdminModel->createFolder(str_replace('-', '/', $currentFolder).'/'.$name);
						break;
					}
				case 'upload' :
					{
						$folder = str_replace('-', '/', $_POST['folder']);
						$this->AdminModel->storeUpload($_FILES['uploadField'], $folder);
						redirect(site_url(array('admin', 'browser')));
						break;
					}
			}
		} else {
			$this->load->view('admin/browser/browser.php', $data);
		}
	}
	
	/**
	 * Users:
	 */
	function users()
	{
		$this->showHeader();
		$this->showTree();
		$data = array(
			'lang'=>$this->lang			
		);		
		$action = $this->uri->segment(3);
		if($action!=false) {
			switch($action) {
				case 'save' :
					{
						$id = $this->input->post('id');
						if($id!==false) {
							$data = $this->AdminModel->getData('users', $id);
							$data['username'] = $this->makeSafe($this->input->post('username'));
							$data['name']     = $this->makeSafe($this->input->post('name'));
							$data['email']    = $this->makeSafe($this->input->post('email'));
							$data['id_rank']  = $this->input->post('id_rank');
							if($this->input->post('password')!='') {
								if($this->input->post('password')==$this->input->post('password_check')) {
									$data['password'] = md5($this->input->post('password'));
								} else {
									// Passwords do not match!
									$this->addMessage('error', 'passwords_no_match');
									break;
								}
							} else {
								// Password cannot be empty for a new user:
								if($id==0) {
									$this->addMessage('error', 'empty_password');
									break;
								}
							}
							$this->AdminModel->saveData('users', $data, $id);
						}
						redirect(site_url(array('admin', 'users')));
						break;
					}
				case 'add' :
					{
						$data['user'] = $this->AdminModel->getData('users', 0);
						$data['ranks'] = $this->AdminModel->getRanks();
						$this->load->view('admin/users/add_edit.php', $data);
						break;
					}
				case 'edit' :
					{
						$id = $this->uri->segment(4);
						if($id!=false) {
							$data['user'] = $this->AdminModel->getData('users', $id);
							$data['ranks'] = $this->AdminModel->getRanks();
							$data['user']['password'] = '';		// When editing, leave the password empty.
							$this->load->view('admin/users/add_edit.php', $data);
						}
						break;
					}
				case 'delete' :
					{
						$id = $this->uri->segment(4);						
						if($id!=false && $id!=1) {
							$this->AdminModel->deleteData(array('users'=>'id'), $id);
						} else {
							$this->addMessage('error', 'message_delete_admin');
						}
						redirect(site_url(array('admin', 'users')));
						break;
					}
			}
		} else {
			// Show default browser:
			$data['users'] = $this->AdminModel->getUsers();
			$this->load->view('admin/users/browse.php', $data);
		}
		// Show the footer:
		$this->showFooter();
	}
	
	/**
	 * Ranks:
	 */
	function ranks()
	{
		$this->showHeader();
		$this->showTree();
		$this->showMessages();
		$data = array(
			'lang'=>$this->lang			
		);		
		$action = $this->uri->segment(3);
		if($action!=false) {
			switch($action) {
				case 'save' :
					{
						$id = $this->input->post('id');
						$data = $this->AdminModel->getData('ranks', $id);
						// Adjust the data:
						$data['name'] = $this->makeSafe($this->input->post('name'));
						$data['system'] = isset($_POST['system']) ? 1 : 0;
						$data['users'] = isset($_POST['users']) ? 1 : 0;
						$data['ranks'] = isset($_POST['ranks']) ? 1 : 0;
						$data['configuration'] = isset($_POST['configuration']) ? 1 : 0;
						// Store the data:
						$id = $this->AdminModel->saveData('ranks', $data, $id);
						// Save the modules-links:
						$modules = array();
						foreach($_POST as $key=>$value) {
							if(substr($key, 0, 7)=='module_') {
								$a = explode('_', $key);
								array_push($modules, $a[1]);
							}
						}
						$this->AdminModel->saveRankModules($id, $modules);
						// Redirect:
						redirect(site_url(array('admin', 'ranks')));
						break;
					}
				case 'add' :
					{
						$data['rank']    = $this->AdminModel->getData('ranks', 0);
						$data['modules'] = $this->AdminModel->getModules();
						$this->load->view('admin/ranks/add_edit.php', $data);
						break;
					}
				case 'edit' :
					{
						$id = $this->uri->segment(4);
						if($id!=false) {
							$data['rank']    = $this->AdminModel->getData('ranks', $id);
							$data['modules'] = $this->AdminModel->getModules();
							$this->load->view('admin/ranks/add_edit.php', $data);
						}
						break;
					}				
				case 'duplicate' :
					{
						$id = $this->uri->segment(4);
						if($id!=false) {
							// Duplicate the rank:
							$rank = $this->AdminModel->getData('ranks', $id);
							$rank['id'] = 0;	// Set ID to 0 to indicate that this is a new rank
							$newId = $this->AdminModel->saveData('ranks', $rank, 0);							
							// Duplicate the rights that are attached to this rank:
							$templates = $this->AdminModel->getAllowedTemplates($id);
							$this->AdminModel->saveAllowedTemplates($newId, $templates);
						}
						redirect(site_url(array('admin', 'ranks')));
						break;
					}
				case 'delete' :
					{
						$id = $this->uri->segment(4);
						// ID can also not be 1, because that is the administrators rank:						
						if($id!=false && $id!=1) {							
							$users = $this->AdminModel->getUsersUsingRank($id);
							if(count($users) == 0) {
								$this->AdminModel->deleteData(array('ranks'=>'id', 'templates_ranks'=>'id_rank'), $id);
							} else {
								// Send message (There are users using this rank)
								$this->addMessage('error', 'users_using_rank');
							}
						} else {
							// Send message (Administrator rank cannot be deleted)
							$this->addMessage('error', 'delete_admin_rank');
						}
						redirect(site_url(array('admin', 'ranks')));
						break;
					}
			}
		} else {
			// Show default browser:
			$data['ranks'] = $this->AdminModel->getRanks();
			$this->load->view('admin/ranks/browse.php', $data);
		}
		// Show the footer:
		$this->showFooter();
	}
	
	/**
	 * Make a string safe (strip tags and convert html entities)
	 * @param	$str	string	The string to convert
	 * @return	string			The 'safe' string
	 */
	function makeSafe($str)
	{
		return htmlentities(strip_tags($str), ENT_QUOTES, 'UTF-8');
	}
	
	/**
	 * Add a message to the system
	 * @param	$type		string	The type of message (info,ok,error)
	 * @param	$message	string	The message itself (from admin_lang.php)
	 */
	function addMessage($type, $message)
	{
		$messages = $this->session->userdata('messages');
		array_push($messages, array('type'=>$type, 'message'=>$this->lang->line('message_'.$message)));
		$this->session->set_userdata('messages', $messages);		
	}
	
	/**
	 * Show a module
	 */
	function module()
	{
		$this->showHeader();
		$this->showTree();
		$this->showMessages();
		// Load the module:
		$alias = $this->uri->segment(3);
		
		if($alias!=false) {
			// Store the parameters:
			$parameters    = array();
			$totalSegments = $this->uri->total_segments();
			if($totalSegments > 3) {
				for($i=4; $i<=$totalSegments; $i++) {
					array_push($parameters, $this->uri->segment($i));
				}
			}
			// TODO: Optimize this?
			$modules = $this->AdminModel->getModules();
			foreach($modules as $module) {				
				if($module['alias']==$alias) {
					// Create dataobject:
					$data = array(
						'info'=>$module,
						'parameters'=>$parameters,
						'settings'=>$this->AdminModel->getSettings()
					);
					$this->load->view('admin/modules/top.php');
					$this->load->view('../../../assets/modules/'.$module['folder'].'/'.$module['file'], $data);
					$this->load->view('admin/modules/bottom.php');
				}
			}
		} else {
			// TODO: Show 'module not found'-screen
		}
		// Show the footer:
		$this->showFooter();
	}
}
?>