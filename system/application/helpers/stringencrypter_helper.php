<?php
	function encodeFileName($str)
	{
		$newStr = strtr($str, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/-.,1234567890',
							  'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM^1234567890-.,');
		$newStr = str_replace('^', 'SSSSSSSSSS', $newStr);
		return $newStr;
	}
	
	function decodeFileName($str)
	{
		$newStr = str_replace('SSSSSSSSSS', '^', $str);
		$newStr = strtr($newStr, 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM^1234567890-.,',
							     'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/-.,1234567890');
		return $newStr;
	}	

?>