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
            <h1><?php echo $lang->line('login_title'); ?></h1>        
            <form method="post" action="<?php echo site_url(array('admin', 'login')); ?>">
                <!-- Username: -->                
                <label for="username"><?php echo $lang->line('login_username'); ?>:</label>
                <input type="text" name="username" id="username" class="inputField" />
                <!-- Password: -->
                <label for="password"><?php echo $lang->line('login_password'); ?>:</label>
                <input type="password" name="password" class="inputField" />
                <!-- Submit: -->
                <input type="hidden" name="login" value="true" />
                <input type="submit" class="submit" value="<?php echo $lang->line('login_submit_button'); ?>" />
                <img src="<?php echo base_url(); ?>system/application/views/admin/images/ajax-loader-small.gif" width="16" height="16" />
            </form>
            <?php
                if($error == true) {
                    echo '<p class="error">'.$lang->line('login_error').'</p>';
                }
            ?>
            <p class="password"><a href="#"><?php echo $lang->line('login_forgot'); ?></a></p>
            <div class="forgot_password">
                <p><?php echo $lang->line('login_forgot_instructions'); ?></p>
                <form method="post" action="<?php echo site_url(array('admin', 'login')); ?>">
                    <!-- Username: -->                
                    <label for="email"><?php echo $lang->line('login_email'); ?>:</label>
                    <input type="text" name="email" id="email" class="inputField" />
                    <!-- Submit: -->
                    <input type="hidden" name="loginforgot" value="true" />
                    <input type="submit" class="submit" value="<?php echo $lang->line('login_send_button'); ?>" />
                </form>
            </div>
        </div>
    </body>
</html>
