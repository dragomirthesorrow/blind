<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['name'])){
    $name_cam=$_POST['name'];
    $path_cam=$_POST['path'];
    $sence_cam=$_POST['sence'];
    $func_cam=$_POST['func'];
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/connect.php';
    $sql_add_cam="insert into `monitors` (`id`,`name`,`path`,`func`) values (NULL,'$name_cam','$path_cam','$func_cam')";
    $add_cam=new Connection($sql_add_cam);
    $add_cam->Connect();
    $sql_get_id="select * from `monitors` order by `id` desc limit 1";
    $get_id=new Connection($sql_get_id);
    $id=$get_id->Connect();
    $id_f=$id['0']['id'];
    $sql_add_recdef="insert into `log_record` (`id`,`id_monitor`,`pid`,`start_time`,`finished`) values (NULL,'$id','0','0000-00-00','1')";
    $add_recdef=new Connection($sql_add_recdef);
    $add_recdef->Connect();
    //Создаем директории в папке рекорд
    mkdir("/var/www/html/modules/record/devices/$name_cam",0777);
    echo '<p align="center"><font color="green">Камера успешно добавлена</font></p>';
}
