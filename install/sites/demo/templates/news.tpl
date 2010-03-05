<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{*
    "A Basic Website" - News page
    ---------------------------------------------------------------------------
    This page is used to display the 3 latest news items. It is also a great
    example on how to implement simple pagination.
*}
<html>
    <head>        
        <title>{$header} &laquo; {$settings.site_name}</title>
        <link rel="stylesheet" type="text/css" media="screen,tv,projecten" href="{$settings.base_url}/site/css/screen.css" />
    </head>

    <body>
        <div id="body">
            
            <div id="top">
                <h1>{$settings.site_name}</h1>
                {include file="includes/navigation.tpl"}
            </div>
            
            <div id="box">
                <div id="content">
                    <h1>{$header}</h1>
                    {*
                        See if there is a parameter set. On this page, the
                        parameter represents the page of news items:
                    *}
                    {assign var="itemsPerPage" value=3}
                    {if $parameters|@count eq 1}
                        {*
                            Use Smarty's math-function to calculate the
                            correct limit-account:
                        *}
                        {assign var="currentPage" value=$parameters[0]}
                        {math assign="limit" equation="$currentPage * $itemsPerPage"}
                    {else}
                        {assign var="currentPage" value=0}
                        {assign var="limit" value=0}
                    {/if}
                    {*
                        Show 3 news items:
                        The four parameters of the children()-function explained:
                        [1] : The ID of the content item to get the children
                              from. In this case, the current page.
                        [2] : The filter to filter by. In this case: only get
                              the items which have 'published' set to 1 (on).
                        [3] : The limit-parameter. In this case: show
                              $itemsPerPage amount of pages, skip the first
                              $limit.
                        [4] : The order-by-parameter. Order descending by the
                              date-option
                    *}                    
                    {foreach from=$this->children($idContent, "published=>1", "$itemsPerPage,$limit", "date desc") item=child}
                        {$child->render()}
                    {/foreach}
                    {*
                        Simple pagination:
                    *}
                    {assign var="tree" value=$this->getTree()}
                    {assign var="totalItems" value=$tree|@count}
                    {math assign="lastPage" equation="floor(x/$itemsPerPage)" x=$totalItems}
                    {if $totalItems gt $itemsPerPage}
                        <div class="paginator">
                            {if $currentPage gt 0}
                                <a href="{$this->getUrl()}/{math equation="x-1" x=$currentPage}">&laquo; previous</a>
                            {/if}
                            {if $currentPage lt $lastPage}
                                <a href="{$this->getUrl()}/{math equation="x+1" x=$currentPage}" class="next">next &raquo;</a>
                            {/if}
                        </div>
                    {/if}
                </div>
                
                <div id="footer">
                    <p>Powered by <a href="http://www.threecms.com" target="_blank">Three</a><a href="{$settings.base_url}/index.php/admin" class="login">login</a></p>
                </div>
            </div>
        </div>
    </body>
</html> 