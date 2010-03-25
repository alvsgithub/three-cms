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
	$lang['menu_dashboard']				= 'Dashboard';
	$lang['menu_logout']				= 'Logout';
    
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
    $lang['title_dashboard']			= 'Dashboard';
	
    // Names:
    $lang['name_template']          	= 'template';
    $lang['name_data_object']       	= 'data object';
    $lang['name_option']            	= 'option';
    $lang['name_language']          	= 'language';
    $lang['name_locale']            	= 'locale';
    $lang['name_dashboard']            	= 'dashboard item';
    
    // Descriptions:
    $lang['desc_templates']        		= 'A template is used to render the data object to the screen in a presentational form. This can be a webpage, but it can also be a small part of a webpage, or something completely different, like a XML-file for instance.';
    $lang['desc_data_objects']     		= 'Data objects are a collection of options and are the base foundation of each content-item in your website. A data object specifies which options your content must have. For instance, a regular page should have at least a title and content, but other types of content, such as news items for instance, should have more options such as author name, publish date, etc.';
    $lang['desc_options']          		= 'A option is a single piece of data of a specific kind.';
    $lang['desc_languages']        		= 'Here you can specify which languages your site uses. You can also de-activate a language for a while.';
    $lang['desc_locales']          		= 'For multi-lingual sites you have some non-content-terms which should be translated for each country. For instance, the text on a button or the name of a shopping cart. This can easily be done with locales.';
    $lang['desc_dashboard']        		= 'Dashboard items are used as quick-steps to managing certain content objects. They can be helpfull as shortcuts to most common used functionality for your website.';
    $lang['desc_notfound']         		= 'The page you are looking for cannot be found!';
    
    // Actions:
    $lang['action_add']            		= 'Add';
    $lang['action_modify']         		= 'Modify';
    $lang['action_duplicate']      		= 'Duplicate';
	$lang['action_duplicate_prefix']	= 'Duplicate of ';
    $lang['action_delete']         		= 'Delete';
	$lang['action_move']				= 'Move';
	$lang['action_add_type']			= 'Add new content of the type \'%s\'...';
    $lang['action_visible']          	= 'Visible';
    
    // Button titles:
    $lang['button_add_new_item']   		= 'Add a new %s...';    
    $lang['button_save']           		= 'Save';
	$lang['button_add_option']			= 'Add option';
	$lang['button_upload']				= 'Upload';
    
	// Dialogs:
	$lang['dialog_delete']				= 'Are you sure you want to delete this item? This action cannot be undone!';
	$lang['dialog_delete_tree']			= 'Are you sure you want to delete this item? All child documents will also be deleted! This action cannot be undone!';
	$lang['dialog_option_exists']		= 'This option already exists in this data object. An option can only appear once in a data object!';
	$lang['dialog_parent_same_id']		= 'You cannot set the document as a parent of itself!';
	$lang['dialog_parent_descendant']	= 'You cannot set a descendant of this document as the parent of this document!';
	$lang['dialog_new_folder']			= 'Please enter the name of the new folder:';
	$lang['dialog_no_folder']			= 'Please select a folder to perform this action.';
	$lang['dialog_change_template']     = 'Are you sure you want to change the template of this page? All changes you have made to this template after the last time you saved will be lost!';
	$lang['dialog_required']			= 'Some required fields are left empty!';
	
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
	
	// Dashboard:
	$lang['system_dashboard_name']			= 'Name';
	$lang['system_dashboard_type']			= 'Type';
	$lang['system_dashboard_from_parent']	= 'From parent';
	$lang['system_dashboard_from_template']	= 'From template';
	$lang['system_dashboard_from_addon']	= 'From addon';
	$lang['system_dashboard_source']		= 'Source';
	$lang['system_dashboard_headers']		= 'Headers';
	$lang['system_dashboard_count']			= 'Count';
	$lang['system_dashboard_column']		= 'Column';
	$lang['system_dashboard_left']			= 'Left';
	$lang['system_dashboard_right']			= 'Right';
	
	// System settings:
	$lang['system_language_name']		= 'Name';
	$lang['system_language_code']		= 'Code';
	$lang['system_language_active']		= 'Active';
	$lang['system_locale_name']			= 'Name';
	$lang['system_options_name']		= 'Name';
	$lang['system_options_description']	= 'Description';
	$lang['system_options_tooltip']		= 'Tooltip';
	$lang['system_options_options']		= 'Options';
	$lang['system_options_type']		= 'Type';
	$lang['system_options_default']		= 'Default Value';
	$lang['system_options_multi']		= 'Multilingual';
	$lang['system_options_required']	= 'Required';
	$lang['system_template_allowed']	= 'Allowed Child Templates';
	$lang['system_template_name']		= 'Name';
	$lang['system_template_dataobject'] = 'Data Object';
	$lang['system_template_file']		= 'Template File';
	$lang['system_template_ranks']		= 'Template is available for the following ranks';
	$lang['system_template_root']		= 'Can be added to the root';
	$lang['system_template_type']		= 'Type';
	$lang['system_template_type_page']	= 'Page';
	$lang['system_template_type_content'] = 'Content';
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
	$lang['content_select_parent']		= 'Select a parent from the tree on the right of the screen';
	$lang['content_order']				= 'Order';
	$lang['content_stored']				= 'Content succesfully stored';
	$lang['content_server_error']		= 'Content not saved due to an internal server error!';
	$lang['content_moved']				= 'Content successfully moved!';
	$lang['content_show_alias']			= 'show alias';
	$lang['content_auto_alias']			= 'if no alias is supplied, one will be generated automaticly';

    // Default text chunks:
    $lang['default_actions']        	= 'Actions';
    $lang['default_admin_panel']    	= 'Admin Panel';
	$lang['default_one_moment']			= 'One moment please...';
	
	// File browser:
	$lang['browser_previous']			= 'Previous';
	$lang['browser_next']				= 'Next';
	$lang['browser_up']					= 'Up';
	$lang['browser_new_folder']			= 'New folder';
	$lang['browser_new_file']			= 'New file';
	$lang['browser_delete']				= 'Delete';
	$lang['browser_search']				= 'Search';
	
	// Tree:
	$lang['tree_add']					= 'Add new content to the root';
	
	// Users:
	$lang['users_title']				= 'Users';
	$lang['users_add']					= 'Add a new user';
	$lang['users_edit']					= 'Edit user';
	$lang['users_username']				= 'Username';
	$lang['users_password']				= 'Password';
	$lang['users_password_again']		= 'Password (again)';
	$lang['users_name']					= 'Name';
	$lang['users_email']				= 'E-mail address';
	$lang['users_rank']					= 'Rank';
	
	// Ranks:
	$lang['ranks_title']				= 'Ranks';
	$lang['ranks_add']					= 'Add a new rank';
	$lang['ranks_edit']					= 'Edit rank';
	$lang['ranks_name']					= 'Name';
	$lang['ranks_system']				= 'User can manage system functionality';
	$lang['ranks_users']				= 'User can manage user accounts';
	$lang['ranks_ranks']				= 'User can manage ranks';
	$lang['ranks_configuration']		= 'User can edit the sites configuration';
	$lang['ranks_addons']				= 'Allowed addons';
	$lang['ranks_templates']			= 'Template rights';
	$lang['ranks_no_addons']			= 'No addons found!';
	
	// Login:
	$lang['login_title']				= 'Login';
	$lang['login_username']				= 'Username';
	$lang['login_email']				= 'E-mail address';
	$lang['login_password']				= 'Password';
	$lang['login_submit_button']		= 'Login';
	$lang['login_send_button']			= 'Send';
	$lang['login_error']				= 'You entered the wrong username and/or password!';
	$lang['login_forgot']				= 'Did you forgot your password?';
	$lang['login_forgot_instructions']	= 'Please enter your e-mail address below and the login instructions will be sent to your e-mail address';
	$lang['login_mail_subject']			= 'New password request for [[WEBSITE]]';
	$lang['login_mail_message']			= "Someone (probably you) requested a new password for [[WEBSITE]].\n\nTo confirm that it was you who made this request please click on the following link:\n[[URL]]\n\nIf it wasn't you who made this request or simply don't want to change your password you can simply delete this e-mail. Your password will not be reset.";
	$lang['login_new_password']			= 'Your new password';
	$lang['login_new_password_text']	= 'Your new password is:[[PASSWORD]]Please make sure to write it down and keep it in a safe place because this is the only time your password will be shown. You can change your password after you login.';
	$lang['login_new_password_fail']	= 'Something went wrong while trying to reset your password. Your URL is probably incorrect. If you tried copy-pasting the URL please make sure there are no additional characters that may have been included accidentily. If the problem persists, please contact your system administrator.';
	$lang['login_continue']				= 'Continue to login';
	$lang['login_request_title']		= 'New password request';
	$lang['login_request']				= 'An e-mail has been sent to the e-mail address you supplied. Please follow the instructions in this e-mail to reset your password.';
	$lang['login_request_mailfail']		= 'There could be no user found with the e-mail address you supplied.';
	$lang['login_request_fail']			= 'Something went wrong while trying to send the e-mail request. Please contact your system adminstrator.';
	
	// Messages:
	$lang['message_users_using_rank']	= 'You cannot delete this rank! There are still users using it!';
	$lang['message_delete_admin_rank']	= 'You cannot delete the administrators rank!';
	$lang['message_delete_admin']		= 'You cannot delete the administrators user!';
	$lang['message_empty_password']		= 'User not saved: Password cannot be empty for a new user!';
	$lang['message_passwords_no_match']	= 'User not saved: Supplied passwords do not match!';
	
	// Addons:
	$lang['addon_notfound_title']		= 'Addon not found';
	$lang['addon_notfound'] 			= 'The addon you requested could not be found!';
?>