$(function(){
	// Modules:
	$(".module ul.tabMenu a").click(function(){
		$(".module .tab").hide();
		$(".module .tabMenu a").removeClass("active");
		$(".module #" + $(this).attr("rel")).show();
		$(this).addClass("active");		
		return false;
	});
	$(".module ul.tabMenu li:first a").click();
});