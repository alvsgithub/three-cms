$(function(){
	$("form").submit(function(){		
		$("input[type=submit]", this).blur().attr("disabled", "disabled");
		$("img").show();
	});
});