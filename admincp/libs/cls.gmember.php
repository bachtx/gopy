<?php
class CLS_GMEMBER
{
    private $pro= array('GMEM_ID'=>'1', 'NAME'=>'', 'INTRO'=>'', 'ISACTIVE'=>'');
    private $mysql=null;
    public function CLS_GMEMBER()
    {
        $this->mysql= new CLS_MYSQL();
    }
    public function __set($proname, $value)
    {
        if(!isset($this->pro[$proname]))
        {
            echo "khong tim thay";
            return;
        }
        return $this->pro[$proname]=$value;
    }
    public function __get($proname)
    {
        if(!isset($this->pro[$proname]))
        {
            echo "khong tim thay...";
            return;
        }
        return $this->pro[$proname];
    }
    public function Fetch_Assoc()
    {
        return $this->mysql->Fetch_Assoc();
    }
    public function get_List()
    {
        $sql= "select*from tbl_gmember";
        return $this->mysql->Query($sql);
    }
    public function getInfo($id)
    {
        $sql= "select * from tbl_gmember where `gmem_id`= '$id'";
        return $this->mysql->Query($sql);
    }
    public function addNew()
    {
        $sql="insert into tbl_gmember(`name`, `intro`, `isactive`) values ";
        $sql.="('".$this->NAME."', '".$this->INTRO."', '".$this->ISACTIVE."')";
        return $this->mysql->Query($sql);
    }
    public function Update($id)
    {
        $sql="UPDATE tbl_gmember SET `name`='".$this->NAME."',
                                     `intro`='".$this->INTRO."',
                                     `isactive`='".$this->ISACTIVE."' where `gmem_id`='$id'";

        return $this->mysql->Query($sql);
    }
    public function Delete($id)
    {
        $sql="delete from tbl_gmember where `gmem_id`='$id'";
        echo $sql;
        return $this->mysql->Query($sql);
    }
    public  function isActive($id,$value){
        $sql = "UPDATE `tbl_gmember` SET `isactive`='$value' WHERE `gmem_id` in ('$id')";
        if($value=='')
            $sql = "Update tbl_gmember SET `isactive`= if(`isactive`=1,0,1)Where `gmem_id`='$id'";

        $this->mysql->Query($sql);
    }

}
?>