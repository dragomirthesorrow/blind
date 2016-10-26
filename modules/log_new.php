<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$date_created=date("d", filectime("/var/www/html/log.txt"));
$date_current=date("d");
if($date_current!=$date_created){
    rename("/var/www/html/log.txt", "/var/www/html/log_'.$date_created.'.txt");
    file_put_contents('/var/www/html/log.txt','');
}
