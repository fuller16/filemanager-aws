<?php 
require 'vendor/autoload.php';

use Hfig\MAPI;
use Hfig\MAPI\OLE\Pear;
ini_set('max_execution_time', 0);

// message parsing and file IO are kept separate
$messageFactory = new MAPI\MapiMessageFactory();
$documentFactory = new Pear\DocumentFactory(); 
$decodelocation = '/home/pinpointdev/Dropbox/filemanager/attachments/';
$baseurl = 'http://filemanager.pinpoint.promo/attachments';
$uniquefolder = uniqid();
if (!is_dir('/home/pinpointdev/Dropbox/filemanager/attachments/'.$uniquefolder)){
  mkdir('/home/pinpointdev/Dropbox/filemanager/attachments/'.$uniquefolder, 0777);
}
// message parsing and file IO are kept separate
function get_string_between($string, $start, $end){
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) {
		return '';
	}
	$ini += strlen($start);   
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}
try {
    $file = $_GET['path'];
	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);*/
	$ole = $documentFactory->createFromFile($file);
	$message = $messageFactory->parseMessage($ole);
	$pattern = "(\£\d+)";
	//$html = preg_replace_callback($pattern, "utf8replacer", utf8_encode($message->getBodyHTML()));
	try {
		$html = preg_replace_callback($pattern, "utf8replacer", utf8_encode($message->getBodyHTML()));
	}catch(Exception $e) {
		if($e->getMessage() == 'No HTML or Embedded RTF body. Convert from RTF not implemented'){
			$html = preg_replace_callback($pattern, "utf8replacer", utf8_encode($message->getBody()));
		}
	}
	$date = $message->getSendTime();
	$doctypes = array('ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx');
	if (count($message->getAttachments()) > 0) {
		foreach ($message->getAttachments() as $attach) {
		    $filename = $attach->getFilename();
		    $temploc = $decodelocation . '/' . $uniquefolder . '/' . $filename;
		    $fileurl = $baseurl . '/' . $uniquefolder . '/' . rawurlencode($filename);
		    $replace_string = get_string_between($html, 'cid:' . $filename,'"');
		    file_put_contents($temploc, $attach->getData());
		    if ($replace_string) {
		        $html = str_replace('cid:' . $filename.$replace_string, $fileurl, $html);
		    } else {

		        // $geturl = array(
			       //      'filename' => $filename,
			       //      'path' => $temploc,
			       //  );
		        $ext = pathinfo($fileurl, PATHINFO_EXTENSION);
		        
		        if (in_array($ext, $doctypes)){
                
                    $attachments[] = '<a target="_blank" href="https://view.officeapps.live.com/op/embed.aspx?src=' . $fileurl . '">' . $filename . '</a>';

                }else if($ext == 'ai') {

                    $attachments[] = '<a target="_blank" href="https://docs.google.com/viewer?embedded=true&hl=en&url='. $fileurl . '">' . $filename . '</a>';

                }else if($ext == 'eps'){

					$attachments[] = '<a target="_blank" href="/converteps.php?attachment=attachments/'.$uniquefolder.'/'.$filename.'">' . $filename . '</a>';

                } else if($ext == 'msg') {

                	$attachments[] = '<a target="_blank" href="/msgconvert1.php?path=/home/pinpointdev/Dropbox/filemanager/attachments/'.$uniquefolder.'/'.$filename.'">' . $filename . '</a>';

		        }else{
		        	$attachments[] = '<a target="_blank" href="' . $fileurl . '">' . $filename . '</a>';
		        }
		   	}
		}
	}
	foreach ($message->getRecipients() as $recipient) {
	    $email = $recipient->getEmail();
	    $name = $recipient->getName();
	    if ($recipient->getType() == 'From') {
	        $From[] = ($name) ? '<a href="mailto:' . $email . '">' . $name . '</a>' : '<a href="mailto:' . $email . '">' . $email . '</a>';
	    } elseif ($recipient->getType() == 'To') {
	        $To[] = ($name) ? '<a href="mailto:' . $email . '">' . $name . '</a>' : '<a href="mailto:' . $email . '">' . $email . '</a>';
	    } elseif ($recipient->getType() == 'Cc') {
	        $Cc[] = ($name) ? '<a href="mailto:' . $email . '">' . $name . '</a>' : '<a href="mailto:' . $email . '">' . $email . '</a>';
	    } elseif ($recipient->getType() == 'Bcc') {
	        $Bcc[] = ($name) ? '<a href="mailto:' . $email . '">' . $name . '</a>' : '<a href="mailto:' . $email . '">' . $email . '</a>';
	    }
	}
	$data = array(
		'From' => '<a href="mailto:' . $message->properties['sender_email_address'] . '">' . $message->properties['sender_name'] . '</a>',
		'FromName' => $message->properties['sender_email_address'],
		'To' => ($To) ? implode('; ', $To) : '',
		'Date' => ($date) ? $date->format('Y-m-d H:i:s') : '',
		'Cc' => ($Cc) ? implode('; ', $Cc) : '',
		'Bcc' => ($Bcc) ? implode('; ', $Bcc) : '',
		'Subject' => $message->properties['subject'],
		'hasAttachment' => $message->properties['hasattach'],
		'attachments' => ($attachments) ? implode('; ', $attachments) : false,
		'html' => $html,
	);
}catch(Exception $e) {
  echo 'Error Message: ' .$e->getMessage();
  exit;
}
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title></title>
	</head>
	<body>
	<table>
		<tr>
			<td>From: <?php echo $data['From']; ?></td>
		</tr>
		<tr>
			<td>To: <?php echo $data['To']; ?></td>
		</tr>
		<tr>
			<td>Date: <?php echo $data['Date']; ?></td>
		</tr>
		<!--< tr>
			<td>Cc: <?php echo $data['Cc']; ?></td>
		</tr> -->
		<!-- <tr>
			<td>Bcc: <?php echo $data['Bcc']; ?></td>
		</tr> -->
		<tr>
			<td>Subject: <?php echo $data['Subject']; ?></td>
		</tr>
		<tr>
			<td>Attachments: <?php echo $data['attachments']; ?></td>
		</tr>
	</table>
	<hr class="solid">
	<div class="container">
		<?php echo $data['html']; ?>
	</div>
	</body>
	</html>