<div id="content">
	<div id="innerContent">
		<h1><?php echo $lang->line('title_settings'); ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'settings', 'save')); ?>">
			<?php
				/**
				 * Inline function: Show the value of a specific setting. This is used in case there are new settings added
				 * @param	$settings	array	The associated settings array
				 * @param	$name		string	The name of the setting
				 */
				function settingValue($settings, $name)
				{
					if(isset($settings[$name])) {
						echo $settings[$name];
					}
				}
				
				// TODO: Make setting names multilingual
			?>
			<table>
				<tr>
					<th>Site name:</th>
					<td><input type="text" name="site_name" value="<?php settingValue($settings, 'site_name'); ?>" /></td>
				</tr>
				<tr>
					<th>Base URL:</th>
					<td><input type="text" name="base_url" value="<?php settingValue($settings, 'base_url'); ?>" /></td>
				</tr>
				<tr>
					<th>Assets path:</th>
					<td><input type="text" name="assets_path" value="<?php settingValue($settings, 'assets_path'); ?>" /></td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th>Default language:</th>
					<td>
						<select name="default_language">
							<?php
								foreach($languages as $language) {
									echo '<option value="'.$language['id'].'"';
									if(isset($settings['default_language'])) {
										if($language['id'] == $settings['default_language']) {
											echo ' selected="selected"';
										}
									}
									echo '>'.$language['name'].'</option>';									
								}
							?>
						</select>						
					</td>
				</tr>
				<tr>
					<th>Default page ID:</th>
					<td><input type="text" name="default_page_id" value="<?php settingValue($settings, 'default_page_id'); ?>" /></td>
				</tr>
				<tr>
					<th>Date format:</th>
					<td><input type="text" name="date_format" value="<?php settingValue($settings, 'date_format'); ?>" /></td>
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