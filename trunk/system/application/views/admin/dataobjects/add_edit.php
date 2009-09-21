<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
		<form method="post" action="<?php echo site_url(array('admin', 'dataobjects', 'save')); ?>">
			<table>
				<tr>
					<th><?php echo $lang->line('system_dataobject_name'); ?>:</th>
					<td><input type="text" name="name" value="<?php echo $values['name']; ?>" /></td>
				</tr>
				<tr class="delimiter">
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $lang->line('system_dataobject_linked'); ?>:</th>
					<td>
						<div id="optionsField">
						<?php
							$optionString = '';
							$first = true;							
							foreach($options as $option) {
								// echo '<div class="option"><span class="name">'.$option['name'].'</span><span class="options"><span class="moveUp">Move Up</span><span class="moveDown">Move Down</span><span class="remove">Remove</span></span></div>';
								// Options get loaded with an AJAX Call
								if(!$first) { $optionString.='-'; }
								$optionString.=$option['id'];
								$first = false;
							}
						?>
						</div>
						<div class="addOption">
							<select name="optionList">
								<?php
									foreach($optionList as $option) {
										echo '<option value="'.$option['id'].'">'.$option['name'].'</option>';
									}
								?>
							</select>
							<input type="button" name="addOption" value="<?php echo $lang->line('button_add_option'); ?>" />
							<input type="hidden" name="optionString" value="<?php echo $optionString; ?>" />
							<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/dataobjects.js"></script>
						</div>
					</td>					
				</tr>
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