<hr />
<?php
    if(!isset($_POST['install'])) {
?>
<p>It seems that this is the first time you are using the web users module.</p>
<form method="post" action="<?php echo moduleCreateLink(array('webusers')); ?>" />
    <input type="submit" value="Click here to install" name="install" />
</form>
<?php
    } else {
        // Install:
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
        $this->dbforge->create_table('webusers');
        echo '<p>Module successfully installed...</p>';
        echo '<p><a href="'.moduleCreateLink(array('webusers')).'">Click here to go to the module</a></p>';
    }
?>