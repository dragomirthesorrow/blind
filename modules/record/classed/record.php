<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/classes/connect.php');
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
        //system(start-stop-daemon -Xvbs '$_SERVER[\'DOCUMENT_ROOT\']'/modules/record/devices/'$cam_name'/pidrec.txt -r ffmpeg -- '$_SERVER[\'DOCUMENT_ROOT\']'/record/'$monitor[\'name\']'/record.avi);
        //Лог для файла:
        $system_pid_file=file($_SERVER['DOCUMENT_ROOT'].'/modules/record/devices/'.$cam_name.'/pidrec.txt');
        $system_pid = $system_pid_file[0];
        $date=  date("Y-m-d H:i:s");
        $log_started_record='<p><font color=green> '.$date.' Начата запись с камеры '.$cam_name.', процесс записи: '.$system_pid.'</font></p>';
        $file=fopen($_SERVER['DOCUMENT_ROOT'].'/log.txt',"a");
        fwrite ($file, $log_started_record);
        //Лог для базы
        $sql_log_rec="update `log_record` set `start_time`='$date',`pid`='$system_pid' where `id_monitor`='$this->mon'";
        $log_rec = new Connection($sql_log_rec);
        $log_rec->Connect();
    }
    public function CheckAndRestart(){
        echo 'Проверка записей:'; 
        require_once ($_SERVER['DOCUMENT_ROOT'].'/configs/interval.config');
        $dt=date("Y-m-d H:i:s");
        $date=strtotime(date("Y-m-d H:i:s"));
        //Получаем время записи от начала и сверяем с максимальным
        $sql_get_start="select * from `log_record`";
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
                echo 'Больше!';
                //Если запись идет более допустимого интервала - проверяем на наличие события, в случае отсутствия рестартуем запись и удаляем хвосты
                $sql_check_event="select * from `events` where `end_time` is NULL and `monitor_id`='$camera'";
                $check_event=new Connection($sql_check_event);
                $event=$check_event->Connect();
                //$log_alert='<p><font color=orange>Внимание!Фоновая запись идет более допустимого значения. Процесс: '.$pidn.'. Камера №: '.$camera.'</font></p>';
                //$filel=fopen($_SERVER['DOCUMENT_ROOT'].'/log.txt',"a");
                //fwrite ($filel, $log_alert);
                if(empty($event)){
                    echo 'Записи события нет';//Рестартуем запись с новым пидом
                    //Завершаем запись
                    $sql_get_name="select `name` from `monitors` where `id`='$camera'";
                    $get_name=new Connection($sql_get_name);
                    $name=$get_name->Connect();
                    //system("start-stop-daemon \-Kp '$_SERVER[\'DOCUMENT_ROOT\']'/modules/record/devices/'$name['0']['name']'/pidrec.txt");
                    
                    $log_alert_end='<p><font color=orange>Внимание!Фоновая запись идет более допустимого значения. Процесс: '.$pidn.'. Камера №: '.$camera.'. Процесс перезапускается...</font></p>';
                    $file_end=fopen($_SERVER['DOCUMENT_ROOT'].'/log.txt',"a");
                    fwrite ($file_end, $log_alert_end);
                //Возобновляем запись с новым пид и логом
                    $new_record=$this->StartRecord($camera, $pidn);
                    
                }else{
                    $log_alert_f='<p><font color=blue>Фоновая запись идет более допустимого значения. Процесс: '.$pidn.'. Камера №: '.$camera.'. !!!Записывается событие!!!</font></p>';
                    $file_f=fopen($_SERVER['DOCUMENT_ROOT'].'/log.txt',"a");
                    fwrite ($file_f, $log_alert_f);
                    echo 'Запись пока ведется в событии';//Пропускаем цикл
                    print_r($event);
                    continue;
                }
            }else{
                echo 'записи ваще не идет';
                continue;
            }
            //Проверяем - идет ли запись Ивента
            //$monit=$time['monitor'];
            //$sql_event_record="select * from `event` where `monitor_id`='$monit'";
            //$event_record=new Connection($sql_event_record);
            //$event=$event_record->Connect();
            
        }
        
        //Проверяем не идет ли запись по пиду на отрезке времени, если не идет перестартуем и чистим
        //
        //логируем начало записи и в файл и в скуль
    }
    public function EndRecord(){
        
    }
    }
