<?php

session_start();
$request= $_SESSION["album"];
$r = stripslashes($argv[1]);
echo "This is my.php";
echo $r;


?>