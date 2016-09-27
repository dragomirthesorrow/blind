<?php
$d1="2016-09-27 14:59:40";
$d2="2016-09-27 15:00:10";
$D1=  strtotime($d1);
$D2= strtotime($d2);
$dd1=getdate($D1);
$dd2=getdate($D2);
echo $dd1['hours'].'/';
echo $dd2['hours'];
//$d3=$D2-$D1;
//echo $d3;
//echo $D1.'/';
//echo $D2;