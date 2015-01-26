<?php

error_reporting(E_STRICT | E_ALL);

date_default_timezone_set('Etc/UTC');

require '../PHPMailerAutoload.php';

$mail = new PHPMailer;

$body = file_get_contents('contents.html');
//$body = eregi_replace("[\]",'',$body);

$mail->isSMTP();
$mail->SMTPAuth   = true;                  // Sử dụng đăng nhập vào account
$mail->SMTPSecure = "ssl";
$mail->Host       = "203.113.131.16";     // Thiết lập thông tin của SMPT
$mail->Port       = 465;

$mail->Username = 'bachtx3@viettel.com.vn';
$mail->Password = 'adfectiver@1';
$mail->setFrom('HuongTV2@viettel.com.vn', 'List manager');
$mail->addReplyTo('bachtx3@viettel.com.vn', 'List manager');

$mail->Subject = "PHPMailer Simple database mailing list test";

$mail->msgHTML($body);
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

//Connect to the database and select the recipients from your mailing list that have not yet been sent to
//You'll need to alter this to match your database
$mysql = mysqli_connect('localhost', 'root', '');
mysqli_select_db($mysql, 'db_comments');
$result = mysqli_query($mysql, 'SELECT sent_to FROM tbl_listmail');
var_dump($result);

foreach ($result as $row) { //This iterator syntax only works in PHP 5.4+
    $mail->addAddress("bachtx3@viettel.com.vn", "AUthor");

    if (!$mail->send()) {
        echo "Mailer Error (" . str_replace("@", "&#64;", $row["sent_to"]) . ') ' . $mail->ErrorInfo . '<br />';
        break; //Abandon sending
    } else {
        echo "Message sent to :" .' (' . str_replace("@", "&#64;", $row['sent_to']) . ')<br />';
        //Mark it as sent in the DB
        mysqli_query(
            $mysql,
            "UPDATE mailinglist SET status = 2 WHERE email = '" .
            mysqli_real_escape_string($mysql, $row['sent_to']) . "'"
        );
    }
    // Clear all addresses and attachments for next loop
    $mail->clearAddresses();
    $mail->clearAttachments();
}
