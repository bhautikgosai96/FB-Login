<?php
session_start();

//$data = file_get_contents('php://input');
//$r = json_decode(file_get_contents('php://input'));

$myArray = [1,2,3,4];

//$path = "/app/php/bin/php";
$output = shell_exec('php my.php'.escapeshellarg(serialize($myArray)));

echo json_encode($output);

?>