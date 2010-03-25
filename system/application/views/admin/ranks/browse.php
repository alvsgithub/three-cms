<div id="content">
	<div id="innerContent">
		<script type="text/javascript" src="<?php echo BASE_URL; ?>system/application/views/admin/js/items.js"></script>
        <h1><?php echo $lang->line('ranks_title'); ?></h1>
		<table class="items">
			<tr>
				<th>ID</th>
				<th><?php echo $lang->line('ranks_name'); ?></th>
				<th><?php echo $lang->line('default_actions'); ?></th>
			</tr>
		<?php
			// id, username, password, real name, e-mail
			foreach($ranks as $rank) {
				echo '
					<tr>
						<td>'.$rank['id'].'</td>
						<td>'.$rank['name'].'</td>
						<td>
							<a href="'.site_url(array('admin','ranks','edit', $rank['id'])).'" class="edit">'.$lang->line('action_modify').'</a>
							<a href="'.site_url(array('admin','ranks','duplicate', $rank['id'])).'" class="duplicate">'.$lang->line('action_duplicate').'</a>
							<a href="'.site_url(array('admin','ranks','delete', $rank['id'])).'" class="delete">'.$lang->line('action_delete').'</a>
						</td>
					</tr>
				';
			}		
		?>
		</table>
		<a href="<?php echo site_url(array('admin', 'ranks', 'add')); ?>" class="add"><?php echo $lang->line('ranks_add'); ?></a>
	</div>
</div>