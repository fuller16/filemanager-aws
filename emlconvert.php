<?php 
require 'vendor/autoload.php';
use PhpMimeMailParser\Parser;

ini_set('max_execution_time', 0);

// message parsing and file IO are kept separate
$parser = new Parser();
$decodelocation = '/var/www/html/filemanager/attachments/';
$baseurl = 'http://filemanager.pinpoint.promo/attachments';
$uniquefolder = uniqid();
if (!is_dir('/var/www/html/filemanager/attachments/'.$uniquefolder)){
  mkdir('/var/www/html/filemanager/attachments/'.$uniquefolder, 0777);
}

try {
    $file = $_GET['path'];
    $file = strtok($file, '?');
	  $parser = new PhpMimeMailParser\Parser();
    // 1. Either specify a file path (string)
    $parser->setPath($file); 

    $text = $parser->getMessageBody('htmlEmbedded');
    print_r($text);
    exit;
	
}catch(Exception $e) {
  echo 'Error Message: ' .$e->getMessage();
  exit;
}
?>
	