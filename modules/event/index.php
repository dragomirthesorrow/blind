<?php
require_once('/var/www/html/classes/connect.php');
require_once('/var/www/html/configs/path.config');
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

    //ffmpeg с олд
    //ff с текущей
    //сплит
    //system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_event -x /usr/bin/ffmpeg -- -ss '$start' '$duration' -i '$path_res'/record.avi -vcodec copy '$video_storage'/'$id_event'.avi > /var/www/html/modules/event/event_mod.log");
    //unlink("/var/www/html/modules/record/devices/'.$cam_name.'/pid_event");
}else{
    //фф с текущей
    $start=date("H:i:s", mktime(0,0,$event_start_time_s - $s_rec_s));
    $duration=date("H:i:s", mktime(0,0,$event_end_time_s - $event_start_time_s));
    system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pid_event -x /usr/bin/ffmpeg -- -i '$path_res'/record.avi -ss '$start' '$duration' -vcodec copy '$video_storage'/'$id_event'.avi > /var/www/html/modules/event/event_mod.log");
    unlink("/var/www/html/modules/record/devices/'.$cam_name.'/pid_event");
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
