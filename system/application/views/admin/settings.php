<div id="content">
	<div id="innerContent">
		<h1><?php echo $lang->line('title_settings'); ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'settings', 'save')); ?>">
			<table>
				<tr>
					<th>Default language:</th>
					<td>
						<select name="default_language">
							<?php
								foreach($languages as $language) {
									echo '<option value="'.$language['id'].'"';
									if($language['id'] == $settings['default_language']) {
										echo ' selected="selected"';
									}
									echo '>'.$language['name'].'</option>';									
								}
							?>
						</select>						
					</td>
				</tr>
				<tr>
					<th>Default page ID:</th>
					<td><input type="text" name="default_page_id" value="<?php echo $settings['default_page_id']; ?>" /></td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td><input type="submit" value="<?php echo $lang->line('button_save'); ?>" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>