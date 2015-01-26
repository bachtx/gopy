<?php
    class CLS_MEMBER
    {
        private $pro= array('MEM_ID'=>'1',
                            'NAME'=>'',
                            'PASS'=>'',
                            'FIRSTNAME'=>'',
                            'LASTNAME'=>'',
                            'BIRTHDAY'=>'',
                            'GENDER'=>'',
                            'ADDRESS'=>'',
                            'PHONE'=>'',
                            'MOBILE'=>'',
                            'EMAIL'=>'',
                            'JOINDATE'=>'',
                            'LASTLOGIN'=>'',
                            'GMEM_ID'=>'',
                            'ISACTIVE'=>'');
        private $mysql=null;
        public function CLS_MEMBER()
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
                echo "khong tim thay $proname...";
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
            $sql= "select*from tbl_member ";
            return $this->mysql->Query($sql);
        }
        public function getInfo($name)
        {
            $sql= "select * from tbl_member where `username`= '$name'";
            return $this->mysql->Query($sql);
        }
        public function getInfoEdit($id){
            $sql= "select * from tbl_member where `mem_id`= '$id'";
            return $this->mysql->Query($sql);
        }
        public function get_name_gmem($id_gmem)
        {
            $sql="select `gmem_id`, `name` from tbl_gmember where `gmem_id`='$id_gmem'";
            $connect = new CLS_MYSQL();
            $connect->Query($sql);
            if($connect->Num_rows()>0){
                $row= $connect->Fetch_Assoc();
                echo $row['name'];
            }
            else echo '';
        }
        public function Add_new()
        {
            $sql="insert into tbl_member (`username`, `password`,`firstname`, `lastname`, `birthday`, `gender`,
                  `address`, `phone`, `mobile`, `email`, `joindate`,`lastlogin`, `gmem_id`,`isactive`  ) values ";
            $sql.="('".$this->NAME."', '".md5(sha1($this->PASS))."', '".$this->FIRSTNAME."', '".$this->LASTNAME."', '".$this->BIRTHDAY."',
                    '".$this->GENDER."', '".$this->ADDRESS."','".$this->PHONE."' ,'".$this->MOBILE."', '".$this->EMAIL."',
                    '".$this->JOINDATE."', '".$this->LASTLOGIN."','".$this->GMEM_ID."', '".$this->ISACTIVE."')";

            return $this->mysql->Query($sql);
        }
        public function Update($id)
        {
//            `password`='".md5(sha1($this->PASS))."',
            $sql="update `tbl_member` set `username`='".$this->NAME."',`firstname`='".$this->FIRSTNAME."',
                `lastname`='".$this->LASTNAME."', `birthday`='".$this->BIRTHDAY."', `gender`='".$this->GENDER."', `address`='".$this->ADDRESS."',
                `phone`='".$this->PHONE."', `mobile`='".$this->MOBILE."', `email`='".$this->EMAIL."',
                `lastlogin`='".$this->LASTLOGIN."', `gmem_id`='".$this->GMEM_ID."',`isactive`='".$this->ISACTIVE."' WHERE `mem_id`='$id'";
           // echo $sql;die;
            return $this->mysql->Query($sql);
        }
        public function Delete($id)
        {
            $sql="delete from tbl_member where `mem_id`='$id'";
            return $this->mysql->Query($sql);
        }
        public  function isActive($id,$value){
            $time = date('Y-d-m:h-i-s');
            $sql = "UPDATE `tbl_member` SET `isactive`='$value' WHERE `mem_id` in ('$id')";
            if($value=='')
                $sql = "Update tbl_member SET `isactive`= if(`isactive`=1,0,1),`joindate`='".$time."' Where `mem_id`='$id'";
            //echo $sql;die;
            $this->mysql->Query($sql);
        }

        public  function Login($user,$pass){
            $mysql = new CLS_MYSQL();
            $user = trim($user);
            $pass = trim($pass);
            $pass = md5(sha1($pass));
            $sql1 = "select `username`,`password`,`gmem_id`,`isactive` from tbl_member where `username`='$user'";
            $mysql->Query($sql1);
            $r = $mysql->Fetch_Assoc();
            if($r['isactive'] == 0){
                $_SESSION['error'] = 1; // tài khoản bị khóa
                return false;
            }
            else {
                $sql = "select `username`,`password`,`gmem_id` from tbl_member where `username`='$user' AND `isactive` = '1'";
                $mysql->Query($sql);
                $row = $mysql->Fetch_Assoc();
                if($row['password']==$pass){
                    $_SESSION['LOGIN'] = $row['username'];
                    $_SESSION['error'] = 0;// đăng nhập thành công
                    if($row['gmem_id'] == 1){
                        $_SESSION['ischeck'] = '1';
                    }

                    return true;
                }
                else{
                    $_SESSION['error'] = 2; // Đăng nhập sai
                    return false;

                }
            }
        }

        public function isLogin(){
            if(isset($_SESSION['LOGIN']))
                return true;
            return false;
        }
        public function isAdmin($gid=1) {
            if(isset($_SESSION['LOGIN']) && $_SESSION['ischeck']==$gid)
                return true;
            return false;
        }

        public  function updateLogin($username){
            $date = date('Y-m-d h:i:s');
            $sql = "update tbl_member SET `lastlogin` ='$date' where `username` = '$username'";
            $this->mysql->Query($sql);
        }

        public function changPass($id,$pass) {
            $pass = md5(sha1($pass));
            $sql = "UPDATE tbl_member SET `password` = '$pass' where `mem_id` = '$id'";
            return $this->mysql->Query($sql);
        }

    }
?>