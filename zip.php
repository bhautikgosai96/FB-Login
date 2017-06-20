<?php

$errors = array();
$data = array();

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
$img = $request;



$zip = new ZipArchive();

$filename = time().'.zip';
if($zip->open($filename, ZipArchive::CREATE)!==TRUE)
    die ("Could not open archive");


foreach($img as $file){
    $zip->addfile($file)
}

$zip->close();

if(file_exists($filename)){
    header('Content-type: application/zip');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    readfile($filename);
    unlink($filename);
}

/*
$temp=[];
foreach($img as $file){


	$download_file = file_get_contents($file);

	$name =basename($file);
	array_push($temp,$name);
	file_put_contents($name,$download_file);

	$zip->addFile($name);



}


$zip->close();
//echo 'Exist or not'.file_exists($filename);
// close zip

foreach($temp as $n){

	unlink($n);
	//removing file from server
}
$filename=array($filename);*/
echo json_encode($filename);



?>