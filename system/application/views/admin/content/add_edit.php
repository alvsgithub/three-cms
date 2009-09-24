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
					<td><input disabled="disabled" type="text" name="template" value="<?php echo $contentData['id_template']; ?>" /> // TODO</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('content_parent'); ?>:</th>
					<td><input disabled="disabled" type="text" name="parent" value="<?php echo $contentData['id_content']; ?>" /> // TODO</td>
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
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
					// TODO: Some serious optimization here. There are now 3 foreach-loops stacked in each other!
					
					// Show the content fields:
					foreach($contentData['content'] as $item) {
				?>
				<tr>
					<th><?php echo ucfirst($item['name']); ?>:</th>
					<td>
				<?php
					$optionID = $item['id_option'];
					// See if this item is multilingual:
					if($item['multilanguage']==1) {
						$iterations = count($contentData['languages']);
					} else {
						$iterations = 1;
					}
					for($i=0; $i<$iterations; $i++) {
						// $contentData['languages'] as $language) {
						$languageID = $item['multilanguage']==1 ? $contentData['languages'][$i]['id'] : 0;	// 0 stands for non-multilanguage
						$name       = 'input_'.$optionID.'_'.$languageID;
						$value      = '';
						$class		= 'language_'.$languageID;
						foreach($item['value'] as $valueItem) {
							if($valueItem['id_language']==$languageID) {
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
									// TODO
									echo '<textarea name="'.$name.'" class="'.$class.'">'.$value.'</textarea>';
									break;
								}
							case 'rich_text' :
								{
									// TODO: Add a CKEditor
									break;
								}
							case 'url' :
								{
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
							case 'image' :
								{
									// TODO: Add a browse-button
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
							case 'file' :
								{
									// TODO: Add a browse-button
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
							case 'boolean' :
								{
									$checked = $value==1 ? 'checked="checked" ' : '';
									echo '<input type="checkbox" name="'.$name.'" '.$checked.' class="'.$class.'" />';
									break;
								}
							case 'dropdown' :
								{
									// TODO: Add a dropdown where a single value can be selected
									break;
								}
							case 'selectbox' :
								{
									// TODO: Add a selectbox where multiple values can be selected
									break;
								}
							case 'date' :
								{
									// TODO: Add a datapicker
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
							case 'time' :
								{
									// TODO: Add a timepicker
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
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
				<tr>
					<th>&nbsp;</th>
					<td>
						<input type="hidden" name="id" value="<?php echo $contentData['id']; ?>" />
						<input type="submit" value="<?php echo $lang->line('button_save'); ?>" />
					</td>
				</tr>
			</table>			
			<script type="text/javascript">
				var language_ids        = [<?php echo $languagesString; ?>];
				var default_language	= <?php echo DEFAULT_LANGUAGE_ID; ?>;
			</script>
			<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/content.js"></script>
		</form>
	</div>
</div>
	