<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 03/01/15
 * Time: 5:39 PM
 */

class CLS_COMMENT {
    private $pro=array(
        'Id'=>'0',
        'IpAddress'=>'',
        'FullName'=>'',
        'Email'=>'',
        'Contents'=>'',
        'DateTime'=>'',
        'Status'=>1);
    private $objmysql=NULL;

    public function CLS_COMMENT() {
        $this->objmysql=new CLS_MYSQL;
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

    public function getList($where='',$page)  {
        $star = '0';
        $leng = MAXROW;
        $limit = '';
        if ($page!='') {
            $star=($page-1)*MAXROW;
            $limit = " LIMIT $star,$leng";
        }

        $sql = "SELECT * FROM tbl_comments where 1=1 "." ORDER BY `id` DESC ".$where.$limit;
        // echo $sql;
        return $this->objmysql->Query($sql);
    }

    public function Num_rows() {
        return $this->objmysql->Num_rows();
    }

    public function Fetch_Assoc() {
        return $this->objmysql->Fetch_Assoc();
    }

    function Add_new() {
        $sql = " INSERT INTO `tbl_comments` (`ip_address`,`full_name`, `email`, `Contents`, `date_time`, `status`) VALUES";
        $sql.="('".$this->IpAddress."', N'".$this->FullName."', '".$this->Email."', N'".$this->Contents."' ,'".$this->DateTime."', '".$this->Status."')";
        return $this->objmysql->Exec($sql);
    }

    function Delete($id) {
        $sql = "DELETE FROM `tbl_comments` WHERE `id`='".$id."'";
        // echo $sql;
        return $this->objmysql->Exec($sql);
    }

    function getListTotal($str_where) {
        $sql = "SELECT *  FROM tbl_comments WHERE 1=1 ".$str_where;
       // echo $sql;
        return $this->objmysql->Query($sql);
    }

    function getTotalNumRows(){
        $sql = "SELECT *  FROM tbl_comments WHERE 1=1";
        return $this->objmysql->Query($sql);
    }
}

?>