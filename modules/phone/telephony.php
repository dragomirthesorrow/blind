<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/phone/class/phonetools.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Упарвление общей конфигурацией телефонов. Отображение списка телефонов. В дальнейшем управление каждым телефоном.
$phones=new Phones();
$items=$phones->ShowAll();
//print_r($items[0]);
foreach($items['0'] as $item){
    $mac_phone=$item['othertelephone'];
    $num_phone=$item['telephonenumber'];
    $name_phone=$item['samaccountname'];
    $dn_phone=$item['dn'];
    $mac=strtolower($mac_phone['0']);//mac address of device from AD
    $num=$num_phone['0'];//number
    $name=$name_phone['0'];
    preg_match("/CN\=(.+)\,OU/",$dn_phone,$dn1);
    $dn=$dn1['1'];
    //проверяем наличие конфигурации
    $file='/var/www/html/tel_configs/cfg'.$mac.'.xml';
    $exist=file_exists($file);
    if($exist==TRUE){
        $notice='';
    }else{
        $notice='<font size="0,2" color="red">Файл конфигурации не найден.</font>';
    }
    echo '<tr><td>'.$name.'</td><td>'.$num.$notice.'</td><td>'.$dn.'</td></tr>';
    
}
//print_r($phones['0']);