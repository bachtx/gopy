<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 1/4/15
 * Time: 11:12 PM
 */

date_default_timezone_set('Etc/UTC');
error_reporting(E_ERROR | E_PARSE);
require_once('phpmailer/class.phpmailer.php');
require_once('../admincp/libs/cls.listmail.php');

include("phpmailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$objListMail = new CLS_LISTMAIl();
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
$mail->FromName   = 'Thư góp ý';


$mail->Subject    = "Nội dung góp ý";


// echo $obj->Email;

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->msgHTML(nl2br($obj->Contents));
if($obj->Email !='')
	$mail->AddReplyTo($obj->Email,"");

// Get config emal database
$objListMail->getListMail();
$row = $objListMail->Fetch_Assoc();

if($objListMail->Num_rows() > 0){
	$sent_to = $row['sent_to'];
	$sent_cc = $row['sent_cc'];
	$sent_bcc = $row['sent_bcc'];

	$emailCC = explode(";", $sent_cc);
	$emailBCC = explode(";", $sent_bcc);

	// Sent to
	$mail->AddAddress($sent_to, "Phòng hành chính");	

	//CC
	if(count($emailCC) > 0) {
		foreach ($emailCC as $key => $value) {
			$mail->AddCC($value, "");
		}
	} else {
		if($sent_cc != ''){
			$mail->AddCC($sent_cc, "");
		}			
	}
	

	// BCC
	if(count($emailCC) > 0) {
		foreach ($emailBCC as $key => $value) {
			$mail->AddBCC($value, "");
		}
	} else {
		if($sent_bcc != ''){
			$mail->AddBCC($sent_bcc, "");
		}			
	}
	
	if(!$mail->Send()) {
	    return 'falid';
	} else {
	    return 'sucess ';
	}

}



