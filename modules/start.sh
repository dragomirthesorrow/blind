#!/bin/bash
#запускаем эхо-запись
#запускаем извлечение картинок
#запускаем детектирование события
dt=`date +%Y-%m-%d:%H:%M:%S`
pd=`cat /var/www/html/mainpid`
echo '<p><font color=blue>'${dt} 'Приложение запущено. Процесс: ' ${pd}'</font></p>'>>/var/www/html/log.txt;
start-stop-daemon -Sbmp /var/www/html/modules/modect/pidic -x /usr/bin/php -- /var/www/html/modules/modect/ImageCollecter.php
I=0
while [ 1 ]; do
I=$(( I + 1));
sleep 1;
php /var/www/html/modules/record/index.php
#start-stop-daemon -Sbmp /var/www/html/modules/modect/pidic -x /usr/bin/php -- /var/www/html/modules/modect/ImageCollecter.php
php /var/www/html/modules/modect/modect.php
#remover jpg ов
done
