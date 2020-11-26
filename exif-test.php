<?php
/*
 * This file is part of MinigalNano: https://github.com/sebsauvage/MinigalNano
 *
 * MiniGal Nano is based on an original work by Thomas Rybak (© 2010)
 *
 * MinigalNano is licensed under the AGPL v3 (https://gnu.org/licenses/agpl-3.0.txt).
 */

error_reporting(0);

$get_filename = $_GET['filename'];
$get_size = @$_GET['size'];
if (empty($get_size)) {
	$get_size = 120;
}

if (preg_match("/^\/.*/i", $get_filename)) {
	die("Unauthorized access !");
}

if (preg_match("/.jpe?g$/i", $get_filename)) {
	$get_filename_type = "JPG";
}

if (preg_match("/.gif$/i", $get_filename)) {
	$get_filename_type = "GIF";
}

if (preg_match("/.png$/i", $get_filename)) {
	$get_filename_type = "PNG";
}

/**
 * Vertical flip
 * @author http://stackoverflow.com/questions/8232722/how-to-flip-part-of-an-image-horizontal-with-php-gd
 */
function flipVertical(&$img) {
	$size_x = imagesx($img);
	$size_y = imagesy($img);
	$temp = imagecreatetruecolor($size_x, $size_y);
	$x = imagecopyresampled($temp, $img, 0, 0, 0, ($size_y - 1), $size_x, $size_y, $size_x, 0 - $size_y);
	if ($x) {
		$img = $temp;
	} else {
		die("Unable to flip image");
	}
}

/**
 * Horizontal flip
 * @author http://stackoverflow.com/questions/8232722/how-to-flip-part-of-an-image-horizontal-with-php-gd
 */
function flipHorizontal(&$img) {
	$size_x = imagesx($img);
	$size_y = imagesy($img);
	$temp = imagecreatetruecolor($size_x, $size_y);
	$x = imagecopyresampled($temp, $img, 0, 0, ($size_x - 1), 0, $size_x, $size_y, 0 - $size_x, $size_y);
	if ($x) {
		$img = $temp;
	} else {
		die("Unable to flip image");
	}
}

/**
 * Sanitizing (this allows for collisions)
 */
function sanitize($name) {
	return preg_replace("/[^[:alnum:]_.-]/", "_", $name);
}

// Display error image if file isn't found
if (!is_file($get_filename)) {
	header('Content-type: image/jpeg');
	$errorimage = imagecreatefromjpeg('images/questionmark.jpg');
	imagejpeg($errorimage, null, 90);
	imagedestroy($errorimage);
	exit;
}

// Display error image if file exists, but can't be opened
if (!is_readable($get_filename)) {
	header('Content-type: image/jpeg');
	$errorimage = imagecreatefromjpeg('images/cannotopen.jpg');
	imagejpeg($errorimage, null, 90);
	imagedestroy($errorimage);
	exit;
}

// otherwise, generate thumbnail, send it and save it to file.

$target = "";
$xoord = 0;
$yoord = 0;

$imgsize = getimagesize($get_filename);
$width = $imgsize[0];
$height = $imgsize[1];
// If the width is greater than the height it’s a horizontal picture
if ($width > $height) {
	$xoord = ceil(($width - $height) / 2);
	// Then we read a square frame that equals the width
	$width = $height;
} else {
	$yoord = ceil(($height - $width) / 2);
	$height = $width;
}

// Rotate JPG pictures
// for more info on orientation see
// http://www.daveperrett.com/articles/2012/07/28/exif-orientation-handling-is-a-ghetto/

$degrees = 0;
$flip = '';
if (preg_match("/.jpg$|.jpeg$/i", $_GET['filename'])) {
	if (function_exists('exif_read_data') && function_exists('imagerotate')) {
		$exif = exif_read_data($_GET['filename'], 0, true);
        print_r($exif);
		if(!empty($exif['Orientation'])) {
			$ort = $exif['Orientation'];
		} else {
			$ort = $exif['IFD0']['Orientation'];
        }
    } else {
        echo "unable to rotate !!";
    }
} else {
    echo "Not a JPG !!";
}
