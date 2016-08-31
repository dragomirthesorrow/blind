<?php

/*
 * Скрипт записи для каждого устройства
 */
//Формируем запрос на получение всех устройств, с которых ведется запись
$sql="select * from `monitors`";
//Подключаемся к классу запроса и получаем ответ
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/connect.php');
$monitorso = new Connection($sql);
//$monitorso->$sql=$sql;
$monitors=$monitorso->Connect();
//Для каждого стартуем запись, если запись не начата
foreach($monitors as $monitor){
    echo $monitor['id'];
    $sqlgetpid="select * from `log_record` where `id_monitor`='.$monitor[id].' order by `id` desc limit 1";
    $getpid=new Connection($sqlgetpid);
    $pid_arr=$getpid->Connect();
    //print_r($pid_arr);
    $pid=$pid_arr['pid'];
    if($pid==0)//проверка по пид, если запись не начата
    {echo '1';
//system(start-stop-daemon -Xvbs '$_SERVER[\'DOCUMENT_ROOT\']'/record/'$monitor[\'name\']'/pidrec -r ffmpeg -- '$_SERVER[\'DOCUMENT_ROOT\']'/record/'$monitor[\'name\']'/record.avi);
}
    
    }