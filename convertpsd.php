<?php
$im = new Imagick();

if($_GET['attachment']){
	$filename = $_GET['attachment'];
	$im->readImage("/home/pinpointdev/Dropbox/filemanager/".$filename);
}else{
	$filename = $_GET['path'];
	$im->readImage("/home/pinpointdev/Dropbox/onpoint.pinpoint/public".$filename);
}


/*$im->setIteratorIndex(2);
$output->addImage($im->getimage());
*/
$im->setIteratorIndex(1);
$output->addImage($im->getimage());
$merged = @$output->flattenimages();
$merged->setImageFormat('jpg');
$merged->writeImage('test.jpg');
/*$offsetX = 240 - $im->getImageWidth() / 2;
//$im->setResolution(1200,1200);
$offsetY = 180 - $im->getImageHeight() / 2;
$im->extentImage( 480, 360, -$offsetX, -$offsetY);*/
// $im->setImageFormat("png");
// header("Content-Type: image/png");
echo $merged;