<?php
class Admin extends Controller
{
    private $loggedIn;
    
    function Admin()
    {
        parent::Controller();
        
		// Load the Session library:
		$this->load->library('session');
        
        // See if the user is logged in:
        $this->loggedIn = $this->session->userdata('loggedIn');
    }
    
    function index()
    {
        if(!$this->loggedIn) {
            $this->load->view('admin/login.php');
        }
    }
}
?>