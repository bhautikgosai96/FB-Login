<?php

$data = file_get_contents('php://input');
$request = json_decode($data);
$img = $request;



$zip = new ZipArchive();

$filename = 'zip-'.time().'.zip';
if($zip->open($filename, ZipArchive::CREATE)!=TRUE)
    die ("Could not open archive");


$temp=[];
$count = 0;
foreach($img as $file){

    $count = $count + 1;
	$download_file = file_get_contents($file);

	$name = "img-".$count.".jpg";
	array_push($temp,$name);
	file_put_contents($name,$download_file);

	$zip->addFile($name);

}

$zip->close();

foreach($temp as $n){

	unlink($n);
	//removing file from server
}

echo json_encode($filename);

?>
