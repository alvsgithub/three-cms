<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'languages')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('system_language_name'); ?></th>
					<td><input type="text" name="name" value="<?php echo $values['name']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_language_code'); ?></th>
					<td><input type="text" name="code" value="<?php echo $values['code']; ?>" maxlength="2" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_language_active'); ?></th>
					<td>
						<?php $checked = $values['active']==1 ? 'checked="checked"' : ''; ?>
						<input type="checkbox" name="active" <?php echo $checked; ?> />
					</td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>
						<input type="hidden" name="id" value="<?php echo $values['id']; ?>" />
						<input type="submit" value="<?php echo $lang->line('button_save'); ?>" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>