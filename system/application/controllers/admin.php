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
    }
    
    function index()
    {
        // TODO: Create login part
		/*
		if(!$this->loggedIn) {
            $this->load->view('admin/login.php');
        }
		*/
		
		
		$this->load->view('admin/header.php');
		$this->load->view('admin/footer.php');
    }
}
?>