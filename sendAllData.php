<?php

$data = file_get_contents('php://input');
$request = json_decode($data);
session_start();

$userName = $request[0];
$len = sizeof($request);
$albumnList = array();

for($i=1;$i<$len;$i++){
    array_push($albumnList,$request[$i]);
}


$_SESSION['driveAlbumnList']=$request;
$_SESSION['DriveUserName']=$userName;

echo json_encode("Successfully Done!!");
?>
