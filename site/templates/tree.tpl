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