<?php
/*
В этом файле расположен обработчик изменения общих настроек телефонов, а также каждого, в зависимости от GET параметра
 */
$mac=$_GET['mac'];
if(isset($_GET['mac'])){
    //Для одного аппарата, ежели есть мак
    
    //Выводим конфиг полностью
    $file='/var/www/html/tel_configs/cfg'.$mac.'.xml';
    $config=file($file);
    $action='1';
    include_once '../html/phone_settings.html';
    
    
}else{
    //Конфиг по умолчанию
    $action='2';
    
    
    //Выводим деф-конфиг
    $file='/var/www/html/tel_configs/auto_configurating_phones.sh';
    $cfg=file($file);
    
    /*foreach($cfg as $dir){
        
    }*/
    include_once '../html/phone_settings.html';
}
