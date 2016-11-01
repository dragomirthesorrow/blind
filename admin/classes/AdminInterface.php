<?php

class Front{
    
    function CameraPanel(){
        require_once($_SERVER['DOCUMENT_ROOT'].'/classes/connect.php');
        echo '<p><a href="#" onclick="window.open(\'tools/addcamera.php\',\'Adding camera\',\'left=400, top=150,menubar=no, location=no, toolbar=no,width=600,height=600\');">Добавить камеру</a></p>';
        $sql_get_cameras="select * from `monitors`";
        $get_cameras=new Connection($sql_get_cameras);
        $cameras=$get_cameras->Connect();
        foreach($cameras as $camera){ 
            echo '<p><a href="#" onclick="window.open(\'tools/camera_settings.php?cam='.$camera['id'].'&cam_name='.$camera['name'].'\', \''.$camera['name'].'\',\'left=400, top=150,menubar=no, location=no, toolbar=no,width=600,height=600\')">'.$camera['name'].'</a></p>';
        }
    }
    
    function MainPanel(){
        require_once '../classes/checktool.php';
        $check=new CheckTools();
        $status_service=$check->CheckStatus();
        //Проверка запущен ли процесс, если да, то кнопка остановить, нет - запустить. В родительском файле получено значение процесса
            if(empty($status_service)){
            //Процесс не запущен
            echo '<p><font color=red>Приложение не запущено.</font><a href="#" onclick="window.open(\'tools/functions/manual_start_stop.php?action=1\',\'Clean\',\'left=400, top=150,menubar=no, location=no, toolbar=no,width=900,height=600\');">Start</a></p>';
            }else{
            //Процесс запущен
            echo '<p><font color=green>Приложение запущено.</font><a href="#" onclick="window.open(\'tools/functions/manual_start_stop.php?action=0\',\'Clean\',\'left=400, top=150,menubar=no, location=no, toolbar=no,width=900,height=600\');">Stop</a></p>';
            }
            $check=new CheckTools();
            $check->CheckDevicesAdmin();
    }
    
    function PhonePanel(){
        //Подключаем модуль phones и выводим его
        require_once '../modules/phone/class/phonetools.php';
        $PPanel=new Phones();
        $panel=$PPanel->ShowAll();
        //print_r($PPanel);
        echo '<table>';
        foreach ($panel['0'] as $item){
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
    echo '<tr><td>'.$name.'</td><td>'.$num.$notice.'</td><td>'.$dn.'</td><td><a href="#">Изменить</a></td></tr>';
        }
        echo '</table>';
    }
}

Class Tools{
    
    function CameraEdit(){
        
    }
    
    function MainSettingsEdit(){
        
    }
    
    function AddCamera(){
        
    }
    
    function CleanVideo(){
        
    }
    
    function StartStopService(){
        
    }
}