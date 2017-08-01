<?php

$data = file_get_contents('php://input');
$request = json_decode($data);
session_start();

$userName = $request->userName;
$albumnList = $request->albumnList;

$_SESSION['driveAlbumnList']=$albumnList;
$_SESSION['DriveUserName']=$userName;

echo json_encode("Successfully Done!!");
?>
