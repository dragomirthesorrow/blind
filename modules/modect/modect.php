<?php
/*
 * Detecting of moves script
 */
//connecting all requirements
require_once '/var/www/html/classes/connect.php';
require_once ('/var/www/html/modules/modect/classes/Modect.php');
//get all params of all cameras
$sql_get_cameras="select * from `monitors` where func='modect'";
$get_cameras=new Connection($sql_get_cameras);
$cameras=$get_cameras->Connect();
foreach($cameras as $camera){
	$id_mon=$camera['id'];
    $name=$camera['name'];
    $sence=$camera['sence'];
    $detect=new Modect($name,$id_mon,$sence);
    $detect->DetectTheBeginning();
    $detect->DetectTheEnd();
    //$end=new Modect();
    //$end->DetectTheEnd();
    //unset($detect);
}
