<?php

session_start();
//$request= $_SESSION["album"];

$r = $argv[1];
echo $r;
print_r($r,true);
foreach($r as $i){
     $img=$k->image;
        $aName=$k->albumnName;
        foreach($img as $i){
            echo $i;
        }
}
echo "This is my.php";
echo $r;


?>