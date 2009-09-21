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
    
	function templates()
	{
		
	}
	
	function dataobjects()
	{
		
	}
	
	function options()
	{
        $this->showHeader();
		$this->showTree();
		$action = $this->uri->segment(3);
		$id     = $this->uri->segment(4);
		
		// Language part
		// See if there should be something saved:
		if($this->input->post('id')!==false) {			
			$data = array(
				'id'=>$this->input->post('id'),
				'name'=>$this->input->post('name'),
				'type'=>$this->input->post('type'),
				'default_value'=>$this->input->post('default_value'),
				'multilanguage'=>isset($_POST['multilanguage']) ? 1 : 0
			);
			$this->AdminModel->saveOption($data);
			redirect(site_url(array('admin', 'manage', 'options')));
		}
		// See if there should be something deleted:
		if($action=='delete') {
			if($id!=false) {
				$this->AdminModel->deleteOption($id);
				redirect(site_url(array('admin', 'manage', 'options')));
			}
		}
		// See if there should be something duplicated:
		if($action=='duplicate') {
			if($id!=false) {
				$this->AdminModel->duplicateOption($id);
				redirect(site_url(array('admin', 'manage', 'options')));
			}
		}
		// Show the languages form:
		$name = $this->lang->line('name_option');
		$data = array(
			'lang'=>$this->lang
		);
		if($id==false) {
			$title = str_replace('%s', $name, $this->lang->line('title_add_new_item'));
		} else {
			$title = str_replace('%s', $name, $this->lang->line('title_modify_item'));
		}
		$data['title']  = $title;
		$data['values'] = $this->AdminModel->getOption($id);
		$this->load->view('admin/options/add_edit.php', $data);
		// End languages part
		
        $this->showFooter();
	}
	
	function languages()
	{
        $this->showHeader();
		$this->showTree();
		$action = $this->uri->segment(3);
		$id     = $this->uri->segment(4);
		
		// Language part
		// See if there should be something saved:
		if($this->input->post('id')!==false) {			
			$data = array(
				'id'=>$this->input->post('id'),
				'name'=>$this->input->post('name'),
				'code'=>$this->input->post('code'),
				'active'=>isset($_POST['active']) ? 1 : 0
			);
			$this->AdminModel->saveLanguage($data);
			redirect(site_url(array('admin', 'manage', 'languages')));
		}
		// See if there should be something deleted:
		if($action=='delete') {
			if($id!=false) {
				$this->AdminModel->deleteLanguage($id);
				redirect(site_url(array('admin', 'manage', 'languages')));
			}
		}
		// See if there should be something duplicated:
		if($action=='duplicate') {
			if($id!=false) {
				$this->AdminModel->duplicateLanguage($id);
				redirect(site_url(array('admin', 'manage', 'languages')));
			}
		}
		// Show the languages form:
		$name = $this->lang->line('name_language');
		$data = array(
			'lang'=>$this->lang
		);
		if($id==false) {
			$title = str_replace('%s', $name, $this->lang->line('title_add_new_item'));
		} else {
			$title = str_replace('%s', $name, $this->lang->line('title_modify_item'));
		}
		$data['title']  = $title;
		$data['values'] = $this->AdminModel->getLanguage($id);
		$this->load->view('admin/languages/add_edit.php', $data);
		// End languages part
		
        $this->showFooter();
	}
	
	function locales()
	{
		
	}
	
    /**
     * Default scaffolding functionality
     */
    function scaffold()
    {
        $this->showHeader();
		$this->showTree();
        // Get the item to scffold:
        $tableName = $this->uri->segment(3);
        $action    = $this->uri->segment(4);
        // See if there is a POST done:
        if(!empty($_POST)) {
			// See if there was a subForm:
			if($this->input->post('subForm')!=false) {
				
			}
            $this->AdminModel->scaffoldSave();
        } else {
            if($action!=false) {
                switch($action) {
                    case 'add' :
                        {
                            // TODO: Add functionality
                            $this->addModify($tableName);
                            break;
                        }
                    case 'edit' :
                        {
                            // TODO: Edit functionality
                            $id = $this->uri->segment(5);
                            $id = $id != false ? $id : 0;
                            $this->addModify($tableName, $id);
                            break;
                        }
                    /*
                    case 'delete' :
                        {
                            // TODO: Delete functionality
                            $this->delete($tableName);
                            break;
                        }
                    case 'duplicate' :
                        {
                            // TODO: Duplicate functionality
                            $this->duplicate($tableName);
                            break;
                        }
                    */
                }
            } else {
                $data = array(
                    'lang'=>$this->lang
                );
                $this->load->view('admin/manage/notfound.php', $data);
            }
        }
        $this->showFooter();
    }
    
    /**
     * Show the add- or modify form, based on scaffolding technique
     * @param   $tableName  string  The name of the table
     * @param   $id         int     The id (in case of modify)
     */
	function addModify($tableName, $id=0)
	{
		switch($tableName) {
			case 'templates' :
				{
                    $scaffoldData = $this->AdminModel->createScaffoldTable('templates', 'name,id_dataobject,templatefile', 'templates', $id);
                    $name         = $this->lang->line('name_template');
					$subForm      = false;
					break;
				}
			case 'dataobjects' :
				{
                    $scaffoldData = $this->AdminModel->createScaffoldTable('dataobjects', 'name', 'dataobjects', $id);
                    $name         = $this->lang->line('name_data_object');
					$subForm      = false;
					break;
				}
			case 'options' :
				{
                    $scaffoldData = $this->AdminModel->createScaffoldTable('options', 'name,type,multilanguage', 'options', $id);
                    $name         = $this->lang->line('name_option');
					$subForm      = false;
					break;
				}
			case 'languages' :
				{
                    $scaffoldData = $this->AdminModel->createScaffoldTable('languages', 'name,code,active', 'languages', $id);
                    $name         = $this->lang->line('name_language');
					$subForm      = false;
					break;
				}
			case 'locales' :
				{
					$scaffoldData = $this->AdminModel->createScaffoldTable('locales', 'name', 'locales', $id);
					$name         = $this->lang->line('name_locale');
					$subForm      = $this->AdminModel->getLocaleTable($id);
					break;
				}
		}
		if($id==0) {
			$title = str_replace('%s', $name, $this->lang->line('title_add_new_item'));
		} else {
			$title = str_replace('%s', $name, $this->lang->line('title_modify_item'));
		}
        // Add language:
        $scaffoldData['lang']    = $this->lang;
        $scaffoldData['title']   = $title;
		$scaffoldData['subForm'] = $subForm;

        // Load the scaffolding view:
        if(isset($scaffoldData)) {
            $this->load->view('admin/manage/scaffold.php', $scaffoldData);
        }
	}
	
	/*
	function modify($tableName)
	{
		
	}
	*/
	
	function duplicate()
	{
		
	}
	
	function delete()
	{
		
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