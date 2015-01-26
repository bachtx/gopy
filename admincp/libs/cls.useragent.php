<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 1/1/15
 * Time: 9:36 PM
 */

class CLS_USERAGENT {
    private $pro=array(
        'Id'=>'0',
        'Ip'=>'',
        'LogTime'=>'0'
    );
    private $objmysql=NULL;

    public function CLS_USERAGENT() {
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

    public  function  getList(){
        $sql = "SELECT * FROM tbl_useragent";
        return $this->objmysql->Query($sql);
    }

    public function AddNew(){
        $mDate = date('Y-m-d H:i:s');
        $Date = date('Y-m-d');
        $sql = " INSERT INTO `tbl_useragent` (`ip`,`logtime`, `date`) VALUES";
        $sql.="('".$this->Ip."', '".$mDate."', '".$Date."')";
        return $this->objmysql->Exec($sql);
    }

    public function getDataCharts(){
        $sql = "SELECT logtime, COUNT(`date`) as quanty FROM tbl_useragent WHERE DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= logtime GROUP BY `date` ORDER BY `logtime` ASC";
        return $this->objmysql->Query($sql);
    }

    public function Num_rows() {
        return $this->objmysql->Num_rows();
    }

    public function Fetch_Assoc() {
        return $this->objmysql->Fetch_Assoc();
    }
}
?>