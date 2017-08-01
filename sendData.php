<?php

$data = file_get_contents('php://input');
$request = json_decode($data);
session_start();
$img=$request->img;
$albumName=$request->albumnName;
$userName=$request->userName;


$_SESSION['driveAlbumn']=$albumName;
$_SESSION['driveImg']= $img;
$_SESSION['DriveUserName']=$userName;

echo json_encode("Successfully Done!!");
?>
