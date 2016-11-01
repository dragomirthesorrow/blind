<?php
require_once '../classes/version.php';
$vers=new Version();
$version=$vers->ShowVersion();
include_once 'html/login.html';