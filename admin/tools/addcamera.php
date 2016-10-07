<?php
session_start();
if(!isset($_SESSION['user_id'])){
    echo 'Для неавторизованных пользователей доступ закрыт.';
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/connect.php';
$sql_get_funcs="select * from `cam_funcs`";
$get_funcs=new Connection($sql_get_funcs);
$funcs=$get_funcs->Connect();
include_once 'html/addcamera.html';