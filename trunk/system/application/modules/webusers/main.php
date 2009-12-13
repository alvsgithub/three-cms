<?php
    if(!isset($_POST['save'])) {
?>
<table>
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
                    <a href="'.moduleCreateLink(array("webusers", "edit", $result->id)).'" class="edit" title="Edit this user">Edit</a>
                    <a href="'.moduleCreateLink(array("webusers", "delete", $result->id)).'" class="delete" title="Delete this user">Delete</a>
                </td>
            </tr>
        ';
    }
?>
</table>
<p><a href="<?php echo moduleCreateLink(array("webusers", "add")); ?>" class="button">Add a new webuser</a></p>
<script type="text/javascript">
    $(function(){
        $("a.delete").click(functio(){
            return confirm('Are you sure you want to delete this user? This action cannot be undone!');
        });
    });
</script>
<?php
    } else {        
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
        } else {
            // Existing webuser:
            $this->db->where('id', $id);
            $this->db->update('webusers', $details);
        }
        // Redirect:
        redirect(moduleCreateLink(array('webusers')));
    }
?>