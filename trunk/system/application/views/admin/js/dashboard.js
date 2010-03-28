$(function(){
	// Dashboard:
	$("#dashboard .item tr:has(a)").hover(function(){
		$(this).addClass("hover");
	}, function(){
		$(this).removeClass("hover");
	}).click(function(){
		// $("a.edit", this).click();
		window.location = $("a:first", this).attr("href");
	});	
});