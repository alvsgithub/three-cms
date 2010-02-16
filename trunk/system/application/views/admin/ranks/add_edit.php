<div id="content">
	<div id="innerContent">		
        <h1><?php echo $title; ?></h1>
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
					<th><?php echo $lang->line('ranks_addons'); ?>:</th>
					<td>
						<?php							
							if(count($addons->addons)==0) {
								echo '<em>'.$lang->line('ranks_no_addons').'</em>';
							} else {								
								foreach($addons->addons as $addon) {									
									$query = $this->db->get_where('ranks_addons', array('id_rank'=>$rank['id'], 'addon'=>strtolower($addon[0])));
									$checked = $query->num_rows >= 1 ? ' checked="checked" ' : '';
									echo '
										<input type="checkbox" name="module_'.strtolower($addon[0]).'" '.$checked.' /> '.$addon[0].'<br />
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
					<th><?php echo $lang->line('ranks_templates'); ?>:</th>
					<td class="templateRanks">
						<?php
							// Quick inline function:
							function chk($val)
							{
								if($val==1) {
									return ' checked="checked" ';
								} else {
									return false;
								}
							}
							
							foreach($templates as $template) {
								$a = $template['rights'];
								echo '<strong>'.$template['name'].'</strong><br />';
								echo '<label><input type="checkbox" name="template_visible_'.$template['id'].'" '.  chk($a['visible']).' /> '.  $lang->line('action_visible').' </label>';
								echo '<label><input type="checkbox" name="template_add_'.$template['id'].'" '.      chk($a['add']).' /> '.      $lang->line('action_add').' </label>';
								echo '<label><input type="checkbox" name="template_modify_'.$template['id'].'" '.   chk($a['modify']).' /> '.   $lang->line('action_modify').' </label>';
								echo '<label><input type="checkbox" name="template_duplicate_'.$template['id'].'" '.chk($a['duplicate']).' /> '.$lang->line('action_duplicate').' </label>';
								echo '<label><input type="checkbox" name="template_move_'.$template['id'].'" '.     chk($a['move']).' /> '.     $lang->line('action_move').' </label>';
								echo '<label><input type="checkbox" name="template_delete_'.$template['id'].'" '.   chk($a['delete']).' /> '.   $lang->line('action_delete').' </label>';
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
						<input type="hidden" name="id" value="<?php echo $rank['id']; ?>" />
						<input type="submit" value="<?php echo $lang->line('button_save'); ?>" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>