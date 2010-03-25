<?php
    if(!isset($_POST['save'])) {
?>



<!-- Tabmenu: -->
<ul class="tabMenu">
    <li><a href="#" rel="usersTab">Users</a></li>
    <li><a href="#" rel="groupsTab">Groups</a></li>
</ul>



<!-- Tab for users: -->
<div class="tab" id="usersTab">
    <table class="items">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Username</th>
            <th>Blocked</th>
            <th>Actions</th>
        </tr>
    <?php
        // Show the webusers:
        $this->db->select('id,name,email,username,blocked');
        $this->db->order_by('username', 'asc');
        $query = $this->db->get('webusers');
        foreach($query->result() as $result) {
            $blocked = $result->blocked == 1 ? 'yes' : 'no';
            echo '
                <tr>
                    <td>'.$result->id.'</td>
                    <td>'.$result->name.'</td>
                    <td><a href="mailto:'.$result->email.'">'.$result->email.'</a></td>
                    <td>'.$result->username.'</td>
                    <td>'.$blocked.'</td>
                    <td>
                        <a href="'.$this->createLink(array("webusers", "edituser", $result->id)).'" class="edit" title="Edit this user">Edit</a>
                        <a href="'.$this->createLink(array("webusers", "deleteuser", $result->id)).'" class="delete" title="Delete this user">Delete</a>
                    </td>
                </tr>
            ';
        }
    ?>
    </table>
    <p><a href="<?php echo $this->createLink(array("webusers", "adduser")); ?>" class="button">Add a new webuser</a></p>
</div>



<!-- Tab for groups: -->
<div class="tab" id="groupsTab">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Users in group</th>
            <th>Actions</th>
        </tr>
        <?php
        // Show the groups:
        $this->db->select('id,name');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('webusers_groups');
        foreach($query->result() as $result) {
            $pf = $this->db->dbprefix;
            $this->db->select('webusers.username, webusers.id');
            $this->db->from('webusers');
            $this->db->from('webusers_user_group');
            $this->db->where('webusers_user_group.id_group', $result->id);
            $this->db->where('`'.$pf.'webusers`.`id`', '`'.$pf.'webusers_user_group`.`id_user`', false);
            $userQuery = $this->db->get();            
            
            $users = array();
            foreach($userQuery->result() as $userResult) {
                array_push($users, '<a href="'.$this->createLink(array("webusers", "edituser", $userResult->id)).'">'.$userResult->username.'</a>');
            }
            $usersString = implode(', ', $users);
            echo '
                <tr>
                    <td>'.$result->id.'</td>
                    <td>'.$result->name.'</td>
                    <td>'.$usersString.'</td>
                    <td>
                        <a href="'.$this->createLink(array("webusers", "editgroup", $result->id)).'" class="edit" title="Edit this group">Edit</a>
                        <a href="'.$this->createLink(array("webusers", "deletegroup", $result->id)).'" class="delete" title="Delete this group">Delete</a>
                    </td>
                </tr>
            ';
        }
        ?>
    </table>
    <p><a href="<?php echo $this->createLink(array("webusers", "addgroup")); ?>" class="button">Add a new group</a></p>
</div>



<!-- Some custom javascript (jQuery): -->
<script type="text/javascript">
    $(function(){
        $("#usersTab a.delete").click(function(){
            return confirm('Are you sure you want to delete this user? This action cannot be undone!');
        });
        $("#groupsTab a.delete").click(function(){
            return confirm('Are you sure you want to delete this group? All users in this group will also be deleted! This action cannot be undone!');
        });
    });
</script>



<?php
    } else {
        if(isset($_POST['user'])) {
            // Save the user:
            $details = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'postalcode' => $this->input->post('postalcode'),
                'city' => $this->input->post('city'),
                'country' => $this->input->post('country'),
                'telephone' => $this->input->post('telephone'),
                'mobile' => $this->input->post('mobile'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username')
            );
            $details['blocked'] = isset($_POST['blocked']) ? 1 : 0;
            if(!empty($_POST['password'])) {
                $password  = md5($_POST['password']);
                $password2 = md5($_POST['password2']);
                if($password == $password2) {
                    $details['password'] = $password;
                }
            }
            $id = $this->input->post('id');
            if($id==0) {
                // New webuser:
                $this->db->insert('webusers', $details);
                $id = $this->db->insert_id();
            } else {
                // Existing webuser:
                $this->db->where('id', $id);
                $this->db->update('webusers', $details);
            }
            // Save the links between group and users:
            // First delete all the existing links:
            $this->db->delete('webusers_user_group', array('id_user'=>$id));
            // Then save the keys:
            foreach($_POST as $key=>$value) {
                if(substr($key, 0, 6)=='group_') {
                    $a = explode('_', $key);
                    $id_group = $a[1];
                    $this->db->insert('webusers_user_group', array('id_user'=>$id, 'id_group'=>$id_group));
                }
            }
        } elseif(isset($_POST['group'])) {
            // Save the group:
            $details = array(
                'name' => $this->input->post('name')
            );
            $id = $this->input->post('id');
            if($id==0) {
                // New group:
                $this->db->insert('webusers_groups', $details);
                $id = $this->db->insert_id();
            } else {
                // Existing group:
                $this->db->where('id', $id);
                $this->db->update('webusers_groups', $details);
            }
        }
        // Redirect:
        redirect($this->createLink(array('webusers')));
    }
?>