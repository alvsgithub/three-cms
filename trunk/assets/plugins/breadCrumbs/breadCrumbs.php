<?php
/**
 * Breadcrumbs plugin for Three CMS
 * --------------------------------------------------
 * Code submitted by:	axdes
 * Code modified by:	kanduvisla
 *
 * Note: This plugin does not yet work!
 * 
 */
class BreadCrumbs extends DataModel
{
	/**
	 * Generate a breadcrumbs trail
	 */
	function generate($idContent = null)
	{
		$breadgrit = '';
		$idContent = $idContent !== null ? $idContent : $this->idContent;
		$breadgrit_last = $this->get('name');		
		$parents = $this->parents($idContent);
		$aliases = array();		
		foreach($parents as $parentObject) {
			$breadgrit .= '<a href="'.$parentObject->getUrl().'">'.$parentObject->get('name').'</a> - ';
		}		
		$breadgrit = $breadgrit . $breadgrit_last;		
		if ($this->get('alias') !== 'home') {
			$breadgrit = iconv("windows-1251", "UTF-8",'<a href="/">Home</a>') . ' - ' . $breadgrit;
		}		
		echo $breadgrit;
	}
}
?>