<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($_GET['action']==1){ $act='<p><font color="green">Настройки камеры обновлены успешно.</font></p>';}elseif($_GET['action']==2){ $act='<p><font color="orange">Настройки не были изменены.</font></p>';}else{ $act='';}
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/connect.php';

//$_GET['cam']$_GET['cam_name'];
$id=$_GET['cam'];
$sql_get_cam_info="select * from `monitors` where `id`='$id'";
$get_cam_info=new Connection($sql_get_cam_info);
$cam_info=$get_cam_info->Connect();

$cam_path=$cam_info['0']['path'];
$cam_sence=$cam_info['0']['sence'];
$cam_func=$cam_info['0']['func'];

$sql_get_funcs="select * from `cam_funcs`";
$get_funcs=new Connection($sql_get_funcs);
$funcs=$get_funcs->Connect();


include_once 'html/camera_settings.html';