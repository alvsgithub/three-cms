<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Three CMS :: Admin Panel</title>
        <link rel="stylesheet" type="text/css" media="screen,tv,projection" href="<?php echo base_url(); ?>system/application/views/admin/css/screen.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>system/application/views/admin/js/global.js"></script>
    </head>
    <body>
        <div id="body">
            <div id="top">
                <!-- TODO: Logo goes here -->
            </div>
            <div id="navigation">
                <ul>
                    <li>Configuration
                        <ul>
                            <li><a href="#">Site settings</a></li>
                        </ul>
                    </li>
                    <li>System
                        <ul>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'dataobjects')); ?>">Data Object Types</a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'options'));   ?>">Option Types</a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'languages')); ?>">Languages</a></li>
                            <li><a href="<?php echo site_url(array('admin', 'manage', 'locales'));   ?>">Locales</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="tree">
                <!-- TODO: Build a tree of all the content -->
            </div>
            <div id="content">
