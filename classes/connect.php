<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/configs/database.config');
class Connection{

public $sql;
public function __construct($sql){
        $this->sql=$sql;
}
function Connect(){
$connect= mysqli_connect(HOST,USER,PASS,DB) or die (mysqli_error());
//mysqli_select_db(DB,$connect);
//mysqli_set_charset('utf8');
$qu=mysqli_query($connect,$this->sql);
                $res=array();
                //мое решение:(обратный массив)
                while($data=mysqli_fetch_assoc($qu)){
                        array_splice($res,0,0,array($data));
                }
                return $res;
                mysql_close();
}
}
?>