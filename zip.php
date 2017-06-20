<?php
function createZip($files, $zip_file) {
   $zip = new ZipArchive;

  if($zip->open($zip_file, ZipArchive::CREATE) === TRUE)
  {
    foreach($files as $file)
    {
      $zip->addFile($file);
    }
    $zip->close();
    return true;
  }
  else return false;
}
$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
$files = $request;

$zip_file = 'final.zip';
if(createZip($files, $zip_file))
    echo json_encode('The '. $zip_file. ' successfully created');
else
    echo json_encode('Unable to create the '. $zip_file. ' file');

header('Content-type: application/zip');
header('Content-disposition: filename="'. $zip_file. '"');
header('Content-length:'. filesize($zip_file));
readfile($zip_file);
exit();

?>