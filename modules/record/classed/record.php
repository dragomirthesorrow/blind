<?php
class Record {
    
    public function StartRecord($monitor){
        //system(start-stop-daemon -Xvbs '$_SERVER[\'DOCUMENT_ROOT\']'/record/'$monitor[\'name\']'/pidrec -r ffmpeg -- '$_SERVER[\'DOCUMENT_ROOT\']'/record/'$monitor[\'name\']'/record.avi);
    //Получаем пид процесса записи и логируем то, что запись идет 
    }
    public function GetPid($pid){
        
    }
    
    }
