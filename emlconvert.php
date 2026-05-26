<?php
require __DIR__ . '/auth_check.php';
require __DIR__ . '/config.php';
require 'vendor/autoload.php';
use PhpMimeMailParser\Parser;

ini_set('max_execution_time', 0);

// message parsing and file IO are kept separate
$parser = new Parser();
$decodelocation = rtrim($attachments_path, '/') . '/';
$baseurl = rtrim($attachments_url, '/');
$uniquefolder = uniqid();
if (!is_dir($decodelocation . $uniquefolder)){
  mkdir($decodelocation . $uniquefolder, 0777);
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
	