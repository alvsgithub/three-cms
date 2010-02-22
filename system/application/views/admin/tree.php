<div id="tree">
	<div id="treeNavigation">
		<ul>
			<li><a href="<?php echo site_url(array('admin', 'content', 'root')); ?>" class="addContent"><?php echo $lang->line('tree_add'); ?></a></li>
		</ul>
	</div>
	<div id="innerTree">
		
		<?php			
			echo '<strong class="root">'.$sitename.'</strong>';
			echo '<div id="treeContainer"></div>';
			// Function to draw the tree:
			/*
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
			*/
			/*
			function drawTree($tree, $currentId) {
				echo '<ul>';
				foreach($tree as $item) {
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
				}
				echo '</ul>';
			}
			
			// Draw the new tree:			
			if(count($tree)>0) {
				drawTree($tree, $currentId);
			}
			*/
			/*
Array(
    [0] => Array
        (
            [id] => 50
            [name] => Home
            [template] => 1
            [numChildren] => 0
            [tree] => 
            [move] => 1
            [modify] => 1
            [visible] => 1
            [allowed] => 1
        )

    [1] => Array
        (
            [id] => 51
            [name] => What is Three CMS
            [template] => 1
            [numChildren] => 0
            [tree] => 
            [move] => 1
            [modify] => 1
            [visible] => 1
            [allowed] => 1
        )

    [2] => Array
        (
            [id] => 52
            [name] => Core Values
            [template] => 6
            [numChildren] => 3
            [tree] => 
            [move] => 1
            [modify] => 1
            [visible] => 1
            [allowed] => 5
        )

    [3] => Array
        (
            [id] => 56
            [name] => News
            [template] => 7
            [numChildren] => 3
            [tree] => 
            [move] => 1
            [modify] => 1
            [visible] => 1
            [allowed] => 8
        )

    [4] => Array
        (
            [id] => 60
            [name] => Example page
            [template] => 1
            [numChildren] => 0
            [tree] => 
            [move] => 1
            [modify] => 1
            [visible] => 1
            [allowed] => 1
        )

    [5] => Array
        (
            [id] => 61
            [name] => Example page
            [template] => 1
            [numChildren] => 1
            [tree] => 
            [move] => 1
            [modify] => 1
            [visible] => 1
            [allowed] => 1
        )

)
			*/
			
		?>
	</div>
</div>
