
<?php

$lines = file('/var/www/html/log.txt');
//print_r($lines);
foreach ($lines as $line) {
$line = trim($line);
echo $line.'<br/>';
}
