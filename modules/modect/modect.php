<?php
/*
 * Detecting of moves script
 */
/*
 * Gathering the camera information and get 5 frames at a minute, then after comparing detect motion or not.
 * At the beginning it gather all information about cameras from mysql.
 * Then it get 5 frames at second from each other.
 * Then compare, and if motion is detected - begin event.
 * There are two functions:
 * 1 - detect start of motion
 * 2 - detect the end of it.
 * Get frames with pre interval, which is defined in interval.config.
 */
//connecting all requirements
require_once '../../configs/path.config';
require_once $begin.'/classes/connect.php';
require_once '../../modules/modect/classes/modect.php';

//get all params of all cameras
$sql_get_cameras="select * from `monitors`";
$get_cameras=new Connection($sql_get_cameras);
$cameras=$get_cameras->Connect();
foreach($cameras as $camera){
    echo $camera['name'];
}