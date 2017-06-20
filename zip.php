<?php

$image = json_decode(file_get_contents("php://input"));

$zip = new ZipArchive();

$filename = time().".zip";
$zip->open($filename, ZipArchive::CREATE);


foreach($image as $file){
    $zip->addfile($file);
}

$zip->close();

if(file_exists($filename)){
    header('Content-type: application/zip');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    readfile($filename);
    unlink($filename);
}
echo json_encode($filename);


?>