<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Admin :: Login</title>
    </head>
    <body>        
        <h1>Login</h1>        
        <form method="post" action="<?php echo site_url(array('admin', 'login')); ?>">
            Username:   <input type="text" name="username" /><br />
            Password:   <input type="password" name="password" /><br />
            <input type="submit" name="login" value="login" />
        </form>
    </body>
</html>
