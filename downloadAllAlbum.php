<?php

$errors = array();
$data = array();

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);

$zip = new ZipArchive();

$filename = "f.zip";
if($zip->open($filename, ZipArchive::CREATE)!=TRUE)
    die ("Could not open archive");


$temp=[];

foreach($request as $k){

    $img=$k->image;
    $aName=$k->albumnName;

    mkdir($aName);
    $count = 0;

    foreach($img as $i){
       $download_file = file_get_contents($i);
        $count = $count + 1;
        $name = "img-".$count.".jpg";
        array_push($temp,$name);
        file_put_contents($name,$download_file);


    }

    $zip->addFile($aName);

}

$zip->close();
//echo 'Exist or not'.file_exists($filename);
// close zip

foreach($temp as $n){

	unlink($n);
	//removing file from server
}

echo json_encode($img);



?>
