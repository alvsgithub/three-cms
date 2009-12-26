<?php
/**
 * Form plugin for Three CMS
 * v1.0
 */

class Form
{
	var $form;
	var $action;
	
	/**
	 * Create a new form
	 * @param	$action	string	The URL to post to
	 */
	function newForm($action = '/')
	{
		$this->form   = array();
		$this->action = $action;
	}
	
	/**
	 * Add an item to the form
	 * @param	$type	string	The type (text, password, checkbox, etc...)
	 * @param	$name	string	The name of the item
	 */
	function add($type, $name, $label = '', $class = '', $value = '')
	{
		if($this->form == null) {			
			$this->newForm();
		}
		// If the label is empty, create one:
		if(empty($label)) {
			$label = ucfirst($name);
		}
		array_push($this->form, array($type, $name, $label, $class, $value));
	}
	
	/**
	 * Render the form
	 */
	function render()
	{
		echo '<form method="post" action="'.$this->action.'">';
		foreach($this->form as $item) {
			$class = !empty($item[3]) ? 'class="'.$item[3].'" ' : '';
			$value = !empty($item[4]) ? 'value="'.$item[4].'" ' : '';
			switch($item[0]) {
				case 'textarea' :
					{
						// Textarea:
						echo '<label for="'.$item[1].'">'.$item[2].'</label>';
						echo '<textarea name="'.$item[1].'" id="'.$item[1].' '.$class.$value.'"></textarea>';
						break;
					}
				default:
					{
						// Default input-tag:
						echo '<label for="'.$item[1].'">'.$item[2].'</label>';
						echo '<input type="'.$item[0].'" name="'.$item[1].'" id="'.$item[1].'" '.$class.$value.'/>';
						break;
					}
			}
		}
		echo '</form>';
	}
}
?>