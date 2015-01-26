<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 1/1/15
 * Time: 9:36 PM
 */
class CLS_LISTMAIL {
    private $pro=array(
        'Id'=>'0',
        'SmtpServer'=>'',
        'Port'=>'0',
        'Authen'=>'',
        'SentTo'=>'',
        'SentCc'=>'',
        'SentBcc'=>''
    );
    private $objmysql=NULL;

    public function CLS_LISTMAIL() {
        $this->objmysql = new CLS_MYSQL;
    }

    // property set value
    public function __set($proname,$value) {
        if(!isset($this->pro[$proname])){
            echo ('Can not found $proname member');
            return;
        }
        $this->pro[$proname]=$value;
    }

    public function __get($proname) {
        if (!isset($this->pro[$proname])) {
            echo ("Can not found $proname member");
            return;
        }
        return $this->pro[$proname];
    }

    public  function  getListMail(){
        $sql = "SELECT * FROM tbl_listmail";
        //echo $sql;
        return $this->objmysql->Query($sql);
    }

    public function Update(){
            $sql = "UPDATE tbl_listmail  SET `sent_to`='".$this->SentTo."',`sent_cc`='".$this->SentCc."', 
            `sent_bcc`='".$this->SentBcc."',`smtp_server`='".$this->SmtpServer."', `port`='".$this->Port."', `authen`='".$this->Authen."'  WHERE `id`='".$this->Id."'";
            return $this->objmysql->Exec($sql);        
    }

    public function Num_rows() {
        return $this->objmysql->Num_rows();
    }

    public function Fetch_Assoc() {
        return $this->objmysql->Fetch_Assoc();
    }
}
?>