<?php
require_once('/var/www/html/classes/connect.php');
require_once('/var/www/html/configs/path.config');
require_once('/var/www/html/configs/interval.config');
$id_event=$argv[1];
$cam_name=$argv[2];
//echo $id_event;
//Получаем все данные о событии.
$sql_event_info="select * from `events` where `id`='$id_event'";
$event_info=new Connection($sql_event_info);
$info=$event_info->Connect();
$event_start_time=$info['0']['start_time'];
$event_end_time=$info['0']['end_time'];
$id_monitor=$info['0']['monitor_id'];
//получаем время начала записи с камеры и настоящее
$sql_start_rec="select * from `log_record` where `id_monitor`='$id_monitor'";
$start_rec=new Connection($sql_start_rec);
$rec=$start_rec->Connect();
$s_rec=$rec['0']['start_time'];
$event_start_time_s=  strtotime($event_start_time);
$event_end_time_s=  strtotime($event_end_time);
$s_rec_s=strtotime($s_rec);
$path_res='/var/www/html/modules/record/devices/'.$cam_name;
/*//Получаем полностью данные камеры
$sql_monitor_info="select * from `monitors` where `id`='$id_monitor'";
$monitor_info=new Connection($sql_monitor_info);
$info=$monitor_info->Connect();
$path_monitor=$info['0']['path'];
$cam_name=$info['0']['name'];*/
if($event_start_time_s<$s_rec_s){
    $start_old_reverse=$s_rec_s - $event_start_time_s;
    $start_old=date("H:i:s", mktime(0,0, 3600-$start_old_reverse-$prerecord_interval));//Начало события в старом куске
    //ffmpeg с олд
    system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_event1 -x /usr/bin/ffmpeg -- -i '$path_res'/record_old.avi -ss '$start_old_reverse' -vcodec copy -acodec copy '$video_storage'/'$id_event'_1.avi > /var/www/html/modules/event/event_mod.log");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/pid_event1");
    //ff с текущей
    $final_event_time=date("H:i:s", mktime(0,0, $event_end_time_s - $s_rec_s + $postrecord_interval));
    system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_event2 -x /usr/bin/ffmpeg -- -i '$path_res'/record_old.avi -t '$final_event_time' -vcodec copy -acodec copy '$video_storage'/'$id_event'_2.avi > /var/www/html/modules/event/event_mod.log");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/pid_event2");
    //сплит
    system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_event_spl -x /usr/bin/ffmpeg -- -i concat: \"'$path_res'/'$id_event'_1.avi|'$path_res'/'$id_event'_2.avi\" -c copy '$video_storage'/'$id_event'.avi > /var/www/html/modules/event/event_mod.log");
    //system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_event -x /usr/bin/ffmpeg -- -ss '$start' '$duration' -i '$path_res'/record.avi -vcodec copy '$video_storage'/'$id_event'.avi > /var/www/html/modules/event/event_mod.log");
    system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_ss -x /usr/bin/ffmpeg -- -i '$video_storage''$id_event'.avi -an -ss 00:00:01 -r 1 -vframes 1 -f '$video_storage'$id_levent'_screenshot.jpg");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/pid_event_spl");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/'.$id_event.'_1.avi");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/'.$id_event.'_2.avi");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/pid_ss");
}else{
    //фф с текущей
    $start=date("H:i:s", mktime(0,0,$event_start_time_s - $s_rec_s - $prerecord_interval));
    $duration=date("H:i:s", mktime(0,0,$event_end_time_s - $event_start_time_s + $prerecord_interval + $postrecord_interval));
    system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_event -x /usr/bin/ffmpeg -- -i '$path_res'/record.avi -ss '$start' -t '$duration' -vcodec copy -acodec copy '$video_storage'/'$id_event'.avi > /var/www/html/modules/event/event_mod.log");
    system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_ss -x /usr/bin/ffmpeg -- -i '$video_storage''$id_event'.avi -an -ss 00:00:01 -r 1 -vframes 1 -f '$video_storage'$id_levent'_screenshot.jpg");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/pid_event");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/pid_ss");
    //$d4=date("H:i:s", mktime(0,0,$D2-$D1));
}

/*$n_time=date("Y-m-d H:i:s");
$delta_rec=strtotime($n_time)-strtotime($s_rec);
$delta_ev=;*/

/*
//Если часы в начале и конце разные, то будем использовать сплит из старой записи и текущей.
$event_start_time_s=  strtotime($event_start_time);
$event_end_time_s=  strtotime($event_end_time);
$event_start_time=getdate($event_start_time_s);
$event_end_time=getdate($event_end_time_s);
$event_start_h=$event_start_time['hours'];
$event_end_h=$event_end_time['hours'];
if($event_start_h!=$event_end_h){
 
    //ffmpeg с олд
    //ff с текущей
    //сплит
}else{
    //фф с текущей
}*/
