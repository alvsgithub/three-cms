var ajaxLoader = '<img src="'+baseURL+'system/application/views/admin/images/ajax-loader.gif" width="128" height="15" />';
var inputField;
var parentSelection = false;

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
		CKEDITOR.replace($(this).attr('name'), {filebrowserBrowseUrl: baseURL + "index.php/admin/browser"});	
	});
	
	$("input[name=browse]").click(function(){
		inputField = $(this).prev();
		var left = screen.width/2 - 400;
		var top  = screen.height/2 - 300;
		window.open(baseURL + 'index.php/admin/browser', 'File browser', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=600,left='+left+',top='+top);
	});
	
	// Parent selection:
	$("a.selectParent").click(function(){
		$("span", this).text(select_parent);
		$("#tree").css({backgroundColor: "#CCDDFF"}).animate({backgroundColor: "#FFFFFF"}, 1000);
		parentSelection = true;
		return false;		
	});
});

function initializeTree()
{
	$("#tree span.name").unbind("click");
	$("#tree span.name").click(function(){
		parent = $(this).parent();
		id     = $('span.id:first var', parent).text();	// The ID of this content item		
		if(!parentSelection) {
			$("#tree span.name").removeClass("selected");
			$(this).addClass("selected");
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
					$.get(baseURL + 'index.php/admin/ajax/treeclose/'+id);
				}
			}
			$("#content").load(baseURL + 'index.php/admin/ajax/page_summary/'+id, function(){
				$("td.content_actions a.delete").click(function(){
					return confirm(dialog_delete_tree);
				});
			});			
		} else {
			if(id==$("input[name=id]").val()) {
				alert(dialog_parent_same_id);
				return;
			}
			// Check if the parent is not a descendand of the current documents ID (AJAX)
			$.get(baseURL + 'index.php/admin/ajax/checkdescendant/'+id+'/'+$("input[name=id]").val(), function(data){
				if(data!='ok') {
					alert(dialog_parent_descendant);					
				} else {
					// Set the parent:
					$("input[name=parent]").val(id);
					$("a.selectParent span").text('');
					parentSelection = false;
				}
			});
		}
	});
}

function setInputValue(val)
{
	inputField.val(val);
}