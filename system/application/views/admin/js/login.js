$(function(){
	$("form").submit(function(){		
		$("input[type=submit]", this).blur().attr("disabled", "disabled");
		$("img").show();
	});
	$("p.password a").click(function(){
		$("div.forgot_password").show();
		return false;
	});
});