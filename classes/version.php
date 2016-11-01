<?php
//Получаем версию из файла readme.txt

class Version{
    
    function ShowVersion(){
        $vers=file("/var/www/html/readme.txt");
        $version=$vers['0'];
        return $version;
        
    }
}