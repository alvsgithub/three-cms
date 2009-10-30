$(function(){
	// First hide all the languages:
	for(i=0; i<language_ids.length; i++) {
		$(".language_" + language_ids[i]).hide();
	}
	// Show the default languages:
	$(".language_" + default_language).show();
	$(".l_" + default_language).addClass("active");
	
	// Bind the functions:
	$("a.switchLanguage").click(function(){
		$("a.switchLanguage").removeClass("active");
		$(this).addClass("active");
		className = $(this).attr("class");
		a = className.split(' ');
		idName = a[1];
		a = idName.split('_');
		id = a[1];
		for(i=0; i<language_ids.length; i++) {
			$(".language_" + language_ids[i]).hide();
		}
		$(".language_" + id).show();
		return false;
	});
	
	// Bigger / smaller:
	$("a.orderSmaller").click(function(){
		newVal = $("input[name=order]").val();
		newVal--;
		if(newVal < 0) { newVal = 0; }
		$("input[name=order]").val(newVal);
		return false;
	});
	
	$("a.orderBigger").click(function(){
		newVal = $("input[name=order]").val();
		newVal++;
		$("input[name=order]").val(newVal);
		return false;
	});
	
});