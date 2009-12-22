<?php
	// This file is going to export the entire site.
	
	// Step 1: Create an 'export'-folder on the root of the site:
	// See if the folder exists, if so, empty it:
	if(!file_exists('export')) {
		if(!mkdir('export')) {
			'<p class="error">Cannot create the export-folder. Please create it manually!</p>';
			return;		// Prevent further execution.
		}		
	}
	
	// Step 2: Walk through the site and parse it on the go:
	$startID = $settings['default_page_id'];
	
	// Require the correct models and smarty:
	initalizeSmarty();
	initializeDataModel();
	$adminModel = getAdminModel();
	$pageModel  = getPageModel();
	
	// Define the base url:
	define("BASE_URL", $settings['base_url']);
	// Define the site url:
	$site_url = $_POST['site_url'];
	// Check if there is a trailing slash:
	if(substr($site_url, strlen($site_url)-1, 1) != '/') {
		$site_url .= '/';
	}
	define("SITE_URL", $site_url);
	
	// A quick inline function to create the file:
	function createFile($file, $content) {
		if($handle = @fopen($file, 'w')) {
			fwrite($handle, $content);
			fclose($handle);
			echo '<li>Created file: '.$file.'</li>';
		} else {
			echo '<li class="error">Could not create file: '.$file.'</li>';
		}
	}
	
	// A quick inline function to create the dir:
	function createDir($dir)
	{
		if(@mkdir($dir)) {
			echo '<li>Created directory: '.$dir.'</li>';
		} else {
			echo '<li class="error">Could not create directory: '.$dir.'</li>';
		}
	}
	
	// A function to process the content
	function processContent($content)
	{
		$content = str_replace('<head>', "<head>\n<!-- This is an automated export of the site created using the export-module from Three CMS -->\n", $content);
		$content = str_replace(array(BASE_URL.'index.php/', BASE_URL), SITE_URL, $content);
		return $content;
	}
	
	// A quick recursive function to create the files:	
	function parseTree($adminModel, $pageModel, $idContent, $idLanguage, $languageCode, $preAlias='')
	{
		$pages = $adminModel->getTree($idContent);
		foreach($pages as $page) {
			// Create a folder for each page:
			$pageObject = $pageModel->getDataObject($page['id'], $idLanguage);
			
			// TODO: Loop through the page and it's parents to get the 'real' page.
			// If the template of the page is of the type 'content', then check the parent and send this page as a contentObject
			$type = $pageModel->getPageType($page['id']);
			if($type == 'content') {
				// Go up in the tree until a page of the type 'page' is found.
				$contentObjects = array($pageObject);
				$idPage = $page['id'];
				while($type == 'content') {
					$idParent    = $pageModel->getParent($idPage);
					$type        = $pageModel->getPageType($idParent);
					$pageObject2 = $pageModel->getDataObject($idParent, $idLanguage);
					
					if($type=='content') {
						array_push($contentObjects, $pageObject2);
					} 
					
					$idPage = $pageObject->get('idContent');
				}
				
				if(isset($pageObject2)) {					
					$pageObject2->contentObjects = $contentObjects;
				}
			}
			
			$alias = $pageObject->get('alias');
			createDir('export/'.$languageCode.'/'.$preAlias.$alias);
			if(!isset($pageObject2)) {
				createFile('export/'.$languageCode.'/'.$preAlias.$alias.'/index.html', processContent($pageObject->render(false)));				
			} else {
				createFile('export/'.$languageCode.'/'.$preAlias.$alias.'/index.html', processContent($pageObject2->render(false)));				
			}
			// Parse the children (recursive):				
			parseTree($adminModel, $pageModel, $pageObject->get('idContent'), $idLanguage, $languageCode, $alias.'/');
		}
	}
	
	// The magic starts here:
	echo '<ul>';
	
	// First create the default page:	
	$content = $pageModel->renderPage($startID, $settings['default_language'], false);
	createFile('export/index.html', processContent($content));
	
	// Create all the other pages:
	$languages  = $adminModel->getLanguages();
	foreach($languages as $language) {
		createDir('export/'.$language['code']);		
		// Create the default page for this language:
		$content = $pageModel->renderPage($startID, $language['id'], false);
		createFile('export/'.$language['code'].'/index.html', processContent($content));
		// Parse the site recursive:
		parseTree($adminModel, $pageModel, 0, $language['id'], $language['code']);
	}
	
	// The magic ends here:
	echo '</ul>';
	echo '<p>The site is exported to a static site. You might have to manually correct links here and there (such as stylesheet and javascript links).</p>';
?>