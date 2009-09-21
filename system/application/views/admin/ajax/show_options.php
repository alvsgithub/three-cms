<?php
	$optionString = '';
	$first = true;
	$i = 0;
	$total = count($optionData);
	foreach($optionData as $option) {
		echo '<div class="option" id="option_'.$i.'"><span class="name">'.$option['name'].'</span><span class="options">';
		$i++;
		if(!$first) {
			echo '<span class="moveUp">Move Up</span>';
		}
		if($i<$total) {
			echo '<span class="moveDown">Move Down</span>';
		} else {
			echo '<span class="placeHolder"></span>';
		}
		echo '<span class="remove">Remove</span></span></div>';
		if(!$first) { $optionString.='-'; }
		$optionString.=$option['id'];
		$first = false;
		
	}
?>