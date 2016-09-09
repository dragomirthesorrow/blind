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
    $record=new Modect();
//    $record->DetectTheBeginning($name,$id_mon);
    $record->DetectTheEnd($name,$id_mon);
}
