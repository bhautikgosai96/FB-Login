<?php

session_start();

$request= $_POST['album'];

echo "This is my.php";
echo $request;
echo $_POST['album']."last";
?>