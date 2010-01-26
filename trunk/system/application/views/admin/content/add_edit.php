<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'content', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('content_name'); ?>:</th>
					<td><input type="text" name="name" value="<?php echo $contentData['name']; ?>" /></td>
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
					// TODO: Some serious optimization here. There are now 3 foreach-loops stacked in each other!
					
					// Show the content fields:
					foreach($contentData['content'] as $item) {						
						echo '<tr class="option"><th>';
						echo ucfirst($item['description']).':';
						if(!empty($item['tooltip'])) {
							echo '<span class="tooltip">?</span><span class="tooltipContent">'.$item['tooltip'].'</span></th>';
						}
						echo '<td>';
					$optionID = $item['id_option'];
					// See if this item is multilingual:
					if($item['multilanguage']==1) {
						$iterations = count($contentData['languages']);
					} else {
						$iterations = 1;
					}
					for($i=0; $i<$iterations; $i++) {						
						$languageID = $item['multilanguage']==1 ? $contentData['languages'][$i]['id'] : 0;	// 0 stands for non-multilanguage
						$name       = 'input_'.$optionID.'_'.$languageID;
						$value      = '';
						$class		= 'language_'.$languageID;
						foreach($item['value'] as $valueItem) {
							if($languageID==0) {
								if($valueItem['id_language']==$settings['default_language']) {
									$value = $valueItem['value'];
									break;
								}
							} elseif($valueItem['id_language']==$languageID) {
								$value = $valueItem['value'];
								break;
							}
						}
						// Show the correct input type, according to the option type:						
						switch($item['type']) {
							case 'small_text' :
								{
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
							case 'large_text' :
								{
									echo '<textarea name="'.$name.'" class="'.$class.'">'.$value.'</textarea>';
									break;
								}
							case 'rich_text' :
								{
									echo '<div class="'.$class.'"><textarea name="'.$name.'" class="richtext">'.$value.'</textarea></div>';
									break;
								}
							case 'url' :
								{
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
							case 'image' :
								{
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									echo '<input type="button" name="browse" value="Browse server..." />';
									break;
								}
							case 'file' :
								{
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									echo '<input type="button" name="browse" value="Browse server..." />';
									break;
								}
							case 'boolean' :
								{
									$checked = $value=='1' ? 'checked="checked" ' : '';									
									echo '<input type="checkbox" name="'.$name.'" '.$checked.' class="'.$class.'" />';
									break;
								}
							case 'dropdown' :
								{
									$values = explode('||', $item['options']);
									echo '<select name="'.$name.'">';
									foreach($values as $option) {
										$optionArray = explode('==', $option);
										$optionName  = $optionArray[0];
										$optionValue = count($optionArray)==1 ? $optionArray[0] : $optionArray[1];
										$selected    = $optionValue == $value ? ' selected="selected"' : '';
										echo '<option value="'.$optionValue.'"'.$selected.'>'.$optionName.'</option>';
									}
									echo '</select>';
									break;
								}
							case 'selectbox' :
								{
									$values = explode('||', $item['options']);
									$valueArray = explode(';', $value);
									foreach($values as $option) {
										$optionArray = explode('==', $option);
										$optionName  = $optionArray[0];
										$optionValue = count($optionArray)==1 ? $optionArray[0] : $optionArray[1];
										$checked = in_array($optionValue, $valueArray) ? ' checked="checked" ' : '';
										echo '<label><input type="checkbox" name="'.$name.'_'.md5($optionValue).'" '.$checked.' /> '.$optionName.'</label><br />';
									}
									break;
								}
							case 'date' :
								{
									// TODO: Add a datapicker
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.' datePicker" />';
									break;
								}
							case 'time' :
								{
									// TODO: Add a timepicker
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
							
							// TODO: Custom options:
							
							/*
							case 'content' :
								{
									// TODO: Add a dropdown where to select a content type
									break;
								}
							case 'content_of_type' :
								{
									// TODO: Add a dropdown where te select content of a specific dataObject
									break;
								}
							*/
						}
					}
				?>
					</td>
				<?php
					}
				?>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
					// See if there are any modules to execute here:
					$moduleFound = false;
					foreach($modules as $module) {
						$moduleName = strtolower($module['name']);
						$path = 'system/application/modules/'.$moduleName.'/'.$moduleName.'.content.edit.php';
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
			</script>
			<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/content.js"></script>
		</form>
	</div>
</div>
	