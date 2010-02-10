<?php
class Breadcrumbs extends AddonBaseModel
{
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

	/**
	 * Generate breadcrumbs
	 */
	function generate($idContent = null, $option = 'contentName', $seperator = ' - ')
	{
		if($this->dataObject!=null) {
			$breadgrit = '';
			$idContent = $idContent !== null ? $idContent : $this->dataObject->idContent;
			$breadgrit_last = $this->dataObject->get($option);		
			$parents = $this->dataObject->parents($idContent);
			$aliases = array();		
			foreach($parents as $parentObject) {
				$breadgrit .= '<a href="'.$parentObject->getUrl().'">'.$parentObject->get($option).'</a>'.$seperator;
			}		
			$breadgrit = $breadgrit . $breadgrit_last;		
			if ($this->dataObject->get('alias') !== 'home') {
				$breadgrit = iconv("windows-1251", "UTF-8",'<a href="/">Home</a>') . $seperator . $breadgrit;
			}		
			echo $breadgrit;
		}
	}
}
?>