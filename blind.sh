#!/bin/bash

default_action="s"
action=${1:-$default_action}

if [ $action == "s" ]; then

#запускаем скрипт start.sh
start-stop-daemon -Sbmp /var/www/html/mainpid -x /var/www/html/modules/start.sh
echo 'Для завершения записи необходим параметр: e';

elif [ $action == "e" ]; then
#запускаем скрипт end.sh
pid=`cat /var/www/html/mainpid`
if [ $pid == 0 ]; then
echo 'Приложение не запущено'
exit;
fi
php /var/www/html/modules/end.php
date=`date +%Y-%m-%d:%H:%M:%S`
start-stop-daemon -Kp /var/www/html/mainpid
rm /var/www/html/mainpid
echo '<p><font color=red>'${date}' Приложение завершено. Процесс: '${pid}'</font></p>'>>/var/www/html/log.txt
echo 'Приложение завершает работу.';
fi
