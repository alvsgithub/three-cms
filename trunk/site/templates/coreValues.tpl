<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>{$title}</title>
		<link rel="stylesheet" type="text/css" media="screen" href="{$settings.base_url}site/css/screen.css" />
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
				<h2>{$locale.coreValues}</h2>
				{foreach from=$dataObject->children() item=child}
					{$child->render()}
				{/foreach}
			</div>
			<div id="footer">
				<p>&copy; {$smarty.now|date_format:"%Y"} || Powered by Three CMS</p>
			</div>
		</div>
	</body>
</html>
