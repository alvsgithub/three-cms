# Introduction #

First of all, Three CMS uses the Smarty template engine for template parsing. For documentation on this template engine, please read the documentation on [the Smarty website](http://www.smarty.net).

# Creating templates #

## Default parameters ##

When creating templates, each option of a page is a parameter you can use. For instance, if your page has a header, an introtext and a content-part with the names 'header', 'introtext' and 'content', your template could look something like this:

```
<html>
  <head>
    <title>{$header}</title>
  </head>
  <body>
    <h1>{$header}</h1>
    <p class="intro">{$introtext}</p>
    {$content}
  </body>
</html>
```

## Predefined parameters ##

There are some predefined parameters. These are:

### Settings ###

The settings are the main settings as defined in the CMS. These can be called with the `{$settings}`-tag. To get a single setting you can use `{$settings._setting_}`, where `_setting_` is the name of your setting. For example, to display the site name you can use: `{$settings.site_name}`.

### Locales ###

Locales are certain words that are used for multilingual sites. For example: the value of a previous- or next-link is different in different languages. This is where locales are for. You can use a locale by using the `{$locale}`-tag. To get a single locale you can use `{$locale._locale_}`, where `_locale_` is the name of your locale. For example, if you have a locale with the name 'helloWorld' you should write this as: `{$locale.helloWorld}`.

### Parameters ###

Parameters are used to get the parameters send with your URL. For example: when your page is `example.com/news/item/34` and there is no content object with the alias '34', the value '34' is set in the parameters-array. If there is neither a content object with the alias 'item' in this case, both 'item' and '34' are passed as parameters. This goes on until a valid content object is found.

### Content Objects ###

Content objects that are created according to your URL. For example: take an URL such as `example.com/news/new-cms`. In this case 'news' is of the type 'page' and 'new-cms' is of the type 'content'. Therefore, the page 'news' will get rendered with as contentObject 'new-cms'. An example of how such HTML could look like:

```
<html>
  <head>
    <title>{$header}</title>
  </head>
  <body>
    <h1>{$header}</h1>
    {* If there are content-objects given, render the first one: *}
    {if $contentObjects neq false}
      {$contentObjects[0]->render()}

    {* Otherwise: show the default content: *}
    {else}
      <p class="intro">{$introtext}</p>
      {$content}
    {/if}
  </body>
</html>
```

### This ###

The `{$this}`-parameter is a reference to the current dataobject. Example:

```
<html>
  <head>
    <title>{$header}</title>
  </head>
  <body>
    {* Create a simple menu: *}
    <ul>
      {foreach from=$this->children() item=child}
        <li><a href="{$child->getUrl()}">{$child->get('header')}</a></li>
      {/foreach}
    </ul>
  </body>
</html>
```

Note: Before beta 3 this parameter was referenced to as `{$dataObject}`.

### Other parameters ###

Besides the above special parameters, there are some other parameters that are predefined for each data object:
  * `{$idContent}` : The ID of the current data object.
  * `{$idLanguage}` : The ID of the current language.
  * `{$alias}` : The alias of the current data object.
  * `{$contentName}` : The name of the current data object.
  * `{$order}` : The (menu-)order of the current data object.

## Functions ##

A data object also has some functions to use:

### children() ###

**`function children($idContent = null, $options = null, $limit = null, $orderby = null)`**

Get the children of this dataModel.

**$idContent:** The ID of the parent to get the children from. If ID is set to null (default), the current dataobjects' ID is used<br />
**$options:** An associated array with options to use as filter. Because Smarty doesn't natively accept arrays, arrays should be formatted as a string. See the below examples how this works.<br />
**$limit:** An array with one ore two values for the limit-options<br />
**$orderby:** A string to order by: 'optionName asc/desc'. example: 'myDate asc'

This function returns an array with dataModels.

Example 1:

```
{* Create a simple menu: *}
<ul>
  {foreach from=$this->children() item=child}
    <li><a href="{$child->getUrl()}">{$child->get('header')}</a></li>
  {/foreach}
</ul>
```

Example 2, only show pages which are placed on the root (id=0), and have the `show in menu`-option to on (1):
```
{* Create a simple menu: *}
<ul>
  {foreach from=$this->children(0, 'show in menu=>1') item=child}
    <li><a href="{$child->getUrl()}">{$child->get('header')}</a></li>
  {/foreach}
</ul>
```

### child() ###

**`function child($idContent=null, $options=null, $num=0)`**

Get a specific child of this dataModel

**$idContent:** The ID of the parent to get the children from. If ID is set to null (default), the current dataobjects' ID is used<br />
**$options:** An array with options to use as filter
**$num**: The number of the child to retrieve (default=the first)

**Returns:** A single datamodel or false of no model is found

### getTree() ###

**`function getTree($startID=null, $templates=null, $optionConditions=null)`**

Create a tree of this dataModel and all it's children (recursive).

**$startID:** The ID to see as te root parent. Set to null to use the current dataModel's ID.<br />
**$templates:** An array containing the ID's of the templates to allow in this tree. Set to null to allow all templates.<br />
**$optionConditions:** An associated array holding the name of the options and their value to which the content should be filterd. Set to null to allow all content

**Returns:** A multi-dimensional array of the whole tree

### getUrl() ###

**`function getUrl($idContent = null, $idLanguage = null)`**

Create the url to this dataobject.

**$idContent:** The ID of the content to create the URL of, if left empty, the URL of the current page is returned.<br />
**$idLanguage:** The ID of the language to use for this URL. null for current language

### getAlias() ###

**`getAlias($idContent)`**

Get the alias of a given content ID

**$idContent:** The ID of the content to get the alias from

**Returns:** The alias

### getLanguageCode() ###

**`function getLanguageCode($idLanguage = null)`**

Get the language code

**$idLanguage:** The ID of the language

**Returns:** The code of the language (string)

### parents() ###

**`function parents($idContent = null)`**

Get an array with all the parents

**$idContent:** The ID of the child to get the parents from. If ID is set to null (default), the current dataObjects' ID is used.

**Returns:** An array with dataModels.

### getLanguages() ###

**`function getLanguages()`**

Create an array with the different languages this website uses.

**Returns:** A 2-dimensional array.

### firstParent() ###

**`function firstParent($idContent = null)`**

**$idContent:** The ID of the child to get the first parent from. If ID is set to null (default), the current dataobjects' ID is used.

**Returns:** A single datamodel.

### getParent() ###

**`function getParent($idContent = null)`**

Get the parent

**$idContent:** The ID of the child to get the parent from. If ID is set to null (default), the current dataobjects' ID is used.

### get() ###

**`function get($parameter)`**

Get a specific parameter

**$parameter:** The name of the parameter.

**Returns:** The value

Example:

```
{foreach from=$this->children() item=child}
  {* See how all attributes of each child are available: *}
  <div class="newsItem">
    <h2>{$child->get('header')}</h2>
    <p>{$child->get('summary')}</p>
    <p class="readmore"><a href="{$child->getUrl()}">{$locale.readMore}</a></p>
  </div>
{/foreach}
```

### render() ###

**`function render($display = true)`**

Renders the current data object

**$display:** Display the page (true) or return it as a string (false)

**Returns:** Empty string on success or a string with the content if display is false.

Example:

```
{foreach from=$this->children() item=child}
  {$child->render()}
{/foreach}
```