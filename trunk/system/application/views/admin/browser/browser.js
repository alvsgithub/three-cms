var parent;
var currentFolder = '';
var currentPath   = '';
var ckEditor = false;
var ckEditorFuncNum;

$(function(){
	$("input[name=searchField]").hide();
	$("input[name=uploadField]").hide();
	$("input[name=uploadButton]").hide();	
	$("a.search").click(function(){		
		$("input[name=searchField]").css({width: 0}).show().animate({width: 200}).focus();		
		return false;
	});
	$(window).resize(resizeWindow);
	resizeWindow();
	loadTree();
	$("a.newFolder").click(function(){
		if(currentFolder!='') {
			name = prompt(dialog_new_folder);
			if(name!=null) {
				$.get(baseURL + 'index.php/admin/browser/newfolder/' + currentPath + '/' + name, function(){
					currentPath += '-' + name;
					loadTree();
				});
			}
		} else {
			alert(dialog_no_folder);
		}
		return false;
	});
	$("a.newFile").click(function(){		
		if(currentFolder!='') {
			$("input[name=uploadField]").css({width: 0}).show().animate({width: 200}).focus();		
			$("input[name=uploadButton]").css({width: 0}).show().animate({width: 100}).focus();		
		} else {
			alert(dialog_no_folder);
		}
		return false;
	});
	
	if(getQueryVariable("CKEditor")!=false) {
		ckEditor = window.opener.CKEDITOR; // document.getElementById(getQueryVariable("CKEditor"));	
		ckEditorFuncNum = getQueryVariable("CKEditorFuncNum");
	}
	
	$("input[name=uploadButton]").mousedown(function(){
		$("input[name=folder]").val(currentPath);
	});
});

function loadTree()
{
	$("#tree").load(baseURL + 'index.php/admin/browser #tree>*', function(){
		$("#tree span").click(function(){
			currentFolder = $(this).text();
			currentPath   = $(this).attr('rel');
			$("#tree span").removeClass("active");
			$("#tree li").removeClass("open");
			$(this).addClass("active");
			parent = $(this).parent();
			parent.addClass("open");
			// $(this).next().show();
			loadFileView();
		});
		// $("#tree ul ul").hide();	
		// Open the current path:
		if(currentPath!='') {
			$("#tree span").removeClass("active");
			$("#tree li").removeClass("open");
			var span = $('span[rel="'+currentPath+'"]');
			span.addClass("active");
			parent = span.parent();
			alert(currentPath);
			parent.addClass("open");
			loadFileView();
		}
	});
}

function loadFileView()
{
	$("#files").load(baseURL + 'index.php/admin/browser/files/' + currentPath, function(){		
		// Bind the delete-function:
		var deletion = false;
		var ok       = false;
		$("a.delete", this).click(function(){
			deletion = true;
			ok       = confirm(deleteFile);
			return ok;
		});			
		$(".file", this).click(function(){
			// Check if it is not the delete-link which is clicked:
			
			if(!deletion) {
				fileName = $("input[name=filename]", this).val();
				if(ckEditor!=false) {
					ckEditor.tools.callFunction(ckEditorFuncNum, fileName);
				} else {
					window.opener.setInputValue(fileName);
				}
				window.close();
			}
			if(!ok) {
				deletion = false;
			}
		});
	});
}

function resizeWindow()
{
	h = $(window).height();
	w = $(window).width();
	$("#tree").height(h-53);
	
	$("#files").height(h-43);
	$("#files").width(w-246);
}

function getQueryVariable(variable) {
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if (pair[0] == variable) {
			return pair[1];
		}
	}
	return false;
}