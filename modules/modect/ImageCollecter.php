<?php
//Автоматический скрипт фоновый. Постоянно вырезает картинки и дает им названия по тайм стампу. Протестенные картинки будет убивать модект класс

//Получаем все мониторы
// Получаем картинку с каждого по пути в риал тайм и кладем в соответствующую папку
// Через 0,2 секунды повторяем процесс
//В конце перезапуск экземпляра скрипта
require_once '../../configs/path.config';
require_once $begin.'/classes/connect.php';
//Получаем адреса всех камер

$sql_get_cameras="select * from `monitors`";
$get_cameras=new Connection($sql_get_cameras);
$cameras=$get_cameras->Connect();
foreach($cameras as $camera){
        //Запускаем отдельный скрипт для каждого устройства
    system("start-stop-daemon -Sb -x /etc/bin/php ./collect.php?path='$path'&name='$name'");
  
 
}