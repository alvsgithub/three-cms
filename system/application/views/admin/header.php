<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Three CMS :: <?php echo $lang->line('default_admin_panel'); ?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/css/screen.css" />
		<link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/css/calendar-blue.css" />
		<link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/css/jquery.timeentry.css" />
		<link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/css/jquery.tree.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery-1.4.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery.mousewheel.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery.dynDateTime.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/calendar-en.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery.timeentry.min.js"></script>
		<!--
		<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery.color.js"></script>
		-->
		<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery.tree.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            var baseURL              = '<?php echo base_url(); ?>';
            var dialog_delete        = '<?php echo $lang->line('dialog_delete'); ?>';
            var dialog_delete_tree   = '<?php echo $lang->line('dialog_delete_tree'); ?>';
            var dialog_option_exists = '<?php echo $lang->line('dialog_option_exists'); ?>';
			var dialog_tree_invalid_move = '<?php echo $lang->line('dialog_tree_invalid_move'); ?>';
			var dialog_tree_not_movable  = '<?php echo $lang->line('dialog_tree_not_movable'); ?>';
			var dialog_tree_no_edit      = '<?php echo $lang->line('dialog_tree_no_edit'); ?>'; 
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/global.js"></script>
    </head>
    <body>
        <div id="body">
            <div id="navigation">
                <ul>
                    <li><a class="dashboard" href="<?php echo site_url(array('admin')); ?>"><?php echo $lang->line('menu_dashboard'); ?></a></li>
                    <?php
                        if($rank['configuration']==1)
                        {
                    ?>                    
                    <li><a class="configuration" href="#" class="noClick"><?php echo $lang->line('menu_configuration'); ?></a>
                        <ul>
                            <li><a href="<?php echo site_url(array('admin', 'settings')); ?>"><?php echo $lang->line('menu_site_settings'); ?></a></li>
							<?php
								$addons->executeHook('AppendSubNavigation', array('parent'=>'configuration', 'allowedAddons'=>$allowedAddons));
							?>
                        </ul>
                    </li>
                    <?php
                        } 
                        if($rank['users']==1 || $rank['ranks']==1)
                        {
                    ?>                    
                    <li><a class="users" href="#" class="noClick"><?php echo $lang->line('menu_users'); ?></a>
                        <ul>
                            <?php
                                if($rank['users']==1)
                                {
                            ?>
                            <li><a href="<?php echo site_url(array('admin', 'users')); ?>"><?php echo $lang->line('menu_users'); ?></a></li>
                            <?php
                                }
                                if($rank['ranks']==1)
                                {
                            ?>
                            <li><a href="<?php echo site_url(array('admin', 'ranks')); ?>"><?php echo $lang->line('menu_ranks'); ?></a></li>
                            <?php
                                }
                            ?>
							<?php
								$addons->executeHook('AppendSubNavigation', array('parent'=>'users', 'allowedAddons'=>$allowedAddons));
							?>
                        </ul>
                    </li>
                    <?php
                        } 
                        if($rank['system']==1)
                        {
                    ?>                    
                    <li><a class="system" href="#" class="noClick"><?php echo $lang->line('menu_system'); ?></a>
                        <ul>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'templates')); ?>"><?php echo $lang->line('menu_templates'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'dataobjects')); ?>"><?php echo $lang->line('menu_data_objects'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'options'));   ?>"><?php echo $lang->line('menu_options'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'languages')); ?>"><?php echo $lang->line('menu_languages'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'locales'));   ?>"><?php echo $lang->line('menu_locales'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'dashboard'));   ?>"><?php echo $lang->line('menu_dashboard'); ?></a></li>
							<?php								
								$addons->executeHook('AppendSubNavigation', array('parent'=>'system', 'allowedAddons'=>$allowedAddons));
							?>
                        </ul>
                    </li>
					<?php
							$addons->executeHook('AppendMainNavigation', array('allowedAddons'=>$allowedAddons));
                        }
                    ?>
                    <li class="logout"><a class="logout" href="<?php echo site_url(array('admin', 'logout')); ?>"><?php echo $lang->line('menu_logout'); ?></a></li>
                </ul>
            </div>
			<div id="loading">
				<img src="<?php echo base_url(); ?>system/application/views/admin/images/ajax-loader.gif" width="128" height="15" />
				<p><?php echo $lang->line('default_one_moment'); ?></p>
			</div>