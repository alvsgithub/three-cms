# Addon Development #

**Please note: Addons are not supported for beta 3 of Three CMS. Only the current SVN trunk and upcoming beta's will have addon support!**

Addons are small objects which can help you enrich your site. Addons can have multiple purposes. They can help you with small tasks, like easily create a form or convert a date, to complex structures like have webuser-management or a complete webshop!

# Details #

Addons are stored in the `assets/addons`-folder. There are a few basic rules each addon should apply to:

  * Each addon must have it's own distinctive folder in the addons folder.
  * The filename of the plugin must be `addon.php`.
  * The plugin must be a class.
  * This class must have the same name as the folder and it must start with an uppercase.
  * This class must extend `AddonBaseModel`.
  * The class must at least have 2 functions: `init()` and `getHooks()`.

## Empty addon structure ##

Assuming we create an addon called 'Hello World', we create a folder in our `assets/addons`-folder named `helloworld`. In this folder we create a php-file called `addon.php` with the following code:

```
class Helloworld extends AddonBaseModel
{
  /**
   * Initialize
   */
  function init()
  {
    // Initializing stuff can go here...
  }
	
  /**
   * This function tells Three CMS on which hook a function needs to be called
   */
  function getHooks()
  {
    // We'll handle hooks later
    $hooks = array();
    return $hooks;
  }
}
```

This addon will do completely nothing. Let's add a simple function to this addon:

```
function greet()
{
  return 'Hello World!';
}
```

To call this addon in our website, we simply use:

```
{$helloworld->greet()}
```

Functions can also have parameters:

```
function greet($language)
{
  switch($language) {
    case 'dutch' :
      return 'Hallo Wereld!';
      break;
    default :
      return 'Hello World!';
      break;
  }
}
```

So now we can do something like:

```
{$helloworld->greet('dutch')}
```

## So now what? ##

Well, you can create functionality for your site where Smarty comes short. And last but not least: You can use CodeIgniters functionality in your addons!

# Hooks #

Hooks are essential for addons. They'll let you execute functions on a given moment in your website. At the moment there are [limited hooks](Hooks.md), but the [list](Hooks.md) is growing... To use hooks we use our `getHooks()`-function. Three CMS calls this function when it loads the class after the `init()`-function. The function must return a two-dimensional array with the name of the hook and the callback-function to execute. An example:

```
function getHooks()
{
  $hooks = array(
    array('hook'=>'PreRenderPage', 'callback'=>'checkForPost')
  );
  return $hooks;
}

function checkForPost($context)
{
  if(isset($_POST['parameter'])) {

    ...Do something...

  }
}
```

You see that the `checkForPost()`-function gets a parameter called `$context`. Each callback is always provided with a multidimensional array with usefull parameters. If you look at the [Hooks-section](Hooks.md), you'll see which parameters are sent with each hook.