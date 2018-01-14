<?php

session_start();
var_dump($_SESSION);
$request= $_SESSION["album"];
echo $_SESSION["album"];
echo "This is my.php";
echo $request;


?>