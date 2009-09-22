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
					<a href="#" class="edit" title="<?php echo $lang->line('action_modify'); ?>">Edit</a>
					<a href="#" class="duplicate" title="<?php echo $lang->line('action_duplicate'); ?>">Duplicate</a>
					<a href="#" class="move" title="<?php echo $lang->line('action_move'); ?>">Move</a>
					<a href="#" class="delete" title="<?php echo $lang->line('action_delete'); ?>">Delete</a>
				</td>
			</tr>
		</table>
	</div>
</div>