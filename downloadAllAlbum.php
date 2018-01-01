<?php

ignore_user_abort(true);

// don't let the script time out
set_time_limit(0);

// start output buffering
ob_start();

// If you need to return data to the browser, run that code
// here. For example, you can process the credit card and
// then tell the user that their account has been approved.

$data = file_get_contents('php://input');
$request = json_decode($data);
//$request = $_SESSION['data'];
//print_r($request);
$zip = new ZipArchive();

$filename = 'zip-'.time().'.zip';
if($zip->open($filename, ZipArchive::CREATE)!=TRUE)
    die ("Could not open archive");


$temp=[];

foreach($request as $k){

    $img=$k->image;
    $aName=$k->albumnName;


    $count = 0;

    foreach($img as $i){
       $download_file = file_get_contents($i);
        $count = $count + 1;
        $name = $aName."-".$count.".jpg";
        array_push($temp,$name);
        file_put_contents($name,$download_file);

        $zip->addFile($name,$aName.'/'.$name);

    }

    $zip->addFile($aName);

}

$zip->close();


usleep(1500000); // do some stuff...



// now force PHP to output to the browser...
$size = ob_get_length();
header("Content-Length: $size");
header('Connection: close');
ob_end_flush();
ob_flush();
flush(); // yes, you need to call all 3 flushes!
if (session_id()) session_write_close();

// everything after this will be executed in the background.
// the user can leave the page, hit the stop button, whatever.

usleep(120000000); // do some stuff

echo json_encode($filename);




?>