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
});

function initializeTree()
{
	$("#tree li.hasChildren span.name").click(function(){
		parent = $(this).parent();
		// See if there is content:		
		if($('div.innerTree', parent).length == 0) {
			parent.append('<div class="innerTree">'+ajaxLoader+'</div>');
			parent.addClass("open");
			id = $('span.id var', parent).text();	// The ID of this content item
			// Load the tree:
			$.get(baseURL + 'index.php/admin/ajax/tree/'+id, function(data) {
				$("div.innerTree").html(data);
			});
		} else {
			// Close:
			parent.removeClass("open");
			$("div.innerTree", parent).remove();
		}
	});
}