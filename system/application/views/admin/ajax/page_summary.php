<div id="content">
	<div id="innerContent">
		<h1><?php echo $content['name']; ?></h1>
		<table>
			<tr>
				<th width="10%"><?php echo $lang->line('content_id'); ?>:</th>
				<td><?php echo $content['id']; ?></td>
			</tr>
			<tr>
				<th><?php echo $lang->line('content_name'); ?>:</th>
				<td><?php echo $content['name']; ?></td>
			</tr>
			<tr>
				<th><?php echo $lang->line('content_alias'); ?>:</th>
				<td><?php echo $content['alias']; ?></td>
			</tr>
			<tr>
				<th><?php echo $lang->line('content_template'); ?>:</th>
				<td><?php echo $content['templateName']; ?></td>
			</tr>
			<tr class="delimiter">
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<th><?php echo $lang->line('default_actions'); ?>:</th>
				<td class="content_actions">
					<?php
						$modify    = $lang->line('action_modify');
						$duplicate = $lang->line('action_duplicate');
						$move      = $lang->line('action_move');
						$delete    = $lang->line('action_delete');
					?>
					
					<a href="<?php echo site_url(array('admin', 'content', 'edit', $content['id'])); ?>" class="edit" title="<?php echo $modify.'">'.$modify; ?></a>
					<a href="<?php echo site_url(array('admin', 'content', 'duplicate', $content['id'])); ?>" class="duplicate" title="<?php echo $duplicate.'">'.$duplicate; ?></a>
					<a href="<?php echo site_url(array('admin', 'content', 'move', $content['id'])); ?>" class="move" title="<?php echo $move.'">'.$move; ?></a>
					<a href="<?php echo site_url(array('admin', 'content', 'delete', $content['id'])); ?>" class="delete" title="<?php echo $delete.'">'.$delete; ?></a>
				</td>
			</tr>
			<tr class="delimiter">
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<th><?php echo $lang->line('action_add'); ?></th>
				<td>
					<?php
						foreach($childTemplates as $template) {
							$buttonText = str_replace('%s', $template['name'], $lang->line('action_add_type'));
							echo '<a href="'.site_url(array('admin', 'content', 'add', $content['id'], $template['id'])).'" class="addContent" title="'.$buttonText.'">'.$buttonText.'</a>';
						}
					?>
				</td>
			</tr>
		</table>
	</div>
</div>