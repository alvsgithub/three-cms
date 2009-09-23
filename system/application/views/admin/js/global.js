var ajaxLoader = '<img src="'+baseURL+'system/application/views/admin/images/ajax-loader.gif" width="128" height="15" />';

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
});

function initializeTree()
{
	$("#tree span.name").unbind("click");
	$("#tree span.name").click(function(){
		parent = $(this).parent();		
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