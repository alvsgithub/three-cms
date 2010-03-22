<hr />
<?php
    if(!isset($_POST['install'])) {
?>
<p>It seems that this is the first time you are using the web users module.</p>
<form method="post" action="<?php $this->createLink(array('webusers')); ?>" />
    <input type="submit" value="Click here to install" name="install" />
</form>
<?php
    } else {
        // Install:
        
        // Webusers table:
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
        
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('webusers', true);
        
        // Webuser groups:
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'auto_increment' => true
            ),
            'name' => array(
                'type' => 'TINYTEXT'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('webusers_groups', true);
        
        // Linkage between webusers and webuser-groups:
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'auto_increment' => true
            ),
            'id_user' => array(
                'type' => 'INT'
            ),
            'id_group' => array(
                'type' => 'INT'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('webusers_user_group', true);        
        
        // Linkage between groups and content:
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'auto_increment' => true
            ),
            'id_content' => array(
                'type' => 'INT'
            ),
            'id_group' => array(
                'type' => 'INT'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('webusers_content_group', true);        
        
        echo '<p>Module successfully installed...</p>';
        echo '<p><a href="'.$this->createLink(array('webusers')).'">Click here to go to the module</a></p>';
    }
?>