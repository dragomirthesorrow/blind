<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['id_cam'])){

$id_cam=$_POST['id_cam'];
$name_cam=$_POST['name_cam'];
$path_cam=$_POST['path_cam'];
$sence_cam=$_POST['sence_cam'];
$func_cam=$_POST['func_cam'];
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/connect.php';
$sql_compare_info="select * from `monitors` where `id`='$id_cam'";
$compare_info=new Connection($sql_compare_info);
$compare=$compare_info->Connect();
//print_r($compare);
//Проверка на изменение значений.
if($id_cam==$compare['0']['id'] && $name_cam==$compare['0']['name'] && $path_cam==$compare['0']['path'] && $sence_cam==$compare['0']['sence'] && $func_cam==$compare['0']['func']){
    header("Location:../../tools/camera_settings.php?cam=$id_cam&cam_name=$name_cam&action=2");
    //echo 'comp';
    
}else{
$sql_update_cam="update `monitors` set `name`='$name_cam',`path`='$path_cam',`func`='$func_cam',`sence`='$sence_cam' where `id`='$id_cam'";
$update_cam=new Connection($sql_update_cam);
$update_cam->Connect();
//Если имя камеры изменилось, то заменяем соответственную папку в модуле record//
$old_dir=$compare['0']['name'];
if($name_cam!=$compare['0']['name']){
    //Создаем новую соответствующую
    rename("/var/www/html/modules/record/devices/$old_dir","/var/www/html/modules/record/devices/$name_cam");
    
    
}

header("Location:../../tools/camera_settings.php?cam=$id_cam&cam_name=$name_cam&action=1");
}}