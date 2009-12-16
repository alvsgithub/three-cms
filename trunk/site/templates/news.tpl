<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		{include file="head.tpl"}
	</head>
	<body>
		<div id="body">
			<div id="top">
				<h1>{$title}</h1>
			</div>
			{include file="navigation.tpl"}
			<div id="content">
				{if $contentObjects neq false}
					{if $webusers->allowed($contentObjects[0]->get('idContent'))}
						{$contentObjects[0]->render()}
					{/if}
				{else}
					<h1>{$header}</h1>
					<p>{$content}</p>					
					{foreach from=$dataObject->children() item=child}
						{if $webusers->allowed($child->get('idContent'))}
						{* See how all attributes of each child are available: *}
						<div class="newsItem">
							<h2>{$child->get('header')}</h2>
							<p>{$child->get('summary')}</p>
							<p class="readmore"><a href="{$child->getUrl()}">{$locale.readMore}</a>
						</div>
						{/if}
					{/foreach}
				{/if}
			</div>
			<div id="footer">
				<p>&copy; {$smarty.now|date_format:"%Y"} | Powered by Three CMS</p>
			</div>
		</div>
	</body>
</html>
