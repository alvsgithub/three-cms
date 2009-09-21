<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'options', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('system_options_name'); ?></th>
					<td><input type="text" name="name" value="<?php echo $values['name']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_options_type'); ?></th>
					<td>
						<select name="type">
							<?php
								function drawOption($name, $lang, $currentType)
								{
									echo '<option value="'.$name.'"';
									if($name==$currentType) { echo ' selected="selected"'; }
									echo '>'.$lang->line('option_'.$name).'</option>'."\n";
								}
								drawOption('small_text', $lang, $values['type']);
								drawOption('large_text', $lang, $values['type']);
								drawOption('rich_text', $lang, $values['type']);
								drawOption('url', $lang, $values['type']);
								drawOption('image', $lang, $values['type']);
								drawOption('file', $lang, $values['type']);
								drawOption('boolean', $lang, $values['type']);
								drawOption('dropdown', $lang, $values['type']);
								drawOption('selectbox', $lang, $values['type']);
								drawOption('date', $lang, $values['type']);
								drawOption('time', $lang, $values['type']);
								drawOption('content', $lang, $values['type']);
								drawOption('content_of_type', $lang, $values['type']);
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_options_default'); ?></th>
					<td><textarea name="default_value"><?php echo $values['default_value']; ?></textarea>
				<tr>
					<th><?php echo $lang->line('system_options_multi'); ?></th>
					<td>
						<?php $checked = $values['multilanguage']==1 ? 'checked="checked"' : ''; ?>
						<input type="checkbox" name="multilanguage" <?php echo $checked; ?> />
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