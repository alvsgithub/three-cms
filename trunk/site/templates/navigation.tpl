<div id="navigation">
	{* See how simple it is to create a navigation: *}
	<ul>
	{foreach from=$dataObject->children(0, 'published=>1') item=child}
		<li>
			<a {if $child->get('idContent') eq $idContent}class="active" {/if}href="{$child->getUrl()}">{$child->get('header')}</a>
		</li>
	{/foreach}
	</ul>
	{* Use of multilingual locales: *}
	<h2>{$locale.languagePicker}</h2>
	{* And how about a language switcher? Just like that: *}
	<ul class="language">
	{foreach from=$dataObject->getLanguages() item=language}
		<li>
			<a {if $language.id eq $idLanguage}class="active" {/if}href="{$language.url}">{$language.name}</a>
		</li>
	{/foreach}
	</ul>
	
	{* The power of external modules: *}
	{$webusers->checkLogin()}
	{if $webusers->loggedIn()}
		<p>Hallo {$webusers->userInfo('name')}!</p>
		<form method="post">
			<input type="submit" name="logout" value="logout" />
		</form>
	{else}
		<form method="post">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" />
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" />
			<input type="submit" value="login" name="login" />
		</form>
	{/if}
</div>