<?php
	// TODO: Some serious optimization here. There are now 3 foreach-loops stacked in each other!

	// Set to 1 if there is one or more multilingual item. This is used by Three CMS to show or hide the language buttons:
	$multilingual = 0;	
	$totalItems   = count($contentData['content']);
	$currentItem  = 1;
	
	// Show the content fields:
	foreach($contentData['content'] as $item) {		
		echo '<tr class="option"><th>';
		echo ucfirst($item['description']).':';
		// The tooltip:
		if(!empty($item['tooltip'])) {
			echo '<span class="tooltip">?</span><span class="tooltipContent">'.$item['tooltip'].'</span>';
		}
		$optionID = $item['id_option'];
		// See if this item is multilingual:
		if($item['multilanguage']==1) {
			$multilingual = true;
			$iterations = count($contentData['languages']);
		} else {
			$iterations = 1;
		}
		// Set a hidden variable to tell the javascript that if there is one ore more multilingual items:
		if($currentItem==$totalItems) {
			echo '<var style="display: none;" class="multilingual">'.$multilingual.'</var>';
		}
		$currentItem++;
		echo '</th><td>';
		for($i=0; $i<$iterations; $i++) {						
			$languageID = $item['multilanguage']==1 ? $contentData['languages'][$i]['id'] : 0;	// 0 stands for non-multilanguage
			$name       = 'input_'.$optionID.'_'.$languageID;
			$value      = '';
			$class		= 'language_'.$languageID;						
			if($item['required']==1) { $class .= ' required'; }						
			foreach($item['value'] as $valueItem) {
				if($languageID==0) {
					if($valueItem['id_language']==$settings['default_language']) {
						$value = $valueItem['value'];
						break;
					}
				} elseif($valueItem['id_language']==$languageID) {
					$value = $valueItem['value'];
					break;
				}
			}
			// Show the correct input type, according to the option type:						
			switch($item['type']) {
				case 'small_text' :
					{
						echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
						break;
					}
				case 'large_text' :
					{
						echo '<textarea name="'.$name.'" class="'.$class.'">'.$value.'</textarea>';
						break;
					}
				case 'rich_text' :
					{
						// Extra class to set on the textarea:
						$class2 = $item['required']==1 ? ' required' : '';
						echo '<div class="'.$class.'"><textarea name="'.$name.'" class="richtext'.$class2.'">'.$value.'</textarea></div>';
						break;
					}
				case 'url' :
					{
						echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
						break;
					}
				case 'image' :
					{
						echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
						echo '<input type="button" name="browse" value="Browse server..." />';
						break;
					}
				case 'file' :
					{
						echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
						echo '<input type="button" name="browse" value="Browse server..." />';
						break;
					}
				case 'boolean' :
					{
						$checked = $value=='1' ? 'checked="checked" ' : '';									
						echo '<input type="checkbox" name="'.$name.'" '.$checked.' class="'.$class.'" />';
						break;
					}
				case 'dropdown' :
					{
						$values = explode('||', $item['options']);
						echo '<select name="'.$name.'">';
						foreach($values as $option) {
							$optionArray = explode('==', $option);
							$optionName  = $optionArray[0];
							$optionValue = count($optionArray)==1 ? $optionArray[0] : $optionArray[1];
							$selected    = $optionValue == $value ? ' selected="selected"' : '';
							echo '<option value="'.$optionValue.'"'.$selected.'>'.$optionName.'</option>';
						}
						echo '</select>';
						break;
					}
				case 'selectbox' :
					{
						$values = explode('||', $item['options']);
						$valueArray = explode(';', $value);
						foreach($values as $option) {
							$optionArray = explode('==', $option);
							$optionName  = $optionArray[0];
							$optionValue = count($optionArray)==1 ? $optionArray[0] : $optionArray[1];
							$checked = in_array($optionValue, $valueArray) ? ' checked="checked" ' : '';
							echo '<label><input type="checkbox" name="'.$name.'_'.md5($optionValue).'" '.$checked.' /> '.$optionName.'</label><br />';
						}
						break;
					}
				case 'date' :
					{
						// Add a datapicker
						echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.' datePicker" />';
						break;
					}
				case 'time' :
					{
						// Add a timepicker
						echo '<input type="text" name="'.$name.'" value="'.$value.'" class="'.$class.' timePicker" />';
						break;
					}				
			}
			$addons->executeHook('ContentAddOption', array('type'=>$item['type'], 'inputName'=>$name, 'value'=>$value, 'class'=>$class, 'item'=>$item));
		}
		echo '</td>';		
	}
?>