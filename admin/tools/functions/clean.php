<?php
session_start();
if(!isset($_SESSION['user_id'])){
    echo 'Для неавторизованных пользователей доступ закрыт.';
}
if(isset($_POST['since'])){
    //print_r($_POST);
    require_once $_SERVER['DOCUMENT_ROOT'].'/configs/path.config';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/connect.php';
    //Выбираем все события в промежутке этих дат.
    $date_min=$_POST['since'];
    $date_max=$_POST['to'];
    $date_mn=date("Y-m-d", strtotime($date_min));
    $date_mx=date("Y-m-d", strtotime($date_max));
    //echo $date_m;
    $sql_get_events="select * from `events` where DATE(`start_time`)>'$date_mn' and DATE(`start_time`)<'$date_mx'";
    $get_events=new Connection($sql_get_events);
    $events=$get_events->Connect();
    //print_r($events);
    if(empty($events)){
     //echo 'empty';  
        header("Location:../clean.php?action=0");
    }else{
        //echo 'not empty';
        foreach ($events as $event){
            $id=$event['id'];
            $filename=$video_storage.$id.'.avi';
            unlink($filename);
            //echo $filename;
            $sql_del="delete from `events` where `id`='$id'";
            $del=new Connection($sql_del);
            $del->Connect();
        }
        header("Location:../clean.php?action=1");
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

