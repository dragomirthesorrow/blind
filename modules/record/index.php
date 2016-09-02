<?php
include '../../configs/path.config';
/*
 * Скрипт записи для каждого устройства
 */
//Формируем запрос на получение всех устройств, с которых ведется запись
$sql="select * from `monitors`";
//Подключаемся к классу запроса и получаем ответ
require_once($begin.'/classes/connect.php');
require_once ($begin.'/modules/record/classed/record.php');
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
    $monitor_id=$pid_arr['0']['id_monitor'];
    //Проверяем на наличие записи

        if($pidp == 0){
            //Если запись не идет, то начинаем
        echo 'Запись не идет, начинаем';
    $rec=new Record;
    $rec->StartRecord($monitor_id,$pidp);
}
    //Проверяем длительности записи и рестартуем при необходимости
    $restart=new Record;
    $restart->CheckAndRestart();

        }

