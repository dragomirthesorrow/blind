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
    //Создаем директории в папке рекорд
    mkdir("/var/www/html/modules/record/devices/'.$name_cam.'",0777);
    echo '<p align="center"><font color="green">Камера успешно добавлена</font></p>';
}
