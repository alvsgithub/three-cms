<div id="innerContent">
	<h1><?php echo $content['name']; ?></h1>
	<table>
		<tr>
			<th width="10%"><?php echo $lang->line('content_id'); ?>:</th>
			<td><span class="idContent"><?php echo $content['id']; ?></span></td>
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
		<tr>
			<th><?php echo $lang->line('content_order'); ?>:</th>
			<td><?php echo $content['order']; ?></td>
		</tr>
		<?php
			if($allowedActions['visible']) {
		?>
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
					// Only show the allowed actions:					
					if($allowedActions['modify'])    { echo '<a href="'.site_url(array('admin', 'content', 'edit', $content['id'])),'" class="edit" title="'.$modify.'">'.$modify.'</a>'; }
					if($allowedActions['duplicate']) { echo '<a href="'.site_url(array('admin', 'content', 'duplicate', $content['id'])).'" class="duplicate" title="'.$duplicate.'">'.$duplicate.'</a>'; }
					if($allowedActions['move'])      { echo '<a href="'.site_url(array('admin', 'content', 'move', $content['id'])).'" class="move" title="'.$move.'">'.$move.'</a>'; }
					if($allowedActions['delete'])    { echo '<a href="'.site_url(array('admin', 'content', 'delete', $content['id'])).'" class="delete" title="'.$delete.'">'.$delete.'</a>'; }
				?>
				<input name="id" type="hidden" value="<?php echo $content['id']; ?>" />
			</td>
		</tr>
		<?php
			}
			// See if this user may add new content:
			if($allowedActions['add']) {
				// See if there are child templates that can be added to this object:			
				$templates = array();
				foreach($childTemplates as $template) {
					if($template['allowed']) {
						array_push($templates, $template);
					}
				}
				if(count($templates)>0) {
		?>
		<tr class="delimiter">
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th><?php echo $lang->line('action_add'); ?></th>
			<td>
				<?php
					foreach($templates as $template) {
						$buttonText = str_replace('%s', $template['name'], $lang->line('action_add_type'));
						echo '<a href="'.site_url(array('admin', 'content', 'add', $content['id'], $template['id'])).'" class="addContent" title="'.$buttonText.'">'.$buttonText.'</a>';
					}
				?>
			</td>
		</tr>
		<?php
				}
			}
		?>
	</table>
</div>
