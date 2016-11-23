<?php
/*
В этом файле расположен обработчик изменения общих настроек телефонов, а также каждого, в зависимости от GET параметра
 */
//Обработчик поста
if(!empty($_POST)){
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
        fwrite($file,"cfile='/var/www/html/tel_configs/confirmed_cfg'\${mac}'.xml' \n");
        fwrite($file, "openssl enc -e -aes-256-cbc -k 123456 -in \$dfile -out \$dfile.xml\n");
        fwrite($file, "#rm \$dfile\n");
        //fwrite($file, "\r");
        fclose($file);
        //После создания дефолтной конфигурации запускаем переконфигурирование всех файлов.
        //1 Получаем директивы претерпевшие изменения по сравнению с эталоном $conf_old.
        $conf_new=file("/var/www/html/tel_configs/auto_configurating_phones1.sh");
        $dirs=array_diff_assoc($conf_new,$conf_old);

        //Получаем массив старых значений в формате xml
        $conf_old_xml11=array_slice($conf_old,16);

        $lenth=count(file("/var/www/html/tel_configs/cfg.xml"));
        $conf_old_xml=array_slice($conf_old_xml11,0,$lenth);

        
        //3 Получаем для каждого файла кфг отличия от эталона.
        $cfg_files_dir='/var/www/html/tel_configs/cfg*.xml';
        $cfg_files=glob($cfg_files_dir);
        $num_temp_file='1';
        foreach($cfg_files as $cfile){
            $linesall=file($cfile);
            $dirs_not_to_update=array_diff($linesall,$conf_old_xml);//Директивы, которые не будем менять
            //4 Получаем масив директив для конкретного аппарата, коорые будут заменены. Исключаем директивы, измененные для аппарата,
            //а также директивы аккаунтов. (они исключены на этапе сверки старого и нового файла дефолтной конфигурации)$dirs_not_to_update
      
            
            //Получаем значения директив в обоих массивах и исключаем из dirs то, что ненужно обновлять.
            $dirs_str=implode($dirs);
            $dirs_not_to_update_str=implode($dirs_not_to_update);
            
            $changes=array();
            $discard=array();

            foreach($dirs_not_to_update as $dntu){
            preg_match("/<\/P(.+)>\n/",$dntu,$Pnot);
            array_push($discard,$Pnot['1']);
            }
            $P_not=array_slice($discard,1);

            //$dirs - полный состав директории <P..>....</P>
            //$P_not - номер директивы 35,35
            
//5 для каждой директивы проверяем на совпадение в массиве измененных
            foreach($dirs as $P){
                //print_r($P);
$lenth_discard=count($P_not);
$count_not_discard=array();

//берем массив дискарда и для каждого сверяем с каждой директивай изменений
                foreach($P_not as $exclude){
                    
                    $find="/<P$exclude>(.+)<\/P$exclude>/";
                    preg_match($find,$P,$result);
                    if(empty($result['1'])){
                        array_push($count_not_discard,$P);
                    }else{
                        continue;
                    }
                }
                //если есть совпадения, то не засовываем директиву в изменения
                if(count($count_not_discard)==$lenth_discard){
                    //echo count($count_not_discard).'/'.$lenth_discard;
                    array_push($changes,$P);
                }else{
                    //echo count($count_not_discard).'/'.$lenth_discard;
                    continue;
                }
            }
            
            //Выводим сообщение, если ничего не меняется для конфигурации.
            if(empty($changes)){
                echo 'Данные параметры конфигурации для '.$cfile.' были изменены вручную, изменения внесены не были.<br/>';
                continue;
            }
            
//6 Собираем конфигурации:

           
            $lenth_changes=count($changes);
            $new_file='/var/www/html/tel_configs/'.$num_temp_file.'cfg';
            $remake=fopen($new_file,"a");
            foreach($linesall as $line_new){//для каждой строки
                 $new_lines_config=array();
                foreach($changes as $change){//проверяем нед ли значения в обновлении конфига
                    $search1="/<\/P(.+)>/";
                    preg_match($search1,$change,$d_number);
                    $number=$d_number['1'];
                    $search2="/<P$number>(.+)/";
                    preg_match($search2,$line_new,$exist);
                    if(isset($exist['1'])){
                        continue;
                        
                    }else{
                        
                        array_push($new_lines_config,"PASS");
                    }
                }
                if(count($new_lines_config)==$lenth_changes){
                    fwrite($remake,$line_new);
                }else{
                    fwrite($remake,$change);
                }
            }
            fclose($remake);
            unlink($cfile);
            rename($new_file,$cfile);
            echo $cfile.'Пересобран<br/>';
            $num_temp_file=$num_temp_file+1;
            
            
            //8 делаем зашифрованные конфиги, на случай если телефон не воспринимает инных. Пароль всегда P@ssw0rd
            //Получаем mac из названия файла
            $mac_search="/\/cfg(.+).xml/";
            preg_match($mac_search,$cfile,$mac_array);
            $mac_device=$mac_array['1'];
            unlink("/var/www/html/tel_configs/confirmed_cfg'.$mac_device.'.xml");
            system("openssl enc -e -aes-256-cbc -k P@ssw0rd -in '$cfile' -out /var/www/html/tel_configs/confirmed_cfg'$mac_device'.xml");
        }
        
        
        

        //7 Переносим новый файл конфигурирования
        file_put_contents("/var/www/html/tel_configs/auto_configurating_phones.sh",'');
        $new_sh=file("/var/www/html/tel_configs/auto_configurating_phones1.sh");
        $sh=fopen('/var/www/html/tel_configs/auto_configurating_phones.sh',"a");
        foreach($new_sh as $new_default){
            fwrite($sh,trim($new_default)."\n");
        }
        fclose($sh);
        unlink("/var/www/html/tel_configs/auto_configurating_phones1.sh");

    }else{
        $mac=$_GET['mac'];
        //echo '1'.$mac;
        //для одного телефона
        $cofg='/var/www/html/tel_configs/cfg'.$mac.'.xml';
        file_put_contents($cofg, '');
        $cfg=fopen($cofg,"a");
        fwrite($cfg, "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
        fwrite($cfg, "<gs_provision version=\"1\">\n");
        fwrite($cfg, "<mac>$mac</mac>\n");
        fwrite($cfg, "<config version=\"1\">\n");
        foreach($_POST as $new_dir){
            fwrite($cfg, $new_dir."\n");
        }
        fwrite($cfg, "</config>\n");
        fwrite($cfg, "</gs_provision>\n");
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