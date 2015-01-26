<?php
session_start();
include('../../includes/vtinnit.php');
require_once ('../../libs/cls.member.php');
require_once ('../../../libs/cls.mysql.php');

$obj_member =  new CLS_MEMBER();
$obj_member->updateLogin($_SESSION['LOGIN']);
unset($_SESSION['LOGIN']);
unset($_SESSION['ischeck']);

header("location:../../../index.php");
?>