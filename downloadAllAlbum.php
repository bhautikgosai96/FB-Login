<?php



$data = file_get_contents('php://input');
$r = json_decode($data);
$filename = $r->filename;
$request = $r->album;
//$request = $_SESSION['data'];
//print_r($request);
$zip = new ZipArchive();

if($filename == 'new'){
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

}else{

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

}

echo json_encode($filename);



?>
