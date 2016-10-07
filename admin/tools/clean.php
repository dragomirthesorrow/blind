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
//include'../js/calendar.js';
if(isset($_GET['action']) && $_GET['action']==0){
    $act='<p><font color="orange">Записей найдено не было.</font></p>';
}elseif(isset($_GET['action']) && $_GET['action']==1){
    $act='<p><font color="green">Записи удалены.</font></p>';
}elseif(!isset($_GET['action'])){
    $act='';
}
include_once 'html/clean.html';
