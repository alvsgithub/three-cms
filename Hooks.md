# Introduction #

Hooks are used by addons. There will be many hooks, but for now it is limited. If you have requests for hooks place them in the forum, or post them here.

# Hooks #

|**Name**|**When gets it executed?**|**Context-parameters**|
|:-------|:-------------------------|:---------------------|
| AppendMainNavigation |_backend_; allows you to add HTML after the main navigation|allowedAddons|
|AppendSubNavigation|_backend_; allows you to add HTML after the subnavigation|parent,allowedAddons|
|ShowModuleScreen|_backend_; gets used for a dedicated module page|alias,parameters[.md](.md)|
|ContentAboveOptions|_backend_; allows you to put HTML between the options and the top-options (language-picker etc.)|lang,contentData,templates,title,allowedTemplates,settings|
|ContentBelowOptions|_backend_; allows you to put HTML between the options and the save-button|lang,contentData,templates,title,allowedTemplates,settings|
|PreSaveContent|_backend_; before content is stored in the database.|idContent,contentData[.md](.md)|
|PostSaveContent|_backend_; after content gets stored in the database.|idContent,contentData[.md](.md)|
|PreRenderPage|_frontend_; before Smarty renders the page.|idPage,idLanguage,dataObject,parameters[.md](.md),dataObjects[.md](.md)|
|PostRenderPage|_frontend_; after Smarty has rendered the page.|idPage,idLanguage,dataObject,parameters[.md](.md),dataObjects[.md](.md)|
|AddOption|_backend_; allows you to add an option-tag after the list of options in the option window. Basicly it allows you to create your own type of options|lang,values[.md](.md)|
|ContentAddOption|_backend_; allows you to add HTML-code after an option in the content window. Basicly it allows you to add functionality to existing options, or create functionality for new type of options|type,inputName,value,class,item[.md](.md)|
|ModifyOptionValue|_backend_; allows you to change alter the value of an option. Please note that `$result` is a pointer, so any changes made to it will have effect on the option.|&result,dataObject|
|LoadPage|_frontend_; allows you to load Code Igniter libraries or helpers to use in your addon for the frontend.|&page|
|LoadAdmin|_backend_; allows you to load Code Igniter libraries or helpers to use in you addon for the backend.|&page|