<?php
$name=$_GET['name'];
$name='Cam_01';
//получаем картинки для камеры
$date_time=date("Ymd_His");
system("ffmpeg -i '$path' -vframes 1 -an -f image2 /var/www/html/modules/record/devices/'$name'/1_'$date_time'.jpg");
time_nanosleep(0, 500000);

$date_time=date("Ymd_His");
system("ffmpeg -i '$path' -vframes 1 -an -f image2 /var/www/html/modules/record/devices/'$name'/2_'$date_time'.jpg");
exit;


