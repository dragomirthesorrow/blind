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
include_once './html/main.html';
?>

-создание файла дампа базы