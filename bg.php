<?php
session_start();

//$data = file_get_contents('php://input');
//$r = json_decode($data);
$_SESSION['data'] = "hello";
//$body = "hello";
//$path = "/app/php/bin/php";
$output = shell_exec('php my.php');

echo json_encode($output);

?>