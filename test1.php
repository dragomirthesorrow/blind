<?php

$directcstr='/var/www/html/modules/record/devices/Cam_01/*.jpg';
$filelistcstr = glob($directcstr);
print_r($filelistcstr);