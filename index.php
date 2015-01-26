<?php
require_once('admincp/includes/vtinnit.php');
require_once('libs/cls.mysql.php');
require_once('admincp/libs/cls.useragent.php');
require_once('admincp/libs/cls.comment.php');
$obj = new CLS_COMMENT();

$objAgent = new CLS_USERAGENT();
$objAgent->Ip = $_SERVER['REMOTE_ADDR'];
$objAgent->AddNew();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thư góp ý</title>
    <link rel="shortcut icon" href="images/vtcore.ico">
    <link rel="apple-touch-icon" href="images/vtcore.ico">
    <link rel="apple-touch-icon" sizes="72x72" href="images/vtcore.ico">
    <link rel="apple-touch-icon" sizes="114x114" href="images/vtcore.ico">

    <script src="js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/main-style.css">
    <script type="text/javascript" src = 'js/vtcore.js'></script>

    <!-- <link rel="stylesheet" type="text/css" href="css/jquery-te-1.4.0.css"> 
    <script type="text/javascript" src = 'js/jquery-te-1.4.0.min.js'></script> -->
    <script type="text/javascript" src = 'js/nicEdit.js'></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
    </script>
    
</head>
<body>
<!--Header-->
<div id="body">    
    <div class="header">
        <div class="title">
            <h3>Trung tâm nghiên cứu phát triển thiết bị mạng viễn thông Viettel - VTCore</h3>
        </div>
    </div>
    <!--Main content-->
    <div id="wrapper">
        <div class="main_content">
            <div class="col_left">
                <div class="frm_comment">
                    <form action="" method="post" class="form_comment" id="form_comment">
                        <ul>
                            <li>
                                <label class="title">Họ và tên:</label>
                                <input type="text" value="" maxlength="50" placeholder="Họ và tên..." name="txt_name" class="inputValidateText txt_name" autofocus></br>
                            </li>
                            <li>
                                <label class="title">Email:</label>
                                <input type="text" value="" maxlength="50" placeholder="example@viettel.com.vn" name="txt_email" class="txt_mail"></br>
                            </li>
                            <li>
                                <label class="title">Ý kiến</label><font color="red"> *</font></br>
                                <label id="txt_error" style="display: none;color: #ff0000"></label>
                                <textarea name="content_comment" class="jqte-test inputValidateText"></textarea>
                            </li>                        
                        </ul>
                        <div class="action_submit"><input type="submit" value="Đóng góp" name="cmd_sent" class="btn_sent" ></div>
                    </form>
                </div>
            </div>
            <div class="col_right">
                <div class="counter">
                    <div class="no_of">
                        <div>
                            <?php
                                $obj->getTotalNumRows();
                                echo $obj->Num_rows();
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--Footer-->
    <div id='footer'>
        <div>
        <span>Mọi thông tin liên hệ: Phòng hành chính</span><br>
            <span>Email: anhtt7@viettel.com.vn</span>    
        </div>
    </div>
</div>
</body>
</html>
<script>
    // $('.jqte-test').jqte();
    // var jqteStatus = true;
    // $(".status").click(function()
    // {
    //     jqteStatus = jqteStatus ? false : true;
    //     $('.jqte-test').jqte({"status" : jqteStatus})
    // });
</script>

