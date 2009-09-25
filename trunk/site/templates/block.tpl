<div class="block">
	<h2>{$header}</h2>
	<p>{$content}</p>
	{assign var=parent value=$dataObject->getParent()}
	Parent: {$parent->get('header')}
</div>