$(function(){
	// Dashboard:
	$("#dashboard .item tr").hover(function(){
		$(this).addClass("hover");
	}, function(){
		$(this).removeClass("hover");
	}).click(function(){
		// $("a.edit", this).click();
		window.location = $("a:first", this).attr("href");
	});	
});