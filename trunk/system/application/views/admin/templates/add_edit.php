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
				<tr>
					<th><?php echo $lang->line('system_template_root'); ?>:</th>
					<td><input type="checkbox" name="root" <?php echo $values['root']==1 ? ' checked="checked" ' : ''; ?> /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_template_type'); ?>:</th>
					<td>
						<select name="type">
							<option value="page" <?php echo $values['type']=='page' ? ' selected="selected" ' : ''; ?>><?php echo $lang->line('system_template_type_page'); ?></option>
							<option value="content" <?php echo $values['type']=='content' ? ' selected="selected" ' : ''; ?>><?php echo $lang->line('system_template_type_content'); ?></option>
						</select>
					</td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_template_allowed'); ?>:</th>
					<td>
						<?php
							foreach($childTemplates as $item) {
								$checked = $item['allowed'] ? ' checked="checked"' : '';
								echo '<label class="allowed"><input type="checkbox" name="allow_template_'.$item['id'].'" '.$checked.' /> '.$item['name'].'</label>';
							}
						?>
					</td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_template_ranks'); ?>:</th>
					<td class="templateRanks">
						<?php
							function chk($val)
							{
								if($val==1) {
									return ' checked="checked" ';
								} else {
									return false;
								}
							}
							
							foreach($ranks as $rank) {
								$a = $rank['allowed'];
								echo '<strong>'.$rank['name'].':</strong><br />';
								echo '<label><input type="checkbox" name="visible_'.$rank['id'].'" '.  chk($a['visible']).' /> '.  $lang->line('action_visible').' </label>';
								echo '<label><input type="checkbox" name="add_'.$rank['id'].'" '.      chk($a['add']).' /> '.      $lang->line('action_add').' </label>';
								echo '<label><input type="checkbox" name="modify_'.$rank['id'].'" '.   chk($a['modify']).' /> '.   $lang->line('action_modify').' </label>';
								echo '<label><input type="checkbox" name="duplicate_'.$rank['id'].'" '.chk($a['duplicate']).' /> '.$lang->line('action_duplicate').' </label>';
								echo '<label><input type="checkbox" name="move_'.$rank['id'].'" '.     chk($a['move']).' /> '.     $lang->line('action_move').' </label>';
								echo '<label><input type="checkbox" name="delete_'.$rank['id'].'" '.   chk($a['delete']).' /> '.   $lang->line('action_delete').' </label>';
								echo '<br /><br />';
							}
						?>
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