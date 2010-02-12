<div id="tree">
	<div id="treeNavigation">
		<ul>
			<li><a href="<?php echo site_url(array('admin', 'content', 'root')); ?>" class="addContent"><?php echo $lang->line('tree_add'); ?></a></li>
		</ul>
	</div>
	<div id="innerTree">		
		<?php
			echo '<strong class="root">'.$sitename.'</strong>';
			// Function to draw the tree:
			function drawTree($tree, $currentId) {				
				
				echo '<ul>';				
				foreach($tree as $item) {
					$selected = $item['id'] == $currentId ? ' selected ' : '';
					if($item['tree']==null) {
						$class = $item['numChildren'] > 0 ? ' class="hasChildren"' : '';
						echo '<li'.$class.'><span class="name'.$selected.'"><span class="icon"></span>'.$item['name'].'</span> <span class="id">(<var>'.$item['id'].'</var>)</span></li>';
					} else {
						$class = $item['numChildren'] > 0 ? ' class="hasChildren open"' : '';
						echo '<li'.$class.'><span class="name'.$selected.'"><span class="icon"></span>'.$item['name'].'</span> <span class="id">(<var>'.$item['id'].'</var>)</span>';
						echo '<div class="innerTree">';
						drawTree($item['tree'], $currentId);
						echo '</div>';
						echo '</li>';
					}
				}
				echo '</ul>';
			}
			
			if(count($tree)>0) {
				drawTree($tree, $currentId);
			}			
		?>
	</div>
</div>
