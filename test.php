<?php
include_once '/var/www/html/classes/version.php';
$vers=new Version();
$version = $vers->ShowVersion();
echo $version.'!!!';