var parent;

$(function(){
	$("input[name=searchField]").hide();
	$("a.search").click(function(){		
		$("input[name=searchField]").css({width: 0}).show().animate({width: 200}).focus();		
		return false;
	});
	$("#tree span").click(function(){
		$("#tree span").removeClass("active");
		$("#tree li").removeClass("open");
		$(this).addClass("active");
		parent = $(this).parent();
		parent.addClass("open");
		$(this).next().show();
		$("#files").load(baseURL + 'index.php/admin/browser/files/' + $(this).attr('rel'), function(){
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
	});
	$("#tree ul ul").hide();
	
	
	$(window).resize(resizeWindow);
	resizeWindow();	
});

function resizeWindow()
{
	h = $(window).height();
	w = $(window).width();
	$("#tree").height(h-53);
	
	$("#files").height(h-43);
	$("#files").width(w-246);
}