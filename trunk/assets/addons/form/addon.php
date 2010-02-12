<?php
class Form extends AddonBaseModel
{
	var $formArr     = array();
	var $action      = '/';
	var $labelSuffix = '';
	
	/**
	 * Initialize
	 */
	function init()
	{
		@session_start();
		$this->frontEnd = true;
	}
	
	/**
	 * This function tells Three CMS on which hook a function needs to be called
	 */
	function getHooks()
	{
		// Since this addon only does something on the frontend, there are no hooks:
		$hooks = array();
		return $hooks;
	}
	
	// Frontend functions:
	
	/**
	 * Create a new form
	 * @param	$action	string	The URL to post to
	 */
	function newForm($action = '/')
	{
		$this->formArr     = array();
		$this->action      = $action;
		$this->labelSuffix = '';		
	}
	
	/**
	 * Set the label suffix
	 * @param	$suffix	string	The suffix to use
	 */
	function suffix($suffix)
	{
		$this->labelSuffix = $suffix;
	}
	
	/**
	 * Add an item to the form
	 * @param	$type	string	The type (text, password, checkbox, etc...)
	 * @param	$name	string	The name of the item
	 */
	function add($type, $name, $label = '', $class = '', $value = '')
	{
		// if($this->form == null) {			
			// $this->newForm();
		// }
		// If the label is empty, create one:
		if(empty($label)) {
			$label = ucfirst($name);
		}
		array_push($this->formArr, array($type, $name, $label, $class, $value));
	}
	
	/**
	 * Render the form
	 */
	function render()
	{
		echo '<form method="post" action="'.$this->action.'">';
		foreach($this->formArr as $item) {
			$class = !empty($item[3]) ? 'class="'.$item[3].'" ' : '';
			$value = !empty($item[4]) ? 'value="'.$item[4].'" ' : '';
			if($item[0]!='hidden' && !empty($item[2])) {				
				echo '<label for="'.$item[1].'">'.$item[2].$this->labelSuffix.'</label>';
			}
			switch($item[0]) {
				case 'textarea' :
					{
						// Textarea:
						echo '<textarea name="'.$item[1].'" id="'.$item[1].' '.$class.$value.'"></textarea>';
						break;
					}
				default:
					{
						// Default input-tag:
						echo '<input type="'.$item[0].'" name="'.$item[1].'" id="'.$item[1].'" '.$class.$value.'/>';
						break;
					}
			}
		}
		echo '</form>';
	}
	
}
?>