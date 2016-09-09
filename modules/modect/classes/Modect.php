<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modect
 *
 * @author a.onischenko
 */
include_once ('/var/www/html/configs/interval.config');
require_once ('/var/www/html/modules/modect/classes/Compare.php');
require_once ('/var/www/html/classes/connect.php');
$difference=$MIN_DIFF;

class Modect {
    public $name;
    public $id_mon;
    function __construct($name,$id_mon) {
        //Pдесь преобразуем переменные в нужные, а также получаем картинки для сверки
        $this->name=$name;
        $this->id=$id_mon;
        
    }
    
    public function DetectTheBeginning() {
	//!!! Проверяем - нет ли сейчас события с моника, если нет, то пропускаем все это и переходим к мониторингу завершения.

	$sql_event_now="select * from `events` where `monitor_id`='$this->id' and `end_time` IS NULL";
	$event_now=new Connection($sql_event_now);
	$now=$event_now->Connect();
echo 'work'.$this->name.'and'.$this->id;
	if(empty($now)){
		//Получаем все картинки из директории девайса

		$direct='/var/www/html/modules/record/devices/'.$this->name.'/*.jpg';
		$filelist = glob($direct);
		//Получаем длинну массива
		$c=count($filelist);
		//Выдергиваем последнее изображение и предпоследнее
		$c=$c-1;
		$last_im=$filelist[$c];
		$c2=$c-1;
		$pre_last_img=$filelist[$c2];
		$image1 = new imagick($last_im);
		$image2 = new imagick($pre_last_img);
		$result = $image1->compareImages ($image2,  Imagick::METRIC_MEANSQUAREERROR);
		$diff = round($result[1]*100000,5);
		if($diff>'80'){
			$time=date("Y-m-d H:i:s");
			//Write the event into event base and log
			$sql_add_event="insert into `events` (`id`,`start_time`,`end_time`,`monitor_id`,`unact`) values (NULL,'$time',NULL,'$this->id',NULL)";
			$add_event=new Connection($sql_add_event);
			$add_event->Connect();
			$get_event_id="select * from `events` where `start_time`='$time' and `monitor_id`='$this->id'";
			$event_id=new Connection($get_event_id);
			$event=$event_id->Connect();
			$id_event=$event['0']['id'];
			$log_text='<p>'.$time.' Зафиксировано событие: '.$id_event.'</p>';
			$file1=fopen('/var/www/html/log.txt',"a");
	        	fwrite ($file1, $log_text);
      		}else{
            		//exit;
			//$this->DetectTheEnd($this->name,$this->id);
        	}
	}else{
		//exit;
		//$this->DetectTheEnd($this->name,$this->id);
	} //exit;
    }

   /*public function DetectTheEnd($name,$id_mon) {
	
echo 'end';	
	
	$sql_get_sevent="select * from `events` where `monitor_id`='$this->id' and `end_time` is NULL";
        $get_sevent=new Connection($sql_get_sevent);
        $sevent=$get_sevent->Connect();
	if(empty($sevent)){
		//exit;
	}else{
		$now=date("Y-m-d H:i:s");
		$event_start=$sevent['0']['start_time'];
                $event_id=$sevent['0']['id'];
                //Получаем длинну
                $ntime=strtotime(date("Y-m-d H:i:s"));
                $sttime=strtotime($event_start);
                $during=$ntime-$sttime;
		if($during>10){
			$direct='/var/www/html/modules/record/devices/'.$this->name.'/*.jpg';
                        $filelist = glob($direct);
                        //Получаем длинну массива
                        $c=count($filelist);
                        //Выдергиваем последнее изображение и предпоследнее
                        $c=$c-1;
                        $last_im=$filelist[$c];
                        $c2=$c-1;
                        $pre_last_img=$filelist[$c2];
                        $image1 = new imagick($last_im);
                        $image2 = new imagick($pre_last_img);
                        $result = $image1->compareImages ($image2,  Imagick::METRIC_MEANSQUAREERROR);
                        $diff = round($result[1]*100000,5);
			if($diff<80){
				$unact_loged=$sevent['0']['unact'];
				if($unact_loged==NULL){
				 	$sql_unact_log="update `events` set `unact`='$now' where `id`='$event_id'";
                                	$unact_log=new Connection($sql_unact_log);
                                	$unact_log->Connect();
                                	 exit;
				}
				$unact_loged_i=strtotime($unact_loged);
        	                $now_i=strtotime($now);
	                        $unact=$now_i-$unact_loged_i;
				if($unact<10){
					$sql_unact_log="update `events` set `unact`='$now' where `id`='$event_id'";
                                        $unact_log=new Connection($sql_unact_log);
                                        $unact_log->Connect();
                                         exit;
				}elseif($unact>10){
				 //завершаем событие и передаем параметры скрипту сборки видео
                                $sql_end_event="update `events` set `end_time`='$now' where `id`='$event_id'";
                                $end_event=new Connection($sql_end_event);
                                $end_event->Connect();
                                system("php /var/www/html/modules/event/index.php '$event_id'");
                                $LOG_END='<p>'.$now.'Событие завершено: '.$event_id.'</p>';
                                $file3=fopen('/var/www/html/log.txt',"a");
                                fwrite ($file3, $LOG_END);

				}
			}


		}
	}
 }*/



}

