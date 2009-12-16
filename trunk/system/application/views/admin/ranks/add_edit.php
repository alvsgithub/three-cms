<div id="content">
	<div id="innerContent">		
        <h1><?php echo $lang->line('ranks_add'); ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'ranks', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('ranks_name'); ?>:</th>
					<td><input type="text" name="name" value="<?php echo $rank['name']; ?>" /></td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('ranks_system'); ?>:</th>
					<td><input type="checkbox" name="system" <?php echo $rank['system']==1 ? 'checked="checked"' : ''; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('ranks_users'); ?>:</th>
					<td><input type="checkbox" name="users" <?php echo $rank['users']==1 ? 'checked="checked"' : ''; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('ranks_ranks'); ?>:</th>
					<td><input type="checkbox" name="ranks" <?php echo $rank['ranks']==1 ? 'checked="checked"' : ''; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('ranks_configuration'); ?>:</th>
					<td><input type="checkbox" name="configuration" <?php echo $rank['configuration']==1 ? 'checked="checked"' : ''; ?>" /></td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('ranks_modules'); ?>:</th>
					<td>
						<?php
							if(count($modules)==0) {
								echo '<em>'.$lang->line('ranks_no_modules').'</em>';
							} else {
								foreach($modules as $module) {
									$query = $this->db->get_where('ranks_modules', array('id_rank'=>$rank['id'], 'module'=>strtolower($module['name'])));
									$checked = $query->num_rows >= 1 ? ' checked="checked" ' : '';
									echo '
										<input type="checkbox" name="module_'.strtolower($module['name']).'" '.$checked.' /> '.$module['name'].'<br />
									';
								}
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
						<input type="hidden" name="id" value="<?php echo $rank['id']; ?>" />
						<input type="submit" value="<?php echo $lang->line('button_save'); ?>" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>