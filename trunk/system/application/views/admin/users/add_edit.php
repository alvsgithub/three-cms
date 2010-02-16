<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'users', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('users_username'); ?>:</th>
					<td><input type="text" name="username" value="<?php echo $user['username']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('users_rank'); ?>:</th>
					<td>
						<select name="id_rank">
							<?php
								foreach($ranks as $rank) {
									echo '<option value="'.$rank['id'].'" ';
									echo $user['id_rank']==$rank['id'] ? ' selected="selected"' : '';
									echo '>'.$rank['name'].'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('users_password'); ?>:</th>
					<td><input type="password" name="password" value="" /> <em>Leave empty if you wish not to change the password!</em></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('users_password_again'); ?>:</th>
					<td><input type="password" name="password_check" value="" /></td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('users_name'); ?>:</th>
					<td><input type="text" name="name" value="<?php echo $user['name']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('users_email'); ?>:</th>
					<td><input type="text" name="email" value="<?php echo $user['email']; ?>" /></td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>
						<input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
						<input type="submit" value="<?php echo $lang->line('button_save'); ?>" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>