<?php
	function moduleCreateLink($array)
	{
		array_unshift($array, 'module');
		array_unshift($array, 'admin');
		return site_url($array);
	}
?>