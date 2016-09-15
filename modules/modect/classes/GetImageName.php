<?php



class GetImageName{
    
    public function GetName(){
        $direct='/var/www/html/modules/record/devices/'.$this->name.'/*.jpg';
        $filelist = glob($direct);
        //Получаем длинну массива
        $c=count($filelist);
        //Выдергиваем последнее изображение и предпоследнее
        $c=$c-1;
        $last_im=$filelist[$c];
        $c2=$c-1;
        $pre_last_img=$filelist[$c2];
    }
}




