$(function(){
	// Steps:
	$(".step1").click(function() { showStep(1); });
	$(".step2").click(function() { showStep(2); });
	$(".step3").click(function() { showStep(3); });
	$(".step4").click(function() { showStep(4); });
	$(".step5").click(function() { showStep(5); });
	$(".step6").click(function() { showStep(6); });
	
	// License agreement:
	$("input[name=license]").click(function(){
		if($(this).attr("checked")) {
			$("input.next.step3").removeAttr("disabled");
		} else {
			$("input.next.step3").attr("disabled", "disabled");
		}
	});
	
	// Database check:
	$("input[name=dbcheck]").click(function(){
		$(this).attr("disabled", "disabled");
		var vars    = {};
		vars.dbname = $("input[name=dbname]").val();
		vars.dbhost = $("input[name=dbhost]").val();
		vars.dbuser = $("input[name=dbuser]").val();
		vars.dbpass = $("input[name=dbpass]").val();
		vars.dbprefix = $("input[name=dbprefix]").val();
		$.post("ajax.dbcheck.php", vars, function(data){
			$("#dbmessage").html(data);
			if($("#dbmessage var").text()==1) {
				$("input.next.step4").removeAttr("disabled");
			} else {
				$("input.next.step4").attr("disabled", "disabled");
				$("input[name=dbcheck]").removeAttr("disabled");
			}			
		});
	});
	$("#step3 input[type=text]").keydown(function(){
		$("input[name=dbcheck]").removeAttr("disabled");
		$("input.next.step4").attr("disabled", "disabled");
	});
	
	// Administrator user credentials:
	$("input[name=generate]").click(function(){
		var password = '';
		var chars    = 'qwertyupasdfghjklzxcvbnmQWERTYUPASDFGHJKLZXCVBNM23456789';
		for(i=0; i<12; i++) {
			password += chars.charAt(Math.floor(Math.random() * chars.length));
		}
		$("input[name=adminpass]").val(password);
	});

	// Setup selector:
	$(".descriptions p").hide();
	$("p.description2").show();
	$("input[name=setup]").click(function(){
		$(".descriptions p").hide();
		$("p.description" + $(this).val()).show();
	});
	
	// Last check:
	$("input.next.step6").click(function(){
		$("dd.dbname").html($("input[name=dbname]").val() + '&nbsp;');
		$("dd.dbprefix").html($("input[name=dbprefix]").val() + '&nbsp;');
		$("dd.adminuser").html($("input[name=adminuser]").val() + '&nbsp;');
		$("dd.adminpass").html($("input[name=adminpass]").val() + '&nbsp;');
		$("dd.adminemail").html($("input[name=adminemail]").val() + '&nbsp;');
		switch($("input[name=setup]:checked").val()) {
			case '1':
				$("dd.setup").text('Empty installation');
				break;
			case '2':
				$("dd.setup").text('Default website');
				break;
			case '3':
				$("dd.setup").text('Example site');
				break;
			case '4':
				$("dd.setup").text('Example blog');
				break;
		}
	});
	
	// AJAX install:
	$("input.install").click(function(){
		$("input.install").attr("disabled", "disabled");
		var vars        = {};
		vars.dbname     = $("input[name=dbname]").val();
		vars.dbhost     = $("input[name=dbhost]").val();
		vars.dbuser     = $("input[name=dbuser]").val();
		vars.dbpass     = $("input[name=dbpass]").val();
		vars.dbprefix   = $("input[name=dbprefix]").val();
		vars.adminuser  = $("input[name=adminuser]").val();
		vars.adminpass  = $("input[name=adminpass]").val();
		vars.adminemail = $("input[name=adminemail]").val();
		vars.setup      = $("input[name=setup]").val();
		if($("input[name=license]").attr("checked")) {
			vars.license = 'true';
		}
		$.post("install.php", vars, function(data){
			$("#installMessage").html(data);
			showStep(7);
		});
		return false;
	});
});

function showStep(nr)
{
	for(i=1; i<=7; i++) {
		$("#step"+i).hide();
	}
	$("#step"+nr).show();
}