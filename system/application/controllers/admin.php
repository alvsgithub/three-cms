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
        $todo   = $this->uri->segment(4);
        
        if($todo!=false) {
            switch($todo) {
                case 'add' :
                    {
                        // TODO: Add functionality
						$this->addModify($action);
                        break;
                    }
                case 'edit' :
                    {
                        // TODO: Edit functionality
						$id = $this->uri->segment(5);
						$id = $id != false ? $id : 0;
						$this->addModify($action, $id);
                        break;
                    }
                case 'delete' :
                    {
                        // TODO: Delete functionality
						$this->delete($action);
                        break;
                    }
                case 'duplicate' :
                    {
                        // TODO: Duplicate functionality
						$this->duplicate($action);
                        break;
                    }                    
            }
        }
        
        // Show the data:
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
    
	function addModify($tableName, $id=0)
	{
		switch($tableName) {
			case 'templates' :
				{
					
					break;
				}
			case 'dataobjects' :
				{
					
					break;
				}
			case 'options' :
				{
					
					break;
				}
			case 'languages' :
				{
                    $this->AdminModel->createScaffoldTable('languages','name,code,active', $id);
					break;
				}
			case 'locales' :
				{
					
					break;
				}
		}
	}
	
	/*
	function modify($tableName)
	{
		
	}
	*/
	
	function duplicate($tableName)
	{
		
	}
	
	function delete($tableName)
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