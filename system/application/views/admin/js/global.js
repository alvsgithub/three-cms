// TODO: Update to the latest version of jQuery

var ajaxLoader = '<img src="'+baseURL+'system/application/views/admin/images/ajax-loader.gif" width="128" height="15" />';
var inputField;
var currentID = 0;

$(function(){
	// Simple dropdown:
	$("#navigation li").hover(function(){
		$("ul", this).show();
	}, function(){
		$("ul", this).hide();
	});
	
	// Delete link:
	$("a.delete").click(function(){
		return confirm(dialog_delete);
	});
	
	// Set interval to keep the session alive (runs each 5 minutes):
	setInterval('keepAlive()', 300000);	// 300000 ms = 5 minutes
	
	// No Click-buttons in the top navigation:
	$("a.noClick").click(function(){
		return false;
	});
	
	// Li-hover:
	$("#navigation>ul>li").hover(function(){
		$(this).addClass("hover");
	}, function(){
		$(this).removeClass("hover");
	});
	
	// Modules:
	$(".module ul.tabMenu a").click(function(){
		$(".module .tab").hide();
		$(".module .tabMenu a").removeClass("active");
		$(".module #" + $(this).attr("rel")).show();
		$(this).addClass("active");		
		return false;
	});
	$(".module ul.tabMenu li:first a").click();
	
	// jsTree:
	// When a node is moved, it may only be placed in another node which allows it's template				
	$("#treeContainer").tree({
		data : {
			async : true,
			opts : {
				'method' : 'POST',
				'url' : baseURL + 'index.php/admin/ajax/tree/' + currentID
			}
		},
		callback : {
			beforedata: function(node, tree_obj) {
				currentID = $("var.id:first", node).text();
				tree_obj.settings.data.opts.url = baseURL + 'index.php/admin/ajax/tree/' + currentID;				
				return true;
			},
			beforemove: function(node) {
				// See if this node is allowed to move:
				if($("var.move:first", node.node).text()=='1') {
					// See if this node is allowed in it's new parent:
					if(node.parent == -1) {
						// When node.parent = -1, this item is located on the root.
						return true;
					}
					allowed = $("var.allowed:first", node.parent).text().split(',');					
					current = $("var.template:first", node.node).text();
					if(in_array(current, allowed)) {
						return true;
					} else {
						alert('You cannot place this item here!');
						return false;
					}
				} else {
					alert('This item is not movable!');
					return false;
				}
			},
			onmove: function(node) {							
				// Reset the positions:							
				positions = [];
				// AJAX-call the new positions and the parent:
				if(node.parent == -1) {
					id_parent = 0;
					$("#treeContainer>ul>li>a").each(function(){
						positions.push($("var.id", this).text());
					});
				} else {
					id_parent = $("var.id:first", node.parent).text();
					$(">ul>li>a", node.parent).each(function(){
						positions.push($("var.id", this).text());
					});
				}
				id_item = $("var.id:first", node.node).text();
				data = {
					id_item: id_item,
					id_parent: id_parent,
					positions: positions.join(',')					
				};
				$.post(baseURL + 'index.php/admin/ajax/tree_move', data);
			},
			onselect: function(node) {
				// Select:
				$("#innerTree a").not($("a", node)).removeClass("clicked");
				
				$("#loading").show();
				id = $("var.id:first", node).text();
				$("#content").load(baseURL + 'index.php/admin/ajax/page_summary/' + id, function(){
					$("td.content_actions a.delete").click(function(){
						return confirm(dialog_delete_tree);
					});
					$("#loading").hide();
				});
			},
			ondblclk: function(node) {
				// Modify:
				$("#loading").show();
				if($("var.modify:first", node).text()=='1') {
					id = $("var.id:first", node).text();
					window.location = baseURL + 'index.php/admin/content/edit/' + id;
				}
			},
			onclose: function(node) {
				// Send ajax-call that the tree is closed:
				id = $("var.id:first", node).text();
				$.post(baseURL + 'index.php/admin/ajax/treeclose/' + id);
			}
		}
	});
});

function in_array (needle, haystack) {
	for (key in haystack) {
		if (haystack[key] == needle) {
			return true;
		}
	}
	return false;
}

function keepAlive()
{
	$.post(baseURL + 'index.php/admin/ajax/keepalive');
}

function setInputValue(val)
{
	inputField.val(val);
}