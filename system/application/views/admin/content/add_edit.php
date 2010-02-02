<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'content', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('content_name'); ?>:</th>
					<td><input type="text" name="name" class="required" value="<?php echo $contentData['name']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('content_alias'); ?>:</th>
					<td><input type="text" name="alias" value="<?php echo $contentData['alias']; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('content_template'); ?>:</th>
					<td>
						<?php
							// If id_template is not empty (will be empty when adding new content), check if the current template is allowed to use by the user:
							if(!empty($contentData['id_template']) && !in_array($contentData['id_template'], $allowedTemplates)) {
								echo '<input type="hidden" name"template" value="'.$contentData['id_template'].'" />';
								foreach($templates->result() as $result) {
									if($result->id==$contentData['id_template']) {
										echo $result->name;
									}
								}
							} else {								
						?>
						<select name="template">
						<?php							
							foreach($templates as $template) {
								if(in_array($template['id'], $allowedTemplates) && $template['allowed']==1) {
									$selected = $contentData['id_template']==$template['id'] ? ' selected="selected"' : '';
									echo '<option value="'.$template['id'].'"'.$selected.'>'.$template['name'].'</option>';
								}
							}
						?>
						</select>
						<?php							
							}
						?>
					</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('content_parent'); ?>:</th>
					<td><input readonly="readonly" class="small" type="text" name="parent" value="<?php echo $contentData['id_content']; ?>" /> <a href="#" class="selectParent">Select parent <span></span></a></td>
				</tr>
				<tr>
					<th><?php echo $lang->line('content_order'); ?>:</th>
					<td><input class="small" type="text" name="order" value="<?php echo $contentData['order']; ?>" /> <a href="#" class="orderSmaller">&laquo;</a> <a href="#" class="orderBigger">&raquo;</a></td>
				</tr>				
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('content_language'); ?>:</th>
					<td>
						<?php							
							$languagesString = '';
							$first = true;
							foreach($contentData['languages'] as $language) {								
								if(file_exists(BASEPATH.'application/views/admin/images/lang/'.$language['code'].'.png')) {
									$style = 'style="background-image: url('.base_url().'system/application/views/admin/images/lang/'.$language['code'].'.png); padding-left: 25px;"';
								} else {
									$style = '';
								}
								// Show the language link:
								echo '<a '.$style.' href="#" class="switchLanguage l_'.$language['id'].'">'.$language['name'].'</a>';
								if(!$first) {
									$languagesString .= ',';
								}
								$languagesString .= $language['id'];
								$first = false;
							}
						?>
					</td>
				</tr>
				<tr class="delimiter optionsStart">
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
					include_once('options_field.php');
				?>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
					// See if there are any modules to execute here:
					$moduleFound = false;
					foreach($modules as $module) {
						$moduleName = strtolower($module['name']);
						$path = $module['path'].'/'.$moduleName.'.content.edit.php';
						if(file_exists($path)) {
							include_once($path);
							$moduleFound = true;
						}
					}
					if($moduleFound) {
						// Add an extra delimiter:
						echo '
							<tr class="delimiter">
								<td colspan="2">&nbsp;</td>
							</tr>
						';
					}
				?>				
				<tr>
					<th>&nbsp;</th>
					<td>
						<input type="hidden" name="id" value="<?php echo $contentData['id']; ?>" />
						<input type="submit" value="<?php echo $lang->line('button_save'); ?>" /> <img src="<?php echo base_url(); ?>system/application/views/admin/images/ajax-loader.gif" width="128" height="15" class="loading" />		<div id="message"></div>
					</td>
				</tr>
			</table>			
			<script type="text/javascript">
				var language_ids     	     = [<?php echo $languagesString; ?>];
				var default_language		 = <?php echo $settings['default_language']; ?>;
				var select_parent    	     = '<?php echo $lang->line('content_select_parent'); ?>';
				var dialog_parent_same_id	 = '<?php echo $lang->line('dialog_parent_same_id'); ?>';
				var dialog_parent_descendant = '<?php echo $lang->line('dialog_parent_descendant'); ?>';
				var content_server_error     = '<?php echo $lang->line('content_server_error'); ?>';
				var change_template          = '<?php echo $lang->line('dialog_change_template'); ?>';
				var date_format              = '<?php echo $settings['date_format']; ?>';
				var dialog_required			 = '<?php echo $lang->line('dialog_required'); ?>';
			</script>
			<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/content.js"></script>
		</form>
	</div>
</div>
	