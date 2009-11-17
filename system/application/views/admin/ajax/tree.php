<?php if(count($tree)>0) { ?>
<ul>
	<?php foreach($tree as $item) {
		$class = $item['numChildren'] > 0 ? ' class="hasChildren"' : '';
		echo '<li'.$class.'><span class="name"><span class="icon"></span>'.$item['name'].'</span> <span class="id">(<var>'.$item['id'].'</var>)</span></li>'; 
	} ?>
</ul>
<?php } ?>