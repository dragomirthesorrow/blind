<?php
require_once '/var/www/html/classes/connect.php';
require_once '/var/www/html/modules/record/classed/record.php';
$get_monitors="select * from `monitors`";
$monitors=new Connection($get_monitors);
$monitors_a=$monitors->Connect();
foreach($monitors_a as $monitor){
$mon=$monitor['id'];
$end_rec=new Record();
$end=$end_rec->EndRecord($mon);
}
