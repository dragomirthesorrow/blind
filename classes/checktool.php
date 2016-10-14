<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'connect.php';
Class CheckTools{
    
    public function CheckDevices(){
        $disk_space_byte=disk_free_space("/");
        $disk_space=round($disk_space_byte/1073741824,2);
        $disk_t_space=  disk_total_space("/");
        $percent=round($disk_space_byte*100/$disk_t_space);
        echo '<p>На диске свободно: '.$disk_space.' Гб. ('.$percent.'%)</p>';
        if($disk_space<10)
            { 
                echo '<p><font color="red">Срочно обратитесь к системному администратору. Свободное место заканчивается!</font></p>';
                
            }
            else
            {
                echo '<p><font color="grey">Свободное место в норме.</font></p>';
                
            }
            $sql_check_cameras="select * from `monitors`";
            $check_cameras=new Connection($sql_check_cameras);
            $check=$check_cameras->Connect();
            //echo '<table class="chk">';
            foreach($check as $dev){
                $path=$dev['path'];
                $pattern="/\@(.+)\:/";
                preg_match($pattern, $path, $ip);
                $ip_dev=$ip['1'];
                $log="/var/www/html/ping_log";
                $ping=system("ping -c1 '$ip_dev' >> '$log'");
                $fl=file($log);
                $pat="/100% packet loss/";
                //echo $pat;
                //print_r($fl);
                $fli=implode(",", $fl);
                //print_r($fli);
                preg_match($pat,$fli,$host_stat);
                //print_r($host_stat);
                file_put_contents($log, '');
                //echo '<tr class="yyy">';
                //<td class="xxx">222</td></tr>';
                if(empty($host_stat)){
                    echo '<p>'.$dev['name'].'<img src="../images/online.png" weight="40"/></p>';
                }else{
                    echo '<p>'.$dev['name'].'<img src="../images/offline.png" weight="40"/></p>';
                }
                //echo '</tr>';
            }
            //echo '<table>';
    }
}

