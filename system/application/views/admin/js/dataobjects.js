var optionString;

$(function(){
	$("input[name=addOption]").click(function(){
		newOption = $("select[name=optionList]").val();
		if(optionString!='') {
			optionArray = optionString.split('-');										
			for(i=0; i<optionArray.length; i++) {
				if(optionArray[i]==newOption) {
					alert(dialog_option_exists);
					return false;
				}
			}
		} else {
			optionArray = [];
		}
		// Option does not exists. Add it:
		optionArray.push(newOption);
		optionString = optionArray.join('-');
		$("input[name=optionString]").val(optionString);
		
		loadOptions();
	});
	
	loadOptions();
});

function loadOptions()
{
	optionString = $("input[name=optionString]").val();
	$("#optionsField").load(baseURL + 'index.php/admin/ajax/show_options/' + optionString, function(){
		initializeButtons();
	});
}

function initializeButtons()
{
	$("span.moveUp").click(function(){
		currentPositionID = $(this).parent().parent().attr("id");
		a = currentPositionID.split('_');
		currentPosition = parseInt(a[1]);
		
		optionArray = optionString.split('-');
		
		myValue    = optionArray[currentPosition];
		otherValue = optionArray[currentPosition-1];
		
		optionArray[currentPosition-1] = myValue;
		optionArray[currentPosition] = otherValue;
		
		optionString = optionArray.join('-');
		$("input[name=optionString]").val(optionString);
		
		loadOptions();
	});
	
	$("span.moveDown").click(function(){
		currentPositionID = $(this).parent().parent().attr("id");
		a = currentPositionID.split('_');
		currentPosition = parseInt(a[1]);
		
		optionArray = optionString.split('-');
		
		myValue    = optionArray[currentPosition];
		otherValue = optionArray[currentPosition+1];
		
		optionArray[currentPosition+1] = myValue;
		optionArray[currentPosition] = otherValue;
		
		optionString = optionArray.join('-');
		$("input[name=optionString]").val(optionString);
		
		loadOptions();
	});
	
	$("span.remove").click(function(){
		currentPositionID = $(this).parent().parent().attr("id");
		a = currentPositionID.split('_');
		currentPosition = parseInt(a[1]);
		
		optionArray = optionString.split('-');
		newArray    = [];
		for(i=0; i<optionArray.length; i++) {
			if(i!=currentPosition) {
				newArray.push(optionArray[i]);
			}
		}
		
		optionString = newArray.join('-');
		$("input[name=optionString]").val(optionString);
		
		loadOptions();
	});
}				