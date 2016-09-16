<?php
require_once ('/var/www/html/configs/database.config');


$connect= mysqli_connect(HOST,USER,PASS,DB) or die (mysqli_error());
//mysqli_select_db(DB,$connect);
//mysqli_set_charset('utf8');
$qu=mysqli_query($connect,"select * from `test`");
print_r($qu);
var_dump($qu);
if($qu==bool){
    echo 'si';
}else{
    print_r($qu);
}
//insert into `test` (`id`,`val`) values ('2','2')
//update `test` set `val`='3' where `id`='1'