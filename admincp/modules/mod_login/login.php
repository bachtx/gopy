<?php
if(isset($_POST['dang_nhap'])){
    $obj_user->Login($_POST['txt_user'],$_POST['txt_pass']);
    header("location:index.php");
}
else{?>
    <h3 class="title-login">ĐĂNG NHẬP</h3>
    <div class="div_login">
        <div>
        <form action="" method="post" class="frm_login">
            <table width="100%" border="0" align="center" cellspacing="0" cellpadding="3">
                <tr>
                    <td align="right"><strong>Tên đăng nhập :</strong> </td>
                    <td><input type="text" name="txt_user"  class="txt_user" autofocus="true"/></td>
                </tr>
                <tr>
                    <td align="right"><strong>Mật khẩu: </strong></td>
                    <td><input type="password" name="txt_pass"></td>
                </tr>
<!--                <tr>-->
<!--                    <td align="right"><strong>Mã bảo mật :</strong></td>-->
<!--                    <td><input type="text" name="txt_mabaomat"><img src="capchar/captchaSecurityImages.php"></td>-->
<!--                </tr>-->
                <tr>
                    <td align="right"></td>
                    <td>
                        <input type="submit" class="btn_login" name="dang_nhap" value="Đăng nhập">
                        <input type="reset" name="reset" class="btn_cancel" value="Hủy">
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>
    <?php
    if(isset($_SESSION['error']) && $_SESSION['error'] == 1)
        echo "<script type='text/javascript'>alert('Vui lòng thử lại đăng nhập !')
        </script>";
    if(isset($_SESSION['error']) && $_SESSION['error'] == 2)
        echo "<script type='text/javascript'>alert('Vui lòng thử lại đăng nhập')
         </script>";

    unset($_SESSION['error']);
    unset($_SESSION['ERROR_LOGIN']);
    ?>

<?php }
?>

