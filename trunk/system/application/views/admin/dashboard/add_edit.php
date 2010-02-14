<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<?php
			// Quick inline function:
			function isSelected($a, $b)
			{
				return $a==$b ? ' selected="selected" ' : '';
			}
		?>
		<form method="post" action="<?php echo site_url(array('admin', 'dashboard', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('system_dashboard_name'); ?></th>
					<td><input type="text" name="name" value="<?php echo $values['name']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_dashboard_type'); ?></th>
					<td>
						<select name="type">
							<option value="from_parent" <?php echo isSelected($values['type'], 'from_parent').'>'.$lang->line('system_dashboard_from_parent'); ?></option>
							<option value="from_template" <?php echo isSelected($values['type'], 'from_template').'>'.$lang->line('system_dashboard_from_template'); ?></option>
							<option value="from_addon" <?php echo isSelected($values['type'], 'from_addon').'>'.$lang->line('system_dashboard_addon'); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_dashboard_source'); ?></th>
					<td><input type="text" name="source" value="<?php echo $values['source']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_dashboard_headers'); ?></th>
					<td><input type="text" name="headers" value="<?php echo $values['headers']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_dashboard_count'); ?></th>
					<td><input type="text" name="count" value="<?php echo $values['count']; ?>" /></td>
				</tr>				
				<tr>
					<th><?php echo $lang->line('system_dashboard_column'); ?></th>
					<td>
						<select name="column">
							<option value="left" <?php echo isSelected($values['type'], 'left').'>'.$lang->line('system_dashboard_left'); ?></option>
							<option value="right" <?php echo isSelected($values['type'], 'right').'>'.$lang->line('system_dashboard_right'); ?></option>
						</select>
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