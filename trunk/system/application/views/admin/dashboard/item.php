<div class="item">
	<?php	
		echo '<h3>'.$item['name'].'</h3>';
		if($item['type']=='from_addon') {
			$addons->executeHook('DashBoardItem', array('item'=>$item));
		} else {
			echo '<table>';
			// Show the headers: 
			$headers = $item['headers'];
			$colspan = count($headers)+1;
			echo '<tr>';
			foreach($headers as $header) {			
				echo '<th>'.ucfirst($header['description']).'</th>';
			}
			echo '<th>&nbsp;</th>';
			echo '</tr>';
			// Show items:
			foreach($item['content'] as $content) {
				echo '<tr>';
				$first = true;
				foreach($headers as $header) {				
					if($first) {
						echo '<td><a href="'.site_url(array('admin', 'content', 'edit', $content['id'])).'">'.$content['headers'][$header['name']].'</a></td>';
						$first = false;
					} else {
						echo '<td>'.$content['headers'][$header['name']].'</td>';	
					}
				}
				echo '<td><a class="delete" href="'.site_url(array('admin', 'content', 'delete', $content['id'])).'">delete</a></td>';
				echo '</tr>';
			}
			// Show add-action:
			// TODO: Add according to allowed templates
			// What kind of add-buttons can be shown by 'from_template'?
			// Add new item to... ? or none? In case of a blog, maybe 100 add-buttons will be shown :-S
			//
			$count = 0;
			if(isset($item['add']['templates'])) {
				foreach($item['add']['templates'] as $template) {				
					if(in_array($template['id'], $allowedTemplates) && $template['allowed']) {
						if($count==0) { echo '<tr><td colspan="'.$colspan.'">'; }
						$count++;
						$buttonText = str_replace('%s', $template['name'], $lang->line('action_add_type'));
						echo '<a href="'.site_url(array('admin', 'content', 'add', $item['source'], $template['id'])).'" class="addContent" title="'.$buttonText.'">'.$buttonText.'</a>';
					}
				}
				if($count > 0) { echo '</td></tr>'; }
			}
			echo '</table>';
		}
	?>
</div>