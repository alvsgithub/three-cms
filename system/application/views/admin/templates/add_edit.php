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
					<td>
						<?php
							foreach($ranks as $rank) {
								$checked  = $rank['allowed'] ? ' checked="checked"' : '';
								$readonly = $rank['id']==1 ? ' disabled="disabled"' : '';
								echo '<label class="allowed"><input type="checkbox" name="allow_rank_'.$rank['id'].'" '.$checked.$readonly.' /> '.$rank['name'].'</label>';
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