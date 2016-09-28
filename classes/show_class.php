<?php
include_once('connect.php');
class Show{
	//var $camid;
	function ShowCams(){
		$sql=("select * from `Monitors` order by `Id` desc");
		$camso=new Connection($sql);
		$camso->sql=$sql;
		$cams=$camso->Connect();
		foreach($cams as $c){echo '<tr><td><a href="?page=monitor&monid='.$c['Id'].'">'.$c['Id'].'</a></td></tr>';}
		$count=count($cams);
		return $count;
	}
	function ShowEvents($camid){
		$this->camid=$camid;
		//echo $camid;
		$sql=("select * from `Events` where `MonitorId` in (select id from `Monitors` where `Id`='$camid') order by `StartTime`");
		$eventso=new Connection($sql);
		$eventso->sql=$sql;
		$events=$eventso->Connect();
		foreach($events as $e){ 
		echo '<tr><td>'.$e['StartTime'].'</td><td><a href="./events/remote/video/'.$e['Id'].'.avi" type="application/file"">'.$e['Id'].'<img src="./events/remote/video/'.$e['Id'].'_screenshot.jpg" width="80"/>  </a>';
		$file='/var/www/html/export/events/remote/video/'.$e['Id'].'.avi';
		$size=filesize($file);
		if($size==0){echo '<font color=red>Файл не был записан или записан некорректно.</font>';}
		echo '</td></tr>';
		}
	}
}
?>
