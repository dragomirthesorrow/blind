<?php

$path='/var/www/html/modules/record/devices/Cam_01/*.jpg';
echo $cam;
$filelist = glob($path);
$max_filename=max($filelist);
print_r($filelist);
//Получаем длинну массива
$c=count($filelist);
//Выдергиваем последнее изображение и предпоследнее
$c=$c-1;
$last_im=$filelist[$c];
$c2=$c-1;
$pre_last_img=$filelist[$c2];

echo $last_im.'/';
echo $pre_last_img.'/';
echo $c;
