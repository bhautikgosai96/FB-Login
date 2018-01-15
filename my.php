<?php

session_start();
$request= $_SESSION["album"];

$r = escapeshellarg($myArray);
echo $r;
echo "This is my.php";
echo $r;


?>