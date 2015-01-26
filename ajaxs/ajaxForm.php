<?php
$now = new DateTime();

require_once('../admincp/includes/vtinnit.php');
require_once('../libs/cls.mysql.php');
require_once('../admincp/libs/cls.comment.php');
$obj = new CLS_COMMENT();
$res = array();

date_default_timezone_set("Asia/Saigon");

// $now = new DateTime();

if(isset($_POST['content_comment']) && $_POST['content_comment'] !='') {
    $obj->FullName = $_POST['txt_name'];
    $obj->Email = $_POST['txt_email'];
    $obj->Contents = $_POST['content_comment'];

    if($_POST['txt_email'] != ''){
        $ex = explode("@", $_POST['txt_email']);
        if(!empty($ex) && $ex[1] != 'viettel.com.vn') {
            echo 'error_email';
        } else {
            $result = include('../smtp/sendmail.php');
            if($result == 'sucess ') {
                $ip_address = $_SERVER['REMOTE_ADDR'];;
                $obj->IpAddress = $ip_address;
                $obj->DateTime = $now->format('Y-m-d H:i:s');

                $obj->Add_new();
                echo 'success';
            }
        }


    } else {
        $result = include('../smtp/sendmail.php');
        if($result == 'sucess ') {
            $ip_address = $_SERVER['REMOTE_ADDR'];;
            $obj->IpAddress = $ip_address;
            $obj->DateTime = $now->format('Y-m-d H:i:s');
            $obj->Add_new();
            echo 'success';
        }
    }

} else {
    // echo "empty";
}

if(isset($_POST['autoload'])) {
    $obj->getTotalNumRows();
    $total = $obj->Num_rows();
    echo $total;
}

if(isset($_POST['itemId'])) {    
    $id = $_POST['itemId'];
    $obj->Delete($id);
    echo "success";
}

?>