<?php
$process=file("/var/www/html/mainpid");
$proc=trim($process['0']);
$st='/var/www/html/status';
system("ps '$proc' > '$st'");
$lines=file($st);
$service_status=$lines['1'];
if(empty($service_status)){
    echo 'it does not works';
}  else {
    echo 'it works';
}
