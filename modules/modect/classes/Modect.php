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
require_once '../../configs/interval.config';
class Modect {
    //put your code here
    public function GetImages($path){
        $this->id=$path;
        
        /*//Получаем картинки 5 за секунду
        
        //Получаем время старта записи
        $sql_get_startrec="select * from `log_record` where `id_monitor`='$this->id'";
        $startrec=new Connection($sql_get_startrec);
        $start_rec=$startrec->Connect();
        $start_time=$start_rec['start_time'];*/
//system("ffmpeg -ss 1 00:00:00 /var/www/html/modules/record/'$cam_name'/record.avi");
    }
    public function DetectTheBeginning($path) {
        $this->path=$path;
        $Img1->compareImages($Img2, Imagick::METRIC_MEANSQUAREERROR);
    }
    
    public function DetectTheEnd($path) {
        $this->path=$path;
        
    }
    
    
}
