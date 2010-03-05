{*
	Create a simple navigation by using some core features of
	Three, and the basic features of Smarty:
*}
<ul class="navigation">
	{*
		Get all the children of the root(0) which have a
		option called 'show in menu' with the value '1':
	*}
	{foreach from=$this->children(0, 'show in menu=>1') item=child}
		{*
			If this child's ID is the current ID, then give
			the list-item the class 'active':
		*}
		<li {if $child->get('idContent') eq $idContent} class="active" {/if}>
			<a href="{$child->getUrl()}">{$child->get('contentName')}</a>
		</li>
	{/foreach}
</ul>
