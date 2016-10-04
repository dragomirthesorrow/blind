<?php
include_once('connect.php');
class Show{
	//var $camid;
	function ShowCams(){
		$sql=("select * from `monitors` order by `id` desc");
		$camso=new Connection($sql);
		$camso->sql=$sql;
		$cams=$camso->Connect();
		foreach($cams as $c){echo '<tr><td><a href="?monid='.$c['id'].'">'.$c['name'].'</a></td></tr>';}
		$count=count($cams);
		return $count;
	}
	function ShowEvents($camid){
		$this->camid=$camid;
		//echo $camid;
		$sql=("select * from `events` where `monitor_id` in (select id from `monitors` where `id`='$camid') order by `start_time`");
		$eventso=new Connection($sql);
		$eventso->sql=$sql;
		$events=$eventso->Connect();
		foreach($events as $e){ 
		echo '<tr><td>'.$e['start_time'].'</td><td><a href="'.$video_storage.$e['id'].'.avi" type="application/file"">'.$e['id'].'<img src="'.$video_storage.$e['Id'].'_screenshot.jpg" width="80"/>  </a>';
		$file=$video_storage.$e['id'].'.avi';
		$size=filesize($file);
		if($size==0){echo '<font color=red>Файл не был записан или записан некорректно.</font>';}
		echo '</td></tr>';
		}
	}
}
?>
