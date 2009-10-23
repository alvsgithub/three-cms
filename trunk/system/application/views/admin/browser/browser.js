var parent;
var currentFolder = '';
var currentPath   = '';

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
				window.opener.setInputValue(fileName);
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