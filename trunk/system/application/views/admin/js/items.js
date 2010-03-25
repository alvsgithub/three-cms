$(function(){
	// Items table:
	$("table.items tr").hover(function(){
		$(this).addClass("hover");
	}, function(){
		$(this).removeClass("hover");
	}).click(function(){
		// $("a.edit", this).click();
		window.location = $("a.edit", this).attr("href");
	});
});