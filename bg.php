<?php
session_start();

$data = file_get_contents('php://input');
$r = json_decode(file_get_contents('php://input'));  // array which i need in downloadAllAlbum.php

$output = shell_exec("php downloadAllAlbum.php $r");

echo json_encode($output);

//$path = "/app/php/bin/php";
?>