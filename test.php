<?php
$date_created=date("d", filectime("/var/www/html/log.txt"));
$date_current=date("d");
echo $date_created.'/'.$date_current;
if($date_current>$date_created){
    rename("/var/www/html/log.txt", "/var/www/html/log_'.$date_created.'.txt");
    file_put_contents('/var/www/html/log.txt','');
}