# Introduction #

Here are some snippets you can use in your template

## Simple navigation ##

A simple navigation in an unordered list where the link of the current page gets a class called 'active':

```
<ul>
  {foreach from=$this->children(0) item=child}
    <li>
      <a {if $child->get('idContent') eq $idContent}class="active" {/if}href="{$child->getUrl()}">{$child->get('header')}</a>
    </li>
  {/foreach}
</ul>
```

## Navigation with 'first' and 'last'-class ##

The same navigation only the first list item has the class 'first' and the last list item has the class 'last':

```
<ul>
  {foreach from=$this->children(0) item=child name=navigation}
    <li>
      <a class="{if $child->get('idContent') eq $idContent}active{/if} {if $smarty.foreach.navigation.first}first{/if} {if $smarty.foreach.navigation.last}last{/if}" href="{$child->getUrl()}">{$child->get('contentName')}</a>
    </li>			
  {/foreach}
</ul>
```

## Language picker ##

A simple language picker which leads to the homepage of the selected language. The current language gets a class called 'active':

```
<ul class="language">
  {foreach from=$this->getLanguages() item=language}
    <li>
      <a {if $language.id eq $idLanguage}class="active" {/if}href="{$language.url}">{$language.name}</a>
    </li>
  {/foreach}
</ul>
```

## Published / Unpublished functionality ##

You can add published/unpublished-functionality by creating a published option of the type Boolean and filter them on the frontend. For this example we created a Boolean-option called 'published'.

**navigation example:**
```
<ul>
  {foreach from=$this->children(0, 'published=>1') item=child}
    <li>
      <a href="{$child->getUrl()}">{$child->get('header')}</a>
    </li>
  {/foreach}
</ul>
```

**page example:**
```
{if $this->get('published') eq '1'}
  ... show content ...
{else}
  <p>This page is not yet published!</p>
{/if}
```

## Site tree ##

Create easily a sitemap with Smarty:

Create a file called tree.tpl with the following code:
```
{assign var='tree' value=$this->children($id)}
{if $tree|@count gt 0}
<ul>
	{foreach from=$tree item=child}
		<li>			
			<a href="{$child->getUrl()}">{$child->get('contentName')}</a>
			{include file="tree.tpl" id=$child->idContent}
		</li>
	{/foreach}
</ul>
{/if}
```

To show the tree in your site use:
```
{include file="tree.tpl" id='0'}
```

## Pagination ##

Create simple pagination with Smarty:

This example uses the `$parameters`-variable to check which page to show.

```
{*
  Setup the pagination; set the amount of items to show for each page,
  set the current page, and set the limit for the current page:
*}
{assign var="itemsPerPage" value=3}
{if $parameters|@count eq 1}
  {assign var="currentPage" value=$parameters[0]}
  {math assign="limit" equation="$currentPage * $itemsPerPage"}
{else}
  {assign var="currentPage" value=0}
  {assign var="limit" value=0}
{/if}
{*
  Show the items:
*}                    
{foreach from=$this->children($idContent, "", "$itemsPerPage,$limit") item=child}
  ...do your stuff here...  
{/foreach}
{*
  Show the paginator:
*}
{assign var="tree" value=$this->getTree()}
{assign var="totalItems" value=$tree|@count}
{math assign="lastPage" equation="floor(x/$itemsPerPage)" x=$totalItems}
{if $totalItems gt $itemsPerPage}
  <div class="paginator">
    {if $currentPage gt 0}
      <a href="{$this->getUrl()}/{math equation="x-1" x=$currentPage}">previous</a>
    {/if}
    {if $currentPage lt $lastPage}
      <a href="{$this->getUrl()}/{math equation="x+1" x=$currentPage}">next</a>
    {/if}
  </div>
{/if}
```

## Format date ##

Convert a timestamp to a date by using Smarty's date\_format-modifier:
```
<p class="date">{$date|date_format:"%d/%m/%Y"}</p>
```

## Show content before a horizontal rule ##

This is ideal for scenario's where you want to display the first piece of an article, followed by a read-more-button. In the backend, you can use a horizontal rule as the seperator.

```
{assign var="shortContent" value="<hr />"|explode:$content}
{$shortContent[0]}
```

To hide the horizontal rule from being shown in the full article use:

```
{$content|replace:"<hr />":""}
```