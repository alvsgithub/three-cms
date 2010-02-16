<?php
/*
	Related Content v0.1
	---------------------------------------------------------------------------
	Author:		Giel Berkers
	Website:	www.gielberkers.com
	---------------------------------------------------------------------------
	This option adds a related-content option to choose from
	
	Usage:
	
	Create an option of the type 'Related content'.
	
	You can set filters in the options-fields to filter the related content.
	For example: a filter like "template==7" only shows content items which
	template is from ID 7. A filter like "id_content=32" only shows content
	items which parent is 32. You could also filter on name, id or alias but
	these items are always unique, so they will always result in only one
	related content item to choose from. So	that would be rather silly.
	
	Frontend usage:
	
	This addon returns an array with the ID's of the related content items.
	You could use these like this for example:
	
	{* Assuming that the name of your option is 'relatedContent': *}
	{foreach from=$relatedContent item=id}
		{assign var='content' value=$this->newObject($id, $idLanguage)}
		<div class="content">
			<a href="{$content->getUrl()}">
				<h2>{$content->get('headerOrSomething')}</h2>
				<p><a href="{$content->getUrl()}">Go to content</a></p>
			</a>
		</div>
	{/foreach}
	
*/

class Related extends AddonBaseModel
{
	/**
	 * Initialize
	 */
	function init()
	{
		// Make sure this addon is available on the frontend
		$this->frontEnd = true;
	}
	
	/**
	 * This function tells Three CMS on which hook a function needs to be called
	 */
	function getHooks()
	{
		$hooks = array(
			array(
				'hook'=>'AddOption',
				'callback'=>'addOption'
			),
			array(
				'hook'=>'ContentAddOption',
				'callback'=>'contentAddOption'
			),
			array(
				'hook'=>'ModifyOptionValue',
				'callback'=>'makeArray'
			)
		);
		return $hooks;
	}
	
	function addOption($context)
	{
		// Check if this is the current selected item:
		$selected = $context['values']['type'] == 'related_content' ? ' selected="selected" ' : '';
		echo '<option value="related_content" '.$selected.'>Related Content</option>';
	}
	
	function contentAddOption($context)
	{
		if($context['type']=='related_content') {
			// Check what the current selected items are:
			$ids = explode('||', $context['value']);
			
			// Get the content objects:			
			$this->db->select('id,name');
			// Check if there are options to filter by:
			$options = $context['item']['options'];
			if(!empty($options)) {
				$options = explode('||', $options);
				foreach($options as $option) {
					$where = explode('==', $option);
					if(count($where)==2) {
						$this->db->where($where[0], $where[1]);
					}
				}
			}
			$query = $this->db->get('content');
			
			// Show a multiple selectbox:
			echo '<select name="'.$context['inputName'].'" multiple="multiple" style="width: 500px; height: 100px;">';			
			foreach($query->result() as $result) {
				// Shop the option:
				$selected = in_array($result->id, $ids) ? ' selected="selected" ' : '';
				echo '<option value="'.$result->id.'" '.$selected.'>'.$result->name.'</option>';
			}
			echo '</select><br />';
			echo '<em>You can select more than one content items by holding the Ctrl-button on your keyboard.</em>';
		}
	}
	
	function makeArray($context)
	{
		if($context['result']->type=='related_content') {
			$ids     = explode('||', $context['result']->value);
			$context['result']->value = $ids;
		}
	}
}

?>