$(function(){
	// First hide all the languages:
	for(i=0; i<language_ids.length; i++) {
		$(".language_" + language_ids[i]).hide();
	}
	// Show the default languages:
	$(".language_" + default_language).show();
	$(".l_" + default_language).addClass("active");
	
	// Bind the functions:
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
		// Return false:
		return false;
	});
	
	$("#message").click(function(){
		$(this).slideUp("slow");
	});
	
	// Datepicker:
	$(".datePicker").dynDateTime();
	
	// Tooltips:
	$("span.tooltip").hover(function(){
		pos = $(this).position();
		$(this).next().css({left: pos.left - 205, top: pos.top}).show();
	}, function(){
		$(this).next().hide();
	});
	
	// TODO: When changing template, load the options according to the chosen template:
	/*
	$("select[name=template]").change(function(){		
		var ok = confirm(change_template);
		if(ok) {
			idTemplate = $(this).val();
			// AJAX-call to load the correct options:			
			$("#loading").show();
			$("tr.option").remove();
			$.post(baseURL + 'index.php/admin/ajax/loadoptions', {template: idTemplate}, function(data){
				$("#loading").hide();
				$("tr.optionsStart").after(data);				
			});
		} else {
			
		}
		return ok;
	});
	*/
});