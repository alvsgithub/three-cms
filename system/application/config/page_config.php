<?php

// Smarty constants
define('SMARTY_TEMPLATE_DIR', 'site/templates');				// Location of the Smarty-templates
define('SMARTY_COMPILE_DIR', 'system/smarty/templates_c');		// Location where to put the compiled templates
define('SMARTY_CACHE_DIR', 'system/smarty/cache');				// Location of the cached files
define('SMARTY_CONFIG_DIR', 'site/configs');					// Location of the site config files
define('SMARTY_DEBUG_TPL', '../../system/smarty/debug.tpl');	// Location of the debug template (for some reason this must be reset)
define('SMARTY_DIR', 'system/smarty/');							// Path to Smarty
define('SMARTY_COMPILE', true);									// Compile the templates? Set to false when the website is deployed
define('SMARTY_DEBUG', false);									// Show the debugger?
define('SMARTY_CACHE', 0);										// Cache the pages? 0=no 1=yes 2=yes, per file
define('SMARTY_CACHE_LIFETIME', 3600);							// Cache lifetime, in seconds

// Default page constants
define('DEFAULT_LANGUAGE_ID', 1);           					// The default language		// TODO: This should be gone, use settings in database instead
define('DEFAULT_PAGE_ID', 1);               					// The default page			// TODO: This should be gone, use settings in database instead

?>