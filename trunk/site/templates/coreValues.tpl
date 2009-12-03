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
				<h1>{$header}</h1>
				<p>{$content}</p>
				{* Locales can easily be used in your multilingual site: *}
				<h2>{$locale.coreValues}</h2>
				{foreach from=$dataObject->children() item=child}
					{* See how each child can be rendered by using it's own template: *}
					{$child->render()}
				{/foreach}
			</div>
			<div id="footer">
				{* Simple use of all Smarty's core features: *}
				<p>&copy; {$smarty.now|date_format:"%Y"} | Powered by Three CMS</p>
			</div>
		</div>
	</body>
</html>
