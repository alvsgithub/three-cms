var ajaxLoader = '<img src="'+baseURL+'system/application/views/admin/images/ajax-loader.gif" width="128" height="15" />';
var inputField;
var parentSelection = false;
var moveAction = false;

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
		setParentSelection();
		return false;		
	});
	
	// Set interval to keep the session alive (runs each 5 minutes):
	setInterval('keepAlive()', 300000);	// 300000 ms = 5 minutes
});

function setParentSelection()
{
	$("#tree").css({backgroundColor: "#CCDDFF"}).animate({backgroundColor: "#FFFFFF"}, 1000);
	parentSelection = true;
}

function initializeTree()
{
	var iconClicked = false;
	
	$("#tree span.name, #tree span.icon").unbind("click");
	$("#tree span.icon").click(function(){
		// There is clicked on the icon. Expand the tree:
		iconClicked = true;
		parent = $(this).parent().parent();
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
			parent = $(this).parent();
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
}

function keepAlive()
{
	$.post(baseURL + 'index.php/admin/ajax/keepalive');
}

function setInputValue(val)
{
	inputField.val(val);
}