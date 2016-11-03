<?php
/*
В этом файле расположен обработчик изменения общих настроек телефонов, а также каждого, в зависимости от GET параметра
 */
//Обработчик поста
if(!empty($_POST)){
    //print_r($_POST);
    //echo $_POST['P3'];
    //если дефолт или нет:
    if($_POST['default']==="${name}" || empty($_GET['mac'])){
        //для всех
        $conf_old=file("/var/www/html/tel_configs/auto_configurating_phones.sh");
        $conf='/var/www/html/tel_configs/auto_configurating_phones1.sh';
        //file_put_contents($conf, '');
        $file=fopen($conf,"a");
        fwrite ($file, "#!/bin/bash \n" );
        fwrite ($file, "\n");
        fwrite ($file, "#this script gets params from auto_conf.php and create configs for phones.\n");
        fwrite($file, "\n");
        fwrite($file, "#mac\n");
        fwrite($file, "mac=$1\n");
        fwrite($file, "#number\n");
        fwrite($file, "number=$2\n");
        fwrite($file, "#name of user\n");
        fwrite($file, "name=$3\n");
        fwrite($file, "\n");
        fwrite($file, "#set the output filename\n");
        fwrite($file, "dfile='/var/www/html/tel_configs/cfg'\${mac}'.xml'\n");
        fwrite($file, "\n");
        fwrite($file, "#start the construction\n");
        fwrite($file, "cat <<EOF >>\$dfile\n");
        fwrite($file, "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
        fwrite ($file, "<gs_provision version=\"1\">\n");
        fwrite ($file, "<mac>\${mac}</mac>\n");
        fwrite ($file, "<config version=\"1\">\n");
        foreach($_POST as $new_dir){
            fwrite($file, trim($new_dir)."\n");
        }
        fwrite($file, "</config>\n");
        fwrite($file, "</gs_provision>\n");
        fwrite($file, "EOF\n");
        fwrite($file,"\n");
        fwrite($file, "#openssl enc -e -aes-256-cbc -k 123456 -in \$dfile -out \$dfile.xml\n");
        fwrite($file, "#rm \$dfile\n");
        //fwrite($file, "\r");
        fclose($file);
        //После создания дефолтной конфигурации запускаем переконфигурирование всех файлов.
        //1 Получаем директивы претерпевшие изменения по сравнению с эталоном $conf_old.
        $conf_new=file("/var/www/html/tel_configs/auto_configurating_phones.sh");
        //print_r($conf_old);
        //print_r($conf_new);
        $dirs=array_diff_assoc($conf_new,$conf_old);

        //Получаем массив старых значений в формате xml
        $conf_old_xml11=array_slice($conf_old,16);

        $lenth=count(file("/var/www/html/tel_configs/cfg.xml"));
        $conf_old_xml=array_slice($conf_old_xml11,0,$lenth);
                foreach($conf_old_xml as $xml){
            echo htmlspecialchars($xml).'<br/>';
        }
        //print_r($conf_old_xml);
        /*foreach($conf_old_xml as $xml){
            echo HTMLSPECIALCHARS($xml).'<br/>';
        }*/
        
        //3 Получаем для каждого файла кфг отличия от эталона.
        $cfg_files_dir='/var/www/html/tel_configs/cfg*.xml';
        $cfg_files=glob($cfg_files_dir);
        foreach($cfg_files as $cfile){
            echo'-----------------------------'.$cfile.'<br/>';
            $linesall=file($cfile);
            //print_r($c);
            $dirs_not_to_update=array_diff($linesall,$conf_old_xml);//Директивы, которые не будем менять
            //4 Получаем масив директив для конкретного аппарата, коорые будут заменены. Исключаем директивы, измененные для аппарата,
            //а также директивы аккаунтов. (они исключены на этапе сверки старого и нового файла дефолтной конфигурации)$dirs_not_to_update
            //$dirs
            //$directory_to_change=array_diff($dirs,$dirs_not_to_update);
            //print_r($c);
            print_r($dirs_not_to_update).'////////////////////////////////';
            //sleep(1);
            /*foreach ($dirs_not_to_update as $ddd){
               
                echo htmlspecialchars($ddd).'<br/>';
            }*/
            
        }
        unset($conf_old_xml);
        unset($conf_old_xml11);
        unset($lenth);
        //3 Если изменено для определенного телефона, то директиву по умолчанию не перезаписываем.
        //print_r(htmlspecialchars(($diff));

        
        
        //Выбираем телефоны, которые необходимо сконфигурировать.
        unlink("/var/www/html/tel_configs/auto_configurating_phones.sh");
        rename("/var/www/html/tel_configs/auto_configurating_phones1.sh","/var/www/html/tel_configs/auto_configurating_phones.sh");
        //mv 1 - 0
    }else{
        $mac=$_GET['mac'];
        //echo '1'.$mac;
        //для одного телефона
        $cofg='/var/www/html/tel_configs/cfg'.$mac.'.xml';
        file_put_contents($cofg, '');
        $cfg=fopen($cofg,"a");
        fwrite($cfg, "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n");
        fwrite($cfg, "<gs_provision version=\"1\">\r\n");
        fwrite($cfg, "<mac>$mac</mac>\r\n");
        fwrite($cfg, "<config version=\"1\">\r\n");
        foreach($_POST as $new_dir){
            fwrite($cfg, $new_dir."\r\n");
        }
        fwrite($cfg, "</config>\r\n");
        fwrite($cfg, "</gs_provision>\r\n");
        fclose($cfg);
    }
}else{
$mac=$_GET['mac'];
if(isset($_GET['mac'])){
    //Для одного аппарата, ежели есть мак
    
    //Выводим конфиг полностью
    $file='/var/www/html/tel_configs/cfg'.$mac.'.xml';
    $config=file($file);
    $action='1';
    include_once '../html/phone_settings.html';
    
    
}else{
    //Конфиг по умолчанию
    $action='2';
    
    
    //Выводим деф-конфиг
    $file='/var/www/html/tel_configs/auto_configurating_phones.sh';
    $cfg=file($file);
    
    /*foreach($cfg as $dir){
        
    }*/
    include_once '../html/phone_settings.html';
}
}