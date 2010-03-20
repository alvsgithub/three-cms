<?php
/*
	Thumb addon for Three
	---------------------------------------------------------------------------
	Version:	0.1
	Author:		Giel Berkers
	Website:	http://www.gielberkers.com
	---------------------------------------------------------------------------
	This addon creates a thumbnail of the given image and returns the path to
	the thumbnail. Optional are: width, height and quality.
	
	Functions:
	
	get(filename, [width=100], [height=100], [quality=80])	
	
	Usage:
	
	Use the get()-function to get the thumb of the desired image:
	
	{$thumb->get('path/to/file/file.jpg)}
	{$thumb->get('path/to/file/file.jpg, 100, 100, 80)}
	
	Example in template (where $image is the path to the image):
	
	<img src="{$thumb->get($image, 60, 40)}" alt="thumb" width="60" height="40" />	
*/
class Thumb extends AddonBaseModel
{
	/**
	* Initialize
	*/
	function init()
	{
		// Initializing stuff can go here...
		$this->frontEnd = true;
	}
		
	/**
	* This function tells Three CMS on which hook a function needs to be called
	*/
	function getHooks()
	{
		$hooks = array();
		return $hooks;
	}
	
	/**
	 * Create a thumb
	 * @param	$file		string	The filename
	 * @param	$width		int		The width
	 * @param	$height		int		The height
	 * @param	$quality	int		The quality (0-100)
	 */
	function get($file, $width=100, $height=100, $quality=80) {
		$a         = explode('/', $file);
		$fileName  = $a[count($a)-1];
		
		$hash      = $fileName.'.'.md5($file.':'.$width.':'.$height.':'.$quality);
		
		// $file = '../../../../../'.$file;
		if(file_exists($file)) {
			$fileSize = filesize($file);
			$fileDate = filectime($file);
			$hash.= '-'.$fileSize.'-'.$fileDate;
		}
		
		$cachefile = 'system/cache/thumbs/'.$hash.'.jpg';
		
		if(!file_exists($cachefile)) {
			// Create the thumb:
			ini_set('memory_limit', '-1');	
			// See if widht or height is 0. If this is the case, these must be calculated automaticly.
			list($originalWidth, $originalHeight) = getimagesize($file);
			if($width!=0 && $height!=0) {
				$image  = imagecreatetruecolor($width, $height);
			} else {
				if($width==0) {
					// Calculate the width
					$width = ceil($originalWidth * ($height/$originalHeight));
				}
				if($height==0) {
					// Calculate the height
					$height = ceil($originalHeight * ($width/$originalWidth));
				}
				$image  = imagecreatetruecolor($width, $height);
			}
			
			if(isset($file)) {
				if(file_exists($file)) {
					// Check the extension:
					$a = explode('.', $file);
					$ext = strtolower($a[count($a)-1]);
					switch($ext) {
						case 'jpg' :
						case 'jpeg' :
							{
								$originalImage  = imagecreatefromjpeg($file);
								break;
							}
						case 'png' :
							{
								$originalImage  = imagecreatefrompng($file);
								break;
							}
						case 'gif' :
							{
								$originalImage  = imagecreatefromgif($file);
								break;
							}
						default:
							{
								// extension not supported
								$originalImage = imagecreatetruecolor($width, $height);
								imagefilledrectangle($originalImage, 0, 0, $width, $height, imagecolorallocate($originalImage, 255, 0, 0));
								break;
							}
					}
					// $originalImage  = imagecreatefromjpeg($file);
					
					$thumbRatio = $height / $width;
					$imageRatio = $originalHeight / $originalWidth;
					if($thumbRatio < $imageRatio) {
						// Crop at the top and the bottom
						$dstW = $width;
						$dstH = $originalHeight * ($width / $originalWidth);
						$dstX = 0;
						$dstY = -(($dstH-$height) / 2);
					} else {
						// Crop at the left and the right side
						$dstW = $originalWidth * ($height / $originalHeight);
						$dstH = $height;
						$dstX = -(($dstW-$width) / 2);
						$dstY = 0;
					}
					
					// Fill the image with white:
					imagefilledrectangle($image, 0, 0, $width, $height, imagecolorallocate($image, 255, 255, 255));				
					
					imagecopyresampled($image, $originalImage, $dstX, $dstY, 0, 0, $dstW, $dstH, $originalWidth, $originalHeight);				
				} else {
					// If the image doesn't exist, fill it with a red color
					imagefilledrectangle($image, 0, 0, $width, $height, imagecolorallocate($image, 255, 0, 0));				
				}
			}		
			// Save the image:
			imagejpeg($image, $cachefile, $quality);
			imagedestroy($image);	
			ini_restore('memory_limit');
		}
		return $cachefile;		
	}
}
?>