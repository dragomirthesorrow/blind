<?php session_start();?>
<?php if(!isset($_SESSION['user_id'])){header('Location:index.php');}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<head>
<title>Blind 0.1.</title>
 <link rel="stylesheet" type="text/css" href="css/style.css"> 
<link rel="shortcut icon" href="./images/eye.ico" type="image/x-icon">
</head>
<body> 
    <div class="container">
        
        <div class="head">
            <table><tr><td><?php echo date("Y-m-d H:i:s"); ?></td><td></td><td></td><td></td><td></td><td>Добрый день, <?php echo $_SESSION['user_id'];?>!</td><td> <form name="logout" action="../functions/auth_user.php"><input type="image" src="images/exit.png" height="40"/><input type="hidden" name="logout" value="exit"/></form></td></tr></table>
        </div>
        <div class="menu"><p>
            <div class="left_menu"><img style="padding:0px; margin:0px; margin-top: 1px" src="./images/left_item.png" height="40"/></div><?php 
            require_once './classes/connect.php';
            $sql_get_items="select * from `user_pages`";
            $get_items=new Connection($sql_get_items);
            $items=$get_items->Connect();
            foreach ($items as $item){
            echo '<div class="menu_but"><div class="but_txt">'.$item['name'].'</div> <a href="./'.$item['code'].'"
       OnMouseOver="document.getElementById(\'B_B\').src=\'./images/item_light.png\'"
       OnMouseOut="document.getElementById(\'B_B\').src=\'./images/item.png\'"><img id="B_B" style=\"padding:0px; margin:0px;\" src="./images/item.png" height="40"/></a></div>';} ?><div class="right_menu"><img style="padding:0px; margin:0px;" src="./images/right_item.png" height="40"/></div>
            </p></div>
        <div class="left">
            
                <?php
                require_once 'classes/checktool.php';
                $chck=new CheckTools();
                $chck->CheckDevices();
                
                ?>
        </div>
        <div class="center">
            <?php
            if(!isset($_GET['monid'])){
                include_once 'html/show_cams.html';
            }else{
                include_once 'html/show_events.html';
            }
            ?>
        </div>
        
    </div>
    <div class="transp"></div>
    <div class="footer">blind version 0.1.0</div>
</body> </html>
