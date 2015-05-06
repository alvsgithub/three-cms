**Important: In the current SVN and the upcoming releases Modules and Plugins will make place for one single option: Addons.**

# Introduction #

A plugin is a class which can be used to perform one or more specific actions. Plugin development in Three CMS is fairly simple.

# Details #

Plugins are stored in the `assets/plugins`-folder. There are a few basic rules each plugin should apply to:

  * Each plugin must have it's own distinctive folder in the plugins folder.
  * The filename of the plugin should be the same as the name of the folder.
  * The plugin must be a class.
  * This class must have the same name as the folder and it must start with an uppercase.

# Example: Hello World! #

First, follow the steps above:
  1. Create a folder in `assets/plugins` called `helloWorld`.
  1. In this folder create the file `helloWorld.php`. Note that the name is the same as the folder.
  1. In this PHP file create a class called `HelloWorld`. Note that the first character is now uppercase. It's up to you if you want this class to extend existing classes. It can extend default Code Igniter classes, or classes from Three CMS.

Let's put some very simple content in this plugin, so your helloWorld.php-file should look something like this:

```
<?php
  class HelloWorld
  {
    function sayIt()
    {
      echo 'Hello World!';
    }
  }
?>
```

# Usage #

The plugin can be used in your template by simply calling the plugin name the same way as you would call any parameter, and access it's properties or execute it's functions:

```
<html>
  <head>
    <title>Plugin example</title>
  </head>
  <body>
    {$helloWorld->sayIt()}
  </body>
</html>
```