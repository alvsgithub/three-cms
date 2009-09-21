<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'templates', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('system_template_name'); ?>:</th>
					<td><input type="text" name="name" value="<?php echo $values['name']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_template_dataobject'); ?>:</th>
					<td>
						<select name="id_dataobject">
							<?php
								foreach($dataObjects as $dataObject) {
									echo '<option value="'.$dataObject['id'].'"';
									if($dataObject['id']==$values['id_dataobject']) { echo ' selected="selected"'; }
									echo '>'.$dataObject['name'].'</option>'."\n";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_template_file'); ?>:</th>
					<td><input type="text" name="templatefile" value="<?php echo $values['templatefile']; ?>" /></td>
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