<?php


//echo 'index of API front';
//echo 'Here will the interface of front';
//$object = new stdClass();
//$array = array(1, 'var_dump test', 4 => $object);
//var_dump($array);
//print_r($_SERVER['DOCUMENT_ROOT']);
//phpinfo();
require_once 'classes/version.php';
$vers=new Version();
$version=$vers->ShowVersion();
include_once '/var/www/html/html/index_main.html';