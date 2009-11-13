<div id="content">
	<!--
		Add content to the root
	-->
	<div id="innerContent">
		<h1><?php echo $lang->line('title_add_content'); ?></h1>
		<table>
			<tr>
				<th><?php echo $lang->line('action_add'); ?></th>
				<td>
					<?php
						foreach($templates as $template) {
							if(in_array($template['id'], $allowedTemplates)) {
								$buttonText = str_replace('%s', $template['name'], $lang->line('action_add_type'));
								echo '<a href="'.site_url(array('admin', 'content', 'add', 0, $template['id'])).'" class="addContent" title="'.$buttonText.'">'.$buttonText.'</a>';
							}
						}
					?>
				</td>
			</tr>
		</table>
	</div>
</div>