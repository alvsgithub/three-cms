<?php
	ini_set('memory_limit', '-1');

	header('Content-type: image/jpeg');
	
	$width     = isset($_GET['width']) ? $_GET['width'] : 100;
	$height    = isset($_GET['height']) ? $_GET['height'] : 100;
	$file      = isset($_GET['file']) ? $_GET['file'] : null;
	$quality   = isset($_GET['quality']) ? $_GET['quality'] : 80;	
	
	$hash      = md5($file.':'.$width.':'.$height.':'.$quality);
	
	$file = '../../../../../'.$file;
	if(file_exists($file)) {
		$fileSize = filesize($file);
		$fileDate = filectime($file);
		$hash.= '-'.$fileSize.'-'.$fileDate;
	}

	$cachefile = '../../../../cache/thumbs/'.$hash.'.jpg';
	
	if(file_exists($cachefile)) {
		$image = imagecreatefromjpeg($cachefile);
	} else {
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
	}
	imagejpeg($image, '', $quality);
	imagedestroy($image);

	ini_restore('memory_limit');
?>
