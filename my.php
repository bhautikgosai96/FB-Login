<?php

session_start();
var_dump($_SESSION);
$request= $_SESSION["album"];
print_r($_SESSION["album"]);
echo "This is my.php";
echo $request;
print_r($request);

?>