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
                case 'add' :
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
                    include_once('form.php');
                    break;
                case 'edit' :
                    if(isset($parameters[1])) {
                        $this->db->where('id', $parameters[1]);
                        $query   = $this->db->get('webusers');
                        $details = $query->result_array();
                        if(count($details) == 1) {
                            $details = $details[0];
                            include_once('form.php');
                        }
                    }
                    break;
                case 'delete' :
                    include_once('delete.php');
                    break;
            }
        }
    }
?>