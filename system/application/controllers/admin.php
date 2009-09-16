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
		
        // See if the user is logged in:
        $this->loggedIn = $this->session->userdata('loggedIn');
        
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
        // By default, load the dashboard:
        $this->load->view('admin/dashboard.php');
        $this->showFooter();
    }
    
    /*
    function dataobjects()
    {
        $this->showHeader();
        $this->load->view('admin/dataobjects.php');
        $this->showFooter();
    }
    
    function options()
    {
        $this->showHeader();
        $this->load->view('admin/options.php');
        $this->showFooter();
    }
    
    function languages()
    {
        $this->showHeader();
        $this->load->view('admin/languages.php');
        $tableData = $this->AdminModel->getTableData('languages', 'id,name,code,active');
        $data = array(
            'tableData'=>$tableData,
            'tableHeaders'=>array('id', 'name', 'code', 'active'),
            'action'=>'languages'
        );
        $this->load->view('admin/default/table.php', $data);
        $this->showFooter();
    }
    */
    function manage()
    {
        $this->showHeader();
        // Get the item to manage:
        $action = $this->uri->segment(3);
        
        // TODO: Add functionality
        
        // TODO: Edit functionality
        
        // TODO: Delete functionality
        
        // Show the data:
        switch($action) {
            case 'dataobjects':
                {
                    $title          = 'Data Objects';
                    $tableData      = $this->AdminModel->getTableData('dataobjects', 'id,name');
                    $tableHeaders   = array('id', 'name');
                    break;
                }
            case 'options' :
                {
                    $title          = 'Options';
                    $tableData      = $this->AdminModel->getTableData('options', 'id,name,type,multilanguage');
                    $tableHeaders   = array('id', 'name', 'type', 'multilanguage');
                    break;
                }
            case 'languages' :
                {
                    $title          = 'Languages';
                    $tableData      = $this->AdminModel->getTableData('languages', 'id,name,code,active');
                    $tableHeaders   = array('id', 'name', 'code', 'active');
                    break;
                }
            case 'locales' :
                {
                    $title          = 'Locales';
                    $tableData      = $this->AdminModel->getTableData('locales', 'id,name');
                    $tableHeaders   = array('id', 'name');
                    break;
                }
        }
        $data = array(
            'tableData'=>$tableData,
            'tableHeaders'=>$tableHeaders,
            'action'=>$action,
            'title'=>$title
        );
        $this->load->view('admin/default/table.php', $data);
        $this->showFooter();
    }
    
    /*
    function locales()
    {
        $this->showHeader();
        $this->load->view('admin/locales.php');
        $this->showFooter();
    }
    */
    function showHeader()
    {
		// Show the header:
		$this->load->view('admin/header.php');
    }
    
    function showFooter()
    {
        // Show the footer:
		$this->load->view('admin/footer.php');
    }
    
}
?>