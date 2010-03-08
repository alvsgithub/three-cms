<?php
	function drawTree($tree, $currentID) {
		// echo '<ul>';
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
		// echo '</ul>';
	}
	
	// Draw the new tree:			
	if(count($tree)>0) {
		drawTree($tree, $currentID);
	}
	
	// print_r($tree);


/*
	if(count($tree)>0) {	
?>
<ul>
	<?php foreach($tree as $item) {
		$class = $item['numChildren'] > 0 ? ' class="hasChildren"' : '';
		echo '<li'.$class.'><span class="name"><span class="icon"></span>'.$item['name'].'</span> <span class="id">(<var>'.$item['id'].'</var>)</span></li>'; 
	} ?>
</ul>
<?php
	}
*/
/*
	if(count($tree)>0) {	
?>
<ul>
	<?php foreach($tree as $item) {
		if($item['visible']) {
			$class = $item['numChildren'] > 0 ? ' class="closed"' : '';
			echo '
				<li'.$class.'>
					<a href="#">
						'.$item['name'].'
						<var class="id">'.$item['id'].'</var>
						<var class="template">'.$item['template'].'</var>
						<var class="allowed">'.$item['allowed'].'</var>								
						<var class="move">'.$item['move'].'</var>
						<var class="move">'.$item['modify'].'</var>
					</a>
			';
			// See if there is a subtree:
			if($item['tree']!=null) {
				drawTree($item['tree'], $currentId);
			}
			echo '
				</li>
			';
		}
	} ?>
</ul>
<?php
	}
*/
?>