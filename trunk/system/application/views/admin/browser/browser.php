<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="nl">
    <head>
        <title>Browse server</title>
        <link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/browser/browser.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery-1.4.1.min.js"></script>
		<script type="text/javascript">
            var baseURL              = '<?php echo base_url(); ?>';
			var deleteFile  		 = '<?php echo $lang->line('dialog_delete'); ?>';
			var dialog_new_folder    = '<?php echo $lang->line('dialog_new_folder'); ?>';
			var dialog_no_folder     = '<?php echo $lang->line('dialog_no_folder'); ?>';
		</script>
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/browser/browser.js"></script>
    </head>
    <body>
        <div id="body">
			<div id="top">
				<form method="post" enctype="multipart/form-data" action="<?php echo site_url(array('admin', 'browser', 'upload')); ?>">
				<a href="#" class="newFile" title="<?php echo $lang->line('browser_new_file'); ?>"><?php echo $lang->line('browser_new_file'); ?></a>
				<input type="file" name="uploadField" /><input type="submit" name="uploadButton" value="<?php echo $lang->line('button_upload'); ?>" />
				<input type="hidden" name="folder" />
				<a href="#" class="newFolder" title="<?php echo $lang->line('browser_new_folder'); ?>"><?php echo $lang->line('browser_new_folder'); ?></a>
				</form>
			</div>
			<div id="tree">
				<?php
					function buildTree($path)
					{
						$files = glob($path.'/*');
						if(count($files) > 0) {
							echo '<ul>';
							foreach($files as $file) {
								if(is_dir($file)) {									
									$a = explode('/', $file);
									$name = $a[count($a)-1];
									// Make sure it is not the modules or plugins-folder:
									if($file != 'assets/addons') {
										echo '<li class="folder"><span rel="'.str_replace('/', '-', $file).'">'.$name.'</span>';
										buildTree($file);
										echo '</li>';
									}
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

