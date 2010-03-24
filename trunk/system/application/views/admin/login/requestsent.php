<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Three-CMS :: <?php echo $lang->line('login_title'); ?></title>
        <link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/css/login.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/login.js"></script>
    </head>
    <body>
        <div id="login">
            <h1><?php echo $lang->line('login_request_title'); ?></h1>
			<div class="info">
	            <p><?php echo $text; ?></p>
				<p><a href="<?php echo base_url(); ?>index.php/admin/login"><?php echo $lang->line('login_continue'); ?></a></p>
			</div>
        </div>
    </body>
</html>
