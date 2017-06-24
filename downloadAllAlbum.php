<?php

$errors = array();
$data = array();

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);

$zip = new ZipArchive();

$filename = 'finalAll.zip';
if($zip->open($filename, ZipArchive::CREATE)!=TRUE)
    die ("Could not open archive");


$temp=[];

foreach($request as $file){

    $img=$k->image;
    $aName=$k->albumnName;

    $fname = mkdir($aName);
    $count = 0;

    $fp = fopen($fname,"wb");


    foreach($img as $i){
        $download_file = file_get_contents($file);
        $count = $count + 1;
        $name = "img-".$count.".jpg";
        file_put_contents($name,$download_file);
        $content = $name;
        fwrite($fp,$content);
    }
    fclose($fp);
	array_push($temp,$fname);
	$zip->addFile($fname);
}

$zip->close();
//echo 'Exist or not'.file_exists($filename);
// close zip

foreach($temp as $n){

	unlink($n);
	//removing file from server
}

echo json_encode("finalAll.zip");



?>
