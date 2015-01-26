<?php

date_default_timezone_set('Etc/UTC');
require_once('phpmailer/class.phpmailer.php');

$mail             = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "203.113.131.16"; // SMTP server
// $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                            // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "203.113.131.16";      // sets GMAIL as the SMTP server
$mail->Port       =  465;      				// set the SMTP port for the GMAIL server
$mail->Mailer 	  = "smtp";	 
$mail->CharSet    = 'UTF-8';      

$mail->Username   = "bachtx3@viettel.com.vn";
$mail->Password   = "adfectiver@1";

$mail->From       = 'bachtx3@viettel.com.vn';
$mail->FromName   = 'Phản hồi ý kiến';

$mail->AddReplyTo("","[Email phản hồi]");

$mail->Subject    = "Nội dung phản hồi";

$mail->msgHTML($obj->Contents);

$emailReply = "";

$mail->AddAddress($emailReply, "");

// Get config emal database
$objListMail->getListMail();
$row = $objListMail->Fetch_Assoc();

if(!$mail->Send()) {
	    return 'falid';
} else {
    return 'sucess ';
}



