<?php
/*
Copyright (c) 2009 Grzegorz Żydek 

This file is part of PGRFileManager v1.5.2

Permission is hereby granted, free of charge, to any person obtaining a copy
of PGRFileManager and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

PGRFileManager IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

//Include your own script with authentication if you wish
//otherwise comment or remove line below
//include($_SERVER['DOCUMENT_ROOT'].'/_files/application/PGRFileManagerConfig.php');



//path to root directory 
//i.e. if your gallery dir is http://www.mypage.com/gallery, type PGRFileManagerConfig::$rootPath = '/gallery'  

// Make this dynamic:
$rootURL = 'http';
if(isset($_SERVER['HTTPS'])) {
	if($_SERVER["HTTPS"] == "on") { $rootURL .= "s"; }
}
$rootURL .= '://'.$_SERVER['HTTP_HOST'].'/';
$rootPath = dirname($_SERVER['SCRIPT_FILENAME']).'/';
// Remove double slashes but leave http:// intact:
$baseURL    = preg_replace('#(http:|https:)|//#', '\\1/', $rootURL.str_replace($_SERVER['DOCUMENT_ROOT'], '', $rootPath));
define('BASE_URL', $baseURL);
define('ROOT_PATH', $rootPath);

$path = str_replace('system/application/views/admin/ckeditor/plugins/pgrfilemanager/php/', '', BASE_URL);
if($path==BASE_URL) {
	$path = str_replace('system/application/views/admin/ckeditor/plugins/pgrfilemanager/', '', BASE_URL);
}
$a    = explode('/', $path);
array_shift($a); // http:/
array_shift($a); // /
array_shift($a); // hostname.com/
$path = '/'.implode('/', $a).'assets';
// Done making this dynamic!


PGRFileManagerConfig::$rootPath = $path; // '/three/assets';

// PGRFileManagerConfig::$rootDir = '../../../../../../../../assets';

//Max file upload size in bytes
PGRFileManagerConfig::$fileMaxSize = 1024 * 1024 * 10;
//Allowed file extensions
//PGRFileManagerConfig::$allowedExtensions = '' means all files
PGRFileManagerConfig::$allowedExtensions = '';
//Allowed image extensions
PGRFileManagerConfig::$imagesExtensions = 'jpg|gif|jpeg|png|bmp';
//Max image file height in px
PGRFileManagerConfig::$imageMaxHeight = 724;
//Max image file width in px
PGRFileManagerConfig::$imageMaxWidth = 1280;
//Thanks to Cycle.cz
//Allow or disallow edit, delete, move, upload, rename files and folders
PGRFileManagerConfig::$allowEdit = true;		// true - false