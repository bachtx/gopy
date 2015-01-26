<?php
session_start();
ini_set('display_errors',1);
define('ISHOME',true);
ob_start();
require_once('includes/vtinnit.php');
require_once('includes/vtfunction.php');
require_once('../libs/cls.mysql.php');
require_once('libs/cls.listmail.php');
require_once('libs/cls.comment.php');
require_once('libs/cls.member.php');

global $objListMail ; global $obj_user; global $objComment;
$objListMail = new CLS_LISTMAIL();
$obj_user = new CLS_MEMBER();
$objComment =  new CLS_COMMENT();
$f_date = ''; $t_date = '';
// Filter
$str_where = ''; $class = '';
if(!isset($_SESSION['DATE']) || !isset($_SESSION['T_DATE'])) {
    $_SESSION['F_DATE'] = '';
    $_SESSION['T_DATE'] = '';
}

if(isset($_POST['btn_submit'])) {

    if($_POST['txt_conten'] !='') {
        $content = $_POST['txt_conten'] ;
        $str_where.=" AND `contents` like '%".$content."%' ";
    }

    if($_POST['from_date'] !='' || $_POST['to_date'] != '') {

        if($_POST['from_date'] != '') {
            $_SESSION['F_DATE'] = date("d-m-Y", strtotime($_POST['from_date']));  
        } else {
            $_SESSION['F_DATE'] = date("d-m-Y");
        }
        

        if($_POST['to_date'] != '') {
            $_SESSION['T_DATE'] = date("d-m-Y", strtotime($_POST['to_date']));    
        } else {
            $_SESSION['T_DATE'] = date("d-m-Y");
        }
        
    }
}

if($_SESSION['F_DATE'] !='' || $_SESSION['T_DATE'] != '') {
  $f_date = date("Y-m-d", strtotime($_SESSION['F_DATE']));
  $t_date = date("Y-m-d", strtotime($_SESSION['T_DATE']));  
}

if($f_date != ''){
    $str_where.=" AND `date_time` BETWEEN  '".$f_date."' AND '".$t_date."' ";
}



if(!isset($_SESSION['CUR_PAGE']))
    $_SESSION['CUR_PAGE']=1;
if(isset($_POST['txtCurnpage'])){
    $_SESSION['CUR_PAGE'] = $_POST['txtCurnpage'];
}

$objComment->getListTotal($str_where);
$total_rows = $objComment->Num_rows();

if($_SESSION['CUR_PAGE']>ceil($total_rows/MAXROW))
    $_SESSION['CUR_PAGE'] = ceil($total_rows/MAXROW);

$cur_page = ($_SESSION['CUR_PAGE']<1)?1:$_SESSION['CUR_PAGE'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'/>
        <link rel="shortcut icon" href="images/vtcore.ico">
        <link rel="apple-touch-icon" href="images/vtcore.ico">
        <link rel="apple-touch-icon" sizes="72x72" href="images/vtcore.ico">
        <link rel="apple-touch-icon" sizes="114x114" href="images/vtcore.ico">
		<title>Thư góp ý</title>

		<link rel='stylesheet' type='text/css' href='css/style.css'/>
		<script type="text/javascript" src = '../js/jquery-2.1.1.min.js'></script>
		<script type='text/javascript' src = 'js/vtscript.js'></script>
        <link rel='stylesheet' type='text/css' href='css/jquery-ui.css'/>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/highcharts.js"></script>

        <script language="javascript">
            $(function() {
                $( "#datetime" ).datepicker({ dateFormat: 'dd-mm-yy' });
            });
             $(function() {
                $( "#datetime1" ).datepicker({ dateFormat: 'dd-mm-yy' });
            });
        </script>
	</head>
	<body>
        <div id="body">
             <div class="header">
                <div class="title">
                    <h3>Trung tâm nghiên cứu phát triển thiết bị mạng viễn thông Viettel - VTCore</h3>
                </div>
            </div>

             <div class='wrapper'>
            <!-- Main content -->
                <div class="cm_content">
                <?php if ($obj_user->isLogin()) :?>
                    <!-- login -->
                    <div class="tab_control">
                        <div class="tab_dk">
                            <ul class="tab_menu">
                                <li rel="tab1" class="active">Thư góp ý</li>
                                <li rel="tab4">Thống kê</li>
                                <li rel="tab3">Cấu hình mail</li>
                            </ul>
                        </div>
                        <div class="hello_user">
                            <?php
                            if(isset($_SESSION['LOGIN'])){
                                echo '<strong>Xin chào: '.$_SESSION['LOGIN']. '</strong>';
                                echo '<span><a class="logout" href="modules/mod_login/logout.php/">Đăng xuất</a></span>';                                
                            }
                            ?>
                        </div>
                    </div>
                    <div class="container">
                        <!-- Tab1 -->
                        <div id="tab1" class="tab_content">
                            <div class="col_time">
                                <div class="calendar">
                                    <div class="month">
                                        <?php echo 'Tháng '.date('m'); ?>
                                    </div>
                                    <div class="day">
                                        <?php echo date('d');?>
                                    </div>
                                </div>
                                <div class="counter">
                                    <div class="tit_comment"><h3>Ý kiến</h3></div>
                                    <div class='no_of'>
                                        <?php $ob = new CLS_COMMENT();$ob->getTotalNumRows();
                                            echo $ob->Num_rows();
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <div class="col_comment">
                                <div class="filter">
                                    <div class="frm_search">
                                        <div class="left_search">
                                            <form id="frm_list" name="frm_list" method="post" action="">
                                                <span>Tìm kiếm theo </span>
                                                <input type="text" name="txt_conten" placeholder="Từ khóa" class="txt_content">
                                                <input type="text" name="from_date" placeholder="Từ ngày" class="from_date" id="datetime" value="<?php echo $_SESSION['F_DATE'];?>">
                                                <input type="text" name="to_date" placeholder="Đến ngày" class="to_date" id="datetime1" value="<?php echo $_SESSION['T_DATE'];?>">
                                                <input type="submit" class="btn_search" name="btn_submit" value="">                                            
                                            </form>
                                        </div>
                                        <div class="refresh">Refresh</div>
                                    </div>
                                </div>

                                <?php
                                    unset($_SESSION['F_DATE']);
                                    unset($_SESSION['T_DATE']);

                                   if($str_where != '') {
                                        $objComment->getList($str_where,'');
                                    } else {
                                        $objComment->getList($str_where, $cur_page);
                                    }

                                    $stt = $total_rows-(($cur_page-1)*5);
                                   while($row = $objComment->Fetch_Assoc()) {
                                       $author = $row['full_name'];
                                       $status = $row['status'];

                                       $count_word = str_word_count($row['contents']);

                                       if($author == '') {
                                           $author = "Author";
                                       }
                                ?>
                                    <div class="item_comment">
                                        <div class="top_item">                                            
                                            <div class="left_top"><span><?php echo $stt; ?></span></div>
                                            <div class="right_top">
                                                <div class="author">
                                                    Ý kiến bởi : <?php echo $author . ' - '.$row['email'] ?>
                                                </div>
                                                <div class="time">
                                                    <?php echo date('h:i',strtotime($row['date_time'])) ." - ";
                                                    ?>
                                                    <?php echo date('d',strtotime($row['date_time'])) .' Tháng '; echo date('m',strtotime($row['date_time'])).'/';echo date('Y',strtotime($row['date_time']));?>
                                                </div>
                                                <div class="remove_item" itemId="<?php echo $row['id']; ?>"></div>
                                            </div>
                                        </div>
                                        <div class="bottom_item">
                                            <?php if($count_word > 150) $class = "over_word"; ?>                                        
                                            <div class="comment <?php echo $class;?>">
                                                <?php echo $row['contents'];?>
                                            </div>
                                            <?php
                                            if($count_word > 100){
                                            ?>
                                                <div class="reply">
                                                    <div class="scroll_dow" onclick="return toggleSlide(this)">
                                                        <span>Xem chi tiết</span>
                                                    </div>
                                                    <div class="scroll_top" style="display:none" onclick="return toggleSlide(this)">
                                                        <span>Thu gọn</span>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>

                                <?php 
                                    $stt--;
                                } ?>
                                <?php 
                                     if($str_where != '') {                                       
                                    } else {
                                        paging($total_rows,MAXROW,$cur_page); 
                                    }
                                ?>
                                <?php 
                                    if($objComment->Num_rows() == 0) {
                                        echo "<div class='no_result' style='text-align:center;font-style: italic; height: 20px;margin-top: 20px;'>
                                         Không có kết quả nào!
                                         </div>";
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- Tab2 -->

                        <div id="tab4" class="tab_content">
                            <script type="text/javascript" src = 'js/chart/chartCountView.js'></script>
                            <div id="container-countView"></div>                            
                        </div>

                        <!-- Tab3 -->
                         <div id="tab3" class="tab_content" style=" padding: 0px 20px;">
                            <?php include('modules/config_mail/layout.php');?>
                        </div>
                    </div>
                   
                </div>

                <?php else: ?>
                    <!-- no login -->
                    <div class="form-login-admincp">
                        <?php include('modules/mod_login/login.php'); ?>
                    </div>
                <?php endif;?>
            </div>

        </div>
       
        <!--Footer-->
        <div id='footer'>
            <div>
                <span>Mọi thông tin liên hệ: Phòng hành chính</span><br>
                <span>Email: anhtt7@viettel.com.vn</span>
            </div>
        </div>
    </body>
</html>

<?php ob_end_flush();?>