<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="nl">
    <head>
        <title>Browse server</title>
        <link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/browser/browser.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript">
            var baseURL              = '<?php echo base_url(); ?>';
		</script>
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/browser/browser.js"></script>
    </head>
    <body>
        <div id="body">
			<div id="top">
				<a href="#" class="prev" title="<?php echo $lang->line('browser_previous'); ?>"><?php echo $lang->line('browser_previous'); ?></a>
				<a href="#" class="next" title="<?php echo $lang->line('browser_next'); ?>"><?php echo $lang->line('browser_next'); ?></a>
				<span class="delimiter"></span>
				<a href="#" class="up" title="<?php echo $lang->line('browser_up'); ?>"><?php echo $lang->line('browser_up'); ?></a>
				<a href="#" class="refresh" title="<?php echo $lang->line('browser_refresh'); ?>"><?php echo $lang->line('browser_refresh'); ?></a>
				<a href="#" class="search" title="<?php echo $lang->line('browser_search'); ?>"><?php echo $lang->line('browser_search'); ?></a>
				<input type="text" name="searchField" />
				<span class="delimiter"></span>
				<a href="#" class="newFile" title="<?php echo $lang->line('browser_new_file'); ?>"><?php echo $lang->line('browser_new_file'); ?></a>
				<a href="#" class="newFolder" title="<?php echo $lang->line('browser_new_folder'); ?>"><?php echo $lang->line('browser_new_folder'); ?></a>
				<a href="#" class="delete" title="<?php echo $lang->line('browser_delete'); ?>"><?php echo $lang->line('browser_delete'); ?></a>				
			</div>
			<div id="tree">
				<?php
					// TODO: Implement previous-button functionality
					// TODO: Implement next-button functionality
					// TODO: Implement up-button functionality
					// TODO: Implement refresh functionality
					// TODO: Implement search functionality (AJAX)
					// TODO: Implement upload new file functionality (AJAX / multiple files)
					// TODO: Implement new folder functionality
					// TODO: Implement delete functionality
					function buildTree($path)
					{
						$files = glob($path.'/*');
						if(count($files) > 0) {
							echo '<ul>';
							foreach($files as $file) {
								if(is_dir($file)) {
									$a = explode('/', $file);
									$name = $a[count($a)-1];
									echo '<li class="folder"><span rel="'.str_replace('/', '-', $file).'">'.$name.'</span>';
									buildTree($file);
									echo '</li>';
								} 
							}
							echo '</ul>';
						}
					}
					
					buildTree('assets');
				?>
			</div>
			<div id="files">
				
			</div>
		</div>
    </body>
</html>

