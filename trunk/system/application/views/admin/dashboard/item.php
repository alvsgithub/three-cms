<div class="item">
	<?php
		echo '<h3>'.$item['name'].'</h3>';
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
		echo '<tr><td class="add" colspan="'.$colspan.'"><a href="#">add new</a></td></tr>';
		echo '</table>';
		// print_r($item);
	?>
</div>