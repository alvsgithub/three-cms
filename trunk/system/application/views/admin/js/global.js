$(function(){
	// Simple dropdown:
	$("#navigation li").hover(function(){
		$("ul", this).show();
	}, function(){
		$("ul", this).hide();
	});
});