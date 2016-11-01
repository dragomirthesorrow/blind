<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset($_SESSION['user_id'])){
    header("Location:index.php");
    
}
//Получаем наличие запущенного процесса и создаем переменную $status_service

//Получаем пид всего процесса
/*$process=file("/var/www/html/mainpid");
$proc=trim($process['0']);
$st='/var/www/html/status';
system("ps '$proc' > '$st'");
$lines=file($st);
$status_service=$lines['1'];*/

require_once '../classes/version.php';
require_once 'classes/AdminInterface.php';

//Получаем версию приложения
$vers=new Version();
$version=$vers->ShowVersion();

//Проверяем запущенность процесса

include_once './html/main.html';
?>
