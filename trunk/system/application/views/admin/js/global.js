var ajaxLoader = '<img src="'+baseURL+'system/application/views/admin/images/ajax-loader.gif" width="128" height="15" />';
var inputField;
var currentID = 0;
// var parentSelection = false;
// var moveAction = false;

$(function(){
	// Simple dropdown:
	$("#navigation li").hover(function(){
		$("ul", this).show();
	}, function(){
		$("ul", this).hide();
	});
	
	// Tree:
	// initializeTree();
	
	// Delete link:
	$("a.delete").click(function(){
		return confirm(dialog_delete);
	});
	
	// Parent selection:
	/*
	$("a.selectParent").click(function(){
		$("span", this).text(select_parent);
		setParentSelection();
		return false;		
	});
	*/
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
				// return node;
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
				id = $("var.id:first", node).text();
				$("#content").load(baseURL + 'index.php/admin/ajax/page_summary/' + id, function(){
					$("td.content_actions a.delete").click(function(){
						return confirm(dialog_delete_tree);
					});
					/*
					$("td.content_actions a.move").click(function(){
						$(this).addClass("inactive");
						setParentSelection();
						moveAction = true;
						return false;
					});
					*/
					$("#loading").hide();
				});
			},
			ondblclk: function(node) {
				// Modify:
				if($("var.modify:first", node).text()=='1') {
					id = $("var.id:first", node).text();
					window.location = baseURL + 'index.php/admin/content/edit/' + id;
				}
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

/*
function setParentSelection()
{
	$("#tree").css({backgroundColor: "#CCDDFF"}).animate({backgroundColor: "#FFFFFF"}, 1000);
	parentSelection = true;
}
*/

/*
function initializeTree()
{
	var iconClicked = false;
	
	$("#tree span.name, #tree span.icon").unbind("click");
	$("#tree span.icon").click(function(){
		// There is clicked on the icon. Expand the tree:
		iconClicked = true;
		var parent = $(this).parent().parent();
		id     = $('span.id:first var', parent).text();	// The ID of this content item
		// See if this parent has children:
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
	});
	
	$("#tree span.name").click(function(){
		// Only select this item if there is not clicked on the icon:
		if(!iconClicked) {
			var parent = $(this).parent();
			id     = $('span.id:first var', parent).text();	// The ID of this content item
			if(!parentSelection) {
				$("#tree span.name").removeClass("selected");
				$(this).addClass("selected");
				// Load the summary of this page:
				$("#loading").show();
				$("#content").load(baseURL + 'index.php/admin/ajax/page_summary/'+id, function(){
					$("td.content_actions a.delete").click(function(){
						return confirm(dialog_delete_tree);
					});
					$("td.content_actions a.move").click(function(){
						$(this).addClass("inactive");
						setParentSelection();
						moveAction = true;
						return false;
					});
					$("#loading").hide();
				});
			} else {
				if(id==$("input[name=id]").val()) {
					alert(dialog_parent_same_id);
					return;
				}
				// Check if the parent is not a descendand of the current documents ID (AJAX)
				// TODO: Check if this page is allowed to be a child of the newly selected parent.
				$.get(baseURL + 'index.php/admin/ajax/checkdescendant/'+id+'/'+$("input[name=id]").val(), function(data){
					if(data!='ok') {
						alert(dialog_parent_descendant);					
					} else {
						// Set the parent:
						if(moveAction) {
							// The action is done by the move-button in the summary-screen:
							$("#loading").show();
							$.post(baseURL + 'index.php/admin/content/move/' + $("span.idContent").text(), {id_content: id}, function(){
								// Reload the tree:
								$("#tree").load(baseURL + 'index.php/admin/ajax/fulltree #tree>*', function(){
									initializeTree();
									parentSelection = false;
									moveAction      = false;
									$("td.content_actions a.move").removeClass("inactive");
									$("#loading").hide();
								});
							});
						} else {
							// The action is done by the add/edit-screen:
							$("input[name=parent]").val(id);
							$("a.selectParent span").text('');
							parentSelection = false;
						}
					}
				});
			}			
		}
		// iconClicked = false;
	});
	
	// Root-selector:
	$("#tree strong.root").click(function(){
		if(parentSelection) {
			id = 0;
			if(moveAction) {
				// The action is done by the move-button in the summary-screen:
				$("#loading").show();
				$.post(baseURL + 'index.php/admin/content/move/' + $("span.idContent").text(), {id_content: id}, function(){
					// Reload the tree:
					$("#tree").load(baseURL + 'index.php/admin/ajax/fulltree #tree>*', function(){
						initializeTree();
						parentSelection = false;
						moveAction      = false;
						$("td.content_actions a.move").removeClass("inactive");
						$("#loading").hide();
						$("#tree strong.root").removeClass("hover");
					});
				});
			} else {
				// The action is done by the add/edit-screen:
				$("input[name=parent]").val(id);
				$("a.selectParent span").text('');
				$("#tree strong.root").removeClass("hover");
				parentSelection = false;
			}
		}
	}).hover(function(){
		if(parentSelection) {
			$(this).addClass("hover");
		}
	}, function(){
		if(parentSelection) {
			$(this).removeClass("hover");
		}
	});
}
*/

function keepAlive()
{
	$.post(baseURL + 'index.php/admin/ajax/keepalive');
}

function setInputValue(val)
{
	inputField.val(val);
}