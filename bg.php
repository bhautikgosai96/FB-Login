<?php
session_start();

//$data = file_get_contents('php://input');
//$r = json_decode($data);
$_SESSION["album"] = "hello";
$body = "hello";
//$path = "/app/php/bin/php";
$output = shell_exec('php my.php "' . addslashes($body) . '"');

echo json_encode($output);

?>