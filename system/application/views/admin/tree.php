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
		?>
	</div>
</div>
