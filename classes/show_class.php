<?php
include_once('connect.php');
//include_once $_SERVER['DOCUMENT_ROOT'].'/configs/path.config';
class Show{
	//var $camid;
	function ShowCams(){
		$sql=("select * from `monitors` order by `id` desc");
		$camso=new Connection($sql);
		$camso->sql=$sql;
		$cams=$camso->Connect();
		foreach($cams as $c){
                    preg_match("/@(.+):/",$c['path'],$ip_cam);
                    $ip_c=$ip_cam['1'];
                    //echo $ip_c;
                    //Распознаем устройство: ищем в пути название axis, если присутствует, то меняем способ вывода снэпа.
                    preg_match("/(.+)axis(.+)/",$c['path'],$model);
                    if(empty($model)){
                        $image='<img id="foximg" src="http://video:123456@'.$ip_c.'/cgi-bin/cmd/encoder?SNAPSHOT" alt="Press Reload if no image is displayed"  width="320" height="240" border="0">';
                    }else{
                        $image='<img id="stream" src="http://video:123456@'.$ip_c.'/mjpg/video.mjpg" alt="Press Reload if no image is displayed" style="cursor: crosshair;" width="320" height="240" border="0">';
                    }
                    
                    echo '<tr><td><a href="?monid='.$c['id'].'">'.$image.$c['name'].'</a></td></tr>';}
		$count=count($cams);
		return $count;
	}
	function ShowEvents($camid){
                $pattern="/\'(.+)\'/";
                $lines2 = file('/var/www/html/configs/path.config');
                preg_match($pattern, $lines2['2'],$matches_path);
                $path=$matches_path['1'];
                $video_storage=$path;
                $pt="/\/var\/www\/html\//";
                $vs=preg_replace($pt, "",$path);
                //echo $vs;
		$this->camid=$camid;
		//echo $camid;
		$sql=("select * from `events` where `monitor_id` in (select id from `monitors` where `id`='$camid') order by `start_time`");
		$eventso=new Connection($sql);
		$eventso->sql=$sql;
		$events=$eventso->Connect();
		foreach($events as $e){ 
		echo '<tr><td>'.$e['start_time'].'</td><td><a href="'.$vs.$e['id'].'.avi" type="application/file"">'.$e['id'].'  </a>';
		$file=$video_storage.$e['id'].'.avi';
		$size=filesize($file);
		if($size==0){echo '<font color=red>Файл не был записан или записан некорректно.</font>';}
		echo '</td></tr>';
		}
	}
}
//<img src="'.$video_storage.$e['id'].'_screenshot.jpg" width="80"/>
?>
