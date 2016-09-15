<?php
//add path config
require_once ('/var/www/html/configs/path.config');
require_once ('/var/www/html/classes/connect.php');
class Record {

    public function StartRecord($monitor,$pid){
        $this->mon=$monitor;
        $this->pid=$pid;
        //Получаем имя и путь до камеры
        $sql_get_cam="select * from `monitors` where `id`='$this->mon'";
        $get_cam = new Connection($sql_get_cam);
        $cam=$get_cam->Connect();
        $cam_path=$cam['0']['path'];//Путь камеры
        $cam_name=$cam['0']['name'];//Имя камеры для папок
        //Стартуем запись, логируем событие
        system("start-stop-daemon -Sbmp /var/www/html/modules/record/devices/'$cam_name'/pidrec.txt -x /usr/bin/ffmpeg -- -i '$cam_path' -acodec copy -vcodec copy -y /var/www/html/modules/record/devices/'$cam_name'/record.avi");
        //Лог для файла:
        $system_pid_file=file('/var/www/html/modules/record/devices/'.$cam_name.'/pidrec.txt');
        $system_pid = $system_pid_file[0];
        $date=  date("Y-m-d H:i:s");
        $log_started_record='<p><font color=green> '.$date.' Начата запись с камеры '.$cam_name.', процесс записи: '.$system_pid.'</font></p>';
        $file=fopen('/var/www/html/log.txt',"a");
        fwrite ($file, $log_started_record);
        //Лог для базы
        $sql_log_rec="update `log_record` set `start_time`='$date',`pid`='$system_pid',`finished`=null  where `id_monitor`='$this->mon'";
        $log_rec = new Connection($sql_log_rec);
        $log_rec->Connect();
    }
    public function CheckAndRestart(){
//        echo 'Проверка записей:';
        require_once ('/var/www/html/configs/interval.config');
        $dt=date("Y-m-d H:i:s");
        $date=strtotime(date("Y-m-d H:i:s"));
        //Получаем время записи от начала и сверяем с максимальным
        $sql_get_start="select * from `log_record` where `finished` is NULL";
        $get_start=new Connection($sql_get_start);
        $start=$get_start->Connect();
        //print_r($start);
        foreach($start as $time_arr){
            //Получаем дельту времени
            $camera=$time_arr['id_monitor'];
            $pidn=$time_arr['pid'];
            $time=strtotime($time_arr['start_time']);
            $delta=$date-$time;//Получили время с начала записи
            if($delta > $max_record_time){
//                echo 'Больше!';
                //Если запись идет более допустимого интервала - проверяем на наличие события, в случае отсутствия рестартуем запись и удаляем хвосты
                $sql_check_event="select * from `events` where `end_time` is NULL and `monitor_id`='$camera'";
                $check_event=new Connection($sql_check_event);
                $event=$check_event->Connect();
                if(empty($event)){
  //                  echo 'Записи события нет';//Рестартуем запись с новым пидом
                    //Завершаем запись
                    $sql_get_name="select `name` from `monitors` where `id`='$camera'";
                    $get_name=new Connection($sql_get_name);
                    $name=$get_name->Connect();
$nm=$name['0']['name'];
                    system("start-stop-daemon -Kp /var/www/html/modules/record/devices/'$nm'/pidrec.txt");
                    //удаляем хвосты от записей
//print_r($name);
                    system("rm /var/www/html/modules/record/devices/'$nm'/record_old.avi");
                    system("mv /var/www/html/modules/record/devices/'$nm'/record.avi /var/www/html/modules/record/devices/'$nm'/record_old.avi");
                    system("rm /var/www/html/modules/record/devices/'$nm'/pidrec.txt");
                    $pid_1='/var/www/html/modules/record/devices/'.$monitor_name.'/pid';
                    $pid_2='/var/www/html/modules/record/devices/'.$monitor_name.'/pid1';
                    $dir_for_clean='/var/www/html/modules/record/devices/'.$monitor_name.'/*.jpg';
                    array_map('unlink', glob($dir_for_clean));
                    unlink($pid_1);
                    unlink($pid_2);
                    $log_alert_end='<p><font color=orange>[Atention]'.$dt.'Внимание!Фоновая запись идет более допустимого значения. Процесс: '.$pidn.'. Камера №: '.$camera.'. Процесс перезапускается...</font></p>';
                    $file_end=fopen('/var/www/html/log.txt',"a");
                    fwrite ($file_end, $log_alert_end);
                //Возобновляем запись с новым пид и логом
                    $this->StartRecord($camera, $pidn);
                }else{
                    $log_alert_f='<p><font color=blue>[Atention]'.$dt.'Фоновая запись идет более допустимого значения. Процесс: '.$pidn.'. Камера №: '.$camera.'. !!!Записывается событие!!!</font></p>';
                    $file_f=fopen('/var/www/html/log.txt',"a");
                    fwrite ($file_f, $log_alert_f);
                    //echo 'Запись пока ведется в событии';//Пропускаем цикл
                    //print_r($event);
                    continue;
                }
            }else{
                continue;
            }


        }
    }
    public function EndRecord($monitor){
        //получаем номер камеры в параметре
        $this->monitor=$monitor;

        //завершаем ивенты с этой камеры
        $sql_get_events="select * from `events` where `end_time` is NULL and `monitor_id`='$this->monitor'";
        $get_events=new Connection($sql_get_events);
        $events=$get_events->Connect();
        $sql_monitor_info="select * from `monitors` where `id`='$this->monitor'";
        $monitor_info=new Connection($sql_monitor_info);
        $monitor=$monitor_info->Connect();
        $monitor_name=$monitor['0']['name'];
        $event='События записи прерваны не были.';
        if(!empty($events)){
        $sql_end_events="update `events` set `end_time`=DATE_TIME where `monitor_id`='$this->monitor'";
        $end_event= new Connection($sql_end_events);
        $interrupt=$end_event->Connect();
        $event='Были остановлены события: '.$events['0']['id'];
        //прерываем по пидам события
        }

        //завершаем эхо-запись
        //Получаем пид процесса
        $sql_get_echo="select * from `log_record` where `id_monitor`='$this->monitor'";
        $get_echo=new Connection($sql_get_echo);
        $echo=$get_echo->Connect();
        $echo_pid=$echo['0']['pid'];
        system("start-stop-daemon \-Kp /var/www/html/modules/record/devices/'$monitor_name'/pidrec.txt ");

        //Удаляем хвосты от процессов
	system("rm /var/www/html/modules/record/devices/'$monitor_name'/pidrec.txt");
        system("mv /var/www/html/modules/record/devices/'$monitor_name'/record.avi /var/www/html/modules/record/devices/'$monitor_name'/record_old.avi");
        $pid_1='/var/www/html/modules/record/devices/'.$monitor_name.'/pid';
        $pid_2='/var/www/html/modules/record/devices/'.$monitor_name.'/pid1';
        $dir_for_clean='/var/www/html/modules/record/devices/'.$monitor_name.'/*.jpg';
        array_map('unlink', glob($dir_for_clean));
        unlink($pid_1);
        unlink($pid_2);
        
        //Логируем запись о завершении события пользователем
        $dat=date("Y-m-d H:i:s");
        $log_interrupt='<p><font color=grey>'.$dat.' Запись с камеры '.$this->monitor.' с эхо-процессом '.$echo_pid.' завершена пользователем. '.$event.'</font></p>';
        $file_interrupt=fopen('/var/www/html/log.txt',"a");
        fwrite ($file_interrupt, $log_interrupt);

	//Убираем pid из лога в базе
	$upd_pid="update `log_record` set `pid`='0', `finished`='1' where `id_monitor`='$this->monitor'";
	$pid_new=new Connection($upd_pid);
	$pid_new->Connect();
    }
}
