<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{*
    "A Basic Website"
    ---------------------------------------------------------------------------
    This is a demo website which is created with Three. It shows the following
    features of Three:
    
    - Introduction to the Smarty Template Engine
    - Introduction to some of Threes' predefined parameters
    - Example of how to include template-files
    - Example of how to create a simple navigation
    - Example of how to create a published/unpublished-option for news items.
    - Example for pagination (see news.tpl)
*}
<html>
    <head>        
        {*
            See how the site-settings can be called by using
            the pre-defined $settings-parameter:
        *}
        <title>{$header} &laquo; {$settings.site_name}</title>
        <link rel="stylesheet" type="text/css" media="screen,tv,projecten" href="{$settings.base_url}/site/css/screen.css" />
    </head>

    <body>
        <div id="body">
            
            <div id="top">
                <h1>{$settings.site_name}</h1>
                {*
                    Include other smarty templates, or pieces of templates
                    simply by using Smarty's include-command:
                *}
                {include file="includes/navigation.tpl"}
            </div>
            
            <div id="box">
                <div id="content">
                    {*
                        The options used by this content item can simply be
                        called as smarty-variables:
                    *}
                    <h1>{$header}</h1>
                    <p class="description">{$description}</p>
                    {$content}
                </div>
                
                <div id="footer">
                    <p>Powered by <a href="http://www.threecms.com" target="_blank">Three</a><a href="{$settings.base_url}/index.php/admin" class="login">login</a></p>
                </div>
            </div>
        </div>
    </body>
</html> 