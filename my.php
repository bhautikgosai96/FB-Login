<?php

session_start();
$request= $_SESSION["album"];

$r = escapeshellarg($myArray);
echo $r;
print_r($r);
echo "This is my.php";
echo $r;


?>