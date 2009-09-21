<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'locales', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('system_locale_name'); ?></th>
					<td><input type="text" name="name" value="<?php echo $values['name']; ?>" /></td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php foreach($locales as $locale) { ?>
				<tr>
					<th><?php echo ucfirst($locale['name']); ?>:</th>
					<td><input type="text" name="language_<?php echo $locale['id']; ?>" value="<?php echo $locale['value']; ?>" /></td>
				</tr>
				<?php } ?>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>
						<input type="hidden" name="id" value="<?php echo $values['id']; ?>" />
						<input type="submit" value="<?php echo $lang->line('button_save'); ?>" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>