<?php
/**
 	Search v0.1
 	---------------------------------------------------------------------------
 	Performs a site search
 	---------------------------------------------------------------------------
 	Usage:
 
 	Create a search form somewhat like this:
 	
 	<form method="post" action="#">
		<input type="text" name="search[query]" />
		<input type="submit" value="Search" />
	</form>
	
	Now, on the page where you want to display your search results (the page
	where the form should make it's action to), use getResults() to get the
	results. If no results are found, false is returned:
	
	{if $search->getResults() neq false}
		<ul class="searchResults">
		{foreach from=$search->getResults() item=result}
			<li>
				<a href="{$result.url}">{$result.url}</a>
			</li>
		{/foreach}
		</ul>
	{/if}
	
	Additional parameters can be used in the searchform:
	search[options]	: Which options to check for a match; if not used, all
					  fields are checked. Must be numeric
	search[return]	: Which output to return; default is a 2-dimensional array
					  with the URL and the ID. Options are:
					  - id 				: Default, as described above
					  - options:a,b,c	: Returns the values of the options
										  with the given id's. Must be numeric
					  - dataobject		: Returns the dataobjects of each
										  result
	
 	<form method="post" action="#">
		<input type="text" name="search[query]" />
		<input type="hidden" name="search[options]" value="13,15" />
		<input type="hidden" name="search[return]" value="options:15,17" />
		<input type="submit" value="Search" />
	</form>
	
	Example in the page (asuming that option 15 is called 'name' and option
	17 is called 'description'):
	
	{if $search->getResults() neq false}
		<ul class="searchResults">
		{foreach from=$search->getResults() item=result}
			<li>
				<h3><a href="{$result.url}">{$result.name}</a></h3>
				<span>{$result.description}</span>
			</li>
		{/foreach}
		</ul>
	{/if}
	
 */

class Search extends AddonBaseModel
{
	var $results;		// An array with the search results
	var $dataObject;	// Reference to the data object
	
	/**
	 * Initialize
	 */
	function init()
	{
		$this->frontEnd = true;
		$this->results  = array();
	}
	
	/**
	 * This function tells Three CMS on which hook a function needs to be called
	 */
	function getHooks()
	{
		// Since this addon only does something on the frontend, there are no hooks:
		$hooks = array(
			array(
				'hook'=>'PreRenderPage',
				'callback'=>'preRender'
			)
		);
		return $hooks;
	}
	
	// Check for search-querys:
	function preRender($context)
	{
		if(isset($_POST['search'])) {
			$this->dataObject = $context['dataObject'];
			$data = $this->input->post('search');
			if(isset($data['query'])) {
				$this->performSearch($data);
			}
		}
	}
	
	function performSearch($data)
	{
		// See if there are limitations, such as options to scan:
		$options = false;
		if(isset($data['options'])) {
			$options = explode(',', $data['options']);
			$newOptions = array();
			foreach($options as $id_option) {
				if(is_numeric($id_option)) {
					array_push($newOptions, $id_option);
				}
			}
		}
		// See what result is desired:
		// options are:
		// id				Return an array with ID's that match the searchquery
		// options[a,b,c]	Return a 2-dimensional associated array with the given options
		// dataobject		Return an array with dataobjects that match the searchquery
		//
		// Search results are always 2- or more-dimensional arrays:
		// array(id=>..., url=>... result=>...array(...))
		$return = isset($data['return']) ? $data['return'] : 'id';
		
		// Perform the search:
		$this->db->distinct();
		$this->db->select('id_content');
		$this->db->from('values');
		$this->db->like('value', $data['query']);
		if($options!=false) {
			$this->db->where_in('id_option', $options);
		}		
		
		// TODO: Language filtering. Check when options are single or multilingual:
		
		$query = $this->db->get();		
		if($query->num_rows > 0) {
			$results = array();
			foreach($query->result() as $result) {				
				$entry = array(
					'id'  => $result->id_content,
					'url' => $this->dataObject->getUrl($result->id_content)
				);				
				if($return == 'dataobject') {
					$entry['dataobject'] = $this->dataObject->newObject($result->id_content, $this->dataObject->options['idLanguage']);
				} elseif(substr($return, 0, 7) == 'options') {
					$a = explode(':', $return);
					$returnOptions = explode(',', $a[1]);
					foreach($returnOptions as $id_option) {
						if(is_numeric($id_option)) {
							$this->db->select('values.value,options.name');
							$this->db->join('options', 'options.id = values.id_option');
							$this->db->where('id_option', $id_option);
							$this->db->where('id_content', $entry['id']);
							$this->db->where('id_language', $this->dataObject->options['idLanguage']);
							$optionValueQuery = $this->db->get('values');							
							if($optionValueQuery->num_rows > 0) {
								$optionValueResult = $optionValueQuery->result();
								$entry[$optionValueResult[0]->name] = $optionValueResult[0]->value;
							}
						}
					}
				}
				array_push($results, $entry);				
			}			
			$this->results = $results;
		} else {
			$this->results = false;
		}		
	}
	
	
	
	// Frontend functions:
	function getResults()
	{
		return $this->results;
	}
}
?>