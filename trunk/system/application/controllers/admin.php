<?php
class Admin extends Controller
{
    private $loggedIn;
    
    function Admin()
    {
        parent::Controller();
        
		// Load the Session library:
		$this->load->library('session');
        
		// Load the URL helper:
		$this->load->helper('url');
		
        // Load the Language Class:
        $this->lang->load('admin');
        
        // See if the user is logged in:
        $this->loggedIn = $this->session->userdata('loggedIn');
        
        // Load the adminModel:
        $this->load->model('AdminModel', '', true);
    }
    
    function index()
    {
        // TODO: Create login part
		/*
		if(!$this->loggedIn) {
            $this->load->view('admin/login.php');
        }
		*/
		
        $this->showHeader();
		$this->showTree();
        // By default, load the dashboard:
        $data = array(
            'lang'=>$this->lang
        );
        $this->load->view('admin/dashboard.php', $data);
        $this->showFooter();
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
                    $tableData      = $this->AdminModel->getTableData('templates', 'id,name,templatefile');
                    $tableHeaders   = array('id', 'name', 'templatefile');
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
                    $data = array(
                        'lang'=>$this->lang
                    );
                    $this->load->view('admin/manage/notfound.php', $data);
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
					$data = array(
						'name'=>$this->input->post('name'),
						'id_dataobject'=>$this->input->post('id_dataobject'),
						'templatefile'=>$this->input->post('templatefile')
					);
					$this->AdminModel->saveData('templates', $data, $this->input->post('id'));
					redirect(site_url(array('admin', 'manage', 'templates')));
					break;
				}
			case 'delete' :
				{
					// Delete
					if($id!=false) {
						$this->AdminModel->deleteData(array('templates'=>'id', 'content'=>'id_template'), $id);
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
						'dataObjects'=>$this->AdminModel->getDataObjects()
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
						'name'=>$this->input->post('name'),
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
						'name'=>$this->input->post('name'),
						'type'=>$this->input->post('type'),
						'default_value'=>$this->input->post('default_value'),
						'multilanguage'=>isset($_POST['multilanguage']) ? 1 : 0
					);
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
						'name'=>$this->input->post('name'),
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
						'name'=>$this->input->post('name')
					);
					$id = $this->AdminModel->saveData('locales', $data, $this->input->post('id'));
					echo $id;					
					// Save the language-entries:
					$locales = $this->AdminModel->getLocaleValues($id);
					for($i=0; $i < count($locales); $i++) {
						$locales[$i]['value'] = $this->input->post('language_'.$locales[$i]['id']);
					}
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
							'lang'=>$this->lang							
						);
						$this->load->view('admin/ajax/page_summary.php', $data);
					}
					break;
				}
		}
	}
	
	/**
	 * Show the initial tree
	 */
    function showTree()
	{
		// Show the tree
		$data = array(
			'lang'=>$this->lang,
			'tree'=>$this->AdminModel->getTree()
		);
		$this->load->view('admin/tree.php', $data);
	}
	
	/**
	 * Show the header
	 */
	function showHeader()
    {
		// Show the header:
        $data = array(
            'lang'=>$this->lang
        );
		$this->load->view('admin/header.php', $data);
    }
    
	/**
	 * Show the footer
	 */
    function showFooter()
    {
        // Show the footer:
        $data = array(
            'lang'=>$this->lang
        );
		$this->load->view('admin/footer.php', $data);
    }
    
}
?>