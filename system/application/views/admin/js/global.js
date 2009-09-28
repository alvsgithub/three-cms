var ajaxLoader = '<img src="'+baseURL+'system/application/views/admin/images/ajax-loader.gif" width="128" height="15" />';
var inputField;

$(function(){
	// Simple dropdown:
	$("#navigation li").hover(function(){
		$("ul", this).show();
	}, function(){
		$("ul", this).hide();
	});
	
	// Tree:
	initializeTree();
	
	// Delete link:
	$("a.delete").click(function(){
		return confirm(dialog_delete);
	});
	
	// TextArea's with the class 'richtext' should be ckeditors:
	$("textarea.richtext").each(function(){
		CKEDITOR.replace($(this).attr('name'));	
	});
	
	$("input[name=browse]").click(function(){
		inputField = $(this).prev();
		var left = screen.width/2 - 400;
		var top  = screen.height/2 - 300;
		window.open(baseURL + 'index.php/admin/browser', 'File browser', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=600,left='+left+',top='+top);
	});
});

function initializeTree()
{
	$("#tree span.name").unbind("click");
	$("#tree span.name").click(function(){
		parent = $(this).parent();
		$("#tree span.name").removeClass("selected");
		$(this).addClass("selected");
		id     = $('span.id:first var', parent).text();	// The ID of this content item		
		if(parent.hasClass("hasChildren")) {
			// See if there is content:		
			if($('div.innerTree', parent).length == 0) {
				parent.append('<div class="innerTree">'+ajaxLoader+'</div>');
				parent.addClass("open");
				// Load the tree:
				$.get(baseURL + 'index.php/admin/ajax/tree/'+id, function(data) {
					$("div.innerTree", parent).html(data);
					initializeTree();
				});
			} else {
				// Close:
				parent.removeClass("open");
				$("div.innerTree", parent).remove();
			}
		}
		$("#content").load(baseURL + 'index.php/admin/ajax/page_summary/'+id, function(){
			$("td.content_actions a.delete").click(function(){
				return confirm(dialog_delete_tree);
			});
		});
	});
}

function setInputValue(val)
{
	inputField.val(val);
}