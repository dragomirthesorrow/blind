<html>
    <head><meta http-equiv="Content-type" content="text/html"; charset="utf-8">
    </head>
    
    <?php

$lines = file('/var/www/html/log.txt');
//print_r($lines);
foreach ($lines as $line) {
$line = trim($line);
echo $line.'<br/>';
}
?>
</html>