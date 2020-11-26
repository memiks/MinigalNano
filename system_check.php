<?php
/*
 * This file is part of MinigalNano: https://github.com/sebsauvage/MinigalNano
 *
 * MiniGal Nano is based on an original work by Thomas Rybak (© 2010)
 *
 * MinigalNano is licensed under the AGPL v3 (https://gnu.org/licenses/agpl-3.0.txt).
 */

ini_set("memory_limit", "256M");
$phpok = "No";
$exif = "No";
$gd = "No";
$thumbs = "No";
$rotate = "No";

if (version_compare(phpversion(), "5.7", '>')) {
	$phpok = "Yes";
}

if (function_exists('exif_read_data')) {
	$exif = "Yes";
	if (function_exists('imagerotate')) {
		$rotate = "Yes";
	}
}

if (extension_loaded('gd') && function_exists('gd_info')) {
	$gd = "Yes";
}

if (is_dir('thumbs') && is_writable('thumbs')) {
	$thumbs = "Yes";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="robots" content="noindex, nofollow">
	<title>MiniGal Nano system check</title>
	<style type="text/css">
		body {
			width: 90%;
			background-color: #daddd8;
			font: 12px Arial, Tahoma, "Times New Roman", serif;
		}
		h1 {
			font-size: 30px;
			margin: 20px 0 5px 0;
			letter-spacing: -2px;
		}
		div {
			line-height: 20px;
		}
		.left {
			width: 30%;
			display: inline-table;
			background-color: #fdffbe;
			padding: 2px;
		}
		.middle-neutral {
			font-weight: bold;
			text-align: center;
			width: 100px;
			display: inline-table;
			background-color: #fdffbe;
			padding: 2px;
		}
		.middle-No {
			font-weight: bold;
			text-align: center;
			width: 100px;
			display: inline-table;
			background-color: #ff8181;
			padding: 2px;
		}
		.middle-Yes {
			font-weight: bold;
			text-align: center;
			width: 100px;
			display: inline-table;
			background-color: #98ffad;
			padding: 2px;
		}
		.right {
			width: 60%;
			display: inline-table;
			background-color: #eaf1ea;
			padding: 2px;
		}
	</style>
</head>
<body>
	<h1>MiniGal Nano system check</h1>
	<div class="left">
		PHP Version
	</div>
	<div class="middle-<?php echo $phpok?>">
		<?php echo phpversion();?>
	</div>
	<div class="right">
		<a href="https://www.php.net/" target="_blank">PHP</a> scripting language version 5.7 or greater is needed.
	</div>
	<br />

	<div class="left">
		GD library support
	</div>
	<div class="middle-<?php echo $gd?>">
		<?php echo $gd;?>
	</div>
	<div class="right">
		<a href="https://libgd.github.io/" target="_blank">GD image manipulation</a> library is used to create thumbnails. Bundled since PHP 4.3.
	</div>
	<br />

	<div class="left">
		EXIF support
	</div>
	<div  class="middle-<?php echo $exif?>">
		<?php echo $exif;?>
	</div>
	<div class="right">
		Ability to extract and display <a href="http://en.wikipedia.org/wiki/Exif" target="_blank">EXIF information</a>. The script will work without it, but not display image information.
	</div>
	<br />

	<div class="left">
		Rotation support
	</div>
	<div  class="middle-<?php echo $rotate?>">
		<?php echo $rotate;?>
	</div>
	<div class="right">
		Need EXIF ! Ability to <a href="https://www.php.net/manual/en/function.imagerotate.php" target="_blank">rotate image</a>. The script will work without it, but not rotate image regarding EXIF informations.
	</div>
	<br />

	<div class="left">
		Thumbnails caching
	</div>
	<div class="middle-<?php echo $thumbs?>">
		<?php echo $thumbs;?>
	</div>
	<div class="right">
		You should let php create and use the 'thumbs" directory. MiniGal will be <b>much</b> faster.
	</div>
	<br />

	<div class="left">
		PHP memory limit
	</div>
	<div class="middle-neutral">
		<?php echo ini_get("memory_limit");?>
	</div>
	<div class="right">
		Memory is needed to create thumbnails. Bigger images uses more memory.
	</div>

	<footer role="contentinfo">
		<a href="https://github.com/sebsauvage/MinigalNano" title="Powered by MiniGal Nano" target="_blank">
				Made with miniGal by the community.
			</a>
	</footer>
</body>
</html>
