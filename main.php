<?php session_start();?>
<?php if(!isset($_SESSION['user_id'])){header('Location:index.php');}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<head>
<title>Выгрузка видео</title>
 <link rel="stylesheet" type="text/css" href="style.css"> 
<link rel="shortcut icon" href="./img/cam.ico" type="image/x-icon">
</head>
<body> <div class="container" "id="contentLog"> 
<div class="content" id="content"> 
<table id="top" class="top"> 
<tr><td><?php echo 'Добрый день, '.$_SESSION['user_id'];?>
<a href="index.php?logout=true">
<img src="img/logout.png" width="30"/></a> </td><td></td><td></td></tr><tr><td></td><td><p align="right"><?php echo (date("d F Y ")); ?></p></td><td></td></tr> 
<tr><td></td><td><p><B>ZM-exporting script interface v2.2</B></p></td><td></td></tr> </table> </div> <div class="navigate" id="navigate"><p><a href="?">Main</a> <a href="?page=log">Log</a></p></div> <div class="content" 
id="content"> <?php if(empty($_GET['page'])){
	include_once('html/show_cams.html');
}elseif(!empty($_GET['page'])){
	$page=$_GET['page'];
	if($page=='monitor'){
	include_once('html/show_events.html');}else{include_once('html/'.$page.'.html');}
}
?> </div> <p>&#169; AO</p> </div> </body> </html>
