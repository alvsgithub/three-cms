<div id="content">
	<div id="innerContent">
        <h1><?php echo $lang->line('users_title'); ?></h1>
		<table>
			<tr>
				<th>ID</th>
				<th><?php echo $lang->line('users_username'); ?></th>
				<th><?php echo $lang->line('users_name'); ?></th>
				<th><?php echo $lang->line('users_email'); ?></th>
				<th><?php echo $lang->line('users_rank'); ?></th>
				<th><?php echo $lang->line('default_actions'); ?></th>
			</tr>
		<?php
			// id, username, password, real name, e-mail
			foreach($users as $user) {
				echo '
					<tr>
						<td>'.$user['id'].'</td>
						<td>'.$user['username'].'</td>
						<td>'.$user['name'].'</td>
						<td><a href="mailto:'.$user['email'].'">'.$user['email'].'</a></td>
						<td>'.$user['rank'].'</td>
						<td>
							<a href="'.site_url(array('admin','users','edit', $user['id'])).'" class="edit">'.$lang->line('action_modify').'</a>
							';
							// <a href="'.site_url(array('admin','users','duplicate', $user['id'])).'" class="duplicate">'.$lang->line('action_duplicate').'</a>
				echo '
							<a href="'.site_url(array('admin','users','delete', $user['id'])).'" class="delete">'.$lang->line('action_delete').'</a>
						</td>
					</tr>
				';
			}		
		?>
		</table>
		<a href="<?php echo site_url(array('admin', 'users', 'add')); ?>" class="add"><?php echo $lang->line('users_add'); ?></a>
	</div>
</div>