<?php
$d1="2016-09-27 14:59:40";
$d2="2016-09-27 15:00:10";
$D1=  strtotime($d1);
$D2= strtotime($d2);
$delta_d=$D2-$D1;
$mk=mktime(0,0,$D2-$D1);
$d4=date("H:i:s", mktime(0,0,$D2-$D1));
echo $d4;
//$d3=$D2-$D1;
//echo $d3;
//echo $D1.'/';
//echo $D2;