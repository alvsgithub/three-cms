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
					<th><?php echo $lang->line('content_languages'); ?></th>
					<td>
						<?php
							// TODO: Add Language icons:
							$languagesString = '';
							$first = true;
							foreach($contentData['languages'] as $language) {
						?>
							<a href="#" class="switchLanguage l_<?php echo $language['id']; ?>"><?php echo $language['name']; ?></a>
						<?php
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
									break;
								}
							case 'rich_text' :
								{
									// TODO
									break;
								}
							case 'url' :
								{
									// TODO
									break;
								}
							case 'image' :
								{
									// TODO
									echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
									break;
								}
							case 'file' :
								{
									// TODO
									break;
								}
							case 'boolean' :
								{
									// TODO
									break;
								}
							case 'dropdown' :
								{
									// TODO
									break;
								}
							case 'selectbox' :
								{
									// TODO
									break;
								}
							case 'date' :
								{
									// TODO
									break;
								}
							case 'time' :
								{
									// TODO
									break;
								}
							case 'content' :
								{
									// TODO
									break;
								}
							case 'content_of_type' :
								{
									// TODO
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
				
				$(function(){
					// First hide all the languages:
					for(i=0; i<language_ids.length; i++) {
						$(".language_" + language_ids[i]).hide();
					}
					// Show the default languages:
					$(".language_" + default_language).show();
					$(".l_" + default_language).addClass("active");
					
					// Bind the functions:
					$("a.switchLanguage").click(function(){
						$("a.switchLanguage").removeClass("active");
						$(this).addClass("active");
						className = $(this).attr("class");
						a = className.split(' ');
						idName = a[1];
						a = idName.split('_');
						id = a[1];
						for(i=0; i<language_ids.length; i++) {
							$(".language_" + language_ids[i]).hide();
						}
						$(".language_" + id).show();
						return false;
					});
				});
			</script>
		</form>
	</div>
</div>
	