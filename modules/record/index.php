<?php

/*
 * Скрипт записи для каждого устройства
 */
//Формируем запрос на получение всех устройств, с которых ведется запись
$sql="select * from `monitors`";
//Подключаемся к классу запроса и получаем ответ
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/connect.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/modules/record/classed/record.php');
$monitorso = new Connection($sql);
//$monitorso->$sql=$sql;
$monitors=$monitorso->Connect();
//Для каждого стартуем запись, если запись не начата
foreach($monitors as $monitor){
    //echo $monitor['id'];
    $sqlgetpid="select * from `log_record` where `id_monitor`='$monitor[id]' order by `id` desc limit 1";
    $getpid=new Connection($sqlgetpid);
    $pid_arr=$getpid->Connect();
    //print_r($pid_arr);
    $pidp=$pid_arr['0']['pid'];
    if($pidp==0)//проверка по пид, если запись не начата
    {
    //echo $pidp;
    //вызов класса записи
    $rec=new Record;
    $rec->StartRecord($pidp);
}
    
    }