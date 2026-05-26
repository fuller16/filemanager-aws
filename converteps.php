<?php
require __DIR__ . '/auth_check.php';
require __DIR__ . '/config.php';
$im = new Imagick();

if($_GET['attachment']){
	$filename = $_GET['attachment'];
	$im->readImage(rtrim($imagick_attachments_root, '/') . '/' . $filename);
}else{
	$filename = $_GET['path'];
	$im->readImage(rtrim($imagick_public_root, '/') . $filename);
}
// $im->setResolution(1200,1200);
$offsetX = 240 - $im->getImageWidth() / 2;
$offsetY = 180 - $im->getImageHeight() / 2;
$im->extentImage( 480, 360, -$offsetX, -$offsetY);
$im->setImageFormat("png");
header("Content-Type: image/png");
echo $im;