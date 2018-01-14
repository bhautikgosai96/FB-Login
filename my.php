<?php

session_start();

$request= $_SESSION['album'];

echo "This is my.php";
echo $request;

?>