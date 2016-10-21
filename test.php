<?php
if(isset($_GET['act'])){
    system("start-stop-daemon  -Sbmp /var/www/html/tpid -u www-data -x /usr/bin/ffmpeg -- -i rtsp://video:123456@10.20.30.150:7070 -acodec copy -vcodec copy -y /var/www/html/test.avi");
    echo '<form action=""><input type="text" value="1" name="act"/><input type="submit"/></form>';
    echo 'begin!';
}else{
    echo '<form action=""><input type="text" value="1" name="act"/><input type="submit"/></form>';
}