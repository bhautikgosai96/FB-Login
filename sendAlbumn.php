<?php


$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
session_start();
$img=$request->img;
$albumName=$request->albumnName;



$_SESSION['picasaAlbum']=$albumName;
$_SESSION['picasaImg']= $img;

echo $_SESSION['picasaAlbum'];
echo $_SESSION['picasaImg'];
$op='Data written';
echo json_encode($op);
?>
