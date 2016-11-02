<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once ('/var/www/html/configs/ldap.config');
$ldap = ldap_connect($ldaphost,$ldapport) or die("Cant connect to LDAP Server");
//Включаем LDAP протокол версии 3
ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_bind($ldap, "oadm", "Dcbsm17J") or die('Не могу подсоединиться к LDAP-серверу');
$that=array("sAMAccountName","telephoneNumber","otherTelephone");
$result = ldap_search($ldap,$base,$phone_filter,$that);
$info = ldap_get_entries($ldap, $result);
foreach ($info as $inf){
    //print_r($inf);
    //echo '<br/>';
    //Сверяем наличие конфигурации:
    //1 Получаем все из АД
    $mac_phone=$inf['othertelephone'];
    $num_phone=$inf['telephonenumber'];
    $name_phone=$inf['samaccountname'];
    $mac=strtolower($mac_phone['0']);//mac address of device from AD
    $num=$num_phone['0'];//number
    $name=$name_phone['0'];//name of extention
    //2 Проверяем наличие файла с маком в названии
    $fl='/var/www/html/tel_configs/cfg'.$mac.'.xml';
//echo $fl;
    if(!file_exists($fl)){
        //Если файла с конфигурацией еще нет, то запускаем конфигуратор-скрипт баш
        system("/var/www/html/tel_configs/auto_configurating_phones.sh '$mac' '$num' '$name'");
        //А также запускаем конфигуратор экстеншена для астериск
        //system("./autoconf_ext.sh '.$mac.' '.$num.' '.$name.'");
    }
    //echo $mac.'/'.$num.'/'.$name;
}
//print_r($info);
ldap_close($ldap);



/*$ldap_host = "10.0.0.16";
   $ldap_port = "389";
   $base_dn = "OU=User,DC=corp,DC=digital-grass,DC=ru";
   $filter = iconv ('CP1251','UTF-8',"telephoneNumber=*");
   $ldap_user ="oadm";
   $ldap_pass = "Dcbsm17J";
 
   $connect = ldap_connect( $ldap_host, $ldap_port);
   ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
   //print $connect;
    ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
   $bind = ldap_bind($connect, $ldap_user, $ldap_pass);
   //echo "<br>bind:".$bind;
   $that=array("sAMAccountName","telephoneNumber","otherTelephone");
   $read = ldap_search($connect, $base_dn, $filter, $that);
   printf ($read);
   $info = ldap_get_entries($connect, $read);
   //echo $info["count"]." entrees retournees<BR><BR>";
   for($ligne = 0; $ligne<$info["count"]; $ligne++)
   {
       for($colonne = 0; $colonne<$info[$ligne]["count"]; $colonne++)
       {
           $data = @iconv('UTF-8', 'CP1251',$info[$ligne][$colonne]);
           echo @iconv('UTF-8', 'CP1251',$data).":".@iconv('UTF-8', 'CP1251',$info[$ligne][$data][0])."<BR>";
       }
       echo "<BR>";
   }
ldap_close($connect); */



/*foreach($result as $res){
    print_r($res);
}*/



/*<?php
// $ds верный идентификатор ссылки на сервер директории

// $person всё или часть имени человека, н-р "Jo"

$dn = "o=My Company, c=US";
$filter="(|(sn=$person*)(givenname=$person*))";
$justthese = array("ou", "sn", "givenname", "mail");

$sr=ldap_search($ds, $dn, $filter, $justthese);

$info = ldap_get_entries($ds, $sr);

echo $info["count"]." записей возвращено\n";
?>
*/
