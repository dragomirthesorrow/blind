<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if(!isset($_SESSION['user_id'])){
    echo 'Для неавторизованных пользователей доступ закрыт.';
}
$lines = file('/var/www/html/configs/interval.config');
//print_r($lines);
$pattern="/\'(.+)\'/";
preg_match($pattern, $lines['2'],$matches_mrt);
$mrt=$matches_mrt['1'];
//$pattern_=1;
preg_match($pattern, $lines['3'],$matches_prer);
$prer=$matches_prer['1'];
preg_match($pattern, $lines['4'],$matches_pstr);
$pstr=$matches_pstr['1'];
/*foreach ($lines as $line) {
$line = trim($line);
echo $line.'<br/>';
}*/
$lines2 = file('/var/www/html/configs/path.config');
//print_r($lines2);
preg_match($pattern, $lines2['2'],$matches_path);
$path=$matches_path['1'];
/*foreach ($lines2 as $line2) {
$line2 = trim($line2);
echo $line2.'<br/>';
}*/
if($_GET['action']==2){ $act='<p><font color="orange">Изменения внесены не были</font></p>';}elseif($_GET['action']==1){$act='<p><font color="green">Изменения внесены</font></p>';}else{$act='';}
include_once 'html/mainsettings.html';