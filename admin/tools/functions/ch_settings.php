<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['path'])){
    //print_r($_POST);
    $pathp=$_POST['path'];
    $mrtp=$_POST['max_rec_echo'];
    $prerp=$_POST['prer'];
    $pstrp=$_POST['pstr'];
    //еще раз все получаем и проверяем на изменения
    $lines = file('/var/www/html/configs/interval.config');
    $pattern="/\'(.+)\'/";
    preg_match($pattern, $lines['2'],$matches_mrt);
    $mrt=$matches_mrt['1'];
    preg_match($pattern, $lines['3'],$matches_prer);
    $prer=$matches_prer['1'];
    preg_match($pattern, $lines['4'],$matches_pstr);
    $pstr=$matches_pstr['1'];
    $lines2 = file('/var/www/html/configs/path.config');
    preg_match($pattern, $lines2['2'],$matches_path);
    $path=$matches_path['1'];
    

    if($pathp==$path && $mrtp==$mrt && $prerp==$prer && $pstrp==$pstr){
        header("Location:../mainsettings.php?action=2");
    }else{
        $lines['0']='<?php';
        $lines['1']='';
        $lines['2']='$max_record_time=\''.$mrtp.'\';';
        $lines['3']='$prerecord_interval=\''.$prerp.'\';';
        $lines['4']='$postrecord_interval=\''.$pstrp.'\';';
        file_put_contents('/var/www/html/configs/interval.config', '');
        $f1 = fopen('/var/www/html/configs/interval.config',"a");
        //fwrite($f1, $str_value);
        foreach($lines as $line){
            fwrite($f1, $line."\r\n");
        }
        //$tst="wr success";
        //fwrite($f1, $lines);
        fclose($f1);
        //print_r($lines);
       
       
       $lines2['0']='';
       $lines2['1']='';
       $lines2['2']='$video_storage=\''.$pathp.'\'';
       $lines2['3']='?>';
       file_put_contents('/var/www/html/configs/path.config', '');
       $f2 = fopen('/var/www/html/configs/path.config',"a");
        
        foreach($lines2 as $line2){
            fwrite($f2, $line2."\r\n");
        }
       //print_r($lines2);
        fclose($f2);
       header("Location:../mainsettings.php?action=1");
    }
    
}
