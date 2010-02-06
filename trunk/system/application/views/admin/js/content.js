var currentTemplate;
var currentLanguage;
var CKeditors = [];

$(function(){
	currentLanguage = default_language;
	
	// Languagepicker:
	$("a.switchLanguage").click(function(){
		$("a.switchLanguage").removeClass("active");
		$(this).addClass("active");
		className = $(this).attr("class");
		a = className.split(' ');
		idName = a[1];
		a = idName.split('_');
		id = a[1];
		for(i=0; i<language_ids.length; i++) {
			$(".language_" + language_ids[i]).hide();
		}
		$(".language_" + id).show();
		currentLanguage = id;
		return false;
	});
	
	// Bigger / smaller:
	$("a.orderSmaller").click(function(){
		newVal = $("input[name=order]").val();
		newVal--;
		if(newVal < 0) { newVal = 0; }
		$("input[name=order]").val(newVal);
		return false;
	});
	
	$("a.orderBigger").click(function(){
		newVal = $("input[name=order]").val();
		newVal++;
		$("input[name=order]").val(newVal);
		return false;
	});
	
	// Override submit-function for ajax-functionality:
	$("form").submit(function(){
		// Check if all required fields are filled in:
		ok = true;
		$(".required", this).each(function(){			
			$(this).removeClass("error");
			if($(this).val()=='') {
				$(this).addClass("error");
				ok = false;
			}
		});
		if(ok) {
			// See if ID isn't 0, because if so, this is new content and it should be saved with a refresh:
			if($("input[name=id]").val()==0) {
				return true;
			}
			// Disable the submit button, and make the loading bar visible:
			$("input[type=submit]", this).attr("disabled", "disabled");
			$("img.loading").show();		
			// Get all the parameters and post them:
			data = {};
			$("input, select", this).each(function(){
				// Workaround for checkboxes:
				if($(this).attr("type")=="checkbox") {
					if($(this).attr("checked")) {
						data[$(this).attr("name")] = $(this).val();
					}
				} else {
					data[$(this).attr("name")] = $(this).val();
				}
			});
			// Textareas are done by ckEditor, so we must grab the data from ckEditor instead of the textarea itself.
			$("textarea", this).each(function(){
				instance = CKEDITOR.instances[$(this).attr("name")];
				if(instance != undefined) {
					// ckEditor instance:
					data[instance.name] = instance.getData();
				} else {
					// Regular textarea:
					data[$(this).attr("name")] = $(this).val();
				}
			});
			// Set the ajax-parameter to true, so the admin-part knows not to redirect after storage:
			data.ajax = true;
			// Send POST:
			$.post($(this).attr("action"), data, function(responseStr){
				response = responseStr.split(';');
				if(response.length==2) {
					// Reload the tree:
					$("#tree").load(baseURL + 'index.php/admin/ajax/fulltree #tree>*', function(){
						initializeTree();
					});
					$("#message").html('<p class="ok">' + response[1] + '</p>').slideDown("slow");				
				} else {
					alert(content_server_error);
				}
				$("input[type=submit]").removeAttr("disabled");
				$("img.loading").hide();
			});
		} else {
			alert(dialog_required);
		}
		// Return false:
		return false;
	});
	
	$("#message").click(function(){
		$(this).slideUp("slow");
	});
	
	// When changing template, load the options according to the chosen template:
	$("select[name=template]").click(function(){
		currentTemplate = $(this).val();
	}).change(function(){
		var ok = confirm(change_template);
		if(ok) {
			idTemplate = $(this).val();
			idParent   = $("input[name=parent]").val();
			idContent  = $("input[name=id]").val();
			// AJAX-call to load the correct options:			
			$("#loading").show();
			$("tr.option").remove();
			$.post(baseURL + 'index.php/admin/ajax/loadoptions', {template: idTemplate, parent: idParent, id: idContent}, function(data){
				$("#loading").hide();
				$("tr.optionsStart").after(data);
				setupContent();
			});
		} else {
			$(this).val(currentTemplate);
		}
		return ok;
	});
	
	// Setup the content:
	setupContent();
	
	$("a.showAlias").click(function(){
		$("tr.alias").show();
		return false;
	});
});

// Add all functionality:
function setupContent()
{
	// First hide all the languages:
	for(i=0; i<language_ids.length; i++) {
		$(".language_" + language_ids[i]).hide();
	}
	// Show the default languages:
	$(".language_" + currentLanguage).show();
	$(".l_" + currentLanguage).addClass("active");
	
	// Datepicker:
	$(".datePicker").dynDateTime({
		ifFormat: date_format,
		daFormat: date_format		
	});
	
	// Timepicker:
	$(".timePicker").timeEntry({
		show24Hours: true,
		useMouseWheel: true,
		spinnerImage: baseURL + 'system/application/views/admin/css/spinnerUpDown.png',
		spinnerSize: [15, 16, 0],
		spinnerIncDecOnly: true,
		spinnerRepeat: [250, 125]
	});
	
	// Tooltips:
	$("span.tooltip").hover(function(){
		pos = $(this).position();
		$(this).next().css({left: pos.left - 205, top: pos.top}).show();
	}, function(){
		$(this).next().hide();
	});	
	
	// TextArea's with the class 'richtext' should be ckeditors:
	// Remove all instances of previous declared CK-Editors:
	for(i=0; i<CKeditors.length; i++) {
		CKEDITOR.remove(CKeditors[i]);
	}
	CKeditors = []; // Hold an array with references
	$("textarea.richtext").each(function(){
		CKeditors.push(CKEDITOR.replace($(this).attr("name"), {filebrowserBrowseUrl: baseURL + "index.php/admin/browser"}));		
	});
	
	// Browse-button
	$("input[name=browse]").click(function(){
		inputField = $(this).prev();
		var left = screen.width/2 - 400;
		var top  = screen.height/2 - 300;
		window.open(baseURL + 'index.php/admin/browser', 'File browser', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=600,left='+left+',top='+top);
	});	
}