<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'content', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('content_name'); ?>:</th>
					<td><input type="text" name="name" class="required" value="<?php echo $contentData['name']; ?>" /> <a href="#" class="showAlias"><?php echo $lang->line('content_show_alias'); ?></a></td>
				</tr>
				<tr class="alias">
					<th><?php echo $lang->line('content_alias'); ?>:</th>
					<td><input type="text" name="alias" value="<?php echo $contentData['alias']; ?>" /> <em><?php echo $lang->line('content_auto_alias'); ?></em></td>
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
				<?php
					// Only show the language picker if:
					// - there is more than one language AND
					// - there are any options AND
					// - any of the options are multilingual:
					$languagesString = '';
					if(count($contentData['languages']) > 1 && count($contentData['content']) > 0) {
				?>
				<tr class="delimiter hideIfNotMultilingual">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr class="hideIfNotMultilingual">
					<th><?php echo $lang->line('content_language'); ?>:</th>
					<td>
						<?php							
							$first = true;
							foreach($contentData['languages'] as $language) {								
								/*
								if(file_exists(BASEPATH.'application/views/admin/images/lang/'.$language['code'].'.png')) {
									$style = 'style="background-image: url('.base_url().'system/application/views/admin/images/lang/'.$language['code'].'.png); padding-left: 25px;"';
								} else {
									$style = '';
								}
								*/
								// Show the language link:
								// echo '<a '.$style.' href="#" class="switchLanguage l_'.$language['id'].'">'.$language['name'].'</a>';
								echo '<a href="#" class="switchLanguage l_'.$language['id'].'">'.$language['name'].'</a>';
								if(!$first) {
									$languagesString .= ',';
								}
								$languagesString .= $language['id'];
								$first = false;
							}
						?>
					</td>
				</tr>
				<?php
					} // End count languages					
					$addons->executeHook('ContentAboveOptions', array('lang'=>$lang, 'contentData'=>$contentData, 'templates'=>$templates, 'title'=>$title, 'allowedTemplates'=>$allowedTemplates, 'settings'=>$settings));
				?>
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
					// Addons:
					$ok = $addons->executeHook('ContentBelowOptions', array('lang'=>$lang, 'contentData'=>$contentData, 'templates'=>$templates, 'title'=>$title, 'allowedTemplates'=>$allowedTemplates, 'settings'=>$settings));
					if($ok) {
						echo '<tr class="delimiter"><td colspan="2">&nbsp;</td></tr>';
					}
				?>				
				<tr>
					<th>&nbsp;</th>
					<td>
						<input type="hidden" name="id" value="<?php echo $contentData['id']; ?>" />
						<input type="hidden" name="parent" value="<?php echo $contentData['id_content']; ?>" />
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