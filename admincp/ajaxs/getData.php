<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/30/14
 * Time: 6:15 PM
 */
$value = array();
require_once('../includes/vtinnit.php');
require_once('../../libs/cls.mysql.php');
require_once('../libs/cls.comment.php');
require_once('../libs/cls.useragent.php');

$objComment = new CLS_COMMENT();
$objUser = new CLS_USERAGENT();

if (isset($_POST['value'])) {

    $objUser->getDataCharts();
    //$objComment->getDataCharts();
    $aryTime  = array(); $view = array(); $comment = array();

    while($row = $objUser->Fetch_Assoc()) {
        $aryTime[] = date("d-m-Y", strtotime($row['logtime']));
        $view[] = $row['quanty'];   
        $comment[] = 2;    
    }

    // while($row = $objComment->Fetch_Assoc()) {
    //     $aryTime[] = date("d-m-Y", strtotime($row['logtime']));
    //     $view[] = $row['quanty'];       
    // }

    $view = array_map('intval',  $view);
    $infoChart = array (
        array("name" => "Lượt truy cập",
            "data" => $view ),
        array( "name" => "Số thư góp ý",
            "data" => $comment)
    ) ;
    echo json_encode(array(
        'Time' => $aryTime,
        'infoValue' => $infoChart,
    ));
}


