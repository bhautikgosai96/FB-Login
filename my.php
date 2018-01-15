<?php

session_start();
$request= $_SESSION["album"];

$r = unserialize($argv[1]);
echo $r;
echo "This is my.php";
echo $r;


?>