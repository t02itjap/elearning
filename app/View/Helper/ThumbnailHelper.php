<?php

App::uses('AppHelper', 'View/Helper');
App::uses('HtmlHelper', 'View/Helper');
/**
 * The thumbnail helper class.
 */
class ThumbnailHelper extends AppHelper
{
	public $helpers = array('Html');
	private $files_dir = 'files/';
	private $thumbs_dir = 'thumbs/';
	private $width;
	private $height;

/**
 * Renders a thumbnail image.
 *
 * @param  string $filename
 * @param  array  $options
 * @param  array  $imgOptions
 * @return string
 */
	public function render($imagefile, $options = array(), $imgOptions = array())
	{
		
		if (file_exists($imagefile)) {
			$filename = htmlentities($imagefile);
		} else {
			return false;
		}
		
		list($width, $height) = getImageSize($imagefile);
		
		if ($width == 0 || $height == 0) {
			return false;
		}
		
		if (isset($options['width']) && isset($options['height'])) {
			$ratioWidth = $options['width'] / $width;
			$ratioHeight = $options['height'] / $height;
			$scale = $ratioWidth < $ratioHeight ? $ratioWidth : $ratioHeight;
			
		} elseif (isset($options['width'])) {
			$size = $options['width'] / $width;
			if ($size > 1) {
				$scale = 1;
			} else {
				$scale = $size;
			}
		} elseif (isset($options['height'])) {
			$size = $options['height'] / $height;
			if ($size > 1) {
				$scale = 1;
			} else {
				$scale = $size;
			}
		} else {
			$size = floor(filesize($imagefile) / 1024);
			if ($size > 10) {
				$scale = sqrt(10 / $size);
			} else {
				$scale = 1;
			}
		}
		
		if (isset($scale)) {
			$newImageWidth = (int) ceil($width * $scale);
			$newImageHeight = (int) ceil($height * $scale);
		}
		
		$pathInfo = pathinfo($imagefile);
		$thumbImageName = str_replace(array('/', '\\'), DS, 
				$pathInfo['dirname'] . DS . $pathInfo['filename'] . '_' . $newImageWidth. 'x' . $newImageHeight . '_thumbnail' . '.' . $pathInfo['extension']);
// 		$thumb_image_name = str_replace(array('/', '\\'), DS, WWW_ROOT . 'img' . DS . 'thumbs' . DS . basename($imagefile));
		
		if (file_exists($thumbImageName)) {
			$imagePath = str_replace(array('/', '\\') , '/', $thumbImageName);
			
			preg_match('/img\/(.+)/', $imagePath, $matches);
			
			return $this->Html->image($matches[1], $imgOptions);
		} else {
			
			$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
			$ext = strtolower(substr(basename($imagefile), strrpos(basename($imagefile), ".") + 1));
			
			$source = "";
			if ($ext == "png") {
				$source = imagecreatefrompng($imagefile);
			} elseif ($ext == "jpg" || $ext == "jpeg") {
				$source = imagecreatefromjpeg($imagefile);
			} elseif ($ext == "gif") {
				$source = imagecreatefromgif($imagefile);
			}
			
			imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
			
			imagepng($newImage, $thumbImageName, 9);
			
			$imagePath = str_replace(array('/', '\\') , '/', $thumbImageName);
			
			preg_match('/img\/(.+)/', $imagePath, $matches);
			
			return $this->Html->image($matches[1], $imgOptions);
			
// 			chmod($thumbImageName, 0777);
// 			$imgbinary = fread(fopen($thumbImageName, "r"), filesize($thumbImageName));
// 			$filetype = pathinfo($thumbImageName, PATHINFO_EXTENSION);
// 			$data = 'data:image/' . 'png' . ';base64,' . base64_encode($imgbinary);
// 			$imgOption = $this->_parseAttributes($imgOptions, null, '', ' ');
// 			return "<img src = $data  $imgOption>";
		}
		

	}
}