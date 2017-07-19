<?php


$data = file_get_contents('php://input');
$request = json_decode($data);
session_start();
$img=$request->img;
$albumName=$request->albumnName;



$_SESSION['picasaAlbum']=$albumName;
$_SESSION['picasaImg']= $img;


echo json_encode("Successfully Done!!");
?>
