<?php
	function drawTree($tree, $currentID) {
		foreach($tree as $item) {
			if($item['visible']) {
				$class   = $item['numChildren'] > 0 ? ' class="closed"' : '';
				$class   = $item['tree'] == null ? $class : ' class="open"';
				$a_class = $item['id'] == $currentID ? ' class="clicked" ' : '';
				echo '
					<li'.$class.'>
						<a href="#" '.$a_class.'>
							'.$item['name'].' <span class="id">('.$item['id'].')</span>
							<var class="id">'.$item['id'].'</var>
							<var class="template">'.$item['template'].'</var>
							<var class="allowed">'.$item['allowed'].'</var>								
							<var class="move">'.$item['move'].'</var>
							<var class="modify">'.$item['modify'].'</var>
						</a>
				';
				// See if there is a subtree:
				if($item['tree']!=null) {
					echo '<ul>';
					drawTree($item['tree'], $currentID);
					echo '</ul>';
				}
				echo '
					</li>
				';
			}
		}
	}
	
	// Draw the new tree:			
	if(count($tree)>0) {
		drawTree($tree, $currentID);
	}
?>