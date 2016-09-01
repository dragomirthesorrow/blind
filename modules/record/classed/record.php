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
        echo $cam_path;
        echo $cam_name;
        //Стартуем запись, логируем событие
        //system(start-stop-daemon -Xvbs '$_SERVER[\'DOCUMENT_ROOT\']'/modules/record/devices/'$cam_name'/pidrec.txt -r ffmpeg -- '$_SERVER[\'DOCUMENT_ROOT\']'/record/'$monitor[\'name\']'/record.avi);
        //Лог для файла:
        $system_pid_file=file($_SERVER['DOCUMENT_ROOT'].'/modules/record/devices/'.$cam_name.'/pidrec.txt');
        $system_pid = $system_pid_file[0];
        $date=  date("Y-m-d H:i:s");
        //echo $date;
        $log_started_record='<p><font color=green> '.$date.' Начата запись с камеры '.$cam_name.', процесс записи: '.$system_pid.'</font></p>';
        echo $log_started_record;
        
        //Получаем время записи от начала и сверяем с максимальным
        
        //Проверяем не идет ли запись по пиду на отрезке времени, если не идет перестартуем и чистим
        //
        //логируем начало записи и в файл и в скуль
        echo $this->mon;
        echo $this->pid;
        
    }
    public function CheckAndRestart(){
        echo 'Проверка записей:'; 
    }
    
    }
