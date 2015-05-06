# Setting up friendly URL's #

Setting up friendly URL's with Three CMS is fairly easy since the CMS is based on Code Igniter. There are two steps to take for making use of friendly URL's:

  1. Create a .htaccess file according to the Code Igniter wiki
  1. Adjust the config.php file to make sure the line 'index.php' is not injected into your URL's.

Also you have to make sure your Apache server has the mod\_rewrite module installed and enabled in order for friendly URL's to work.

The method described here is also mentioned on the [Code Igniter website](http://codeigniter.com/wiki/mod_rewrite/).

## Creating the .htaccess file ##

Create a .htaccess file on the root of your site and give it the following content:

```
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    #Removes access to the system folder by users.
    #Additionally this will allow you to create a System.php controller,
    #previously this would not have been possible.
    #'system' can be replaced if you have renamed your system folder.
    RewriteCond %{REQUEST_URI} ^system.*
    RewriteRule ^(.*)$ /index.php?/$1 [L]

    #Checks to see if the user is attempting to access a valid file,
    #such as an image or css document, if this isn't true it sends the
    #request to index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?/$1 [L]
</IfModule>

<IfModule !mod_rewrite.c>
    # If we don't have mod_rewrite installed, all 404's
    # can be sent to index.php, and everything works as normal.
    # Submitted by: ElliotHaughin

    ErrorDocument 404 /index.php
</IfModule> 
```

## Adjusting config.php ##

Open the config file located in `system/application/config/config.php` and find the line that assigns $config['index\_page'] a value, usually:

```
$config['index_page'] = "index.php";
```

and change it to:

```
$config['index_page'] = '';
```

Save the file.