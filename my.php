<?php

session_start();
$request= $_SESSION["album"];
print_r($_SESSION);
echo "This is my.php";
echo $request;
print_r($request);

?>