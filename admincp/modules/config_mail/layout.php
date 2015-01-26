<?php
    $objListMail->getListMail();
    $row = $objListMail->Fetch_Assoc();

    if(isset($_POST['cmdsave'])) {
        $objListMail->SentTo = un_unicode($_POST['sent_to']);
        $objListMail->SentCc = un_unicode($_POST['sent_cc']);
        $objListMail->SentBcc= un_unicode($_POST['sent_bcc']);
        $objListMail->SmtpServer = $_POST['smtp_server'];
        $objListMail->Port = $_POST['port'];
        $objListMail->Authen = $_POST['authen'];
        $objListMail->Id = $_POST['txt_id'];
        $objListMail->Update();
        header('location:index.php');
    }
?>
<section style="padding:15px 0 0;">
<form method='POST' action=''>
	<table width="60%" cellspacing="1" cellpadding="6"  class='frm'>
        <tr><td colspan="2">Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</td></tr>
		<tr>
			<th width="150" align="right" bgcolor="#fff">SMTP Server<span class='star'>*</span> :</th>
			<td><input type='text' name='smtp_server' maxlength="50" value="<?php echo $row['smtp_server']?>" readonly/>
                <label id="txt_smtp_server" class="label_error"></label>
            </td>
		</tr>
        <tr>
            <th width="150" align="right" bgcolor="#fff">Port<span class='star'>*</span> :</th>
            <td><input type='text' name='port' maxlength="10" value="<?php echo $row['port']?>" readonly/>
            </td>
        </tr>
        <tr>
            <th width="150" align="right" bgcolor="#fff">SMTP Secure<span class='star'>*</span> :</th>
            <td><input type='text' name='authen' maxlength="10" value="<?php echo $row['authen']?>" readonly/>
            </td>
        </tr>
        <tr>
            <th width="150" align="right" bgcolor="#fff"><span class='star'>*</span>Sent To  :</th>
            <td><input type='text' name='sent_to' value='<?php echo un_unicode($row['sent_to']); ?>' style="width:200px;"/></td>
        </tr>
        <tr>
            <th width="150" align="right" bgcolor="#fff">CC :</th>
            <td>
                <textarea name="sent_cc" style="width: 392px; height: 80px;"><?php echo un_unicode($row['sent_cc']); ?></textarea>
            </td>
        </tr>
        <tr>
            <th width="150" align="right" bgcolor="#fff">BCC :</th>
            <td>
                <textarea name="sent_bcc" style="width: 392px; height: 80px;" ><?php echo un_unicode($row['sent_bcc']); ?></textarea>
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">
                <input type="submit" name="cmdsave" id="cmdsave" value="Cập nhật">
                <input type="hidden" value="<?php echo $row['id']?>" name="txt_id">
            </td>
        </tr>
    </table>
    
</form>
</fieldset>
</section>