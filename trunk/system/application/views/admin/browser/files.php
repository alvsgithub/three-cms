<?php
	function wrap($str, $length, $delimiter) {
		$newString = '';
		$count = 0;
		for($i=0; $i<strlen($str); $i++) {
			$count ++;
			$newString .= $str[$i];
			if($count >= $length) {
				$newString .= $delimiter;
				$count = 0;
			}
		}
		
		return $newString;
	}
	
	$files = glob(str_replace('-', '/', $path).'/*');
	foreach($files as $file) {
		if(is_file($file)) {
			$a = explode('/', $file);
			$fileName = $a[count($a)-1];
			$fileName = wrap($fileName, 16, "<br />");
			$a = explode('.', $file);
			$extension = strtolower($a[count($a)-1]);
			$fileSize = filesize($file) / 1024;
			$fileSize = number_format($fileSize, 0);
			
			// If it is an image, show a thumbnail:
			switch($extension) {
				case 'jpg' :
				case 'jpeg' :
				case 'gif' :
				case 'png' :
					{
						$thumbnail = base_url().'system/application/views/admin/browser/thumbnail.php?file='.$file;
						$content = '
							<div class="thumb">
								<img src="'.$thumbnail.'" alt="Thumbnail" width="100" height="100" />
							</div>
						';
						break;
					}
				default:
					{
						$content = '<div class="thumb '.$extension.'"></div>';
						break;
					}
			}
			
			echo '
				<div class="file">
					'.$content.'
					<p class="name">'.$fileName.'</p>
					<p class="size">'.$fileSize.' kb</p>
					<input type="hidden" name="filename" value="'.$file.'" />
				</div>
			';
		}
	}
?>