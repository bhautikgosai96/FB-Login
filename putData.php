<?php

$data = file_get_contents('php://input');
$request = json_decode($data);
session_start();


$_SESSION['data']=$request;

echo json_encode("Successfully Done!!");
?>