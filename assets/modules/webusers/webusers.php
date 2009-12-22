<h1>Web Users</h1>
<?php
    // First, check to see if the webusers-table exists:
    if(!$this->db->table_exists('webusers')) {
        include_once('install.php');
    } else {
        if(count($parameters)==0) {
            include_once('main.php');
        } else {
            switch($parameters[0]) {
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
                    if(isset($parameters[1])) {
                        $this->db->where('id', $parameters[1]);
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
                    if(isset($parameters[1])) {
                        $this->db->where('id', $parameters[1]);
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
?>