<?php session_start();
if(!isset($_SESSION['user_id'])){header('Location:index.php');}
require_once 'classes/version.php';
$vers=new Version();
$version=$vers->ShowVersion();
include_once 'html/main.html';