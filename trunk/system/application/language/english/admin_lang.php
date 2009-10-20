<?php
    // English Language file for the admin
    
    // Menu items:
    $lang['menu_users']					= 'Users';
	$lang['menu_ranks']					= 'Ranks';
	$lang['menu_web_users']				= 'Web users';
	$lang['menu_web_ranks']				= 'Web ranks';
	$lang['menu_configuration']     	= 'Configuration';
    $lang['menu_site_settings']     	= 'Site Settings';
    $lang['menu_system']            	= 'System';
    $lang['menu_templates']         	= 'Templates';
    $lang['menu_data_objects']      	= 'Data Object Types';
    $lang['menu_options']           	= 'Option Types';
    $lang['menu_languages']         	= 'Languages';
    $lang['menu_locales']           	= 'Locales';
    
    // Titles:
    $lang['title_templates']        	= 'Templates';
    $lang['title_data_objects']     	= 'Data Objects';
    $lang['title_options']          	= 'Option Types';
    $lang['title_languages']        	= 'Languages';
    $lang['title_locales']          	= 'Locales';
    $lang['title_notfound']         	= 'Not found';
    $lang['title_add_new_item']     	= 'Add a new %s';
    $lang['title_modify_item']      	= 'Modify %s';
	$lang['title_add_content']			= 'Add new content';
	$lang['title_modify_content']		= 'Edit content';
    $lang['title_settings']				= 'Settings';
	
    // Names:
    $lang['name_template']          	= 'template';
    $lang['name_data_object']       	= 'data object';
    $lang['name_option']            	= 'option';
    $lang['name_language']          	= 'language';
    $lang['name_locale']            	= 'locale';
    
    // Descriptions:
    $lang['desc_templates']        		= 'A template is used to render the data object to the screen in a presentational form. This can be a webpage, but it can also be a small part of a webpage, or something completely different, like a XML-file for instance.';
    $lang['desc_data_objects']     		= 'Data objects are a collection of options and are the base foundation of each content-item in your website. A data object specifies which options your content must have. For instance, a regular page should have at least a title and content, but other types of content, such as news items for instance, should have more options such as author name, publish date, etc.';
    $lang['desc_options']          		= 'A option is a single piece of data of a specific kind.';
    $lang['desc_languages']        		= 'Here you can specify which languages your site uses. You can also de-activate a language for a while.';
    $lang['desc_locales']          		= 'For multi-lingual sites you have some non-content-terms which should be translated for each country. For instance, the text on a button or the name of a shopping cart. This can easily be done with locales.';
    $lang['desc_notfound']         		= 'The page you are looking for cannot be found!';
    
    // Actions:
    $lang['action_add']            		= 'Add';
    $lang['action_modify']         		= 'Modify';
    $lang['action_duplicate']      		= 'Duplicate';
	$lang['action_duplicate_prefix']	= 'Duplicate of ';
    $lang['action_delete']         		= 'Delete';
	$lang['action_move']				= 'Move';
	$lang['action_add_type']			= 'Add new content of the type \'%s\'...';
    
    // Button titles:
    $lang['button_add_new_item']   		= 'Add a new %s...';    
    $lang['button_save']           		= 'Save';
	$lang['button_add_option']			= 'Add option';
    
	// Dialogs:
	$lang['dialog_delete']				= 'Are you sure you want to delete this item? This action cannot be undone!';
	$lang['dialog_delete_tree']			= 'Are you sure you want to delete this item? All child documents will also be deleted! This action cannot be undone!';
	$lang['dialog_option_exists']		= 'This option already exists in this data object. An option can only appear once in a data object!';
	
	// Options:
	$lang['option_small_text']			= 'Small Text';
	$lang['option_large_text']			= 'Large Text';
	$lang['option_rich_text']			= 'Rich Text';
	$lang['option_url']					= 'URL';
	$lang['option_image']				= 'Image';
	$lang['option_file']				= 'File';
	$lang['option_boolean']				= 'Boolean (yes/no)';
	$lang['option_dropdown']			= 'Dropdown list';
	$lang['option_selectbox']			= 'Select box (multiple values)';
	$lang['option_date']				= 'Date';
	$lang['option_time']				= 'Time';
	$lang['option_content']				= 'Content';
	$lang['option_content_of_type']		= 'Content of a specific type';
	
	// System settings:
	$lang['system_language_name']		= 'Name';
	$lang['system_language_code']		= 'Code';
	$lang['system_language_active']		= 'Active';
	$lang['system_locale_name']			= 'Name';
	$lang['system_options_name']		= 'Name';
	$lang['system_options_type']		= 'Type';
	$lang['system_options_default']		= 'Default Value';
	$lang['system_options_multi']		= 'Multilingual';
	$lang['system_template_allowed']	= 'Allowed Child Templates';
	$lang['system_template_name']		= 'Name';
	$lang['system_template_dataobject'] = 'Data Object';
	$lang['system_template_file']		= 'Template File';
	$lang['system_dataobject_name']		= 'Name';
	$lang['system_dataobject_linked']	= 'Linked Options';

	// Content information:
	$lang['content_id']					= 'ID';
	$lang['content_name']				= 'Name';
	$lang['content_template']			= 'Template';
	$lang['content_parent']				= 'Parent';
	$lang['content_alias']				= 'Alias';
	$lang['content_languages']			= 'Languages';
	$lang['content_language']			= 'Language';

    // Default text chunks:
    $lang['default_actions']        	= 'Actions';
    $lang['default_admin_panel']    	= 'Admin Panel';
	
	// File browser:
	$lang['browser_previous']			= 'Previous';
	$lang['browser_next']				= 'Next';
	$lang['browser_up']					= 'Up';
	$lang['browser_new_folder']			= 'New folder';
	$lang['browser_new_file']			= 'New file';
	$lang['browser_delete']				= 'Delete';
	$lang['browser_search']				= 'Search';
?>