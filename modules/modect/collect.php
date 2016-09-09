<?php
//system("echo 'collect'>/var/www/html/test.txt");;
$name=$argv[2];
$id=$argv[1];
require_once ('/var/www/html/classes/connect.php');
//Расчитываем кадр, который надо выдернуть
system("rm /var/www/html/modules/record/devices/'$name'/pid");
//Получаем дату-время начала записи
$sql_get_time="select * from `log_record` where `id_monitor`='$id'";//!!!!!!!!!!!
$get_time=new Connection($sql_get_time);
$time=$get_time->Connect();
$start_time=$time['0']['start_time'];
$path='/var/www/html/modules/record/devices/'.$name.'/record.avi';//!!!!!!!

//получаем картинки для камеры
$date_time=date("YmdHis");
$current_time=date("Y-m-d H:i:s");
//преобразуем в число и высчитываем количество секунд
$stime=strtotime($start_time);
$ctime=strtotime($current_time);
$d=$ctime-$stime;
$duration=mktime(0,0,$d);
$frame=date("H:i:s", $duration);


//echo $start_time.'/';
//echo $current_time.'/';
//echo $stime.'/';
//echo $ctime.'/';
//echo $d.'/';
//echo $frame;
system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$name'/pid -x /usr/bin/ffmpeg -- -i '$path' -an -ss '$frame' -r 1 -vframes 1 -f image2 /var/www/html/modules/record/devices/'$name'/'$date_time'.jpg");
//start-stop-daemon -Sbmp ~/pid -x /usr/bin/ffmpeg -- -i /var/www/html/modules/record/devices/Cam_01/record.avi -an -ss 00:00:10 -r 1 -vframes 1 -f image2 /var/www/html/modules/record/devices/Cam_01/1.jpg
