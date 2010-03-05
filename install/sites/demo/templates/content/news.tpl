<div class="newsItem">
	{*
		Make use of Smartys' date_format-modifier to format your timestamp
		to the dateformat you wish:
	*}
	<span class="date">{$date|date_format:"%d/%m<br />%Y"}</span>
	<h2>{$contentName}</h2>
	{$content}
</div>