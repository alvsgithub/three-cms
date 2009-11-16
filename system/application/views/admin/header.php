<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Three CMS :: <?php echo $lang->line('default_admin_panel'); ?></title>
        <link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/css/screen.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery.color.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            var baseURL              = '<?php echo base_url(); ?>';
            var dialog_delete        = '<?php echo $lang->line('dialog_delete'); ?>';
            var dialog_delete_tree   = '<?php echo $lang->line('dialog_delete_tree'); ?>';
            var dialog_option_exists = '<?php echo $lang->line('dialog_option_exists'); ?>';            
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/global.js"></script>
    </head>
    <body>
        <div id="body">
            <div id="navigation">
                <ul>
                    <li><a href="<?php echo site_url(array('admin')); ?>"><?php echo $lang->line('menu_dashboard'); ?></a></li>
                    <?php
                        if($rank['configuration']==1)
                        {
                    ?>                    
                    <li><?php echo $lang->line('menu_configuration'); ?>
                        <ul>
                            <li><a href="<?php echo site_url(array('admin', 'settings')); ?>"><?php echo $lang->line('menu_site_settings'); ?></a></li>
                        </ul>
                    </li>
                    <?php
                        } 
                        if($rank['users']==1 || $rank['ranks']==1)
                        {
                    ?>                    
                    <li><?php echo $lang->line('menu_users'); ?>
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
                        </ul>
                    </li>
                    <?php
                        } 
                        if($rank['system']==1)
                        {
                    ?>                    
                    <li><?php echo $lang->line('menu_system'); ?>
                        <ul>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'templates')); ?>"><?php echo $lang->line('menu_templates'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'dataobjects')); ?>"><?php echo $lang->line('menu_data_objects'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'options'));   ?>"><?php echo $lang->line('menu_options'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'languages')); ?>"><?php echo $lang->line('menu_languages'); ?></a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'locales'));   ?>"><?php echo $lang->line('menu_locales'); ?></a></li>
                        </ul>
                    </li>
                    <?php
                        }
                    ?>
                    <li class="logout"><a href="<?php echo site_url(array('admin', 'logout')); ?>"><?php echo $lang->line('menu_logout'); ?></a></li>
                </ul>
            </div>
