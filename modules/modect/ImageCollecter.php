<?php
require_once '/var/www/html/classes/connect.php';
//Получаем адреса всех камер
//echo 'exrcuting';
$sql_get_cameras="select * from `monitors` where `func`='modect'";
$get_cameras=new Connection($sql_get_cameras);
$cameras=$get_cameras->Connect();
$i=1;
//sleep(4);
while($i==1){
foreach($cameras as $camera){
        //Запускаем отдельный скрипт для каждого устройства
	$name=$camera['name'];
	$id=$camera['id'];
//echo $name;echo $id;
    system("php /var/www/html/modules/modect/collect.php '$id' '$name'");


}
//sleep(3);
}
exit;
